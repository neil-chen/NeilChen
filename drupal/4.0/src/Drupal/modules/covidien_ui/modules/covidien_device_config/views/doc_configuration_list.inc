<?php

/**
 * @file
 * Used for document catalog module.
 */
$view = new view;
$view->name = 'doc_configuration_list';
$view->description = 'Document Configuration based list';
$view->tag = '';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'field_device_config_hw_list_nid' => array(
    'id' => 'field_device_config_hw_list_nid',
    'table' => 'node_data_field_device_config_hw_list',
    'field' => 'field_device_config_hw_list_nid',
  ),
  'field_device_config_hardware_nid' => array(
    'label' => 'Device config hardware',
    'required' => 0,
    'delta' => '-1',
    'id' => 'field_device_config_hardware_nid',
    'table' => 'node_data_field_device_config_hardware',
    'field' => 'field_device_config_hardware_nid',
    'relationship' => 'field_device_config_hw_list_nid',
  ),
  'field_device_config_sw_list_nid' => array(
    'label' => 'Device config SW reference',
    'required' => 0,
    'delta' => '-1',
    'id' => 'field_device_config_sw_list_nid',
    'table' => 'node_data_field_device_config_sw_list',
    'field' => 'field_device_config_sw_list_nid',
    'relationship' => 'field_device_config_hw_list_nid',
  ),
  'field_device_config_software_nid' => array(
    'label' => ' Device config Software',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_device_config_software_nid',
    'table' => 'node_data_field_device_config_software',
    'field' => 'field_device_config_software_nid',
    'relationship' => 'field_device_config_sw_list_nid',
  ),
  'field_hw_type_nid' => array(
    'label' => 'Hardware Type',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_hw_type_nid',
    'table' => 'node_data_field_hw_type',
    'field' => 'field_hw_type_nid',
    'relationship' => 'field_device_config_hardware_nid',
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
    'jeditable' => array(
      'enabled' => 1,
      'reload_page' => 0,
      'hide_if_empty' => 0,
      'disable_if_not_empty' => 0,
      'override_defaults' => 0,
    ),
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'none',
  ),
  'field_device_config_version_value' => array(
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
    'id' => 'field_device_config_version_value',
    'table' => 'node_data_field_device_config_version',
    'field' => 'field_device_config_version_value',
    'relationship' => 'none',
  ),
  'field_effective_date_value' => array(
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
    'format' => 'short',
    'multiple' => array(
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_to' => '',
      'group' => TRUE,
    ),
    'repeat' => array(
      'show_repeat_rule' => '',
    ),
    'fromto' => array(
      'fromto' => 'both',
    ),
    'exclude' => 0,
    'id' => 'field_effective_date_value',
    'table' => 'node_data_field_effective_date',
    'field' => 'field_effective_date_value',
    'relationship' => 'none',
  ),
  'field_device_end_of_life_value' => array(
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
    'format' => 'short',
    'multiple' => array(
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_to' => '',
      'group' => TRUE,
    ),
    'repeat' => array(
      'show_repeat_rule' => '',
    ),
    'fromto' => array(
      'fromto' => 'both',
    ),
    'exclude' => 0,
    'id' => 'field_device_end_of_life_value',
    'table' => 'node_data_field_device_end_of_life',
    'field' => 'field_device_end_of_life_value',
    'relationship' => 'none',
  ),
  'created' => array(
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
    'date_format' => 'custom',
    'custom_date_format' => 'm/d/Y',
    'exclude' => 0,
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  'title_1' => array(
    'label' => 'Name',
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
    'id' => 'title_1',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'field_device_config_hardware_nid',
  ),
  'field_hw_version_value' => array(
    'label' => 'Revision',
    'alter' => array(
      'alter_text' => 1,
      'text' => 'r[field_hw_version_value]',
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
    'label_type' => 'custom',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 0,
    'id' => 'field_hw_version_value',
    'table' => 'node_data_field_hw_version',
    'field' => 'field_hw_version_value',
    'relationship' => 'field_device_config_hardware_nid',
  ),
  'field_device_config_hw_status_value' => array(
    'label' => 'Required',
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
    'label_type' => 'custom',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 0,
    'id' => 'field_device_config_hw_status_value',
    'table' => 'node_data_field_device_config_hw_status',
    'field' => 'field_device_config_hw_status_value',
    'relationship' => 'field_device_config_hw_list_nid',
  ),
  'title_3' => array(
    'label' => 'Documents',
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
    'id' => 'title_3',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'none',
  ),
  'title_2' => array(
    'label' => 'Name',
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
    'id' => 'title_2',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'field_device_config_software_nid',
  ),
  'field_sw_version_value' => array(
    'label' => 'Version',
    'alter' => array(
      'alter_text' => 1,
      'text' => 'v[field_sw_version_value]',
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
    'label_type' => 'custom',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 0,
    'id' => 'field_sw_version_value',
    'table' => 'node_data_field_sw_version',
    'field' => 'field_sw_version_value',
    'relationship' => 'field_device_config_software_nid',
  ),
  'field_device_config_sw_status_value' => array(
    'label' => 'Required',
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
    'label_type' => 'custom',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 0,
    'id' => 'field_device_config_sw_status_value',
    'table' => 'node_data_field_device_config_sw_status',
    'field' => 'field_device_config_sw_status_value',
    'relationship' => 'field_device_config_sw_list_nid',
  ),
  'title_4' => array(
    'label' => 'Documents',
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
    'id' => 'title_4',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'vid_1',
  ),
  'field_expiration_datetime_value' => array(
    'label' => 'hw expiration_datetime',
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
    'label_type' => 'custom',
    'format' => 'default',
    'multiple' => array(
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_to' => '',
      'group' => TRUE,
    ),
    'repeat' => array(
      'show_repeat_rule' => '',
    ),
    'fromto' => array(
      'fromto' => 'both',
    ),
    'exclude' => 0,
    'id' => 'field_expiration_datetime_value',
    'table' => 'node_data_field_expiration_datetime',
    'field' => 'field_expiration_datetime_value',
    'relationship' => 'field_device_config_hardware_nid',
  ),
  'field_expiration_datetime_value_1' => array(
    'label' => 'sw expiration_datetime',
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
    'label_type' => 'custom',
    'format' => 'default',
    'multiple' => array(
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_to' => '',
      'group' => TRUE,
    ),
    'repeat' => array(
      'show_repeat_rule' => '',
    ),
    'fromto' => array(
      'fromto' => 'both',
    ),
    'exclude' => 0,
    'id' => 'field_expiration_datetime_value_1',
    'table' => 'node_data_field_expiration_datetime',
    'field' => 'field_expiration_datetime_value',
    'relationship' => 'field_device_config_software_nid',
  ),
  'field_sw_status_nid' => array(
    'label' => 'sw status',
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
    'label_type' => 'custom',
    'format' => 'plain',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 0,
    'id' => 'field_sw_status_nid',
    'table' => 'node_data_field_sw_status',
    'field' => 'field_sw_status_nid',
    'relationship' => 'field_device_config_software_nid',
  ),
  'title_5' => array(
    'label' => 'Hardware type Title',
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
    'id' => 'title_5',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'field_hw_type_nid',
  ),
));
$handler->override_option('sorts', array(
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
));
$handler->override_option('arguments', array(
  'title' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'php',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'glossary' => 0,
    'ignorecase' => 0,
    'limit' => '0',
    'case' => 'none',
    'path_case' => 'none',
    'transform_dash' => 0,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      2 => 0,
      3 => 0,
      4 => 0,
      27 => 0,
      23 => 0,
      5 => 0,
      28 => 0,
      29 => 0,
      30 => 0,
      31 => 0,
      6 => 0,
      7 => 0,
      8 => 0,
      9 => 0,
      10 => 0,
      11 => 0,
      12 => 0,
      13 => 0,
      14 => 0,
      15 => 0,
      16 => 0,
      17 => 0,
      18 => 0,
    ),
    'relationship' => 'none',
    'default_options_div_prefix' => '',
    'default_taxonomy_tid_term_page' => 0,
    'default_taxonomy_tid_node' => 0,
    'default_taxonomy_tid_limit' => 0,
    'default_taxonomy_tid_vids' => array(),
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => '$arg = arg(0);
$tmp = empty($arg);
if(!$tmp){
  return arg(0);
} else {
  return \'\';
}',
    'validate_argument_node_type' => array(
      'access_option' => 0,
      'address_type' => 0,
      'app_role_access_policy' => 0,
      'app_section' => 0,
      'business_unit' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'device_discrepancy' => 0,
      'device_installation' => 0,
      'device_language_availability' => 0,
      'device_log' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_service_history' => 0,
      'device_service_type' => 0,
      'device_setting_history' => 0,
      'device_type_config' => 0,
      'document' => 0,
      'document_type' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party' => 0,
      'party_contact' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'person' => 0,
      'person_application_role' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'product_line_report' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'software_reg_approval' => 0,
      'story' => 0,
      'user_settings' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
  ),
  'field_device_type_nid' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'php',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'break_phrase' => 1,
    'not' => 0,
    'id' => 'field_device_type_nid',
    'table' => 'node_data_field_device_type',
    'field' => 'field_device_type_nid',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      2 => 0,
      3 => 0,
      4 => 0,
      27 => 0,
      23 => 0,
      5 => 0,
      28 => 0,
      29 => 0,
      30 => 0,
      31 => 0,
      6 => 0,
      7 => 0,
      8 => 0,
      9 => 0,
      10 => 0,
      11 => 0,
      12 => 0,
      13 => 0,
      14 => 0,
      15 => 0,
      16 => 0,
      17 => 0,
      18 => 0,
    ),
    'relationship' => 'none',
    'default_options_div_prefix' => '',
    'default_taxonomy_tid_term_page' => 0,
    'default_taxonomy_tid_node' => 0,
    'default_taxonomy_tid_limit' => 0,
    'default_taxonomy_tid_vids' => array(),
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => 'global $user;
$arg = arg(1);
$tmp =is_numeric($arg);
if($tmp && $arg>0) {
  $valid_devices = explode(\',\', $user->devices_nid);
  $tmp = in_array($arg,$valid_devices);
  if($tmp){
    return $arg;
 }else{
   return 0;
 }
} else {
  return $user->devices_nid;
}',
    'validate_argument_node_type' => array(
      'access_option' => 0,
      'address_type' => 0,
      'app_role_access_policy' => 0,
      'app_section' => 0,
      'business_unit' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'device_discrepancy' => 0,
      'device_installation' => 0,
      'device_language_availability' => 0,
      'device_log' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_service_history' => 0,
      'device_service_type' => 0,
      'device_setting_history' => 0,
      'device_type_config' => 0,
      'document' => 0,
      'document_type' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party' => 0,
      'party_contact' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'person' => 0,
      'person_application_role' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'product_line_report' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'software_reg_approval' => 0,
      'story' => 0,
      'user_settings' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
  ),
  'field_hw_type_nid' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'php',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'break_phrase' => 0,
    'not' => 0,
    'id' => 'field_hw_type_nid',
    'table' => 'node_data_field_hw_type',
    'field' => 'field_hw_type_nid',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      2 => 0,
      3 => 0,
      4 => 0,
      27 => 0,
      23 => 0,
      5 => 0,
      28 => 0,
      29 => 0,
      30 => 0,
      31 => 0,
      6 => 0,
      7 => 0,
      8 => 0,
      9 => 0,
      10 => 0,
      11 => 0,
      12 => 0,
      13 => 0,
      14 => 0,
      15 => 0,
      16 => 0,
      17 => 0,
      18 => 0,
    ),
    'relationship' => 'field_device_config_hardware_nid',
    'default_options_div_prefix' => '',
    'default_taxonomy_tid_term_page' => 0,
    'default_taxonomy_tid_node' => 0,
    'default_taxonomy_tid_limit' => 0,
    'default_taxonomy_tid_vids' => array(),
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => '$arg = arg(2);
$tmp = is_numeric($arg);
if($tmp && $arg>0) {
return $arg;
}else{
return \'all\';
}',
    'validate_argument_node_type' => array(
      'access_option' => 0,
      'address_type' => 0,
      'app_role_access_policy' => 0,
      'app_section' => 0,
      'business_unit' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'device_discrepancy' => 0,
      'device_installation' => 0,
      'device_language_availability' => 0,
      'device_log' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_service_history' => 0,
      'device_service_type' => 0,
      'device_setting_history' => 0,
      'device_type_config' => 0,
      'document' => 0,
      'document_type' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party' => 0,
      'party_contact' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'person' => 0,
      'person_application_role' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'product_line_report' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'software_reg_approval' => 0,
      'story' => 0,
      'user_settings' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
  ),
  'title_1' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'php',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'glossary' => 0,
    'ignorecase' => 0,
    'limit' => '0',
    'case' => 'none',
    'path_case' => 'none',
    'transform_dash' => 0,
    'id' => 'title_1',
    'table' => 'node',
    'field' => 'title',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      2 => 0,
      3 => 0,
      4 => 0,
      27 => 0,
      23 => 0,
      5 => 0,
      28 => 0,
      29 => 0,
      30 => 0,
      31 => 0,
      6 => 0,
      7 => 0,
      8 => 0,
      9 => 0,
      10 => 0,
      11 => 0,
      12 => 0,
      13 => 0,
      14 => 0,
      15 => 0,
      16 => 0,
      17 => 0,
      18 => 0,
    ),
    'relationship' => 'field_device_config_software_nid',
    'default_options_div_prefix' => '',
    'default_taxonomy_tid_term_page' => 0,
    'default_taxonomy_tid_node' => 0,
    'default_taxonomy_tid_limit' => 0,
    'default_taxonomy_tid_vids' => array(),
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => '$arg = arg(3);
$tmp = empty($arg);
if(!$tmp){
  return arg(3);
} else {
  return \'all\';
}',
    'validate_argument_node_type' => array(
      'access_option' => 0,
      'address_type' => 0,
      'app_role_access_policy' => 0,
      'app_section' => 0,
      'business_unit' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'device_discrepancy' => 0,
      'device_installation' => 0,
      'device_language_availability' => 0,
      'device_log' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_service_history' => 0,
      'device_service_type' => 0,
      'device_setting_history' => 0,
      'device_type_config' => 0,
      'document' => 0,
      'document_type' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party' => 0,
      'party_contact' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'person' => 0,
      'person_application_role' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'product_line_report' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'software_reg_approval' => 0,
      'story' => 0,
      'user_settings' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
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
      'device_type_config' => 'device_type_config',
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
$handler->override_option('header_format', '2');
$handler->override_option('header_empty', 0);
$handler->override_option('empty', '<div class="view-content">
      <table class="views-table cols-8">
  <thead>
    <tr>
              <th class="views-field views-field-nid-1 active">
                  </th>
              <th class="views-field views-field-title-1">
          Name &amp; Revision        </th>
              <th class="views-field views-field-field-hw-description-value">
          Description        </th>
              <th class="views-field views-field-nid-2">
          Status        </th>
              <th class="views-field views-field-nid">
                  </th>
              <th class="views-field views-field-title">
          Name &amp; Version        </th>
              <th class="views-field views-field-field-sw-description-value">
          Description        </th>
              <th class="views-field views-field-nid-3">
          Status        </th>
          </tr>
  </thead>
  <tbody>
          <tr class="odd views-row-first views-row-last">
                  <td class="views-field views-field-nid-1" colspan="4">No Hardwares available 
          </td>
                  <td class="views-field views-field-nid"  colspan="4">No Softwares available 
          </td>
              </tr>
      </tbody>
</table>
    </div>');
$handler->override_option('empty_format', '2');
$handler->override_option('items_per_page', 0);
$handler->override_option('use_pager', '1');
$handler->override_option('distinct', 0);
$handler->override_option('style_plugin', 'table');
$handler->override_option('style_options', array(
  'grouping' => 'title_1',
  'override' => 1,
  'sticky' => 0,
  'order' => 'asc',
  'summary' => '',
  'columns' => array(
    'title' => 'title',
    'field_device_config_version_value' => 'field_device_config_version_value',
    'field_effective_date_value' => 'field_effective_date_value',
    'field_device_end_of_life_value' => 'field_device_end_of_life_value',
    'created' => 'created',
    'title_1' => 'title_1',
    'field_hw_version_value' => 'field_hw_version_value',
    'field_device_config_hw_status_value' => 'field_device_config_hw_status_value',
    'title_2' => 'title_2',
    'field_device_config_sw_status_value' => 'field_device_config_sw_status_value',
    'field_sw_version_value' => 'field_sw_version_value',
  ),
  'info' => array(
    'title' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_device_config_version_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_effective_date_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_device_end_of_life_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'created' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'title_1' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_hw_version_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_device_config_hw_status_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'title_2' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_device_config_sw_status_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_sw_version_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
