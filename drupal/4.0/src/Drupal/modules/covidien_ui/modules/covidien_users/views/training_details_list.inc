<?php

$view = new view;
$view->name = 'training_details_list';
$view->description = 'Training_details_list';
$view->tag = 'training_details_list';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'content_profile_rel' => array(
    'id' => 'content_profile_rel',
    'table' => 'users',
    'field' => 'content_profile_rel',
  ),
));
$handler->override_option('fields', array(
  'field_trainee_id_nid' => array(
    'id' => 'field_trainee_id_nid',
    'table' => 'node_data_field_trainee_id',
    'field' => 'field_trainee_id_nid',
  ),
));
$handler->override_option('arguments', array(
  'field_trainee_id_nid' => array(
    'id' => 'field_trainee_id_nid',
    'table' => 'node_data_field_trainee_id',
    'field' => 'field_trainee_id_nid',
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
  'content_profile_rel' => array(
    'id' => 'content_profile_rel',
    'table' => 'users',
    'field' => 'content_profile_rel',
  ),
  'field_trainee_id_nid' => array(
    'id' => 'field_trainee_id_nid',
    'table' => 'node_data_field_trainee_id',
    'field' => 'field_trainee_id_nid',
  ),
  'field_trainer_id_nid' => array(
    'label' => 'Trainer Name',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_trainer_id_nid',
    'table' => 'node_data_field_trainer_id',
    'field' => 'field_trainer_id_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_device_type_nid' => array(
    'label' => 'Device Type',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_device_type_nid',
    'table' => 'node_data_field_device_type',
    'field' => 'field_device_type_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_device_product_line_nid' => array(
    'label' => 'Product line ',
    'required' => 0,
    'delta' => '-1',
    'id' => 'field_device_product_line_nid',
    'table' => 'node_data_field_device_product_line',
    'field' => 'field_device_product_line_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_device_type_nid',
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
    'relationship' => 'field_trainee_id_nid',
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
    'relationship' => 'field_device_type_nid',
  ),
  'nid_2' => array(
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
    'id' => 'nid_2',
    'table' => 'node',
    'field' => 'nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'title' => array(
    'label' => 'Trainer User ID',
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
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_trainer_id_nid',
  ),
  'field_trainee_id_nid' => array(
    'label' => 'Trainer User ID',
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
    'exclude' => 1,
    'id' => 'field_trainee_id_nid',
    'table' => 'node_data_field_trainee_id',
    'field' => 'field_trainee_id_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_training_completion_date_value' => array(
    'label' => 'Date of Training',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 1,
      'path' => 'node/[nid_2]/edit/[nid]/mcot',
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
    'id' => 'field_training_completion_date_value',
    'table' => 'node_data_field_training_completion_date',
    'field' => 'field_training_completion_date_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'title_4' => array(
    'label' => 'Class of Trade',
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
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_device_product_line_nid',
  ),
  'title_1' => array(
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
    'link_to_node' => 0,
    'exclude' => 0,
    'id' => 'title_1',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_device_type_nid',
  ),
  'field_active_flag_value' => array(
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
    'id' => 'field_active_flag_value',
    'table' => 'node_data_field_active_flag',
    'field' => 'field_active_flag_value',
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
      'person_training_record' => 'person_training_record',
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
));
$handler->override_option('access', array(
  'type' => 'role',
  'role' => array(
    2 => 2,
  ),
));
$handler->override_option('empty', '<table class="views-table cols-4">
    <thead>
    <tr>
              <th class="views-field views-field-field-trainee-id-nid">
          Trainer User ID        </th>
              <th class="views-field views-field-field-training-completion-date-value">
          Date of Training        </th>
 <th class="views-field views-field-field-device-type-nid">
          Class of Trade        </th>
              <th class="views-field views-field-field-device-type-nid">
          Device Type        </th>
              <th class="views-field views-field-field-active-flag-value">
          Status        </th>
          </tr>
  </thead>
  <tbody>
          <tr class="odd views-row-first">
                  <td colspan="5">No Training Records available</td>
              </tr>
      </tbody>
</table>');
$handler->override_option('empty_format', '2');
$handler->override_option('use_pager', '1');
$handler->override_option('distinct', 1);
$handler->override_option('style_plugin', 'table');
$handler->override_option('style_options', array(
  'grouping' => '',
  'override' => 1,
  'sticky' => 0,
  'order' => 'asc',
  'summary' => '',
  'columns' => array(
    'title_2' => 'title_2',
    'title_3' => 'title_3',
    'nid' => 'nid',
    'nid_1' => 'nid_1',
    'title' => 'title',
    'field_trainee_id_nid' => 'field_trainee_id_nid',
    'field_training_completion_date_value' => 'field_training_completion_date_value',
    'title_4' => 'title_4',
    'title_1' => 'title_1',
    'field_active_flag_value' => 'field_active_flag_value',
  ),
  'info' => array(
    'title_2' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'title_3' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'nid' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'nid_1' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'title' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_trainee_id_nid' => array(
      'separator' => '',
    ),
    'field_training_completion_date_value' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'title_4' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'title_1' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_active_flag_value' => array(
      'sortable' => 1,
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
$handler->override_option('path', 'covidien/training_details');
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
