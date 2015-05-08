<?php

/**
 * @file
 * Used by cron job for uploading document catlog files to file repo.
 */
$view = new view;
$view->name = 'files_cron_doc';
$view->description = 'list of documents upload to repo';
$view->tag = '';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'field_document_file_fid' => array(
    'label' => 'Document file',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_document_file_fid',
    'table' => 'node_data_field_document_file',
    'field' => 'field_document_file_fid',
    'relationship' => 'none',
  ),
  'field_documnet_type_nid' => array(
    'label' => 'Document Type',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_documnet_type_nid',
    'table' => 'node_data_field_documnet_type',
    'field' => 'field_documnet_type_nid',
    'relationship' => 'none',
  ),
));
$handler->override_option('fields', array(
  'nid' => array(
    'label' => 'Nid',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 0,
      'path' => '',
      'absolute' => 0,
      'link_class' => '',
      'alt' => '',
      'rel' => '',
      'prefix' => '',
      'suffix' => '',
      'target' => '',
      'help' => '',
      'trim' => 0,
      'max_length' => '',
      'word_boundary' => 1,
      'ellipsis' => 1,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'link_to_node' => 0,
    'exclude' => 0,
    'id' => 'nid',
    'table' => 'node',
    'field' => 'nid',
    'relationship' => 'none',
  ),
  'fid' => array(
    'id' => 'fid',
    'table' => 'files',
    'field' => 'fid',
    'relationship' => 'field_sw_file_fid',
  ),
  'filemime' => array(
    'label' => 'Mime type',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 0,
      'path' => '',
      'absolute' => 0,
      'link_class' => '',
      'alt' => '',
      'rel' => '',
      'prefix' => '',
      'suffix' => '',
      'target' => '',
      'help' => '',
      'trim' => 0,
      'max_length' => '',
      'word_boundary' => 1,
      'ellipsis' => 1,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'link_to_file' => 0,
    'exclude' => 0,
    'id' => 'filemime',
    'table' => 'files',
    'field' => 'filemime',
    'relationship' => 'field_sw_file_fid',
  ),
  'filename' => array(
    'id' => 'filename',
    'table' => 'files',
    'field' => 'filename',
  ),
  'filepath' => array(
    'id' => 'filepath',
    'table' => 'files',
    'field' => 'filepath',
  ),
  'filesize' => array(
    'id' => 'filesize',
    'table' => 'files',
    'field' => 'filesize',
  ),
  'timestamp' => array(
    'id' => 'timestamp',
    'table' => 'files',
    'field' => 'timestamp',
  ),
  'title' => array(
    'label' => 'Title',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 0,
      'path' => '',
      'absolute' => 0,
      'link_class' => '',
      'alt' => '',
      'rel' => '',
      'prefix' => '',
      'suffix' => '',
      'target' => '',
      'help' => '',
      'trim' => 0,
      'max_length' => '',
      'word_boundary' => 1,
      'ellipsis' => 1,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'link_to_node' => 0,
    'exclude' => 0,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'field_documnet_type_nid',
  ),
));
$handler->override_option('filters', array(
  'status' => array(
    'operator' => '=',
    'value' => '1',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'id' => 'status',
    'table' => 'node',
    'field' => 'status',
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'document' => 'document',
    ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'id' => 'type',
    'table' => 'node',
    'field' => 'type',
    'relationship' => 'none',
  ),
  'field_document_md5sum_value' => array(
    'operator' => 'empty',
    'value' => '',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
      'optional' => FALSE,
    ),
    'case' => 1,
    'id' => 'field_document_md5sum_value',
    'table' => 'node_data_field_document_md5sum',
    'field' => 'field_document_md5sum_value',
    'relationship' => 'none',
  ),
  'filepath' => array(
    'operator' => 'not empty',
    'value' => '',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
      'optional' => FALSE,
    ),
    'case' => 1,
    'id' => 'filepath',
    'table' => 'files',
    'field' => 'filepath',
    'relationship' => 'field_document_file_fid',
  ),
  'field_expiration_datetime_value' => array(
    'operator' => 'empty',
    'value' => array(
      'value' => NULL,
      'min' => NULL,
      'max' => NULL,
      'default_date' => '',
      'default_to_date' => '',
    ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'date_fields' => array(
      'node_data_field_expiration_datetime.field_expiration_datetime_value' => 'node_data_field_expiration_datetime.field_expiration_datetime_value',
    ),
    'date_method' => 'AND',
    'granularity' => 'day',
    'form_type' => 'date_select',
    'default_date' => '',
    'default_to_date' => '',
    'year_range' => '-3:+3',
    'id' => 'field_expiration_datetime_value',
    'table' => 'node_data_field_expiration_datetime',
    'field' => 'field_expiration_datetime_value',
    'relationship' => 'none',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('style_plugin', 'table');
$handler->override_option('style_options', array(
  'grouping' => '',
  'override' => 1,
  'sticky' => 0,
  'order' => 'asc',
  'summary' => '',
  'columns' => array(
    'nid' => 'nid',
    'fid' => 'fid',
    'filemime' => 'filemime',
    'filename' => 'filename',
    'filepath' => 'filepath',
    'filesize' => 'filesize',
    'status' => 'status',
    'timestamp' => 'timestamp',
  ),
  'info' => array(
    'nid' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'fid' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'filemime' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'filename' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'filepath' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'filesize' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'status' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'timestamp' => array(
      'sortable' => 0,
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
