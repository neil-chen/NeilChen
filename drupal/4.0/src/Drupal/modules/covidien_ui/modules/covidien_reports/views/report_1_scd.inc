<?php

/**
 * @file
 * Report configuration view, Device Configuration Report SCD.
 */
$view = new view;
$view->name = 'report_1_scd';
$view->description = '';
$view->tag = '';
$view->base_table = 'device_scd700_software_version_view';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('fields', array(
  'device_nid' => array(
    'label' => 'device_nid',
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
    'set_precision' => FALSE,
    'precision' => 0,
    'decimal' => '.',
    'separator' => ',',
    'format_plural' => 0,
    'format_plural_singular' => '1',
    'format_plural_plural' => '@count',
    'prefix' => '',
    'suffix' => '',
    'exclude' => 1,
    'id' => 'device_nid',
    'table' => 'device_scd700_software_version_view',
    'field' => 'device_nid',
    'relationship' => 'none',
  ),
  'customername' => array(
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
    'hide_alter_empty' => 0,
    'exclude' => 0,
    'id' => 'customername',
    'table' => 'device_scd700_software_version_view',
    'field' => 'customername',
    'relationship' => 'none',
  ),
  'deviceserial' => array(
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
    'id' => 'deviceserial',
    'table' => 'device_scd700_software_version_view',
    'field' => 'deviceserial',
    'relationship' => 'none',
  ),
  'hardware_version' => array(
    'label' => 'Control Board',
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
    'hide_alter_empty' => 0,
    'exclude' => 0,
    'id' => 'hardware_version',
    'table' => 'device_scd700_software_version_view',
    'field' => 'hardware_version',
    'relationship' => 'none',
  ),
  'software_version' => array(
    'label' => 'S/W  Version',
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
    'hide_alter_empty' => 0,
    'exclude' => 0,
    'id' => 'software_version',
    'table' => 'device_scd700_software_version_view',
    'field' => 'software_version',
    'relationship' => 'none',
  ),
  'lastest_sw_update' => array(
    'label' => 'Configuration Reported Date & Time',
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
    'set_precision' => FALSE,
    'precision' => 0,
    'decimal' => '.',
    'separator' => ',',
    'format_plural' => 0,
    'format_plural_singular' => '1',
    'format_plural_plural' => '@count',
    'prefix' => '',
    'suffix' => '',
    'id' => 'lastest_sw_update',
    'table' => 'device_scd700_software_version_view',
    'field' => 'lastest_sw_update',
    'relationship' => 'none',
  ),
  'service_person' => array(
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
    'set_precision' => FALSE,
    'precision' => 0,
    'decimal' => '.',
    'separator' => ',',
    'format_plural' => 0,
    'format_plural_singular' => '1',
    'format_plural_plural' => '@count',
    'prefix' => '',
    'suffix' => '',
    'exclude' => 0,
    'id' => 'service_person',
    'table' => 'device_scd700_software_version_view',
    'field' => 'service_person',
    'relationship' => 'none',
  ),
));
$handler->override_option('filters', array(
  'software_name' => array(
    'operator' => '=',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'software_name_op',
      'identifier' => 'software_name',
      'label' => 'device_scd700_software_version_view: software_name',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'software_name',
    'table' => 'device_scd700_software_version_view',
    'field' => 'software_name',
    'relationship' => 'none',
  ),
  'hardware_name' => array(
    'operator' => '=',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'hardware_name_op',
      'identifier' => 'hardware_name',
      'label' => 'device_scd700_software_version_view: hardware_name',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'hardware_name',
    'table' => 'device_scd700_software_version_view',
    'field' => 'hardware_name',
    'relationship' => 'none',
  ),
  'productline_nid' => array(
    'operator' => '=',
    'value' => array(
      'value' => '',
      'min' => '',
      'max' => '',
    ),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'productline_nid_op',
      'identifier' => 'productline_nid',
      'label' => 'device_scd700_software_version_view: productline_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'productline_nid',
    'table' => 'device_scd700_software_version_view',
    'field' => 'productline_nid',
    'relationship' => 'none',
  ),
  'devicetype_nid' => array(
    'operator' => '=',
    'value' => array(
      'value' => '',
      'min' => '',
      'max' => '',
    ),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'devicetype_nid_op',
      'identifier' => 'devicetype_nid',
      'label' => 'device_scd700_software_version_view: devicetype_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'devicetype_nid',
    'table' => 'device_scd700_software_version_view',
    'field' => 'devicetype_nid',
    'relationship' => 'none',
  ),
  'accountnumber' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'accountnumber_op',
      'identifier' => 'accountnumber',
      'label' => 'device_scd700_software_version_view: accountnumber',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'accountnumber',
    'table' => 'device_scd700_software_version_view',
    'field' => 'accountnumber',
    'relationship' => 'none',
  ),
  'software_part' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'software_part_op',
      'identifier' => 'software_part',
      'label' => 'device_scd700_software_version_view: software_part',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'software_part',
    'table' => 'device_scd700_software_version_view',
    'field' => 'software_part',
    'relationship' => 'none',
  ),
  'software_version' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'software_version_op',
      'identifier' => 'software_version',
      'label' => 'device_scd700_software_version_view: software_version',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'software_version',
    'table' => 'device_scd700_software_version_view',
    'field' => 'software_version',
    'relationship' => 'none',
  ),
  'deviceserial' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'deviceserial_op',
      'identifier' => 'deviceserial',
      'label' => 'device_scd700_software_version_view: deviceserial',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'deviceserial',
    'table' => 'device_scd700_software_version_view',
    'field' => 'deviceserial',
    'relationship' => 'none',
  ),
  'customername' => array(
    'operator' => '=',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'customername_op',
      'identifier' => 'customer_nid',
      'label' => 'device_scd700_software_version_view: customername',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'customername',
    'table' => 'device_scd700_software_version_view',
    'field' => 'customername',
    'relationship' => 'none',
  ),
  'country_nid' => array(
    'operator' => '=',
    'value' => array(
      'value' => '',
      'min' => '',
      'max' => '',
    ),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'country_nid_op',
      'identifier' => 'country',
      'label' => 'device_scd700_software_version_view: country_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'country_nid',
    'table' => 'device_scd700_software_version_view',
    'field' => 'country_nid',
    'relationship' => 'none',
  ),
  'hardware_part' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'hardware_part_op',
      'identifier' => 'hardware_part',
      'label' => 'device_scd700_software_version_view: hardware_part',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'hardware_part',
    'table' => 'device_scd700_software_version_view',
    'field' => 'hardware_part',
    'relationship' => 'none',
  ),
  'hardware_version' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'hardware_version_op',
      'identifier' => 'hardware_version',
      'label' => 'device_scd700_software_version_view: hardware_version',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'hardware_version',
    'table' => 'device_scd700_software_version_view',
    'field' => 'hardware_version',
    'relationship' => 'none',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('header_format', '1');
$handler->override_option('header_empty', 0);
$handler->override_option('footer_format', '2');
$handler->override_option('footer_empty', 0);
$handler->override_option('style_plugin', 'table');
$handler->override_option('style_options', array(
  'grouping' => '',
  'override' => 1,
  'sticky' => 0,
  'order' => 'asc',
  'summary' => '',
  'columns' => array(
    'DeviceSerial' => 'DeviceSerial',
    'DeviceType' => 'DeviceType',
    'Region' => 'Region',
    'productLine' => 'productLine',
  ),
  'info' => array(
    'DeviceSerial' => array(
      'separator' => '',
    ),
    'DeviceType' => array(
      'separator' => '',
    ),
    'Region' => array(
      'separator' => '',
    ),
    'productLine' => array(
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
$handler->override_option('exposed_block', TRUE);
$handler = $view->new_display('page', 'Page', 'page_1');
$handler->override_option('use_pager', '1');
$handler->override_option('path', 'covidien/report/1/scd');
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
$handler = $view->new_display('pdf', 'PDF Page', 'pdf_1');
$handler->override_option('items_per_page', 0);
$handler->override_option('style_plugin', 'pdf_table');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'info' => array(
    'customername' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
    'devicetype' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
    'deviceserial' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
    'hardware_version' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
    'hardware1_version' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
    'software_version' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
    'lastest_sw_update' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
    'service_person' => array(
      'header_style' => array(
        'text' => array(
          'font_size' => '',
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
          'font_style' => array(
            'b' => 0,
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
      'position' => array(
        'width' => '',
      ),
    ),
  ),
  'position' => array(
    'last_writing_position' => 1,
    'x' => '',
    'y' => '',
    'width' => '',
    'row_height' => '',
  ),
  'grouping' => '',
));
$handler->override_option('row_plugin', 'pdf_fields');
$handler->override_option('path', 'covidien/report/1/scd/pdf/Device_Current_Configuration_Report');
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
$handler->override_option('items_skip_print', '3');
$handler->override_option('items_per_print', '10');
$handler->override_option('pdf_file_name', 'Device_Current_Configuration_Report');
$handler->override_option('leading_template', '');
$handler->override_option('template', '');
$handler->override_option('succeed_template', '');
$handler->override_option('default_font_family', 'helvetica');
$handler->override_option('default_font_style', array());
$handler->override_option('default_font_size', '11');
$handler->override_option('default_text_align', 'L');
$handler->override_option('default_font_color', '000000');
$handler->override_option('default_text_hyphenate', 'none');
$handler->override_option('css_file', '');
$handler = $view->new_display('views_data_export', 'Data export csv', 'views_data_export_1');
$handler->override_option('items_per_page', '0');
$handler->override_option('style_plugin', 'views_data_export_csv');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'attach_text' => 'CSV',
  'provide_file' => 1,
  'filename' => 'Device_Current_Configuration_Report.csv',
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
$handler->override_option('path', 'covidien/report/1/scd/csv');
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
$handler = $view->new_display('views_data_export', 'Data export xls', 'views_data_export_2');
$handler->override_option('items_per_page', '0');
$handler->override_option('style_plugin', 'views_data_export_xls');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'attach_text' => 'XLS',
  'provide_file' => 1,
  'filename' => 'Device_Current_Configuration_Report.xls',
  'help' => '',
  'parent_sort' => 0,
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'covidien/report/1/scd/xls');
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
$handler = $view->new_display('views_data_export', 'Data export doc', 'views_data_export_3');
$handler->override_option('items_per_page', '0');
$handler->override_option('style_plugin', 'views_data_export_doc');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'attach_text' => 'Word Document',
  'provide_file' => 1,
  'filename' => '%view.doc',
  'help' => '',
  'parent_sort' => 0,
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'covidien/report/1/scd/doc');
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
