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
$deviceTypeRelation = get_device_type_relation_with_gateway_version();
$deviceTypeRelationStr = '';
foreach ($deviceTypeRelation as $key => $value) {
  $deviceTypeRelationStr .= $key . ',' . $value . '|';
}
//use new device type list 
$field_device_type_select = field_device_type_select($_GET['field_device_type_nid']);
$field_device_type = $field_device_type_select['select_device_type'];
$field_device_type['#id'] = 'edit-field-device-type-nid';
$field_device_type['#name'] = 'field_device_type_nid';
$sw_device_type = drupal_render($field_device_type);
?>
<?php if (!empty($q)): ?>
  <?php
  // This ensures that, if clean URLs are off, the 'q' is added first so that
  // it shows up first in the URL.
  print $q;
  ?>
<?php endif; ?>
<input type="hidden" id="device_type_relation" name="device_type_relation" value="<?php echo $deviceTypeRelationStr; ?>" />
<table class="form-item-table-full" style="margin-bottom: 10px;">
  <tr>
    <td>
      <?php
      $widget = $widgets['filter-field_device_type_nid'];
      ?>
      <div class="form-item-div">
        <div class="form-item-left">
          <h4><?php echo t('Software Catalog'); ?></h4>
        </div>
        <div class="form-item-right">
          <?php if (in_array('edit', $user->devices_access['software'])): ?>
            <div class="views-submit-button">
              <?php global $base_url ?>
              <a href="<?php echo $base_url; ?>/node/add/software" id="secondary_submit"><?php echo t("Add New Software"); ?></a>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="clear_div"></div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left">
          <?php if (!empty($widget->label)): ?>
            <label for="<?php print $widget->id; ?>"><?php print $widget->label; ?>:</label>
          <?php endif; ?>
        </div>
        <div class="form-item-left" style="padding-left : 30px;">
          <?php echo $sw_device_type; ?>
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <td style="padding-top  : 20px;">
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
          <div id="softwarelist_page1" class="oval_search_wraper"><?php print $widget->widget; ?></div>
          <div class="views-exposed-widget views-submit-button" style="padding-top : 10px;" >
            <?php print $button; ?>	
          </div>	
        </div>
        <div id="hardware-filter-div" class="form-item-right" style="margin-top  : -22px;">
          <label><?php echo t('Filter Categories:'); ?> </label>
          <table class="border_div">
            <tbody>
              <tr>
                <td style="padding : 5px;">							
                  <label for="edit-hardware-type"><?php echo t('Hardware Type:'); ?> </label>
                  <?php
                  $id = 'filter-field_hw_type_nid';
                  $widget = $widgets[$id];
                  ?>
                  <?php if (!empty($widget->operator)): ?>
                    <div class="views-operator">
                      <?php print $widget->operator; ?>
                    </div>
                  <?php endif; ?>
                  <div class="views-widget">
                    <?php print $widget->widget; ?>
                  </div>

                </td>
                <td style="padding : 5px;">												
                  <label for="edit-hardware-name"><?php echo t('Hardware Name:'); ?> </label>
                  <?php
                  $id = 'filter-title_1';
                  $widget = $widgets[$id];
                  ?>
                  <?php if (!empty($widget->operator)): ?>
                    <div class="views-operator">
                      <?php print $widget->operator; ?>
                    </div><?php endif; ?>
                  <div class="views-widget">
                    <?php print $widget->widget; ?>
                  </div> 

                </td>
                <td style="padding : 5px;">

                  <label for="edit-hardware-ver"><?php echo t('Hardware Revision:'); ?> </label>
                  <?php
                  $id = 'filter-field_hw_version_value';
                  $widget = $widgets[$id];
                  ?>
                  <?php if (!empty($widget->operator)): ?>
                    <div class="views-operator">
                      <?php print $widget->operator; ?>
                    </div>
                  <?php endif; ?>
                  <div class="views-widget">
                    <?php print $widget->widget; ?>
                  </div> 														
                </td>
              </tr>
            </tbody>
          </table>								
        </div>
      </div>
    </td>
  </tr>
</table>

<div style="text-align : right;">
  <?php
  if ($_REQUEST['sw_archieved_status'] == 1) {
    $sw_archieved_status = 'checked="checked"';
  } else {
    $sw_archieved_status = '';
  }
  ?>
  <input type="checkbox" name="sw_archieved_status" id="sw_archieved_status" value="1" <?php echo $sw_archieved_status ?> onclick="$('#edit-submit-softwarelist').trigger('click');" />
  &nbsp;<label><?php echo t('Show Software with Archived Status'); ?></label></div>
