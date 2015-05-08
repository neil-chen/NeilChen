<?php
/**
 * @file views-exposed-form.tpl.php
 *
 * This template handles the layout of the views exposed filter form.
 *
 * Variables available:
 * - $widgets: An array of exposed form widgets. Each widget contains:
 * - $widget->label: The visible label to print. May be optional.
 * - $widget->operator: The operator for the widget. May be optional.
 * - $widget->widget: The widget itself.
 * - $button: The submit button for the form.
 *
 * @ingroup views_templates
 */
global $user;
?>
<?php if (!empty($q)): ?>
  <?php
  // This ensures that, if clean URLs are off, the 'q' is added first so that
  // it shows up first in the URL.
  print $q;
  ?>
<?php endif; ?>

<table class="form-item-table-full" style="margin-bottom : 20px;" >
  <tr>
    <td>
      <?php
      $id = 'filter-field_device_type_nid';
      $widget = $widgets[$id];
      ?>			
      <div class="form-item-div">
        <div class="form-item-left">
          <h4><?php echo t('Configuration Management'); ?></h4>
          <p class="discrips"><?php echo t('Named device configurations are listed below.'); ?></p>
        </div>
        <div class="form-item-right">
          <?php if (in_array('edit', $user->devices_access['configuration'])): ?>
            <?php global $base_url ?>
            <input type="button" class="form-submit secondary_submit" onclick="window.location = '<?php echo $base_url . '/node/add/device-type-config' ?>';
                return true;" value="Add New Configuration" id="edit-add-new">			
<?php endif; ?>
        </div>
      </div>
      <div class="clear_div"></div>
    </td>
  </tr>
  <tr>
    <td style="padding-left : 30px;">			
      <div class="form-item-div">
        <div class="form-item-left">
          <label for=""><?php echo t('Select Device Type:') ?></label>
        </div>
        <div class="form-item-left" style="padding-left : 30px;">
<?php if (!empty($widget->operator)): ?><div class="views-operator"><?php print $widget->operator; ?></div><?php endif; ?>
          <div class="views-widget"><?php print $widget->widget; ?></div>

        </div>
        <div class="form-item-left" style="padding-left : 20px; width : 300px">
          <div class="views-exposed-widget views-submit-button" >
<?php print $button; ?>	
          </div>
        </div>
      </div>
    </td>
  </tr>	
</table>
