<?php

function get_audit_trail_report() {
  drupal_set_title(t('Audit Trail Report'));
  $args = get_audit_trail_report_args();
  $filters = get_audit_trail_report_filter_list($args);
  $header = array(t('User ID'), t('Customer Name'), t('Customer Account number'), t('Activity'), t('Host Name'), t('Device Type'), t('Device Serial Number'), t('Date & Time'));
  $rows = get_audit_trail_report_data($args);

  $filter_url = request_uri();
  if ($filter_url != '') {
    $export_filter_arr = explode('?', $filter_url);
    $filter_url = $export_filter_arr[1];
  }
  $filters['url'] = $filter_url;
  $filters['count'] = count($rows);  
  $from_date = new DateTime($_GET['from_date']);
  $to_date = new DateTime($_GET['to_date']); 
  $diff = $from_date->diff($to_date);  
  if($diff->days > 30) {
    $filters['date_range_valid'] = false;
  } else {
    $filters['date_range_valid'] = true;
  }
  
  $output = '';
  $output .= theme('get_audit_trail_report_filter', $filters);
  $output .= theme('table', $header, $rows, array('class' => 'views-table', 'style' => 'margin:0; width:100%;'));
  $output .= theme('pager', NULL, 10, 0);
  $output .= theme('get_audit_trail_report_buttom', $filters);
  return $output;
}

function get_audit_trail_report_filter_list($args) {
  $filters = array();
  $productline = node_load(array('nid' => $args['productline_nid']));
  $i = 0;
  $filters[$i]['label'] = t('Class of Trade:');
  $filters[$i]['value'] = $productline ? $productline->title : 'All';
  $i++;
  $filters[$i]['label'] = t('User:');
  $filters[$i]['value'] = $args['last_name'] ? $args['last_name'] : 'All';
  $i++;
  $filters[$i]['label'] = t('Email Address:');
  $filters[$i]['value'] = $args['username'] ? $args['username'] : 'All';
  $i++;
  $filters[$i]['label'] = t('Activity Type:');
  $filters[$i]['value'] = $args['activity_type'] ? $args['activity_type'] : 'All';
  $i++;
  $filters[$i]['label'] = t('Customer Name:');
  $filters[$i]['value'] = $args['cid'] ? $args['cid'] : 'All';
  $i++;
  $filters[$i]['label'] = t('Customer Account Number:');
  $filters[$i]['value'] = $args['comp_account_no'] ? $args['comp_account_no'] : 'All';
  $i++;
  $filters[$i]['label'] = t('From Date:');
  $filters[$i]['value'] = $args['from_date'] ? date('m/d/Y', $args['from_date']) : '';
  $i++;
  $filters[$i]['label'] = t('To Date:');
  $filters[$i]['value'] = $args['to_date'] ? date('m/d/Y', $args['to_date']) : date('m/d/Y');

  return $filters;
}

function get_audit_trail_report_csv() {
  drupal_set_header('Cache-control: public');
  drupal_set_header('Content-Type: text/csv');
  drupal_set_header('Content-Disposition: attachment; filename=Audit_Trail_Report.csv');
  $args = get_audit_trail_report_args();
  //filters
  $filters = get_audit_trail_report_filter_list($args);
  //header
  $header = array(t('User ID'), t('Customer Name'), t('Customer Account number'), t('Activity'), t('Host Name'), t('Device Type'), t('Device Serial Number'), t('Date & Time'));
  //result tables
  $rows = get_audit_trail_report_all_data($args);

  $output = '';
  foreach ($filters as $filter) {
    $output .= implode(',', $filter) . "\n";
  }
  $output .= "\n" . implode(',', $header) . "\n";
  foreach ($rows as $row) {
    if ($row) {
      $output .= '"' . implode('","', $row) . "\"\n";
    }
  }
  $output .= "\n\n\nCovidien Report";
  echo $output;
  exit();
}

function get_audit_trail_report_pdf() {
  require_once views_pdf_get_library('tcpdf') . '/tcpdf.php';
  require_once views_pdf_get_library('fpdi') .  '/fpdi2tcpdf_bridge.php';
  require_once views_pdf_get_library('fpdi') . '/fpdi.php';

  /**
   * Extend TCPDF to work with multiple columns
   */
  class MC_TCPDF extends TCPDF {

    public function WriteRecord($data) {
      $this->SetFont('helvetica', '', 7);
      $this->SetFillColor(200, 220, 255);  
      $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $txt = $data['user_id'] . ' | ' . $data['customer_name'] . ' | ' . $data['customer_account_number'] . ' | '
              . $data['activity'] . ' | ' . $data['host_name'] . ' | ' .  $data['device_type'] . ' | '
              . $data['device_serial_number'] . ' | ' . str_replace("<br/>", '@', $data['date_time']);
      $this->MultiCell(0, 0, $txt, 1, '', true, 1, '', '', true, 0, false, false, 0, 'T', false);
      $this->Ln(2);
    }

  } // end of extended class

  $pdf = new MC_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Covidien');
  $pdf->SetTitle('Audit Trail Report');
  $pdf->SetSubject('Audit Trail Report');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
  $pdf->AddPage(); 
  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // set some language-dependent strings (optional)
  if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
  }
 
  $args = get_audit_trail_report_args();
  $filters = get_audit_trail_report_filter_list($args);
  $header = array(t('User ID'), t('Customer Name'), t('Customer Account number'), t('Activity'), t('Host Name'), t('Device Type'), t('Device Serial Number'), t('Date & Time'));
  $rows = get_audit_trail_report_all_data($args);
  $output = ''; 
  $output .= theme('get_audit_trail_report_filter', $filters);
  $pdf->writeHTMLCell(0, 0, '', '', $output, 0, 1, 0, true, '', true);
  foreach($rows as $row){
    $pdf->WriteRecord($row); 
  } 
  //Close and output PDF document
  $pdf->Output('Audit_Trail_Report.pdf', 'D');

  exit();
}

function get_audit_trail_report_xls() {
  drupal_set_header('Cache-control: public');
  drupal_set_header("Content-type:application/vnd.ms-excel");
  drupal_set_header("Content-Disposition:attachment;filename=Audit_Trail_Report.xls");
  $args = get_audit_trail_report_args();
  $filters = get_audit_trail_report_filter_list($args);
  $header = array(t('User ID'), t('Customer Name'), t('Customer Account number'), t('Activity'), t('Host Name'), t('Device Type'), t('Device Serial Number'), t('Date & Time'));
  $rows = get_audit_trail_report_all_data($args);
  $output = '';
  $output .= theme('get_audit_trail_report_filter', $filters);
  $output .= theme('table', $header, $rows);
  echo $output;
  exit;
}

function get_audit_trail_report_args() {
  $args = array();
  
  if(isset($_GET['from_date']) && !empty($_GET['from_date'])){
    $args['from_date'] = $_GET['from_date'] ? strtotime($_GET['from_date']) : '';
  }
  if(isset($_GET['to_date']) && !empty($_GET['to_date'])){
    $args['to_date'] = $_GET['to_date'] ? strtotime($_GET['to_date']) : '';
  }
  if(isset($_GET['productline_nid']) && !empty($_GET['productline_nid'])){
    $args['productline_nid'] = check_plain($_GET['productline_nid']);
  }
  if(isset($_GET['username']) && !empty($_GET['username'])){
    $args['username'] = check_plain($_GET['username']);
  }
  if(isset($_GET['last_name']) && !empty($_GET['last_name'])){
    $args['last_name'] = check_plain($_GET['last_name']);
  }
  if(isset($_GET['activity_type']) && !empty($_GET['activity_type'])){
    $args['activity_type'] = check_plain($_GET['activity_type']);
  }
  if(isset($_GET['cid']) && !empty($_GET['cid'])){
    $args['cid'] = check_plain($_GET['cid']);
  }
  if(isset($_GET['comp_account_no']) && !empty($_GET['comp_account_no'])){
    $args['comp_account_no'] = check_plain($_GET['comp_account_no']);
  }
  return $args;
}

function get_audit_trail_report_data($args) {
  $args = array_filter($args);  
  $query = get_audit_trail_report_query($args);  
  $count_query = "SELECT COUNT(*) FROM (" . $query . ") AS count_query"; 
  $pageSize = 10;   
  $result = pager_query($query, $pageSize, 0, $count_query, $args);
  
  $rows = array(); 
  while ($row = db_fetch_object($result)) { 
    //GATEWAY-1779 'Add user' record is not exist in Audit Trail Report 
    $rows[$row->aid]['user_id'] = $row->user_id ? $row->user_id : user_load(1)->name;
    $rows[$row->aid]['customer_name'] = $row->customer_name;
    $rows[$row->aid]['customer_account_number'] = $row->customer_account_number;
    $rows[$row->aid]['activity'] = $row->activity;
    $rows[$row->aid]['host_name'] = $row->host_name;
    $rows[$row->aid]['device_type'] = $row->device_type;
    $rows[$row->aid]['device_serial_number'] = $row->device_serial_number;
    $rows[$row->aid]['date_time'] = date('m/d/Y', $row->date_time) . '<br/>' . date('h:i:s A', $row->date_time);
  } 
  return $rows;
}

function get_audit_trail_report_all_data($args) { 
  $query = get_audit_trail_report_query($args);
  $args = array_filter($args); 
  $result = db_query($query, $args);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    //GATEWAY-1779 'Add user' record is not exist in Audit Trail Report 
    $rows[$row->aid]['user_id'] = $row->user_id ? $row->user_id : user_load(1)->name;
    $rows[$row->aid]['customer_name'] = $row->customer_name;
    $rows[$row->aid]['customer_account_number'] = $row->customer_account_number;
    $rows[$row->aid]['activity'] = $row->activity;
    $rows[$row->aid]['host_name'] = $row->host_name;
    $rows[$row->aid]['device_type'] = $row->device_type;
    $rows[$row->aid]['device_serial_number'] = $row->device_serial_number;
    $rows[$row->aid]['date_time'] = date('m/d/Y', $row->date_time) . '<br/>' . date('h:i:s A', $row->date_time);
  }
  return $rows;
}
