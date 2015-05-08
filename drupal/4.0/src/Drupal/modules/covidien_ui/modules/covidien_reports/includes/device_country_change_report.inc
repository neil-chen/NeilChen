<?php


function device_country_change_form($form) {
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_ahah.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_reports') . '/js/covidien_report.js');

  $form = array();

//  $form['#action'] = url('reports/result/15');

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

  $form['device_type'] = array(
    '#type' => 'select',
    '#default_value' => $_SESSION['default_dtype'],
    '#validated' => TRUE,
    '#options' => get_device_type(),
    '#attributes' => array('onchange' => 'changeDeviceType()'),
  );

  $form['device_type_name'] = array(
    '#type' => 'hidden',
  );

  $form['user_id'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
    '#maxlength' => 400,
    '#required' => TRUE,
    '#validated' => TRUE,
  );

  $form['user_id_hidden'] = array(
    '#type' => 'hidden',
  );

  $form['user_id']['#autocomplete_path'] = 'firstname_lastname/autocomplete';

//  $form['user_id']['#attributes'] = array(
//  'onfocus' => 'reportparentvalues("reports/customername", "edit-user-id");',
//  );

  $form['from_date'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#maxlength' => 10,
    '#date_format' => 'm/d/Y',
    '#date_year_range' => '-5:+6',
    '#validated' => TRUE,
  );

  $form['to_date'] = array(
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#date_format' => 'm/d/Y',
    '#maxlength' => 10,
    '#date_year_range' => '-5:+6',
    '#required' => TRUE,
    '#validated' => TRUE,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('View Report'),
    '#attributes' => array('onclick' => 'return country_change_form_commit()'),
  );

  $form['#validate'] = array('device_country_change_form_validate');
  $form['#submit'] = array('device_country_change_form_submit');
  
  return $form;
}



function device_country_change_form_validate(&$form, &$form_state) {
  form_set_error(NULL, '', TRUE);
  drupal_get_messages();
  $filter = $form_state['values'];
  
  $_SESSION['default_dtype'] = $filter['device_type'] ;
  
  if (!$_POST['op']) {
    return false;
  }
  
  if ($filter['device_type'] == 'all') {
    form_set_error('device_type', t("Invalid Device Type"));
  }
  
  $from_date =  $filter['from_date']['date'] ;
  $to_date =  $filter['to_date']['date'];    
    
  if (!$from_date) { 
    form_set_error('from_date', t('Invalid From Date'));
    return false;
  }

  if (!$to_date) { 
    form_set_error('to_date', t('Invalid To Date'));
    return false;
  }
  
  $from_date = strtotime($from_date);
  $to_date =  strtotime($to_date);
  
  if ($to_date < $from_date) {
    form_set_error('to_date', t('From Date must be equal to or earlier than the To date'));
  }
  
}

function device_country_change_form_submit(&$form, &$form_state) {
  if (count(form_get_errors()) || !$_POST['op']) {
    return false;
  }  
  
  $device_type =  $_POST['device_type'];
  $user_id = $_POST['user_id'];
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];
  
  $device_type_name = $_REQUEST['device_type_name'];
//  $user_id = $_REQUEST['user_id'];  // Vivian Li
  $from_date = $_REQUEST['from_date']['date'];
  $to_date = $_REQUEST['to_date']['date'];
  $pro_line = $_REQUEST['pro_line'];
  $pro_line_name = $_REQUEST['pro_line_name'];

//  Drupal goto encode the values and views filter not able to process.
//  $args = array(
//    'device_type' => $device_type, 
//    'device_type_name' => $device_type_name, 
//    'user_id' => $user_id , 
//    'from_date' => $from_date['date']  ,
//    'to_date' => $to_date,
//    'pro_line' => $pro_line,  
//    'pro_line_name' => $pro_line_name,  
//  );
  
//  ?device_type=1446815&device_type_name=VTS Client&user_id=Rose Ni&from_date=1&to_date=12%2F16%2F2014&pro_line=23&pro_line_name=Ventilation
  $args = '?device_type='. $device_type ;
  $args .= '&device_type_name='. $device_type_name ;
  $args .= '&user_id='. $user_id ;
  $args .= '&from_date='. $from_date ;
  $args .= '&to_date='. $to_date ;
  $args .= '&pro_line='. $pro_line ;  
  $args .= '&pro_line_name='. $pro_line_name ;
  
//  drupal_goto('reports/result/15', $args);

  global $base_url ;
  header('location:' . $base_url . '/reports/result/15'.$args); 
  exit;

}

function template_preprocess_device_country_change_form(&$vars, $hook) {
  drupal_set_title(t('Select Report and Set Report Parameters'));
  $vars['title'] = t('Select Report and Set Report Parameters');
  $vars['device_type'] = drupal_render($vars['form']['device_type']);
  $vars['product_line'] = drupal_render($vars['form']['product_line']);
  $vars['user_id'] = drupal_render($vars['form']['user_id']);

  $vars['from_date'] = drupal_render($vars['form']['from_date']);
  $vars['to_date'] = drupal_render($vars['form']['to_date']);

  //  echo '<pre>' ; var_dump($vars['from_date']) ; exit;


  $vars['country'] = drupal_render($vars['form']['country']);

  $vars['search_button'] = drupal_render($vars['form']['submit']);
  // this is must
  $vars['form_extras'] = drupal_render($vars['form']);

  $vars['report_menu'] = get_all_report_menu();
  
}


function template_preprocess_device_country_change_report(&$vars, $hook) {
  $pageSize = 10;

  $device_type = $_REQUEST['device_type'];
  $user_id = $_REQUEST['user_id'];  // Vivian Li
  $from_date = $_REQUEST['from_date'];
  $to_date = $_REQUEST['to_date'];
  $pro_line = $_REQUEST['pro_line'];
  $pro_line_name = $_REQUEST['pro_line_name'];


  // table head need to customize
  $header = array(
    array(
      'data' => t('Device SN'),
      'field' => 'sn',
      'sort' => 'asc'
    ),
    array(
      'data' => t('Customer'),
      'field' => 'customer',
      'sort' => 'asc'
    ),
    array(
      'data' => t('User ID'),
      'field' => 'user_id',
      'sort' => 'asc'
    ),
    array(
      'data' => t('Date Country Changed'),
      'field' => 'date_time',
      'sort' => 'asc'
    ),
    array(
      'data' => t('Previous Country'),
      'field' => 'old_country',
      'sort' => 'asc'
    ),
    array(
      'data' => t('New Country'),
      'field' => 'new_country',
      'sort' => 'asc'
    )
  );

  $sql = "select d.field_device_serial_number_value sn,
            b.field_bu_customer_account_number_value customer,
            p.field_person_username_value user_id ,
            h.date_time
            , o.field_iso_3166_2lcode_value old_country
            , n.field_iso_3166_2lcode_value new_country
          from device_country_change_history h
            join content_type_country o on h.old_country_nid=o.nid
            join content_type_country n on h.new_country_nid=n.nid
            join content_type_device d on h.originator_device_nid=d.nid
            join content_type_person p on  h.user_nid = p.nid
            join content_type_bu_customer b on d.field_device_owner_nid = b.nid
            join content_field_device_type dt on d.nid = dt.nid
            join content_field_device_product_line pl on dt.field_device_type_nid  = pl.nid
          where dt.field_device_type_nid = %d 
            and pl.field_device_product_line_nid = %d " ;
  
    $args = array($device_type, $pro_line);

    if($user_id){
      $sql .= " and  CONCAT(p.field_first_name_value , ' ', p.field_last_name_value ) = '%s'";
      $args[] = $user_id;
    }

    if($from_date){
      $sql .= " and h.date_time >= %d";
      $args[] = strtotime($from_date);
    }
    
    if($to_date){
      $sql .= " and h.date_time < %d";
      $args[] = strtotime("+1 day", strtotime($to_date)) ;
    }

  //  --  where originator_device_nid   old_country  new_country  date_time

  drupal_set_title(t('Sevice Country Change Report'));
  global $base_url;

  $sql .= check_plain($_GET['sort']) ? tablesort_sql($header) : " ORDER BY h.date_time DESC ";
  $count_query_sql = ' SELECT COUNT(*) as total FROM (' . $sql . ') AS result ';
  $result = pager_query($sql, $pageSize, 0, $count_query_sql,$args);
  
  $rows = array();
  $row = array();
  while ($record = db_fetch_object($result)) {
    $row[0] = $record->sn;
    $row[1] = $record->customer;
    $row[2] = $record->user_id;
    $row[3] = date('Y-m-d H:i:s', $record->date_time);
    $row[4] = $record->old_country;
    $row[5] = $record->new_country;
    array_push( $rows, $row );
  }

  $output = theme('table', $header, $rows);
  $output .= theme('pager', NULL, $pageSize);

  
  $form['returnbtn'] = array(
    '#type' => 'submit',
    '#value' => 'Return',
    '#attributes' => array(
      'class' => 'secondary_submit',
      //'onclick' => "window.location=\"" . $base_url . "/covidien/reports/filter/7\"; return true;",
      'style' => 'float:right'
    ),
  );


  $vars['device_type_name'] = $_REQUEST['device_type_name'];
  $vars['pro_line_name'] = $pro_line_name;
  $vars['user_id'] = $user_id;
  $vars['from_date'] = $from_date;
  $vars['to_date'] = $to_date;
  $vars['result'] = $output;
}



