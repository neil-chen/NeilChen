<?php

$view = new view;
$view->name = 'account_number_map_customer';
$view->description = 'account_number_map_customer used in person Content type';
$view->tag = '';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'field_bu_party_pk_nid' => array(
    'label' => 'Business Unit',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_bu_party_pk_nid',
    'table' => 'node_data_field_bu_party_pk',
    'field' => 'field_bu_party_pk_nid',
    'relationship' => 'none',
  ),
  'nodereferer_referers' => array(
    'label' => 'Referencing Nodes',
    'required' => 0,
    'referrer_delta' => '-1',
    'referrer_field' => 'field_product_line_bu_party',
    'id' => 'nodereferer_referers',
    'table' => 'node',
    'field' => 'nodereferer_referers',
    'relationship' => 'field_bu_party_pk_nid',
  ),
));
$handler->override_option('fields', array(
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
    'link_to_node' => 1,
    'exclude' => 1,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'none',
  ),
  'field_bu_customer_account_number_value' => array(
    'label' => '',
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
    'label_type' => 'none',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 0,
    'id' => 'field_bu_customer_account_number_value',
    'table' => 'node_data_field_bu_customer_account_number',
    'field' => 'field_bu_customer_account_number_value',
    'relationship' => 'none',
  ),
));
$handler->override_option('filters', array(
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'bu_customer' => 'bu_customer',
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
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('distinct', 1);
