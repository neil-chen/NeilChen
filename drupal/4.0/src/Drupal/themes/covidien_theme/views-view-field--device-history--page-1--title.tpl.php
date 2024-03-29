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

$result = $output;
global $base_url;
if (strtolower($row->node_node_data_field_device_service_type_title) == 'upgrade') {
  if ($row->node_data_field_service_datetime_field_upgrade_status_value == 'installed') {
    $result = '<a href="' . $base_url . '/covidien/upgrade/history/' . $row->node_node_data_field_device_installation_pk_nid . '/' . $row->node_node_data_field_from_device_component_nid . '/' . $row->nid . '" class="iframe2">' . $output . ' - ' . t('Pass') . '</a>';
  } else if ($row->node_data_field_service_datetime_field_upgrade_status_value == 'failed' || $row->node_data_field_service_datetime_field_upgrade_status_value == 'Failed') {
    $result = $output . ' - ' . t('Fail');
  } else if (strtolower($row->node_data_field_service_datetime_field_upgrade_status_value) == 'not attempted') {
    $result = $output . ' - ' . t('Download Only');
  }
} else if (strtolower($row->node_node_data_field_device_service_type_title) == 'log retrieval') {
  if (($row->node_data_field_service_datetime_field_upgrade_status_value == 'PostUpdate') || ($row->node_data_field_service_datetime_field_upgrade_status_value == 'PreUpdate')) {
    $upgrade_desc = $row->node_data_field_service_datetime_field_upgrade_status_value;
  } else {
    $upgrade_desc = 'Unknown';
  }
  $result = '<a href="javascript:void(0)" onclick="popuppage(\'' . $row->node_node_node_data_field_device_log_type_field_device_log_type_value . '\', \'' . $row->node_node_node_data_field_device_log_type_field_device_log_filename_value . '\')">' . $output . ' - ' . $upgrade_desc . '</a>';
}
print $result;
?>

