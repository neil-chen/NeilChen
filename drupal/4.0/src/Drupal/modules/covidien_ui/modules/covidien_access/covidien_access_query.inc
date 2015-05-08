<?php

/**
 * Query functions
 */
function getNodeDetailsAccess($name, $type) {
  $query = "select * from {node} where title='%s' and type='%s'";
  return db_result(db_query($query, $name, $type));
}

function getNodecountAccess($nodetype, $nodetype) {
  $query = "select count(*) as ncount from node_type where type='%s'";
  return db_query($query, $nodetype);
}

function checkExpirednodeQuery($nid) {
  $query = "select field_expiration_datetime_value from content_field_expiration_datetime where nid = '%s' order by vid DESC LIMIT 0,1";
  return db_result(db_query($query, $nid));
}

function getUserRoldQuery($uid) {
  $query = "select T3.name from {users} as T1 join {users_roles} as T2 on T1.uid = T2.uid join {role} as T3 on T2.rid = T3.rid where T1.uid = '%s'";
  return db_result(db_query($query, $uid));
}

function checkNodetype() {
  return db_result(db_query("select type from {node_type} where type = 'product_line_report'"));
}

function getProductlinereportDetails($pl) {
  if ($pl == 'all') {
    $result = db_query("select distinct(field_report_name_value) from content_type_product_line_report");
  } else {
    $result = db_query("select distinct(field_report_name_value) from content_type_product_line_report where field_report_product_line_nid='%s'", $pl);
  }
  return $result;
}

function getUserExpireinfo($date, $uid) {
  $query = "select T1.nid from {node} as T1 join {content_type_person} as T2 on T1.nid = T2.nid join {users} as T3 on T1.title = T3.name where T2.field_password_expiration_date_value < '%s' and T1.type = 'person' and T3.uid='%s'";
  return db_result(db_query($query, $date, $uid));
}
