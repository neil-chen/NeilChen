<?php

/**
 * @file
 * Report configuration view, Software Upgrade Report.
 */
$view = new view;
$view->name = 'report_2';
$view->description = 'Software Upgrade Report';
$view->tag = '';
$view->base_table = 'device_software_upgrade_view';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('fields', array(
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
    'hide_alter_empty' => 1,
    'exclude' => 0,
    'id' => 'customername',
    'table' => 'device_software_upgrade_view',
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
    'table' => 'device_software_upgrade_view',
    'field' => 'deviceserial',
    'relationship' => 'none',
  ),
  'SW_upgrade_status' => array(
    'label' => 'SW Upgrade Status',
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
    'id' => 'SW_upgrade_status',
    'table' => 'device_software_upgrade_view',
    'field' => 'SW_upgrade_status',
    'relationship' => 'none',
  ),
  'Attempts' => array(
    'label' => '# of Tries',
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
    'id' => 'Attempts',
    'table' => 'device_software_upgrade_view',
    'field' => 'Attempts',
    'relationship' => 'none',
    'override' => array(
      'button' => 'Override',
    ),
  ),
  'Prior_SW_Version' => array(
    'label' => 'Prior SW Version',
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
    'id' => 'Prior_SW_Version',
    'table' => 'device_software_upgrade_view',
    'field' => 'Prior_SW_Version',
    'relationship' => 'none',
  ),
  'New_SW_Version' => array(
    'label' => 'New SW Version',
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
    'id' => 'New_SW_Version',
    'table' => 'device_software_upgrade_view',
    'field' => 'New_SW_Version',
    'relationship' => 'none',
  ),
  'Event_datetime' => array(
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
    'set_precision' => FALSE,
    'precision' => 0,
    'decimal' => '.',
    'separator' => ',',
    'format_plural' => 0,
    'format_plural_singular' => '1',
    'format_plural_plural' => '@count',
    'prefix' => '',
    'suffix' => '',
    'id' => 'Event_datetime',
    'table' => 'device_software_upgrade_view',
    'field' => 'Event_datetime',
    'relationship' => 'none',
    'override' => array(
      'button' => 'Override',
    ),
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
    'exclude' => 0,
    'id' => 'service_person',
    'table' => 'device_software_upgrade_view',
    'field' => 'service_person',
    'relationship' => 'none',
  ),
  'country_name' => array(
    'label' => 'Country',
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
    'id' => 'country_name',
    'table' => 'device_software_upgrade_view',
    'field' => 'country_name',
    'relationship' => 'none',
  ),
  'devicetype' => array(
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
    'id' => 'devicetype',
    'table' => 'device_software_upgrade_view',
    'field' => 'devicetype',
    'relationship' => 'none',
  ),
));
$handler->override_option('filters', array(
  'SW_upgrade_status' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'SW_upgrade_status_op',
      'identifier' => 'SW_upgrade_status',
      'label' => 'device_software_upgrade_view: SW_upgrade_status',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'SW_upgrade_status',
    'table' => 'device_software_upgrade_view',
    'field' => 'SW_upgrade_status',
    'override' => array(
      'button' => 'Override',
    ),
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
      'label' => 'device_software_upgrade_view: accountnumber',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'accountnumber',
    'table' => 'device_software_upgrade_view',
    'field' => 'accountnumber',
    'override' => array(
      'button' => 'Override',
    ),
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
      'label' => 'device_software_upgrade_view: customername',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'customername',
    'table' => 'device_software_upgrade_view',
    'field' => 'customername',
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
      'label' => 'device_software_upgrade_view: devicetype_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'devicetype_nid',
    'table' => 'device_software_upgrade_view',
    'field' => 'devicetype_nid',
    'override' => array(
      'button' => 'Override',
    ),
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
      'label' => 'device_software_upgrade_view: productline_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'productline_nid',
    'table' => 'device_software_upgrade_view',
    'field' => 'productline_nid',
    'override' => array(
      'button' => 'Override',
    ),
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
      'label' => 'device_software_upgrade_view: country_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'country_nid',
    'table' => 'device_software_upgrade_view',
    'field' => 'country_nid',
    'relationship' => 'none',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('items_per_page', 0);
$handler->override_option('link_display', 'page_1');
$handler->override_option('style_plugin', 'table');
$handler->override_option('style_options', array(
  'grouping' => '',
  'override' => 1,
  'sticky' => 0,
  'order' => 'asc',
  'summary' => '',
  'columns' => array(
    'customername' => 'customername',
  ),
  'info' => array(
    'customername' => array(
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
$handler->override_option('exposed_block', TRUE);
$handler = $view->new_display('pdf', 'PDF Page', 'pdf_1');
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
    'SW_upgrade_status' => array(
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
    'Attempts' => array(
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
    'Prior_SW_Version' => array(
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
    'New_SW_Version' => array(
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
    'Event_datetime' => array(
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
    'Event_datetime_1' => array(
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
$handler->override_option('path', 'covidien/report/2/pdf/Software_Upgrade_Report');
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
$handler->override_option('items_per_print', '10');
$handler->override_option('pdf_file_name', 'Software_Upgrade_Report');
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
$handler = $view->new_display('page', 'Page', 'page_1');
$handler->override_option('items_per_page', 10);
$handler->override_option('use_pager', '1');
$handler->override_option('path', 'covidien/report/2');
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
$handler = $view->new_display('views_data_export', 'Data export csv', 'views_data_export_1');
$handler->override_option('items_per_page', '0');
$handler->override_option('style_plugin', 'views_data_export_csv');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'attach_text' => 'CSV',
  'provide_file' => 1,
  'filename' => 'Software_Upgrade_Report.csv',
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
$handler->override_option('path', 'covidien/report/2/csv');
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
  'filename' => 'Software_Upgrade_Report.xls',
  'help' => '',
  'parent_sort' => 0,
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'covidien/report/2/xls');
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
$handler = $view->new_display('views_data_export', 'Data export xlsx', 'views_data_export_3');
$handler->override_option('items_per_page', '0');
$handler->override_option('style_plugin', 'views_data_export_csv');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'attach_text' => 'XLSX',
  'provide_file' => 1,
  'filename' => 'Software_Upgrade_Report.xlsx',
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
$handler->override_option('path', 'covidien/report/2/xlsx');
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
