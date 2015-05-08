<?php

/**
 * get the relation between device type and gateway version.
 * 
 * @param String $deviceTypeName device type name.
 */
function get_device_type_relation_with_gateway_version($deviceTypeName = '') {
  if ($deviceTypeName == '') {
    $sql = "select n.title , d.device_type_gateway_version from {content_type_devicetype} d join {node} n
   on d.nid = n.nid where  n.type='devicetype' ";
    $device_type = array();
    $results = db_query($sql);
    while ($row = db_fetch_array($results)) {
      $device_type[current($row)] = next($row);
    }

    return $device_type;
  } else {
    $sql = "select device_type_gateway_version from  content_type_devicetype d join node n
   on d.nid = n.nid where n.title = '%s' and n.type='devicetype' ";
    $device_type_version = db_result(db_query($sql, $deviceTypeName));

    return $device_type_version;
  }
}
