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
drupal_add_js(drupal_get_path('module', 'covidien_ui') . '/js/covidien_autocomplete.js');
drupal_add_js(drupal_get_path('module', 'covidien_devices') . '/js/covidien_devices.js');
if (!empty($q)) {
  global $base_url;
  // This ensures that, if clean URLs are off, the 'q' is added first so that
  // it shows up first in the URL.
  print $q;
}
?>
<script type="text/javascript">
  $(document).ready(function() {
    var val = $('#edit-sno').val();
    if (val == "") {
      $('#edit-sno').val(Drupal.t('Search - Enter Serial Number'));
    }
    var val = $('#edit-account-number').val();
    if (val == "") {
      $('#edit-account-number').val(Drupal.t('Enter Account Number'));
    }

    $('#edit-sno, #edit-account-number').focus(function() {
      var val = $(this).val();
      if ((val == Drupal.t("Search - Enter Serial Number")) || (val == Drupal.t("Enter Account Number"))) {
        $(this).val('');
      }
    });

    $('#edit-submit-device-information').click(function() {
      var val = $("#edit-sno").val();
      if (val == Drupal.t("Search - Enter Serial Number")) {
        $('#edit-sno').val('');
      }
      var val = $("#edit-account-number").val();
      if (val == Drupal.t("Enter Account Number")) {
        $('#edit-account-number').val('');
      }
    });


  });
</script>	

<table class="form-item-table-full">
  <tr>
    <td>
      <h2><?php echo t('Find and Select a Specific Device'); ?></h2>
    </td>
    <td align="right">
    </td>
  </tr>
  <tr>
    <td valign="top" colspan="2" style="padding : 0px;">
      <div class="form-item-div device_search_device">
        <div class="form-item-left">
          <label><?php echo t('Search Device Type:'); ?>
        </div>
        <div class="form-item-left label_left_more">
          <?php echo $widgets['filter-field_device_type_nid']->widget; ?></label>
        </div>
      </div>							
      <div style="clear : both;"></div>
      <div class="form-item-div">
        <div class="form-item-left device_search">
          <div id="softwarelist_page1" class="oval_search_wraper">
            <?php echo $widgets['filter-field_device_serial_number_value']->widget; ?>
          </div>
          <div class="views-exposed-widget views-submit-button" style="padding-top : 10px;" >
            <?php echo $button; ?>	
          </div>	
        </div>
        <div class="form-item-right">
          <table class="form-item-user-table">
            <tbody>
              <tr>
                <td style="padding : 0px;">
                  <div>
                    <label><?php echo t('Filter Categories:'); ?></label>
                  </div>
                  <table class="border_div">
                    <tbody>
                      <tr>
                        <td>
                          <label for="edit-hardware-type"><?php echo t('Country:'); ?></label>
                          <?php echo $widgets['filter-field_device_country_nid']->widget; ?>
                        </td>
                        <td>
                          <label for="edit-hardware-name"><?php echo t('Customer Name:'); ?></label>
                          <?php echo $widgets['filter-title']->widget; ?>
                        </td>
                        <td>
                          <label for="edit-hardware-ver"><?php echo t('Customer Account Number:'); ?></label>
                          <?php echo $widgets['filter-field_bu_customer_account_number_value']->widget; ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>							
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div style="clear : both"></div>
    </td>
  </tr>	
</table>					






