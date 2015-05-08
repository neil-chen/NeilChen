$content['type']  = array (
  'name' => 'Device_installation',
  'type' => 'device_installation',
  'description' => '',
  'title_label' => 'Facility_Device_id',
  'body_label' => '',
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
  'old_type' => 'device_installation',
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
  'unique_field_fields' => 
  array (
    'title' => false,
    'name' => false,
    'field_facility_pk' => false,
    'field_device_pk' => false,
    'field_device_country' => false,
    'field_activation_datetime' => false,
    'field_activation_utc_offset' => false,
    'field_expiration_datetime' => false,
    'field_expiration_utc_offset' => false,
    'field_location_id' => false,
    'field_usr_provided_dev_facility' => false,
    'field_usr_provided_dev_address' => false,
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
    'label' => 'Facility',
    'field_name' => 'field_facility_pk',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_select',
    'change' => 'Change basic information',
    'weight' => '2',
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
      'device_embargo' => false,
      'device_log' => false,
      'device_component_upgrade_log' => false,
      'person_training_record' => false,
      'product_line_report' => false,
      'sku' => false,
      'software_approval_unavailable' => false,
      'device_user_privileges' => false,
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
  1 => 
  array (
    'label' => 'Service Device id',
    'field_name' => 'field_device_pk',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_select',
    'change' => 'Change basic information',
    'weight' => '3',
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
      'device' => 'device',
      'bu_customer' => 0,
      'bu_department' => 0,
      'business_unit' => 0,
      'customer_account_number' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'devicetype' => 0,
      'device_service_history' => 0,
      'device_installation' => 0,
      'device_service_type' => 0,
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
      'device_component_history' => false,
      'software' => false,
      'hardware' => false,
      'access_option' => false,
      'address_type' => false,
      'app_section' => false,
      'app_role_access_policy' => false,
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
      'postal_address' => false,
      'profile' => false,
      'section_access_option' => false,
      'software_reg_approval' => false,
      'softwarestatus' => false,
      'softwaretype' => false,
      'device_config_hardware' => false,
      'device_config_software' => false,
      'person_application_role' => false,
      'device_log' => false,
      'device_embargo' => false,
      'device_component_upgrade_log' => false,
      'party_voice_address' => false,
      'person_training_record' => false,
      'product_line_report' => false,
      'sku' => false,
      'software_approval_unavailable' => false,
      'device_user_privileges' => false,
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
      'token' => 
      array (
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
  ),
  2 => 
  array (
    'label' => 'Country ',
    'field_name' => 'field_device_country',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_select',
    'change' => 'Change basic information',
    'weight' => '4',
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
      'country' => 'country',
      'access_option' => 0,
      'address_type' => 0,
      'app_section' => 0,
      'app_role_access_policy' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'business_unit' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'customer_facility' => 0,
      'department' => 0,
      'device' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_discrepancy' => 0,
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
      'postal_address' => 0,
      'product_line' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'software_reg_approval' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'story' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'person_application_role' => 0,
      'user_settings' => 0,
      'device_embargo' => false,
      'party_voice_address' => false,
      'person_training_record' => false,
      'product_line_report' => false,
      'software_approval_unavailable' => false,
      'device_user_privileges' => false,
      'device_component_upgrade_log' => false,
      'sku' => false,
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
  3 => 
  array (
    'label' => 'activation datetime',
    'field_name' => 'field_activation_datetime',
    'type' => 'datetime',
    'widget_type' => 'date_text',
    'change' => 'Change basic information',
    'weight' => '5',
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
  4 => 
  array (
    'label' => 'Activation_UTC_offset',
    'field_name' => 'field_activation_utc_offset',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '6',
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
    'label' => 'expiration_datetime',
    'field_name' => 'field_expiration_datetime',
    'type' => 'datetime',
    'widget_type' => 'date_text',
    'change' => 'Change basic information',
    'weight' => '7',
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
  6 => 
  array (
    'label' => 'Expiration UTC offset',
    'field_name' => 'field_expiration_utc_offset',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '8',
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
  7 => 
  array (
    'label' => 'location ID',
    'field_name' => 'field_location_id',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_select',
    'change' => 'Change basic information',
    'weight' => '9',
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
      'postal_address' => 'postal_address',
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
      'party_voice_address' => 0,
      'person' => 0,
      'person_training_record' => 0,
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
      'device_component_upgrade_log' => false,
      'sku' => false,
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
  8 => 
  array (
    'label' => 'User provided device facility',
    'field_name' => 'field_usr_provided_dev_facility',
    'type' => 'text',
    'widget_type' => 'text_textfield',
    'change' => 'Change basic information',
    'weight' => '10',
    'rows' => 5,
    'size' => '60',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_usr_provided_dev_facility][0][value',
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
    ),
  ),
  9 => 
  array (
    'label' => 'User provided device address',
    'field_name' => 'field_usr_provided_dev_address',
    'type' => 'text',
    'widget_type' => 'text_textfield',
    'change' => 'Change basic information',
    'weight' => '11',
    'rows' => 5,
    'size' => '60',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_usr_provided_dev_address][0][value',
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
    ),
  ),
);
$content['extra']  = array (
  'title' => '-5',
  'revision_information' => '-2',
  'author' => '-3',
  'options' => '-1',
  'comment_settings' => '0',
  'menu' => '-4',
  'path' => '1',
);
