<?php 
function self_registration_form(&$form_state) { 
 
 
  $form = array(); 
  $format = 'm/d/Y';
  //10/30 keep class of trade value to use later in device type
  ahah_helper_register($form, $form_state);
  //print('hi');
  $cot_default_value = 23;
  if (!isset($form_state['storage']['cot']['class_of_trade'])) {
    $cot_default_value = 23;
  }
  else { 
    $cot_default_value =  $form_state['storage']['cot']['class_of_trade'];
  }
  //End COT and Devices
  //covidien_user
  $default_user = 1;
  if (!isset($form_state['values']['cov_user'])) {
    $default_user = 1;
  }
  else {
    $default_user =  $form_state['values']['cov_user'];
  }
  
  $customer_name = '';
  $customer_account = '';
  if(!isset($form_state['storage']['covidien_user']['customer_account_wrapper']['customer_name'])){
    $customer_name = '';
  } else {
     $customer_name = $form_state['storage']['covidien_user']['customer_account_wrapper']['customer_name']; 
     $customer_account = get_customer_account($customer_name); 
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
  
  $form['first_name'] = array(
    '#title' => 'First name',
    '#type' => 'textfield',
    '#size' => '30',
    '#required' => TRUE,
    '#attributes' => array(
      'title' => t("Please enter in your first name."),
    )
  );

  $form['last_name'] = array(
    '#title' => 'Last name',
    '#type' => 'textfield',
    '#size' => '30',
    '#required' => TRUE,
    '#attributes' => array(
      'title' => t("Please enter in your last name."),
    )
  );

  $form['email'] = array(
    '#title' => 'Email',
    '#type' => 'textfield',
    '#size' => '30',
    '#required' => TRUE,
    '#attributes' => array(
      'title' => t("Please enter in your email address."),
      'onblur' => "checkEmail();",
    )
  );
  $form['confirm_email'] = array(
    '#title' => 'Confirm Email',
    '#type' => 'textfield',
    '#size' => '30',
    '#required' => TRUE,
    '#attributes' => array(
      'title' => t("Please confirm your email address."),
      'onblur' => "checkEmail();",
    )
  );
  $form['phone'] = array(
    '#title' => 'Phone',
    '#type' => 'textfield',
    '#size' => '30',
    '#required' => TRUE,
    '#attributes' => array(
      'title' => t("Please enter in your phone number."),
      'onkeypress' => "return isNumberKey(event);",
    )
  );
  $form['country'] = array(
    '#type' => 'select',
    '#title' => t('Country'), 
    '#options' => $country_options,
    '#required' => TRUE,
    '#attributes' => array(
      'title' => t("Please select your country."),
    )
  ); 
  /*
  $form['language'] = array(
    '#type' => 'select',
    '#title' => t('Language'), 
    '#options' => $language_options,
    '#required' => TRUE,
    '#attributes' => array(
      'title' => t("Please select your language."),
    )
  );
   */
  $form['cov_user'] = array(
    '#type' => 'checkbox',
    '#title' => t('I am Covidien Employee'),
    '#default_value' => $default_user, 
    '#attributes' => array(
      'title' => t("Are you a Covidien Employee?"),
    )
      
  );  
  
  $form['customer_name'] = array(
    '#title' => 'Customer Name',
    '#type' => 'textfield',
    '#size' => '100',
    '#autocomplete_path' => 'self/customer_name_autocomplete',
    '#description' => "Type a few letters to display a pick list of known Covidien customers. If you do not see your facility listed, type in the entire name.",
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
      'onblur' => "validate_manager_account(this);",
    )
  ); 
  /**/
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
  
  foreach ($all_cot as $index => $cot) {
    //$class_of_trade_options[$class->nid] = $class->title;
    //print_r($cot);
    //Get role for each COT
    $form['cot_category_role']['cot_'.$cot->nid.'_'.$cot->title]['role_'.$cot->nid] = array(
      '#type' => 'select',
      '#id' => $cot->nid,
      '#title' => t('Role'),
      '#options' => get_role_list($cot->nid,'Yes'),
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
        $half_class="";
        //$default_check = 0;
        //$disable_checkbox = FALSE;
        //Get trainer base on device id
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
            );
            $form['acknowledge_wrapper']['acknowledge'] = array(
              '#type' => 'checkbox',
              //'#default_value' => 1,
              '#title' => t('Acknowledge User Guide Training Material'),
              '#prefix' => '<a name="acknowldege-checkbox" href="http://www.covidien.com/valleylabexchange" target="_blank">Valleylab Exchange Training Material</a>', // Add markup before form item
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
          //'#default_value' => $default_check,
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
            '#attributes' => array(
              'title' => t("Please select the trainer for this device."),
            )
          );

          //Date popup is having issue when adding in dynamic file https://www.drupal.org/node/797742#comment-3036010
          $form['cot_category']['cot_'.$cot->nid.'_'.$cot->title][$key]['training_date']['training_date'.$key] = array(
            '#type' => 'date_popup', 
            '#size' => '10',  
            '#date_format' => $format,
            '#attributes' => array(
              'title' => t("Click the calendar to select the date."),
              'onClose' => "return checkDate(id);",
              'class' => 'training-date-picker',
              'readonly' => 'readonly',
            ), 
          );  
        }
        //Show upload option only if cot is compression
        /**/
        if($cot->nid == 25 || strtolower($cot->title) == 'compression'){
          $form['cot_category']['cot_'.$cot->nid.'_'.$cot->title][$key]['files']['trainning_certificate']['file'.$key] = array(
            '#type' => 'file',  
            '#attributes' => array(
               'title' => t("Please enter in the account number."), 
               'onchange' => "return validateFileExtension(this);",
            ),
            '#name' => 'files[]', 
          );   
        } 
      }

    }
    
    /*
    
    $form['cot_category']['cot_'.$class->nid] = array(
        '#type' => 'textfield', 
        '#size' => '10',  
        '#attributes' => array(
          'title' => t("Please enter in the training date with mm/dd/yyyy format."),
          'onblur' => "return checkDate(id);",
        ), 
      ); */
	}
   
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Register',
    '#attributes' => array(
      'title' => t("Click here to register."),
    )
  ); 
  $form['#submit'][0] = 'self_registration_form_submit';  
  
  return $form; 
}

function self_registration_form_submit($form, &$form_state) {
  //print_r($form_state['values']);//die;
  global $base_url; 
 
  //Saving files
  $num_files = count($_FILES['files']['name']);
  $x = 0;
  $validators = array();
  $dest = 'trainning'; 
  for($x = 0; $x < $num_files; $x++){ 
    $file = file_save_upload($x, $validators, $dest);
    if ($file != 0) {
      $form_state['storage']['uploaded_files'][$x] = $file->fid; 
      drupal_set_message(t('Successfully uploaded the file.'));
      watchdog('debug form file', print_r($file, 1));
    } else {
      form_set_error('self_registration_form', t("Failed to save the file."));
      watchdog('debug form', print_r($file, 1));
    } 
  }
  
  $is_covidien_user = 0;
  $customer_name = '';
  $customer_account = '';
  $approving_manager = $form_state['values']['approving_manager'];
  
  if($form_state['values']['cov_user'] == 1){
    $is_covidien_user = 1;
  } else {
    $customer_name = $form_state['values']['customer_name'];
    $customer_account = $form_state['values']['customer_account'];
    //By Business rule, if the user is non-covidien, then use the first cot proxy as approving manager
    //Need to update the approving manager later on base on the first cot
    $approving_manager = '';
  }
   
  //Getting US English nid
  //get list of all countries and language
  $default_language = '';
  $query = "SELECT nid
            FROM node
            WHERE TYPE = 'language'
            AND title LIKE ('%US English%')
            ORDER BY title ASC
            LIMIT 0 , 1";
  $result = db_query($query);
  while ($object = db_fetch_object($result)) {
    $default_language = $object->nid;
  } 
     
  $cov_facility = '';
  $user = new stdClass;
  $user->first_name = $form_state['values']['first_name'];
  $user->last_name = $form_state['values']['last_name'];
  $user->email = $form_state['values']['email'];
  $user->phone_number = $form_state['values']['phone'];
  $user->is_covidien_user = $is_covidien_user;
  $user->country = $form_state['values']['country'];
  $user->language = $default_language; //need to be us english
  //$user->cot = $form_state['values']['cot']['class_of_trade'];
  //$user->role = $form_state['values']['cot']['role']; 
  $user->customer_name = $customer_name;
  $cov_facility = $customer_name;
  $user->account_number = $customer_account;
  //Customer Exist, update this field after user got approved
  $user->customer_exist = '';// $form_state['values']['customer_exist']; 
  $user->create_time =  convert_date(gmdate('Y-m-d', time()));
  $user->status = 'pending';
  $user->approve_result = 'pending';
  $user->approving_user = $approving_manager;
  $user->approved_date =  '';
  $user->user_id = '';// $form_state['values']['user_id'];
  $user->active_code = md5($user->first_name.$user->email);
  try {
    drupal_write_record('registrant', $user);
  } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
  
  //Write cot and role to registrant_cot table
  //Tracking role for two COT
  $track_role = 0;
  foreach($form_state['values']['cot_category'] as $key => $cot) {
    $devices_list = array();
    $cot_nid = explode('_', $key);//value at index 1 is the cot number
    //Track role for Vessel and Abalation, they should have the same role assign 
    if($track_role == 0){
      $track_role = $form_state['values']['role_'.$cot_nid[1]]; 
    } 
    foreach($cot as $device_num_key => $device) {
      //break the loop if the last two COT is not checked 
      if($form_state['values']['acknowledge_wrapper']['acknowledge'] == 0 && !isset($form_state['values']['cot_category'][$key][$device_num_key]['training_date'])) {
        break;
      }
      //if device is checked 
      if($device['devices']['option_'.$device_num_key] == 1){ 
        //Need to get the first COT Proxy
        if($form_state['values']['cov_user'] != 1 && $approving_manager == ''){
          $result = db_query("SELECT proxy
                        FROM {content_type_product_line}
                        WHERE nid = %d", $cot_nid[1]);
     
          while ($data = db_fetch_object($result)) { 
            if($data){
              $approving_manager = $data->proxy;
            }  
          }  
          //Update approving manager with proxy first cot that have the device selected
          $sql = "UPDATE {registrant} SET 
                  approving_user = '%s'
                  WHERE id = %d;";
          db_query($sql, $approving_manager, $user->id);
        }
        
        $object = new stdClass();
        $object->cot = $cot_nid[1];
        $object->device_id = $device_num_key;
        $object->trainer = $device['trainer']['trainer'.$device_num_key];
        if($object->trainer == ''){
          $sql_query_for_trainer = "SELECT nid
                                    FROM node
                                    WHERE title = 'gwagent.admin@covidien.com'
                                    AND TYPE = 'person'";
          $single_trainer_result = db_query($sql_query_for_trainer);
          $trainer_object = db_fetch_object($single_trainer_result);
          $object->trainer = $trainer_object->nid;
        }
        $object->training_date = $device['training_date']['training_date'.$device_num_key];
        $devices_list[] = $object; //store checked device into device list and later save to db
      
      }
    } 
    
    //if the cot have any device, then save to db, else do not save
    
    if(count($devices_list) > 0) {
      //Save COT and Role to db 
      $registrant_cot = new stdClass;
      $registrant_cot->registrant_id = $user->id;
      $registrant_cot->cot = $cot_nid[1];
      //NOTE: for Vessel and Abalation, the role are the same for both cot base on what user selected
      $assign_role = '';
      if($form_state['values']['role_'.$cot_nid[1]] == ''){ 
        //QUERY NEED TO FIND THE SIMILAR ROLE
        $query = 'select field_role_product_line_nid as cot, field_roles_description_value as role'
          . ' from {content_type_roles} '
          . ' where nid = %d';
        $result = db_query($query, $track_role);
        $result_object = db_fetch_object($result);
        //use the role name to get the role for Abalation 
        $query_match_role = "select nid"
          . " from {content_type_roles} "
          . " where field_role_product_line_nid = %d and field_roles_description_value = '%s'";
        $result_role_id = db_query($query_match_role, $result_object->cot,$result_object->role);
        $result_role_id = db_fetch_object($result_role_id); 
        $assign_role = $result_role_id->nid;
      } else {
        $assign_role = $form_state['values']['role_'.$cot_nid[1]];
      } 
      $registrant_cot->role = $assign_role; 

      try {
        drupal_write_record('registrant_cot', $registrant_cot);
      } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
      
      //Save traning record to db
      $counter = 0;
      foreach($devices_list as $item){   
        $training_item = new stdClass;
        $training_item->registrant_id = $user->id;
        $training_item->registrant_cot_id = $registrant_cot->id;
        $training_item->device_type = $item->device_id;
        $training_item->trainer_uid = $item->trainer;
        $training_date = '';
        if(isset($item->training_date) && $item->training_date != ''){
          $training_date = convert_date($item->training_date); 
        } else { 
          $training_date = convert_date(gmdate('Y-m-d', time()));
        } 
        $training_item->training_date = $training_date;
        $file_id = '';
        if(($cot_nid[1] == '25') && (isset($form_state['storage']['uploaded_files']) && count($form_state['storage']['uploaded_files']) > 0)){
          $file_id = $form_state['storage']['uploaded_files'][$counter];
          $counter++;
        }
        $training_item->certificate_file = $file_id;
        $device_access = 1;
        if($is_covidien_user == 1){
          $device_access = 2;
        }
        $training_item->device_access = $device_access;
        try {
          drupal_write_record('registrant_training', $training_item);
        } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
      }
    } 
  }
 
  $user_name = $user->first_name . ' ' . $user->last_name;
  $email = $user->email;
  
  if(empty($customer_name)){
    $customer_name = $user_name;
  }
  //Send out email to register user
  $to = $email; // to e-mail address
  $from = "noreply@covidien.com"; // from e-mail address
  $subject = "Self Registration account status"; // subject of e-mail
  //$body = "Congratulations " . $user_name . ", your account is now pending for approval."; //it might be any variable from the form eg. $form_state['values']['your_field']
  
  $body = "Dear " . $user_name . ",\n\nCongratulations! You have register to " 
          . $base_url . " the Covidien Device Management portal.\nYour approving manager is: " . $approving_manager 
          . "\nYou will receive notification if your registration is approved.\n\n Thank you,\n Covidien Admin";
  
//params is the array passed to hook_mail function
  $params = array(
      'subject' => $subject,
      'body' => $body,
      );
  drupal_mail('covidien_user_registration', 'self_register', $to, language_default(), $params, $from);
  
  //Send out email to Approving manager/proxy
  //Validate the approving manager/proxy first before sending out the email.
  
  $to_manager = $approving_manager;
  $to_manager_subject = "New registrant is waiting for your approval";
  
  $approving_url = $base_url . '/self/approving/' . $user->id . '/' . $user->active_code;
  $to_manager_body = "Dear " . $approving_manager . ",\n\nYou have received this email because you have been identified as an approving manager" 
                      . " for one of the following applications hosted by the Covidien Device Management Portal."
                      . " \n\n"
                      . "Valleylab Exchange\n"
                      . "SCD Updater\n"
                      . "Enhanced Service Software"
                      . " \n\n"
                      . "Further action is required by you."
                      . "\n\n"
                      . "A new user (" . $customer_name . ") has requested a login to the Covidien Device Management portal (" . $base_url . ")"
                      . " so that he/she may perform the functions associated with the aforementioned applications. \n\nPlease click the link below to view additional information and to approve or deny the request: \n\n" 
                      . $approving_url
                      . "\n\n"
                      . "You may receive follow-up emails until this is resolved."
                      . " \n\nThank you,\nCovidien Admin ";
  $to_manager_params = array(
      'subject' => $to_manager_subject,
      'body' => $to_manager_body,
    );  
  drupal_mail('covidien_user_registration', 'self_register', $to_manager, language_default(), $to_manager_params, $from);
  
   
  $redirect = 'self/complete/' . $user_name . '/' . $email;
  drupal_goto($redirect); 
} 
  
function get_business_unit($party_type) {
  $query = "SELECT n.nid, n.title FROM node n 
            JOIN content_type_party p ON p.nid = n.nid 
            JOIN node pt ON p.field_party_type_nid = pt.nid
            WHERE n.type='%s' AND pt.title = '%s'";
  $result = db_query($query, 'party', $party_type);
  $rows = array();
  while ($row = db_fetch_object($result)) { 
    $rows[$row->nid] = $row->title; 
  } 
  return $rows;
}
  

