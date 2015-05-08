<?php

/**
 * @file
 * Reports module function SQL placed here.
 */

/**
 * Helper function to query the values for the module functions.
 */
function get_productline_query($i) {
  switch ($i) {
    case 0:
      $qry = "select nid,title from {node} where type='product_line' AND status=1";
      break;
    case 1:
      $qry = "select nid,title from {node} where type='product_line' AND status=1 AND nid IN(%s)";
      break;
    default:
      $qry = "";
  }
  return $qry;
}

/**
 * Helper
 */
function get_device_type_query() {
  return "SELECT n.nid AS devicetype_nid, n.title AS device_type 
    FROM {node} n
    JOIN {content_type_devicetype} d ON n.vid = d.vid
    JOIN {content_field_device_product_line} pl ON pl.nid = n.nid 
    WHERE n.status = 1 AND pl.field_device_product_line_nid='%d'";
}

/**
 * Helper
 */
function get_customer_name_query($post, $user) {
  $tmpwhere = '';
  if ($user->covidien_user != 'Yes') {
    $customer_nid = implode(',', $user->customer_nid);
    $customer_nid = helper_queryin($customer_nid);
    $tmpwhere .= " AND node1.nid IN (" . $customer_nid . ") ";
  }
  if ($post['filtertype'] == 'tcname') {
    $tmpwhere .= " AND node1.title!='Unknown' ";
  }
  $qry = "select node1.title as customer_name from {content_type_party}
    join {content_type_bu_customer} on content_type_bu_customer.field_customer_party_pk_nid=content_type_party.nid 
    join {node} as node1 on node1.nid=content_type_bu_customer.field_customer_party_pk_nid 
    LEFT JOIN {content_field_expiration_datetime} as expiry on expiry.vid = content_type_party.vid 
    where expiry.field_expiration_datetime_value IS NULL AND node1.title like'%%%s%' " . $tmpwhere . " limit 20";
  return $qry;
}

/**
 * Helper
 */
function get_account_number_query($i, $post) {
  $tmpwhere = '';
  if ($post['filtertype'] == 'tacno') {
    $tmpwhere .= " AND node3.title!='Unknown' ";
  }
  switch ($i) {
    case 0:
      $qry = "select content_type_bu_customer.field_bu_customer_account_number_value as account_number 
        from {content_type_bu_customer}
        join {node} on node.nid=content_type_bu_customer.nid and node.vid=content_type_bu_customer.vid 
        join {content_type_party} on content_type_party.nid=content_type_bu_customer.field_customer_party_pk_nid 
        join {node} as node3 on node3.nid=content_type_party.nid and node3.vid=content_type_party.vid 
        join {content_type_party_type} on content_type_party.field_party_type_nid=content_type_party_type.nid 
        join {node} as node1 on node1.nid=content_type_party_type.nid and node1.vid=content_type_party_type.vid and node1.title='Customer' 
        LEFT JOIN {content_field_expiration_datetime} as expiry on expiry.vid = content_type_bu_customer.vid 
        where expiry.field_expiration_datetime_value is NULL 
        AND content_type_bu_customer.field_bu_customer_account_number_value like '%%%s%' " . $tmpwhere . " limit 20";
      break;
    case 1:
      $qry = "select content_type_bu_customer.field_bu_customer_account_number_value as account_number 
        from {content_type_bu_customer}
        join {node} on node.nid=content_type_bu_customer.nid and node.vid=content_type_bu_customer.vid 
        join {content_type_party} on content_type_party.nid=content_type_bu_customer.field_customer_party_pk_nid 
        join {node} as node3 on node3.nid=content_type_party.nid and node3.vid=content_type_party.vid 
        join {content_type_party_type} on content_type_party.field_party_type_nid=content_type_party_type.nid 
        join {node} as node1 on node1.nid=content_type_party_type.nid and node1.vid=content_type_party_type.vid and node1.title='Customer' 
        LEFT JOIN {content_field_expiration_datetime} as expiry on expiry.vid=content_type_bu_customer.vid 
        where expiry.field_expiration_datetime_value IS NULL 
        AND node3.title like '%s' AND content_type_bu_customer.field_bu_customer_account_number_value like '%%%s%' " . $tmpwhere . " limit 20";
      break;
    default :
      $qry = "";
  }
  return $qry;
}

/**
 * Helper
 */
function get_software_name_query() {
  $qry = "select node.nid as software_nid,node.title as software_name 
      from content_type_software join node on node.vid=content_type_software.vid 
      join content_field_expiration_datetime on content_field_expiration_datetime.vid=content_type_software.vid 
      and content_field_expiration_datetime.field_expiration_datetime_value is NULL 
      join content_field_device_type on content_field_device_type.vid=content_type_software.vid 
      where content_field_device_type.field_device_type_nid='%d'";
  return $qry;
}

/**
 * Helper
 */
function get_part_number_query() {
  $qry = "select field_sw_part_value from content_type_software join node on node.nid= content_type_software.nid and node.vid= content_type_software.vid where node.title='%s' group by  field_sw_part_value";
  return $qry;
}

/**
 * Helper
 */
function get_ds_number_query($user, $device_type, $software_name, $part_number, $version, $string) {
  $qry_args = array();
  $qry_where = '';
  $swjoin = FALSE;
  if ($device_type > 0) {
    $qry_where .= " AND node2.nid IN (" . $device_type . ") ";
  } else {
    $qry_where .= " AND node2.nid IN (" . $user->devices_nid . ") ";
  }
  if ($software_name != '' && $software_name != 'all') {
    $qry_args[] = $software_name;
    $qry_where .= " AND node.title='%s' ";
    $swjoin = TRUE;
  }
  if ($part_number != '' && $part_number != 'all') {
    $qry_args[] = $part_number;
    $qry_where .= " and content_type_software.field_sw_part_value='%s' ";
    $swjoin = TRUE;
  }
  if ($version != '' && $version != 'all') {
    $qry_args[] = $version;
    $qry_where .= " and content_type_software.field_sw_version_value='%s' ";
    $swjoin = TRUE;
  }
  if ($string != '') {
    $qry_args[] = $string;
    $qry_where .= " and content_type_device.field_device_serial_number_value LIKE '%%%s%' ";
  }
  if ($swjoin) {
    $qry_join = "join content_type_software on content_type_software.nid=content_type_device_component_history.field_device_component_nid join node on node.nid=content_type_software.nid and node.vid=content_type_software.vid";
  }
  $qry = "select distinct content_type_device.field_device_serial_number_value from content_type_device join content_type_device_component_history on content_type_device_component_history.field_component_device_nid=content_type_device.nid " . $qry_join . " JOIN content_field_device_type on content_field_device_type.nid=content_type_device.nid and content_field_device_type.vid=content_type_device.vid JOIN content_type_devicetype on content_type_devicetype.nid=content_field_device_type.field_device_type_nid JOIN node as node2 on node2.vid=content_type_devicetype.vid where 1 " . $qry_where . " limit 0,20";
  return array('query' => $qry, 'arg' => $qry_args);
}

/**
 * Helper
 */
function get_version_query() {
  $qry = "select field_sw_version_value from content_type_software join node on node.nid=content_type_software.nid and node.vid=content_type_software.vid  where node.title='%s' and content_type_software.field_sw_part_value='%s'";
  return $qry;
}

/**
 * Helper
 */
function get_nodetitle_query() {
  return "SELECT title from {node} where nid='%d'";
}

/**
 * Helper
 */
function get_servicetype_query() {
  $query = "select node.nid, node.title as servicetype from node join content_type_device_service_type on content_type_device_service_type.nid=node.nid and content_type_device_service_type.vid=node.vid";
  return $query;
}

/**
 * Helper
 */
function get_acno_customer_name_query($user, $post) {
  $tmpwhere = '';
  if ($user->covidien_user != 'Yes') {
    $customer_nid = implode(',', $user->customer_nid);
    $customer_nid = helper_queryin($customer_nid);
    $tmpwhere .= " AND node1.nid IN (" . $customer_nid . ") ";
  }
  if ($post['filtertype'] == 'tcname') {
    $tmpwhere .= " AND node1.title!='Unknown' ";
  }
  $query = "select node1.title as customername 
    from {content_type_party}
    join {content_type_bu_customer} on content_type_bu_customer.field_customer_party_pk_nid=content_type_party.nid 
    join {node} as node1 on node1.nid=content_type_bu_customer.field_customer_party_pk_nid 
    LEFT JOIN {content_field_expiration_datetime} as expiry on expiry.vid=content_type_party.vid  
    where expiry.field_expiration_datetime_value is NULL
    AND content_type_bu_customer.field_bu_customer_account_number_value='%s' and node1.title like '%%%s%' " . $tmpwhere . " limit 20";
  return $query;
}

/**
 * Helper
 */
function get_country_query() {
  $qry = "select content_type_country.nid,node.title from content_type_country join node on node.vid=content_type_country.vid order by node.title asc";
  return $qry;
}

/**
 * Helper
 */
function get_hw_name_query() {
  $qry = "select node.nid as hardware_nid,node.title as hardware_name 
      from content_type_hardware 
      join node on node.vid=content_type_hardware.vid 
      join content_field_expiration_datetime on content_field_expiration_datetime.vid=content_type_hardware.vid 
      and content_field_expiration_datetime.field_expiration_datetime_value is NULL 
      join content_field_device_type on content_field_device_type.vid=content_type_hardware.vid where content_field_device_type.field_device_type_nid='%d'";
  return $qry;
}

/**
 * Helper
 */
function get_hwpart_number_query() {
  $qry = "select field_hw_part_value from content_type_hardware join node on node.nid=content_type_hardware.nid and node.vid= content_type_hardware.vid where node.title='%s' group by field_hw_part_value";
  return $qry;
}

/**
 * Helper
 */
function get_hwversion_query() {
  $qry = "select field_hw_version_value from content_type_hardware join node on node.nid=content_type_hardware.nid and node.vid=content_type_hardware.vid where node.title='%s' and content_type_hardware.field_hw_part_value='%s'";
  return $qry;
}

/**
 * Helper
 */
function get_CustomerName_report_query($user, $value) {
  $tmpwhere = '';
  if ($user->covidien_user != 'Yes') {
    $customer_nid = implode(',', $user->customer_nid);
    $customer_nid = helper_queryin($customer_nid);
    $tmpwhere = " node1.nid IN (" . $customer_nid . ") AND ";
  }
  $where = '';
  if (!empty($value) && $value != 'all') {
    $where = ' content_type_bu_customer.field_bu_customer_account_number_value="' . $value . '" and';
  }
  $qry = "select node1.title as customername 
    from {content_type_party}
    join {content_type_bu_customer} on content_type_bu_customer.field_customer_party_pk_nid = content_type_party.nid 
    join {node} as node1 on node1.nid = content_type_bu_customer.field_customer_party_pk_nid 
    LEFT JOIN {content_field_expiration_datetime} expiry on expiry.vid = content_type_party.vid 
    where expiry.field_expiration_datetime_value is NULL 
    AND $where $tmpwhere node1.title like '%%%s%%' limit 0,20";
  return $qry;
}

/**
 * Helper
 */
function get_CustomerAccount_report_query($user, $value) {
  $tmpwhere = '';
  if ($user->covidien_user != 'Yes') {
    $customer_nid = implode(',', $user->customer_nid);
    $customer_nid = helper_queryin($customer_nid);
    $tmpwhere = " node1.nid IN (" . $customer_nid . ") AND ";
  }
  $where = '';
  if (!empty($value) && $value != 'all') {
    $where = ' node1.title="' . $value . '" and';
  }
  $qry = "select content_type_bu_customer.field_bu_customer_account_number_value 
    from content_type_party 
    join content_type_bu_customer on content_type_bu_customer.field_customer_party_pk_nid=content_type_party.nid 
    join node as node1 on node1.nid=content_type_bu_customer.field_customer_party_pk_nid 
    LEFT JOIN content_field_expiration_datetime as expiry on expiry.vid=content_type_bu_customer.vid  
    where expiry.field_expiration_datetime_value is NULL
    AND $where $tmpwhere content_type_bu_customer.field_bu_customer_account_number_value like '%%%s%%' and node1.title != 'Unknown' limit 0,20";
  return $qry;
}

function get_total_device_report_query() {
  $qry = "select node.title,count(content_field_device_type.field_device_type_nid) as totaldevices from content_field_device_type join node node1 on (content_field_device_type.nid = node1.nid and content_field_device_type.vid =node1.vid and node1.type = 'device' ) join content_field_expiration_datetime on((content_field_device_type.nid = content_field_expiration_datetime.nid and content_field_device_type.vid =content_field_expiration_datetime.vid and isnull(content_field_expiration_datetime.field_expiration_datetime_value))) right join node on (node.nid = content_field_device_type.field_device_type_nid) where node.type = 'devicetype' group by node.nid";
  return $qry;
}

function get_configuration_name_query() {
  $query = "SELECT nid, title FROM {node} WHERE type='%s'";
  $result = db_query($query, 'device_type_config');
  return $result;
}

function get_configuration_version_query() {
  $query = "SELECT c.nid, c.field_device_config_version_value AS ver FROM node n
 						LEFT JOIN content_type_device_type_config c ON n.vid=c.vid
						WHERE n.type='%s';";
  $result = db_query($query, 'device_type_config');
  return $result;
}

function get_audit_trail_report_query($args) {
  $query = "SELECT activity_log.logtime AS date_time,
      activity_log.aid, 
      CONCAT(content_type_person.field_first_name_value,' ',content_type_person.field_last_name_value) AS user_id, 
      node.title as customer_name,
      content_type_bu_customer.field_bu_customer_account_number_value AS customer_account_number,
      activity_log.message AS activity,
      activity_log.ip_address AS host_name,
      activity_log.device AS device_type,
      activity_log.device_serial AS device_serial_number
      FROM activity_log 
      LEFT JOIN content_type_person content_type_person on content_type_person.nid = activity_log.nid 
      LEFT JOIN content_type_bu_customer on content_type_bu_customer.nid = content_type_person.field_comp_account_no_nid 
      LEFT JOIN node on node.nid = content_type_bu_customer.field_customer_party_pk_nid    ";
  if ($args['from_date'] && $args['to_date']) {
    $query .= " WHERE (activity_log.logtime BETWEEN '%s' AND '%s') ";
  }
  if ($args['productline_nid'] && is_numeric($args['productline_nid'])) {
    $query .= " AND (activity_log.product_line_nid = %d) ";
  }
  if ($args['username'] && $args['username'] != 'All') {
    $query .= " AND content_type_person.field_person_username_value = '%s' ";
  }
  if ($args['last_name'] && $args['last_name'] != 'All') {
    $query .= " AND CONCAT(content_type_person.field_first_name_value,' ',content_type_person.field_last_name_value) = '%s' ";
  }
  if ($args['activity_type'] && $args['activity_type'] != 'All') {
    $query .= " AND activity_log.activity_type = '%s' ";
  }
  
  $cid_array = array(
    'All' => 'All',
    'DMP-Unknown' => 'DMP-Unknown',
    'Unknown' => 'Unknown'
  );
  
  if ($args['cid'] && (!in_array($args['cid'], $cid_array))) {
    $query .= " AND node.title = '%s' ";
  }
  if ($args['comp_account_no'] && (!in_array($args['comp_account_no'], $cid_array))) {
    $query .= " and content_type_bu_customer.field_bu_customer_account_number_value = '%s'  ";
  }

  $query .= " GROUP BY activity_log.logtime ";  
  return $query;
}

/**
 * Helper function to query the device type, s/w version, cuntry and total number by customer. 
 * Parameters $product_line,$customer_name to replace the placeholder
 */
function get_device_category_by_customer_report_query() {
  $qry = "select c.title as devicetype,g.software_version as software_version ,f.title as country ,count(1) as total
from content_type_device a, content_field_device_type b, node c, content_field_device_pk d, 
content_type_device_installation e, node f, Software_VW g,
content_field_device_product_line h, node i, content_field_expiration_datetime j,
content_field_expiration_datetime k, Hardware_VW l
where a.nid = b.nid and c.type='devicetype' and b.field_device_type_nid = c.nid and d.field_device_pk_nid = a.nid
and d.nid = e.nid and e.field_device_country_nid = f.nid and g.component_device = b.nid and h.field_device_product_line_nid = '%d'
and h.nid = b.field_device_type_nid and i.title = trim('%s') and a.field_device_owner_nid = i.nid and a.nid = j.nid
and (j.field_expiration_datetime_value > now() or j.field_expiration_datetime_value is null) and a.nid = k.nid
and (k.field_expiration_datetime_value > now() or k.field_expiration_datetime_value is null)
and a.nid = l.component_device group by 1,2,3 order by 1,2,3";
  return $qry;
}
