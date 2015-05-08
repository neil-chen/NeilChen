<?php

/**
 * page callback covidien/devices 
 */
function covidien_device_list() {
  drupal_add_js('misc/autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_devices') . '/js/covidien_devices.js');
  $ouput = drupal_get_form('covidien_device_list_form');
  covidien_device_list_form_validate($form_state);
  $ouput .= covidien_device_list_table();
  return $ouput;
}

/**
 * hook_views_pre_execute
 * @param type $view
 */
function covidien_device_list_table() {
  //query
  $header = array(
    array('data' => t('Serial Number'), 'field' => 'n.title', 'sort' => 'desc'),
    array('data' => t('Customer Name'), 'field' => 'ctn.title'),
    array('data' => t('Customer Account number'), 'field' => 'acn.title'),
    array('data' => t('Country'), 'field' => 'con.title'),
    array('data' => t('Region'), 'field' => 'rn.title'),
  );
  $query = covidien_device_list_query();
  $result = pager_query($query['query'], 10, 0, $query['count_query'], $query['args']);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->nid]['device_sn'] = l($row->device_sn, 'covidien/device/' . $row->nid . '/' . $row->device_sn);
    $rows[$row->nid]['customer_name'] = $row->customer_name;
    $rows[$row->nid]['account_no'] = $row->account_no;
    $rows[$row->nid]['country'] = $row->country;
    $rows[$row->nid]['region'] = $row->region;
  }
  $output = theme_table($header, $rows);
  $output .= theme('pager', NULL, 10, 0);
  return $output;
}

/**
 * get devices list query 
 */
function covidien_device_list_query() {
  global $user;
  $get['device_type'] = check_plain($_GET['device_type']);
  $get['sno'] = check_plain($_GET['sno']);
  $get['country_id'] = check_plain($_GET['country_nid']);
  $get['customer_name'] = check_plain($_GET['customer_name']);
  $get['account_no'] = check_plain($_GET['account_number']);
  //no covidien user
  $get['account_no_nid'] = 0;
  if ($user->covidien_user != 'Yes') {
    $get['account_no_nid'] = current($user->customer_account_nid);
  }
  //query
  $sql = "SELECT n.nid, n.title AS device_sn, ctn.title AS customer_name, acn.title AS account_no, con.title AS country, rn.title AS region
        FROM {content_type_device} d 
        JOIN {node} n ON d.vid = n.vid AND n.type = 'device'
        JOIN {content_field_device_type} dt ON d.nid = dt.nid
        JOIN {content_field_device_product_line} pl ON dt.field_device_type_nid = pl.nid
        LEFT JOIN {node} rn ON d.region_nid = rn.nid
        LEFT JOIN {node} acn ON d.field_device_owner_nid = acn.nid 
        LEFT JOIN {content_type_bu_customer} bc ON acn.vid = bc.vid
        LEFT JOIN {node} ctn ON bc.field_customer_party_pk_nid = ctn.nid 
        LEFT JOIN {content_field_device_pk} dp ON d.nid = dp.field_device_pk_nid
        LEFT JOIN {content_type_device_installation} di ON dp.vid = di.vid
        LEFT JOIN {node} con ON di.field_device_country_nid = con.nid
        LEFT JOIN {content_field_expiration_datetime} ed ON d.vid = ed.vid 
        WHERE ed.field_expiration_datetime_value IS NULL ";

  $args = array();
  //GATEWAY-1946
  if ($_SESSION['default_cot']) {
    $sql .= " AND pl.field_device_product_line_nid = %d ";
    $args[] = $_SESSION['default_cot'];
  }
  if ($get['device_type'] && $get['device_type'] != 'All') {
    $sql .= " AND dt.field_device_type_nid = %d ";
    $args[] = $get['device_type'];
  }
  if ($get['sno'] && $get['sno'] != 'All') {
    $sql .= " AND n.title = '%s' ";
    $args[] = $get['sno'];
  }
  if ($get['country_id'] && $get['country_id'] != 'All') {
    $sql .= " AND con.nid = %d ";
    $args[] = $get['country_id'];
  }
  if ($get['customer_name'] && $get['customer_name'] != 'All') {
    $sql .= " AND ctn.title = '%s' ";
    $args[] = $get['customer_name'];
  }
  if ($get['account_no'] && $get['account_no'] != 'All') {
    $sql .= " AND acn.title = '%s' ";
    $args[] = $get['account_no'];
  }
  if ($get['account_no_nid'] && $get['account_no_nid'] != 'All') {
    $sql .= " AND acn.nid = '%s' ";
    $args[] = $get['account_no_nid'];
  }

  $header = array(
    array('data' => t('Serial Number'), 'field' => 'n.title', 'sort' => 'desc'),
    array('data' => t('Customer Name'), 'field' => 'ctn.title'),
    array('data' => t('Customer Account number'), 'field' => 'acn.title'),
    array('data' => t('Country'), 'field' => 'con.title'),
    array('data' => t('Region'), 'field' => 'rn.title'),
  );
  $sql .= " GROUP BY d.nid " . tablesort_sql($header);
  $count_query = "SELECT COUNT(*) FROM (" . $sql . ") AS subquery";

  return array('query' => $sql, 'count_query' => $count_query, 'args' => $args);
}

function covidien_device_list_form(&$form) {
  $form = array();
  $device_id = check_plain($_GET['device_type']) ? check_plain($_GET['device_type']) : $_SESSION['default_dtype']; //get
  $form_device_type = field_device_type_select($device_id);
  $form_device_type['select_device_type']['#id'] = 'edit-device-type';
  $form_device_type['select_device_type'] ['#name'] = 'device_type';
  $form['device_type'] = $form_device_type['select_device_type'];
  $form['sno'] = array(
    '#type' => 'textfield',
    '#id' => 'edit-sno',
    '#options' => $options,
    '#default_value' => check_plain($_GET['sno']),
    '#value' => check_plain($_GET['sno']),
    '#autocomplete_path' => 'covidien/devices/autocomplete',
    '#attributes' => array('onfocus' => 'covidien_devices_acl("devices");'),
  );
  $options_country['All'] = t('All');
  $country_result = db_query("SELECT nid, title FROM {node} WHERE type = 'country'");
  while ($crow = db_fetch_object($country_result)) {
    $options_country[$crow->nid] = $crow->title;
  }
  $form['country_nid'] = array(
    '#type' => 'select',
    '#id' => 'edit-country-nid',
    '#options' => $options_country,
    '#default_value' => check_plain($_GET['country_nid']),
    '#value' => check_plain($_GET['country_nid']),
  );
  $form['customer_name'] = array(
    '#type' => 'textfield',
    '#id' => 'customer_name',
    '#default_value' => check_plain($_GET['customer_name']),
    '#value' => check_plain($_GET['customer_name']),
    '#autocomplete_path' => 'covidien/admin/device/customername/filter',
    '#attributes' => array('onfocus' => 'covidien_customer_device_acl("account_number","customer_name", "customername");'),
  );
  $form['account_number'] = array(
    '#type' => 'textfield',
    '#id' => 'account_number',
    '#default_value' => check_plain($_GET['account_number']),
    '#value' => check_plain($_GET['account_number']),
    '#autocomplete_path' => 'covidien/admin/user/account/filter',
    '#attributes' => array('onfocus' => 'covidien_customer_device_acl("customer_name", "account_number", "account");', 'onblur' => 'get_covidien_customer_name_for_device($("#account_number").val(), "customer_name", "devices");'),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Go'),
    '#id' => 'edit-submit-device-information',
  );
  $form['#method'] = 'GET';
  $form['#theme'] = array('covidien_device_list_form');
  $form['#validate'] = array('covidien_device_list_form_validate');
  return $form;
}

function covidien_device_list_form_validate(&$form_state) {
  $sno = check_plain($_GET['sno']);
  $customer_name = check_plain($_GET['customer_name']);
  $account_number = check_plain($_GET['account_number']);
  if (!covidien_ui_input_validate($sno)) {
    form_set_error('sno', t('Invalid Serial Number'));
  }
  if (!covidien_ui_input_validate($customer_name)) {
    form_set_error('customer_name', t('Invalid Customer Name'));
  }
  if (!covidien_ui_input_validate($account_number)) {
    form_set_error('account_number', t('Invalid Customer Account Number'));
  }
}
