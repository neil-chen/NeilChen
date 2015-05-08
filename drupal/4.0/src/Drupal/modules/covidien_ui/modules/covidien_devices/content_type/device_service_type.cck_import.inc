$content['type']  = array (
  'name' => 'Device_service_type',
  'type' => 'device_service_type',
  'description' => '',
  'title_label' => 'Title',
  'body_label' => 'Body',
  'min_word_count' => '0',
  'help' => '',
  'node_options' => 
  array (
    'status' => true,
    'promote' => true,
    'sticky' => false,
    'revision' => false,
  ),
  'old_type' => 'device_service_type',
  'orig_type' => '',
  'module' => 'node',
  'custom' => '1',
  'modified' => '1',
  'locked' => '0',
  'content_profile_use' => 0,
  'comment' => '2',
  'comment_default_mode' => '4',
  'comment_default_order' => '1',
  'comment_default_per_page' => '50',
  'comment_controls' => '3',
  'comment_anonymous' => 0,
  'comment_subject_field' => '1',
  'comment_preview' => '1',
  'comment_form_location' => '0',
  'npbr_default_view_perms' => 
  array (
    1 => false,
    2 => false,
    7 => false,
    13 => false,
    16 => false,
    14 => false,
    15 => false,
    10 => false,
    9 => false,
    3 => false,
    11 => false,
    5 => false,
    12 => false,
    4 => false,
    8 => false,
  ),
  'npbr_default_edit_perms' => 
  array (
    1 => false,
    2 => false,
    7 => false,
    13 => false,
    16 => false,
    14 => false,
    15 => false,
    10 => false,
    9 => false,
    3 => false,
    11 => false,
    5 => false,
    12 => false,
    4 => false,
    8 => false,
  ),
  'npbr_default_delete_perms' => 
  array (
    1 => false,
    2 => false,
    7 => false,
    13 => false,
    16 => false,
    14 => false,
    15 => false,
    10 => false,
    9 => false,
    3 => false,
    11 => false,
    5 => false,
    12 => false,
    4 => false,
    8 => false,
  ),
  'npbr_default_grant_perms' => 
  array (
    1 => false,
    2 => false,
    7 => false,
    13 => false,
    16 => false,
    14 => false,
    15 => false,
    10 => false,
    9 => false,
    3 => false,
    11 => false,
    5 => false,
    12 => false,
    4 => false,
    8 => false,
  ),
);
$content['fields']  = array (
  0 => 
  array (
    'label' => 'description',
    'field_name' => 'field_service_description',
    'type' => 'text',
    'widget_type' => 'text_textfield',
    'change' => 'Change basic information',
    'weight' => '32',
    'rows' => 5,
    'size' => '60',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_service_description][0][value',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => NULL,
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'op' => 'Save field settings',
    'module' => 'text',
    'widget_module' => 'text',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'text',
        'size' => 'big',
        'not null' => false,
        'sortable' => true,
        'views' => true,
      ),
    ),
    'display_settings' => 
    array (
      'label' => 
      array (
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  1 => 
  array (
    'label' => 'Sort sequence',
    'field_name' => 'field_sort_sequence',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '34',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_sort_sequence][0][value',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => NULL,
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'min' => '',
    'max' => '',
    'prefix' => '',
    'suffix' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'op' => 'Save field settings',
    'module' => 'number',
    'widget_module' => 'number',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'int',
        'not null' => false,
        'sortable' => true,
      ),
    ),
    'display_settings' => 
    array (
      'label' => 
      array (
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  2 => 
  array (
    'label' => 'Is Active',
    'field_name' => 'field_is_active',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '36',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_is_active][0][value',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => NULL,
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'min' => '1',
    'max' => '2',
    'prefix' => '',
    'suffix' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'op' => 'Save field settings',
    'module' => 'number',
    'widget_module' => 'number',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'int',
        'not null' => false,
        'sortable' => true,
      ),
    ),
    'display_settings' => 
    array (
      'label' => 
      array (
        'format' => 'above',
        'exclude' => 0,
      ),
      'teaser' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      4 => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
);
$content['extra']  = array (
  'title' => '-5',
  'body_field' => '0',
  'revision_information' => '20',
  'author' => '20',
  'options' => '25',
  'comment_settings' => '30',
  'menu' => '-2',
  'path' => '30',
);
