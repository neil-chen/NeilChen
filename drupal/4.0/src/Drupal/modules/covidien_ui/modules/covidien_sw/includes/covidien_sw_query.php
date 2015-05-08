<?php

/**
 * @file
 * Software catlog module function SQL placed here.
 */

/**
 * Helper function to query the values for the module functions.
 */
function sw_integrity_query($i = 0) {
  $qry = db_rewrite_sql("select field_sw_integrity_check_value from {content_type_software} where vid='%d' and nid='%d'");
  return $qry;
}

/**
 * Helper function to query the values for the module functions.
 */
function covidien_sw_cron_query($i = 0) {
  switch ($i) {
    case 0:
      $qry = db_rewrite_sql("select * from {node} where nid=%d");
      break;
    case 1:
      $qry = "UPDATE content_type_software set field_sw_integrity_check_value='%s' where `vid`='%d' and `nid`='%d'";
      break;
    case 2:
      $qry = 'UPDATE files set filepath="%s",filesize="%s" WHERE fid="%d"';
      break;
    default:
      $qry = '';
  }
  return $qry;
}
