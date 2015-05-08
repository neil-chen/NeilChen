<?php

function software_audit_report_form() {
  $form = array();
  $form['#action'] = url('covidien/reports/software_audit_report');
  $form['#method'] = 'get';
  $form['select_type'] = array(
    '#type' => 'select',
    '#default_value' => '',
    '#validated' => TRUE,
    '#options' => array(
      1 => 'Software Audit by Device Type Report',
      2 => 'Software Audit by CoT Report',
    ),
  );
  $form['device_type'] = array(
    '#type' => 'select',
    '#default_value' => $device_type_id,
    '#value' => $device_type_id,
    '#validated' => TRUE,
    '#options' => get_device_type($_SESSION['default_cot']),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'View Report',
  );
  return $form;
}

function template_preprocess_software_audit_report_form(&$vars) {
  $vars['report_menu'] = covidien_report_filter_list();
}

function template_preprocess_software_audit_report(&$vars) {
  $pl_nid = $_SESSION['default_cot'];
  $type = check_plain($_GET['select_type']);
  $device_type_nid = check_plain($_GET['device_type']);
  if ($type == 1) {
    $table_list = software_audit_report_by_device_type($device_type_nid);
    $count = db_result(db_query("SELECT COUNT(*) FROM (" . software_audit_report_by_device_type_query() . ") AS count_query", $device_type_nid));
    $dt_rows = software_audit_report_by_cot_device_type_rows();
    $args = array();
    $args['device_type'] = $device_type_nid;
    $args['device_count'] = $dt_rows[$device_type_nid];
    $filters = get_software_audit_report_filter_list($args);
    $output = '';
    $output = theme('get_named_configurations_report_filter', $filters);
  } else {
    $table_list = software_audit_report_by_cot();
    $count = db_result(db_query("SELECT COUNT(*) FROM (" . software_audit_report_by_cot_query() . ") AS count_query", $pl_nid));
  }
  $vars['filters'] = $output;
  $vars['report_menu'] = covidien_report_filter_list();
  $vars['count'] = $count;
  $vars['table_list'] = $table_list;
}

function software_audit_report() {
  return theme('software_audit_report');
}

function get_software_audit_report_filter_list($args) {
  $product_line = covidien_get_product_line();
  $productline = node_load($product_line);
  $filters = array();
  $i = 0;
  $filters[$i]['label'] = t('Class of Trade:');
  $filters[$i]['value'] = $productline->title ? $productline->title : 'All';
  if (!empty($args['device_type'])) {
    $i++;
    $device_type = node_load($args['device_type']);
    $filters[$i]['label'] = t('Device Type:');
    $filters[$i]['value'] = $device_type->title ? $device_type->title : 'NULL';
  }
  if (!empty($args['device_count'])) {
    $i++;
    $filters[$i]['label'] = t('Total Of Devices:');
    $filters[$i]['value'] = $args['device_count'] ? $args['device_count'] : 'NULL';
  }
  return $filters;
}

function software_audit_report_by_device_type_country_rows($device_type_nid) {
  //count by country 
  $country_sql = "SELECT di.field_device_country_nid , COUNT(dpk.field_device_pk_nid) AS devices_count 
    FROM content_field_device_type dt
    join content_field_device_pk dpk on dt.nid = dpk.field_device_pk_nid and dt.field_device_type_nid = %d
    JOIN content_type_device_installation di ON dpk.nid = di.nid 
    GROUP BY di.field_device_country_nid";
  $country_result = db_query($country_sql, $device_type_nid);
  $country_rows = array();
  while ($country_row = db_fetch_object($country_result)) {
    $country_rows[$country_row->field_device_country_nid] = $country_row->devices_count;
  }
  return $country_rows;
}

function software_audit_report_by_device_type_total() {
  //count by total 
  $total_sql = "SELECT COUNT(dpk.field_device_pk_nid) AS devices_count 
    FROM content_field_device_pk dpk 
    JOIN content_type_device_service_history sh ON dpk.vid = sh.vid
    JOIN content_type_device_installation di ON sh.field_device_installation_pk_nid = di.nid";
  $total = db_result(db_query($total_sql));
  return $total;
}

function software_audit_report_by_device_type($device_type_nid) {
  $sql = software_audit_report_by_device_type_query();
  $country_rows = software_audit_report_by_device_type_country_rows($device_type_nid);
  $dt_rows = software_audit_report_by_cot_device_type_rows();
  $header = array(
    array('data' => 'Country', 'field' => 'swaudit.country', 'sort' => 'asc'),
    array('data' => 'Customer', 'field' => 'swaudit.customer'),
    array('data' => 'S/W Version', 'field' => 'swaudit.sw'),
    array('data' => 'Device Type', 'field' => 'dtn.title'),
    array('data' => '# of devices', 'field' => 'devices_count'),
    array('data' => '% Country'),
    array('data' => '% Overall'),
  );
  $rows = array();
  $count_query = "SELECT COUNT(*) FROM (" . $sql . ") AS count_query";
  $sql .= tablesort_sql($header);
  $result = pager_query($sql, 20, 0, $count_query, $device_type_nid);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['country'] = $row->country;
    $res['customer'] = $row->customer;
    $res['software'] = $row->sw;
    $res['device_type'] = $row->device_type;
    $res['devices_count'] = $row->devices_count;
    $res['country_count'] = round(($row->devices_count / $country_rows[$row->country_nid]) * 100, 5) . '%';
    $res['overall'] = round(($row->devices_count / $dt_rows[$row->device_type_nid]) * 100, 5) . '%';
    $rows[] = $res;
  }

  $output = theme_table($header, $rows);
  $output .= theme('pager', NULL, 20, 0);
  return $output;
}

function software_audit_report_by_cot_device_type_rows() {
  //count by device type 
  $dt_sql = "SELECT dt.field_device_type_nid, COUNT(dpk.nid) AS devices_count 
    FROM node dpk 
    JOIN content_field_device_type dt ON dpk.nid = dt.nid and dpk.type='device'
    JOIN content_field_expiration_datetime ed 
    on dpk.nid = ed.nid and dpk.vid = ed.vid and ed.field_expiration_datetime_value is null
    GROUP BY dt.field_device_type_nid";
  $dt_result = db_query($dt_sql);
  $dt_rows = array();
  while ($dt_row = db_fetch_object($dt_result)) {
    $dt_rows[$dt_row->field_device_type_nid] = $dt_row->devices_count;
  }
  return $dt_rows;
}

function software_audit_report_by_cot_total() {
  //count by total 
  $total_sql = "SELECT COUNT(dpk.field_device_pk_nid) AS devices_count 
    FROM content_field_device_pk dpk 
    JOIN content_field_device_type dt ON dpk.field_device_pk_nid = dt.nid";
  $total = db_result(db_query($total_sql));
  return $total;
}

function software_audit_report_by_cot() {
  $pl_nid = $_SESSION['default_cot'];
  $sql = software_audit_report_by_cot_query();
  $dt_rows = software_audit_report_by_cot_device_type_rows();
  $header = array(
    array('data' => 'Device Type', 'field' => 'swaudit.device_type', 'sort' => 'asc'),
    array('data' => 'Customer', 'field' => 'swaudit.customer'),
    array('data' => 'S/W version', 'field' => 'swaudit.sw'),
    array('data' => 'Device Count', 'field' => 'devices_count'),
    array('data' => '% Device Type'),
  );
  $rows = array();
  $count_query = "SELECT COUNT(*) FROM (" . $sql . ") AS count_query";
  $sql .= tablesort_sql($header);
  $result = pager_query($sql, 20, 0, $count_query, $pl_nid);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['device_type'] = $row->device_type;
    $res['customer'] = $row->customer;
    $res['software'] = $row->sw;
    $res['devices_count'] = $row->devices_count;
    $res['device_type_count'] = round(($row->devices_count / $dt_rows[$row->device_type_nid]) * 100, 5) . '%';
    $rows[] = $res;
  }
  $output = theme_table($header, $rows);
  $output .= theme('pager', NULL, 20, 0);
  return $output;
}

function software_audit_report_by_device_type_query() {
  $sql = "select swaudit.device_type_nid, swaudit.country_nid, swaudit.country, swaudit.customer, swaudit.sw, count(swaudit.device) as devices_count, device_type
    from (select distinct m.nid as device_type_nid, p.nid as country_nid, p.title as country, m.title as device_type,l.title as customer ,
    concat(h.title,' v', i.field_sw_version_value,' - p',i.field_sw_part_value) as sw,c.nid as device 
    from content_field_device_type b
    join node c on c.nid = b.nid and b.field_device_type_nid = %d
    join content_field_expiration_datetime e on c.nid = e.nid and c.vid = e.vid and e.field_expiration_datetime_value is null
    join content_type_device_component_history f on c.nid = f.field_component_device_nid
    join content_field_expiration_datetime g on g.nid = f.nid and g.vid = f.vid and g.field_expiration_datetime_value is null
    join node h on h.nid = f.field_device_component_nid
    join content_type_software i on h.nid = i.nid and h.vid = i.vid
    join content_type_device j on j.nid = c.nid and j.vid = c.vid
    join content_type_bu_customer k on j.field_device_owner_nid = k.nid
    join node l on k.field_customer_party_pk_nid = l.nid
    join node m on b.field_device_type_nid = m.nid
	join content_field_device_pk n on c.nid = n.field_device_pk_nid
	join content_type_device_installation o on n.nid = o.nid
	join node p on o.field_device_country_nid = p.nid) as swaudit
    group by swaudit.country, swaudit.customer, swaudit.sw";
  return $sql;
}

function software_audit_report_by_cot_query() {
  $sql = "select swaudit.device_type_nid, swaudit.device_type, swaudit.customer, swaudit.sw, count(swaudit.device) as devices_count
    from (select distinct m.nid as device_type_nid, m.title as device_type,l.title as customer ,
    concat(h.title,' v', i.field_sw_version_value,' - p',i.field_sw_part_value) as sw,c.nid as device 
    from content_field_device_product_line a 
    join content_field_device_type b on a.field_device_product_line_nid = %d and a.nid = b.field_device_type_nid
    join node c on c.nid = b.nid
    join content_field_expiration_datetime e on c.nid = e.nid and c.vid = e.vid and e.field_expiration_datetime_value is null
    join content_type_device_component_history f on c.nid = f.field_component_device_nid
    join content_field_expiration_datetime g on g.nid = f.nid and g.vid = f.vid and g.field_expiration_datetime_value is null
    join node h on h.nid = f.field_device_component_nid
    join content_type_software i on h.nid = i.nid and h.vid = i.vid
    join content_type_device j on j.nid = c.nid and j.vid = c.vid
    join content_type_bu_customer k on j.field_device_owner_nid = k.nid
    join node l on k.field_customer_party_pk_nid = l.nid
    join node m on b.field_device_type_nid = m.nid) as swaudit
    group by swaudit.device_type, swaudit.customer, swaudit.sw";
  return $sql;
}

function software_audit_report_by_device_type_all($device_type_nid) {
  $country_rows = software_audit_report_by_device_type_country_rows($device_type_nid);
  $dt_rows = software_audit_report_by_cot_device_type_rows();
  $sql = software_audit_report_by_device_type_query();
  $result = db_query($sql, $device_type_nid);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['country'] = $row->country;
    $res['customer'] = $row->customer;
    $res['software'] = $row->sw;
    $res['device_type'] = $row->device_type;
    $res['devices_count'] = $row->devices_count;
    $res['country_count'] = round(($row->devices_count / $country_rows [$row->country_nid]) * 100, 5) . '%';
    $res['overall'] = round(( $row->devices_count / $dt_rows[$row->device_type_nid]) * 100, 5) . '%';
    $rows[] = $res;
  }
  return $rows;
}

function software_audit_report_by_cot_all() {
  $pl_nid = $_SESSION['default_cot'];
  $dt_rows = software_audit_report_by_cot_device_type_rows();
  $sql = software_audit_report_by_cot_query();
  $result = db_query($sql, $pl_nid);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['device_type'] = $row->device_type;
    $res['customer'] = $row->customer;
    $res['software'] = $row->sw;
    $res['devices_count'] = $row->devices_count;
    $res['device_type_count'] = round(($row->devices_count / $dt_rows[$row->device_type_nid]) * 100, 5) . '%';
    $rows[] = $res;
  }
  return $rows;
}

function software_audit_report_csv() {
  drupal_set_header('Cache-control: public');
  drupal_set_header('Content-Type: text/csv');
  drupal_set_header('Content-Disposition: attachment; filename=Software_Audit_Report.csv');
  $type = check_plain($_GET['select_type']);
  $device_type_nid = check_plain($_GET['device_type']);
  $dt_rows = software_audit_report_by_cot_device_type_rows();
  if ($type == 1) {
    $header = array('Country', 'Customer', 'S/W version', 'Device Type', ' #of devices', '% Country', '% Overall');
    $rows = software_audit_report_by_device_type_all($device_type_nid);
    $args = array();
    $args['device_type'] = $device_type_nid;
    $args['device_count'] = $dt_rows[$device_type_nid];
    $filters = get_software_audit_report_filter_list($args);
    $output = '';
    foreach ($filters as $filter) {
      $output .= implode(',', $filter) . "\n";
    }
  } else {
    $header = array('Device Type', 'Customer', 'S/W version', 'Device Count', '% Device Type');
    $rows = software_audit_report_by_cot_all();
  }
  //result tables
  $output .= implode(',', $header) . "\n";
  foreach ($rows as $row) {
    if ($row) {
      $output .= '"' . implode('","', $row) . "\"\n";
    }
  }
  $output .= "\n\n\nCovidien Report";
  echo $output;
  exit();
}

function software_audit_report_xls() {
  drupal_set_header('Cache-control: public');
  drupal_set_header("Content-type:application/vnd.ms-excel");
  drupal_set_header("Content-Disposition:attachment;filename=Software_Audit_Report.xls");
  $type = check_plain($_GET['select_type']);
  $device_type_nid = check_plain($_GET['device_type']);
  $dt_rows = software_audit_report_by_cot_device_type_rows();
  $output = '';
  if ($type == 1) {
    $header = array('Country', 'Customer', 'S/W version', 'Device Type', '# of devices', '% Country', '% Overall');
    $rows = software_audit_report_by_device_type_all($device_type_nid);
    $args = array();
    $args['device_type'] = $device_type_nid;
    $args['device_count'] = $dt_rows[$device_type_nid];
    $filters = get_software_audit_report_filter_list($args);
    $output .= theme('get_named_configurations_report_filter', $filters);
  } else {
    $header = array('Device Type', 'Customer', 'S/W version', 'Device Count', '% Device Type');
    $rows = software_audit_report_by_cot_all();
  }
  $output .= theme('table', $header, $rows);
  echo $output;
  exit;
}

function software_audit_report_pdf() {
  $type = check_plain($_GET['select_type']);
  $device_type_nid = check_plain($_GET['device_type']);
  $dt_rows = software_audit_report_by_cot_device_type_rows();
  $output = '';
  if ($type == 1) {
    $header = array('Country', 'Customer', 'S/W version', 'Device Type', '# of devices', '% Country', '% Overall');
    $rows = software_audit_report_by_device_type_all($device_type_nid);
    $args = array();
    $args['device_type'] = $device_type_nid;
    $args['device_count'] = $dt_rows[$device_type_nid];
    $filters = get_software_audit_report_filter_list($args);
    $output .= theme('get_named_configurations_report_filter', $filters);
    $output .= "<br><br>";
  } else {
    $header = array('Device Type', 'Customer', 'S/W version', 'Device Count', '% Device Type');
    $rows = software_audit_report_by_cot_all();
  }
  $output .= theme('table', $header, $rows, array('class' => 'views-table', 'style' => 'margin:0; width:100%;'));
  //use pdf class
  module_load_include('php', 'views_pdf', 'views_pdf_template');
  $pdf = new PdfTemplate($output);
  $pdf->AddPage(); //add a page
  $pdf->SetTitle('Software Audit Report'); //set title 
  $pdf->SetFont('', '', 8); //set font size
  $pdf->writeHtml($output, true, 0, true, 0); //write html 
  $pdf->Output('Software_Audit_Report.pdf', 'D'); //D is download
  exit();
}
