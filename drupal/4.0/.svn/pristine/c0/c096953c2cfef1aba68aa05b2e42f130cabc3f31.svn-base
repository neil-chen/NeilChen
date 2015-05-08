<?php

/**
 * @file
 * Reports functionality defined here. For Service Records Report Only.
 */

/**
 * Alert event by Device serial number & date range
 */
function alert_event_report_form() {
  drupal_add_js(drupal_get_path('module', 'covidien_reports') . '/js/covidien_report_filter9.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_ahah.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_reports') . '/js/covidien_report.js');

  $post = array();
  $post['form_id'] = 'alert_event_report_form';

  $form = array();

  $form['product_line'] = array(
      '#type' => 'select',
      '#default_value' => $_SESSION['default_cot'],
      '#options' => get_productline(),
      '#ahah' => array(
          'event' => 'change',
          'wrapper' => 'edit-device-type',
          'method' => 'replace',
          'path' => 'ahah-report-pl-dtype-exposed-callback',
      )
  );

  $form['ds_number'] = array(
      '#type' => 'textfield',
      '#default_value' => '',
  );
  $form['ds_number']['#autocomplete_path'] = 'covidien/reports/autocomplete';
  $form['ds_number']['#attributes'] = array(
      'onfocus' => 'parentvalues("reports");',
  );

  $form['device_type'] = array(
      '#type' => 'select',
      '#default_value' => '',
      '#validated' => TRUE,
      '#options' => get_device_type(),
  );

  $form['device_type_hidden'] = array(
      '#type' => 'hidden',
  );

  if (is_numeric($_SESSION['default_dtype'])) {
    $form['device_type_hidden']['#default_value'] = $_SESSION['default_dtype'];
  }

  $form['from_date'] = array(
      '#type' => 'date_popup',
      '#attributes' => array(),
      '#maxlength' => 10,
      '#date_format' => 'm/d/Y',
      '#date_year_range' => '-5:+6',
  );

  $form['to_date'] = array(
      '#type' => 'date_popup',
      '#attributes' => array(),
      '#date_format' => 'm/d/Y',
      '#maxlength' => 10,
      '#date_year_range' => '-5:+6',
  );

  $form['alert_reason'] = array(
      '#type' => 'select',
      '#default_value' => '',
      '#validated' => FALSE,
      '#options' => get_alert_reason(),
  );

  $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('View Report'),
  );

  return $form;
}

/**
 * Report view data.
 */
function alert_event_report_form_view_data() {
  $alert_event_report_form_view = array();
  $alert_event_report_form_view['table']['group'] = t('alert');
  $alert_event_report_form_view['table']['base'] = array(
      'field' => 'alert_nid',
      'title' => t('alert_event_report_form_view'),
      'help' => t('Service Record from device_service_history_view'),
  );
  $alert_event_report_form_view['alert_nid'] = array(
      'title' => t('alert_nid'),
      'help' => t("alert_nid from alert_event_report_form_view"),
      'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_numeric',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort',
      ),
  );
  $alert_event_report_form_view['productline'] = array(
      'title' => t('productline'),
      'help' => t("productline from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_string',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_string',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort_string',
      ),
  );
  $alert_event_report_form_view['productline_nid'] = array(
      'title' => t('productline_nid'),
      'help' => t("productline_nid from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_numeric',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort',
      ),
  );
  $alert_event_report_form_view['devicetype'] = array(
      'title' => t('devicetype'),
      'help' => t("devicetype from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_string',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_string',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort_string',
      ),
  );
  $alert_event_report_form_view['devicetype_nid'] = array(
      'title' => t('devicetype_nid'),
      'help' => t("devicetype_nid from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_numeric',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort',
      ),
  );
  $alert_event_report_form_view['deviceserial'] = array(
      'title' => t('deviceserial'),
      'help' => t("deviceserial from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_string',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_string',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort_string',
      ),
  );
  $alert_event_report_form_view['alert_date'] = array(
      'title' => t('service_date'),
      'help' => t("service_date from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_string',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_string',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort_string',
      ),
  );
  $alert_event_report_form_view['alert_reason'] = array(
      'title' => t('alert_reason'),
      'help' => t("servicetype from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_string',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_string',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort_string',
      ),
  );
  $alert_event_report_form_view['alert_reason_id'] = array(
      'title' => t('alert_reason_id'),
      'help' => t("servicetype_nid from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_numeric',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort',
      ),
  );
  $alert_event_report_form_view['from_component_nid'] = array(
      'title' => t('from_component_nid'),
      'help' => t("from_component_nid from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_numeric',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort',
      ),
  );
  $alert_event_report_form_view['to_component_nid'] = array(
      'title' => t('to_component_nid'),
      'help' => t("to_component_nid from device_service_history_view"),
      'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
      ),
      'argument' => array(
          'handler' => 'views_handler_argument_numeric',
      ),
      'filter' => array(
          'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
          'handler' => 'views_handler_sort',
      ),
  );
  return $alert_event_report_form_view;
}

function covidien_reports_preprocess_alert_event_report_form(&$vars, $hook) {

  $form = $vars['form'];

  drupal_set_title(t('Select Report and Set Report Parameters'));
  $vars['title'] = t('Select Report and Set Report Parameters');
  $vars['product_line'] = drupal_render($form['product_line']);
  $vars['device_type'] = drupal_render($form['device_type']);
  $vars['ds_number'] = drupal_render($form['ds_number']);
  $vars['from_date'] = drupal_render($form['from_date']);
  $vars['to_date'] = drupal_render($form['to_date']);
  $vars['alert_reason'] = drupal_render($form['alert_reason']);
  $vars['search_button'] = drupal_render($form['submit']);

  // this is must
  $vars['form_extras'] = drupal_render($form);
  $total_reports = allReportList(); // Get all reports
  $report_list = getReportList(); // Get all reports related to the Product line

  // build menu
  foreach ($total_reports as $key => $val) {
    $class = array();
    if (in_array($val, $report_list)) {
      if (arg(3) == $key) {
        $class = array('attributes' => array('style' => 'color:#000000'));
      }
      $vars['report_menu'] .= l($val, "covidien/reports/filter/$key", $class) . "<br />";
    }
  }
}

/**
 * Implements hook_validate
 */
function alert_event_report_form_validate(&$form, &$form_state) {
  form_set_error(NULL, '', TRUE);
  drupal_get_messages();
  drupal_add_js(drupal_get_path('module', 'covidien_reports') . '/js/covidien_report_filter9.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_ahah.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_reports') . '/js/covidien_report.js');
  $filter = $form_state['values'];
  if ($filter['device_type'] == 'all') {
    form_set_error('device_type', t("Invalid Device Type"));
  }
  if ($filter['from_date'] == '') {
    form_set_error('from_date', t('Invalid From Date'));
  }
  if ($filter['to_date'] == '' && $form['#post']['to_date']['date']) {
    form_set_error('to_date', t('Invalid To Date'));
  }
  if ($filter['from_date'] != '' || $filter['to_date'] != '') {
    $tomorrowMidnight = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
    $from_date = strtotime($filter['from_date']);
    $to_date = strtotime($filter['to_date']);
    $isdate_valid = FALSE;
    $isdate_valid = date_is_valid($filter['from_date'], DATE_DATETIME, array('year', 'month', 'day'));
    if ($filter['from_date'] == '' || ($filter['from_date'] != '' && !$isdate_valid)) {
      form_set_error('from_date', t('Invalid From Date'));
    } elseif ($from_date > $tomorrowMidnight) {
      form_set_error('from_date', t('Invalid From Date'));
    }
    $isdate_valid1 = FALSE;
    $isdate_valid1 = date_is_valid($filter['to_date'], DATE_DATETIME, array('year', 'month', 'day'));
    if ($filter['to_date'] == '') {
      $filter['to_date'] = date('mm/dd/YYYY');
    } elseif (($filter['to_date'] != '' && !$isdate_valid1)) {
      form_set_error('to_date', t('Invalid To Date'));
    } elseif ($to_date > $tomorrowMidnight) {
      form_set_error('to_date', t('Invalid To Date'));
    }
    if ($isdate_valid && $isdate_valid1) {
      $from_date = strtotime($filter['from_date']);
      $to_date = strtotime($filter['to_date']);
      if ($to_date < $from_date) {
        form_set_error('to_date', t('Invalid From/To Date'));
      }
    }
  }
}

/**
 * Implements hook_submit
 */
function alert_event_report_form_submit(&$form, &$form_state) {
  global $base_url;
  $filter = $form_state['values'];
  $url = $base_path . "/covidien/report/9?v=9";
  if ($filter['product_line'] != 'all') {
    $url .= "&productline_nid=" . $filter['product_line'];
  }
  if ($filter['device_type'] != 'all') {
    $url .= "&devicetype_nid=" . $filter['device_type'];
  }
  if ($filter['alert_reason_id'] != 'all') {
    $url .= "&alert_reason_id=" . $filter['alert_reason'];
  }
  $url .= "&deviceserial=" . $filter['ds_number'];
  if ($filter['from_date'] != '') {
    $url .= "&from_date=" . $filter['from_date'];
  }
  if ($filter['to_date'] != '') {
    $to_date = strtotime($filter['to_date']);
    $url .= "&to_date=" . date('Y-m-d', $to_date) . ' 23:59:59';
  } else {
    $url .= "&to_date=" . date('Y-m-d', time()) . ' 23:59:59';
  }

  // Drupal goto encode the values and views filter not able to process.
  header('location:' . $base_url . $url);

  exit;
}

/**
 * Get html drop selection of alert reason.
 * 
 * @return html.
 */
function get_alert_reason() {
  $option_arr = array();
  $option_arr['all'] = t('All');
  $qry = get_alert_reason_query();
  $option_res = db_query($qry);
  while ($val = db_fetch_object($option_res)) {
    $option_arr[$val->id] = $val->name;
  }
  return $option_arr;
}

/**
 * Helper
 */
function get_alert_reason_query() {
  $query = "select id, name from alert_event";
  return $query;
}
