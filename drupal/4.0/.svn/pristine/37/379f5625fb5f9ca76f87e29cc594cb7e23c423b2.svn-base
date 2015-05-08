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
?>
<form id="covidien-doc-filter-form" method="get" accept-charset="UTF-8">
  <table class="form-item-table-full" style="margin-bottom : 20px;" >
    <tr>
      <td>
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
            <label for="edit-field-device-type-nid">Select Device Type:</label>
          </div>
          <div style="padding-left : 30px;" class="form-item-left">
            <div class="form-item-left">
              <?php echo drupal_render($filter_form['device_type']); ?>
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
            <?php echo drupal_render($filter_form['document_title']); ?>
            <div class="views-exposed-widget views-submit-button" style="padding-top : 10px;" >
              <?php echo drupal_render($filter_form['submit']); ?>
            </div>	
          </div>
          <div class="form-item-right" style="margin-top: -22px;">
            <label><?php echo t('Filter Categories:'); ?></label>
            <table class="border_div">
              <tbody>
                <tr>
                  <td style="padding: 5px;">
                    <div id="edit-hardware-name-wrapper" class="form-item">
                      <label for="edit-hardware-name"><?php echo t('Hardware Type:'); ?></label>
                      <?php echo drupal_render($filter_form['hw_type']); ?>
                    </div>
                  </td>
                  <td style="padding : 5px;">
                    <div id="edit-hardware-ver-wrapper" class="form-item">
                      <label><?php echo t('Hardware Name & Revision:'); ?></label>
                      <?php echo drupal_render($filter_form['hw_name']); ?>
                    </div>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td style="padding : 5px;">
                    <div id="edit-hardware-type-wrapper" class="form-item">
                      <label for="edit-hardware-type"><?php echo t('Software Name:'); ?> </label>
                      <?php echo drupal_render($filter_form['sw_name']); ?>
                    </div>
                  </td>
                  <td style="padding : 5px;">
                    <div id="edit-hardware-name-wrapper" class="form-item">
                      <label for="edit-hardware-name"><?php echo t('Software Version:'); ?> </label>
                      <?php echo drupal_render($filter_form['sw_version']); ?>
                    </div>
                  </td>
                  <td style="padding : 5px;">
                    <div id="edit-hardware-ver-wrapper" class="form-item">
                      <label><?php echo t('Software Status:'); ?></label>
                      <?php echo drupal_render($filter_form['sw_status']); ?>
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
</form>
<?php
echo covidien_document_table_list();
?>
