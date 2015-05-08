<?php

/**
 * @file
 * For hardware catalog view page used by ctools.
 */

/**
 * Implementation of hook_default_page_manager_pages().
 */
function covidien_hw_default_page_manager_pages() {
  $pages = array();
  $path = drupal_get_path('module', 'covidien_hw') . '/pages';
  $files = drupal_system_listing('.inc$', $path, 'name', 0);
  foreach ($files as $file) {
    include_once $file->filename;
    $pages[$page->name] = $page;
  }
  return $pages;
}
