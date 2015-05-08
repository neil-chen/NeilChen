<?php

/**
 * @file
 * Document catlog list page.
 */
$view = new view;
$view->name = 'documentlist';
$view->description = 'List of documents';
$view->tag = '';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'field_hw_list_nid' => array(
    'id' => 'field_hw_list_nid',
    'table' => 'node_data_field_hw_list',
    'field' => 'field_hw_list_nid',
  ),
));
$handler->override_option('fields', array(
  'title' => array(
    'label' => '',
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
    'jeditable' => array(
      'enabled' => 1,
      'reload_page' => 0,
      'hide_if_empty' => 0,
      'disable_if_not_empty' => 0,
      'override_defaults' => 0,
    ),
    'exclude' => 0,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'relationship' => 'none',
  ),
));
$handler->override_option('sorts', array(
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
));
$handler->override_option('arguments', array(
  'field_sw_status_nid' => array(
    'id' => 'field_sw_status_nid',
    'table' => 'node_data_field_sw_status',
    'field' => 'field_sw_status_nid',
  ),
  'field_device_type_nid' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'php',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'break_phrase' => 1,
    'not' => 0,
    'id' => 'field_device_type_nid',
    'table' => 'node_data_field_device_type',
    'field' => 'field_device_type_nid',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      2 => 0,
      3 => 0,
      4 => 0,
      5 => 0,
    ),
    'relationship' => 'none',
    'default_options_div_prefix' => '',
    'default_taxonomy_tid_term_page' => 0,
    'default_taxonomy_tid_node' => 0,
    'default_taxonomy_tid_limit' => 0,
    'default_taxonomy_tid_vids' => array(),
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => 'global $user;
return $user->devices_nid;',
    'validate_argument_node_type' => array(
      'access_option' => 0,
      'address_type' => 0,
      'appl_user_party_auth' => 0,
      'app_role_access_policy' => 0,
      'app_section' => 0,
      'business_unit' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'company' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_account_number' => 0,
      'customer_facility' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'device_discrepancy' => 0,
      'device_installation' => 0,
      'device_language_availability' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_service_history' => 0,
      'device_service_type' => 0,
      'device_setting_history' => 0,
      'device_type_config' => 0,
      'document' => 0,
      'document_type' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party' => 0,
      'party_contact' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'party_voice_address' => 0,
      'person' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'story' => 0,
      'user_settings' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
  ),
));
$handler->override_option('filters', array(
  'status' => array(
    'operator' => '=',
    'value' => '1',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'id' => 'status',
    'table' => 'node',
    'field' => 'status',
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'document' => 'document',
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
    'relationship' => 'none',
  ),
));
$handler->override_option('access', array(
  'type' => 'none',
));
$handler->override_option('cache', array(
  'type' => 'none',
));
$handler->override_option('empty', '<table class="views-table cols-7">
    <thead>
    <tr>
              <th class="views-field views-field-title">
          Document Title & Version</th>
              <th class="views-field views-field-field-documnet-type-nid">
          Type        </th>
              <th class="views-field views-field-field-document-language-nid">
          Language        </th>
              <th class="views-field views-field-field-doc-file-name-value">
          Filename        </th>

              <th class="views-field views-field-field-doc-visibility-value">
          Visibility        </th>
              <th class="views-field views-field-field-document-description-value">
          	Description        </th>
              <th class="views-field views-field-filesize">
          File Size        </th>
              <th class="views-field views-field-timestamp">
          Upload Date        </th>
              <th class="views-field views-field-action">
          Action        </th>
          </tr>
  </thead>
  <tbody>
          <tr class="odd views-row-first" >
                  <td class="views-field views-field-title" colspan="9">
            No Documents available 
    </td>
</tr>
      </tbody>
</table>');
$handler->override_option('empty_format', '2');
$handler->override_option('use_pager', '1');
$handler->override_option('style_plugin', 'table');
$handler = $view->new_display('page', 'Document Page', 'page_1');
$handler->override_option('relationships', array(
  'field_doc_hw_list_nid' => array(
    'label' => 'Hardware',
    'required' => 0,
    'delta' => '-1',
    'id' => 'field_doc_hw_list_nid',
    'table' => 'node_data_field_doc_hw_list',
    'field' => 'field_doc_hw_list_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_doc_sw_list_nid' => array(
    'label' => 'Software',
    'required' => 0,
    'delta' => '-1',
    'id' => 'field_doc_sw_list_nid',
    'table' => 'node_data_field_doc_sw_list',
    'field' => 'field_doc_sw_list_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_document_file_fid' => array(
    'label' => 'Document file',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_document_file_fid',
    'table' => 'node_data_field_document_file',
    'field' => 'field_document_file_fid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_documnet_type_nid' => array(
    'label' => 'Document Type',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_documnet_type_nid',
    'table' => 'node_data_field_documnet_type',
    'field' => 'field_documnet_type_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_doc_status' => array(
    'label' => 'Document Status',
    'required' => 0,
    'delta' => -1,
    'id' => 'doc_status',
    'table' => 'content_type_document',
    'field' => 'doc_status',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_document_language_nid' => array(
    'label' => 'Document language',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_document_language_nid',
    'table' => 'node_data_field_document_language',
    'field' => 'field_document_language_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('fields', array(
  'field_device_type_nid' => array(
    'label' => '',
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
    'hide_alter_empty' => 0,
    'link_to_node' => 0,
    'label_type' => 'none',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 1,
    'id' => 'field_device_type_nid',
    'table' => 'node_data_field_device_type',
    'field' => 'field_device_type_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
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
  'field_document_version_value' => array(
    'label' => '',
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
    'hide_alter_empty' => 0,
    'link_to_node' => 0,
    'label_type' => 'none',
    'format' => 'default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 1,
    'id' => 'field_document_version_value',
    'table' => 'node_data_field_document_version',
    'field' => 'field_document_version_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'title' => array(
    'label' => 'Document Title & Version',
    'alter' => array(
      'alter_text' => 1,
      'text' => '[title] v[field_document_version_value]',
      'make_link' => 0,
      'path' => 'node/[nid]/edit',
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
    'hide_alter_empty' => 0,
    'link_to_node' => 0,
    'exclude' => 0,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'title_1' => array(
    'label' => 'Type',
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
    'relationship' => 'field_documnet_type_nid',
  ),
  'doc_status' => array(
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
    'exclude' => 0,
    'id' => 'doc_status',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_doc_status',
  ),
  'title_2' => array(
    'label' => 'Language',
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
    'id' => 'title_2',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_document_language_nid',
  ),
  'filename' => array(
    'label' => 'Filename',
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
    'link_to_file' => 0,
    'exclude' => 0,
    'id' => 'filename',
    'table' => 'files',
    'field' => 'filename',
    'relationship' => 'field_document_file_fid',
    'override' => array(
      'button' => 'Use default',
    ),
  ),
  'field_doc_external_users_value' => array(
    'label' => 'Visibility',
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
    'hide_alter_empty' => 0,
    'link_to_node' => 0,
    'label_type' => 'custom',
    'format' => 'unformatted',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
    ),
    'exclude' => 0,
    'id' => 'field_doc_external_users_value',
    'table' => 'node_data_field_doc_external_users',
    'field' => 'field_doc_external_users_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_document_description_value' => array(
    'label' => 'Description',
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
    'hide_alter_empty' => 0,
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
    'id' => 'field_document_description_value',
    'table' => 'node_data_field_document_description',
    'field' => 'field_document_description_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'filesize' => array(
    'label' => 'File Size',
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
    'hide_alter_empty' => 0,
    'file_size_display' => 'formatted',
    'exclude' => 0,
    'id' => 'filesize',
    'table' => 'files',
    'field' => 'filesize',
    'relationship' => 'field_document_file_fid',
    'override' => array(
      'button' => 'Use default',
    ),
  ),
  'timestamp' => array(
    'label' => 'Upload Date',
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
    'date_format' => 'custom',
    'custom_date_format' => 'm/d/Y',
    'exclude' => 0,
    'id' => 'timestamp',
    'table' => 'node_revisions',
    'field' => 'timestamp',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_document_md5sum_value' => array(
    'label' => 'Action',
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
    'hide_alter_empty' => 0,
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
    'id' => 'field_document_md5sum_value',
    'table' => 'node_data_field_document_md5sum',
    'field' => 'field_document_md5sum_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('sorts', array(
  'nid' => array(
    'order' => 'DESC',
    'id' => 'nid',
    'table' => 'node',
    'field' => 'nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('arguments', array(
  'field_device_type_nid' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'php',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'break_phrase' => 1,
    'not' => 0,
    'id' => 'field_device_type_nid',
    'table' => 'node_data_field_device_type',
    'field' => 'field_device_type_nid',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      2 => 0,
      3 => 0,
      4 => 0,
      5 => 0,
    ),
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
    'default_options_div_prefix' => '',
    'default_taxonomy_tid_term_page' => 0,
    'default_taxonomy_tid_node' => 0,
    'default_taxonomy_tid_limit' => 0,
    'default_taxonomy_tid_vids' => array(),
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => 'global $user;
return $user->devices_nid;',
    'validate_argument_node_type' => array(
      'access_option' => 0,
      'address_type' => 0,
      'appl_user_party_auth' => 0,
      'app_role_access_policy' => 0,
      'app_section' => 0,
      'business_unit' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'company' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_account_number' => 0,
      'customer_facility' => 0,
      'device' => 0,
      'devicetype' => 0,
      'device_action_history' => 0,
      'device_action_type' => 0,
      'device_availability' => 0,
      'device_component_entitlement' => 0,
      'device_component_history' => 0,
      'device_config_hardware' => 0,
      'device_config_software' => 0,
      'device_discrepancy' => 0,
      'device_installation' => 0,
      'device_language_availability' => 0,
      'device_log_field' => 0,
      'device_log_history' => 0,
      'device_notification_subscription' => 0,
      'device_notification_type' => 0,
      'device_service_history' => 0,
      'device_service_type' => 0,
      'device_setting_history' => 0,
      'device_type_config' => 0,
      'document' => 0,
      'document_type' => 0,
      'email_notifications' => 0,
      'hardware' => 0,
      'hardwaretype' => 0,
      'language' => 0,
      'location' => 0,
      'operating_company' => 0,
      'page' => 0,
      'party' => 0,
      'party_contact' => 0,
      'party_email_address' => 0,
      'party_postal_address' => 0,
      'party_type' => 0,
      'party_voice_address' => 0,
      'person' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'story' => 0,
      'user_settings' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
  ),
));
$handler->override_option('filters', array(
  'title' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'title_op',
      'identifier' => 'title',
      'label' => '',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'title_2' => array(
    'operator' => '=',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'title_2_op',
      'identifier' => 'title_2',
      'label' => 'Node: Title',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'title_2',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_doc_hw_list_nid',
  ),
  'field_hw_version_value' => array(
    'operator' => '=',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_hw_version_value_op',
      'identifier' => 'field_hw_version_value',
      'label' => 'Content: Hardware revision (field_hw_version)',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'field_hw_version_value',
    'table' => 'node_data_field_hw_version',
    'field' => 'field_hw_version_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_doc_hw_list_nid',
  ),
  'field_sw_version_value' => array(
    'operator' => 'contains',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_sw_version_value_op',
      'identifier' => 'field_sw_version_value',
      'label' => 'Content: softwareversion (field_sw_version)',
      'remember' => 0,
    ),
    'case' => 0,
    'id' => 'field_sw_version_value',
    'table' => 'node_data_field_sw_version',
    'field' => 'field_sw_version_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_doc_sw_list_nid',
  ),
  'title_1' => array(
    'operator' => '=',
    'value' => '',
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'title_1_op',
      'identifier' => 'title_1',
      'label' => 'Software Name',
      'remember' => 0,
    ),
    'case' => 1,
    'id' => 'title_1',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_doc_sw_list_nid',
  ),
  'status' => array(
    'operator' => '=',
    'value' => '1',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'id' => 'status',
    'table' => 'node',
    'field' => 'status',
    'relationship' => 'none',
  ),
  'field_expiration_datetime_value' => array(
    'operator' => 'empty',
    'value' => array(
      'value' => NULL,
      'min' => NULL,
      'max' => NULL,
      'default_date' => '',
      'default_to_date' => '',
    ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
    ),
    'date_fields' => array(
      'node_data_field_expiration_datetime.field_expiration_datetime_value' => 'node_data_field_expiration_datetime.field_expiration_datetime_value',
    ),
    'date_method' => 'OR',
    'granularity' => 'day',
    'form_type' => 'date_select',
    'default_date' => '',
    'default_to_date' => '',
    'year_range' => '-3:+3',
    'id' => 'field_expiration_datetime_value',
    'table' => 'node_data_field_expiration_datetime',
    'field' => 'field_expiration_datetime_value',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'document' => 'document',
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
    'relationship' => 'none',
    'override' => array(
      'button' => 'Use default',
    ),
  ),
  'field_device_type_nid' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_device_type_nid_op',
      'identifier' => 'field_device_type_nid',
      'label' => 'Select Device Type',
      'optional' => 1,
      'single' => 1,
      'remember' => 0,
      'reduce' => 0,
    ),
    'id' => 'field_device_type_nid',
    'table' => 'node_data_field_device_type',
    'field' => 'field_device_type_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
    'reduce_duplicates' => 0,
  ),
  'field_hw_type_nid' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_hw_type_nid_op',
      'identifier' => 'field_hw_type_nid',
      'label' => 'Hardware Type',
      'optional' => 1,
      'single' => 1,
      'remember' => 0,
      'reduce' => 0,
    ),
    'id' => 'field_hw_type_nid',
    'table' => 'node_data_field_hw_type',
    'field' => 'field_hw_type_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_doc_hw_list_nid',
    'reduce_duplicates' => 0,
  ),
  'field_sw_status_nid' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_sw_status_nid_op',
      'identifier' => 'field_sw_status_nid',
      'label' => 'Software Status',
      'optional' => 1,
      'single' => 1,
      'remember' => 0,
      'reduce' => 0,
    ),
    'id' => 'field_sw_status_nid',
    'table' => 'node_data_field_sw_status',
    'field' => 'field_sw_status_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'field_doc_sw_list_nid',
    'reduce_duplicates' => 0,
  ),
));
$handler->override_option('distinct', 1);
$handler->override_option('style_options', array(
  'grouping' => '',
  'override' => 1,
  'sticky' => 0,
  'order' => 'desc',
  'summary' => '',
  'columns' => array(
    'field_device_type_nid' => 'field_device_type_nid',
    'nid' => 'nid',
    'field_document_version_value' => 'field_document_version_value',
    'title' => 'title',
    'title_1' => 'title_1',
    'title_2' => 'title_2',
    'filename' => 'filename',
    'field_doc_external_users_value' => 'field_doc_external_users_value',
    'field_document_description_value' => 'field_document_description_value',
    'filesize' => 'filesize',
    'timestamp' => 'timestamp',
    'field_document_md5sum_value' => 'field_document_md5sum_value',
  ),
  'info' => array(
    'field_device_type_nid' => array(
      'separator' => '',
    ),
    'nid' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_document_version_value' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'title' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'title_1' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'doc_status' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'title_2' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'filename' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_doc_external_users_value' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_document_description_value' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'filesize' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'timestamp' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_document_md5sum_value' => array(
      'sortable' => 1,
      'separator' => '',
    ),
  ),
  'default' => 'nid',
));
$handler->override_option('exposed_block', TRUE);
$handler->override_option('path', 'document/list');
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