<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

function  device_current_configuration_report_query($hid_condition ,&$query) {
  //	  TODO   $query->where

//  echo "<pre>";
//  var_dump($query->where);
//  exit;

  unset($query->where[0]['clauses'][9]);

  $counry_id = $query->where[0]['args'][9] ;
  unset($query->where[0]['args'][9]);

  if($counry_id == 0 ) {
    $query->where[0]['clauses'][8] = "(device_software_version_view.customername) = ('%s') ". $hid_condition
      ." device_software_version_view.country_nid is not null";

  } else {
    $query->where[0]['clauses'][8] = "(device_software_version_view.customername) = ('%s') ". $hid_condition
      ." device_software_version_view.country_nid = %d ";
    array_splice($query->where[0]['args'],9,0,array($counry_id));
  }

  // edit  end

//  echo "<pre>";
//  var_dump($query->where);
//  exit;
}
