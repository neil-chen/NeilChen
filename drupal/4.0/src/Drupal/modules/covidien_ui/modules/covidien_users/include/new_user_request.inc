<?php

/**
 * New user Request functions
 */
function getcaptcha() {
  header('Cache-control: private'); // IE 6 FIX
  // always modified 
  header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
  // HTTP/1.1 
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', false);
  // HTTP/1.0 
  header('Pragma: no-cache');
  module_load_include('php', 'covidien_users', 'include/class.captcha');
  $theme = drupal_get_path('theme', 'covidien_theme');
  $module = drupal_get_path('module', 'covidien_users');
  global $base_url;
  $captcha = new Captcha();

  $captcha->chars_number = 8;
  $captcha->font_size = 14;
  $captcha->tt_font = drupal_get_path('module', 'covidien_users') . '/include/verdana.ttf';

  $captcha->show_image(132, 30);
}

function new_user_requests_list() {
  global $base_url;
  global $user;

  $number_results = 10;
  $denied = check_plain($_POST['check_show_denied']);
  // define a list of columns to select
  $header = array(
    'Name' => t('Name'),
    'Email' => t('Email'),
    'Role' => t('Role'),
    'Covidien Employee' => t('Covidien Employee'),
    'Business Unit/Customer Name' => t('Business or Customer Name'),
    'Customer Account Number' => t('Customer Account Number'),
    'Status' => t('Status'),
    'Action' => t('Action')
  );
  $rows = array();
  $where = ' where request_status = 0';
  if (!empty($denied)) {
    $where = '';
  }
  $sql = "SELECT id, xml, request_status from {new_user_request} $where";
  $sql_count = "SELECT count(*) from {new_user_request}";
  $result = pager_query($sql, $number_results, 0, $sql_count, implode(', ', array_keys($header)));
  $recordstaus = FALSE;
  while ($record = db_fetch_object($result)) {
    $recordstaus = TRUE;
    $row = array();
    $xml = simplexml_load_string($record->xml);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
    $row[0] = $array['request']['user']['first'] . ' ' . $array['request']['user']['last'];
    $row[1] = $array['request']['user']['login'];
    $row[2] = '';
    $row[3] = $array['request']['user']['iscovidienemp'];
    if ($array['request']['user']['iscovidienemp'] == 'no') {
      $row[4] = $array['request']['user']['customer'];
    } else {
      $row[4] = $array['request']['user']['business_unit'];
    }
    $row[5] = $array['request']['user']['customeraccount'];
    $row[6] = $record->request_status;
    $row[7] = l('manage', 'covidien/admin/users/new_user_request_info/' . $record->id, array('attributes' => array('class' => 'iframe2 cboxElement')));
    $rows[] = $row;
  }
  if (!$recordstaus) {
    $rows[] = array(array('data' => t('No Records Found.'), 'colspan' => '8'));
  }
  $user_list .= theme('table', $header, $rows, array('id' => 'user_requests_list'));
  $user_list .= theme('pager', NULL, $number_results, 0);
  $filter = drupal_get_form('new_requests_filter_form');
  $output .= theme('tpl_new_user_requests_list', $user_list, $filter);
  return $output;
}

function new_requests_filter_form(&$form_state) {
  $form['check_show_denied'] = array(
    '#type' => 'checkboxes',
    '#options' => array(
      'status' => '&nbsp; Include Denied Requests',
    ),
    '#attributes' => array('onclick' => '$("#new-requests-filter-form").submit();'),
  );
  return $form;
}

function new_user_requests_details($id = '') {
  $output = theme('new_user_request_info', $id);
  return $output;
}

function registerfrm() {
  $output = '';
  $output = drupal_get_form('registerfrm_form');
  return $output;
}

function registerfrm_form() {
  $form = array();
  $form['firstname'] = array(
    '#type' => 'textfield',
    '#id' => 'firstname',
  );
  $form['lastname'] = array(
    '#type' => 'textfield',
    '#id' => 'lastname',
  );
  $form['email'] = array(
    '#type' => 'textfield',
    '#id' => 'email',
  );
  $form['country'] = array(
    '#type' => 'select',
    '#id' => 'country',
    '#options' => getnodearray('country')
  );
  $form['language'] = array(
    '#type' => 'select',
    '#id' => 'language',
    '#options' => getnodearray('language')
  );
  $form['business_unit'] = array(
    '#type' => 'select',
    '#id' => 'business_unit',
    '#options' => getbusinessunitarray()
  );
  $form['company_name'] = array(
    '#type' => 'textfield',
    '#id' => 'company_name',
  );
  $form['company_account'] = array(
    '#type' => 'textfield',
    '#id' => 'company_account',
  );
  $form['security_text'] = array(
    '#type' => 'textfield',
    '#id' => 'security_text',
    '#attributes' => array('style' => 'width:75px'),
  );
  $form['notes'] = array(
    '#type' => 'textarea',
    '#id' => 'notes',
  );
  $form['covidien_emp'] = array(
    '#type' => 'select',
    '#id' => 'covidien_emp',
    '#default_value' => '',
    '#options' => array('yes' => 'Yes', 'no' => 'No')
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
    '#attributes' => array('style' => 'float:none; margin-left:20px'),
  );
//  $form['#validate'] = array('registerfrm_form_validate');
  return $form;
}

function registerfrm_form_validate(&$form, &$form_state) {
  $filter = $form_state['values'];
  if (empty($filter['firstname'])) {
    form_set_error('firstname', t("Invalid Firstname"));
  }
  if (empty($filter['lastname'])) {
    form_set_error('lastname', t("Invalid Lastname"));
  }
  if (empty($filter['email']) || !validateEmail($filter['email'])) {
    form_set_error('email', t("Invalid Email"));
  }
  if (empty($filter['covidien_emp'])) {
    form_set_error('covidien_emp', t("Invalid Covidien Employee"));
  }
  if ($filter['covidien_emp'] == 'no') {
    if (empty($filter['company_name'])) {
      form_set_error('company_name', t("Invalid Customer Name"));
    }
    if (empty($filter['company_account'])) {
      form_set_error('company_account', t("Invalid Customer Account Number"));
    }
  }
  if (empty($filter['country'])) {
    form_set_error('country', t("Invalid Country"));
  }
  if (empty($filter['language'])) {
    form_set_error('language', t("Invalid Language"));
  }

  if (empty($filter['security_text']) || md5($filter['security_text']) != $_SESSION['security_code']) {
    form_set_error('security_text', t("Invalid Security Text"));
  }
}

function registerfrm_form_submit(&$form, &$form_state) {
  $values = $form_state['values'];
  $xml = "<?xml version='1.0' encoding='utf-8'?>
          <message schema_version='3644767c-2632-411a-9416-44f8a7dee08e' session_guid='8a0c3837-0f4c-44ab-944f-154529be78f6'>
          <request type='enrolluser' xaction_guid='6ca7eec2-e6e2-40ab-97fa-2f293c8a140b'>
					<params/>
					<user>
							<first>" . $values['firstname'] . "</first>
							<last>" . $values['lastname'] . "</last>
							<login>" . $values['email'] . "</login>
							<password></password>
							<iscovidienemp>" . $values['covidien_emp'] . "</iscovidienemp>
							<business_unit>" . $values['business_unit'] . "</business_unit>
							<customer>" . $values['company_name'] . "</customer>
							<customeraccount>" . $values['company_account'] . "</customeraccount>
							<country>" . $values['country'] . "</country>
							<language>" . $values['language'] . "</language>
							<note>" . $values['notes'] . "</note>
							<cots>
								<cot>
									<name>Vessel Sealing</name>
									<role>Biomed</role>
									<devices>
										<device>
											<name>Emerald</name>
											<latestOnly>true</latestOnly>
										</device>
										<device>
											<name>ForceTriad</name>
											<latestOnly>true</latestOnly>
										</device>
									</devices>
								</cot>
								<cot>
									<name>Compression</name>
									<role>Biomed</role>
									<devices>
										<device>
											<name>Emerald</name>
											<latestOnly>true</latestOnly>
										</device>
									</devices>
								</cot>
							</cots>
					</user>	
					</request>
					</message>";
  insertnewuserrequest($xml, $values['email']);
}

function deny_user() {
  $id = check_plain($_POST['value']);
  global $user;
  $drupal_time = format_date(time(), 'custom', 'Y-m-d H:i:s', 0);
  if (!empty($id)) {
    db_query("update {new_user_request} set request_status = 1, status_changed_by = '%s', status_change_date = '%s' where id = '%s'", $user->uid, $drupal_time, $id);
    echo 1;
  } else {
    echo 0;
  }
}

function template_preprocess_registerfrm_form(&$vars) {
  $vars['firstname'] = drupal_render($vars['form']['firstname']);
  $vars['lastname'] = drupal_render($vars['form']['lastname']);
  $vars['email'] = drupal_render($vars['form']['email']);
  $vars['covidien_emp'] = drupal_render($vars['form']['covidien_emp']);
  $vars['country'] = drupal_render($vars['form']['country']);
  $vars['language'] = drupal_render($vars['form']['language']);
  $vars['business_unit'] = drupal_render($vars['form']['business_unit']);
  $vars['company_name'] = drupal_render($vars['form']['company_name']);
  $vars['company_account'] = drupal_render($vars['form']['company_account']);
  $vars['notes'] = drupal_render($vars['form']['notes']);
  $vars['security_text'] = drupal_render($vars['form']['security_text']);
  $vars['submit'] = drupal_render($vars['form']['submit']);
  $vars['form_extras'] = drupal_render($vars['form']);
}

function template_preprocess_tpl_new_user_requests_list(&$vars) {
  drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/newjquery.min.js');
  drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery.colorbox-min.js');
  drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery-ui.min.js');
  drupal_add_css(drupal_get_path('module', 'covidien_users') . '/css/colorbox.css');
}

function template_preprocess_new_user_request_info(&$vars) {
  $id = arg(4);
  if ($id > 0) {
    $dbdata = db_query("SELECT id,xml,request_date FROM {new_user_request} WHERE id='%s'", $id);
    $data = array();
    $row = db_fetch_object($dbdata);
    $xmlstring = $row->xml;
    $reqdate = $row->request_date;
    $id = $row->id;
    if ($xmlstring != '') {
      $xml = simplexml_load_string($xmlstring);
      $json = json_encode($xml);
      $array = json_decode($json, TRUE);
    }
  }
  $vars['firstname'] = $array['request']['user']['first'];
  $vars['last'] = $array['request']['user']['last'];
  $vars['login'] = $array['request']['user']['login'];
  $vars['iscovidienemp'] = $array['request']['user']['iscovidienemp'];
  $vars['bunit'] = $array['request']['user']['bunit'];
  $vars['customer'] = $array['request']['user']['customer'];
  $vars['customeraccount'] = $array['request']['user']['customeraccount'];
  $vars['country'] = $array['request']['user']['country'];
  $vars['language'] = $array['request']['user']['language'];
  $vars['cots'] = $array['request']['user']['cots']['cot'];
  $vars['request_date'] = $reqdate;
  $vars['id'] = $id;
  return $op;
}
