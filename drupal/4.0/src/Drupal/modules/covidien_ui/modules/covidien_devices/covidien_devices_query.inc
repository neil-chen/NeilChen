<?php

/**
 * Query functions
 */
function autoSuggestionDeviceQuery($string, $arg1, $devices_nid, $name, $uid) {
  $where = '';
  $matches = array();
  $qry_arg = array();
  $qry_arg[] = $string;
  if ($arg1 && $arg1 != 'All') {
    $where = " and T3.field_device_type_nid ='%s'";
    $qry_arg[] = $arg1;
  } else {
    if ($uid != 1) {
      $where = " and T3.field_device_type_nid IN (%s) ";
      $qry_arg[] = $devices_nid;
    }
  }
  $covidien_user = checkifCovidienUserQuery($name);
  if ($covidien_user == 'No') {
    $account_no = getCompanyinfoQuery($name);
    $customer_query = ' and T2.field_device_owner_nid IN (%s)';
    $qry_arg[] = $account_no;
  }
  $query = "select T2.field_device_serial_number_value from node as T1 join content_type_device as T2 on T1.nid = T2.nid join content_field_device_type as T3 on T1.nid = T3.nid where T2.field_device_serial_number_value LIKE '%%%s%%' $where $customer_query limit 0,20";
  $result = db_query($query, $qry_arg);
  return $result;
}

function checkifCovidienUserQuery($name) {
  $query = "Select T2.field_covidien_employee_value from {node} as T1 join {content_type_person} as T2 on T1.nid = T2.nid where T1.title = '%s' and T1.type='person'";
  return db_result(db_query($query, $name));
}

function getCompanyinfoQuery($name) {
  $query = "SELECT p.field_comp_account_no_nid FROM {node} n JOIN {content_type_person} p ON n.nid = p.nid WHERE n.title = '%s' AND n.type='person'";
  return db_result(db_query($query, $name));
}

function getBuCustomerinfoQuery($company_nid) {
  $query = "select nid from {content_type_bu_customer} where field_customer_party_pk_nid = '%s'";
  return db_query($query, $company_nid);
}

function getFacilitynidQuery($nid) {
  $query = "select nid from {content_type_customer_facility} where field_customer_pk_nid = '%s'";
  return db_result(db_query($query, $nid));
}

function getFacilityinfoQuery($fid) {
  $query = "select field_facility_pk_nid from {content_field_facility_pk} where nid = '%s'";
  return db_result(db_query($query, $fid));
}

function getConfiginfoQuery($device_id) {
  $query = "select d.nid, concat(d.title,' v ',c.version) as sys_config_info from content_type_device_component_history a join content_field_expiration_datetime b ON a.nid = b.nid and a.vid = b.vid join named_configuration c on a.field_device_component_nid = c.nid join node d on c.nid = d.nid where a.field_component_device_nid = %d and b.field_expiration_datetime_value is null";
  $result = db_query($query, $device_id);
  $sys_nid = '';
  $sys_info = '';
  while ($row = db_fetch_object($result)) {
    $sys_nid = $row->nid;
    $sys_info = $row->sys_config_info;
  }
  return '<a href="/covidien/named-config/edit/' . $sys_nid . '" target="_blank">' . $sys_info . '</a>';
}

function getLocationnidQuery($id, $device_id) {
  $query = "Select T1.field_location_id_nid from {content_type_device_installation} as T1 join {content_field_device_pk} as T2 on T1.vid = T2.vid join {content_type_device} as T3 on T2.field_device_pk_nid = T3.nid where T3.field_device_serial_number_value = '%s' and T3.nid = '%s'";
  return db_result(db_query($query, $id, $device_id));
}

function getinstallationinfoQuery($id, $device_id) {
  $query = "select T4.title as language, installation.field_usr_provided_dev_address_value as device_address, installation.field_usr_provided_dev_facility_value as device_facility from {content_type_device_installation} installation join {node} node on node.vid = installation.vid join {content_field_device_pk} as device on installation.vid = device.vid join {content_type_device} as T3 on device.field_device_pk_nid = T3.nid join {node} as T4 on installation.field_device_country_nid = T4.nid where T3.field_device_serial_number_value='%s' and T3.nid = '%s'";
  return db_fetch_object(db_query($query, $id, $device_id));
}

function getDeviceownerinfoQuery($id, $device_id) {
  $query = "select T1.field_device_owner_nid,T2.field_device_type_nid as nid,T1.field_maintance_expiration_date_value from {content_type_device} as T1 inner join {content_field_device_type} as T2 where T1.nid = T2.nid and T1.field_device_serial_number_value= '%s' and T1.nid = '%s'";
  return db_query($query, $id, $device_id);
}

function getRegionInfo($aid) {
  $query = "SELECT cn.nid, cn.title 
        FROM {content_type_bu_customer} bc 
        JOIN {node} cn ON bc.field_customer_party_pk_nid = cn.nid 
        WHERE bc.nid = %d";
  return db_query($query, $aid);
}

function getAssociatedHardwaresQuery() {
  $query = "SELECT node.nid AS nid, node.title AS node_title, node_node_data_field_device_component.title AS node_node_data_field_device_component_title, 
    node_node_data_field_device_component.nid AS node_node_data_field_device_component_nid, node.type AS node_type, 
    node_node_data_field_device_component.type AS node_node_data_field_device_component_type, 
    node_node_data_field_component_device_node_data_field_device_serial_number.field_device_serial_number_value AS node_node_data_field_component_device_node_data_field_device_serial_number_field_device_serial_number_value, 
    node_node_data_field_component_device.nid AS node_node_data_field_component_device_nid, 
    node_node_data_field_component_device.type AS node_node_data_field_component_device_type, 
    node_node_data_field_component_device.vid AS node_node_data_field_component_device_vid, 
    node_node_data_field_device_component_node_data_field_hw_version.field_hw_version_value AS node_node_data_field_device_component_node_data_field_hw_version_field_hw_version_value, 
    node_node_data_field_device_component.vid AS node_node_data_field_device_component_vid, 
    node_node_data_field_device_component_node_data_field_hw_version.field_hw_description_value AS node_node_data_field_device_component_node_data_field_hw_version_field_hw_description_value, 
    node_data_field_expiration_datetime.field_expiration_datetime_value AS node_data_field_expiration_datetime_field_expiration_datetime_value, 
    node.vid AS node_vid FROM node node  
    LEFT JOIN {content_type_device_component_history} node_data_field_device_component ON node.vid = node_data_field_device_component.vid 
    LEFT JOIN {node} node_node_data_field_device_component ON node_data_field_device_component.field_device_component_nid = node_node_data_field_device_component.nid 
    LEFT JOIN {content_type_device_component_history} node_data_field_component_device ON node.vid = node_data_field_component_device.vid 
    LEFT JOIN {node} node_node_data_field_component_device ON node_data_field_component_device.field_component_device_nid = node_node_data_field_component_device.nid 
    LEFT JOIN {content_field_expiration_datetime} node_data_field_expiration_datetime ON node.vid = node_data_field_expiration_datetime.vid 
    LEFT JOIN {content_type_device} node_node_data_field_component_device_node_data_field_device_serial_number ON node_node_data_field_component_device.vid = node_node_data_field_component_device_node_data_field_device_serial_number.vid 
    LEFT JOIN {content_field_expiration_datetime} device_expiration_datetime on device_expiration_datetime.vid = node_node_data_field_component_device_node_data_field_device_serial_number.vid 
    LEFT JOIN {content_type_hardware} node_node_data_field_device_component_node_data_field_hw_version ON node_node_data_field_device_component.vid = node_node_data_field_device_component_node_data_field_hw_version.vid 
    LEFT JOIN {content_field_expiration_datetime} expiry on node_node_data_field_device_component_node_data_field_hw_version.vid = expiry.vid 
    WHERE node.type = 'device_component_history'
    AND node_node_data_field_device_component.type = 'hardware'
    AND node_node_data_field_component_device_node_data_field_device_serial_number.field_device_serial_number_value = '%s'
    AND node_node_data_field_component_device_node_data_field_device_serial_number.nid = '%s'
    AND node_data_field_expiration_datetime.field_expiration_datetime_value IS NULL
    AND device_expiration_datetime.field_expiration_datetime_value IS NULL
    AND expiry.field_expiration_datetime_value IS NULL 
    ORDER BY node_node_data_field_component_device_node_data_field_device_serial_number_field_device_serial_number_value ASC";
  return $query;
}

/**
 * Return Query object to select Software associated to Device serial number($var)
 */
function getSWquery($var, $device_id) {
  $status_sql = "SELECT nid FROM node WHERE title='Limited Release' OR title='In Production'";
  $status_result = db_query($status_sql);
  $srows = array();
  while ($srow = db_fetch_object($status_result)) {
    $srows[] = $srow->nid;
  }

  $sql = "SELECT node.nid AS nid,node.title AS node_title, 
	node_node_data_field_device_component.title AS node_node_data_field_device_component_title, 
	node_node_data_field_device_component.nid AS node_node_data_field_device_component_nid, 
	node.type AS node_type, node_node_data_field_device_component.type AS node_node_data_field_device_component_type, 
	node_node_data_field_component_device_node_data_field_device_serial_number.field_device_serial_number_value AS node_node_data_field_component_device_node_data_field_device_serial_number_field_device_serial_number_value, 
	node_node_data_field_component_device.nid AS node_node_data_field_component_device_nid, 
	node_node_data_field_component_device.type AS node_node_data_field_component_device_type, 
	node_node_data_field_component_device.vid AS node_node_data_field_component_device_vid, 
	node_node_data_field_device_component_node_data_field_sw_version.field_sw_version_value AS node_node_data_field_device_component_node_data_field_sw_version_field_sw_version_value, 
	node_node_data_field_device_component.vid AS node_node_data_field_device_component_vid, 
	node_node_data_field_device_component_node_data_field_sw_version.field_sw_description_value AS node_node_data_field_device_component_node_data_field_sw_version_field_sw_description_value, 
	node_node_data_field_update_to_component_node_data_field_sw_version.field_sw_version_value AS node_node_data_field_update_to_component_node_data_field_sw_version_field_sw_version_value, 
	node_node_data_field_update_to_component.nid AS node_node_data_field_update_to_component_nid, 
	node_node_data_field_update_to_component.type AS node_node_data_field_update_to_component_type, 
	node_node_data_field_update_to_component.vid AS node_node_data_field_update_to_component_vid, 
	node_node_data_field_hw_list.title AS node_node_data_field_hw_list_title, 
	node_node_data_field_hw_list.nid AS node_node_data_field_hw_list_nid 
	FROM {node} node  
	LEFT JOIN {content_type_device_component_history} node_data_field_device_component ON node.vid = node_data_field_device_component.vid 
	LEFT JOIN {node} node_node_data_field_device_component ON node_data_field_device_component.field_device_component_nid = node_node_data_field_device_component.nid 
	LEFT JOIN {content_type_device_component_history} node_data_field_component_device ON node.vid = node_data_field_component_device.vid 
	LEFT JOIN {node} node_node_data_field_component_device ON node_data_field_component_device.field_component_device_nid = node_node_data_field_component_device.nid 
	LEFT JOIN {content_type_device_component_history} node_data_field_update_to_component ON node.vid = node_data_field_update_to_component.vid 
	LEFT JOIN {node} node_node_data_field_update_to_component ON node_data_field_update_to_component.field_update_to_component_nid = node_node_data_field_update_to_component.nid 
	LEFT JOIN {content_field_hw_list} node_node_data_field_device_component_node_data_field_hw_list ON node_node_data_field_device_component.vid = node_node_data_field_device_component_node_data_field_hw_list.vid 
	LEFT JOIN {node} node_node_data_field_hw_list ON node_node_data_field_device_component_node_data_field_hw_list.field_hw_list_nid = node_node_data_field_hw_list.nid 
	LEFT JOIN {content_field_expiration_datetime} node_data_field_expiration_datetime ON node.vid = node_data_field_expiration_datetime.vid 
	LEFT JOIN {content_type_device} node_node_data_field_component_device_node_data_field_device_serial_number ON node_node_data_field_component_device.vid = node_node_data_field_component_device_node_data_field_device_serial_number.vid 
	LEFT JOIN {content_field_expiration_datetime} as device_expiration_datetime on device_expiration_datetime.nid = node_node_data_field_component_device_node_data_field_device_serial_number.nid 
	LEFT JOIN {content_type_software} node_node_data_field_device_component_node_data_field_sw_version ON node_node_data_field_device_component.vid = node_node_data_field_device_component_node_data_field_sw_version.vid 
  LEFT JOIN {content_field_expiration_datetime} expiry on node_node_data_field_device_component_node_data_field_sw_version.vid =  expiry.vid 
	LEFT JOIN {content_type_software} node_node_data_field_update_to_component_node_data_field_sw_version ON node_node_data_field_update_to_component.vid = node_node_data_field_update_to_component_node_data_field_sw_version.vid 
	WHERE node.type = 'device_component_history'
	AND node_node_data_field_device_component.type = 'software'
	AND node_node_data_field_component_device_node_data_field_device_serial_number.field_device_serial_number_value = '%s'
	AND node_node_data_field_component_device_node_data_field_device_serial_number.nid = '%d'
	AND node_data_field_expiration_datetime.field_expiration_datetime_value IS NULL
  AND expiry.field_expiration_datetime_value IS NULL 
	AND device_expiration_datetime.field_expiration_datetime_value IS NULL ";
  if ($srows) {
    $sql .= " AND (node_node_data_field_device_component_node_data_field_sw_version.field_sw_status_nid IN (" . db_placeholders($srows) . ")) ";
  }
  $sql .= " ORDER BY node_node_data_field_component_device_node_data_field_device_serial_number_field_device_serial_number_value ASC ";
  $args = array_merge(array($var), array($device_id), $srows);
  $query = db_query($sql, $args);
  return $query;
}

function getDeviceInfoQuery($installation_nid) {
  $query = "SELECT T3.nid AS device_nid, T3.field_device_serial_number_value AS serial_number,T4.title AS customer_name, device_node.title AS device_type 
      FROM {node} AS node 
      JOIN {content_type_device_installation} AS T1 ON node.vid = T1.vid 
      JOIN {content_field_device_pk} AS content_field_device_pk ON T1.nid = content_field_device_pk.nid 
      JOIN {node} AS T2 ON content_field_device_pk.field_device_pk_nid = T2.nid 
      JOIN {content_type_device} AS T3 ON T2.vid = T3.vid 
      JOIN {content_type_bu_customer} bc ON T3.field_device_owner_nid = bc.nid 
      JOIN {node} AS T4 ON bc.field_customer_party_pk_nid = T4.nid 
      JOIN {content_field_device_type} AS T6 ON T3.vid = T6.vid 
      JOIN {node} AS device_node ON T6.field_device_type_nid = device_node.nid 
      WHERE T1.nid = %d";
  return db_query($query, $installation_nid);
}

function getFromcompHistory($from_sw, $device_nid) {
  $query = 'select nid from {content_type_device_component_history} where field_device_component_nid = "%s" and field_component_device_nid = "%s"';
  return db_result(db_query($query, $from_sw, $device_nid));
}

function getSWcompNidQuery($from_sw, $installation_nid) {
  $query = "select field_to_device_component_nid from content_type_device_service_history where field_from_device_component_nid = '%s' and field_device_installation_pk_nid = '%s' and field_upgrade_status_value='installed'";
  return db_result(db_query($query, $from_sw, $installation_nid));
}

function getToSWfromLogQuery($service_id, $from_sw) {
  $query = 'select field_to_component_nid_value from {content_type_device_component_upgrade_log} where field_uh_device_service_history_value = "%s" and field_from_component_nid_value = "%s"';
  return db_result(db_query($query, $service_id, $from_sw));
}

function getToSWfromLogQuerynoservice($next_component_nid, $installation_nid) {
  $query = 'select field_component_history_nid_value from {content_type_device_component_upgrade_log} where field_component_history_nid_value = "%s" and field_uh_device_installation_pk_value = "%s"';
  return db_result(db_query($query, $next_component_nid, $installation_nid));
}

function getServicewithcompQuery($from_sw, $installation_nid) {
  $query = "select T3.title as Person,T2.field_service_datetime_value as date from {node} as node join {content_type_device_service_history} as T2 on node.vid = T2.vid join {node} as T3 on T2.field_service_person_pk_nid = T3.nid where T2.field_from_device_component_nid = '%s' and T2.field_device_installation_pk_nid = '%s'";
  return db_query($query, $from_sw, $installation_nid);
}

function getServicehistoryinfoQuery($service_id) {
  $query = "select T3.title as Person,T2.field_service_datetime_value as date from {node} as node join {content_type_device_service_history} as T2 on node.vid = T2.vid join {node} as T3 on T2.field_service_person_pk_nid = T3.nid where node.nid = '%s'";
  return db_query($query, $service_id);
}

function getUpgradeloginfo($service_nid) {
  $query = "select * from {content_type_device_component_upgrade_log} where field_uh_device_service_history_value = '%s'";
  return db_query($query, $service_nid);
}

function getUpgradeloginfonoserviceid($from_component_nid) {
  $query = "select * from {content_type_device_component_upgrade_log} where field_component_history_nid_value = '%s'";
  return db_query($query, $from_component_nid);
}

function getCurrentConfigQuery($serial_number) {
  $query = "select T1.field_device_component_nid,T1.field_update_to_component_nid 
      from {node} as history_node 
      join {content_type_device_component_history} as T1 on T1.vid = history_node.vid 
      join {content_type_device} as T2 on T2.nid = T1.field_component_device_nid 
      join {node} as device_node on device_node.vid = T2.vid 
      join {content_field_expiration_datetime} as expire on expire.vid = T1.vid 
      where T2.field_device_serial_number_value = '%s' and expire.field_expiration_datetime_value is NULL";
  return db_query($query, $serial_number);
}

function getservicenidupgradelog($installation_nid, $from, $service_nid) {
  $query = "select count(*) as total from {content_type_device_component_upgrade_log} where field_uh_device_installation_pk_value = '%s' and field_uh_device_service_history_value = '%s'";
  return db_result(db_query($query, $installation_nid, $service_nid));
}

function autoSuggestionAccountDeviceQuery($string, $value, $customer_nid_arr, $covidien_user) {
  $where = '';
  $matches = array();
  $qry_arg = array();
  $where = '';
  if (!empty($value) && $value != 'all') {
    $where = ' node1.title="%s" and';
    $qry_arg[] = $value;
  }

  $tmpwhere = '';
  if ($covidien_user != 'Yes') {
    $customer_nid = implode(',', $customer_nid_arr);
    $tmpwhere = " node1.nid IN (%s) AND ";
    $qry_arg[] = $customer_nid;
  }
  $qry_arg[] = $string;

  $query = "SELECT content_type_bu_customer.field_bu_customer_account_number_value 
          FROM {content_type_party} AS content_type_party JOIN {content_type_bu_customer} AS content_type_bu_customer ON content_type_bu_customer.field_customer_party_pk_nid=content_type_party.nid 
          JOIN {node} AS account_node ON account_node.vid = content_type_bu_customer.vid 
          JOIN {node} AS node1 ON node1.nid = content_type_bu_customer.field_customer_party_pk_nid 
          LEFT JOIN {content_field_expiration_datetime} as expiry ON content_type_bu_customer.vid = expiry.vid
          WHERE $where $tmpwhere content_type_bu_customer.field_bu_customer_account_number_value LIKE '%%%s%%' limit 0,20";
  $result = db_query($query, $qry_arg);
  return $result;
}

function autoSuggestionCompanyDeviceQuery($string, $value, $customer_nid_arr, $covidien_user) {
  $where = '';
  $matches = array();
  $qry_arg = array();
  $tmpwhere = '';
  $where = '';
  if (!empty($value) && $value != 'all') {
    $where = ' content_type_bu_customer.field_bu_customer_account_number_value="%s" and';
    $qry_arg[] = $value;
  }
  if ($covidien_user != 'Yes') {
    $customer_nid = implode(',', $customer_nid_arr);
    $tmpwhere = " node1.nid IN (%s) AND ";
    $qry_arg[] = $customer_nid;
  }
  $qry_arg[] = $string;

  $query = "SELECT node1.title AS customername 
        FROM {content_type_party} 
        LEFT JOIN {content_field_expiration_datetime} expiry_party ON content_type_party.vid = expiry_party.vid 
        JOIN {content_type_bu_customer} ON content_type_bu_customer.field_customer_party_pk_nid = content_type_party.nid 
        JOIN {node} AS node1 ON node1.nid = content_type_bu_customer.field_customer_party_pk_nid 
        WHERE expiry_party.field_expiration_datetime_value IS NULL 
        AND $where $tmpwhere node1.title like '%%%s%%' limit 0,20";
  $result = db_query($query, $qry_arg);
  return $result;
}

function getNamedConfigHWSWRelationByDeviceType($device_type_name) {
  $query = "SELECT hn.nid AS hardware_nid, hn.title AS hardware_name, h.field_hw_part_value AS hw_part_value, h.field_hw_version_value AS hw_version_value,
    sn.nid AS software_nid, sn.title AS software_name, s.field_sw_part_value AS sw_part_value, s.field_sw_version_value AS sw_version_value 
    FROM {named_configuration_relation} r 
    JOIN {named_configuration_relation} rh ON r.right_nid = rh.left_nid
    JOIN {node} hn ON rh.right_nid = hn.nid
    JOIN {content_type_hardware} h ON hn.nid = h.nid AND hn.vid = h.vid 
    JOIN {node} sn ON r.left_nid = sn.nid
    JOIN {content_type_software} s ON sn.nid = s.nid AND sn.vid = s.vid
    JOIN {content_field_device_type} dt ON s.nid = dt.nid AND s.vid = dt.vid
    JOIN {node} dn ON dt.field_device_type_nid = dn.nid 
    LEFT JOIN {content_field_expiration_datetime} ed ON sn.nid = ed.nid AND sn.vid = ed.vid
    WHERE ed.field_expiration_datetime_value IS NULL AND dn.title ='%s'";
  $rows = array();
  $result = db_query($query, $device_type_name);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['hw_nid'] = $row->hardware_nid;
    $res['hw_name'] = $row->hardware_name;
    $res['hw_part'] = $row->hw_part_value;
    $res['hw_version'] = $row->hw_version_value;
    $res['sw_nid'] = $row->software_nid;
    $res['sw_name'] = $row->software_name;
    $res['sw_part'] = $row->sw_part_value;
    $res['sw_version'] = $row->sw_version_value;
    $rows[] = $res;
  }
  return $rows;
}

function getNamedConfigHWFWRelationByDeviceType($device_type_name) {
  $query = "SELECT hn.nid AS hardware_nid, hn.title AS hardware_name, h.field_hw_part_value AS hw_part_value, h.field_hw_version_value AS hw_version_value,
    fn.nid AS firmware_nid, fn.title AS firmware_name, f.part AS fw_part_value, f.version AS fw_version_value 
    FROM {named_configuration_relation} r 
    JOIN {named_configuration_relation} rh ON r.right_nid = rh.left_nid
    JOIN {node} hn ON rh.right_nid = hn.nid
    JOIN {content_type_hardware} h ON hn.nid = h.nid AND hn.vid = h.vid 
    JOIN {node} fn ON r.left_nid = fn.nid
    JOIN {firmware} f ON fn.nid = f.nid AND fn.vid = f.vid
    JOIN {node} dn ON f.device_type_id = dn.nid 
    LEFT JOIN {content_field_expiration_datetime} ed ON fn.nid = ed.nid AND fn.vid = ed.vid
    WHERE ed.field_expiration_datetime_value IS NULL AND dn.title ='%s'";
  $rows = array();
  $result = db_query($query, $device_type_name);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['hw_nid'] = $row->hardware_nid;
    $res['hw_name'] = $row->hardware_name;
    $res['hw_part'] = $row->hw_part_value;
    $res['hw_version'] = $row->hw_version_value;
    $res['fw_nid'] = $row->firmware_nid;
    $res['fw_name'] = $row->firmware_name;
    $res['fw_part'] = $row->sw_part_value;
    $res['fw_version'] = $row->sw_version_value;
    $rows[] = $res;
  }
  return $rows;
}

function getDeviceHW($device_id) {
  $query = "select distinct b.nid, c.type,c.title as name ,b.field_hw_version_value as version ,
    b.field_hw_part_value as part, g.serial_number from 
    content_type_device_component_history a join content_type_hardware b on a.field_device_component_nid = b.nid 
    left join content_field_expiration_datetime e on a.nid = e.nid and a.vid =e.vid 
    left join device_hardware_serial_number g
    on a.field_component_device_nid = g.device_nid and b.nid = g.hardware_nid, 
    node c left join content_field_expiration_datetime d on c.nid = d.nid and c.vid = d.vid, 
    content_type_device f 
    where b.nid = c.nid and b.vid = c.vid 
    and d.field_expiration_datetime_value is null 
    and e.field_expiration_datetime_value is null 
    and a.field_component_device_nid = f.nid 
    and f.field_device_is_active_value = 1 and f.nid = %d";
  $rows = array();
  $result = db_query($query, $device_id);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['hw_nid'] = $row->nid;
    $res['type'] = $row->type;
    $res['name'] = $row->name;
    $res['part'] = $row->part;
    $res['version'] = $row->version;
    $res['serial_number'] = $row->serial_number;
    $rows[] = $res;
  }
  return $rows;
}

function getDeviceSW($device_id) {
  $query = "select distinct b.nid, c.type,c.title as name ,b.field_sw_version_value as version,
    b.field_sw_part_value as part from  
    content_type_device_component_history a join content_type_software b on a.field_device_component_nid = b.nid 
    left join content_field_expiration_datetime e on a.nid = e.nid and a.vid =e.vid, 
    node c left join content_field_expiration_datetime d 
    on c.nid = d.nid and c.vid = d.vid, 
    content_type_device f where b.nid = c.nid and b.vid = c.vid 
    and e.field_expiration_datetime_value is null and d.field_expiration_datetime_value is null 
    and a.field_component_device_nid = f.nid 
    and f.field_device_is_active_value = 1 and f.nid = %d";
  $rows = array();
  $result = db_query($query, $device_id);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['sw_nid'] = $row->nid;
    $res['type'] = $row->type;
    $res['name'] = $row->name;
    $res['part'] = $row->part;
    $res['version'] = $row->version;
    $rows[$row->nid] = $res;
  }
  return $rows;
}

function getDeviceFW($device_id) {
  $query = "select b.nid, 'firmware' as type ,b.title as name,b.version,b.part 
    from content_type_device_component_history a left join content_field_expiration_datetime c on a.nid= c.nid 
    and a.vid = c.vid, view_firmware b, content_type_device f 
    where a.field_device_component_nid = b.nid and a.field_component_device_nid = f.nid 
    and c.field_expiration_datetime_value is null 
    and f.field_device_is_active_value = 1 and f.nid = %d ";
  $rows = array();
  $result = db_query($query, $device_id);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['fw_nid'] = $row->nid;
    $res['type'] = $row->type;
    $res['name'] = $row->name;
    $res['part'] = $row->part;
    $res['version'] = $row->version;
    $rows[$row->nid] = $res;
  }
  return $rows;
}

function getDeviceAppliedConfig($device_id) {
  $query = "select b.nid ,b.title as name,b.version 
    from content_type_device_component_history a left join content_field_expiration_datetime c on a.nid= c.nid 
    and a.vid = c.vid, view_named_system_configuration b, content_type_device f 
    where a.field_device_component_nid = b.nid and a.field_component_device_nid = f.nid 
    and c.field_expiration_datetime_value is null 
    and f.field_device_is_active_value = 1 and f.nid = %d ";
  $result = db_query($query, $device_id);
  while ($row = db_fetch_object($result)) {
    $res = array();
    $res['sys_nid'] = $row->nid;
    $res['name'] = $row->name;
    $res['version'] = $row->version;
  }
  return $res;
}
