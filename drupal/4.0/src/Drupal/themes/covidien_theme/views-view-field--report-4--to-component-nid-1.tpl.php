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

if ($row->device_service_history_view_to_component_nid > 0) {
// Current version 
?>
  <?php

  $name = db_result(db_query("select content_type_software.field_sw_version_value from {content_type_software} as content_type_software join {node} as node on node.nid=content_type_software.nid and node.vid=content_type_software.vid where node.nid='%d'", $row->device_service_history_view_to_component_nid));
  ?>
  <?php echo $name; ?>
  <?php

}?>