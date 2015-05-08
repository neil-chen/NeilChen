$content['type']  = array (
  'name' => 'person_application_role',
  'type' => 'person_application_role',
  'description' => '',
  'title_label' => 'Title',
  'body_label' => '',
  'min_word_count' => '0',
  'help' => '',
  'node_options' => 
  array (
    'status' => true,
    'promote' => false,
    'sticky' => false,
    'revision' => false,
  ),
  'language_content_type' => '0',
  'old_type' => 'person_application_role',
  'orig_type' => '',
  'module' => 'node',
  'custom' => '1',
  'modified' => '1',
  'locked' => '0',
  'content_profile_use' => false,
  'comment' => '0',
  'comment_default_mode' => '4',
  'comment_default_order' => '1',
  'comment_default_per_page' => '50',
  'comment_controls' => '3',
  'comment_anonymous' => 0,
  'comment_subject_field' => '1',
  'comment_preview' => '1',
  'comment_form_location' => '0',
  'unique_field_fields' => 
  array (
    'title' => false,
    'name' => false,
    'field_person_pk' => false,
    'field_app_role_pk' => false,
    'field_max_download_level' => false,
    'field_person_role_default' => false,
  ),
  'unique_field_scope' => 'type',
  'unique_field_comp' => 'each',
  'unique_field_show_matches' => 
  array (
    'show_matches' => false,
  ),
);
$content['fields']  = array (
  0 => 
  array (
    'label' => 'Person PK',
    'field_name' => 'field_person_pk',
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
    'multiple' => '1',
    'referenceable_types' => 
    array (
      'person' => 'person',
      'access_option' => 0,
      'address_type' => 0,
      'app_section' => 0,
      'app_role_access_policy' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'business_unit' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_discrepancy' => 0,
      'device_embargo' => 0,
      'device_log' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_setting_history' => 0,
      'devicetype' => 0,
      'device_language_availability' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_type_config' => 0,
      'device_service_history' => 0,
      'device_installation' => 0,
      'device_service_type' => 0,
      'document' => 0,
      'document_type' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party_contact' => 0,
      'party' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'person_training_record' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'product_line_report' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'software_approval_unavailable' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'story' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'device_user_privileges' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'person_application_role' => 0,
      'user_settings' => 0,
    ),
    'advanced_view' => '--',
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
    ),
  ),
  1 => 
  array (
    'label' => 'App Role PK',
    'field_name' => 'field_app_role_pk',
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
    'multiple' => '1',
    'referenceable_types' => 
    array (
      'access_option' => 0,
      'address_type' => 0,
      'app_section' => 0,
      'app_role_access_policy' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'business_unit' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_discrepancy' => 0,
      'device_embargo' => 0,
      'device_log' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_setting_history' => 0,
      'devicetype' => 0,
      'device_language_availability' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_type_config' => 0,
      'device_service_history' => 0,
      'device_installation' => 0,
      'device_service_type' => 0,
      'document' => 0,
      'document_type' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party_contact' => 0,
      'party' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'person' => 0,
      'person_training_record' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'product_line_report' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'software_approval_unavailable' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'story' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'person_application_role' => 0,
      'user_settings' => 0,
      'device_user_privileges' => false,
    ),
    'advanced_view' => 'roles_with_expirydate',
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
    ),
  ),
  2 => 
  array (
    'label' => 'Allowed Download Level',
    'field_name' => 'field_max_download_level',
    'type' => 'number_integer',
    'widget_type' => 'optionwidgets_select',
    'change' => 'Change basic information',
    'weight' => '34',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
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
    'allowed_values_php' => 'return(array(\'0\'=>\'None\',\'1\'=>\'Latest version only\',\'2\'=>\'All production versions\'));',
    'op' => 'Save field settings',
    'module' => 'number',
    'widget_module' => 'optionwidgets',
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
    ),
  ),
  3 => 
  array (
    'label' => 'Default Person role',
    'field_name' => 'field_person_role_default',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '35',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_person_role_default][0][value',
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
    ),
  ),
);
$content['extra']  = array (
  'title' => '-5',
  'revision_information' => '20',
  'author' => '20',
  'options' => '25',
  'comment_settings' => '30',
  'menu' => '-2',
  'path' => '30',
);
