<?php

/**
 * @file
 * Document catlog module function SQL placed here.
 */

/**
 * Helper function to query the values for the module functions.
 */
function doc_integrity_query($i = 0) {
  $qry = "SELECT field_document_md5sum_value FROM {content_type_document} WHERE vid='%d' and nid='%d'";
  return $qry;
}

/**
 * Helper function to query the values for the module functions.
 */
function covidien_doc_cron_query($i = 0) {
  switch ($i) {
    case 0:
      $qry = "SELECT * FROM {node} WHERE nid=%d";
      break;
    case 1:
      $qry = "UPDATE {content_type_document} SET field_document_md5sum_value='%s' WHERE `vid`='%d' and `nid`='%d'";
      break;
    case 2:
      $qry = 'UPDATE {files} SET filepath="%s",filesize="%s" WHERE fid="%d"';
      break;
    default:
      $qry = '';
  }
  return $qry;
}

/**
 * Helper function for query builing.
 */
function _doc_config_hwlist_query($qry_arg, $confnid, $devicenid, $hwtype) {
  $qry_process = array();
  $qry_str = "SELECT node.nid AS nid,
   node.title AS node_title,
   node_data_field_device_config_version.field_device_config_version_value AS node_data_field_device_config_version_field_device_config_version_value,
   node.type AS node_type,
   node.vid AS node_vid,
   node_data_field_device_config_version.field_effective_date_value AS node_data_field_device_config_version_field_effective_date_value,
   node_data_field_device_config_version.field_device_end_of_life_value AS node_data_field_device_config_version_field_device_end_of_life_value,
   node.created AS node_created,
   node_node_data_field_device_config_hardware.title AS node_node_data_field_device_config_hardware_title,
   node_node_data_field_device_config_hardware.nid AS node_node_data_field_device_config_hardware_nid,
   node_node_data_field_device_config_hardware_node_data_field_hw_version.field_hw_version_value AS node_node_data_field_device_config_hardware_node_data_field_hw_version_field_hw_version_value,
   node_node_data_field_device_config_hardware.type AS node_node_data_field_device_config_hardware_type,
   node_node_data_field_device_config_hardware.vid AS node_node_data_field_device_config_hardware_vid,
   node_node_data_field_device_config_hw_list_node_data_field_device_config_hw_status.field_device_config_hw_status_value AS node_node_data_field_device_config_hw_list_node_data_field_device_config_hw_status_field_device_config_hw_status_value,
   node_node_data_field_device_config_hw_list.nid AS node_node_data_field_device_config_hw_list_nid,
   node_node_data_field_device_config_hw_list.type AS node_node_data_field_device_config_hw_list_type,
   node_node_data_field_device_config_hw_list.vid AS node_node_data_field_device_config_hw_list_vid,   
   node_node_data_field_hw_type.title AS node_node_data_field_hw_type_title,
   node_node_data_field_hw_type.nid AS node_node_data_field_hw_type_nid
 FROM {node} node 
 LEFT JOIN {content_field_device_config_hw_list} node_data_field_device_config_hw_list ON node.vid = node_data_field_device_config_hw_list.vid
 LEFT JOIN {node} node_node_data_field_device_config_hw_list ON node_data_field_device_config_hw_list.field_device_config_hw_list_nid = node_node_data_field_device_config_hw_list.nid
 LEFT JOIN {content_type_device_config_hardware} node_node_data_field_device_config_hw_list_node_data_field_device_config_hardware ON node_node_data_field_device_config_hw_list.vid = node_node_data_field_device_config_hw_list_node_data_field_device_config_hardware.vid
 LEFT JOIN {node} node_node_data_field_device_config_hardware ON node_node_data_field_device_config_hw_list_node_data_field_device_config_hardware.field_device_config_hardware_nid = node_node_data_field_device_config_hardware.nid
 LEFT JOIN {content_field_device_config_sw_list} node_node_data_field_device_config_hw_list_node_data_field_device_config_sw_list ON node_node_data_field_device_config_hw_list.vid = node_node_data_field_device_config_hw_list_node_data_field_device_config_sw_list.vid
 LEFT JOIN {node} node_node_data_field_device_config_sw_list ON node_node_data_field_device_config_hw_list_node_data_field_device_config_sw_list.field_device_config_sw_list_nid = node_node_data_field_device_config_sw_list.nid
 LEFT JOIN {content_type_device_config_software} node_node_data_field_device_config_sw_list_node_data_field_device_config_software ON node_node_data_field_device_config_sw_list.vid = node_node_data_field_device_config_sw_list_node_data_field_device_config_software.vid
 LEFT JOIN {node} node_node_data_field_device_config_software ON node_node_data_field_device_config_sw_list_node_data_field_device_config_software.field_device_config_software_nid = node_node_data_field_device_config_software.nid
 LEFT JOIN {content_type_hardware} node_node_data_field_device_config_hardware_node_data_field_hw_type ON node_node_data_field_device_config_hardware.vid = node_node_data_field_device_config_hardware_node_data_field_hw_type.vid
 LEFT JOIN {content_field_expiration_datetime} content_field_expiration_datetime1 ON node_node_data_field_device_config_hardware_node_data_field_hw_type.vid = content_field_expiration_datetime1.vid and content_field_expiration_datetime1.field_expiration_datetime_value IS NULL
 LEFT JOIN {node} node_node_data_field_hw_type ON node_node_data_field_device_config_hardware_node_data_field_hw_type.field_hw_type_nid = node_node_data_field_hw_type.nid
 LEFT JOIN {content_field_device_type} node_data_field_device_type ON node.vid = node_data_field_device_type.vid
 LEFT JOIN {content_type_device_type_config} node_data_field_device_config_version ON node.vid = node_data_field_device_config_version.vid
 LEFT JOIN {content_type_hardware} node_node_data_field_device_config_hardware_node_data_field_hw_version ON node_node_data_field_device_config_hardware.vid = node_node_data_field_device_config_hardware_node_data_field_hw_version.vid
 LEFT JOIN {content_field_expiration_datetime} content_field_expiration_datetime2 ON node_node_data_field_device_config_hardware_node_data_field_hw_version.vid = content_field_expiration_datetime2.vid and content_field_expiration_datetime2.field_expiration_datetime_value IS NULL
 LEFT JOIN {content_type_device_config_hardware} node_node_data_field_device_config_hw_list_node_data_field_device_config_hw_status ON node_node_data_field_device_config_hw_list.vid = node_node_data_field_device_config_hw_list_node_data_field_device_config_hw_status.vid
 LEFT JOIN {content_field_expiration_datetime} node_node_data_field_device_config_hardware_node_data_field_expiration_datetime ON node_node_data_field_device_config_hardware.vid = node_node_data_field_device_config_hardware_node_data_field_expiration_datetime.vid and node_node_data_field_device_config_hardware_node_data_field_expiration_datetime.field_expiration_datetime_value IS NULL 
 WHERE (node.status = 1) AND (node.type in ('device_type_config')) ";
  if ($confnid != '' && $confid != 'all') {
    $qry_str .= "AND (node.title  like '%%%s%') ";
    $qry_arg[] = $confnid;
  }
  if ($devicenid != '' && $devicenid != 'all') {
    $qry_str .= "AND (node_data_field_device_type . field_device_type_nid IN (" . $devicenid . ") ) ";
  }
  if ($hwtype != '' && $hwtype != 'all') {
    $qry_str .= "AND (node_node_data_field_device_config_hardware_node_data_field_hw_type.field_hw_type_nid = '%d' )";
    $qry_arg[] = $hwtype;
  }
  $qry_str .= " ORDER BY node_created DESC";
  $qry_process['qry_str'] = $qry_str;
  $qry_process['qry_arg'] = $qry_arg;
  return $qry_process;
}

/**
 * Helper function for query builing
 */
function getdocid_config_query() {
  $qry_str = "SELECT content_type_document.nid FROM {content_type_device_type_config}
JOIN {node} as node2 on node2.nid=content_type_device_type_config.nid and 
node2.vid=content_type_device_type_config.vid
JOIN {content_field_device_config_hw_list} on content_field_device_config_hw_list.nid=content_type_device_type_config.nid 
JOIN {node} on node.nid=content_field_device_config_hw_list.nid and node.vid=content_field_device_config_hw_list.vid 
JOIN {content_type_device_config_hardware} on content_type_device_config_hardware.nid=content_field_device_config_hw_list.field_device_config_hw_list_nid
JOIN {content_field_doc_hw_list} on content_field_doc_hw_list.field_doc_hw_list_nid=content_type_device_config_hardware.field_device_config_hardware_nid
JOIN {node} as node3 on node3.nid=content_field_doc_hw_list.nid and node3.vid=content_field_doc_hw_list.vid
JOIN {content_type_document} on content_type_document.nid=content_field_doc_hw_list.nid and content_type_document.vid=content_field_doc_hw_list.vid 
JOIN {content_type_hardware} on content_type_hardware.nid=content_type_device_config_hardware.field_device_config_hardware_nid JOIN {node} as node4 on node4.nid=content_type_hardware.nid and node4.vid=content_type_hardware.vid
JOIN {content_field_expiration_datetime} on content_field_expiration_datetime.nid=content_type_hardware.nid and content_field_expiration_datetime.vid=content_type_hardware.vid and content_field_expiration_datetime.field_expiration_datetime_value IS NULL
WHERE node2.title='%s'
UNION
SELECT content_type_document.nid FROM {content_type_device_type_config}
JOIN {node} as node2 on node2.nid=content_type_device_type_config.nid and 
node2.vid=content_type_device_type_config.vid
JOIN {content_field_device_config_hw_list} on content_field_device_config_hw_list.nid=content_type_device_type_config.nid 
JOIN {node} on node.nid=content_field_device_config_hw_list.nid and node.vid=content_field_device_config_hw_list.vid 
JOIN {content_type_device_config_hardware} on content_type_device_config_hardware.nid=content_field_device_config_hw_list.field_device_config_hw_list_nid
JOIN {content_field_device_config_sw_list} on content_field_device_config_sw_list.nid=content_field_device_config_hw_list.field_device_config_hw_list_nid 
JOIN {node} as node1 on node1.nid=content_field_device_config_sw_list.nid and node1.vid=content_field_device_config_sw_list.vid
JOIN {content_type_device_config_software} on content_type_device_config_software.nid=content_field_device_config_sw_list.field_device_config_sw_list_nid
JOIN {content_field_doc_sw_list} on content_field_doc_sw_list.field_doc_sw_list_nid=content_type_device_config_software.field_device_config_software_nid
JOIN {node} as node3 on node3.nid=content_field_doc_sw_list.nid and node3.vid=content_field_doc_sw_list.vid
JOIN {content_type_document} as content_type_document  on content_type_document.nid=content_field_doc_sw_list.nid and content_type_document.vid=content_field_doc_sw_list.vid 
JOIN {content_type_software} on content_type_software.nid=content_type_device_config_software.field_device_config_software_nid
JOIN {node} as node5 on node5.nid=content_type_software.nid and node5.vid=content_type_software.vid
JOIN {content_field_expiration_datetime} on content_field_expiration_datetime.nid=content_type_software.nid and content_field_expiration_datetime.vid=content_type_software.vid and content_field_expiration_datetime.field_expiration_datetime_value IS NULL
WHERE node2.title='%s'";
  return $qry_str;
}

/**
 * Helper function for query building.
 */
function getdoc_hwlist_query($qry_arg, $hwtype, $user, $devicenid) {
  $qry_str = "SELECT node.nid AS nid,
   node.title AS node_title,node_data_field_hw_type.field_hw_version_value as hardware_version
 FROM {node} node 
 LEFT JOIN {content_type_hardware} node_data_field_hw_type ON node.vid = node_data_field_hw_type.vid
 LEFT JOIN {node node_node_data_field_hw_type} ON node_data_field_hw_type.field_hw_type_nid = node_node_data_field_hw_type.nid
 LEFT JOIN {content_field_expiration_datetime} node_data_field_expiration_datetime ON node.vid = node_data_field_expiration_datetime.vid
 LEFT JOIN {content_field_device_type} node_data_field_device_type ON node.vid = node_data_field_device_type.vid
 WHERE ((node.status = 1) AND (node.type in ('hardware')) ";
  $qry_str .= "AND (node_data_field_hw_type.field_hw_type_nid = '%d' )";
  $qry_arg[] = $hwtype;
  if (strtolower($user->devices_nid) != 'all') {
    $qry_str .= " AND (node_data_field_device_type.field_device_type_nid In (" . $devicenid . ") )";
  }
  $qry_str .= ") AND (node_data_field_expiration_datetime.field_expiration_datetime_value IS NULL)
   ORDER BY node_title ASC";
  $qry_process['qry_str'] = $qry_str;
  $qry_process['qry_arg'] = $qry_arg;
  return $qry_process;
}

/**
 * Helper function to build query.
 */
function doc_device_permission_query() {
  $qry_str = "SELECT 
    node.title AS productline,
    node.nid AS productline_nid,
    node1.title AS devicetype,
    content_type_devicetype.nid AS devicetype_nid,
    content_type_device.nid AS device_nid,
    content_type_device.field_device_owner_nid AS device_owner,
    content_type_device.field_device_serial_number_value AS deviceserial 
    FROM {node} 
    JOIN {content_field_device_product_line} ON content_field_device_product_line.field_device_product_line_nid = node.nid 
    JOIN {content_type_devicetype} ON content_type_devicetype.nid = content_field_device_product_line.nid AND content_field_device_product_line.vid = content_type_devicetype.vid 
    JOIN {node} AS node1 ON node1.nid = content_type_devicetype.nid AND node1.vid = content_type_devicetype.vid 
    JOIN {content_field_device_type} ON content_field_device_type.field_device_type_nid = content_type_devicetype.nid 
    JOIN {content_type_device} ON content_type_device.nid = content_field_device_type.nid AND content_type_device.field_maintance_expiration_date_value >= NOW() 
    JOIN {content_type_bu_customer} ON content_type_device.field_device_owner_nid = content_type_bu_customer.nid
    JOIN {content_type_person} ON content_type_person.field_company_name_nid = content_type_bu_customer.field_customer_party_pk_nid 
    WHERE node.nid='%d' and content_type_person.field_person_username_value='%s' ";
  return $qry_str;
}

/**
 * Helper function to build query.
 */
function node_pl_query() {
  $qry_str = "select node.title,node.nid from content_type_product_line join content_field_device_product_line on content_type_product_line.nid=content_field_device_product_line.field_device_product_line_nid join content_type_devicetype on content_type_devicetype.vid=content_field_device_product_line.vid join node on node.vid=content_type_product_line.vid where content_type_devicetype.nid='%d'";
  return $qry_str;
}
