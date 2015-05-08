<?php

$view = new view;
$view->name = 'regulatory_approval_list';
$view->description = 'Regulatory Approval List';
$view->tag = '';
$view->base_table = 'node';
$view->core = 6;
$view->api_version = '2';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
$handler = $view->new_display('default', 'Defaults', 'default');
$handler->override_option('relationships', array(
  'field_device_avail_country_nid' => array(
    'id' => 'field_device_avail_country_nid',
    'table' => 'node_data_field_device_avail_country',
    'field' => 'field_device_avail_country_nid',
  ),
));
$handler->override_option('fields', array(
  'type' => array(
    'id' => 'type',
    'table' => 'node',
    'field' => 'type',
  ),
));
$handler->override_option('arguments', array(
  'nid' => array(
    'id' => 'nid',
    'table' => 'node',
    'field' => 'nid',
  ),
));
$handler->override_option('filters', array(
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'software_reg_approval' => 'software_reg_approval',
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
$handler = $view->new_display('page', 'Regulatory Approval', 'page_1');
$handler->override_option('relationships', array(
  'field_reg_approved_country_nid' => array(
    'label' => 'Country',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_reg_approved_country_nid',
    'table' => 'node_data_field_reg_approved_country',
    'field' => 'field_reg_approved_country_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'field_reg_approved_component_nid' => array(
    'label' => 'Regulatory Approval Component',
    'required' => 0,
    'delta' => -1,
    'id' => 'field_reg_approved_component_nid',
    'table' => 'node_data_field_reg_approved_component',
    'field' => 'field_reg_approved_component_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
));
$handler->override_option('fields', array(
  'nid_1' => array(
    'label' => 'Component Nid',
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
    'relationship' => 'field_reg_approved_component_nid',
  ),
  'nid' => array(
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
    'exclude' => 1,
    'id' => 'nid',
    'table' => 'node',
    'field' => 'nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
  ),
  'title' => array(
    'label' => 'Country',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 1,
      'path' => 'node/[nid]/edit/[nid_1] ',
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
    'relationship' => 'field_reg_approved_country_nid',
  ),
));
$handler->override_option('arguments', array(
  'field_reg_approved_component_nid' => array(
    'default_action' => 'ignore',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'fixed',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'break_phrase' => 0,
    'not' => 0,
    'id' => 'field_reg_approved_component_nid',
    'table' => 'node_data_field_reg_approved_component',
    'field' => 'field_reg_approved_component_nid',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      2 => 0,
      16 => 0,
      17 => 0,
      19 => 0,
      20 => 0,
      15 => 0,
      18 => 0,
      13 => 0,
      3 => 0,
      4 => 0,
      5 => 0,
      14 => 0,
      6 => 0,
      7 => 0,
      8 => 0,
      9 => 0,
      10 => 0,
      12 => 0,
    ),
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
    'default_options_div_prefix' => '',
    'default_taxonomy_tid_term_page' => 0,
    'default_taxonomy_tid_node' => 0,
    'default_taxonomy_tid_limit' => 0,
    'default_taxonomy_tid_vids' => array(
      1 => 0,
    ),
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => '',
    'validate_argument_node_type' => array(
      'access_option' => 0,
      'address_type' => 0,
      'app_role_access_policy' => 0,
      'app_section' => 0,
      'business_unit' => 0,
      'bu_customer' => 0,
      'bu_department' => 0,
      'component_option_type' => 0,
      'contact_type' => 0,
      'country' => 0,
      'customer_facility' => 0,
      'department' => 0,
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
      'device_log' => 0,
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
      'person' => 0,
      'person_application_role' => 0,
      'postal_address' => 0,
      'product_line' => 0,
      'profile' => 0,
      'region' => 0,
      'roles' => 0,
      'section_access_option' => 0,
      'software' => 0,
      'softwarestatus' => 0,
      'softwaretype' => 0,
      'software_reg_approval' => 0,
      'story' => 0,
      'user_settings' => 0,
    ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(
      1 => 0,
    ),
    'validate_argument_type' => 'tid',
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_php' => '',
  ),
));
$handler->override_option('filters', array(
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'software_approval_unavailable' => 'software_approval_unavailable',
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
  'field_reg_approved_component_nid' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_reg_approved_component_nid_op',
      'identifier' => 'field_reg_approved_component_nid',
      'label' => 'Content: Regulatory Approval Component (field_reg_approved_component)',
      'optional' => 1,
      'single' => 1,
      'remember' => 0,
      'reduce' => 0,
    ),
    'id' => 'field_reg_approved_component_nid',
    'table' => 'node_data_field_reg_approved_component',
    'field' => 'field_reg_approved_component_nid',
    'override' => array(
      'button' => 'Use default',
    ),
    'relationship' => 'none',
    'reduce_duplicates' => 0,
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
));
$handler->override_option('empty', '<table class="views-table cols-3" style="width:60%">
    <thead>
    <tr>
              <th>Country</th>              
          </tr>
  </thead>
  <tbody>
          <tr class="odd views-row-first views-row-last">
                  <td align="left">
						No Regulatory Exceptions available
				  </td>
              </tr>		
      </tbody>
</table>
			');
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
    'nid_1' => 'nid_1',
    'nid' => 'nid',
    'title' => 'title',
    'field_regulatory_approved_status_value' => 'field_regulatory_approved_status_value',
  ),
  'info' => array(
    'nid_1' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'nid' => array(
      'sortable' => 0,
      'separator' => '',
    ),
    'title' => array(
      'sortable' => 1,
      'separator' => '',
    ),
    'field_regulatory_approved_status_value' => array(
      'sortable' => 1,
      'separator' => '',
    ),
  ),
  'default' => '-1',
));
$handler->override_option('path', 'covidien/admin/software_regulatory');
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
