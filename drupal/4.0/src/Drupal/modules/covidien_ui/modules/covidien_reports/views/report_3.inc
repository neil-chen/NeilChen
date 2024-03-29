<?php

/**
 * @file
 * Report configuration view, Component Discrepancy Report.
 */
$view = new view;
$view->name = 'report_3';
$view->description = 'component discrepancy list';
$view->tag = '';
$view->base_table = 'device_component_discrepancy_view';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('fields', array(
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
      'word_boundary' => 0,
      'ellipsis' => 0,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'exclude' => 0,
    'id' => 'deviceserial',
    'table' => 'device_component_discrepancy_view',
    'field' => 'deviceserial',
    'override' => array(
      'button' => 'Override',
    ),
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
    'hide_alter_empty' => 1,
    'exclude' => 0,
    'id' => 'customername',
    'table' => 'device_component_discrepancy_view',
    'field' => 'customername',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
  'accountnumber' => array(
    'label' => 'Customer Account Number',
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
    'id' => 'accountnumber',
    'table' => 'device_component_discrepancy_view',
    'field' => 'accountnumber',
    'relationship' => 'none',
  ),
  'component_name' => array(
    'label' => 'Component Name',
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
    'id' => 'component_name',
    'table' => 'device_component_discrepancy_view',
    'field' => 'component_name',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
  'component_type' => array(
    'label' => 'Component Type',
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
      'word_boundary' => 0,
      'ellipsis' => 0,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'exclude' => 0,
    'id' => 'component_type',
    'table' => 'device_component_discrepancy_view',
    'field' => 'component_type',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
  'part_value' => array(
    'label' => 'Part Number',
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
      'word_boundary' => 0,
      'ellipsis' => 0,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'exclude' => 0,
    'id' => 'part_value',
    'table' => 'device_component_discrepancy_view',
    'field' => 'part_value',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
  'new_version' => array(
    'label' => 'Expected Version',
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
      'word_boundary' => 0,
      'ellipsis' => 0,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'exclude' => 0,
    'id' => 'new_version',
    'table' => 'device_component_discrepancy_view',
    'field' => 'new_version',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
  'previous_version' => array(
    'label' => ' Discrepancy Version',
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
      'word_boundary' => 0,
      'ellipsis' => 0,
      'html' => 0,
      'strip_tags' => 0,
    ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'hide_alter_empty' => 1,
    'exclude' => 0,
    'id' => 'previous_version',
    'table' => 'device_component_discrepancy_view',
    'field' => 'previous_version',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('filters', array(
  'deviceserial_1' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'deviceserial_1_op',
      'identifier' => 'deviceserial',
      'label' => 'device_component_discrepancy_view: deviceserial',
      'remember' => 0,
    ),
    'case' => 0,
    'id' => 'deviceserial_1',
    'table' => 'device_component_discrepancy_view',
    'field' => 'deviceserial',
    'override' => array(
      'button' => 'Override',
    ),
    'relationship' => 'none',
  ),
  'customername' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'customername_op',
      'identifier' => 'customer_nid',
      'label' => 'device_component_discrepancy_view: customername',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'customername',
    'table' => 'device_component_discrepancy_view',
    'field' => 'customername',
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
      'label' => 'device_component_discrepancy_view: accountnumber',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'accountnumber',
    'table' => 'device_component_discrepancy_view',
    'field' => 'accountnumber',
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
      'label' => 'device_component_discrepancy_view: devicetype_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'devicetype_nid',
    'table' => 'device_component_discrepancy_view',
    'field' => 'devicetype_nid',
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
      'label' => 'device_component_discrepancy_view: country_nid',
      'optional' => 1,
      'remember' => 0,
    ),
    'id' => 'country_nid',
    'table' => 'device_component_discrepancy_view',
    'field' => 'country_nid',
    'override' => array(
      'button' => 'Override',
    ),
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
    'component_name' => 'component_name',
    'component_type' => 'component_type',
    'part_value' => 'part_value',
    'previous_version' => 'previous_version',
    'new_version' => 'new_version',
  ),
  'info' => array(
    'component_name' => array(
      'separator' => '',
    ),
    'component_type' => array(
      'separator' => '',
    ),
    'part_value' => array(
      'separator' => '',
    ),
    'previous_version' => array(
      'separator' => '',
    ),
    'new_version' => array(
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
$handler->override_option('exposed_block', TRUE);
$handler = $view->new_display('page', 'Page', 'page_1');
$handler->override_option('use_pager', '1');
$handler->override_option('style_options', array(
  'grouping' => '',
  'override' => 1,
  'sticky' => 0,
  'order' => 'asc',
  'summary' => '',
  'columns' => array(
    'deviceserial' => 'deviceserial',
    'customername' => 'customername',
    'component_name' => 'component_name',
    'component_type' => 'component_type',
    'part_value' => 'part_value',
    'previous_version' => 'previous_version',
    'new_version' => 'new_version',
  ),
  'info' => array(
    'deviceserial' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'customername' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'component_name' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'component_type' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'part_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'previous_version' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'new_version' => array(
      'sortable' => 0,
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
$handler->override_option('path', 'covidien/report/3');
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
$handler = $view->new_display('pdf', 'PDF Page', 'pdf_2');
$handler->override_option('items_per_page', 0);
$handler->override_option('style_plugin', 'pdf_table');
$handler->override_option('style_options', array(
  'mission_description' => FALSE,
  'description' => '',
  'info' => array(
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
    'component_name' => array(
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
    'component_type' => array(
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
    'part_value' => array(
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
    'previous_version' => array(
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
    'new_version' => array(
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
$handler->override_option('path', 'covidien/report/3/pdf/Component_Discrepancy_Report');
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
$handler->override_option('pdf_file_name', 'Component_Discrepancy_Report');
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
  'filename' => 'Component_Discrepancy_Report.csv',
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
$handler->override_option('path', 'covidien/report/3/csv');
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
  'filename' => 'Component_Discrepancy_Report.xls',
  'help' => '',
  'parent_sort' => 0,
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'covidien/report/3/xls');
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
