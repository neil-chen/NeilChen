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
<?php if ($output != '') { ?>
  <?php

  $form['viewfield_config_hw_sw_status_1'] = array(
    '#type' => 'select',
    '#default_value' => '',
    '#options' => array(
      '' => t('Select'),
      'Required' => t('Required'),
      'Optional' => t('Optional'),
    ),
    '#name' => 'viewfield_config_hw_sw_status_1[nid][nid][' . $output . ']',
    '#id' => 'viewfield_config_hw_sw_status_1_nid_nid_' . $output,
  );
  ?>
  <?php echo drupal_render($form['viewfield_config_hw_sw_status_1']); ?>
<?php } ?>
