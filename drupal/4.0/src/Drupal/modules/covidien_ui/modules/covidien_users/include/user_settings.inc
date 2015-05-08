<?php

/**
 * User Settings functions
 */
function covidien_user_changepassword() {
  $output = '';
  $output = drupal_get_form('user_changepasswordfrm');
  return $output;
}

function user_changepasswordfrm() {
  $form = array();
  $form['old_password'] = array(
    '#type' => 'password',
    '#id' => 'oldpass'
  );
  $form['new_password'] = array(
    '#type' => 'password',
    '#id' => 'newpass',
  );
  $form['new_password'] = array(
    '#type' => 'password',
    '#id' => 'newpass',
  );
  $form['confirm_password'] = array(
    '#type' => 'password',
    '#id' => 'confirmpass',
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save Changes'),
    '#attributes' => array('style' => 'float:none; margin-left:20px'),
  );
  return $form;
}

function user_changepasswordfrm_validate(&$form, &$form_state) {
  global $user;
  $filter = $form_state['values'];
  if (empty($filter['old_password'])) {
    form_set_error('old_password', t("Invalid current password"));
  } else {
    $count = checkUserCountQuery($user->uid, md5($filter['old_password']));
    if (!$count) {
      form_set_error("old_password", t("Enter correct current password"));
    }
    //GATEWAY-1635 change by neil 2014-3-28
    if ($user->pass == md5($filter['new_password'])) {
      form_set_error("new_password", t("New password must not be same as Current password"));
    }
  }
  if (empty($filter['new_password']) || !valid_pass($filter['new_password'])) {
    form_set_error('new_password', t("Invalid new password - ") . t("Must contain at least 8 characters, 1 - Special character, 1 - Uppercase, 1 - Lowercase, 1 - Number"));
  } elseif ($filter['confirm_password'] != $filter['new_password']) {
    form_set_error('confirm_password', t("Confirm new password not correct"));
  }
}

function user_changepasswordfrm_submit(&$form, &$form_state) {
  global $user;
  global $drupal_password_expiration_day;
  $values = $form_state['values'];
  $date = time() + ($drupal_password_expiration_day * (24 * 3600));
  $dateSQL = format_date($date, 'custom', 'Y-m-d H:i:s', 0);
  $new = trim($values['new_password']);
  $nid = getNodeDetails($user->name, 'person');
  updateUserPasswordQuery(md5($new), $user->uid);
  updateUserPasswordExpQuery($dateSQL, $nid);

  drupal_set_message(t("Your settings have been changed"));

  global $language;
  $userdet = getuserdetail($user->name);
  $info['name'] = $userdet->name;
  $info['uid'] = $userdet->uid;
  $info['password'] = $new;
  $info['to'] = $user->mail;
  $info['language'] = $language;
  logUserActivity("Password change", "Password changed for user - " . $info['to'], '', '', '', $info['uid'], ip_address(), time());

  //GATEWAY-1423 changed by neil 2014-1-9
  /*
  if (check_change_password_mail()) {
    $mail = new Mail();
    $status = $mail->changepasswordmail($info);
  }*/
  //GATEWAY-1718 every time send email 2014-12-26 
  $mail = new Mail();
  $status = $mail->changepasswordmail($info);

  drupal_goto('covidien/users/settings/user_profile');
}

function check_change_password_mail() {
  $node = node_load(array('title' => 'Change Password', 'type' => 'device_notification_type')); //get change password node
  if (!$node) {
    return true;
  }
  if (in_array($node->nid, get_user_notification())) {
    return true;
  }
  return false;
}

function covidien_user_notification() {
  $output = '';
  $output = drupal_get_form('user_notificationfrm');
  return $output;
}

/*
 * GATEWAY-1423 changed by neil 2014-1-9
 */

function get_user_notification() {
  global $user;
  $user_notification = array();
  $notify_nid = getNodeDetails($user->name, 'user_settings');
  $node = node_load($notify_nid);
  if ($node->field_email_notifications) {
    foreach ($node->field_email_notifications as $val) {
      $user_notification[$val['nid']] = $val['nid'];
    }
  } else {
    $user_notification = array();
  }
  return $user_notification;
}

function user_notificationfrm() {
  global $user;
  $form = array();
  $user_notification = get_user_notification();
  $form['notification'] = array(
    '#type' => 'checkboxes',
    '#options' => getnotificationlist(),
    '#default_value' => $user_notification, //GATEWAY-1423 changed by neil 2014-1-9
    '#value' => $user_notification,
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save Changes'),
    '#attributes' => array('style' => 'float:none; margin-left:20px'),
  );
  return $form;
}

function user_notificationfrm_submit(&$form, &$form_state) {
  global $user;
  $values = $form_state['values'];
  $nid = getNodeDetails($user->name, 'person');
  //update device_notification_subscription content type with email notification values by deleting the old values and insert
  $sql = "SELECT nid FROM {node} WHERE title='%s' AND type='%s'";
  $result_notify = db_query($sql, $user->name, 'device_notification_subscription');
  $result_email_notify = db_query($sql, $user->name, 'user_settings');
  //delete all device_notification_subscription
  while ($row = db_fetch_object($result_notify)) {
    db_query('DELETE FROM {node} WHERE nid = %d', $row->nid);
    db_query('DELETE FROM {node_revisions} WHERE nid = %d', $row->nid);
    db_query('DELETE FROM {node_access} WHERE nid = %d', $row->nid);
    db_query("DELETE FROM {content_type_device_notification_subscription} WHERE nid = %d", $row->nid);
  }
  //delete all user_settings
  while ($row = db_fetch_object($result_email_notify)) {
    db_query('DELETE FROM {node} WHERE nid = %d', $row->nid);
    db_query('DELETE FROM {node_revisions} WHERE nid = %d', $row->nid);
    db_query('DELETE FROM {node_access} WHERE nid = %d', $row->nid);
    db_query("DELETE FROM {content_type_user_settings} WHERE nid = %d", $row->nid);
  }
  $val1 = new stdClass();
  $val1->title = $user->name;
  $val1->type = "user_settings";
  $val1->uid = $user->uid;
  $val1->format = 0;
  $val2 = new stdClass();
  $val2->title = $user->name;
  $val2->type = "device_notification_subscription";
  $val2->uid = $user->uid;
  $val2->format = 0;
  $val2->field_person[] = array('nid' => $nid);

  foreach ($values['notification'] as $k => $v) {
    if ($v) {
      $val2->field_device_notification_type[]['nid'] = $k;
      $val1->field_email_notifications[]['nid'] = $k;
    }
  }
  node_save($val2);
  node_save($val1);
  drupal_get_messages();
  drupal_set_message(t('Your email notification has been saved'));
}

function covidienuser_profile() {
  $output = theme('covidienuser_profile');
  return $output;
}

function template_preprocess_covidienuser_profile(&$vars) {
  global $user;
  $title = t("User Profile");
  drupal_set_title($title);
  $person = getuserprofiledetails($user->name);
  $vars['firstname'] = $person->firstname;
  $vars['lastname'] = $person->lastname;
  $vars['employee'] = $person->employee;
  $vars['email'] = $user->name;
  $vars['customer'] = $person->customer_title;
  $vars['account_number'] = $person->account_number_value;
  $vars['bunit'] = $person->bunit_title;
  $vars['language'] = $person->language_title;
  $vars['country'] = $person->country_title;
  $cot = array();
  $cot_array = UsersProductlineQuery($person->person_nid);
  foreach ($cot_array as $v) {
    $cot[] = $v;
  }
  $vars['cot'] = $cot;
}

function template_preprocess_user_changepasswordfrm(&$vars) {
  global $user;
  $title = t("User Profile");
  drupal_set_title($title);
  $vars['oldpass'] = drupal_render($vars['form']['old_password']);
  $vars['newpass'] = drupal_render($vars['form']['new_password']);
  $vars['confirmpass'] = drupal_render($vars['form']['confirm_password']);
  $vars['submit'] = drupal_render($vars['form']['submit']);
  $vars['form_extras'] = drupal_render($vars['form']);
}

function template_preprocess_user_notificationfrm(&$vars) {
  global $user;
  $title = t("User Profile");
  drupal_set_title($title);
  $vars['notification'] = drupal_render($vars['form']['notification']);
  $vars['submit'] = drupal_render($vars['form']['submit']);
  $vars['form_extras'] = drupal_render($vars['form']);
}

function getnotificationlist() {
  $option = array();
  $result = getnotificationlistquery();
  while ($row = db_fetch_object($result)) {
    $option[$row->nid] = $row->title;
  }
  return $option;
}
