<?php



/**
 * 
   Acceptance criteria
1.  User must select the device type, and device serial number to view the report.
2.  Verify that user can optionally enter all or any combination of following fields and that the report results are filtered on the entered values:
1.  Country
2.  Region
3.  Customer Name
4.  User Assigned Facility Name
5.  Device serial number
6.  Software name and version
7.  Last dock date
3.  Verify that the report includes a row for each time a discrepancy is found or new software or firmware is installed
4.  Verify that all devices listed on the report are of selected device type
5.  Verify that device listed on the report has the selected serial number
6.  Verify that the latest record is listed at the top.
7.  Verify that all general reporting user stories are satisfied

 *
 * @param unknown_type $form
 * @return unknown
 */
function device_historical_configuration_form($form) {
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_common.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_ahah.js');
  drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
  drupal_add_js(drupal_get_path('module', 'covidien_reports') . '/js/covidien_report.js');
  $device_type_id = $_SESSION['default_dtype'];
  $form = array();
  
  $form['#action'] = url('reports/result/12');

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
    '#default_value' => $device_type_id,
  	'#value' => $device_type_id,
    '#validated' => TRUE,
    '#options' => get_device_type($_SESSION['default_cot']),
  );

  $form['ds_number'] = array(
    '#type' => 'textfield',
    '#default_value' => '',
  );
  $form['ds_number']['#autocomplete_path'] = 'covidien/reports/autocomplete';
  $form['ds_number']['#attributes'] = array(
      'onfocus' => 'parentvalues("reports");',
  );  
  /*
  $form['country'] = array(
    '#title' => t('Country'),
    '#type' => 'select',
    '#default_value' => '',
    '#validated' => TRUE,
    '#options' => get_country(),
  );

  $form['region'] = array(
    '#title' => t('Region'),
    '#type' => 'select',
    '#default_value' => '',
    '#validated' => TRUE,
    '#options' => get_region(),
  );  
  
  $form['customer_name'] = array(
    '#title' => t('Customer Name'),
    '#type' => 'textfield',
    '#default_value' => '',
  );
  $form['customer_name']['#autocomplete_path'] = 'covidien/reports/customername/autocomplete';
  $form['customer_name']['#attributes'] = array(
    'onfocus' => 'reportparentvalues("reports/customername", "edit-customer-name");',
  );
  
  $form['User Assigned Facility Name'] = array(
    '#title' => t('User Assigned Facility Name'),
    '#type' => 'textfield',
    '#default_value' => '',
  );  

  $form['software_name'] = array(
    '#title' => t('Software Name'),
    '#type' => 'textfield',
    '#default_value' => '',
  );
  
  $form['software_version'] = array(
    '#title' => t('Software Version'),
    '#type' => 'textfield',
    '#default_value' => '',
  );  
  
  $form['last_dock_date'] = array(
    '#title' => t('Last dock date'),  
    '#type' => 'date_popup',
    '#attributes' => array(),
    '#maxlength' => 10,
    '#date_format' => 'm/d/Y',
    '#date_year_range' => '-5:+6',
  );
 */
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'View Report',
  );

  return $form;
}



function device_historical_configuration_form_validate() {
  $device_type = check_plain($_POST['device_type']);
  $ds_number = check_plain($_POST['ds_number']);
  if ($device_type == 'all' || $device_type == '') {
    form_set_error('device_type', t("Invalid Device Type"));
  }
  if (!covidien_ui_input_validate($ds_number,true)) {
    form_set_error('device_type', t("Invalid Device Serial Number"));
  }
}

function device_historical_configuration_form_submit(&$form, &$form_state) {
  if (count(form_get_errors()) || !$_POST['op']) {
    return false;
  }

  /*

  $device_type =  $_POST['device_type'];
  $user_id = $_POST['user_id'];
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];

  //  Drupal goto encode the values and views filter not able to process.
  $args = array('device_type' => $device_type, 'user_id' => $user_id , 'from_date' => $from_date['date']  ,'to_date' =>$to_date['date'] );
  drupal_goto('reports/result/10', $args);

  */

  //  global $base_url ;
  //  header('location:' . $base_url . '/reports/result/10');
  //  exit;

}

function template_preprocess_device_historical_configuration_form(&$vars, $hook) {

  drupal_set_title(t('Device Historical Configuration Report'));
  $vars['title'] = t('Select Report and Set Report Parameters');
  $vars['device_type'] = drupal_render($vars['form']['device_type']);
  $vars['product_line'] = drupal_render($vars['form']['product_line']);
  $vars['ds_number'] = drupal_render($vars['form']['ds_number']);
  $vars['region'] = drupal_render($vars['form']['region']);
  $vars['customer_name'] = drupal_render($vars['form']['customer_name']);
  $vars['country'] = drupal_render($vars['form']['country']);
  $vars['software_name'] = drupal_render($vars['form']['software_name']);
  $vars['software_version'] = drupal_render($vars['form']['software_version']);
  $vars['last_dock_date'] = drupal_render($vars['form']['last_dock_date']);  
  

  //  echo '<pre>' ; var_dump($vars['form']) ; exit;
  $vars['search_button'] = drupal_render($vars['form']['submit']);
  // this is must
  // $vars['form_extras'] = drupal_render($vars['form']);

  $vars['report_menu'] = covidien_report_filter_list();

}


function template_preprocess_device_historical_configuration_report(&$vars, $hook) {
  device_historical_configuration_form_validate();
  if (count(form_get_errors())) {
    drupal_goto(referer_uri());
  }
  $pageSize = 10;

  $device_type = $_REQUEST['device_type'];
  $ds_number = $_REQUEST['ds_number'] ;
  $region = $_REQUEST['region'];
  $country = $_REQUEST['country'];
  $customer_name = $_REQUEST['customer_name'];    
  $dock_date = $_REQUEST['last_dock_date']['date'];
  $software_name = $_REQUEST['software_name'];
  $software_version = $_REQUEST['software_version'];
  $user_id = $_REQUEST['user_id'];  // Vivian Li
  


  // table head need to customize
  $header = array(
    array(
      'data' => t('Configuration Date'),
      'field' => 'dock_date',
      'sort' => 'asc',
      'rowspan' => '2',
    ),
   array(
      'data' => t('System Config'),
      'field' => 'sys_cfg_name',
      'sort' => 'asc'
      ),
    array(
      'data' => t('Hardware Config'),
      'field' => 'hw_cfg',
      'sort' => 'asc'
      ),
    array(
      'data' => t('Software Config'),
      'field' => 'sw_cfg',
      'sort' => 'asc'
      ),
    array(
      'data' => t('Firmware Config'),
      'field' => 'fw_cfg',
      'sort' => 'asc'
    )
    
  );
  
  $sql = "SELECT a.field_service_datetime_value dock_date, c.*
        FROM content_field_device_pk device_pk 
          JOIN node device ON device.title = '%s' AND device.type = 'device' AND device.nid = device_pk.field_device_pk_nid 
          JOIN content_field_device_type field_device_type ON device.nid = field_device_type.nid 
              AND device.vid = device.vid AND field_device_type.field_device_type_nid = %d 
          JOIN content_type_device_service_history a ON device_pk.nid = a.nid AND device_pk.vid = a.vid 
          JOIN content_type_device_service_type b ON a.field_device_service_type_nid = b.nid
          AND b.field_service_description_value = 'Named System Configuration Update' 
          JOIN (SELECT nid, title AS sys_cfg_name, name AS substatus, MAX(hw_cfg) AS hw_cfg, MAX(sw_cfg) AS sw_cfg, MAX(fw_cfg) AS fw_cfg
            FROM (SELECT node.nid, node.title, d.name, 
                    CASE WHEN g.name = 'hardware_configuration' THEN concat(f.title, ' v', h.version) END AS hw_cfg, 
                    CASE WHEN g.name = 'software_configuration' THEN concat(f.title, ' v', h.version) END AS sw_cfg, 
                    CASE WHEN g.name = 'firmware_configuration' THEN concat(f.title, ' v', h.version) END AS fw_cfg
                  FROM named_configuration a 
                    JOIN node b ON a.device_type_id = b.nid AND b.nid = %d 
                    JOIN node ON a.nid = node.nid 
                    JOIN named_configuration_type c ON a.type_id = c.id AND c.name = 'system_configuration' 
                    JOIN named_configuration_substatus d ON a.substatus = d.id 
                    JOIN named_configuration_relation e ON a.nid = e.left_nid 
                    JOIN node f ON e.right_nid = f.nid 
                    JOIN named_configuration_type g ON e.right_type = g.id 
                    JOIN named_configuration h ON e.right_nid = h.nid
              ) temp
            GROUP BY 1
            ) c ON a.field_to_device_component_nid = c.nid ";

      $args = array($ds_number, $device_type, $device_type);

      drupal_set_title(t('Device Historical Configuration Report'));
      global $base_url;

//      $sql .= check_plain($_GET['sort']) ? tablesort_sql($header) : " ORDER BY h.date_time DESC ";
      $count_query_sql = ' SELECT COUNT(*) as total FROM (' . $sql . ') AS result ';
      $result = pager_query($sql, $pageSize, 0, $count_query_sql,$args);

      $rows = array();
      $row = array();
      while ($record = db_fetch_object($result)) {
        $row[0] = $record->dock_date;
        $row[1] = $record->sys_cfg_name;
        $row[2] = $record->hw_cfg;
        $row[3] = $record->sw_cfg;
        $row[4] = $record->fw_cfg;
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

      $product_line = covidien_get_product_line();
      $productline = node_load($product_line);
      $device_type = node_load($device_type);
      $vars['device_type_name'] = $device_type->title;
      $vars['pro_line_name'] = $productline->title;
      $vars['ds_number'] = $ds_number;
      $vars['region'] = $region;
      $vars['country'] = $country;
      $vars['customer_name'] = $customer_name;
      $vars['dock_date'] = $dock_date;
      
      $vars['result'] = $output;
}



