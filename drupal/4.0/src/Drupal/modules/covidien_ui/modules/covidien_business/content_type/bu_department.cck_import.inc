$content['type']  = array (
  'name' => 'BU Department',
  'type' => 'bu_department',
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
  'language_content_type' => 0,
  'old_type' => 'bu_department',
  'orig_type' => '',
  'module' => 'node',
  'custom' => '1',
  'modified' => '1',
  'locked' => '0',
  'content_profile_use' => false,
  'comment' => '2',
  'comment_default_mode' => '4',
  'comment_default_order' => '1',
  'comment_default_per_page' => '50',
  'comment_controls' => '3',
  'comment_anonymous' => 0,
  'comment_subject_field' => '1',
  'comment_preview' => '1',
  'comment_form_location' => '0',
);
$content['fields']  = array (
  0 => 
  array (
    'label' => 'Business Unit',
    'field_name' => 'field_business_unit_pk',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_select',
    'change' => 'Change basic information',
    'weight' => '31',
    'autocomplete_match' => 'contains',
    'size' => 60,
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'nid' => '',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => NULL,
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'referenceable_types' => 
    array (
      'bu_department' => 0,
      'business_unit' => 0,
      'customer_account_number' => 0,
      'department' => 0,
      'device' => 0,
      'language' => 0,
      'operating_company' => 0,
      'page' => 0,
      'panel' => 0,
      'party' => 0,
      'party_type' => 0,
      'person' => 0,
      'product_line' => 0,
      'region' => 0,
      'roles' => 0,
      'story' => 0,
      'email_notifications' => 0,
      'user_log' => 0,
      'user_settings' => 0,
      'bu_customer' => false,
      'customer_facility' => false,
      'devicetype' => false,
      'device_service_history' => false,
      'device_installation' => false,
      'device_service_type' => false,
      'component_option_type' => false,
      'country' => false,
      'device_component_history' => false,
      'device_discrepancy' => false,
      'device_notification_subscription' => false,
      'device_notification_type' => false,
      'device_type_config' => false,
      'document' => false,
      'document_type' => false,
      'hardwaretype' => false,
      'location' => false,
      'party_email_address' => false,
      'profile' => false,
      'software' => false,
      'softwarestatus' => false,
      'softwaretype' => false,
      'device_config_hardware' => false,
      'device_config_software' => false,
      'hardware' => false,
    ),
    'advanced_view' => 'business_unit_department',
    'advanced_view_args' => '',
    'op' => 'Save field settings',
    'module' => 'nodereference',
    'widget_module' => 'nodereference',
    'columns' => 
    array (
      'nid' => 
      array (
        'type' => 'int',
        'unsigned' => true,
        'not null' => false,
        'index' => true,
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
    'label' => 'Department',
    'field_name' => 'field_department_pk',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_select',
    'change' => 'Change basic information',
    'weight' => '32',
    'autocomplete_match' => 'contains',
    'size' => 60,
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'nid' => '',
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => NULL,
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'referenceable_types' => 
    array (
      'bu_department' => 0,
      'business_unit' => 0,
      'customer_account_number' => 0,
      'department' => 0,
      'device' => 0,
      'language' => 0,
      'operating_company' => 0,
      'page' => 0,
      'panel' => 0,
      'party' => 0,
      'party_type' => 0,
      'person' => 0,
      'product_line' => 0,
      'roles' => 0,
      'story' => 0,
      'email_notifications' => 0,
      'user_log' => 0,
      'user_settings' => 0,
      'bu_customer' => false,
      'customer_facility' => false,
      'devicetype' => false,
      'device_service_history' => false,
      'device_installation' => false,
      'device_service_type' => false,
      'region' => false,
      'component_option_type' => false,
      'country' => false,
      'device_component_history' => false,
      'device_discrepancy' => false,
      'device_notification_subscription' => false,
      'device_notification_type' => false,
      'device_type_config' => false,
      'document' => false,
      'document_type' => false,
      'hardwaretype' => false,
      'location' => false,
      'party_email_address' => false,
      'profile' => false,
      'software' => false,
      'softwarestatus' => false,
      'softwaretype' => false,
      'device_config_hardware' => false,
      'device_config_software' => false,
      'hardware' => false,
    ),
    'advanced_view' => 'department_party_dropdown',
    'advanced_view_args' => '',
    'op' => 'Save field settings',
    'module' => 'nodereference',
    'widget_module' => 'nodereference',
    'columns' => 
    array (
      'nid' => 
      array (
        'type' => 'int',
        'unsigned' => true,
        'not null' => false,
        'index' => true,
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
