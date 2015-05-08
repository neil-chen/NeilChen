<?php

/**
 * @file
 * Hardware catlog module function SQL placed here.
 */

/**
 * Helper function to query the values for the module functions.
 */
function sw_association_query($i = 0) {
  $qry = db_rewrite_sql("SELECT node.nid FROM {content_type_software} AS cts JOIN {content_field_hw_list} AS cfhl ON cts.vid=cfhl.vid JOIN {node} AS node ON node.vid=cts.vid JOIN {content_field_expiration_datetime} AS cfed ON cts.vid=cfed.vid AND cfed.field_expiration_datetime_value IS NULL WHERE cfhl.field_hw_list_nid='%d'");
  return $qry;
}

/**
 * Helper function to query the values for the module functions.
 */
function doc_association_query($i = 0) {
  $qry = db_rewrite_sql("SELECT node.nid FROM {content_type_document} AS ctd JOIN {content_field_doc_hw_list} AS cfdhwl ON ctd.vid=cfdhwl.vid JOIN {node} AS node ON node.vid=ctd.vid JOIN {content_field_expiration_datetime} AS cfed ON ctd.vid=cfed.vid AND cfed.field_expiration_datetime_value IS NULL WHERE cfdhwl.field_doc_hw_list_nid='%d'");
  return $qry;
}

/**
 * Helper function to query the values for the module functions.
 */
function conf_association_query($i = 0) {
  $qry = db_rewrite_sql("SELECT node.nid FROM {content_type_device_type_config} AS cdtc JOIN {content_field_device_config_hw_list} AS cfdchwl ON cdtc.vid=cfdchwl.vid JOIN {content_type_device_config_hardware} AS ctdch ON cfdchwl.field_device_config_hw_list_nid=ctdch.nid JOIN {node} AS node ON node.vid=cdtc.vid JOIN content_field_expiration_datetime ON cdtc.vid=content_field_expiration_datetime.vid AND content_field_expiration_datetime.field_expiration_datetime_value IS NULL WHERE ctdch.field_device_config_hardware_nid='%d'");
  return $qry;
}
