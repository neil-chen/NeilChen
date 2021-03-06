<?php

$view = new view;
$view->name = 'user_download_level';
$view->description = 'user_download_level';
$view->tag = '';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'field_app_role_pk_nid' => array(
    'id' => 'field_app_role_pk_nid',
    'table' => 'node_data_field_app_role_pk',
    'field' => 'field_app_role_pk_nid',
  ),
));
$handler->override_option('fields', array(
  'field_app_role_pk_nid' => array(
    'id' => 'field_app_role_pk_nid',
    'table' => 'node_data_field_app_role_pk',
    'field' => 'field_app_role_pk_nid',
  ),
));
$handler->override_option('arguments', array(
  'field_person_pk_nid' => array(
    'id' => 'field_person_pk_nid',
    'table' => 'node_data_field_person_pk',
    'field' => 'field_person_pk_nid',
  ),
));
$handler->override_option('filters', array(
  'type' => array(
    'id' => 'type',
    'table' => 'node',
    'field' => 'type',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler = $view->new_display('page', 'Page', 'page_1');
$handler->override_option('relationships', array(
  'field_app_role_pk_nid' => array(
    'id' => 'field_app_role_pk_nid',
    'table' => 'node_data_field_app_role_pk',
    'field' => 'field_app_role_pk_nid',
  ),
  'field_person_pk_nid' => array(
    'label' => 'Person PK',
    'required' => 0,
    'delta' => '-1',
    'id' => 'field_person_pk_nid',
    'table' => 'node_data_field_person_pk',
    'field' => 'field_person_pk_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_role_product_line_nid' => array(
    'label' => 'Product Line',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_role_product_line_nid',
    'table' => 'node_data_field_role_product_line',
    'field' => 'field_role_product_line_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_app_role_pk_nid',
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
    'exclude' => 1,
    'id' => 'nid',
    'table' => 'node',
    'field' => 'nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'nid_1' => array(
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
    'exclude' => 1,
    'id' => 'nid_1',
    'table' => 'node',
    'field' => 'nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_person_pk_nid',
  ),
  'title_1' => array(
    'label' => 'Product Line',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 1,
      'path' => 'node/[nid]/edit/[nid_1]',
      'absolute' => 0,
      'link_class' => 'iframe',
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
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_role_product_line_nid',
  ),
  'title' => array(
    'label' => 'Role',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 0,
      'path' => 'node/[nid]/edit/[nid_1]',
      'absolute' => 0,
      'link_class' => 'iframe',
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
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_app_role_pk_nid',
  ),
  'field_max_download_level_value' => array(
    'label' => 'Installation Privilege',
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
    'id' => 'field_max_download_level_value',
    'table' => 'node_data_field_max_download_level',
    'field' => 'field_max_download_level_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('filters', array(
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'person_application_role' => 'person_application_role',
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
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_max_download_level_value' => array(
    'operator' => 'not empty',
    'value' => array(
      'value' => '',
      'min' => '',
      'max' => '',
    ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'id' => 'field_max_download_level_value',
    'table' => 'node_data_field_max_download_level',
    'field' => 'field_max_download_level_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('empty', '<table class="views-table cols-2" width="50%">
    <thead>
    <tr>
              <th class="views-field views-field-title-1">
          Product Line</th>
 <th class="views-field views-field-field-app-role-pk-nid">
          Role        </th>
              <th class="views-field views-field-field-max-download-level-value">
          Installation Privilege        </th>
          </tr>
  </thead>
  <tbody>
          <tr class="odd views-row-first views-row-last">
                  <td colspan="3">No Installation Privileges available</td>
              </tr>
      </tbody>
</table>');
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
    'nid' => 'nid',
    'nid_1' => 'nid_1',
    'title_1' => 'title_1',
    'title' => 'title',
    'field_max_download_level_value' => 'field_max_download_level_value',
  ),
  'info' => array(
    'nid' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'nid_1' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'title_1' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'title' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_max_download_level_value' => array(
      'sortable' => 1,
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
$handler->override_option('path', 'covidien/download_level');
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
