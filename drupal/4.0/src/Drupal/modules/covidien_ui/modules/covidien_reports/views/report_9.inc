<?php
/**
 * @file
 * Report configuration view, Alert Event by Device Serial Number
 */
$view = new view;
$view->name = 'report_9';
$view->description = '';
$view->tag = '';
$view->base_table = 'alert';
$view->core = 6;
$view->api_version = '2';

/* Edit this to true to make a default view disabled initially */
$view->disabled = FALSE;

$handler = $view->new_display('default', 'Defaults', 'default');

$handler->override_option('fields', array(
    'create_time' => array(
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
        'id' => 'create_time',
        'table' => 'alert',
        'field' => 'create_time',
        'relationship' => 'none',
    ),
    'alert_reason' => array(
        'label' => 'alert_reason',
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
        'exclude' => 1,
        'id' => 'alert_reason',
        'table' => 'alert_type',
        'field' => 'name',
        'relationship' => 'none',
    ),
    'alert_description' => array(
        'label' => 'alert_reason',
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
        'exclude' => 1,
        'id' => 'alert_description',
        'table' => 'alert_type',
        'field' => 'description',
        'relationship' => 'none',
    ),

    'status' => array(
        'label' => 'Status',
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
        'id' => 'status',
        'table' => 'alert_status',
        'field' => 'name',
        'relationship' => 'none',
    )
));

$handler->override_option('filters', array(
    'serial_number' => array(
        'operator' => 'contains',
        'value' => '',
        'group' => '0',
        'exposed' => TRUE,
        'expose' => array(
            'use_operator' => 0,
            'operator' => 'serial_number_op',
            'identifier' => 'serial_number',
            'label' => 'alert: serial_number',
            'remember' => 0,
        ),
        'case' => 1,
        'id' => 'serial_number',
        'table' => 'alert',
        'field' => 'serial_number',
        'relationship' => 'none',
    ),

    'alert_type_id' => array(
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
            'operator' => 'alert_type_id_op',
            'identifier' => 'alert_type_id',
            'label' => 'alert: alert_type_id',
            'optional' => 1,
            'remember' => 0,
        ),
        'id' => 'alert_type_id',
        'table' => 'alert',
        'field' => 'alert_type_id',
        'relationship' => 'none',
    ),

    'alert_type_id' => array(
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
            'operator' => 'alert_type_id_op',
            'identifier' => 'alert_type_id',
            'label' => 'alert: alert_type_id',
            'optional' => 1,
            'remember' => 0,
        ),
        'id' => 'alert_type_id',
        'table' => 'alert',
        'field' => 'alert_type_id',
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
$handler->override_option('style_plugin', 'table');
$handler->override_option('style_options', array(
    'grouping' => '',
    'override' => 1,
    'sticky' => 0,
    'order' => 'asc',
    'summary' => '',
    'columns' => array(
        'serial_number' => 'serial_number',
        'alert_time' => 'alert_time',
    ),
    'info' => array(
        'serial_number' => array(
            'sortable' => 0,
            'separator' => '',
        ),
        'alert_time' => array(
            'sortable' => 0,
            'separator' => '',
        ),
    ),
    'default' => '-1',
));
$handler->override_option('exposed_block', TRUE);
$handler = $view->new_display('page', 'Page', 'page_1');
$handler->override_option('items_per_page', 10);
$handler->override_option('use_pager', '1');
$handler->override_option('path', 'covidien/report/9');
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
        'service_date' => array(
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
        'servicetype' => array(
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
        'to_component_nid' => array(
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
        'from_component_nid' => array(
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
        'to_component_nid_1' => array(
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
$handler->override_option('path', 'covidien/report/9/pdf/Service_Records_Report');
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
$handler->override_option('pdf_file_name', 'Service_Records_Report');
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
    'filename' => 'Service_Records_Report.csv',
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
$handler->override_option('path', 'covidien/report/9/csv');
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
    'filename' => 'Service_Records_Report.xls',
    'help' => '',
    'parent_sort' => 0,
));
$handler->override_option('row_plugin', '');
$handler->override_option('path', 'covidien/report/9/xls');
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
