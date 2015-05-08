<?php

function software_version_report_form() {
  $form = array();
  $form['#action'] = url('covidien/reports/software_version_report');
  $form['#method'] = 'get';
  $form['#validate'] = array('software_version_report_form_validate');
  $form['device_type'] = array(
    '#type' => 'select',
    '#validated' => TRUE,
    '#options' => get_device_type($_SESSION['default_cot']),
  );
  $form['country'] = array(
    '#type' => 'select',
    '#default_value' => '',
    '#validated' => TRUE,
    '#options' => get_country(),
  );
  $form['region'] = array(
    '#type' => 'select',
    '#default_value' => '',
    '#validated' => TRUE,
    '#options' => get_region(),
  );
  $form['and_or'] = array(
    '#type' => 'hidden',
    '#id' => 'and_or',
    '#default_value' => 'AND',
  );
  $form['customer_name'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#autocomplete_path' => 'covidien/reports/filtertype/customername/autocomplete',
  );
  $form['customer_address'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#autocomplete_path' => 'covidien/reports/filtertype/customer_address/autocomplete',
  );
  $form['customer_city'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#autocomplete_path' => 'covidien/reports/filtertype/customer_city/autocomplete',
  );
  $form['customer_state'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#autocomplete_path' => 'covidien/reports/filtertype/customer_state/autocomplete',
  );
  $form['user_facility'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#autocomplete_path' => 'covidien/reports/filtertype/user_facility/autocomplete',
  );
  $form['ds_number'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#autocomplete_path' => 'covidien/reports/filtertype/ds_number/autocomplete',
  );
  $form['sw_version'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#autocomplete_path' => 'covidien/reports/filtertype/sw_version/autocomplete',
  );
  $form['last_date_docked'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#maxlength' => 10,
    '#date_format' => 'm/d/Y',
    '#date_year_range' => '-5:+6',
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'View Report',
  );

  return $form;
}

function software_version_report_form_validate() {
  if ($_GET['device_type'] == 'all' || $_GET['device_type'] == '') {
    form_set_error('device_type', t("Invalid Device Type"));
  }
  if ($_GET['country'] == 'all' || $_GET['country'] == '') {
    form_set_error('country', t("Invalid country"));
  }
  if (count(form_get_errors())) {
    drupal_goto(referer_uri());
  }
}

function template_preprocess_software_version_report_form(&$vars) {
  $vars['report_menu'] = covidien_report_filter_list();
}

function template_preprocess_software_version_report(&$vars) {
  $get = filter_xss_arr($_GET);
  $vars['device_type'] = ($get['device_type'] && $get['device_type'] != 'all') ? db_result(db_query("SELECT title FROM {node} WHERE type='devicetype' AND nid=%d", $get['device_type'])) : 'All';
  $vars['country'] = ($get['country'] && $get['country'] != 'all') ? db_result(db_query("SELECT title FROM {node} WHERE type='country' AND nid=%d", $get['country'])) : 'All';
  $vars['region'] = ($get['region'] && $get['region'] != 'all') ? db_result(db_query("SELECT title FROM {node} WHERE type='region' AND nid=%d", $get['region'])) : 'All';
  $vars['customer_name'] = $get['customer_name'];
  $vars['customer_address'] = $get['customer_address'];
  $vars['customer_city'] = $get['customer_city'];
  $vars['customer_state'] = $get['customer_state'];
  $vars['user_facility'] = $get['user_facility'];
  $vars['ds_number'] = $get['ds_number'];
  $vars['sw_version'] = $get['sw_version'];
  $vars['last_date_docked'] = $get['last_date_docked']['date'];
  $vars['filter_url'] = '?device_type=' . $get['device_type'] . '&country=' . $get['country'] . '&and_or=' . $get['and_or'] . '&region=' . $get['region']
    . '&customer_name=' . $get['customer_name'] . '&ds_number=' . $get['ds_number'] . '&sw_version=' . $get['sw_version']
    . '&last_date_docked=' . $get['last_date_docked'];
  $vars['report_menu'] = covidien_report_filter_list();
  $vars['table_list'] = software_version_report_list();
}

function software_version_report() {
  software_version_report_form_validate();
  return theme('software_version_report');
}

function software_version_report_list() {
  $query = software_version_report_query();
  $count_query = "SELECT COUNT(*) FROM (" . $query['query'] . ") AS count_query";
  $header = software_version_report_header();
  $query['query'] .= tablesort_sql($header);
  $result = pager_query($query['query'], 20, 0, $count_query, $query['args']);

  $i = 0;
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$i]['region'] = $row->region;
    $rows[$i]['country'] = $row->country;
    $rows[$i]['customer'] = $row->customer;
    $rows[$i]['address'] = $row->address1 . ' ' . $row->address2;
    $rows[$i]['city'] = $row->city;
    $rows[$i]['state'] = $row->state;
    $rows[$i]['facility'] = $row->facility;
    $rows[$i]['serial_number'] = $row->serial_number;
    $rows[$i]['software'] = $row->sw_name . ' v' . $row->sw_version;
    $rows[$i]['datetime'] = $row->datetime;
    $i++;
  }
  $output = theme_table($header, $rows);
  $output .= theme('pager', NULL, 20, 0);
  return $output;
}

function software_version_report_query() {
  $pl_nid = $_SESSION['default_cot'];
  $get = filter_xss_arr($_GET);
  $sql = "SELECT di.nid, rn.title AS region, cn.title AS country, cusn.title AS customer,
    pa.field_postal_address_line1_value AS address1, pa.field_postal_address_line2_value AS address2,
    pa.field_postal_address_city_value AS city, pa.field_state_province_value AS state,
    di.field_usr_provided_dev_facility_value AS facility,
    d.field_device_serial_number_value AS serial_number,
    sn.title AS sw_name, s.field_sw_version_value AS sw_version,
    MAX(sh.field_service_datetime_value) AS datetime
    FROM {content_type_device_installation} di 
    JOIN {content_field_device_pk} dp ON di.nid = dp.nid 
    JOIN {content_field_device_type} fdt ON dp.field_device_pk_nid = fdt.nid 
    JOIN {content_type_device} d ON dp.field_device_pk_nid = d.nid 
    JOIN {content_type_device_service_history} sh ON di.nid = sh.field_device_installation_pk_nid 
    JOIN {content_type_device_component_history} dch ON d.nid = dch.field_component_device_nid 
    JOIN {node} sn ON dch.field_device_component_nid = sn.nid 
    JOIN {node} cn ON di.field_device_country_nid = cn.nid 
    LEFT JOIN {content_type_postal_address} pa ON di.field_location_id_nid = pa.nid 
    JOIN {content_type_software} s ON sn.vid = s.vid 
    JOIN {content_type_bu_customer} bc ON d.field_device_owner_nid = bc.nid 
    JOIN {node} cusn ON bc.field_customer_party_pk_nid = cusn.nid 
    JOIN {content_field_device_product_line} dpl ON fdt.field_device_type_nid = dpl.nid
    LEFT JOIN {node} rn ON d.region_nid = rn.nid 
    WHERE dpl.field_device_product_line_nid = %d ";
  $args = array($pl_nid);
  if ($get['device_type'] && $get['device_type'] != 'all') {
    $sql .= " AND fdt.field_device_type_nid = %d ";
    $args[] = $get['device_type'];
  }
  if (($get['and_or'] == 'OR') && (($get['country'] && $get['country'] != 'all') && ($get['region'] && $get['region'] != 'all'))) {
    $sql .= " AND (di.field_device_country_nid = %d OR d.region_nid = %d) ";
    $args[] = $get['country'];
    $args[] = $get['region'];
  } else {
    if ($get['country'] && $get['country'] != 'all') {
      $sql .= " AND di.field_device_country_nid = %d ";
      $args[] = $get['country'];
    }
    if ($get['region'] && $get['region'] != 'all') {
      $sql .= " AND d.region_nid = %d ";
      $args[] = $get['region'];
    }
  }
  if ($get['customer_name'] && $get['customer_name'] != 'all') {
    $sql .= " AND cusn.title = '%s' ";
    $args[] = $get['customer_name'];
  }
  if ($get['customer_address'] && $get['customer_address'] != 'all') {
    $sql .= " AND (pa.field_postal_address_line1_value = '%s' OR pa.field_postal_address_line2_value = '%s') ";
    $args[] = $get['customer_address'];
    $args[] = $get['customer_address'];
  }
  if ($get['customer_city'] && $get['customer_city'] != 'all') {
    $sql .= " AND pa.field_postal_address_city_value = '%s' ";
    $args[] = $get['customer_city'];
  }
  if ($get['customer_state'] && $get['customer_state'] != 'all') {
    $sql .= " AND pa.field_state_province_value = '%s' ";
    $args[] = $get['customer_state'];
  }
  if ($get['user_facility'] && $get['user_facility'] != 'all') {
    $sql .= " AND di.field_usr_provided_dev_facility_value = '%s' ";
    $args[] = $get['user_facility'];
  }
  if ($get['ds_number'] && $get['ds_number'] != 'all') {
    $sql .= " AND d.field_device_serial_number_value = '%s' ";
    $args[] = $get['ds_number'];
  }
  if ($get['sw_version'] && $get['sw_version'] != 'all') {
    $sw = explode(' - ', $get['sw_version']);
    $sw_name = trim($sw[0]);
    $sw_version = trim($sw[1]);
    $sql .= " AND sn.title = '%s' AND s.field_sw_version_value = '%s' ";
    $args[] = $sw_name;
    $args[] = $sw_version;
  }
  if ($get['last_date_docked']['date'] && $get['last_date_docked']['date'] != 'all') {
    $strtotime = strtotime($get['last_date_docked']['date']);
    $sql .= " AND (sh.field_service_datetime_value BETWEEN '%s' AND '%s') ";
    $args[] = date('Y-m-d 00:00:00', $strtotime);
    $args[] = date('Y-m-d 23:59:59', $strtotime);
  }
  $sql .= " GROUP BY di.nid, sn.nid  ";
  return array('query' => $sql, 'args' => $args);
}

function software_version_report_rows() {
  $query = software_version_report_query();
  $result = db_query($query['query'], $query['args']);
  $rows = array();
  $i = 0;
  while ($row = db_fetch_object($result)) {
    $rows[$i]['region'] = $row->region;
    $rows[$i]['country'] = $row->country;
    $rows[$i]['customer'] = $row->customer;
    $rows[$i]['address'] = $row->address1 . ' ' . $row->address2;
    $rows[$i]['city'] = $row->city;
    $rows[$i]['state'] = $row->state;
    $rows[$i]['facility'] = $row->facility;
    $rows[$i]['serial_number'] = $row->serial_number;
    $rows[$i]['software'] = $row->sw_name . ' v' . $row->sw_version;
    $rows[$i]['datetime'] = $row->datetime;
    $i++;
  }
  return $rows;
}

function software_version_report_header() {
  $header = array(
    array('data' => 'Region', 'field' => 'rn.title', 'sort' => 'asc'),
    array('data' => 'Country', 'field' => 'cn.title'),
    array('data' => 'Customer Name', 'field' => 'cusn.title'),
    array('data' => 'Customer Address', 'field' => 'pa.field_postal_address_line1_value, pa.field_postal_address_line2_value'),
    array('data' => 'City', 'field' => 'pa.field_postal_address_city_value'),
    array('data' => 'State', 'field' => 'pa.field_state_province_value'),
    array('data' => 'Facility Name ', 'field' => 'di.field_usr_provided_dev_facility_value'),
    array('data' => 'Serial Number', 'field' => 'd.field_device_serial_number_value'),
    array('data' => 'Software Name & Version', 'field' => 'sn.title, s.field_sw_version_value'),
    array('data' => 'Last Date Docked', 'field' => 'datetime'),
  );
  return $header;
}

function software_version_report_all() {
  $header = software_version_report_header();
  $rows = software_version_report_rows();
  $output = theme_table($header, $rows);
  return $output;
}

function software_version_report_csv() {
  drupal_set_header('Cache-control: public');
  drupal_set_header('Content-Type: text/csv');
  drupal_set_header('Content-Disposition: attachment; filename=Software_Versions_Report.csv');
  $header = array_map('current', software_version_report_header());
  $rows = software_version_report_rows();
  //result tables
  $output = implode(',', $header) . "\n";
  foreach ($rows as $row) {
    if ($row) {
      $output .= '"' . implode('","', $row) . "\"\n";
    }
  }
  $output .= "\n\n\nCovidien Report";
  echo $output;
  exit();
}

function software_version_report_xls() {
  drupal_set_header('Cache-control: public');
  drupal_set_header("Content-type:application/vnd.ms-excel");
  drupal_set_header("Content-Disposition:attachment;filename=Software_Versions_Report.xls");
  $output = software_version_report_all();
  echo $output;
  exit;
}

function software_version_report_pdf() {
  $header = array_map('current', software_version_report_header());
  $rows = software_version_report_rows();
  $output = theme('table', $header, $rows, array('class' => 'views-table', 'style' => 'margin:0; width:100%;'));
  //use pdf class
  module_load_include('php', 'views_pdf', 'views_pdf_template');
  $pdf = new PdfTemplate($output);
  $pdf->AddPage(); //add a page
  $pdf->SetTitle('Software Versions Report'); //set title 
  $pdf->SetFont('', '', 8); //set font size
  $pdf->writeHtml($output, true, 0, true, 0); //write html 
  $pdf->Output('Software_Versions_Report.pdf', 'D'); //D is download
  exit();
}

function customer_address_autocomplete() {
  $name = check_plain(trim(arg(5)));
  $result = db_query("SELECT field_postal_address_line1_value FROM {content_type_postal_address} WHERE field_postal_address_line1_value LIKE '%%%s%%' GROUP BY field_postal_address_line1_value LIMIT 20", $name);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->field_postal_address_line1_value] = $row->field_postal_address_line1_value;
  }
  echo drupal_to_js($rows);
  exit();
}

function customer_city_autocomplete() {
  $name = check_plain(trim(arg(5)));
  $result = db_query("SELECT field_postal_address_city_value FROM {content_type_postal_address} WHERE field_postal_address_city_value LIKE '%%%s%%' GROUP BY field_postal_address_city_value LIMIT 20", $name);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->field_postal_address_city_value] = $row->field_postal_address_city_value;
  }
  echo drupal_to_js($rows);
  exit();
}

function customer_state_autocomplete() {
  $name = check_plain(trim(arg(5)));
  $result = db_query("SELECT field_state_province_value FROM {content_type_postal_address} WHERE field_state_province_value LIKE '%%%s%%' GROUP BY field_state_province_value LIMIT 20", $name);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->field_state_province_value] = $row->field_state_province_value;
  }
  echo drupal_to_js($rows);
  exit();
}

function user_facility_autocomplete() {
  $name = check_plain(trim(arg(5)));
  $result = db_query("SELECT field_usr_provided_dev_facility_value FROM {content_type_device_installation} WHERE field_usr_provided_dev_facility_value LIKE '%%%s%%' GROUP BY field_usr_provided_dev_facility_value LIMIT 20", $name);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->field_usr_provided_dev_facility_value] = $row->field_usr_provided_dev_facility_value;
  }
  echo drupal_to_js($rows);
  exit();
}

function ds_number_autocomplete() {
  $name = check_plain(trim(arg(5)));
  $result = db_query("SELECT title FROM {node} WHERE type='device' AND title LIKE '%%%s%%' GROUP BY title LIMIT 20", $name);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->title] = $row->title;
  }
  echo drupal_to_js($rows);
  exit();
}

function sw_version_autocomplete() {
  $name = check_plain(trim(arg(5)));
  $result = db_query("SELECT n.title, s.field_sw_version_value FROM node n JOIN {content_type_software} s ON n.vid = s.vid WHERE n.title LIKE '%%%s%%' OR s.field_sw_version_value LIKE '%%%s%%' GROUP BY n.title, s.field_sw_version_value", $name, $name);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $value = $row->title . ' - ' . $row->field_sw_version_value;
    $rows[$value] = $value;
  }
  echo drupal_to_js($rows);
  exit();
}
