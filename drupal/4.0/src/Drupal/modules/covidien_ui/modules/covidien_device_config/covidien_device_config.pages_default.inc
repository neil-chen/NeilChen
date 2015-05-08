<?php

/**
 * @file
 * For Configuration catalog module List page used by ctools.
 */

/**
 * Implementation of hook_default_page_manager_pages().
 */
function covidien_device_config_default_page_manager_pages() {
  $pages = array();
  $path = drupal_get_path('module', 'covidien_device_config') . '/pages';
  $files = drupal_system_listing('.inc$', $path, 'name', 0);
  foreach ($files as $file) {
    include_once $file->filename;
    $pages[$page->name] = $page;
  }
  return $pages;
}
