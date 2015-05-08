<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function update_device_current_configuration_report_to_table() {
  //Update Table device_current_configuration_table 
  $truncate_query = "TRUNCATE device_current_configuration_table";
  //truncate table
  db_query($truncate_query);
  $insert_query = "INSERT INTO device_current_configuration_table
    SELECT 
    Device_VW.productline AS productline,
    Device_VW.productline_nid AS productline_nid,
    Device_VW.devicetype AS devicetype,
    Device_VW.devicetype_nid AS devicetype_nid,
    Device_VW.device_nid AS device_nid,
    Device_VW.deviceserial AS deviceserial,
    Customer_VW.accountnumber AS accountnumber,
    Customer_VW.customername AS customername,
    Customer_VW.customer_nid AS customer_nid,
    Hardware_VW.hardware_nid AS hardware_nid,
    Hardware_VW.hardware_part AS hardware_part,
    Hardware_VW.hardware_name AS hardware_name,
    Hardware_VW.hardware_version AS hardware_version,
    Software_VW.software_nid AS software_nid,
    Software_VW.software_name AS software_name,
    Software_VW.software_part AS software_part,
    Software_VW.software_version AS software_version,
    Software_VW.software_component AS software_component,
    Software_VW.lastest_sw_update AS lastest_sw_update,
    device_service_history_VW.service_person AS service_person,
    Country_VW.country_nid AS country_nid,
    Country_VW.country_name AS country_name 
    FROM
      Device_VW 
      LEFT JOIN Country_VW 
        ON Country_VW.device_nid = Device_VW.device_nid 
      JOIN Customer_VW 
        ON Device_VW.device_owner = Customer_VW.account_nid 
      JOIN Hardware_VW 
        ON Hardware_VW.component_device = Device_VW.device_nid 
      JOIN Software_VW 
        ON Software_VW.component_device = Device_VW.device_nid 
      JOIN device_service_history_VW 
        ON device_service_history_VW.field_to_device_component_nid = Software_VW.software_component 
        AND device_service_history_VW.service_device_nid = Device_VW.device_nid 
        AND device_service_history_VW.field_service_datetime_value = Software_VW.lastest_sw_update";
  db_query($insert_query);
}

function device_current_configuration_report_sql($args = array()) {
  $sql = "SELECT 
    productline AS productline,
    productline_nid AS productline_nid,
    devicetype AS devicetype,
    devicetype_nid AS devicetype_nid,
    device_nid AS device_nid,
    deviceserial AS deviceserial,
    accountnumber AS accountnumber,
    customername AS customername,
    customer_nid AS customer_nid,
    hardware_nid AS hardware_nid,
    hardware_part AS hardware_part,
    hardware_name AS hardware_name,
    hardware_version AS hardware_version,
    software_nid AS software_nid,
    software_name AS software_name,
    software_part AS software_part,
    software_version AS software_version,
    software_component AS software_component,
    lastest_sw_update AS lastest_sw_update,
    service_person AS service_person,
    country_nid AS country_nid,
    country_name AS country_name 
    FROM device_current_configuration_table WHERE 1 ";
  $sql .= device_current_configuration_report_where($args);
  return $sql;
}

function device_current_configuration_report_args() {
  $agrs = filter_xss_arr($_GET);
  if (!$args['productline_nid'] || $args['productline_nid'] == 'All') {
    $args['productline_nid'] = covidien_get_product_line();
  }
  if (!$args['devicetype_nid'] || $args['devicetype_nid'] == 'All') {
    $args['devicetype_nid'] = covidien_get_device_type();
  }
  return $agrs;
}

function device_current_configuration_report_where($args) {
  $sql = "";
  if ($args['productline_nid'] && $args['productline_nid'] != 'All') {
    $sql .= " AND productline_nid = %d ";
  }
  if ($args['devicetype_nid'] && $args['devicetype_nid'] != 'All') {
    $sql .= " AND device_nid = %d ";
  }
  if ($args['accountnumber'] && $args['accountnumber'] != 'All') {
    $sql .= " AND accountnumber = '%s' ";
  }
  if ($args['hid_condition'] == 'and') {
    if ($args['customer_nid'] && $args['customer_nid'] != 'All') {
      $sql .= " AND customername = '%s' ";
    }
    if ($args['country'] && $args['country'] != 'All') {
      $sql .= " AND country_nid = %d ";
    }
  } elseif ($args['hid_condition'] == 'or') {
    if ($args['customer_nid'] && $args['customer_nid'] != 'All' && $args['country'] && $args['country'] != 'All') {
      $sql .= " AND (customername = '%s' OR country_nid = %d )";
    } else {
      if ($args['customer_nid'] && $args['customer_nid'] != 'All') {
        $sql .= " AND customername = '%s' ";
      }
      if ($args['country'] && $args['country'] != 'All') {
        $sql .= " AND country_nid = %d ";
      }
    }
  }
  if ($args['deviceserial'] && $args['deviceserial'] != 'All') {
    $sql .= " AND deviceserial = '%s' ";
  }
  if ($args['hardware_name'] && $args['hardware_name'] != 'All') {
    $sql .= " AND hardware_name = '%s' ";
  }
  if ($args['hardware_version'] && $args['hardware_version'] != 'All') {
    $sql .= " AND hardware_version = '%s' ";
  }
  if ($args['hardware_part'] && $args['hardware_part'] != 'All') {
    $sql .= " AND hardware_part = '%s' ";
  }
  if ($args['software_name'] && $args['software_name'] != 'All') {
    $sql .= " AND software_name = '%s' ";
  }
  if ($args['software_version'] && $args['software_version'] != 'All') {
    $sql .= " AND software_version = '%s' ";
  }
  if ($args['software_part'] && $args['software_part'] != 'All') {
    $sql .= " AND software_part = '%s' ";
  }
  return $sql;
}

function device_current_configuration_report_filter($args = array()) {
  $filter = array();
  if ($args['productline_nid'] && $args['productline_nid'] != 'All') {
    $filter['Class of Trade'] = $args['productline_nid'];
  }
  if ($args['devicetype_nid'] && $args['devicetype_nid'] != 'All') {
    $filter['Device Type'] = $args['devicetype_nid'];
  }
  if ($args['accountnumber'] && $args['accountnumber'] != 'All') {
    $filter['Customer Account Number'] = $args['accountnumber'];
  }
  if ($args['customer_nid'] && $args['customer_nid'] != 'All') {
    $filter['Customer Name'] = $args['customer_nid'];
  }
  if ($args['country'] && $args['country'] != 'All') {
    $filter['Country'] = $args['country'];
  }
  if ($args['deviceserial'] && $args['deviceserial'] != 'All') {
    $filter['Device Serial Number'] = $args['deviceserial'];
  }
  if ($args['hardware_name'] && $args['hardware_name'] != 'All') {
    $filter['Hardware Name'] = $args['hardware_name'];
  }
  if ($args['hardware_version'] && $args['hardware_version'] != 'All') {
    $filter['Hardware Revision'] = $args['hardware_version'];
  }
  if ($args['hardware_part'] && $args['hardware_part'] != 'All') {
    $filter['Hardware Part'] = $args['hardware_part'];
  }
  if ($args['software_name'] && $args['software_name'] != 'All') {
    $filter['Software Name'] = $args['software_name'];
  }
  if ($args['software_version'] && $args['software_version'] != 'All') {
    $filter['Software Version'] = $args['software_version'];
  }
  if ($args['software_part'] && $args['software_part'] != 'All') {
    $filter['Software Part'] = $args['software_part'];
  }
  return $filter;
}

function device_current_configuration_report_table() {
  $args = device_current_configuration_report_args();
  $sql = device_current_configuration_report_sql($args);
  $sql .= " ORDER BY deviceserial, lastest_sw_update DESC ";
  $filter = device_current_configuration_report_filter($args);
  $result = pager_query($sql, 10, 0, NULL, $filter);
  $rows = array();
  $i = 0;
  while ($row = db_fetch_object($result)) {
    $rows[$i]['customername'] = $row->customername;
    $rows[$i]['deviceserial'] = $row->deviceserial;
    $rows[$i]['country_name'] = $row->country_name;
    $rows[$i]['hardware_name'] = $row->hardware_name . ' v' . $row->hardware_version;
    $rows[$i]['software_name'] = $row->software_name . ' v' . $row->software_version;
    $rows[$i]['lastest_sw_update'] = $row->lastest_sw_update;
    $rows[$i]['service_person'] = $row->service_person;
    $i++;
  }
  $header = array(
    'Customer Name',
    'Device Serial Number',
    'Country',
    'H/W Name & Version',
    'S/W Name & Version',
    'Configuration Reported Date & Time',
    'User ID',
  );
  $output = theme_table($header, $rows);
  //$output .= theme('pager', NULL, 10, 0);
  return $output;
}

function device_current_configuration_report_export_table() {
  $args = device_current_configuration_report_args();
  $sql = device_current_configuration_report_sql($args);
  $sql .= " ORDER BY deviceserial, lastest_sw_update DESC ";
  $filter = device_current_configuration_report_filter($args);
  $result = db_query($sql, $filter);
  $rows = array();
  $i = 0;
  while ($row = db_fetch_object($result)) {
    $rows[$i]['customername'] = $row->customername;
    $rows[$i]['deviceserial'] = $row->deviceserial;
    $rows[$i]['country_name'] = $row->country_name;
    $rows[$i]['hardware_name'] = $row->hardware_name . ' v' . $row->hardware_version;
    $rows[$i]['software_name'] = $row->software_name . ' v' . $row->software_version;
    $rows[$i]['lastest_sw_update'] = $row->lastest_sw_update;
    $rows[$i]['service_person'] = $row->service_person;
    $i++;
  }
  $header = array(
    'Customer Name',
    'Device Serial Number',
    'Country',
    'H/W Name & Version',
    'S/W Name & Version',
    'Configuration Reported Date & Time',
    'User ID',
  );
  $output = theme_table($header, $rows);
  return $output;
}

function device_current_configuration_report_sw_version_by_account() {
  $args = device_current_configuration_report_args();
  $sql = "SELECT 
    customername AS customername,
    software_version AS software_version,
    COUNT(software_nid) AS sw_total
    FROM device_current_configuration_table WHERE 1 ";
  $sql .= device_current_configuration_report_where($args);
  $sql .= "GROUP BY customer_nid, software_nid";
  $filter = device_current_configuration_report_filter($args);
  $result = db_query($sql, $filter);
  $rows = array();
  $i = 0;
  while ($row = db_fetch_object($result)) {
    $rows[$i]['customername'] = $row->customername;
    $rows[$i]['software_version'] = $row->software_version;
    $rows[$i]['sw_total'] = $row->sw_total;
    $i++;
  }
  $header = array(
    'Customer Name',
    'S/W Version',
    'Total',
  );
  $output = theme_table($header, $rows);
  return $output;
}

function device_current_configuration_report_sw_version_country_by_device_type() {
  $args = device_current_configuration_report_args();
  $sql = "SELECT 
    devicetype AS devicetype,
    software_version AS software_version,
    country_name AS country_name,
    COUNT(software_nid) AS sw_total
    FROM device_current_configuration_table WHERE 1 ";
  $sql .= device_current_configuration_report_where($args);
  $sql .= "GROUP BY country_nid, software_nid";
  $filter = device_current_configuration_report_filter($args);
  $result = db_query($sql, $filter);
  $rows = array();
  $i = 0;
  while ($row = db_fetch_object($result)) {
    $rows[$i]['devicetype'] = $row->devicetype;
    $rows[$i]['software_version'] = $row->software_version;
    $rows[$i]['country_name'] = $row->country_name;
    $rows[$i]['sw_total'] = $row->sw_total;
    $i++;
  }
  $header = array(
    'Device Type',
    'S/W Version',
    'Country',
    'Total',
  );
  $output = theme_table($header, $rows);
  return $output;
}
