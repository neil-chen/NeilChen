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
 * $row->device_emerald_software_version_view_software_name 
 */
  
?> 
<?php if($_GET['q'] == 'covidien/report/1/emerald'): ?>
  <?php print ($row->device_emerald_software_version_view_lastest_sw_update); ?> 
<?php else: ?> 
  <tr>
      <td style="text-align:center"><?php print($row->device_emerald_software_version_view_customername); ?></td>
      <td style="text-align:center"><?php print ($row->device_emerald_software_version_view_deviceserial); ?></td>
      <td style="text-align:center"><?php print($row->device_emerald_software_version_view_country_name); ?></td>
      <td style="text-align:center"><?php print ($row->device_emerald_software_version_view_hardware_version); ?></td>
      <td style="text-align:center"><?php print($row->device_emerald_software_version_view_hardware1_version); ?></td>
      <td style="text-align:center"><?php print ($row->device_emerald_software_version_view_software_version); ?></td>
      <td style="text-align:center"><?php print($row->device_emerald_software_version_view_lastest_sw_update); ?></td>
      <td style="text-align:center"><?php print($row->device_emerald_software_version_view_service_person); ?></td>
  </tr>  
<?php endif; ?> 