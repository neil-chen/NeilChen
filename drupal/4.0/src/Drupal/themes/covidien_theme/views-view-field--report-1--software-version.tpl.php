<?php

/**
 * This template is used to print a single field in a view. It is not
 * actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the
 * template is perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
?>   
<?php 
  $sw_name_temp = explode(',', $row->software_name);
  $count_sw_name = count($sw_name_temp);
  $sw_name = ''; 
  if($count_sw_name > 0){
    $count_sw_name = $count_sw_name - 1;
    $sw_name = $sw_name_temp[$count_sw_name];
  }
  
  $temp = explode(',', $row->device_software_version_view_software_version);
  $count = count($temp);
  $count = $count - 1;
   
  $software_and_version = '';
  if($sw_name != ''){
    $software_and_version = $sw_name . ' ' . $temp[$count];
  }
  ?>
  <?php print ($software_and_version); ?> 
 