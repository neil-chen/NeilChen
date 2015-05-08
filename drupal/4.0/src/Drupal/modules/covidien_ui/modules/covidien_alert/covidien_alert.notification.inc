<?php

/**
 * menu callback alert/notification/list
 * @return string
 */
function alert_notification_list() {
  drupal_set_title(t('General Notification list'));
  $output = theme('alert_notification_list');
  return $output;
}

function covidien_theme_preprocess_alert_notification_list(&$vars) {
  $sql = "SELECT tn.id, tn.notification_name, ae.name AS alert_event, tn.display_flag, tn.active_status, tn.from_date, tn.to_date, tn.time_zone
      FROM {technical_notification} tn
      JOIN {alert_event} ae ON ae.id = tn.alert_event_id
      WHERE complete_flag = 'N' ";
  $args = array();
  $header = array(
    array('data' => t('Notification Name'), 'field' => 'tn.notification_name', 'sort' => 'asc'),
    array('data' => t('Alert Event'), 'field' => 'ae.name'),
    array('data' => t('Display on Home Page'), 'field' => 'tn.display_flag'),
    array('data' => t('Status'), 'field' => 'tn.active_status'),
    array('data' => t('Date Range'), 'field' => 'tn.from_date'),
  );
  $sql .= tablesort_sql($header);
  $pageSize = 10;
  $result = pager_query($sql, $pageSize, 0, NULL, $args);

  $has_edit_access = check_user_has_edit_access('alert');
  while ($row = db_fetch_object($result)) {
    if ($has_edit_access) {
      $rows[$row->id]['notification_name'] = l($row->notification_name, 'alert/notification/edit/' . $row->id);
    } else {
      $rows[$row->id]['notification_name'] = $row->notification_name;
    }
    $rows[$row->id]['alert_event'] = $row->alert_event;
    $rows[$row->id]['display_flag'] = $row->display_flag == 'Y' ? 'Yes' : 'No';
    $rows[$row->id]['active_status'] = $row->active_status == 'Y' ? 'Active' : 'No Active';
    $from_date = ($row->from_date && $row->from_date != '0000-00-00 00:00:00') ? format_date(strtotime($row->from_date), 'custom', 'm/d/Y H:i') : '';
    $to_date = ($row->to_date && $row->to_date != '0000-00-00 00:00:00') ? format_date(strtotime($row->to_date), 'custom', 'm/d/Y H:i') : '';
    $time_zone = ($row->time_zone > 0) ? '+' . round($row->time_zone / 36) : round($row->time_zone / 36);
    $rows[$row->id]['data_range'] = ($from_date && $to_date) ? $from_date . ' - ' . $to_date . ' ' . $time_zone : '';
  }
  $table_list = '';
  $table_list .= theme_table($header, $rows);
  $table_list .= theme('pager', NULL, 10, 0);
  $vars['table_list'] = $table_list;
}

/**
 * menu callback alert/notification/add
 * @return type
 */
function alert_notification_add() {
  drupal_set_title(t('Add New General Notification'));
  //alert_notification_form_validate($form_stats);
  $output = drupal_get_form('alert_notification_form');
  return $output;
}

/**
 * menu callback alert/notification/edit/%
 * @return type
 */
function alert_notification_edit() {
  if (isAdmin()) {
    drupal_set_title(t('Edit General Notification'));
  } else {
    drupal_set_title(t('View General Notification'));
  }
  //alert_notification_form_validate($form_stats);
  $output = drupal_get_form('alert_notification_form');
  return $output;
}

/**
 * menu callback alert/notification/history/list
 * @return type
 */
function alert_notification_history_list() {
  drupal_set_title(t('General Notification History List'));
  $output = theme('alert_notification_history_list');
  return $output;
}

/**
 * menu callback alert/notification-history/view/%
 * @return type
 */
function alert_notification_history_view() {
  drupal_set_title(t('View General Notification History'));
  //alert_notification_form_validate($form_stats);
  $output = drupal_get_form('alert_notification_form');
  return $output;
}

/**
 * Implements hook_form()
 * @return array
 */
function alert_notification_form() {
  $form = array();
  $id = arg(3);
  $alert_notification = array();
  if ($id) {
    $alert_notification = get_alert_notification($id);
  }
  $temp_form = alert_template_form();
  $form['sel_alert_event'] = $temp_form['sel_alert_event'];
  $tech_category_id = db_result(db_query("SELECT id FROM {alert_category} WHERE name='%s'", 'General Notification'));
  $alert_event_option = _get_alert_event_list($tech_category_id, 'only');
  $form['sel_alert_event'] = array(
    '#type' => 'select',
    '#id' => 'sel_alert_event',
    '#name' => 'sel_alert_event',
    '#options' => $alert_event_option,
    '#default_value' => $alert_notification['alert_event_id'],
    '#value' => $alert_notification['alert_event_id'],
  );
  if ($alert_notification['alert_event_id']) {
    $form['sel_alert_event']['#attributes'] = array('disabled' => 'disabled');
  }
  $form['notification_id'] = array(
    '#type' => 'hidden',
    '#value' => $alert_notification['id'],
  );
  $form['notification_name'] = array(
    '#type' => 'textfield',
    '#id' => 'notification_name',
    '#name' => 'notification_name',
    '#default_value' => $alert_notification['notification_name'],
    '#value' => $alert_notification['notification_name'],
  );
  $form['display_on_home'] = array(
    '#type' => 'radios',
    '#id' => 'display_on_home',
    '#name' => 'display_on_home',
    '#options' => array('Y' => 'Yes', 'N' => 'No'),
    '#default_value' => $alert_notification['display_flag'],
    '#value' => $alert_notification['display_flag'],
  );
  $zones = _system_zonelist(); // _time_zonelist(); //
  $form['sel_time_zone'] = array(
    '#type' => 'select',
    '#id' => 'time_zone',
    '#name' => 'time_zone',
    '#options' => $zones,
    '#default_value' => $alert_notification['time_zone'],
    '#value' => $alert_notification['time_zone'],
  );
  //GATEWAY-2807 update min date to yesterday 
  $yesterday = 'new Date((new Date()).valueOf() - 1000*60*60*24)';
  $form['from_date'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#maxlength' => 10,
    '#date_format' => variable_get('date_format_short', 'm/d/Y - H:i'),
    '#date_year_range' => '-0:+2',
    '#min_date' => $yesterday,
    '#default_value' => $alert_notification['from_date'],
    '#value' => $alert_notification['from_date'],
  );
  $form['to_date'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#date_format' => variable_get('date_format_short', 'm/d/Y - H:i'),
    '#maxlength' => 10,
    '#date_year_range' => '-0:+2',
    '#min_date' => $yesterday,
    '#default_value' => $alert_notification['to_date'],
    '#value' => $alert_notification['to_date'],
  );
  $form['active_status'] = array(
    '#type' => 'radios',
    '#id' => 'active_status',
    '#name' => 'active_status',
    '#options' => array('Y' => 'Yes', 'N' => 'No'),
    '#default_value' => $alert_notification['active_status'],
    '#value' => $alert_notification['active_status'],
  );
  $delivery_option = _get_alert_delivery_list();
  $delivery_value = get_notification_delivery($id);
  $form['delivery'] = array(
    '#type' => 'checkboxes',
    '#id' => 'delivery',
    '#name' => 'delivery',
    '#options' => $delivery_option,
    '#default_value' => $delivery_value,
    '#value' => $delivery_value,
  );
  $form['message'] = array(
    '#type' => 'textarea',
    '#id' => 'message',
    '#name' => 'message',
    '#default_value' => $alert_notification['message_text'],
    '#value' => $alert_notification['message_text'],
  );
  $form['summary_notes'] = array(
    '#type' => 'textarea',
    '#id' => 'summary_notes',
    '#name' => 'summary_notes',
    '#default_value' => $alert_notification['summary'],
    '#value' => $alert_notification['summary'],
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save Notification'),
    '#id' => 'btn-submit',
    '#attributes' => array('disabled' => 'disabled', 'class' => 'non_active_blue'),
  );
  return $form;
}

function alert_notification_form_validate() {
  if (!isAdmin()) {
    form_set_error('notification_name', t('Only admin user can edit notification'));
  }
  if ($_POST['markCompleted'] == 'Save Notification History') {
    return true;
  }
  if (!covidien_ui_input_validate($_POST['notification_name'], true)) {
    form_set_error('notification_name', t('Invalid Notification Name'));
  }
  if (!covidien_ui_input_validate($_POST['display_on_home'], true)) {
    form_set_error('display_on_home', t('Invalid  Display on Home Page'));
  }
  if ($_POST['display_on_home'] == 'Y') {
    if (empty($_POST['from_date']['date'])) {
      form_set_error('from_date', t('Invalid From Date'));
    }
    if (empty($_POST['to_date']['date'])) {
      form_set_error('to_date', t('Invalid To Date'));
    }
  }
  if (!covidien_ui_input_validate($_POST['active_status'], true)) {
    form_set_error('active_status', t('Invalid Active Status'));
  }
  if (!covidien_ui_input_validate($_POST['message'], true)) {
    form_set_error('message', t('Invalid Message'));
  }
  if (!covidien_ui_input_validate($_POST['summary_notes'], true)) {
    form_set_error('summary_notes', t('Invalid Summary/Notes'));
  }
}

function alert_notification_save_form() {
  alert_notification_form_validate();
  if (count(form_get_errors())) {
    drupal_goto(referer_uri());
  }
  alert_notification_save();
  $url = 'alert/notification/list';
  if ($_POST['markCompleted'] == 'Save Notification History') {
    $url = 'alert/notification-history/list';
  }
  drupal_goto($url);
}

/**
 * menu callback alert/notification/ajax/save
 */
function alert_notification_ajax_save() {
  alert_notification_form_validate();
  if (count(form_get_errors())) {
    drupal_json(array('status' => 'faild', 'notification_id' => 'Invalid'));
    exit();
  }
  $id = alert_notification_save();
  drupal_json(array('status' => 'success', 'notification_id' => $id));
  exit();
}

function alert_notification_save() {
  $post = filter_xss_arr($_POST);
  //save history
  if ($post['notification_id'] && $post['markCompleted'] == 'Save Notification History') {
    db_query("UPDATE {technical_notification} SET display_flag='%s' WHERE id=%d", $post['display_on_home'], $post['notification_id']);
    return $post['notification_id'];
  }
  $from_date = $post['from_date']['date'] ? format_date((strtotime($post['from_date']['date'])), 'custom', 'Y-m-d ') . $post['from_date']['time'] : '';
  $to_date = $post['to_date']['date'] ? format_date((strtotime($post['to_date']['date'])), 'custom', 'Y-m-d ') . $post['to_date']['time'] : '';
  $id = $post['notification_id'];
  $notification['notification_name'] = trim($post['notification_name']);
  $notification['from_date'] = $from_date;
  $notification['to_date'] = $to_date;
  $notification['active_status'] = $post['active_status'];
  $notification['transport_type_id'] = current($post['delivery']);
  $notification['message_text'] = trim($post['message']);
  $notification['summary'] = trim($post['summary_notes']);
  if (!$id) {
    $notification['sel_alert_event'] = $post['sel_alert_event'];
  }
  $notification['display_flag'] = $post['display_on_home'];
  $notification['time_zone'] = $post['time_zone'];

  if ($id) {
    //save notification
    if ($post['markCompleted'] == 'markCompleted') {
      db_query("UPDATE {technical_notification} SET complete_flag='%s', display_flag='%s' WHERE id=%d", 'Y', 'N', $id);
      $message = "General notification <em>" . $notification['notification_name'] . '</em> has been marked as completed.';
    } else {
      //update
      $sql = "UPDATE {technical_notification} SET notification_name='%s', from_date='%s', to_date='%s', active_status='%s', transport_type_id=%d,
      message_text='%s', summary='%s', display_flag='%s', time_zone='%s' WHERE id=%d";
      db_query($sql, array_merge($notification, array($id)));
      $message = "General notification <em>" . $notification['notification_name'] . '</em> has been updated.';
    }
  } else {
    //add new
    $sql = "INSERT INTO {technical_notification} 
      (notification_name, from_date, to_date, active_status, transport_type_id, message_text, summary, alert_event_id, display_flag, time_zone, create_time) 
      VALUES ('%s', '%s', '%s', '%s', %d, '%s', '%s', %d, '%s', '%s',now())";
    db_query($sql, $notification);
    $id = db_last_insert_id('technical_notification', 'id');
    $message = "General notification <em>" . $notification['notification_name'] . '</em> has been created.';
  }
  drupal_set_message($message);
  return $id;
}

function covidien_theme_preprocess_alert_notification_form(&$vars) {
  $id = arg(3);
  $schedule_rows = get_technical_notification_schedule($id);
  $header = array('', 'Schedule Date', 'Recipients', 'Subject Line', 'Status', 'On Completion');
  $vars['schedule_list'] = theme_table($header, $schedule_rows);
  $vars['schedule_form'] = drupal_get_form('technical_notification_schedule_form');
  $vars['notification_id'] = $id;
}

function _time_zonelist() {
  $zones_array = array();
  $timestamp = time();
  foreach (timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
    $time_zone = $zone . ' UTC/GMT ' . date('P ', $timestamp);
    $zones_array[$time_zone] = $time_zone;
  }
  return $zones_array;
}

function get_technical_notification_schedule_query() {
  $sql = "SELECT tns.id, tns.schedule_date, tns.internal_only_flag, tns.subject_line, 
    tns.active_status, tns.on_completion_flag, tns.device_type_nid
    FROM {technical_notification_schedule} tns";
  return $sql;
}

function get_technical_notification_schedule($id = 0) {
  $sql = "SELECT tns.id, tns.schedule_date, tns.internal_only_flag, tns.subject_line, 
    tns.active_status, tns.on_completion_flag, node.nid, node.title, ae.name as event_name
    FROM {technical_notification_schedule} tns 
    join technical_notification tn on tns.technical_notification_id = %d and tns.technical_notification_id = tn.id
    join alert_event ae on tn.alert_event_id = ae.id 
    left join node on tns.device_type_nid = node.nid order by tns.schedule_date";
  $result = db_query($sql, $id);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->id]['id'] = '<input id="schedule_id_' . $row->id . '" name="schedule_id" type="radio" value="' . $row->id . '"/>';
    $rows[$row->id]['schedule_date'] = $row->schedule_date ? format_date(strtotime($row->schedule_date), 'custom', 'm/d/Y H:i A') : '';
    if ($row->event_name == "System Upgrade Notice") {
      $rows[$row->id]['recipients'] = $row->internal_only_flag == 'Y' ? 'Covidien Only' : 'All Users';
    } else {
      $rows[$row->id]['recipients'] = 'COT Group Of ' . $row->title;
    }
    $rows[$row->id]['subject_line'] = $row->subject_line;
    $rows[$row->id]['active_status'] = $row->active_status == 'Y' ? 'Yes' : 'No';
    $rows[$row->id]['on_completion_flag'] = $row->on_completion_flag == 'Y' ? 'Yes' : 'No';
  }
  return $rows;
}

function technical_notification_schedule_save() {
  $post = filter_xss_arr($_POST);
  $schedule['notification_id'] = $post['notification_id'];
  $schedule['active_status'] = $post['active_status'];
  $schedule['on_completion'] = 'N';
  $schedule['covidien_only'] = $post['covidien_only'];
  $schedule['field_device_type_nid'] = $post['field_device_type_nid'];
  $schedule['subject_line'] = $post['subject_line'];
  $schedule['schedule_date'] = $post['schedule_date'] ? format_date(strtotime($post['schedule_date']), 'custom', 'Y-m-d ') . $post['schedule_time'] : '';
  $schedule_id = $post['schedule_id'];
  $alert_event = $post['schedule_alert_event'];
  if ($alert_event == 'General Notice to Users Associated With COT/Device') {
    $schedule['covidien_only'] = null;
  } else {
    $schedule['field_device_type_nid'] = null;
  }
  if ($schedule_id) {
    $schedule['schedule_id'] = $schedule_id;
    //update technical_notification_schedule
    $sql = "UPDATE {technical_notification_schedule} SET
      technical_notification_id = %d,
      active_status = '%s',
      on_completion_flag = '%s',
      internal_only_flag = '%s', 
      device_type_nid = %d,
      subject_line = '%s',
      schedule_date = '%s'
      WHERE id = %d
      ";
    db_query($sql, $schedule);
  } else {
    //add new technical_notification_schedule
    $sql = "INSERT INTO {technical_notification_schedule} 
    (technical_notification_id, active_status, on_completion_flag, internal_only_flag, device_type_nid, subject_line, schedule_date)
    VALUES (%d, '%s', '%s', '%s', %d,'%s','%s')";
    db_query($sql, $schedule);
  }
  //set on completion flag Y on the max date item.
  db_query("update technical_notification_schedule set on_completion_flag = 'N' where technical_notification_id = %d", $schedule['notification_id']);
  $max_date = db_result(db_query("select max(schedule_date) from technical_notification_schedule where active_status = 'Y' and technical_notification_id = %d", $schedule['notification_id']));
  db_query("update technical_notification_schedule set on_completion_flag = 'Y' where active_status = 'Y' and technical_notification_id = %d and schedule_date = '%s'", $schedule['notification_id'], $max_date);
  //update table list
  $schedule_rows = get_technical_notification_schedule($schedule['notification_id']);
  $header = array('', 'Schedule Date', 'Recipients', 'Subject Line', 'Status', 'On Completion');
  $schedule_list = theme_table($header, $schedule_rows);
  drupal_json(array('status' => 'success', 'data' => $schedule_list));
}

function technical_notification_schedule_delete() {
  $schedule_id = arg(5);
  $notification_id = arg(3);
  db_query("DELETE FROM {technical_notification_schedule} WHERE id=%d", $schedule_id);
  //update table list
  $schedule_rows = get_technical_notification_schedule($notification_id);
  $header = array('', 'Schedule Date', 'Recipients', 'Subject Line', 'Status', 'On Completion');
  $schedule_list = theme_table($header, $schedule_rows);
  drupal_json(array('status' => 'success', 'data' => $schedule_list));
}

function technical_notification_schedule_form() {
  $form = array();
  $id = arg(5);
  $schedule = array();
  if ($id) {
    $sql = get_technical_notification_schedule_query();
    $sql .= " WHERE tns.id = %d ";
    $schedule = db_fetch_array(db_query($sql, $id));
  }
  $form['schedule_id'] = array(
    '#type' => 'hidden',
    '#value' => $id,
  );
  //GATEWAY-2807 update min date to yesterday 
  $yesterday = 'new Date((new Date()).valueOf() - 1000*60*60*24)';
  $form['schedule_date'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#date_format' => variable_get('date_format_short', 'm/d/Y - H:i'),
    '#maxlength' => 10,
    '#date_year_range' => '-0:+2',
    '#min_date' => $yesterday,
    '#default_value' => $schedule['schedule_date'],
    '#value' => $schedule['schedule_date'],
  );
  $form['schedule_covidien_only'] = array(
    '#type' => 'radios',
    '#id' => 'schedule_covidien_only',
    '#options' => array('Y' => 'Covidien Only', 'N' => 'All Users'),
    '#default_value' => $schedule['internal_only_flag'],
    '#value' => $schedule['internal_only_flag'],
  );
  $form['schedule_active_status'] = array(
    '#type' => 'radios',
    '#id' => 'schedule_active_status',
    '#options' => array('Y' => 'Yes', 'N' => 'No'),
    '#default_value' => $schedule['active_status'],
    '#value' => $schedule['active_status'],
  );
  $form['schedule_on_completion'] = array(
    '#type' => 'radios',
    '#id' => 'schedule_on_completion',
    '#options' => array('Y' => 'Yes', 'N' => 'No'),
    '#default_value' => $schedule['on_completion_flag'],
    '#value' => $schedule['on_completion_flag'],
  );
  $form['select_device_type'] = field_device_type_select($schedule['device_type_nid'], 'All');
  unset($form['select_device_type']['select_device_type']['#options'][0]);
  $form['subject_line'] = array(
    '#type' => 'textfield',
    '#id' => 'subject_line',
    '#name' => 'subject_line',
    '#default_value' => $schedule['subject_line'],
    '#value' => $schedule['subject_line'],
  );
  return $form;
}

function get_alert_notification($id = 0) {
  $sql = "SELECT * FROM {technical_notification} tn WHERE id=%d";
  $rows = db_fetch_array(db_query($sql, $id));
  return $rows;
}

function covidien_theme_preprocess_alert_notification_history_list(&$vars) {
  $sql = "SELECT tn.id, tn.notification_name, ae.name AS alert_event, tn.from_date, tn.to_date, tn.time_zone, tn.message_text
      FROM {technical_notification} tn
      JOIN {alert_event} ae ON ae.id = tn.alert_event_id 
      WHERE tn.complete_flag = 'Y' ";
  $args = array();
  $from_date = $_GET['from_date']['date'] ? format_date((strtotime($_GET['from_date']['date'])), 'custom', 'Y-m-d ') . $_GET['from_date']['time'] : '';
  $to_date = $_GET['to_date']['date'] ? format_date((strtotime($_GET['to_date']['date'])), 'custom', 'Y-m-d ') . $_GET['to_date']['time'] : '';
  $form_datetime = format_date(strtotime($from_date), 'custom', 'Y-m-d H:i:s');
  $to_datetime = format_date(strtotime($to_date), 'custom', 'Y-m-d H:i:s');
  if ($from_date && $to_date) {
    $sql .= " AND tn.create_time between '%s' AND '%s' ";
    $args[] = $form_datetime;
    $args[] = $to_datetime;
  } else if ($from_date) {
    $sql .= " AND tn.create_time >= '%s' ";
    $args[] = $form_datetime;
  } else if ($to_date) {
    $sql .= " AND tn.to_date <= '%s' ";
    $args[] = $to_datetime;
  }
  $header = array(
    array('data' => t('Notification Name'), 'field' => 'tn.notification_name', 'sort' => 'asc'),
    array('data' => t('Alert Event'), 'field' => 'ae.name', 'sort' => 'asc'),
    array('data' => t('From'), 'field' => 'tn.from_date', 'sort' => 'asc'),
    array('data' => t('To'), 'field' => 'tn.to_date', 'sort' => 'desc'),
    array('data' => t('Message'), 'field' => 'tn.message_text', 'sort' => 'asc'),
  );
  $sql .= tablesort_sql($header);
  $pageSize = 10;
  $result = pager_query($sql, $pageSize, 0, NULL, $args);

  //check edit access 
  $has_edit_access = check_user_has_edit_access('alert');

  while ($row = db_fetch_object($result)) {
    if ($has_edit_access) {
      $rows[$row->id]['notification_name'] = l($row->notification_name, 'alert/notification-history/view/' . $row->id);
    } else {
      $rows[$row->id]['notification_name'] = $row->notification_name;
    }
    $rows[$row->id]['alert_event'] = $row->alert_event;
    $from_date = $row->from_date ? format_date(strtotime($row->from_date), 'custom', 'm/d/Y H:i A') : '';
    $to_date = $row->from_date ? format_date(strtotime($row->to_date), 'custom', 'm/d/Y H:i A') : '';
    $rows[$row->id]['from_date'] = $from_date . ' ' . $row->time_zone;
    $rows[$row->id]['to_date'] = $to_date . ' ' . $row->time_zone;
    $rows[$row->id]['message'] = $row->message_text;
  }
  $table_list = '';
  $table_list .= theme_table($header, $rows);
  $table_list .= theme('pager', NULL, 10, 0);

  $filter_form = drupal_get_form('alert_notification_history_filter_form');
  $vars['filter_form'] = $filter_form;
  $vars['table_list'] = $table_list;
}

function alert_notification_history_filter_form() {
  $form = array();
  $from_date = $_GET['from_date']['date'] ? format_date((strtotime($_GET['from_date']['date'])), 'custom', 'Y-m-d ') . $_GET['from_date']['time'] : '';
  $to_date = $_GET['to_date']['date'] ? format_date((strtotime($_GET['to_date']['date'])), 'custom', 'Y-m-d ') . $_GET['to_date']['time'] : '';
  //validate date time
  if ($from_date && $to_date) {
    if (strtotime($from_date) > strtotime($to_date)) {
      form_set_error('to_date', 'Invalid To Date');
    }
  }
  $form['from_date'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#maxlength' => 10,
    '#date_format' => variable_get('date_format_short', 'm/d/Y - H:i'),
    '#date_year_range' => '-0:+2',
    '#default_value' => $from_date,
    '#value' => $from_date,
    '#title' => t('From Date'),
  );
  $form['to_date'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#date_format' => variable_get('date_format_short', 'm/d/Y - H:i'),
    '#maxlength' => 10,
    '#date_year_range' => '-0:+2',
    '#default_value' => $to_date,
    '#value' => $to_date,
    '#title' => t('To Date'),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Search'),
    '#id' => 'btn-submit',
  );
  $form['#method'] = 'get';
  return $form;
}

/**
 * use $notification_id get alert_transport_type_id
 * @param int $notification_id
 * @return array
 */
function get_notification_delivery($notification_id, $delivery = 'Email') {
  if ($delivery) {
    $delivery = db_fetch_object(db_query("SELECT id, name FROM {alert_transport_type} WHERE name='%s'", $delivery));
    if ($delivery) {
      return array($delivery->id => $delivery->name);
    }
  }
  $sql = "SELECT tt.id, tt.name FROM {technical_notification} tn 
  JOIN {alert_transport_type} tt ON tt.id = tn.transport_type_id
  WHERE tn.id=%d GROUP BY tt.id";
  $result = db_query($sql, $notification_id);
  $rows = array();
  while ($row = db_fetch_object($result)) {
    $rows[$row->id] = $row->name;
  }
  return $rows;
}
