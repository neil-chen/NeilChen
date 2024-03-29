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
if (!empty($q)) {
  // This ensures that, if clean URLs are off, the 'q' is added first so that
  // it shows up first in the URL.
  echo $q;
}
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
      <div class="form-item-div">
        <div class="form-item-left">
          <h4><?php echo t('Hardware Catalog'); ?></h4>
        </div>
        <div class="form-item-right">
          <?php if (is_array($user->devices_access['hardware'])) { ?>
            <?php if (in_array('edit', $user->devices_access['hardware'])): ?>
              <div class="views-submit-button">
                <?php global $base_url ?>
                <input type="button" class="form-submit secondary_submit" onclick="window.location = '<?php echo $base_url . '/node/add/hardware' ?>';
                    return true;" value="<?php echo t("Add New Hardware"); ?>" id="edit-add-new">
              </div>				
            <?php endif; ?>
          <?php } ?>
        </div>
      </div>
      <div class="clear_div"></div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-div">
          <div class="form-item-left">
            <label for="edit-field-device-type-nid">Select Device Type:</label>
          </div>
          <div style="padding-left : 30px;" class="form-item-left">
            <?php echo drupal_render(field_device_type_select()); ?>
          </div>
        </div>
      </div>
      <?php if (!empty($widget->label)): ?>
        <div class="form-item-div">
          <div class="form-item-left">
            <label for="<?php print $widget->id; ?>"><?php print $widget->label; ?>:</label>
          </div>
          <div class="form-item-left" style="padding-left : 30px;">
          <?php endif; ?>
          <?php if (!empty($widget->operator)): ?><div class="views-operator"><?php print $widget->operator; ?></div><?php endif; ?>
          <div class="views-widget"><?php print $widget->widget; ?></div>
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="clear_div"></div>
      <div class="form-item-div">
        <div class="form-item-left">
          <?php
          $widget = $widgets['filter-title'];
          $id = 'filter-title';
          ?>
          <?php if (!empty($widget->operator)): ?>
            <div class="oval_search"><?php print $widget->operator; ?></div>
          <?php endif; ?>
          <div id="hardwarelist_page1" class="oval_search_wraper" style="margin-top : 20px;"><?php print $widget->widget; ?></div>
          <div class="views-exposed-widget views-submit-button" style="padding-top : 10px;" >
            <?php print $button; ?>	
          </div>
        </div>
        <div class="form-item-left" style="padding-left : 30px;">
          <?php
          $widget = $widgets['filter-field_hw_type_nid'];
          $id = 'filter-field_hw_type_nid';
          ?>
          <?php if ($id == 'filter-field_hw_type_nid') { ?>			
            <div class="views-exposed-widget views-widget-<?php print $id; ?>">
              <?php if (!empty($widget->label)) { ?>
                <label for="<?php print $widget->id; ?>"><?php print $widget->label; ?></label>
              <?php } else { ?>
                <label for="<?php print $widget->id; ?>">&nbsp; &nbsp; &nbsp;

                </label>
              <?php } ?>
              <?php if (!empty($widget->operator)): ?>
                <div class="views-operator"><?php print $widget->operator; ?></div>
              <?php endif; ?>
              <div class="views-widget"><?php print $widget->widget; ?></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </td>
  </tr>
</table>
