<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function named_configurations_report_form() {
  $device_type_id = $_SESSION['default_dtype'];
  $form = array();
  $form['#action'] = url('covidien/reports/named_configurations_report');
  $form['#method'] = 'get';
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

function template_preprocess_named_configurations_report_form(&$vars) {
  $vars['report_menu'] = covidien_report_filter_list();
}

function named_configurations_report_form_validate() {
  $args = get_named_configurations_report_args();
  if ($args['device_type'] == 'all') {
    form_set_error('device_type', t("Invalid Device Type"));
  }
}

function named_configurations_report() {
  named_configurations_report_form_validate();
  if (count(form_get_errors())) {
    drupal_goto(referer_uri());
  }
  drupal_set_title(t('Named Configurations Report'));
  $args = get_named_configurations_report_args();
  $filters = get_named_configurations_report_filter_list($args);

  $filter_url = request_uri();
  if ($filter_url != '') {
    $export_filter_arr = explode('?', $filter_url);
    $filter_url = $export_filter_arr[1];
  }
  $filters['url'] = $filter_url;
  #$filters['count'] = count($rows_s); 
  
  $header_s = array(t('System'), t('Type'), t('Hardware'), t('Software'), t('Firmware'));
  $rows_sys = get_named_configurations_report_sys_data($args,false);
  
  $header = array(t('Configuration Name'), t('Type'), t('Components'), t('Part Number & Revision'));
  $rows_h = get_named_configurations_report_h_data($args,false);
  $rows_s = get_named_configurations_report_s_data($args,false);
  $rows_f = get_named_configurations_report_f_data($args,false);
  
  $output = '';
  $output .= theme('get_named_configurations_report_filter', $filters);
  $data['table'][0] = theme_table($header_s, $rows_sys,array('class'=>'named-configuration-report-item-table'));
  $output .= theme_table(array(array('data'=>'Named System Configuration','style'=>'text-align:center')), $data, array('class'=>'cfg-table'));
  $output .= "<br>";
  
  $data['table'][0] = theme_table($header, $rows_h,array('class'=>'named-configuration-report-item-table'));
  $output .= theme_table(array(array('data'=>'Named Hardware Configuration','style'=>'text-align:center')), $data, array('class'=>'cfg-table'));
  $output .= "<br>";
  
  $data['table'][0] = theme_table($header, $rows_s,array('class'=>'named-configuration-report-item-table'));
  $output .= theme_table(array(array('data'=>'Named Software Configuration','style'=>'text-align:center')), $data, array('class'=>'cfg-table'));
  $output .= "<br>";
  
  $data['table'][0] = theme_table($header, $rows_f,array('class'=>'named-configuration-report-item-table'));
  $output .= theme_table(array(array('data'=>'Named Firmware Configuration','style'=>'text-align:center')), $data, array('class'=>'cfg-table'));
  $output .= "<br>";
  
  $output .= theme('get_named_configurations_report_buttom', $filters);

  return $output;
}


function get_named_configurations_report_filter_list($args) {

  $product_line = covidien_get_product_line();
  $productline = node_load($product_line);
  $filters = array();
  $i = 0;
  $filters[$i]['label'] = t('Class of Trade:');
  $filters[$i]['value'] = $productline->title ? $productline->title : 'All';
  $i++;
  $device_type = node_load($args['device_type']);
  $filters[$i]['label'] = t('Device Type:');
  $filters[$i]['value'] = $device_type->title ? $device_type->title : 'NULL';
  
  return $filters;
}

function get_named_configurations_report_csv() {
  drupal_set_header('Cache-control: public');
  drupal_set_header('Content-Type: text/csv');
  drupal_set_header('Content-Disposition: attachment; filename=Named_Configurations_Report.csv');
  $args['device_type'] = check_plain(arg(3));
  //filters
  $filters = get_named_configurations_report_filter_list($args);
  //header
  $header_s = array(t('System'), t('Type'), t('Hardware'), t('Software'), t('Firmware'));
  $header = array(t('Configuration Name'), t('Type'), t('Components'), t('Part Number & Revision'));
  //result tables
  $rows = get_named_configurations_report_sys_data($args,false);
  $output = '';
  foreach ($filters as $filter) {
    $output .= implode(',', $filter) . "\n";
  }
  $output .= "\n" .'Named System Configuration';
  $output .= "\n" . implode(',', $header_s) . "\n";
  foreach ($rows as $row) {
    if ($row) {
      $output .= '"' . implode('","', $row) . "\"\n";
    }
  }
  
  $rows = get_named_configurations_report_h_data($args,false);
  $output .= "\n" .'Named Hardware Configuration';
  $output .= "\n" . implode(',', $header) . "\n";
  foreach ($rows as $row) {
    if ($row) {
      $output .= '"' . implode('","', $row) . "\"\n";
    }
  }
  
  $rows = get_named_configurations_report_s_data($args,false);
  $output .= "\n" .'Named Software Configuration';
  $output .= "\n" . implode(',', $header) . "\n";
  foreach ($rows as $row) {
    if ($row) {
      $output .= '"' . implode('","', $row) . "\"\n";
    }
  }

  $rows = get_named_configurations_report_f_data($args,false);
  $output .= "\n" .'Named Firmware Configuration';
  $output .= "\n" . implode(',', $header) . "\n";
  foreach ($rows as $row) {
    if ($row) {
      $output .= '"' . implode('","', $row) . "\"\n";
    }
  }
  //$output .= "\n\n\nCovidien Report";
  echo $output;
  exit();
}

function get_named_configurations_report_pdf() {
  $args['device_type'] = check_plain(arg(3));
  $filters = get_named_configurations_report_filter_list($args);
  //header
  $header_s = array(t('System'), t('Type'), t('Hardware'), t('Software'), t('Firmware'));
  $header = array(t('Configuration Name'), t('Type'), t('Components'), t('Part Number & Revision'));
  $rows_sys = get_named_configurations_report_sys_data($args,false);
  $rows_h = get_named_configurations_report_h_data($args,false);
  $rows_s = get_named_configurations_report_s_data($args,false);
  $rows_f = get_named_configurations_report_f_data($args,false);
  $output = '';
  $output .= theme('get_named_configurations_report_filter', $filters);
  $output .= "<br><br>";
  $data['table'][0] = theme_table($header_s, $rows_sys);
  $output .= theme_table(array(array('data'=>'Named System Configuration','style'=>'text-align:center')), $data);
  $output .= "<br><br>";
  
  $data['table'][0] = theme_table($header, $rows_h);
  $output .= theme_table(array(array('data'=>'Named Hardware Configuration','style'=>'text-align:center')), $data);
  $output .= "<br><br>";
  
  $data['table'][0] = theme_table($header, $rows_s);
  $output .= theme_table(array(array('data'=>'Named Software Configuration','style'=>'text-align:center')), $data);
  $output .= "<br><br>";
  
  $data['table'][0] = theme_table($header, $rows_f);
  $output .= theme_table(array(array('data'=>'Named Firmware Configuration','style'=>'text-align:center')), $data);
  $output .= "<br><br>";
  //use pdf class
  module_load_include('php', 'views_pdf', 'views_pdf_template');
  $pdf = new PdfTemplate($output);
  $pdf->AddPage(); //add a page
  $pdf->SetTitle('Named Configurations Report'); //set title 
  $pdf->SetFont('', '', 8); //set font size
  $pdf->writeHtml($output, true, 0, true, 0); //write html 
  $pdf->Output('Named_Configurations_Report.pdf', 'D'); //D is download
  exit();
}

function get_named_configurations_report_xls() {
  drupal_set_header('Cache-control: public');
  drupal_set_header("Content-type:application/vnd.ms-excel");
  drupal_set_header("Content-Disposition:attachment;filename=Named_Configurations_Report.xls");
  $args['device_type'] = check_plain(arg(3));
  $filters = get_named_configurations_report_filter_list($args);
  $header_s = array(t('System'), t('Type'), t('Hardware'), t('Software'), t('Firmware'));
  $header = array(t('Configuration Name'), t('Type'), t('Components'), t('Part Number & Revision'));
  $rows_sys = get_named_configurations_report_sys_data($args,false);
  $rows_h = get_named_configurations_report_h_data($args,false);
  $rows_s = get_named_configurations_report_s_data($args,false);
  $rows_f = get_named_configurations_report_f_data($args,false);
  $output = '';
  $output .= theme('get_named_configurations_report_filter', $filters);
  $data['table'][0] = theme_table($header_s, $rows_sys);
  $output .= theme_table(array('Named System Configuration'), $data);
  $output .= "\n";
  
  $data['table'][0] = theme_table($header, $rows_h);
  $output .= theme_table(array('Named Hardware Configuration'), $data);
  $output .= "\n";
  
  $data['table'][0] = theme_table($header, $rows_s);
  $output .= theme_table(array('Named Software Configuration'), $data);
  $output .= "\n";
  
  $data['table'][0] = theme_table($header, $rows_f);
  $output .= theme_table(array('Named Firmware Configuration'), $data);
  $output .= "\n";
  echo $output;
  exit;
}

function get_named_configurations_report_args() {
  $args = array();
  $args['device_type'] = check_plain($_GET['device_type']);
  return $args;
}

function get_named_configurations_report_sys_data($args, $pager = true) {
  $query_args = array_filter($args);
  $new_query_args = array();
  $new_query_args['device_type'] = $query_args['device_type'];
  $query = "select nid, title as sys_cfg_name, name as substatus, max(hw_cfg) as hw_cfg,
  max(sw_cfg) as sw_cfg, max(fw_cfg) as fw_cfg
  from (select node.nid,
      node.title,
      d.name,
      case
          when g.name = 'hardware_configuration' then concat(f.title, ' v', h.version)
      END as hw_cfg,
      case
          when g.name = 'software_configuration' then concat(f.title, ' v', h.version)
      END as sw_cfg,
      case
          when g.name = 'firmware_configuration' then concat(f.title, ' v', h.version)
      END as fw_cfg
  from
      named_configuration a
          join
      node b ON a.device_type_id = b.nid
          and b.nid = %d
          join
      node ON a.nid = node.nid
          join
      named_configuration_type c ON a.type_id = c.id
          and c.name = 'system_configuration'
          join
      named_configuration_substatus d ON a.substatus = d.id
          join
      named_configuration_relation e ON a.nid = e.left_nid
          join
      node f ON e.right_nid = f.nid
          join
      named_configuration_type g ON e.right_type = g.id
          join
      named_configuration h ON e.right_nid = h.nid) as temp group by 1 order by substatus,nid"; 
  $count_query = "SELECT COUNT(*) FROM (" . $query . ") AS count_query"; 
  if($pager){
    $pageSize = 10;  
    $result = pager_query($query, $pageSize, 0, $count_query, $new_query_args);
  }else{
    $result = db_query($query, $new_query_args);
  }
  $rows = array(); 
  while ($row = db_fetch_object($result)) {
    $rows[$row->nid]['sys_cfg_name'] = $row->sys_cfg_name;
    $rows[$row->nid]['sys_cfg_substutas'] = $row->substatus;
    $rows[$row->nid]['hw_cfg'] = $row->hw_cfg;
    $rows[$row->nid]['sw_cfg'] = $row->sw_cfg;
    $rows[$row->nid]['fw_cfg'] = $row->fw_cfg;
  } 
  return $rows;
}

function get_named_configurations_report_h_data($args, $pager = true) {
  $query_args = array_filter($args);
  $new_query_args = array();
  $new_query_args['device_type'] = $query_args['device_type'];
  $query = "select node.nid,
      node.title as hw_cfg_name,
      d.name as substatus,
      f.title as hw_name,
      concat(h.field_hw_part_value,' v', h.field_hw_version_value) as partandversion
  from
      named_configuration a
          join
      node b ON a.device_type_id = b.nid
          and b.nid = %d
          join
      node ON a.nid = node.nid
          join
      named_configuration_type c ON a.type_id = c.id
          and c.name = 'hardware_configuration'
          join
      named_configuration_substatus d ON a.substatus = d.id
          join
      named_configuration_relation e ON a.nid = e.left_nid
          join
      node f ON e.right_nid = f.nid
          join
      named_configuration_type g ON e.right_type = g.id
          join
      content_type_hardware h ON f.nid = h.nid and f.vid = h.vid order by substatus,nid";
  $count_query = "SELECT COUNT(*) FROM (" . $query . ") AS count_query"; 
  if($pager){
    $pageSize = 10;  
    $result = pager_query($query, $pageSize, 0, $count_query, $new_query_args);
  }else{
    $result = db_query($query, $new_query_args);
  }
  
  $rows = array(); 
  while ($row = db_fetch_object($result)) {
    $rows[$row->nid]['hw_cfg_name'] = $row->hw_cfg_name;
    $rows[$row->nid]['hw_cfg_substutas'] = $row->substatus;
    $rows[$row->nid]['hw_name'] = $row->hw_name;
    $rows[$row->nid]['hw_partandversion'] = $row->partandversion;
  } 
  return $rows;
}

function get_named_configurations_report_s_data($args, $pager = true) {
  $query_args = array_filter($args);
  $new_query_args = array();
  $new_query_args['device_type'] = $query_args['device_type'];
  $query = "select node.nid,
      node.title as sw_cfg_name,
      d.name as substatus,
      f.title as sw_name,
      concat(h.field_sw_part_value,' v', h.field_sw_version_value) as partandversion
  from
      named_configuration a
          join
      node b ON a.device_type_id = b.nid
          and b.nid = %d
          join
      node ON a.nid = node.nid
          join
      named_configuration_type c ON a.type_id = c.id
          and c.name = 'software_configuration'
          join
      named_configuration_substatus d ON a.substatus = d.id
          join
      named_configuration_relation e ON a.nid = e.left_nid
          join
      node f ON e.right_nid = f.nid
          join
      named_configuration_type g ON e.right_type = g.id
          join
      content_type_software h ON f.nid = h.nid and f.vid = h.vid order by substatus,nid";
  $count_query = "SELECT COUNT(*) FROM (" . $query . ") AS count_query"; 
  if($pager){
    $pageSize = 10;  
    $result = pager_query($query, $pageSize, 0, $count_query, $new_query_args);
  }else{
    $result = db_query($query, $new_query_args);
  }
  
  $rows = array(); 
  while ($row = db_fetch_object($result)) {
    $rows[$row->nid]['sw_cfg_name'] = $row->sw_cfg_name;
    $rows[$row->nid]['sw_cfg_substutas'] = $row->substatus;
    $rows[$row->nid]['sw_name'] = $row->sw_name;
    $rows[$row->nid]['sw_partandversion'] = $row->partandversion;
  } 
  return $rows;
}

function get_named_configurations_report_f_data($args, $pager = true) {
  $query_args = array_filter($args);
  $new_query_args = array();
  $new_query_args['device_type'] = $query_args['device_type'];
  $query = "select node.nid,
      node.title as fw_cfg_name,
      d.name as substatus,
      f.title as fw_name,
      concat(h.part,' v', h.version) as partandversion
  from
      named_configuration a
          join
      node b ON a.device_type_id = b.nid
          and b.nid = %d
          join
      node ON a.nid = node.nid
          join
      named_configuration_type c ON a.type_id = c.id
          and c.name = 'firmware_configuration'
          join
      named_configuration_substatus d ON a.substatus = d.id
          join
      named_configuration_relation e ON a.nid = e.left_nid
          join
      node f ON e.right_nid = f.nid
          join
      named_configuration_type g ON e.right_type = g.id
          join
      firmware h ON f.nid = h.nid order by substatus,nid";
  $count_query = "SELECT COUNT(*) FROM (" . $query . ") AS count_query"; 
  if($pager){
    $pageSize = 10;  
    $result = pager_query($query, $pageSize, 0, $count_query, $new_query_args);
  }else{
    $result = db_query($query, $new_query_args);
  }
  
  $rows = array(); 
  while ($row = db_fetch_object($result)) {
    $rows[$row->nid]['fw_cfg_name'] = $row->fw_cfg_name;
    $rows[$row->nid]['fw_cfg_substutas'] = $row->substatus;
    $rows[$row->nid]['fw_name'] = $row->fw_name;
    $rows[$row->nid]['fw_partandversion'] = $row->partandversion;
  } 
  return $rows;
}
