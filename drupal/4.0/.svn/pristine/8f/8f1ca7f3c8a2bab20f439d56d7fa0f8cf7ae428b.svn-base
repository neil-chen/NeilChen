<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function get_all_report_menu() {
  $total_reports = allReportList(); // Get all reports
  $report_list = getReportListByProductLine(); // Get all reports related to the Product line
  // build menu
  $report_menu;
  foreach ($total_reports as $key => $val) {
    $class = array();
    if (in_array($val, $report_list)) {
      if (arg(3) == $key) {
        $class = array('attributes' => array('style' => 'color:#000000'));
      }
      $report_menu .= l($val, "covidien/reports/filter/$key", $class) . "<br />";
    }
  }
//  $report_menu .= l('Device Country Change Report', "covidien/reports/filter/15") . "<br />";
  return $report_menu;
}


function get_customer_report($arg2) {
  
  switch ($arg2) {
    case 12:
      $output = theme('device_historical_configuration_report');
      break;
    case 15:
      $output = theme('device_country_change_report');
      break;
  }
    
  return $output;
}
