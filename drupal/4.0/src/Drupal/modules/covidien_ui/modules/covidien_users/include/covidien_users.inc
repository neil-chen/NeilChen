<?php

/**
 * This function contains Dropdown values for Users, Device type privileges Form.
 * Called by Ajax function in covidien_users.js file
 */
function privilege_items() {
  global $user;
  $userid = getNodeDetails($user->name, 'person');
  $devices_array = array();
  $roles_array = array();
  $access_array = array();
  $qry_arg = array();
  $where = '';
  $uid = check_plain($_POST['value']);
  $query = getUserbasedDevicesQuery($user->uid, $uid, $userid);
  while ($row = db_fetch_object($query)) {
    $devices_array[$row->nid] = $row->title;
  }

  $query = getAccessSectionsTrainerQuery();

  while ($row = db_fetch_object($query)) {
    $roles_array[$row->nid] = $row->field_section_name_value;
//    $all_options = getAccessOptions($row->nid);
  }
  $return = array();
  $return[] = $devices_array;
  $return[] = $roles_array;
  echo json_encode($return);
  exit;
}

function getAccess_lists() {
  $val = check_plain($_POST['value']);
  $all_options = getAccessOptions($val);
  echo json_encode($all_options);
  exit;
}

function getAllPrivilege_items() {
  global $user;
  $uid = check_plain($_POST['uid']);
  $login_nid = getNodeDetails($user->name, 'person');
  $edit_nid = getUserNidfrmUidQuery($uid);
  $devices_array = array();
  $roles_array = array();
  $access_array = array();
  $selected_devices = array();
  $selected_roles = array();
  $selected_access = array();
  $device_denied = array();
  $login_user_devices = array();
  $qry_arg = array();

  $query = getUserbasedDevicesQuery($user->uid, $uid, $login_nid);

  while ($row = db_fetch_object($query)) {
    $login_user_devices[$row->nid] = $row->title;
  }

  $query = getUserbasedDevicesQuery($edit_nid, $uid, $edit_nid);

  while ($row = db_fetch_object($query)) {
    $devices_array[$row->nid] = $row->title;
    if (!array_key_exists($row->nid, $login_user_devices)) {
      $device_denied[] = $row->nid;
    }
  }

  $query = getAccessSectionsTrainerQuery();

  while ($row = db_fetch_object($query)) {
    $roles_array[$row->nid] = $row->field_section_name_value;
    $access_array[$row->nid] = getAccessOptions($row->nid);
  }

  $query = getUsersSelectedDeviceQuery($edit_nid);

  while ($row = db_fetch_object($query)) {
    $selected_devices[] = $row->field_device_type_nid;
    $selected_roles[$row->field_device_type_nid] = $row->field_app_section_nid;
    $selected_access[$row->field_device_type_nid] = $row->field_user_section_access_nid;
  }

  $return = array();
  $return[] = $login_user_devices;
  $return[] = $roles_array;
  $return[] = $access_array;
  $return[] = $selected_devices;
  $return[] = $selected_roles;
  $return[] = $selected_access;
  $return[] = $device_denied;
  echo json_encode($return);
  exit;
}

function getDisabledPrivilege_items() {
  global $user;
  $uid = check_plain($_POST['uid']);
  $login_nid = getNodeDetails($user->name, 'person');
  $edit_nid = getUserNidfrmUidQuery($uid);

  $devices_array = array();
  $roles_array = array();
  $access_array = array();
  $selected_devices = array();
  $selected_roles = array();
  $selected_access = array();
  $device_denied = array();
  $login_user_devices = array();
  $qry_arg = array();

  $query = getUserbasedDevicesQuery($user->uid, $uid, $login_nid);

  while ($row = db_fetch_object($query)) {
    $login_user_devices[] = $row->nid;
  }

  $query = getUserbasedDevicesQuery($edit_nid, $uid, $edit_nid);

  while ($row = db_fetch_object($query)) {
    $devices_array[$row->nid] = $row->title;
    if (!in_array($row->nid, $login_user_devices)) {
      $device_denied[] = $row->nid;
    }
  }

  $query = getAccessSectionsTrainerQuery();

  while ($row = db_fetch_object($query)) {
    $roles_array[$row->nid] = $row->field_section_name_value;
    $access_array[$row->nid] = getAccessOptions($row->nid);
  }

  $query = getUsersSelectedDeviceQuery($edit_nid);

  while ($row = db_fetch_object($query)) {
    $selected_devices[] = $row->field_device_type_nid;
    $selected_roles[$row->field_device_type_nid] = $row->field_app_section_nid;
    $selected_access[$row->field_device_type_nid] = $row->field_user_section_access_nid;
  }

  $return = array();
  $return[] = $devices_array;
  $return[] = $roles_array;
  $return[] = $access_array;
  $return[] = $selected_devices;
  $return[] = $selected_roles;
  $return[] = $selected_access;
  $return[] = $device_denied;
  echo json_encode($return);
  exit;
}

function getDeniedPL($edit_nid) {
  $device_denied = array();
  global $user;
  $login_nid = getNodeDetails($user->name, 'person');
  $devices_array = array();

  $device_denied = array();
  $login_user_devices = array();
  $qry_arg = array();

  $query = getUserbasedDevicesQuery($user->uid, $uid, $login_nid);

  while ($row = db_fetch_object($query)) {
    $login_user_devices[] = $row->nid;
  }

  $query = getUserbasedDevicesQuery($edit_nid, $uid, $edit_nid);

  while ($row = db_fetch_object($query)) {
    $devices_array[$row->nid] = $row->title;
    if (!in_array($row->nid, $login_user_devices)) {
      $device_denied[] = $row->nid;
    }
  }
  return $device_denied;
}
