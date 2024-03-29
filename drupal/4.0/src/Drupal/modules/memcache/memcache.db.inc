<?php

/** THIS FILE IS DEPRECATED - DO NOT USE **/
// http://drupal.org/node/959200
// http://drupal.org/node/961496

require_once 'dmemcache.inc';

/** 
 * @file
 * Implementation of cache.inc with memcache logic included.
 **/

/**
 * Return data from the persistent cache. Data may be stored as either plain text or as serialized data.
 * cache_get will automatically return unserialized objects and arrays.
 *
 * @param $cid
 *   The cache ID of the data to retrieve.
 * @param $table
 *   The table $table to store the data in. Valid core values are 'cache_filter',
 *   'cache_menu', 'cache_page', or 'cache' for the default cache.
 */
function cache_get($cid, $table = 'cache') {
  global $user;
  global $memcache_online;

  // Garbage collection necessary when enforcing a minimum cache lifetime
  $cache_flush = variable_get('cache_flush_'. $table, 0);
  if ($cache_flush && ($cache_flush + variable_get('cache_lifetime', 0) <= $_SERVER['REQUEST_TIME'])) {
    // Reset the variable immediately to prevent a meltdown in heavy load situations.
    variable_set('cache_flush_'. $table, 0);
    // Time to flush old cache data
    db_query("DELETE FROM {". $table ."} WHERE expire != %d AND expire <= %d", CACHE_PERMANENT, $cache_flush);
  }

  // If we have a memcache hit for this, return it.
  if ($memcache_online !== FALSE && $cache = dmemcache_get($cid, $table)) {
    return $cache;
  }

  // Look for a database cache hit.
  if ($cache = db_fetch_object(db_query("SELECT data, created, headers, expire, serialized FROM {". $table ."} WHERE cid = '%s'", $cid))) {
    if (isset($cache->data)) {
      // If the data is permanent or we're not enforcing a minimum cache lifetime
      // always return the cached data.
      if ($cache->expire == CACHE_PERMANENT || !variable_get('cache_lifetime', 0)) {
        $cache->data = db_decode_blob($cache->data);
        if ($cache->serialized) {
          $cache->data = unserialize($cache->data);
        }
      }
      // If enforcing a minimum cache lifetime, validate that the data is
      // currently valid for this user before we return it by making sure the
      // cache entry was created before the timestamp in the current session's
      // cache timer. The cache variable is loaded into the $user object by
      // sess_read() in session.inc.
      else {
        if ($user->cache > $cache->created) {
          // This cache data is too old and thus not valid for us, ignore it.
          return 0;
        }
        else {
          $cache->data = db_decode_blob($cache->data);
          if ($cache->serialized) {
            $cache->data = unserialize($cache->data);
          }
        }
      }
    }

    // By calling cache_set with an extra paramater to signify no db storage,
    // we can lazy instantiate memcache that just comes online.
    if ($memcache_online) {
      cache_set($cid, $cache->data, $table, $cache->expire, $cache->headers, FALSE);
    }
    return $cache;
  }
  return 0;
}

/**
 * Store data in the persistent cache.
 *
 * The persistent cache is split up into four database
 * tables. Contributed modules can add additional tables.
 *
 * 'cache_page': This table stores generated pages for anonymous
 * users. This is the only table affected by the page cache setting on
 * the administrator panel.
 *
 * 'cache_menu': Stores the cachable part of the users' menus.
 *
 * 'cache_filter': Stores filtered pieces of content. This table is
 * periodically cleared of stale entries by cron.
 *
 * 'cache': Generic cache storage table.
 *
 * The reasons for having several tables are as follows:
 *
 * - smaller tables allow for faster selects and inserts
 * - we try to put fast changing cache items and rather static
 *   ones into different tables. The effect is that only the fast
 *   changing tables will need a lot of writes to disk. The more
 *   static tables will also be better cachable with MySQL's query cache
 *
 * @param $cid
 *   The cache ID of the data to store.
 * @param $data
 *   The data to store in the cache. Complex data types will be automatically 
 *   serialized before insertion. Strings will be stored as plain text and 
 *   not serialized.
 * @param $table
 *   The table $table to store the data in. Valid core values are 'cache_filter',
 *   'cache_menu', 'cache_page', or 'cache'.
 * @param $expire
 *   One of the following values:
 *   - CACHE_PERMANENT: Indicates that the item should never be removed unless
 *     explicitly told to using cache_clear_all() with a cache ID.
 *   - CACHE_TEMPORARY: Indicates that the item should be removed at the next
 *     general cache wipe.
 *   - A Unix timestamp: Indicates that the item should be kept at least until
 *     the given time, after which it behaves like CACHE_TEMPORARY.
 * @param $headers
 *   A string containing HTTP header information for cached pages.
 * @param $db_storage
 *   This boolean is unique to the memcache.inc implementation of cache set.
 *   It allows us to do a cache_set and not write to the database, but only
 *   to memcache.
 */
function cache_set($cid, $data, $table = 'cache', $expire = CACHE_PERMANENT, $headers = NULL, $db_storage = TRUE) {
  global $memcache_online;
  $created = $_SERVER['REQUEST_TIME'];

  // Create new cache object.
  $cache = new stdClass;
  $cache->cid = $cid;
  $cache->data = is_object($data) ? memcache_clone($data) : $data;
  $cache->created = $created;
  $cache->expire = $expire;
  $cache->headers = $headers;

  if ($db_storage) {
    $serialized = 0;
    if (is_object($data) || is_array($data)) {
      $data = serialize($data);
      $serialized = 1;
    }

    // Save to the database
    db_query("UPDATE {". $table ."} SET data = %b, created = %d, expire = %d, headers = '%s', serialized = %d WHERE cid = '%s'", $data, $created, $expire, $headers, $serialized, $cid);
    if (!db_affected_rows()) {
      @db_query("INSERT INTO {". $table ."} (cid, data, created, expire, headers, serialized) VALUES ('%s', %b, %d, %d, '%s', %d)", $cid, $data, $created, $expire, $headers, $serialized);
    }
  }

  // Save to memcache
  if ($expire == CACHE_TEMPORARY) {
    // 2591199 seconds = about 1 month
    $expire = $_SERVER['REQUEST_TIME'] + variable_get('cache_lifetime', 2591999);
  }
  if ($memcache_online !== FALSE) {
    dmemcache_set($cid, $cache, $expire, $table);
  }
}

/**
 *
 * Expire data from the cache. If called without arguments, expirable
 * entries will be cleared from the cache_page table.
 *
 * @param $cid
 *   If set, the cache ID to delete. Otherwise, all cache entries that can
 *   expire are deleted.
 *
 * @param $table
 *   If set, the table $table to delete from. Mandatory
 *   argument if $cid is set.
 *
 * @param $wildcard
 *   If $wildcard is TRUE, cache IDs starting with $cid are deleted in
 *   addition to the exact cache ID specified by $cid.  If $wildcard is
 *   TRUE and $cid is '*' then the entire table $table is emptied.
 */
function cache_clear_all($cid = NULL, $table = NULL, $wildcard = FALSE) {
  global $user;

  // Default behavior for when cache_clear_all() is called without parameters
  // is to clear all of the expirable entries in the block and page caches.
  if (!isset($cid) && !isset($table)) {
    // Clear the block cache first, so stale data will
    // not end up in the page cache.
    cache_clear_all(NULL, 'cache_block');
    cache_clear_all(NULL, 'cache_page');

    return;
  }

  if (empty($cid)) {
    if (variable_get('cache_lifetime', 0)) {
      // We store the time in the current user's $user->cache variable which
      // will be saved into the sessions table by sess_write(). We then
      // simulate that the cache was flushed for this user by not returning
      // cached data that was cached before the timestamp.
      $user->cache = $_SERVER['REQUEST_TIME'];

      $cache_flush = variable_get('cache_flush_'. $table, 0);
      if ($cache_flush == 0) {
        // This is the first request to clear the cache, start a timer.
        variable_set('cache_flush_'. $table, $_SERVER['REQUEST_TIME']);
      }
      else if ($_SERVER['REQUEST_TIME'] > ($cache_flush + variable_get('cache_lifetime', 0))) {
        // Clear the cache for everyone, cache_lifetime seconds have
        // passed since the first request to clear the cache.
        db_query("DELETE FROM {". $table ."} WHERE expire != %d AND expire < %d", CACHE_PERMANENT, $_SERVER['REQUEST_TIME']);
        variable_set('cache_flush_'. $table, 0);
        // Note there is no memcache flush here.
        // Items are cached in memcache with an expiry equal to cache_lifetime
        // and memcache will expire these automatically.
      }
    }
    else {
      // No minimum cache lifetime, flush all temporary cache entries now.
      // Note, however, that memcache does not have the ability to discern
      // between CACHE_PERMANENT and CACHE_TEMPORARY items. So having no
      // minimum cache lifetime means that all CACHE_PERMANENT items are
      // lost here, too. To avoid that, set a minimum cache lifetime.
      dmemcache_flush($table);
      db_query("DELETE FROM {". $table ."} WHERE expire != %d AND expire < %d", CACHE_PERMANENT, $_SERVER['REQUEST_TIME']);
    }
  }
  else {
    if ($wildcard) {
      if ($cid == '*') {
        dmemcache_flush($table);
        db_query("TRUNCATE TABLE {". $table ."}");
      }
      else {
        db_query("DELETE FROM {". $table ."} WHERE cid LIKE '%s%%'", $cid);
      }
    }
    else {
      dmemcache_delete($cid, $table);
      db_query("DELETE FROM {". $table ."} WHERE cid = '%s'", $cid);
    }
  }
}

/**
 * Provide a substitute clone() function for PHP4. This is a copy of drupal_clone
 * because common.inc isn't included early enough in the bootstrap process to
 * be able to depend on drupal_clone.
 */
function memcache_clone($object) {
  return version_compare(phpversion(), '5.0') < 0 ? $object : clone($object);
}
