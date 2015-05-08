<?php

/**
 * Query functions
 */
function getadminproductline() {
  $query = "select T1.nid, T1.title from {node} as T1 join {content_type_product_line} as T2 on T1.nid = T2.nid where T1.type= 'product_line' and T2.field_product_line_isactive_value IS NULL";
  return db_query($query);
}

function getusersproductline($uid) {
  $query = "select T6.nid, T6.title,T1.field_person_role_default_value as default_val from {content_type_person_application_role} as T1 join {content_field_person_pk} as T2 on T1.nid = T2.nid join {content_field_app_role_pk} as T3 on T1.nid = T3.nid join {node} as T4 on T2.field_person_pk_nid = T4.nid join content_type_roles as T5 on T3.field_app_role_pk_nid = T5.nid join node as T6 on T5.field_role_product_line_nid = T6.nid where T4.uid = '%s' and T4.type='person'";
  return db_query($query, $uid);
}

function updateuserexpirydatesub($diff_date, $nid) {
  $query = "Update {content_type_person} set field_password_expiration_date_value = date_sub(field_password_expiration_date_value, INTERVAL '%s' day) where nid='%s'";
  db_query($query, $diff_date, $nid);
}

function updateuserexpirydateadd($diff_date, $nid) {
  $query = "Update {content_type_person} set field_password_expiration_date_value = DATE_ADD(field_password_expiration_date_value, INTERVAL '%s' DAY) where nid='%s'";
  db_query($query, $diff_date, $nid);
}

function getalluserexpiredate() {
  return db_query("Select nid, field_password_expiration_date_value from {content_type_person}");
}

function getpasswordnotice($uid) {
  $query = "select T2.field_password_expiration_date_value from {node} as T1 join {content_type_person} as T2 on T1.nid = T2.nid join {users} as T3 on T1.uid = T3.uid where T3.uid = '%s' and T1.type = 'person'";
  return db_result(db_query($query, $uid));
}

function getnoderevision($vid, $nid) {
  return db_query("select * from {node_revisions} where vid = '%d' and nid = '%d'", $vid, $nid);
}

function gethardwarenode($vid) {
  return db_query("select * from {content_type_hardware} where vid = '%d'", $vid);
}

function getdevicetypenid_count_query($i = 1) {
  if ($i == 2) {
    $sql = "select COUNT(node.nid) from {node} JOIN {content_field_expiration_datetime} AS cfed ON cfed.vid=node.vid and cfed.nid=node.nid and cfed.field_expiration_datetime_value IS NULL where node.type='devicetype' and node.title = '%s' and node.nid!='%d'";
  } else {
    $sql = "select COUNT(node.nid) from {node} JOIN {content_field_expiration_datetime} AS cfed ON cfed.vid=node.vid and cfed.nid=node.nid and cfed.field_expiration_datetime_value IS NULL where node.type='devicetype' and node.title = '%s'";
  }
  return $sql;
}

function clearallpasswordhash() {
  $time = format_date(time(), 'custom', 'Y-m-d H:i:s');
  db_query("UPDATE {content_type_person} SET field_password_reset_hash_value = '', field_forgotpass_req_date_value = '' where DATE_ADD(field_forgotpass_req_date_value, INTERVAL 12 HOUR) < '%s'", $time);
}
