<?php
/**
 * @file views-exposed-form.tpl.php
 *
 * This template handles the layout of the views exposed filter form.
 *
 * Variables available:
 * - $widgets: An array of exposed form widgets. Each widget contains:
 * - $widget->label: The visible label to echo. May be optional.
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

<table class="form-item-table-full" style="margin-bottom : 20px;" >
  <tr>
    <td>
      <?php
      $id = 'filter-field_device_type_nid';
      $widget = $widgets[$id];
      ?>
      <div class="form-item-div">
        <div class="form-item-left">
          <h4><?php echo t('Document Catalog'); ?></h4>
        </div>
        <div class="form-item-right">
          <?php if (in_array('edit', $user->devices_access['document'])): ?>
            <div class="views-submit-button">
              <a href="<?php echo url('node/add/document'); ?>" id="secondary_submit"><?php echo t("Add New Document"); ?></a>
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
            <label for="<?php echo $widget->id; ?>"><?php echo $widget->label; ?>:</label>
          <?php endif; ?>
        </div>
        <div class="form-item-left" style="padding-left : 30px;">
          <?php if (!empty($widget->operator)): ?>
            <div class="views-operator">
              <?php echo $widget->operator; ?>
            </div><?php endif; ?>
          <div class="views-widget">
            <?php
            module_load_include("module", "convidien_ui", "module");
            $select_device_type = field_device_type_select($device_type_id);
            $device_type_form['field_device_type'] = $select_device_type['select_device_type'];
            //sel_device_type
            $device_type_form['field_device_type']['#name'] = 'field_device_type_nid';
            $device_type_form['field_device_type']['#id'] = 'edit-field-device-type-nid';
            echo drupal_render($device_type_form['field_device_type']);
            ?>
          </div>
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
          $id = 'filter-title';
          $widget = $widgets[$id];
          ?>
          <?php if (!empty($widget->operator)): ?>
            <div class="oval_search"><?php echo $widget->operator; ?></div>
          <?php endif; ?>
          <div id="document_page1" class="oval_search_wraper"><?php echo $widget->widget; ?></div>
          <div class="views-exposed-widget views-submit-button" style="padding-top : 10px;" >
            <?php echo $button; ?>	
          </div>	
        </div>
        <!-- GATEWAY-2942 not display hardware and software filter -->
        <div class="form-item-right" style="margin-top: -22px; display: none;">
          <label><?php echo t('Filter Categories:'); ?> </label>
          <table class="border_div">
            <tbody>
              <tr>
                <!-- GATEWAY-2942 reomove configuration name filter -->
                <td style="padding : 5px; display:none;">
                  <div>
                    <label for="edit-hardware-type"><?php echo t('Configuration Name:'); ?> </label>
                  </div>
                  <?php
                  $id = 'filter-field_config_value';
                  $widget = $widgets[$id];
                  ?>
                  <?php if (!empty($widget->operator)): ?>
                    <div class="oval_search">
                      <?php echo $widget->operator; ?>
                    </div>
                  <?php endif; ?>
                  <div id="document_page1" class="oval_search_wraper">
                    <?php echo $widget->widget; ?>
                  </div>
                </td>

                <td style="padding : 5px;">
                  <div id="edit-hardware-name-wrapper" class="form-item">
                    <label for="edit-hardware-name"><?php echo t('Hardware Type:'); ?> </label>
                    <?php
                    $id = 'filter-field_hw_type_nid';
                    $widget = $widgets[$id];
                    ?>
                    <?php if (!empty($widget->operator)): ?>
                      <div class="oval_search">
                        <?php echo $widget->operator; ?>
                      </div>
                    <?php endif; ?>
                    <div id="document_page1" class="oval_search_wraper">
                      <?php echo $widget->widget; ?>
                    </div>	
                  </div>
                </td>
                <td style="padding : 5px;">
                  <div id="edit-hardware-ver-wrapper" class="form-item">
                    <label><?php echo t('Hardware Name & Revision:'); ?></label>
                    <?php
                    $id = 'filter-field_doc_hw_list_nid';
                    $widget = $widgets[$id];
                    ?>
                    <?php if (!empty($widget->operator)): ?>
                      <div class="oval_search">
                        <?php echo $widget->operator; ?>
                      </div>
                    <?php endif; ?>
                    <div id="document_page1" class="oval_search_wraper">
                      <?php echo $widget->widget; ?>
                    </div>
                  </div>
                  <?php
                  /**
                   * Hidden values
                   */
                  ?>
                  <div id="edit-hardware-title-wrapper" class="form-item" style="display:none">
                    <?php
                    $id = 'filter-title_2';
                    $widget = $widgets[$id];
                    ?>
                    <?php if (!empty($widget->operator)): ?>
                      <div class="oval_search">
                        <?php echo $widget->operator; ?>
                      </div>
                    <?php endif; ?>
                    <div id="document_page1" class="oval_search_wraper">
                      <?php echo $widget->widget; ?>
                    </div>
                  </div>
                  <div id="edit-hardware-revision-wrapper" class="form-item" style="display:none">
                    <?php
                    $id = 'filter-field_hw_version_value';
                    $widget = $widgets[$id];
                    ?>
                    <?php if (!empty($widget->operator)): ?>
                      <div class="oval_search">
                        <?php echo $widget->operator; ?>
                      </div>
                    <?php endif; ?>
                    <div id="document_page1" class="oval_search_wraper">
                      <?php echo $widget->widget; ?>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="padding : 5px;">
                  <div id="edit-hardware-type-wrapper" class="form-item">
                    <label for="edit-hardware-type"><?php echo t('Software Name:'); ?> </label>
                    <?php
                    $id = 'filter-title_1';
                    $widget = $widgets[$id];
                    ?>
                    <?php if (!empty($widget->operator)): ?>
                      <div class="oval_search">
                        <?php echo $widget->operator; ?>
                      </div>
                    <?php endif; ?>
                    <div id="document_page1" class="oval_search_wraper">
                      <?php echo $widget->widget; ?>
                    </div>
                  </div>
                </td>
                <td style="padding : 5px;">
                  <div id="edit-hardware-name-wrapper" class="form-item">
                    <label for="edit-hardware-name"><?php echo t('Software Version:'); ?> </label>
                    <?php
                    $id = 'filter-field_sw_version_value';
                    $widget = $widgets[$id];
                    ?>
                    <?php if (!empty($widget->operator)): ?>
                      <div class="oval_search">
                        <?php echo $widget->operator; ?>
                      </div>
                    <?php endif; ?>
                    <div id="document_page1" class="oval_search_wraper">
                      <?php echo $widget->widget; ?>
                    </div>
                  </div>
                </td>
                <td style="padding : 5px;">
                  <div id="edit-hardware-ver-wrapper" class="form-item">
                    <label><?php echo t('Software Status:'); ?></label>
                    <?php
                    $id = 'filter-field_sw_status_nid';
                    $widget = $widgets[$id];
                    ?>
                    <?php if (!empty($widget->operator)): ?>
                      <div class="oval_search">
                        <?php echo $widget->operator; ?>
                      </div>
                    <?php endif; ?>
                    <div id="document_page1" class="oval_search_wraper">
                      <?php echo $widget->widget; ?>
                    </div>
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
