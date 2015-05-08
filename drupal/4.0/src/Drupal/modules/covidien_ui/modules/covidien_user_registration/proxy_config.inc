<?php 
function proxy_config_form(&$form_state) { 
  
  //after form reloaded, show up the current selected from previous page
  $cot_default_value = '';
  if($form_state['values']['class_of_trade'] != ''){
    $cot_default_value = $form_state['values']['class_of_trade'];
  }
   
  $form = array();
   
  ahah_helper_register($form, $form_state); 
    
  $class_of_trade_options = array(); 
  
  //Get class of trade
  $class_of_trades = getadminproductline();
  $x = 0;
  while ($class = db_fetch_object($class_of_trades)) {
    if($x == 0 && $cot_default_value == ''){
      $cot_default_value = $class->nid;
      $x++;
    }
    $class_of_trade_options[$class->nid] = $class->title;
	}
   
  $form['#ajax'] = array('enabled' => TRUE);
    
 
  $form['class_of_trade'] = array(
    '#type' => 'select',
    '#title' => t('Class of Trade(COT)'),
    '#options' => $class_of_trade_options, 
    '#default_value' => $cot_default_value,  	 
    '#attributes' => array(
      'title' => t("Please select the class of trade."),
      'onchange' => "get_proxy(this);",
    )
  );    
  
  //Get Proxy email base on $cot_default_value;
  $default_proxy_query = get_proxy($cot_default_value);
  $default_proxy_value = '';
  while ($proxy = db_fetch_object($default_proxy_query)) { 
    $default_proxy_value = $proxy->proxy;
	}
  
  $form['proxy_email'] = array(
    '#title' => 'Proxy',
    '#type' => 'textfield',
    '#size' => '256',
    '#default_value' => $default_proxy_value,
    '#required' => TRUE,
    '#id' => 'proxy', 
    '#attributes' => array(
      'title' => t("Please enter in the proxy email address."), 
      'onchange' => "validateCovidienEmail(this);",
    )
  );
 
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save',
    '#attributes' => array(
      'title' => t("Click here to save."),
    )
  ); 
  $form['#submit'][0] = 'proxy_config_form_submit';  
  
  return $form; 
}
  
function proxy_config_form_submit($form, &$form_state) {  
  $proxy = $form_state['values']['proxy_email'];
  $cot_id = $form_state['values']['class_of_trade'];
  try { 
    $sql = "update {content_type_product_line} set proxy = '%s' where nid = %d";
    db_query($sql,$proxy,$cot_id);
    drupal_set_message(t('Settings have been saved successfully.')); 
    
  } catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
} 
    
/**
 *
 * @param type $nid cot nid
 * @return type object return from query
 */        
function get_proxy($nid) {
  $query = "SELECT proxy
            FROM {content_type_product_line}
            WHERE nid = %d";
  return db_query($query,$nid);
} 