$content['type']  = array (
  'name' => 'Customer Facility',
  'type' => 'customer_facility',
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
  'old_type' => 'customer_facility',
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
    'label' => 'Customer',
    'field_name' => 'field_customer_pk',
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
      'bu_customer' => 0,
      'bu_department' => 0,
      'business_unit' => 0,
      'customer_account_number' => 0,
      'customer_facility' => 0,
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
      'access_option' => false,
      'address_type' => false,
      'app_section' => false,
      'app_role_access_policy' => false,
      'appl_user_party_auth' => false,
      'contact_type' => false,
      'device_action_history' => false,
      'device_action_type' => false,
      'device_availability' => false,
      'device_component_entitlement' => false,
      'device_log_field' => false,
      'device_log_history' => false,
      'device_setting_history' => false,
      'device_language_availability' => false,
      'party_contact' => false,
      'party_postal_address' => false,
      'party_voice_address' => false,
      'person_application_role' => false,
      'postal_address' => false,
      'section_access_option' => false,
      'company' => false,
    ),
    'advanced_view' => 'customer_from_customer_drop',
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
    'label' => 'Facility',
    'field_name' => 'field_facility_pk',
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
      'bu_customer' => 0,
      'bu_department' => 0,
      'business_unit' => 0,
      'customer_account_number' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_installation' => 0,
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
      'device_service_history' => false,
      'device_service_type' => false,
      'device_component_history' => false,
      'software' => false,
      'hardware' => false,
      'access_option' => false,
      'address_type' => false,
      'app_section' => false,
      'app_role_access_policy' => false,
      'appl_user_party_auth' => false,
      'component_option_type' => false,
      'contact_type' => false,
      'country' => false,
      'device_action_history' => false,
      'device_action_type' => false,
      'device_availability' => false,
      'device_component_entitlement' => false,
      'device_discrepancy' => false,
      'device_log_field' => false,
      'device_log_history' => false,
      'device_setting_history' => false,
      'device_language_availability' => false,
      'device_notification_subscription' => false,
      'device_notification_type' => false,
      'device_type_config' => false,
      'document' => false,
      'document_type' => false,
      'hardwaretype' => false,
      'location' => false,
      'party_contact' => false,
      'party_email_address' => false,
      'party_postal_address' => false,
      'party_voice_address' => false,
      'person_application_role' => false,
      'postal_address' => false,
      'profile' => false,
      'section_access_option' => false,
      'softwarestatus' => false,
      'softwaretype' => false,
      'company' => false,
      'device_config_hardware' => false,
      'device_config_software' => false,
    ),
    'advanced_view' => 'facility_dropdown',
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
  2 => 
  array (
    'label' => 'activation datetime',
    'field_name' => 'field_activation_datetime',
    'type' => 'datetime',
    'widget_type' => 'date_text',
    'change' => 'Change basic information',
    'weight' => '34',
    'default_value' => 'blank',
    'default_value2' => 'blank',
    'default_value_code' => '',
    'default_value_code2' => '',
    'input_format' => 'm/d/Y - H:i:s',
    'input_format_custom' => '',
    'advanced' => 
    array (
      'label_position' => 'above',
      'text_parts' => 
      array (
        'year' => 0,
        'month' => 0,
        'day' => 0,
        'hour' => 0,
        'minute' => 0,
        'second' => 0,
      ),
    ),
    'increment' => 1,
    'year_range' => '-3:+3',
    'label_position' => 'above',
    'text_parts' => 
    array (
    ),
    'description' => '',
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'repeat' => 0,
    'todate' => '',
    'granularity' => 
    array (
      'year' => 'year',
      'month' => 'month',
      'day' => 'day',
      'hour' => 'hour',
      'minute' => 'minute',
    ),
    'default_format' => 'medium',
    'tz_handling' => 'utc',
    'timezone_db' => 'UTC',
    'op' => 'Save field settings',
    'module' => 'date',
    'widget_module' => 'date',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'datetime',
        'not null' => false,
        'sortable' => true,
        'views' => true,
      ),
    ),
    'display_settings' => 
    array (
      'weight' => '36',
      'parent' => '',
      'label' => 
      array (
        'format' => 'above',
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
  3 => 
  array (
    'label' => 'expiration_datetime',
    'field_name' => 'field_expiration_datetime',
    'type' => 'datetime',
    'widget_type' => 'date_text',
    'change' => 'Change basic information',
    'weight' => '36',
    'default_value' => 'blank',
    'default_value2' => 'blank',
    'default_value_code' => '0000-00-00 00:00:00',
    'default_value_code2' => '0000-00-00 00:00:00',
    'input_format' => 'm/d/Y - H:i:s',
    'input_format_custom' => '',
    'advanced' => 
    array (
      'label_position' => 'above',
      'text_parts' => 
      array (
        'year' => 0,
        'month' => 0,
        'day' => 0,
        'hour' => 0,
        'minute' => 0,
        'second' => 0,
      ),
    ),
    'increment' => 1,
    'year_range' => '-3:+3',
    'label_position' => 'above',
    'text_parts' => 
    array (
    ),
    'description' => '',
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'repeat' => 0,
    'todate' => '',
    'granularity' => 
    array (
      'year' => 'year',
      'month' => 'month',
      'day' => 'day',
      'hour' => 'hour',
      'minute' => 'minute',
    ),
    'default_format' => 'medium',
    'tz_handling' => 'utc',
    'timezone_db' => 'UTC',
    'op' => 'Save field settings',
    'module' => 'date',
    'widget_module' => 'date',
    'columns' => 
    array (
      'value' => 
      array (
        'type' => 'datetime',
        'not null' => false,
        'sortable' => true,
        'views' => true,
      ),
    ),
    'display_settings' => 
    array (
      'weight' => '38',
      'parent' => '',
      'label' => 
      array (
        'format' => 'above',
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
  4 => 
  array (
    'label' => 'Activation_UTC_offset',
    'field_name' => 'field_activation_utc_offset',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '38',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_activation_utc_offset][0][value',
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
      'weight' => '37',
      'parent' => '',
      'label' => 
      array (
        'format' => 'above',
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
  5 => 
  array (
    'label' => 'Expiration_UTC_offset',
    'field_name' => 'field_expiration_utc_offset',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '40',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_expiration_utc_offset][0][value',
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
