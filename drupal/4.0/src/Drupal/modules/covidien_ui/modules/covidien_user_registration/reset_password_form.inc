<?php  
function self_reset_password_form(&$form_state) {  
  
  $id = arg(2);
  $active_code = arg(3);
  $email = arg(4);
  $form = array();
   
  $count = 0;
  if(!empty($id) && !empty($active_code) && !empty($email)){ 
    $query = "SELECT *
            FROM {registrant}
            WHERE ID = %d
            AND email = '%s'
            AND active_code = '%s'
            AND user_id = 0";
   
    $result = db_query($query, $id, $email, $active_code); 
    while ($user = db_fetch_array($result)) {
      $count++; 
      $user['language_id'] = $user['language'];
      $user['country_id'] = $user['country'];
      $user['is_covidien_user'] = $user['is_covidien_user'];
      $form['#register_user'] = $user; 
      break;
    }  
  } 
  
  if($count > 0){ 
      ahah_helper_register($form, $form_state);  

      $form['#attributes'] = array('enctype' => "multipart/form-data");
      $form['#ajax'] = array('enabled' => TRUE);

      $form['password'] = array(
        '#title' => 'New Password',
        '#type' => 'password',
        '#size' => '100',
        '#attributes' => array(
          'title' => t("Please enter in your new password."),
        ),
      ); 
      
      $form['confirm_password'] = array(
        '#title' => 'Confirm Password',
        '#type' => 'password',
        '#size' => '100', 
        '#attributes' => array(
          'title' => t("Please confirm your new password."), 
        )
      ); 

      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => 'Set Password',
        '#attributes' => array(
          'title' => t("Click here to set your password."),
        )
      ); 
      $form['#submit'][0] = 'self_reset_password_form_submit';  

    } 
    
  return $form; 
}
   
function self_reset_password_form_submit($form, &$form_state) {
  global $base_url;
  $mail = $form['#register_user']['email'];
  $name = $form['#register_user']['email'];
  $first_name = $form['#register_user']['first_name'];
  $last_name = $form['#register_user']['last_name'];
  $cov_user = $form['#register_user']['is_covidien_user'] == 1 ? 'Yes': 'No';
  $password = $form_state['values']['password'];
  $query_cot_and_roles = "SELECT role FROM {registrant_cot}
                          where registrant_id = %d";
  $result_roles = db_query($query_cot_and_roles, $form['#register_user']['id'] );
  
  $roles = Array('2' => 'authenticated user');
  
  while ($object = db_fetch_object($result_roles)) { 
    $roles[$object->role] = $object->role;
    /*
    $role = get_drupal_rid_from_cot_and_rid($object->role);
    if($role){
      $roles[$role->rid] = $role->name;
    } */
  } 
  
  $node = array(
    'name' => $name,
    'init' => $mail,
    'mail' => $mail,
    'pass' => $password,
    'status' => 1, 
    'roles' => $roles,
     );
  $node = user_save('', $node); 
  //Create User is ok

  // insert to party content type
  $party_val = new stdClass();
  $party_val->title = $node->name;
  $party_val->uid = $node->uid;
  $party_val->type = "party";
  $party_val->language = "en";
  $party_val->field_party_type[] = '';
  node_save($party_val);

  //Create Person content type   
  $person = new stdClass();
  $person->from_page = 'self_reset';
  $person->type = 'person';
  $person->mail = $mail; 
  $person->uid = $node->uid;
  $person->status = 1;
  $person->roles = $roles;
  $person->field_last_name[0]['value'] = $last_name;
  $person->field_first_name[0]['value'] = $first_name;
  $person->field_covidien_employee[0]['value'] = $cov_user;
  $person->field_user_language[0]['nid'] = $form['#register_user']['language_id'];// 1407482; // content_type_language nid 1407482 = english
  if($cov_user == "No"){
    if(isset($form['#register_user']['customer_name']) && !empty($form['#register_user']['customer_name'])){
      $person->field_company_name[0]['nid'] = get_customer_name_by_title($form['#register_user']['customer_name']);
    }
    if(isset($form['#register_user']['account_number']) && !empty($form['#register_user']['account_number'])){
      $person->field_comp_account_no[0]['nid'] = get_customer_account_by_title($form['#register_user']['account_number']);
    }
  }
  $person->field_person_party[0]['nid'] = $party_val->nid;
  $person->name = $name; 
  $person->title = $mail;
  $person->field_person_username[0]['value'] = $mail;
  $person->language = 'en'; 
  $person->field_device_avail_country[0]['nid']=$form['#register_user']['country_id'];//468;//node 468 - US
  $person->field_password_expiration_date[0]['value']=date('Y-m-d H:i:s', strtotime("+90 days"));
  $person = node_submit($person);
  node_save($person); 
  
  //Create person application role, each role for each cot. foreach needed
  $count = 0;  
  foreach($roles as $key => $role){
    $role = new stdClass(); 
    $role->from_page = 'self_reset';
    $role->title = $name;
    $role->type = "person_application_role";
    $role->language = "en";
    $role->uid = $node->uid;
    $role->field_person_pk[0]['nid'] = $person->nid; //this is the person nid, TODO HAVING ISSUE WITH SAVING PERSON
    //$default = '1'; 
    if($count == 1){
      $role->field_person_role_default[0]['value'] = 1;
    } else {
      $role->field_person_role_default[0]['value'] = 0;
    }
    $device_access_level = 1;
    if($cov_user == 'Yes'){
      $device_access_level = 2;
    }
    $role->field_max_download_level[0]['value'] = $device_access_level; //$form['#register_user']['device_access'];//2; //Device Access Level    $node->{$pl_name . '_privilege'};
    
    $role->field_app_role_pk[0]['nid'] = $key;
     
    //$form['#register_user']['role'];//177;//Role [role] => 177  $nid; 
    node_save($role);
    $count++; //second role will have default of 1 while other as 0
  } 
  
  //add in user role
  foreach($roles as $key => $role){
    $user_role_query = getRoleidQuery($key);
    $role_id = db_fetch_array($user_role_query); 
    $user_role->uid = $node->uid;
    $user_role->rid = $role_id['rid'];
    drupal_write_record('users_roles', $user_role);
  }
  $sql = "select * from {registrant_training} where registrant_id = %d";
  $result = db_query($sql, $form['#register_user']['id']); 

  while ($record = db_fetch_object($result)) { 
    $training_date = '';
    if(isset($record->training_date) && $record->training_date != '0'){
      $training_date = date("Y-m-d",$record->training_date) . ' 00:00:00';
    }
    $training_record= new stdClass();
    $training_record->from_page = 'self_reset';
    $training_record->title = $name;
    $training_record->type = "person_training_record";
    $training_record->uid = $node->uid;
    $training_record->language = "en";
    $training_record->field_trainee_id[] = array('nid' => $person->nid);
    $training_record->field_trainer_id[] = array('nid' => $record->trainer_uid);
    $training_record->field_training_completion_date[0]['value'] = $training_date;
    $training_record->field_certificate_image[0]['fid'] = $record->certificate_file;
    $training_record->field_active_flag[0]['value'] = 0;
    $training_record->field_device_type[0]['nid'] = $record->device_type;  
    node_save($training_record); 
    if (!$training_record) { 
      print("Error saving training_record!");
    }
  }  
  
  try {   
    $sql = "UPDATE {registrant} SET user_id = %d
            WHERE id = %d";
    db_query($sql,$node->uid, $form['#register_user']['id']);  
    
  } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
  
  $to = $mail; // to e-mail address
  $from = "noreply@covidien.com"; // from e-mail address
  $subject = "Covidien password reset"; // subject of e-mail
  /*$body = "Congratulations! Your password has been successfully changed." . 
          " You could log in at: " . $base_url ; 
  */
  $today_date = date("D M j G:i:s T Y"); 
  $body = "Dear " . $first_name . " " . $last_name . ",\n\nYour password was changed on " 
          . $today_date . ".\nIf you did not change your password, please contact Device Management Portal administration immediately.\n\n" . 
          "Thank you,\nCovidien Admin ";
  $params = array(
  'subject' => $subject,
  'body' => $body,
  );
  drupal_mail('covidien_user_registration', 'self_register', $to, language_default(), $params, $from);

  drupal_add_js('alert("Your account has been created successfully. You will now get redirect to login page.");window.location.href = "' . $base_url . '";', 'inline');
  //drupal_set_message(t('Your account has been created successfully.')); 
  $redirect = '<front>';
  //drupal_goto($redirect);

} 
   

function self_reset_password_form_validate($form, &$form_state) {
 
}
 
function get_drupal_rid_from_cot_and_rid($role_nid){ 
  $query = "SELECT role.rid, role.name
            FROM {content_type_roles}
            left join {role} on role.name = CONCAT(content_type_roles.field_role_product_line_nid,'__',content_type_roles.field_roles_description_value) 
            where content_type_roles.nid = %d";
  $result = db_query($query,$role_nid);  
  $record = db_fetch_object($result); 
  return $record;
}