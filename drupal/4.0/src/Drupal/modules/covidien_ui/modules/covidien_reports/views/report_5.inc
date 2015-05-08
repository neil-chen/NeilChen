<?php

/**
 * @file
 * Report configuration view, Audit Trail Report.
 */
$view = new view;
$view->name = 'report_5';
$view->description = 'activitylog_report';
$view->tag = '';
$view->base_table = 'activity_log';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'nid' => array(
    'label' => 'activity_log - Users',
    'required' => 0,
    'id' => 'nid',
    'table' => 'activity_log',
    'field' => 'nid',
    'relationship' => 'none',
  ),
  'field_customer_party_pk_nid' => array(
    'id' => 'field_customer_party_pk_nid',
    'table' => 'node_data_field_customer_party_pk',
    'field' => 'field_customer_party_pk_nid',
    'relationship' => 'nid',
  ),
  'nodereferer_referers' => array(
    'label' => 'Referencing Nodes',
    'required' => 0,
    'referrer_delta' => '-1',
    'referrer_field' => 'field_person_pk',
    'id' => 'nodereferer_referers',
    'table' => 'node',
    'field' => 'nodereferer_referers',
    'relationship' => 'nid',
  ),
  'field_app_role_pk_nid' => array(
    'label' => 'App Role PK',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_app_role_pk_nid',
    'table' => 'node_data_field_app_role_pk',
    'field' => 'field_app_role_pk_nid',
    'relationship' => 'nodereferer_referers',
  ),
  'field_comp_account_no_nid' => array(
    'label' => 'Company Account Number',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_comp_account_no_nid',
    'table' => 'node_data_field_comp_account_no',
    'field' => 'field_comp_account_no_nid',
    'relationship' => 'nid',
  ),
));
$handler->override_option('fields', array(
  'field_first_name_value' => array(
    'label' => 'First Name',
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
    'label_type' => 'widget',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 1,
    'id' => 'field_first_name_value',
    'table' => 'node_data_field_first_name',
    'field' => 'field_first_name_value',
    'relationship' => 'nid',
  ),
  'field_last_name_value' => array(
    'label' => 'User ID',
    'alter' => array(
      'alter_text' => 1,
      'text' => '[field_first_name_value] [field_last_name_value]',
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
    'id' => 'field_last_name_value',
    'table' => 'node_data_field_last_name',
    'field' => 'field_last_name_value',
    'relationship' => 'nid',
  ),
  'field_person_username_value' => array(
    'label' => 'User ID',
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
    'exclude' => 1,
    'id' => 'field_person_username_value',
    'table' => 'node_data_field_person_username',
    'field' => 'field_person_username_value',
    'relationship' => 'nid',
  ),
  'field_company_name_nid' => array(
    'label' => 'Customer Name',
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
    'id' => 'field_company_name_nid',
    'table' => 'node_data_field_company_name',
    'field' => 'field_company_name_nid',
    'relationship' => 'nid',
  ),
  'field_bu_customer_account_number_value' => array(
    'label' => 'Customer Account number',
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
    'id' => 'field_bu_customer_account_number_value',
    'table' => 'node_data_field_bu_customer_account_number',
    'field' => 'field_bu_customer_account_number_value',
    'relationship' => 'field_comp_account_no_nid',
  ),
  'activity_type' => array(
    'label' => 'Activity type',
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
    'exclude' => 1,
    'id' => 'activity_type',
    'table' => 'activity_log',
    'field' => 'activity_type',
    'relationship' => 'none',
  ),
  'message' => array(
    'label' => 'Activity',
    'alter' => array(
      'alter_text' => 1,
      'text' => '[activity_type] - [message]',
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
    'exclude' => 0,
    'id' => 'message',
    'table' => 'activity_log',
    'field' => 'message',
    'relationship' => 'none',
  ),
  'ip_address' => array(
    'label' => 'Host Name',
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
    'exclude' => 0,
    'id' => 'ip_address',
    'table' => 'activity_log',
    'field' => 'ip_address',
    'relationship' => 'none',
  ),
  'device' => array(
    'label' => 'Device Type',
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
    'exclude' => 0,
    'id' => 'device',
    'table' => 'activity_log',
    'field' => 'device',
    'relationship' => 'none',
  ),
  'device_serial' => array(
    'label' => 'Device Serial Number',
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
    'exclude' => 0,
    'id' => 'device_serial',
    'table' => 'activity_log',
    'field' => 'device_serial',
    'relationship' => 'none',
  ),
  'logtime' => array(
    'label' => 'Date & Time',
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
    'exclude' => 0,
    'id' => 'logtime',
    'table' => 'activity_log',
    'field' => 'logtime',
    'relationship' => 'none',
  ),
));
$handler->override_option('filters', array(
  'field_last_name_value' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_last_name_value_op',
      'identifier' => 'last_name',
      'label' => 'Last name',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'field_last_name_value',
    'table' => 'node_data_field_last_name',
    'field' => 'field_last_name_value',
    'relationship' => 'nid',
  ),
  'field_person_username_value' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_person_username_value_op',
      'identifier' => 'username',
      'label' => 'Email Address',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'field_person_username_value',
    'table' => 'node_data_field_person_username',
    'field' => 'field_person_username_value',
    'relationship' => 'nid',
  ),
  'activity_type' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'activity_type_op',
      'identifier' => 'activity_type',
      'label' => 'Activity type',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'activity_type',
    'table' => 'activity_log',
    'field' => 'activity_type',
    'relationship' => 'none',
  ),
  'field_role_product_line_nid' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_role_product_line_nid_op',
      'identifier' => 'productline_nid',
      'label' => 'Product Line',
      'optional' => 1,
      'single' => 1,
      'remember' => 0,
      'reduce' => 0,
    ),
    'id' => 'field_role_product_line_nid',
    'table' => 'node_data_field_role_product_line',
    'field' => 'field_role_product_line_nid',
    'relationship' => 'field_app_role_pk_nid',
    'reduce_duplicates' => 0,
  ),
  'field_bu_customer_account_number_value' => array(
    'operator' => 'allwords',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_bu_customer_account_number_value_op',
      'identifier' => 'comp_account_no',
      'label' => 'Customer Account number',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'field_bu_customer_account_number_value',
    'table' => 'node_data_field_bu_customer_account_number',
    'field' => 'field_bu_customer_account_number_value',
    'relationship' => 'field_comp_account_no_nid',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('empty_format', '2');
$handler->override_option('use_pager', '1');
$handler->override_option('style_plugin', 'table');
$handler->override_option('style_options', array(
  'grouping' => '',
  'override' => 1,
  'sticky' => 0,
  'order' => 'asc',
  'summary' => '',
  'columns' => array(
    'field_first_name_value' => 'field_first_name_value',
    'field_last_name_value' => 'field_last_name_value',
    'field_person_username_value' => 'field_person_username_value',
    'field_company_name_nid' => 'field_company_name_nid',
    'field_bu_customer_account_number_value' => 'field_bu_customer_account_number_value',
    'activity_type' => 'activity_type',
    'message' => 'message',
    'ip_address' => 'ip_address',
    'device' => 'device',
    'device_serial' => 'device_serial',
    'logtime' => 'logtime',
  ),
  'info' => array(
    'field_first_name_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_last_name_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_person_username_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'field_company_name_nid' => array(
      'separator' => '',
    ),
    'field_bu_customer_account_number_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'activity_type' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'message' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'ip_address' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'device' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'device_serial' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'logtime' => array(
      'sortable' => 0,
      'separator' => '',
    ),
  ),
  'default' => 'logtime',
));
$handler->override_option('exposed_block', TRUE);
$handler = $view->new_display('pdf', 'PDF Page', 'pdf_1');
$handler->override_option('items_per_page', 0);
$handler->override_option('use_pager', FALSE);
$handler->override_option('style_plugin', 'pdf_table');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'info' => array(
    'field_last_name_value' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
    'field_company_name_nid' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
    'field_bu_customer_account_number_value' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
    'message' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
    'ip_address' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
    'device' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
    'device_serial' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
    'logtime' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '10',
          'font_family' => 'default',
          'font_style' => array(
            'b' => 'b',
            'i' => 0,
            'u' => 0,
            'd' => 0,
            'o' => 0,
          ),
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'body_style' => array(
        'text' => array(
          'font_size' => '',
          'font_family' => 'default',
          'font_style' => NULL,
          'align' => NULL,
          'hyphenate' => NULL,
          'color' => '',
        ),
        'render' => array(
          'is_html' => 1,
          'eval_before' => '',
          'eval_after' => '',
        ),
      ),
      'position' => array(
        'width' => '',
      ),
    ),
  ),
  'position' => array(
    'last_writing_position' => 1,
    'x' => '',
    'y' => '',
    'width' => '375',
    'row_height' => '',
  ),
  'grouping' => '',
));
$handler->override_option('row_plugin', 'pdf_fields');
$handler->override_option('path', 'covidien/report/5/pdf/Audit_Trail_Report');
$handler->override_option('menu', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('displays', array());
$handler->override_option('sitename_title', FALSE);
$handler->override_option('default_page_format', 'A4');
$handler->override_option('default_page_format_custom', '');
$handler->override_option('default_page_orientation', 'L');
$handler->override_option('unit', 'mm');
$handler->override_option('margin_left', '15');
$handler->override_option('margin_right', '15');
$handler->override_option('margin_top', '15');
$handler->override_option('margin_bottom', '15');
$handler->override_option('items_skip_print', '0');
$handler->override_option('items_per_print', '5');
$handler->override_option('pdf_file_name', 'Audit_Trail_Report');
$handler->override_option('leading_template', '');
$handler->override_option('template', '');
$handler->override_option('succeed_template', '');
$handler->override_option('default_font_family', 'helvetica');
$handler->override_option('default_font_style', array(
  'b' => 0,
  'i' => 0,
  'u' => 0,
  'd' => 0,
  'o' => 0,
));
$handler->override_option('default_font_size', '9');
$handler->override_option('default_text_align', 'L');
$handler->override_option('default_font_color', '000000');
$handler->override_option('default_text_hyphenate', 'none');
$handler->override_option('css_file', '');
$handler = $view->new_display('views_data_export', 'Data export CSV', 'views_data_export_1');
$handler->override_option('items_per_page', '0');
$handler->override_option('style_plugin', 'views_data_export_csv');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'attach_text' => 'CSV',
  'provide_file' => 1,
  'filename' => 'Audit_Trail_Report.csv',
  'help' => '',
  'parent_sort' => 0,
  'separator' => ',',
  'quote' => 1,
  'trim' => 0,
  'replace_newlines' => 0,
  'newline_replacement' => ', ',
  'header' => 1,
  'encoding' => '',
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'covidien/report/5/csv');
$handler->override_option('menu', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('displays', array());
$handler->override_option('sitename_title', FALSE);
$handler->override_option('use_batch', TRUE);
$handler = $view->new_display('views_data_export', 'Data export XLS', 'views_data_export_2');
$handler->override_option('items_per_page', '0');
$handler->override_option('style_plugin', 'views_data_export_xls');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'attach_text' => 'XLS',
  'provide_file' => 1,
  'filename' => 'Audit_Trail_Report.xls',
  'help' => '',
  'parent_sort' => 0,
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'covidien/report/5/xls');
$handler->override_option('menu', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('displays', array());
$handler->override_option('sitename_title', FALSE);
$handler->override_option('use_batch', TRUE);
$handler = $view->new_display('page', 'Page', 'page_1');
$handler->override_option('path', 'covidien/report/5');
$handler->override_option('menu', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
$handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
));
