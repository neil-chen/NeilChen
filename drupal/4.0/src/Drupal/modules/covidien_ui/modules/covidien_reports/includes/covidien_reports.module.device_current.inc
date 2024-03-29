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
    $sql .= " Device_VW.productline_nid = %d ";
  }
  if ($args['devicetype_nid'] && $args['devicetype_nid'] != 'All') {
    $sql .= " AND Device_VW.devicetype_nid = %d ";
  }
  if ($args['accountnumber'] && $args['accountnumber'] != 'All') {
    $sql .= " AND accountnumber = '%s' ";
  }
  if ($args['hid_condition'] == 'and') {
    if ($args['customer_nid'] && $args['customer_nid'] != 'All') {
      $sql .= " AND Customer_VW.customername = '%s' ";
    }
    if ($args['country'] && $args['country'] != 'All') {
      $sql .= " AND Country_VW.country_nid = %d ";
    }
  } elseif ($args['hid_condition'] == 'or') {
    if ($args['customer_nid'] && $args['customer_nid'] != 'All' && $args['country'] && $args['country'] != 'All') {
      $sql .= " AND (Customer_VW.customername = '%s' OR Country_VW.country_nid = %d )";
    } else {
      if ($args['customer_nid'] && $args['customer_nid'] != 'All') {
        $sql .= " AND Customer_VW.customername = '%s' ";
      }
      if ($args['country'] && $args['country'] != 'All') {
        $sql .= " AND Country_VW.country_nid = %d ";
      }
    }
  }
  if ($args['deviceserial'] && $args['deviceserial'] != 'All') {
    $sql .= " AND Device_VW.deviceserial = '%s' ";
  }
  /**/
  if ($args['hardware_name'] && $args['hardware_name'] != 'All') {
    $sql .= " AND componet_node.title = '%s' ";
  }
  if ($args['hardware_version'] && $args['hardware_version'] != 'All') {
    $sql .= " AND hardware.field_hw_version_value = '%s' ";
  }
  if ($args['hardware_part'] && $args['hardware_part'] != 'All') {
    $sql .= " AND hardware.field_hw_part_value = '%s' ";
  }
  if ($args['software_name'] && $args['software_name'] != 'All') {
    $sql .= " AND componet_node.title  = '%s' ";
  }
  if ($args['software_version'] && $args['software_version'] != 'All') {
    $sql .= " AND  software.field_sw_version_value = '%s' ";
  }
  if ($args['software_part'] && $args['software_part'] != 'All') {
    $sql .= " AND software.field_sw_part_value = '%s' ";
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
/*
 * Sub Report for SW Version with Account Name
 */
function device_current_configuration_report_sw_version_by_account() {
  $args = device_current_configuration_report_args();
  $sql = "select alltable.device_software_version_view_customername as customername, alltable.device_software_version_view_software_version as software_version, count(alltable.device_software_version_view_software_version) as sw_total
                from 
                (SELECT Device_VW.productline AS productline,
                Device_VW.productline_nid AS productline_nid,
                Device_VW.devicetype AS device_software_version_view_device_nid,
                Device_VW.devicetype_nid AS devicetype_nid,
                Device_VW.device_nid AS device_nid,
                Device_VW.deviceserial AS device_software_version_view_deviceserial,
                 
                Customer_VW.accountnumber AS accountnumber,
    Customer_VW.customername AS device_software_version_view_customername,
    Customer_VW.customer_nid AS customer_nid, 
                            GROUP_CONCAT(case when hardware.field_hw_version_value is not null then  componet_node.title end separator '<br>') as device_software_version_view_hardware_version,  
                            GROUP_CONCAT(hardware.field_hw_version_value separator '<br>') AS device_software_version_view_hardware1_version,
                   GROUP_CONCAT(case when software.field_sw_part_value != 'NA' then software.field_sw_version_value end )  AS device_software_version_view_software_version,
 
                Country_VW.country_name AS country_name,  
                device_service_history_VW.service_person as device_software_version_view_service_person,
                device_service_history_VW.field_service_datetime_value as device_software_version_view_lastest_sw_update
            FROM
                Device_VW
                    LEFT JOIN
                Country_VW ON Country_VW.device_nid = Device_VW.device_nid
                    JOIN
                Customer_VW ON Device_VW.device_owner = Customer_VW.account_nid
                    JOIN
                content_type_device_component_history device_component ON Device_VW.device_nid = device_component.field_component_device_nid
                    join
                content_field_expiration_datetime expiration ON device_component.nid = expiration.nid
                    and device_component.vid = expiration.vid
                    and expiration.field_expiration_datetime_value is null
                    join
                node componet_node ON device_component.field_device_component_nid = componet_node.nid
                   left join 
                content_type_software 
                     as software ON software.nid = componet_node.nid 
            left join
                content_type_hardware hardware ON hardware.nid = componet_node.nid
                    and hardware.vid = componet_node.vid

                     

            left join
                device_service_history_VW ON device_service_history_VW.field_to_device_component_nid = device_component.field_device_component_nid
                    AND device_service_history_VW.service_device_nid = Device_VW.device_nid 
                    WHERE  ";
  $sql .= device_current_configuration_report_where($args);
  $sql .= "group by Device_VW.deviceserial
                    ) alltable
                    group by alltable.device_software_version_view_software_version,alltable.device_software_version_view_customername";
  $filter = device_current_configuration_report_filter($args);
  $result = db_query($sql, $filter);
  $rows = array();
  $i = 0;
  while ($row = db_fetch_object($result)) {
    $rows[$i]['customername'] = $row->customername;
    $temp = explode(',', $row->software_version);
    $count = count($temp);
    $sw_version = $temp[$count-1];
    $rows[$i]['software_version'] = $sw_version;
    $rows[$i]['sw_total'] = $row->sw_total;
    $i++;
  }
  $list = array(); 
  foreach($rows as $key => $row){ 
    $list[$row['customername']][$row['software_version']]['total'] = $list[$row['customername']][$row['software_version']]['total'] + $row['sw_total'];
  }
  $output = array();
  $x = 0;
  
  foreach($list as $name => $values){ 
    foreach($values as $version => $total){
      $output[$name][$version]['customername'] = $name;
      $output[$name][$version]['software_version'] = $version;
      $output[$name][$version]['sw_total'] = $total['total'];
    } 
  } 
  $final = array();
  foreach($output as $key => $values){
    foreach($values as $item => $value){
      $final[$x]['customername'] = $value['customername']; 
      $final[$x]['software_version'] = $value['software_version'];
      $final[$x]['sw_total'] = $value['sw_total'];
      $x++;
    }
    
  }
  $header = array(
    'Customer Name',
    'S/W Version',
    'Total',
  );
  $output = theme_table($header, $final);
  return $output;
}

/**
 * 
 * @return type SW Version with Country sub report
 */
function device_current_configuration_report_sw_version_country_by_device_type() {
  $args = device_current_configuration_report_args();
 
  $sql = "select alltable.device_software_version_view_device_nid as devicetype, 
          alltable.device_software_version_view_software_version as software_version, 
          count(alltable.device_software_version_view_software_version) as sw_total,
          alltable.country_name AS country_name
                from 
                (SELECT Device_VW.productline AS productline,
                Device_VW.productline_nid AS productline_nid,
                Device_VW.devicetype AS device_software_version_view_device_nid,
                Device_VW.devicetype_nid AS devicetype_nid,
                Device_VW.device_nid AS device_nid,
                Device_VW.deviceserial AS device_software_version_view_deviceserial,
                 
                Customer_VW.accountnumber AS accountnumber,
                Customer_VW.customername AS device_software_version_view_customername,
                Customer_VW.customer_nid AS customer_nid, 
                GROUP_CONCAT(case when hardware.field_hw_version_value is not null then  componet_node.title end separator '<br>') as device_software_version_view_hardware_version,  
                GROUP_CONCAT(hardware.field_hw_version_value separator '<br>') AS device_software_version_view_hardware1_version,
                GROUP_CONCAT(case when software.field_sw_part_value != 'NA' then software.field_sw_version_value end )  AS device_software_version_view_software_version,
 
                Country_VW.country_name AS country_name,  
                device_service_history_VW.service_person as device_software_version_view_service_person,
                device_service_history_VW.field_service_datetime_value as device_software_version_view_lastest_sw_update
                FROM
                Device_VW
                    LEFT JOIN
                Country_VW ON Country_VW.device_nid = Device_VW.device_nid
                    JOIN
                Customer_VW ON Device_VW.device_owner = Customer_VW.account_nid
                    JOIN
                content_type_device_component_history device_component ON Device_VW.device_nid = device_component.field_component_device_nid
                    join
                content_field_expiration_datetime expiration ON device_component.nid = expiration.nid
                    and device_component.vid = expiration.vid
                    and expiration.field_expiration_datetime_value is null
                    join
                node componet_node ON device_component.field_device_component_nid = componet_node.nid
                   left join 
                content_type_software 
                     as software ON software.nid = componet_node.nid 
                left join
                content_type_hardware hardware ON hardware.nid = componet_node.nid
                    and hardware.vid = componet_node.vid
                left join
                device_service_history_VW ON device_service_history_VW.field_to_device_component_nid = device_component.field_device_component_nid
                    AND device_service_history_VW.service_device_nid = Device_VW.device_nid 
                    WHERE   ";
  $sql .= device_current_configuration_report_where($args);
  $sql .= "group by Device_VW.deviceserial
            ) alltable
            group by alltable.device_software_version_view_software_version,alltable.country_name";
  $filter = device_current_configuration_report_filter($args);
  $result = db_query($sql, $filter);
  $rows = array();
  $i = 0;
  while ($row = db_fetch_object($result)) {
    $rows[$i]['devicetype'] = $row->devicetype;
    $temp = explode(',', $row->software_version);
    $count = count($temp);
    $sw_version = $temp[$count-1];
    $rows[$i]['software_version'] = $sw_version;//$row->software_version;
    $rows[$i]['country_name'] = $row->country_name;
    $rows[$i]['sw_total'] = $row->sw_total;
    $i++;
  }
  $list = array(); 
  foreach($rows as $key => $row){ 
    $list[$row['country_name']][$row['software_version']]['total'] = $list[$row['country_name']][$row['software_version']]['total'] + $row['sw_total'];
    $list[$row['country_name']][$row['software_version']]['device_type'] = $row['devicetype'];
    
  }
  $output = array();
  $x = 0;
  
  foreach($list as $name => $values){ 
    foreach($values as $version => $total){
      $output[$name][$version]['country_name'] = $name;
      $output[$name][$version]['software_version'] = $version;
      $output[$name][$version]['sw_total'] = $total['total'];
      $output[$name][$version]['device_type'] = $total['device_type'];
    } 
  } 
  $final = array();
  foreach($output as $key => $values){
    foreach($values as $item => $value){
      $final[$x]['device_type'] = $value['device_type']; 
      $final[$x]['software_version'] = $value['software_version']; 
      $final[$x]['country_name'] = $value['country_name'];
      $final[$x]['sw_total'] = $value['sw_total']; 
      $x++;
    }
    
  }
  $header = array(
    'Device Type',
    'S/W Version',
    'Country',
    'Total',
  );
  $output = theme_table($header, $final);
  return $output;
}
