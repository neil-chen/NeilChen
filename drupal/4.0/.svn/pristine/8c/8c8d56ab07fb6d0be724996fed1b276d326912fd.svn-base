<?php

/**
 * @file
 * The helper functions used in the sample, seed and ref data processing.
 */

/**
 * Helper function to create user privileges.
 */
function create_user_privilege($devicetype, $uname, $section_access_permissions) {
  $field_person_pk = db_result(db_query("select nid from {node} where type='person' and title='%s'", $uname));
  $field_device_type = $devicetype;
  $field_user_section_access = $section_access_permissions['Trainer']['Yes'];
  $node = new stdClass();
  $node->type = 'device_user_privileges';
  $node->uid = 1;
  $node->format = 0;
  $node->title = $uname;
  $node->field_person_pk[0]['nid'] = $field_person_pk;
  $node->field_device_type[0]['nid'] = $field_device_type;
  $node->field_user_section_access[0]['nid'] = $field_user_section_access;
  node_save($node);
}

/**
 * Helper function to create training records.
 */
function sample_training_record($dtitle_nid, $usermail, $trainer_id = '') {
  $field_nid = db_result(db_query("select nid,title from {node} where type='person' and title='%s'", $usermail));
  if ($trainer_id == '') {
    $trainer_id = $field_nid;
  }
  //$field_device_type = db_result(db_query("select nid from node where title = '%s' and type='devicetype'",$dtitle));
  $field_device_type = $dtitle_nid;
  $date = db_result(db_query("select now() as date"));
  $node = new stdClass();
  $node->type = 'person_training_record';
  $node->uid = 1;
  $node->sampledata = 1;
  $node->status = 1;
  $node->format = 0;
  $node->title = 'Training Record';
  $node->field_device_type[0]['nid'] = $field_device_type;
  $node->field_active_flag[0]['value'] = '0'; //Certified
  $node->field_trainer_id[0]['nid'] = $trainer_id;
  $node->field_trainee_id[0]['nid'] = $field_nid;
  $node->field_training_completion_date[0]['value'] = $date;
  node_save($node);
  return true;
}
