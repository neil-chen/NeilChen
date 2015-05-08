<?php

/**
 * Implementation of hook_default_page_manager_pages().
 */
function covidien_device_default_page_manager_pages() {
  $pages = array();
  $path = drupal_get_path('module', 'covidien_device') . '/pages';
  $files = drupal_system_listing('.inc$', $path, 'name', 0);
  foreach ($files as $file) {
    include_once $file->filename;
    $pages[$page->name] = $page;
  }
  return $pages;
}
