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
global $user;
global $base_url;
$active = $row->node_data_field_last_name_field_is_active_user_value;
?>
<?php
if ($active == 1) {
  echo '<span style="color:red">' . t('Deactivated') . '</span>';
} elseif ($output == "Yes") {
  ?>
  <span style="color:red"><?php echo t('Locked'); ?></span>
<?php } ?>

