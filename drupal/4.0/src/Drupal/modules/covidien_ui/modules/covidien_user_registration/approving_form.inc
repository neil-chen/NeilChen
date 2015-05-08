<?php 
function approving_form(&$form_state) { 
  global $base_url, $user;  
 
  $form = array();
  $register_user = array();
  //ahah_helper_register($form, $form_state);  
  $register_id = arg(2);
  $active_code = arg(3);
  $cov_user = 0;
  $query = "SELECT *
            FROM {registrant}
            WHERE ID = %d
            AND active_code = '%s'"; 
   
  $result = db_query($query, $register_id, $active_code); 
  $temp_user = db_fetch_array($result);
  if(!empty($temp_user)){ 
    $temp_user['cot_id'] = $temp_user['cot'];
    $temp_user['cot_name'] = get_title($temp_user['cot']);
    $temp_user['language_id'] = $temp_user['language'];
    $temp_user['country_id'] = $temp_user['country'];
    $temp_user['language'] = get_title($temp_user['language']);
    $temp_user['country'] = get_title($temp_user['country']);
    $temp_user['phone_number'] = $temp_user['phone_number'];
    $cov_user = $temp_user['is_covidien_user'];
    $temp_user['is_covidien_user'] = ($temp_user['is_covidien_user'] == '1'? 'Yes':'No');
    
    $register_user = $temp_user;  
    $form['#register_user'] = $temp_user; 
    
    $form['#attributes'] = array('enctype' => "multipart/form-data");
    $form['#ajax'] = array('enabled' => TRUE);
  
    
  //Begin
     
  $format = 'm/d/Y';
  //10/30 keep class of trade value to use later in device type
  $cot_default_value = 23;
  if (!isset($form_state['storage']['cot']['class_of_trade'])) {
    $cot_default_value = 23;
  }
  else { 
    $cot_default_value =  $form_state['storage']['cot']['class_of_trade'];
  }
  //End COT and Devices
  //covidien_user
  $default_user = $cov_user;
  $customer_name = '';
  $customer_account = '';
  if($cov_user == 0){ 
    $customer_name = $temp_user['customer_name'];
    $customer_account = $temp_user['account_number'];
  }
  
  //watchdog('debug customer name', print_r($form_state, 1));
   
  
  $country_options = array();
  //$language_options = array(); 
  $class_of_trade_options = array();
   
  //get list of all countries and language
  $query = "SELECT *
            FROM {node}
            WHERE TYPE = 'country'
            ORDER BY title ASC";
  $result = db_query($query);
  while ($object = db_fetch_object($result)) {
    $country_options[$object->nid] = $object->title;
  }
  //TODO - Check with business side to see if the device type should appear all or it would base on class of trade
  //defaul COT is 23, then user could select different value
  //$device_type_option = get_device_type('23'); 
  $form['#attributes'] = array('enctype' => "multipart/form-data");
  $form['#ajax'] = array('enabled' => TRUE);
  $form['cot'] = array(
    '#type'   => 'fieldset', 
    '#prefix' => '<div id="cot-info-wrapper">', 
    '#suffix' => '</div>',
    '#tree'   => TRUE, 
  );
   
  $form['cov_user_app'] = array(
    '#type' => 'checkbox',
    '#title' => t('I am Covidien Employee'),
    '#default_value' => $default_user, 
    '#attributes' => array(
      'title' => t("Are you a Covidien Employee?"),
    )
      
  );   
  
  $existed_customer = get_customer_name_by_title($customer_name);
  $message = ""; 
  if($existed_customer == ''){
    $message = "Supplied customer name is not recognized by the DMP as a Covidien customer. You may change this as needed. 
                If it is not changed, the DMP will create for its own use a Customer ID using the supplied Customer name.";
  }
  $form['customer_name'] = array(
    '#title' => 'Customer Name',
    '#type' => 'textfield',
    '#description' => $message,
    '#size' => '100',
    '#default_value' => $customer_name,
    '#autocomplete_path' => 'self/customer_name_autocomplete',
    '#id' => 'customer-name',
    '#attributes' => array(
      'title' => t("Please enter in the customer name."),
      'onblur' => "setaccountnumber();",
    ),
  );
    /*after have the match, pass it to the front end.
     * after that grab the same nid and query and return
     * the second part to have 1-1 match
     */  
    //TODO, need to look up auto complete default setting.
   
  $form['customer_account'] = array(
    '#title' => 'Customer Account',
    '#type' => 'textfield',
    '#size' => '100',
    '#default_value' => $customer_account,
    '#id' => 'customer-account',
    '#autocomplete_path' => 'self/customer_account_autocomplete',
    '#attributes' => array(
      'title' => t("Please enter in the account number."), 
      'onblur' => "setcustomername();",
    )
  );  
  
  $form['approving_manager'] = array(
    '#title' => 'Approving Manager',
    '#type' => 'textfield',
    '#size' => '1024', 
    '#autocomplete_path' => 'self/approving_user_autocomplete',
    '#attributes' => array(
      'title' => t("Please select your approve manager."),
    )
  ); 
  
  $form['cot_category'] = array(
    '#type'   => 'fieldset', 
    '#prefix' => '<div id="cotcate-info-wrapper">', // This is our wrapper div.
    '#suffix' => '</div>',
    '#tree'   => TRUE, // Don't forget to set #tree!
  ); 
  $form['cot'] = array(
    '#type'   => 'fieldset', 
    '#prefix' => '<div id="cot-info-wrapper">', // This is our wrapper div.
    '#suffix' => '</div>',
    '#tree'   => TRUE, // Don't forget to set #tree!
  );   
  //Get class of trade
  $manual_cot = array(
      'ablation' => 'ablation',
      'vessel sealing' => 'vessel sealing',
  );
  
  $class_of_trades = getadminproductline();
  
  $temp_array1 = array();
  $temp_array2 = array();
  //moving ablation and vessel sealing to the bottom of the list
  $count = 0;
  $flag_acknowledge = FALSE; 
  while ($cot_object = db_fetch_object($class_of_trades)) {
    if(!in_array(strtolower($cot_object->title), $manual_cot)){
      $temp_array1[$count] = $cot_object;
    } else {
      $temp_array2[$count] = $cot_object;
    }
    $count++;
  }
   
  $all_cot = $temp_array2 + $temp_array1;
  //remove two cot that we do not support
  foreach($all_cot as $index => $cot){
    if(strtolower($cot->title) == "stapling" || strtolower($cot->title) == "patient monitoring" || strtolower($cot->title) == "infrastructure" || strtolower($cot->title) == "compression"){
      unset($all_cot[$index]);
    }
  }
  
  //Get 2nd cot to match with the 1st cot on first page 
  $first_and_second_cot_role = '';
  foreach($all_cot as $index => $cot){
    $all_roles_belong_in_cot = get_role_list($cot->nid,'Yes'); 
    $default_cot_role = get_default_role_from_cot($register_id, $cot->nid);  
    //get first cot role if it is available
    if(!empty($default_cot_role)){ 
      //Query to get the Role match with the first COT by using the 2nd COT
      $query = 'select field_role_product_line_nid as cot, field_roles_description_value as role'
          . ' from {content_type_roles} '
          . ' where nid = %d';
      $result = db_query($query, $default_cot_role);
      $result_object = db_fetch_object($result); 
      $query_match_role = "select nid"
        . " from {content_type_roles} "
        . " where field_role_product_line_nid = %d and field_roles_description_value = '%s'";
      $result_role_id = db_query($query_match_role, $result_object->cot,$result_object->role);
      $result_role_id = db_fetch_object($result_role_id); 
      $first_and_second_cot_role = $result_role_id->nid; 
    }  
  }
  
  $acknowledge = 0;
  $cot_count = 0;
  foreach ($all_cot as $index => $cot) {
    
    //Get Default role from db
    $default_cot_role = get_default_role_from_cot($register_id, $cot->nid); 
    if($default_cot_role == '' && $cot_count == 0){
      $default_cot_role = $first_and_second_cot_role;
    }
    $cot_count++;
    $form['cot_category_role']['cot_'.$cot->nid.'_'.$cot->title]['role_'.$cot->nid] = array(
      '#type' => 'select',
      '#id' => $cot->nid,
      '#title' => t('Role'),
      '#options' => get_role_list($cot->nid,'Yes'),
      '#default_value' => $default_cot_role,
      '#attributes' => array(
        'title' => t("Please select the role."),
        'name' => $cot->nid,
        'class' => 'cot-role-selection ' . $cot->nid . ' ' . $cot->title,
      )
    );
    
    $device_type_query = "SELECT node1.nid AS devicetype_nid, node1.title AS device_type
                        FROM node
                        JOIN content_field_device_product_line ON content_field_device_product_line.field_device_product_line_nid = node.nid
                        JOIN content_type_devicetype ON content_type_devicetype.nid = content_field_device_product_line.nid
                        AND content_field_device_product_line.vid = content_type_devicetype.vid
                        JOIN node AS node1 ON node1.nid = content_type_devicetype.nid
                        AND node1.vid = content_type_devicetype.vid
                        WHERE node.nid = '%d' and node1.status = 1"; 
  
    $device_type_result = null;

    $device_type_result = db_query($device_type_query, $cot->nid);
    $device_type_options = array();
    while ($device_type = db_fetch_object($device_type_result)) { 
      if (strpos(strtolower($device_type->device_type),'client') === false) {
        $device_type_options[$device_type->devicetype_nid] = $device_type->device_type;
      }
    }
    
    if(count($device_type_options > 0)){ 
      foreach($device_type_options as $key => $device){
        //Getting the device default value from db
        $default_device_value = get_default_device_value($register_id, $key);
        $record = new stdClass();
        $record->trainer_uid = '';
        $record->training_date = '';
        $record->certificate_file = '';
        $record->default = '0';
        //print_r($default_device_value);
        if($default_device_value){
          $record = $default_device_value;
          $record->training_date = date("m/d/Y",$default_device_value->training_date); 
          $file_url = '';
          if(isset($record->certificate_file) && $record->certificate_file != '0'){
            $file =	field_file_load($record->certificate_file, $reset = NULL); 
            if(isset($file['filename']) && $file['filename'] != ''){
              $record->certificate_file = $file['filename'] . ' ' . l('View', $file['filepath'],array(
                                                'attributes' => array(
                                                  'class' => 'training_file',
                                                  'target' => '_blank',
                                                  )
                                                ));
            }
          }
          
          $record->default = 1;
          //$acknowledge = 1;
        } 
        
        $half_class="";
        $trainers_result = get_trainer_name($key);
        $trainer_options = array(
            '' => '',
        );
        while($trainer = db_fetch_object($trainers_result)) { 
          $trainer_options[$trainer->nid] = $trainer->name;
        } 
        
        //add in class to the last two tables for styling
        if(in_array(strtolower($cot->title), $manual_cot)){
          $half_class="half-width";
          //$default_check = 1;
          //$disable_checkbox = TRUE;
          if($flag_acknowledge == FALSE){
            $form['acknowledge_wrapper']= array(
              '#type' => 'fieldset', 
              '#prefix' => '<div id="acknowledge-wrapper">',
              '#suffix' => '</div>',
              '#tree'   => TRUE,
            );/*
            if($record->default = 1 && $half_class == "half-width" && $acknowledge == 0){
              $acknowledge = 1;
            }*/
            $form['acknowledge_wrapper']['acknowledge'] = array(
              '#type' => 'checkbox',
              '#default_value' => 0, 
              '#title' => t('If this box is checked, the user requesting an account has acknowledged that he/she has read the Valleylab Exchange User Guide Training material.'),
              '#prefix' => '<a name="acknowldege-checkbox">Valleylab Exchange user guide</a>', // Add markup before form item
            );
            $flag_acknowledge = TRUE;
          }
        }
        
        
        $form['cot_category']['cot_'.$cot->nid.'_'.$cot->title][$key] = array(
          '#type' => 'fieldset', 
          '#prefix' => '<div id="' . $key . '-wrapper" class="devices-row ' . $half_class . '">',
          '#suffix' => '</div>',
          '#tree'   => TRUE,
        );
         
        $validate_cot_js = "return validate_device(id);";
        if($half_class == 'half-width') {
          $validate_cot_js = "return validate_special_vessel_devices(id);";
        }
        
        $form['cot_category']['cot_'.$cot->nid.'_'.$cot->title][$key]['devices']['option_'.$key] = array(
          '#type' => 'checkbox', 
          '#title' => $device, 
          '#default_value' => $record->default,
          //'#disabled' => $disable_checkbox,
          '#attributes' => array(
            'title' => t("Please select the device type."),
            'class' =>  $half_class,
            'onchange' => $validate_cot_js,
          )
        );
         
        //Do not generate training date, trainer, or file upload field when the cot is vessel sealing or ablation
        if(!in_array(strtolower($cot->title), $manual_cot)){
      
          $form['cot_category']['cot_'.$cot->nid.'_'.$cot->title][$key]['trainer']['trainer'.$key] = array( 
            '#type' => 'select', 
            '#options' => $trainer_options,
            '#default_value' => $record->trainer_uid,
            '#attributes' => array(
              'title' => t("Please select the trainer for this device."),
            )
          );

          //Date popup is having issue when adding in dynamic file https://www.drupal.org/node/797742#comment-3036010
          $form['cot_category']['cot_'.$cot->nid.'_'.$cot->title][$key]['training_date']['training_date'.$key] = array(
            '#type' => 'textfield', 
            '#size' => '10',   
            '#default_value' => $record->training_date,
            '#attributes' => array(
              'title' => t("Please enter in the training date with mm/dd/yyyy format."),
              //'onblur' => "return checkDate(id);",
              'class' => 'training-date-picker',
              'readonly' => 'readonly',
            ), 
          );  
        }
        //Show upload option only if cot is compression
        /**/ 
        if($cot->nid == 25 || strtolower($cot->title) == 'compression'){
          $form['cot_category']['cot_'.$cot->nid.'_'.$cot->title][$key]['files']['trainning_certificate']['file'.$key] = array(
            '#value' => $record->certificate_file,
          );   
        } 
      }

    }
     
    }
    
    $view_only_class = '';  
    if($user->uid && $user->uid != 1){ 
      if(strtolower($temp_user['approving_user']) != strtolower($user->mail)){ 
        $view_only_class = 'non_active_blue not-active';
      } 
    } 
     
    $form['deny'] = array(
      '#type' => 'submit',
      '#value' => 'Deny',
      '#attributes' => array(
        'title' => t("Click here to deny the user."),
        'class' => $view_only_class
      )
    ); 
    $form['save'] = array(
      '#type' => 'submit',
      '#value' => 'Save',
      '#attributes' => array(
        'title' => t("Click here to save the user information."),
        'class' => $view_only_class
      )
    ); 
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => 'Approve',
      '#attributes' => array(
        'title' => t("Click here to create new user from the informations in this page."),
        'class' => $view_only_class
      )
    ); 
    $form['#submit'][0] = 'approving_form_submit';  
  } else { 
    drupal_add_js('alert("Your approval link is INVALID. You will now get redirect to portal page.");window.location.href = "' . $base_url . '";', 'inline');     
  }  
  
  return $form; 
}
   
function approving_form_submit($form, &$form_state) { 
  global $base_url; 
  if($form_state['clicked_button']['#value'] == "Deny"){
     deny_user(arg(2)); 
     $user = $form['#register_user'];
     $user_name = $user['first_name'] . ' ' . $user['last_name'];
     $email = $user['email']; 
    //Send out email to register user
     $to = $email; // to e-mail address 
     $from = "noreply@covidien.com"; // from e-mail address
     $subject = "Sorry! Your registration to " . $base_url . " the Covidien Device Management portal has been rejected."; // subject of e-mail
     //$body = "Sorry " . $user_name . ", your account has been denied."; //it might be any variable from the form eg. $form_state['values']['your_field']
     //params is the array passed to hook_mail function
     $body = "Dear " . $user_name . ",\n\nSorry! Your registration to " 
             . $base_url . " the Covidien Device Management portal has been rejected.\n\n " 
             . "Thank you,\n Covidien Admin ";
     $params = array(
        'subject' => $subject,
        'body' => $body,
        );
     drupal_mail('covidien_user_registration', 'self_register', $to, language_default(), $params, $from);

     $redirect = 'covidien/self/complete/Denied';
     drupal_goto($redirect); 
  } elseif($form_state['clicked_button']['#value'] == "Save"){
    $temporary_url = '';
    $customer_name = '';
    $customer_account = '';
    $cov_user = 0; 
    $device_access = 1; 
    if($form_state['values']['cov_user_app'] == 1){
      $cov_user = 1;
      $device_access = 2;
    } else {
      $customer_name = $form_state['values']['customer_name'];
      $customer_account = $form_state['values']['customer_account']; 
    } 
          
    $sql = "UPDATE {registrant} SET 
            is_covidien_user = %d, 
            customer_name = '%s',
            account_number = '%s'
            WHERE id = %d;";
    db_query($sql,$cov_user,$customer_name,$customer_account, $form['#register_user']['id']); 
    
    $new_cot_and_role_list = array();
    $new_cot_and_devices_list = array();
    $old_cot_and_devices_list = get_old_training_records($form['#register_user']['id']);
    
    foreach($form_state['values']['cot_category'] as $key => $cot) {
      $cot_nid = explode('_', $key);
       
      //Getting Cot and Role id together in one array
      $new_cot_and_role_list[$cot_nid[1]] = $form_state['values']['role_' . $cot_nid[1]];
      
      //Loop through new devices list
      foreach($cot as $device_id => $training_record){
        $record = new stdClass();
        $record->option = '';
        $record->trainer = '';
        $record->training_date = '';
        if($training_record['devices']['option_' . $device_id] == 1){
          $record->option = $training_record['devices']['option_' . $device_id];
          $record->trainer = $training_record['trainer']['trainer' . $device_id];
          //06/13/2000
          $record->training_date = $training_record['training_date']['training_date' . $device_id];
          $new_cot_and_devices_list[$cot_nid[1]][$device_id] = $record;
        }
      }
    }  
    //Query for old Cot and Role
    $old_cot_and_roles_list = array();
    $query_old_cot_and_roles = "SELECT id, cot, role FROM {registrant_cot}
                                where registrant_id = %d";
    $result_roles = db_query($query_old_cot_and_roles, $form['#register_user']['id'] );
    while ($object = db_fetch_object($result_roles)) {
      $old_cot_and_roles_list[$object->cot] = $object;
    }
    /*
    //Update, Insert, and Delete 
    */
    $default_approving_manager = variable_get ( 'default_approving_manager', '' );
    foreach($new_cot_and_devices_list as $cot_id => $devices_array){
      //if new cot is in the database, then do update 
      if(array_key_exists($cot_id, $old_cot_and_roles_list)){
      //if(isset($old_cot_and_roles_list[$cot_id])){ 
         $sql = "UPDATE {registrant_cot} SET 
                  role = %d
                  WHERE registrant_id = %d
                  AND cot = %d;"; 
         db_query($sql,$new_cot_and_role_list[$cot_id], $form['#register_user']['id'], $cot_id ); 
         //Need to update the training record right after this. 
         //this for loop is for update and insert new device
         
         foreach($devices_array as $device_id => $device_object){
           
           if(array_key_exists($device_id, $old_cot_and_devices_list[$cot_id])){
             //if having the same device, then just update
             $sql = "UPDATE {registrant_training} SET  
                    trainer_uid = %d,
                    training_date = %d,
                    device_access = %d
                    WHERE device_type = %d
                    AND registrant_id = %d;";
             $training_date = '';  
             
             if($device_object->trainer == '' && $default_approving_manager == ''){
               $sql_query_for_trainer = "SELECT nid
                                         FROM node
                                         WHERE title = 'gwagent.admin@covidien.com'
                                         AND TYPE = 'person'";
               $single_trainer_result = db_query($sql_query_for_trainer);
               $trainer_object = db_fetch_object($single_trainer_result);
               $device_object->trainer = $trainer_object->nid;
               variable_set ( 'default_approving_manager', $trainer_object->nid );
             } elseif($device_object->trainer == '' && $default_approving_manager != ''){ 
               $device_object->trainer = $default_approving_manager;
             }
             
             if(isset($device_object->training_date) && $device_object->training_date != ''){
               $training_date = convert_date(exchange_date_format($device_object->training_date)); 
             } else { 
               $training_date = convert_date(gmdate('Y-m-d', time()));
             }   
             db_query($sql,$device_object->trainer,$training_date,$device_access,$device_id, $form['#register_user']['id']); 
         
             
           } else { 
             //if the new device list is not in old device list, then do insert new device
             //This is happend when COT is exist in cot database, not happend on branch new cot
             $training_item = new stdClass;
             $training_item->registrant_id = $form['#register_user']['id'];
             $training_item->registrant_cot_id = $old_cot_and_roles_list[$cot_id]->id;
             $training_item->device_type = $device_id;
             $training_item->trainer_uid = $device_object->trainer;
             
             if($training_item->trainer_uid == '' && $default_approving_manager == ''){
               $sql_query_for_trainer = "SELECT nid
                                         FROM node
                                         WHERE title = 'gwagent.admin@covidien.com'
                                         AND TYPE = 'person'";
               $single_trainer_result = db_query($sql_query_for_trainer);
               $trainer_object = db_fetch_object($single_trainer_result);
               $training_item->trainer_uid = $trainer_object->nid;
               variable_set ( 'default_approving_manager', $trainer_object->nid );
             } elseif($training_item->trainer_uid == '' && $default_approving_manager != ''){ 
               $training_item->trainer_uid = $default_approving_manager;
             }
             
             $training_date = '';
             if(isset($device_object->training_date) && $device_object->training_date != ''){
               $training_date = convert_date(exchange_date_format($device_object->training_date)); 
             } else { 
               $training_date = convert_date(gmdate('Y-m-d', time()));
             } 
             $training_item->training_date = $training_date;
             $file_id = '';
             
             $training_item->certificate_file = $file_id;
             $training_item->device_access = $device_access;
             try {
               drupal_write_record('registrant_training', $training_item);
             } catch (Exception $e) {
               echo 'Caught exception: ',  $e->getMessage(), "\n";
             }
           }
           
         } //END UPDATE AND INSERT NEW TRAINING RECORD WITH EXISTING COT;
         
         //This for loop is to remove old device IF COT IS NOT SELECTED
         
         foreach($old_cot_and_devices_list as $cot_key => $cot_device_objects){
           //if the old cot is not in the old cot, then remove the training records
           
           if(!array_key_exists($cot_key, $new_cot_and_devices_list)){
              //do the deletion 
             foreach($cot_device_objects as $device_key => $object){
              $sql = "DELETE FROM {registrant_training} 
                      WHERE registrant_id = %d
                      AND device_type = %d;";
               db_query($sql, $form['#register_user']['id'], $device_key ); 
             }
            } else {
              foreach($cot_device_objects as $id => $object){ 
                if(!array_key_exists($id, $new_cot_and_devices_list[$cot_key])){
                  $sql = "DELETE FROM {registrant_training} 
                      WHERE registrant_id = %d
                      AND device_type = %d;";
                  db_query($sql, $form['#register_user']['id'], $id );
                }
              }
            }
         }
          
      } else { 
        //if new cot is not in the old database, then do insert
        $registrant_cot = new stdClass;
        $registrant_cot->registrant_id = $form['#register_user']['id'];
        $registrant_cot->cot = $cot_id; 
        $registrant_cot->role = $new_cot_and_role_list[$cot_id];  
        try {
          drupal_write_record('registrant_cot', $registrant_cot);
        } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        //This happend when branch new cot is insert along with new devices
        foreach($new_cot_and_devices_list[$cot_id] as $device_id => $device_object){
          $training_item = new stdClass;
          $training_item->registrant_id = $form['#register_user']['id'];
          $training_item->registrant_cot_id = $registrant_cot->id;
          $training_item->device_type = $device_id;
          $training_item->trainer_uid = $device_object->trainer;
         
          if($training_item->trainer_uid == '' && $default_approving_manager == ''){
            $sql_query_for_trainer = "SELECT nid
                                      FROM node
                                      WHERE title = 'gwagent.admin@covidien.com'
                                      AND TYPE = 'person'";
            $single_trainer_result = db_query($sql_query_for_trainer);
            $trainer_object = db_fetch_object($single_trainer_result);
            $training_item->trainer_uid = $trainer_object->nid;
            variable_set ( 'default_approving_manager', $trainer_object->nid );
          } elseif($training_item->trainer_uid == '' && $default_approving_manager != ''){
            $training_item->trainer_uid = $default_approving_manager;
          }
          
          $training_date = '';
          if(isset($device_object->training_date) && $device_object->training_date != ''){
           $training_date = convert_date(exchange_date_format($device_object->training_date)); 
          } else { 
           $training_date = convert_date(gmdate('Y-m-d', time()));
          } 
          $training_item->training_date = $training_date;
          $file_id = '';

          $training_item->certificate_file = $file_id;
          $training_item->device_access = $device_access;
          try {
           drupal_write_record('registrant_training', $training_item);
          } catch (Exception $e) {
           echo 'Caught exception: ',  $e->getMessage(), "\n";
          }
        }
        //Need to insert in the training record right after this
      }
    }
    
    //if the old cot is not in new cot array list, then do delete
    foreach($old_cot_and_roles_list as $cot_id => $role_id){
      if(!array_key_exists($cot_id, $new_cot_and_devices_list)){
        //do the deletion
        $sql = "DELETE FROM {registrant_cot} 
                WHERE registrant_id = %d
                AND cot = %d;";
         db_query($sql, $form['#register_user']['id'], $cot_id );  
         //Need to remove old training record right after this.
      }
    }
     
    drupal_set_message(t('Settings have been saved successfully.')); 
     
  } else {
    //Accept new user
    global $user,$base_url;
  
    $cov_user = '';
    $customer_name = '';
    $customer_account = '';
    
    if($form_state['values']['cov_user_app'] == 1){
      $cov_user = 1; 
    } else {
      $customer_name = $form_state['values']['customer_name'];
      $customer_account = $form_state['values']['customer_account']; 
    } 
    
    //Check Customer name to see if we need to generate a new one or not
    $existed_customer = get_customer_name_by_title($customer_name);
    if($existed_customer == '' && $cov_user != 1){
      
      //query for the last one
      $sql_query = "SELECT field_bu_customer_account_number_value as account
                    FROM {content_type_bu_customer}
                    WHERE field_bu_customer_account_number_value like ('%DMP%') 
                    AND field_bu_customer_account_number_value not like ('%DMP-CA-%') 
                    ORDER BY nid DESC
                    LIMIT 0 , 1";
      $unquie_account = db_query($sql_query);  
      $current_account = db_fetch_object($unquie_account);
      if($current_account){
        $split_account = explode('-', $current_account->account); 
        $num = sprintf('%05d', $split_account[1] + 1); 
        $customer_account = "DMP-" . $num;
      } else {
        $customer_account = "DMP-00001";//first account
      } 
      //Generate Customer Name and Account Type for Unknown Customer
      $party = new stdClass(); 
      $party->type = 'party'; 
      $party->uid = 1;
      $party->status = 1; 
      $party->title = $customer_name;
      $party->field_party_type[0]['nid'] = '11'; //11 is for business customer type
      $party = node_submit($party);
      node_save($party); 

      //create Customer account DMP-99999 
      $customer = new stdClass(); 
      $customer->type = 'bu_customer'; 
      $customer->uid = 1;
      $customer->status = 1; 
      $customer->title = $customer_account;
      $customer->field_bu_customer_account_number[0]['value'] = $customer_account;
      $customer->field_customer_party_pk[0]['nid'] = $party->nid;
      $customer = node_submit($customer);
      node_save($customer); 
    }
    

    //Active code is the md5 of registrant id and email
    $active_code = md5($form['#register_user']['first_name'].$form['#register_user']['email']);
    $date = convert_date(gmdate('Y-m-d', time()));
    $sql = "UPDATE {registrant} SET status = 'completed',
            approve_result = 'approved',
            approved_date = %d
            WHERE id = %d;";
    db_query($sql,$date, $form['#register_user']['id']); 
    
    //Remove after email generate is completed
    $temporary_url .= $form['#register_user']['id'] . '/' . $active_code . '/' . $form['#register_user']['email'];
     
    //drupal_set_message(t('Settings have been saved successfully.')); 
    
    $redirect = 'covidien/self/complete/Accepted/'.$temporary_url;
    
    $user_name = $form['#register_user']['first_name'] . ' ' . $form['#register_user']['last_name'];
    $email = $form['#register_user']['email'];

    //Send out email to register user
    $to = $email; // to e-mail address
    $from = "noreply@covidien.com"; // from e-mail address
    $subject = "Your account has been accepted"; // subject of e-mail
    /*$body = "Congratulations " . $user_name . ", your account has been accepted. 
             Please go to this link to reset your password. " . 
             $base_url . "/self/reset_password/" . $form['#register_user']['id'] . '/' . $active_code . '/' . $form['#register_user']['email']; 
    */
    $body = "Dear " . $user_name . ",\n\nCongratulations! You have approved to " 
            . $base_url . " the Covidien Device Management portal.\nPlease click the following link to reset your password. " 
            . $base_url . "/self/reset_password/" . $form['#register_user']['id'] . '/' . $active_code . '/' . $form['#register_user']['email'] 
            . ".\nIf you not reset your password, you cannot access GDMP.\n\n"
            . "Thank you,\n Covidien Admin";
    $params = array(
    'subject' => $subject,
    'body' => $body,
    );
    drupal_mail('covidien_user_registration', 'self_register', $to, language_default(), $params, $from);
 

    drupal_goto($redirect);
  } 
} 
    
function deny_user($user_id){  
  try {  
    $date = convert_date(gmdate('Y-m-d', time()));
    $sql = "UPDATE {registrant} SET status = 'completed',
            approve_result = 'denied',
            approved_date = %d 
            WHERE id = %d;";
    db_query($sql,$date, $user_id); 
    
    drupal_set_message(t('Settings have been saved successfully.')); 
    
  } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
}

/*
 * Pass in register user id and cot nid
 * return : role id
 */
function get_default_role_from_cot($register_id,$cot_id){ 
  $sql = "SELECT *
          FROM {registrant_cot}
          WHERE registrant_id = %d
          AND cot = %d";
  $cot_role = db_query($sql,$register_id, $cot_id);  
  $role = db_fetch_object($cot_role); 
  return $role->role;
}

/**
 * Pass in: register ID and Device ID
 * Return training record
 */
function get_default_device_value($register_id, $device_id){
  
  $sql = "SELECT *
          FROM {registrant_training}
          WHERE registrant_id = %d
          AND device_type = %d";
  $training_record = db_query($sql,$register_id, $device_id);  
  $record = db_fetch_object($training_record);
  return $record;
}

/**
 *
 * @param type $register_id 
 * @return device id for traning record
 */
function get_old_training_records($register_id){
  $query = "SELECT registrant_cot.cot, registrant_training.device_type
            FROM {registrant_training}
            LEFT JOIN {registrant_cot} ON registrant_cot.id = registrant_training.registrant_cot_id
            WHERE registrant_training.registrant_id = %d";
  $result_devices = db_query($query, $register_id );
  $old_device_list = array();
  while ($object = db_fetch_object($result_devices)) {
    $old_device_list[$object->cot][$object->device_type] = $object;
  } 
  return $old_device_list;
}
