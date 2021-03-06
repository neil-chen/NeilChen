<?php 
function pending_registration_list_form(&$form_state) {    
    
  $from_date = '';
  $to_date = '';
  $user_name = '';
  $is_covidien_user = 0;
  $status = 'all';
  $cot = 'all';
  $trainer = '';
  $form = array();
  $format = 'm/d/Y';
  $class_of_trade_options = array('all' => 'All');
  ahah_helper_register($form, $form_state);
  $show_archived = 0;
  
  if(isset($form_state['values']['register_date_from'])){
    $from_date = $form_state['values']['register_date_from']; 
  } elseif ($_GET['register_date_from']['date'] != '') {
    $from_date = exchange_date_format($_GET['register_date_from']['date']); 
  }
   
  if(isset($form_state['values']['register_date_to'])){
    $to_date = $form_state['values']['register_date_to'];
  } elseif ($_GET['register_date_to']['date'] != '') {
    $to_date = exchange_date_format($_GET['register_date_to']['date']); 
  }
  
  if(isset($form_state['values']['user'])){
    $user_name = $form_state['values']['user'];
  } elseif ($_GET['user'] != '') {
    $user_name = $_GET['user']; 
  }
  
  if(isset($form_state['values']['class_of_trade'])){
    $cot = $form_state['values']['class_of_trade'];
  } elseif ($_GET['class_of_trade'] != ''){
    $cot = $_GET['class_of_trade'];
  }
  
  if(isset($form_state['values']['trainer'])){
    $post_trainer = $form_state['values']['trainer'];
  } elseif ($_GET['trainer'] != ''){
    $post_trainer = $_GET['trainer'];
  }
  
  if(isset($form_state['values']['status'])){
    $status = $form_state['values']['status'];
  } elseif ($_GET['status'] != ''){
    $status = $_GET['status'];
  } 
  if(isset($form_state['values']['show_archived'])){
    $show_archived = $form_state['values']['show_archived'];
  } elseif ($_GET['show_archived'] != ''){
    $show_archived = $_GET['show_archived'];
  }
   
  if(isset($form_state['values']['covidien_user'])){
    $is_covidien_user = $form_state['values']['covidien_user'];
  } elseif ($_GET['covidien_user'] != ''){
    $is_covidien_user = $_GET['covidien_user'];
  }
  
  $form['#ajax'] = array('enabled' => TRUE);
  
  $form['register_date_from'] = array(
    '#title' => 'From Register Date',
    '#type' => 'date_popup', 
    '#date_format' => $format, 
    '#default_value' => $from_date, 
  );
 
  $form['register_date_to'] = array(
    '#title' => 'To Register Date',
    '#type' => 'date_popup', 
    '#default_value' => $to_date,
    '#date_format' => $format, 
  );

  $form['user'] = array(
    '#title' => 'User',
    '#type' => 'textfield',
    '#size' => '30',
    '#default_value' => $user_name, 
    '#attributes' => array(
      'title' => t("Search user by first name or first and last name together."),  
    )
  );
  $form['covidien_user'] = array(
    '#type' => 'checkbox',
    '#title' => t('Covidien Employee'),
    '#default_value' => $is_covidien_user,
  ); 
   
  $form['status'] = array(
    '#type' => 'select',
    '#title' => t('Status'), 
    '#options' => array(
      'all' => 'All',
      'pending' => 'Pending',
      'completed' => 'Completed',
      'active' => 'Active' 
    ), 
    '#default_value' => $status,
  ); 
    
  $form['show_archived'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Archieved'),
    '#default_value' => $show_archived, 
    '#attributes' => array(
      'title' => t("Show Archived"),
    )
  );
      
  //Get class of trade
  $class_of_trades = getadminproductline();
  while ($class = db_fetch_object($class_of_trades)) {
    $class_of_trade_options[$class->nid] = $class->title;
	}
   
  $form['class_of_trade'] = array(
    '#type' => 'select',
    '#title' => t('Class of Trade'),
    '#options' => $class_of_trade_options, 
    '#default_value' => $cot,
      
  ); 
   
  $trainers_result = get_all_trainer_name();
  $trainer_options = array('all' => 'All');
  while($trainer = db_fetch_object($trainers_result)) { 
    $trainer_options[$trainer->nid] = $trainer->name;
  } 
   
  $form['trainer'] = array(
    '#type' => 'select',
    '#title' => t('Trainer'),
    '#options' => $trainer_options, 
    '#default_value' => $post_trainer,
      
  );
 
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'GO',
  );
   
  //Generate the Table list
  $sql = "SELECT DISTINCT(user.id), user.first_name, user.last_name, user.active_code, 
          user.email, user.is_covidien_user, 
          user.customer_name, user.account_number, user.create_time, user.status, 
          user.approve_result, user.approving_user, user.user_id
          FROM {registrant} AS user ";
  $args = array(); 
  $where = array(); 
  
  if((isset($form_state['values']['register_date_from']) && !empty($form_state['values']['register_date_from']) || !empty($_GET['register_date_from']['date']))){
    $where[] = " user.create_time >= %d ";
    $args[] = ($form_state['values']['register_date_from'] != '' ? convert_date($form_state['values']['register_date_from']) : convert_date(exchange_date_format($_GET['register_date_from']['date'])));
  }
  
  if((isset($form_state['values']['register_date_to']) && !empty($form_state['values']['register_date_to'])) || !empty($_GET['register_date_to']['date'])){
    $where[] = " user.create_time <= %d ";
    $args[] = ($form_state['values']['register_date_to'] != '' ? convert_date($form_state['values']['register_date_to']) : convert_date(exchange_date_format($_GET['register_date_to']['date'])));
  }
  
  if ((isset($form_state['values']['user']) && !empty($form_state['values']['user'])) || !empty($_GET['user'])) {
    $where[] = " CONCAT_WS(' ', user.first_name, user.last_name) like '%s%' ";
    $args[] = ($form_state['values']['user'] != '' ? $form_state['values']['user'] : $_GET['user']);
  } 
  
  if(isset($form_state['values']['class_of_trade'])) {
    if($form_state['values']['class_of_trade'] != 'all'){
      $sql .= " left join {registrant_cot} on registrant_cot.registrant_id = user.id ";
      $where[] = " registrant_cot.cot = %d ";
      $args[] = $form_state['values']['class_of_trade'];
    }
  } elseif (!empty($_GET['class_of_trade'])) {
    if($_GET['class_of_trade'] != 'all'){
      $sql .= " left join {registrant_cot} on registrant_cot.registrant_id = user.id ";
      $where[] = " registrant_cot.cot = %d ";
      $args[] = $_GET['class_of_trade'] ;
    }
  } 
  
if($status != 'all'){ 
  if($show_archived != 1){
    $where[] = " (user.status = '%s') ";  
  } else {
    $where[] = " (user.status = '%s' and user.status = 'archived') ";  
  }
  if(isset($form_state['values']['status']) && $form_state['values']['status'] != ''){
    $args[] = $form_state['values']['status'];
  } else {
    $args[] = $_GET['status'];  
  }
} else {
    if($show_archived == 1){
      $where[] = " (user.status != '') ";    
    } else {
      $where[] = " (user.status != 'archived') ";      
    }
}
  
  if(isset($form_state['values']['trainer']) && $form_state['values']['trainer'] != 'all') {
    $sql .= ' left join {registrant_training} on registrant_training.registrant_id = user.id ';
    $where[] = " registrant_training.trainer_uid = %d ";
    $args[] = $form_state['values']['trainer'];
  } elseif (!empty($_GET['trainer']) && $_GET['trainer'] != 'all') {
    $sql .= ' left join {registrant_training} on registrant_training.registrant_id = user.id ';
    $where[] = " registrant_training.trainer_uid = %d ";
    $args[] = $_GET['trainer'];
  } 
   
  $where_query = implode(' and ' , $where);
  if($where_query){
    $sql .= " Where " . $where_query;
  } 
  
  $sql .= " group by user.email
            ORDER BY id DESC";
    
  $header = array(
    array('data' => t('First Name')),
    array('data' => t('Last Name')),
    array('data' => t('Email')),
    array('data' => t('Covidien Employee')),
    array('data' => t('Customer')),
    array('data' => t('Training')),
    array('data' => t('Register Date')),
    array('data' => t('Status')),
    array('data' => t('Approving User')),
    array('data' => t('Approved')),
    array('data' => t('Others')),
  );
  
  $pageSize = 10;
  $rows = array();  
  $count_query = 'SELECT COUNT(*) as total FROM (' . $sql . ') AS result' ;
  $result = pager_query($sql, $pageSize, 0, $count_query, $args); 
  while ($row = db_fetch_object($result)) { 
    $rows[$row->id]['first_name'] = $row->first_name; 
    $rows[$row->id]['last_name'] = $row->last_name; 
    $rows[$row->id]['email'] = $row->email; 
    $rows[$row->id]['is_covidien_user'] = $row->is_covidien_user == 1 ? 'YES' : 'NO'; 
    $customer_name = 'NA';
    if($row->customer_name != '' && $row->account_number != ''){
      $customer_name = $row->customer_name . '(' . $row->account_number . ')'; 
    } 
    $rows[$row->id]['customer'] = $customer_name; 
    $rows[$row->id]['training'] = l(get_training_records($row->id), 'covidien/self/view-training-records/' . $row->id,array(
    'attributes' => array(
      'class' => 'training_detail',
      'data' => $row->id,
      )
    )); 
     
    $register_date=date("m/d/Y",$row->create_time);
    $rows[$row->id]['register_date'] = $register_date; 
    $rows[$row->id]['status'] = $row->status; 
    $rows[$row->id]['approving_user'] = $row->approving_user; 
    $approved = $row->approve_result;
    if($approved == 'pending'){
      $rows[$row->id]['approved'] = l($approved, 'self/approving/' . $row->id . '/' . $row->active_code,array(
      'attributes' => array(
        'class' => $approved,
        )
      )); // $approved; 
    } else {
      $rows[$row->id]['approved'] = array(
        'data' => $approved,
        //'title' => $approved,
        'class' => $approved,
        //'name' => $approved,
      );
    }
    $archive_link = '';
    if($row->status != 'archived'){
        $archive_link = l('archive this', $row->id,array(
          'attributes' => array(
          'class' => 'archived',
          'data' => $row->id,
        )
      ));
    }
    
    $resend_link = '';
    //send email to approved user that had not been reset his/her password yet
    if($row->approve_result == 'approved' && $row->user_id == 0){
        $resend_link = l('resend email', $row->id,array(
          'attributes' => array(
          'class' => 'resend_email',
          'data' => $row->id,
        )
      ));
    }
    
    $active = '';
    if($row->user_id > 0){
      $active = '<br>In GDMP';
    }
    $rows[$row->id]['resend_email'] = $resend_link . '  ' . $archive_link . ' ' . $active; 
  }
  $table_list = '';
  $table_list = theme('table',$header, $rows);
  $table_list .= theme('pager', NULL, 10, 0);
 
  $form['#pending_list'] = $table_list;
  $vars['registration_pending_list'] = $table_list;
  //system_settings_form_submit
  
  $form['#submit'][0] = 'pending_registration_list_form_submit';  
  
  return $form; 
}
 

function pending_registration_list_form_submit($form, &$form_state) { 
  //drupal_set_message(t('The configuration options have been reset to their default values.'));
  //get data and save data to table $form_state['values'];
  //drupal_set_message("you have successfully register for a new user");
  //$user_name = $form_state['values']['first_name'] . ' ' . $form_state['values']['last_name'];
  //$email = $form_state['values']['email'];
  //$redirect = 'self/complete/' . $user_name . '/' . $email;
  //drupal_goto($redirect); 
} 
    
/**
 * get Total Training Records base on user id
 */
function get_training_records($user_id){
  $query = "SELECT COUNT(*) as total
            FROM {registrant_training}
            WHERE registrant_id = %d";
  $training_result = db_query($query, $user_id);
  $total = 0;
  while ($record = db_fetch_object($training_result)) { 
    $total = $record->total;
	}
  return $total;
}

 
/**
 * Get all Trainer without worry about device type
 */
function get_all_trainer_name(){
  $query = "SELECT DISTINCT (pp.field_person_pk_nid) AS nid, n.title AS name
            FROM node n
            JOIN content_type_device_user_privileges dup ON n.vid = dup.vid
            LEFT JOIN content_type_section_access_option sao ON dup.field_user_section_access_nid = sao.vid
            LEFT JOIN node aon ON sao.field_access_option_nid = aon.nid
            LEFT JOIN content_field_device_type fdt ON n.vid = fdt.vid
            LEFT JOIN content_field_person_pk pp ON n.vid = pp.vid
            WHERE n.type = 'device_user_privileges' 
            AND aon.title = 'yes' ORDER BY n.title ASC";
  return db_query($query);
}
