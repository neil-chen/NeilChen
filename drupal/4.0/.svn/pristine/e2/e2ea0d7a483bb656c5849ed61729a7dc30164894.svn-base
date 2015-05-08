<?php

/**
 * Forgot Password functions
 */
function forgot_password_form() {
  $output = '';
  drupal_add_js('misc/autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/covidien_users.js');
  $output = drupal_get_form('forgot_passwordfrm');
  return $output;
}

function forgot_passwordfrm() {
  $form = array();
  $form['email'] = array(
    '#type' => 'textfield',
    '#id' => 'email',
    '#default_value' => 'Username (email address)',
    '#attributes' => array(
//  			'onblur' => 'covidien_user_mail_acl("email", "user_ajax/mail/autocomplete");',
//  			'onkeyup' => 'covidien_user_mail_acl("email", "user_ajax/mail/autocomplete");',
//  			'onfocus' => 'covidien_user_mail_acl("security_text", "user_ajax/mail/autocomplete");',
      'style' => 'width:330px; font-size:12px',
    ),
  );
  $form['security_text'] = array(
    '#type' => 'textfield',
    '#id' => 'security_text',
    '#attributes' => array(
      'onblur' => 'covidien_user_mail_acl("security_text", "user_ajax/captcha/autocomplete");',
      'onkeyup' => 'covidien_user_mail_acl("security_text", "user_ajax/captcha/autocomplete");',
      'onfocus' => 'covidien_user_mail_acl("email", "user_ajax/mail/autocomplete");',
      'style' => 'width:75px',
    ),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
    '#attributes' => array('style' => 'float:none; margin-left:20px', 'class' => 'non_active_grey', 'disabled' => 'disabled'),
  );
  return $form;
}

function forgot_passwordfrm_validate(&$form, &$form_state) {
  $filter = $form_state['values'];
  if (!valid_email_address($filter['email'])) {
    form_set_error('email', t("Enter Username correctly"));
  } else {
    $result = checkuserstatus($filter['email']);
    if (empty($result)) {
      form_set_error('email', t("Enter Username correctly"));
    } elseif ($result['active'] == 1) {
      form_set_error('email', t('The username %name has not been activated or is blocked.', array('%name' => $form_state['values']['email'])));
    } elseif ($result['status'] == 0) {
      form_set_error('email', t("Your account is now LOCKED OUT. Please contact Help Desk for assistance."));
    }
  }
  if (empty($filter['security_text']) || md5($filter['security_text']) != $_SESSION['security_code']) {
    form_set_error('security_text', t("Enter the Securiy Code correctly"));
  }
}

function forgot_passwordfrm_submit(&$form, &$form_state) {
  $values = $form_state['values'];
  $email = $values['email'];
  $userdet = getuserdetail($email);
  $link = updateforgotstatus($email);
  global $language;
  $info['message_id'] = 'forgot_password';
  $info['name'] = $userdet->name;
  $info['ipaddress'] = $_SERVER['REMOTE_ADDR'];
  $info['link'] = $link;
  $info['to'] = $email;
  $info['uid'] = $userdet->uid;
  $info['language'] = $language;
  logUserActivity("Forgot Password", "Forgot password request from user - " . $email, '', '', '', $userdet->uid, ip_address(), time());
  $mail = new Mail();
  $status = $mail->forgotpasswordrequest($info);
  //GATEWAY-2572 add message when forget password
  drupal_set_message(t('A password reset email has been sent.'));
  drupal_goto();
}

function reset_password_form($v = '') {
  global $user;
  $output = '';
  $id = usrdetailpasshash($v);
  if (empty($id)) {
    drupal_goto('covidien/access-denied');
  }
  $user->uid = 0;
  $output = drupal_get_form('reset_passwordfrm', $id);
  return $output;
}

function reset_passwordfrm($form_state, $id) {
  $form = array();
  $form['new_password'] = array(
    '#type' => 'password',
    '#id' => 'newpass',
    '#attributes' => array('style' => 'width:330px'),
  );
  $form['confirm_password'] = array(
    '#type' => 'password',
    '#id' => 'confirmpass',
    '#attributes' => array('style' => 'width:330px'),
  );
  $form['user_uid'] = array(
    '#type' => 'hidden',
    '#id' => 'user_uid',
    '#default_value' => $id->uid,
  );
  $form['node_id'] = array(
    '#type' => 'hidden',
    '#id' => 'node_id',
    '#default_value' => $id->nid,
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
    '#attributes' => array('style' => 'float:none; margin-left:20px'),
  );
  return $form;
}

function reset_passwordfrm_validate(&$form, &$form_state) {
  $filter = $form_state['values'];
  if (empty($filter['new_password']) || !valid_pass($filter['new_password'])) {
    form_set_error('new_password', t("Invalid New Password - ") . t("Must contain at least 8 characters, 1 - Special chars, 1 - Uppercase, 1 - Lowercase, 1 - Number"));
  } elseif ($filter['new_password'] != $filter['confirm_password']) {
    form_set_error('confirm_password', t("Confirm Password not correct"));
  }
}

function reset_passwordfrm_submit(&$form, &$form_state) {
  $values = $form_state['values'];
  $new = $values['new_password'];
  $user_uid = $values['user_uid'];
  $node_id = $values['node_id'];
  resetforgetstatus($node_id);
  updateUserPasswordQuery(md5($new), $user_uid);
  global $drupal_password_expiration_day;
  $date = time() + ($drupal_password_expiration_day * (24 * 3600));
  $dateSQL = format_date($date, 'custom', 'Y-m-d H:i:s', 0);
  updateUserPasswordExpQuery($dateSQL, $node_id);
  $account = user_load(array('uid' => $user_uid));

  global $language;
  $info['message_id'] = 'reset_password';
  $userdet = getuserdetail($account->name);
  $info['name'] = $userdet->name;
  $info['uid'] = $userdet->uid;
  $info['password'] = $new;
  $info['to'] = $account->mail;
  $info['language'] = $language;
  logUserActivity("Reset Password", "Password reset for user - " . $account->mail, '', '', '', $userdet->uid, ip_address(), time());
  $mail = new Mail();
  $status = $mail->changepasswordcofirmation($info);
  //set message 'status' 'warning' 'error' 
  drupal_set_message(t('Your password reset successful!'), 'error');
  drupal_goto();
}

function template_preprocess_forgot_passwordfrm(&$vars) {
  $vars['messages'] = theme('status_messages');
  $vars['email'] = drupal_render($vars['form']['email']);
  $vars['security_text'] = drupal_render($vars['form']['security_text']);
  $vars['submit'] = drupal_render($vars['form']['submit']);
  $vars['form_extras'] = drupal_render($vars['form']);
}

function template_preprocess_reset_passwordfrm(&$vars) {
  $vars['messages'] = theme('status_messages');
  $vars['newpass'] = drupal_render($vars['form']['new_password']);
  $vars['confirmpass'] = drupal_render($vars['form']['confirm_password']);
  $vars['submit'] = drupal_render($vars['form']['submit']);
  $vars['form_extras'] = drupal_render($vars['form']);
}
