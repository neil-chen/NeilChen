<?php

/**
 * @file
 * For document catlog list page used by ctools.
 */

/**
 * Implementation of hook_default_page_manager_pages().
 */
function covidien_doc_default_page_manager_pages() {
  $pages = array();
  $path = drupal_get_path('module', 'covidien_doc') . '/pages';
  $files = drupal_system_listing('.inc$', $path, 'name', 0);
  foreach ($files as $file) {
    include_once $file->filename;
    $pages[$page->name] = $page;
  }
  return $pages;
}

/**
 * menu callback covidien/document
 */
function covidien_doc_list() {
  return theme('covidien_doc_list');
}

function covidien_theme_preprocess_covidien_doc_list(&$vars) {
  drupal_add_js('misc/ahah.js');
  drupal_add_js('misc/autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_doc') . '/js/covidien_doc.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_ahah.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_doc') . '/js/covidien_doc_list.js');
  $filter_form = covidien_doc_filter_form();
  $document_table = covidien_document_table_list();
  $vars['filter_form'] = $filter_form;
  $vars['document_table'] = $document_table;
}

/**
 * document filter form
 * @return array
 */
function covidien_doc_filter_form() {
  $form = array();
  $form['#method'] = 'get';
  $get = filter_xss_arr($_GET);
  $product_line = covidien_get_product_line();
  $device_type = $get['device_type'] ? $get['device_type'] : covidien_get_device_type();
  // table head need to customize
  module_load_include('module', 'covidien_firmware', 'module');
  $select_device_type = field_device_type_select($get['device_type'], $product_line);
  $form['device_type'] = $select_device_type['select_device_type'];
  $form['document_title'] = array(
    '#type' => 'textfield',
    '#name' => 'document_title',
    '#id' => 'document_title',
    '#default_value' => $get['document_title'],
    '#autocomplete_path' => 'covidien/reports/filtertype/document_title/autocomplete',
    '#attributes' => array(
      'placeholder' => 'Search - Enter document Title',
    ),
  );
  $form['hw_type'] = array(
    '#type' => 'select',
    '#name' => 'hw_type',
    '#options' => covidien_get_hw_type($product_line, $device_type),
  );
  $form['hw_name'] = array(
    '#type' => 'select',
    '#name' => 'hw_name',
    '#options' => covidien_get_hw_name($product_line, $device_type, $get['hw_type']),
  );
  $form['sw_name'] = array(
    '#type' => 'select',
    '#name' => 'sw_name',
    '#options' => covidien_get_sw_name($product_line, $device_type),
  );
  $form['sw_version'] = array(
    '#type' => 'select',
    '#name' => 'sw_version',
    '#options' => covidien_get_sw_version($product_line, $device_type, $get['sw_name']),
  );
  $form['sw_status'] = array(
    '#type' => 'select',
    '#name' => 'sw_status',
    '#options' => covidien_get_sw_status($product_line, $device_type, $get['sw_name'], $get['sw_version']),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Filter'),
  );
  return $form;
}

function covidien_get_hw_query($product_line = 0, $device_type = 0, $hw_type = 0) {
  $sql = "SELECT n.nid, n.title, htn.nid AS hw_type_nid, htn.title AS hw_type, h.field_hw_version_value AS hw_version
    FROM node n
    JOIN content_type_hardware h ON n.vid = h.vid
    JOIN content_field_device_type d ON h.vid = d.vid 
    JOIN content_field_device_product_line p ON p.nid = d.field_device_type_nid
    JOIN node htn ON h.field_hw_type_nid = htn.nid AND htn.type='hardwaretype'
    LEFT JOIN content_field_expiration_datetime ed ON n.vid = ed.vid
    WHERE n.type='hardware' AND ed.field_expiration_datetime_value IS NULL";
  if ($product_line && $product_line != 'All') {
    $sql .= " AND p.field_device_product_line_nid = %d ";
  }
  if ($device_type && $device_type != 'All') {
    $sql .= "AND d.field_device_type_nid = %d ";
  }
  if ($hw_type && $hw_type != 'All') {
    $sql .= "AND h.field_hw_type_nid = %d ";
  }
  return $sql;
}

function covidien_get_sw_query($product_line = 0, $device_type = 0, $sw_name = 0, $sw_version = 0) {
  $sql = "SELECT n.nid, n.title, s.field_sw_version_value AS sw_version, sn.nid AS sw_status_nid, sn.title AS sw_status
    FROM node n 
    JOIN content_type_software s ON n.vid = s.vid 
    JOIN content_field_device_type d ON s.vid = d.vid 
    JOIN content_field_device_product_line p ON p.nid = d.field_device_type_nid
    JOIN node sn ON s.field_sw_status_nid = sn.nid
    LEFT JOIN content_field_expiration_datetime ed ON n.vid = ed.vid
    WHERE n.type='software' AND ed.field_expiration_datetime_value IS NULL";
  if ($product_line && $product_line != 'All') {
    $sql .= " AND p.field_device_product_line_nid = %d ";
  }
  if ($device_type && $device_type != 'All') {
    $sql .= "AND d.field_device_type_nid = %d ";
  }
  if ($sw_name && $sw_name != 'All') {
    $sql .= "AND d.field_device_type_nid = %d ";
  }
  if ($sw_version && $sw_version != 'All') {
    $sql .= "AND d.field_device_type_nid = %d ";
  }
  return $sql;
}

function covidien_get_doc_name() {
  $get = filter_xss_arr($_GET);
  if (!$product_line) {
    $product_line = covidien_get_product_line();
  }
  if (!$device_type) {
    $device_type = covidien_get_device_type();
  }
  if ($get['document_title']) {
    $sql = "SELECT n.nid, n.title FROM node n 
      JOIN content_type_document d ON n.vid = d.vid 
      JOIN content_field_device_type dt ON d.vid = dt.vid 
      JOIN content_field_device_product_line p ON p.nid = dt.field_device_type_nid
      LEFT JOIN content_field_expiration_datetime ed ON n.vid = ed.vid
      WHERE n.type='document' AND n.title LIKE '%s%%%' ";
    if ($product_line && $product_line != 'All') {
      $sql .= " AND p.field_device_product_line_nid = %d ";
    }
    if ($device_type && $device_type != 'All') {
      $sql .= "AND dt.field_device_type_nid = %d ";
    }
  }
}

function covidien_get_hw_type($product_line = 0, $device_type = 0) {
  if (!$product_line) {
    $product_line = covidien_get_product_line();
  }
  if (!$device_type) {
    $device_type = covidien_get_device_type();
  }
  //get has hardware type 
  $sql = covidien_get_hw_query($product_line, $device_type);
  $result = db_query($sql, $product_line, $device_type);
  $rows = array('All');
  while ($row = db_fetch_object($result)) {
    $rows[$row->hw_type_nid] = $row->hw_type;
  }
  return $rows;
}

function covidien_get_hw_name($product_line = 0, $device_type = 0, $hw_type = 0) {
  if (!$product_line) {
    $product_line = covidien_get_product_line();
  }
  if (!$device_type) {
    $device_type = covidien_get_device_type();
  }
  //get has hardware type 
  $sql = covidien_get_hw_query($product_line, $device_type, $hw_type);
  $result = db_query($sql, $product_line, $device_type, $hw_type);
  $rows = array('All');
  while ($row = db_fetch_object($result)) {
    $rows[$row->nid] = $row->title . ' r' . $row->hw_version;
  }
  return $rows;
}

function covidien_get_sw_name($product_line = 0, $device_type = 0) {
  if (!$product_line) {
    $product_line = covidien_get_product_line();
  }
  if (!$device_type) {
    $device_type = covidien_get_device_type();
  }
  $sql = covidien_get_sw_query($product_line, $device_type);
  $result = db_query($sql, $product_line, $device_type);
  $rows = array('All');
  while ($row = db_fetch_object($result)) {
    $rows[$row->title] = $row->title;
  }
  return $rows;
}

function covidien_get_sw_version($product_line = 0, $device_type = 0, $sw_name = 0) {
  if (!$product_line) {
    $product_line = covidien_get_product_line();
  }
  if (!$device_type) {
    $device_type = covidien_get_device_type();
  }
  $sql = covidien_get_sw_query($product_line, $device_type, $sw_name);
  $result = db_query($sql, $product_line, $device_type, $sw_name);
  $rows = array('All' => 'All');
  while ($row = db_fetch_object($result)) {
    $rows[$row->sw_version] = $row->sw_version;
  }
  return $rows;
}

function covidien_get_sw_status($product_line = 0, $device_type = 0, $sw_name = 0, $sw_version = 0) {
  if (!$product_line) {
    $product_line = covidien_get_product_line();
  }
  if (!$device_type) {
    $device_type = covidien_get_device_type();
  }
  $sql = covidien_get_sw_query($product_line, $device_type, $sw_name, $sw_version);
  $result = db_query($sql, $product_line, $device_type, $sw_name);
  $rows = array('All');
  while ($row = db_fetch_object($result)) {
    $rows[$row->sw_status_nid] = $row->sw_status;
  }
  return $rows;
}

/**
 * covidien dovument table list use filter 
 * @return type
 */
function covidien_document_table_list() {
  $get = filter_xss_arr($_GET);
  $filter['dt_nid'] = $get['field_device_type_nid'];
  $filter['name'] = $get['title'];
  $filter['config'] = $get['field_config_value'];
  $filter['hw_type'] = $get['field_hw_type_nid'];
  $filter['sw_name'] = $get['title_1'];
  $filter['hw_nid'] = $get['field_doc_hw_list_nid'];
  $filter['hw_version_nid'] = $get['field_hw_version_value'];
  $filter['sw_version_nid'] = $get['field_sw_version_value'];
  $filter['sw_status_nid'] = $get['field_sw_status_nid'];

  //var_dump($get);
  /* SELECT DISTINCT(node.nid) AS nid,
    node_data_field_device_type.field_device_type_nid AS node_data_field_device_type_field_device_type_nid,
    node.type AS node_type,
    node.vid AS node_vid,
    content_type_document.field_document_version_value AS content_type_document_field_document_version_value,
    node.title AS node_title,
    node_node_data_field_documnet_type.title AS node_node_data_field_documnet_type_title,
    node_node_data_field_documnet_type.nid AS node_node_data_field_documnet_type_nid,
    node_content_type_document.title AS node_content_type_document_title,
    node_content_type_document.nid AS node_content_type_document_nid,
    node_node_data_field_document_language.title AS node_node_data_field_document_language_title,
    node_node_data_field_document_language.nid AS node_node_data_field_document_language_nid,
    files_node_data_field_document_file.filename AS files_node_data_field_document_file_filename,
    content_type_document.field_doc_external_users_value AS content_type_document_field_doc_external_users_value,
    content_type_document.field_document_description_value AS content_type_document_field_document_description_value,
    files_node_data_field_document_file.filesize AS files_node_data_field_document_file_filesize,
    node_revisions.timestamp AS node_revisions_timestamp,
    content_type_document.field_document_md5sum_value AS content_type_document_field_document_md5sum_value
    FROM node node
    LEFT JOIN content_field_doc_hw_list node_data_field_doc_hw_list ON node.vid = node_data_field_doc_hw_list.vid
    LEFT JOIN node node_node_data_field_doc_hw_list ON node_data_field_doc_hw_list.field_doc_hw_list_nid = node_node_data_field_doc_hw_list.nid
    LEFT JOIN content_field_doc_sw_list node_data_field_doc_sw_list ON node.vid = node_data_field_doc_sw_list.vid
    LEFT JOIN node node_node_data_field_doc_sw_list ON node_data_field_doc_sw_list.field_doc_sw_list_nid = node_node_data_field_doc_sw_list.nid
    LEFT JOIN content_type_document node_data_field_document_file ON node.vid = node_data_field_document_file.vid
    LEFT JOIN files files_node_data_field_document_file ON node_data_field_document_file.field_document_file_fid = files_node_data_field_document_file.fid
    LEFT JOIN content_type_document node_data_field_documnet_type ON node.vid = node_data_field_documnet_type.vid
    LEFT JOIN node node_node_data_field_documnet_type ON node_data_field_documnet_type.field_documnet_type_nid = node_node_data_field_documnet_type.nid
    LEFT JOIN content_type_document content_type_document ON node.vid = content_type_document.vid
    LEFT JOIN node node_content_type_document ON content_type_document.doc_status = node_content_type_document.nid
    LEFT JOIN content_type_document node_data_field_document_language ON node.vid = node_data_field_document_language.vid
    LEFT JOIN node node_node_data_field_document_language ON node_data_field_document_language.field_document_language_nid = node_node_data_field_document_language.nid
    LEFT JOIN content_type_hardware node_node_data_field_doc_hw_list_node_data_field_hw_version ON node_node_data_field_doc_hw_list.vid = node_node_data_field_doc_hw_list_node_data_field_hw_version.vid
    LEFT JOIN content_type_software node_node_data_field_doc_sw_list_node_data_field_sw_version ON node_node_data_field_doc_sw_list.vid = node_node_data_field_doc_sw_list_node_data_field_sw_version.vid
    LEFT JOIN content_field_expiration_datetime node_data_field_expiration_datetime ON node.vid = node_data_field_expiration_datetime.vid
    LEFT JOIN content_field_device_type node_data_field_device_type ON node.vid = node_data_field_device_type.vid
    LEFT JOIN node_revisions node_revisions ON node.vid = node_revisions.vid
    WHERE ((node.status = 1) AND (node.type in ('document')) AND (node_data_field_device_type.field_device_type_nid = 0 ) AND ( (node.nid IN (SELECT content_field_device_type.nid FROM content_field_device_product_line
    JOIN content_field_device_type ON content_field_device_product_line.nid = content_field_device_type.field_device_type_nid
    WHERE field_device_product_line_nid = '23')) ))
    AND (node_data_field_expiration_datetime.field_expiration_datetime_value IS NULL)
    GROUP BY nid
    ORDER BY nid DESC */
  return $output;
}

function covidien_doc_filter_ajax() {
  
}
