<?php

/**
 * @file
 * Firmware catlog module function SQL placed here.
 */

/**
 * Helper function to query the values for the module functions.
 */
function firmware_integrity_query($i = 0) {
  $qry = db_rewrite_sql("select file_integrity_check_value from {firmware} where id=%d");
  return $qry;
}

/**
 * Helper function to query the values for the module functions.
 */
function covidien_firmware_cron_query($i = 0) {
  switch ($i) {
    case 0:
      $qry = "UPDATE {firmware} SET file_integrity_check_value='%s' WHERE nid=%d";
      break;
    case 1:
      $qry = "UPDATE {files} SET filepath='%s', filesize='%s' WHERE fid=%d";
      break;
    case 2:
      $qry = "SELECT fw.nid AS firmware_id, f.fid, f.filepath FROM {firmware} fw JOIN {files} f ON fw.file_id = f.fid WHERE fw.file_integrity_check_value IS NULL";
      break;
    default:
      $qry = '';
  }
  return $qry;
}
