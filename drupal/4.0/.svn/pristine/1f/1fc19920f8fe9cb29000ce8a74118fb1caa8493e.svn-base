<?php

function feature_license_regulatory_approval() {
//  $output = theme('feature_license_list');
//  return $output;
  return drupal_get_form('feature_license_regulatory_form');
}

function feature_license_regulatory_form() {
//  field_device_type_select

  $form = array();

  $form['feature_regulatory_name'] = array(
    '#type' => 'textfield',
    '#id' => 'feature_regulatory_name',
    '#required' => TRUE,
    '#name' => 'feature_regulatory_name',
    '#attributes' => array('placeholder' => 'Enter Feature Description'),
  );

  $form['feature_name'] = array(
    '#type' => 'textfield',
    '#id' => 'feature_name',
    '#required' => TRUE,
    '#name' => 'feature_name',
    '#attributes' => array('placeholder' => 'Enter Feature Name'),
  );

  $form['feature_description'] = array(
    '#type' => 'textfield',
    '#id' => 'feature_description',
    '#required' => TRUE,
    '#name' => 'feature_description',
    '#attributes' => array('placeholder' => 'Enter Feature Description'),
  );
  /*  $form['select_device_type'] = array(
    //    '#id' => 'select_device_type',
    //    '#name' => 'select_device_type',
    '#type' => 'select',
    '#attributes' => array('onchange' => 'changeDeviceType()'),
    //    '#default_value' => variable_get('feed_item_length','teaser'),
    '#options' => array(
    'title' => t('Titles only'),
    'teaser' => t('Titles plus teaser'),
    'fulltext' => t('Full text'),
    ),
    ); */

  return $form;
}

function template_preprocess_feature_license_regulatory_form(&$vars) {

  drupal_set_title(t('Manage Regulatory Exceptions'));

  $feature_id = arg(2);

  $feature_form = feature_license_regulatory_form();

  if ($feature_id && is_numeric($feature_id)) {

    $query = "SELECT f.nid, f.name ,  f.description, f.device_type ,
                n.title as device_type_name  , GROUP_CONCAT(distinct c.component_nid) component_nid
                FROM feature_catalog f left join feature_relation c
                    on f.nid = c.feature_nid
                    join  node n on f.device_type = n.nid
                WHERE f.nid = %d";
    $result = db_query($query, $feature_id);
    $row = db_fetch_object($result);
    $feature = array(
      'nid' => $row->nid,
      'name' => $row->name,
      'description' => $row->description,
      'device_type_id' => $row->device_type,
      'device_type_name' => $row->device_type_name,
      'component_nid' => $row->component_nid
    );


    $feature_form['select_device_type']['#value'] = $row->device_type;
    $feature_form['feature_name']['#value'] = $feature['name'];
    $feature_form['feature_description']['#value'] = $feature['description'];


    $vars['feature'] = $feature;
    $vars['feature_form'] = $feature_form;




    $sql_exclusions_query = 'SELECT e.country_nid , c.title FROM feature_catalog_exclusions  e
      left join node c on e.country_nid = c.nid where feature_catalog_nid = %d ';
    $result_exclusions_query = db_query($sql_exclusions_query, $feature_id);

    $feature_exclusions_array = array();

    while ($row_exclusions_result = db_fetch_object($result_exclusions_query)) {
      array_push($feature_exclusions_array, $row_exclusions_result->title);
    }

    $vars['feature_exclusions_array'] = $feature_exclusions_array;
  }
}

/**
 *
 * feature license add exclusions
 * @return
 */
function feature_license_regulatory_approval_add() {

//  feature_license_add_exclusions_form_validate(&$form_stats);

  feature_license_add_exclusions_form_submit();
  return drupal_get_form('feature_license_add_exclusions_form');
}

function feature_license_add_exclusions_form() {
  $form = array();

  $form['feature_regulatory_name'] = array(
    '#type' => 'textfield',
    '#id' => 'feature_regulatory_name',
    '#required' => TRUE,
    '#name' => 'feature_regulatory_name',
    '#attributes' => array('placeholder' => 'Enter Feature Description'),
  );

  $form['feature_nid'] = array(
    '#type' => 'hidden',
    '#required' => TRUE,
    '#name' => 'feature_nid',
  );

  $form['feature_name'] = array(
    '#type' => 'textfield',
    '#id' => 'feature_name',
    '#required' => TRUE,
    '#name' => 'feature_name',
    '#attributes' => array('placeholder' => 'Enter Feature Name'),
  );

  $form['device_type'] = array(
    '#type' => 'textfield',
    '#required' => TRUE,
  );

  $form['feature_description'] = array(
    '#type' => 'textfield',
    '#id' => 'feature_description',
    '#required' => TRUE,
    '#name' => 'feature_description',
    '#attributes' => array('placeholder' => 'Enter Feature Description'),
  );

  $form['select_country'] = array(
    '#id' => 'select_country',
    '#name' => 'select_country',
    '#type' => 'select',
    '#attributes' => array('onchange' => 'select_feature_country();',),
//    '#default_value' => variable_get('feed_item_length','teaser'),
//    '#options' => array(
//      'title' => t('Titles only'),
//      'teaser' => t('Titles plus teaser'),
//      'fulltext' => t('Full text'),
//    ),
  );

  return $form;
}

function template_preprocess_feature_license_add_exclusions_form(&$vars) {

  $sql = "select c.nid , n.title from content_type_country c join node n
            on  c.nid=n.nid and c.vid=n.vid
            order by n.title asc ";

  $results = db_query($sql);


  $options = array('Select Country');
  while ($row = db_fetch_array($results)) {
    $options[current($row)] = next($row);
  }


  $feature_exclusions_form = feature_license_add_exclusions_form();

  $feature_exclusions_form['select_country']['#options'] = $options;
  $feature_exclusions_form['feature_nid']['#value'] = check_plain($_GET['feature_nid']);


  $vars ['exclusions_form'] = $feature_exclusions_form;
}

function feature_license_add_exclusions_form_submit() {
  if (count(form_get_errors()) || !$_POST['op']) {
    return false;
  }

  $sql = 'INSERT INTO feature_catalog_exclusions (feature_catalog_nid , country_nid ) VALUES (%d,%d)';

  db_query($sql, check_plain($_POST['feature_nid']), check_plain($_POST['select_country']));


//  global $base_url;
//  echo '<script type="text/javascript">parent.jQuery.fn.colorbox.close();</script>';
//  exit;
}
