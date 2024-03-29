<?php

$view = new view;
$view->name = 'customer_dropdown_pl';
$view->description = 'customer_dropdown_pl';
$view->tag = '';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'field_party_type_nid' => array(
    'label' => 'Party type',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_party_type_nid',
    'table' => 'node_data_field_party_type',
    'field' => 'field_party_type_nid',
    'relationship' => 'none',
  ),
  'nodereferer_referers' => array(
    'label' => 'Referencing Nodes',
    'required' => 0,
    'referrer_delta' => '-1',
    'referrer_field' => 'field_customer_party_pk',
    'id' => 'nodereferer_referers',
    'table' => 'node',
    'field' => 'nodereferer_referers',
    'relationship' => 'none',
  ),
  'field_bu_party_pk_nid' => array(
    'label' => 'Business Unit',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_bu_party_pk_nid',
    'table' => 'node_data_field_bu_party_pk',
    'field' => 'field_bu_party_pk_nid',
    'relationship' => 'nodereferer_referers',
  ),
  'nodereferer_referers_1' => array(
    'label' => 'Referencing Nodes',
    'required' => 0,
    'referrer_delta' => '-1',
    'referrer_field' => 'field_product_line_bu_party',
    'id' => 'nodereferer_referers_1',
    'table' => 'node',
    'field' => 'nodereferer_referers',
    'relationship' => 'field_bu_party_pk_nid',
  ),
));
$handler->override_option('fields', array(
  'title' => array(
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
    'exclude' => 0,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'none',
  ),
));
$handler->override_option('sorts', array(
  'title' => array(
    'order' => 'ASC',
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'none',
  ),
));
$handler->override_option('filters', array(
  'title' => array(
    'operator' => '=',
    'value' => 'Customer',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
      'optional' => FALSE,
    ),
    'case' => 1,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'field_party_type_nid',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('items_per_page', 0);
$handler->override_option('distinct', 1);
