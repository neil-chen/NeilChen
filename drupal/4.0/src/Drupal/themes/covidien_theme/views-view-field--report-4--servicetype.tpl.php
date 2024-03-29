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
<?php echo $output; ?>
<?php $tmp_op = ''; ?>
<?php
if ($row->device_service_history_view_servicetype == "Upgrade") {
  if ($row->device_service_history_view_servicetype_status == 'installed') {
    $tmp_op.= t('P');
  } elseif ($row->device_service_history_view_servicetype_status == 'failed' || $row->device_service_history_view_servicetype_status == 'Failed') {
    $tmp_op.= t('F');
  } elseif (strtolower($row->device_service_history_view_servicetype_status) == 'not attempted' ||
    $row->device_service_history_view_servicetype_status = 'Download Only') {
    $tmp_op.= t('DO');
  }
} elseif ($row->device_service_history_view_servicetype == "Log Retrieval") {
  if ($row->device_service_history_view_servicetype_status == 'PostUpdate') {
    $tmp_op.= t('POU');
  } elseif ($row->device_service_history_view_servicetype_status == 'PreUpgrade') {
    $tmp_op.= t('PRU');
  } else {
    $tmp_op.= t('UNK');
  }
}
?>
<?php if ($tmp_op != '') { ?>
  - <span class="servicetype_status">
    <?php echo $tmp_op; ?>
  <?php } ?>
</span>