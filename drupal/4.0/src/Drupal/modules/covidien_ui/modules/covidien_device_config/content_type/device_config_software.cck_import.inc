$content['type']  = array (
  'name' => 'device_config_software',
  'type' => 'device_config_software',
  'description' => '',
  'title_label' => 'Title',
  'body_label' => '',
  'min_word_count' => '0',
  'help' => '',
  'node_options' => 
  array (
    'status' => true,
    'revision' => true,
    'promote' => false,
    'sticky' => false,
  ),
  'language_content_type' => '0',
  'old_type' => 'device_config_software',
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
    'label' => ' Device config Software',
    'field_name' => 'field_device_config_software',
    'type' => 'nodereference',
    'widget_type' => 'nodereference_buttons',
    'change' => 'Change basic information',
    'weight' => '-4',
    'autocomplete_match' => 'contains',
    'size' => 60,
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'nid' => NULL,
      ),
    ),
    'default_value_php' => '',
    'default_value_widget' => NULL,
    'group' => false,
    'required' => 0,
    'multiple' => '0',
    'referenceable_types' => 
    array (
      'software' => 'software',
      'business_unit' => 0,
      'component_option_type' => 0,
      'country' => 0,
      'department' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_type_config' => 0,
      'document' => 0,
      'document_type' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'page' => 0,
      'party' => 0,
      'party_type' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'story' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'hardware' => 0,
      'access_option' => false,
      'address_type' => false,
      'app_section' => false,
      'app_role_access_policy' => false,
      'appl_user_party_auth' => false,
      'bu_customer' => false,
      'bu_department' => false,
      'contact_type' => false,
      'customer_account_number' => false,
      'customer_facility' => false,
      'device_action_history' => false,
      'device_action_type' => false,
      'device_availability' => false,
      'device_component_entitlement' => false,
      'device_component_history' => false,
      'device_discrepancy' => false,
      'device_log_field' => false,
      'device_log_history' => false,
      'device_setting_history' => false,
      'device_language_availability' => false,
      'device_service_history' => false,
      'device_installation' => false,
      'device_service_type' => false,
      'operating_company' => false,
      'party_contact' => false,
      'party_email_address' => false,
      'party_postal_address' => false,
      'party_voice_address' => false,
      'person' => false,
      'postal_address' => false,
      'product_line' => false,
      'profile' => false,
      'region' => false,
      'roles' => false,
      'section_access_option' => false,
      'company' => false,
      'email_notifications' => false,
      'user_settings' => false,
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
  1 => 
  array (
    'label' => ' Device type SW status',
    'field_name' => 'field_device_config_sw_status',
    'type' => 'text',
    'widget_type' => 'optionwidgets_select',
    'change' => 'Change basic information',
    'weight' => '-3',
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
    'text_processing' => '0',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => 'return array(\'Required\',\'Optional\');',
    'op' => 'Save field settings',
    'module' => 'text',
    'widget_module' => 'optionwidgets',
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
  2 => 
  array (
    'label' => 'Software Entitlement  Required',
    'field_name' => 'field_sw_entitlement_required',
    'type' => 'number_integer',
    'widget_type' => 'number',
    'change' => 'Change basic information',
    'weight' => '-2',
    'description' => '',
    'default_value' => 
    array (
      0 => 
      array (
        'value' => '',
        '_error_element' => 'default_value_widget][field_sw_entitlement_required][0][value',
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
  'revision_information' => '0',
  'author' => '1',
  'options' => '2',
  'comment_settings' => '4',
  'menu' => '-1',
  'path' => '3',
);
