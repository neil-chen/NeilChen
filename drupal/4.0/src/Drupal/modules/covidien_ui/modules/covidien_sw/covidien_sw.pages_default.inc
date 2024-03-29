<?php

/**
 * @file
 * Used for ctools page manager.
 */

/**
 * Implementation of hook_default_page_manager_pages().
 */
function covidien_sw_default_page_manager_pages() {
  $pages = array();
  $path = drupal_get_path('module', 'covidien_sw') . '/pages';
  $files = drupal_system_listing('.inc$', $path, 'name', 0);
  foreach ($files as $file) {
    include_once $file->filename;
    $pages[$page->name] = $page;
  }
  return $pages;
}
