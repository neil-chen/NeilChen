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
drupal_add_js(drupal_get_path('module', 'covidien_activity') . '/js/covidien_activity.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/covidien_users.js');
?>
<?php if (!empty($q)): ?>
  <?php
  global $base_url;
  // This ensures that, if clean URLs are off, the 'q' is added first so that
  // it shows up first in the URL.
  print $q;
  ?>
<?php endif; ?>
<script type="text/javascript">
  $(document).ready(function() {
    var val = $('#edit-last-name').val();
    if (val == "") {
      $('#edit-last-name').val(Drupal.t('Enter user name'));
    }
    var val = $('#edit-isemp').val();
    if (val != "") {
      disablefun(val);
    }

    $('#edit-last-name').focus(function() {
      var val = $(this).val();
      if (val == Drupal.t("Enter user name")) {
        $('#edit-last-name').val('');
      }
      else {
      }
    });
    $('#edit-last-name').blur(function() {
      var val = $(this).val();
      if (val == "") {
        $('#edit-last-name').val(Drupal.t("Enter user name"));
      }
    });
    $('#edit-isemp').change(function() {
      disablefun($(this).val());
    });
    $('#edit-submit-activitylog').click(function() {
      var val = $('#edit-last-name').val();
      if (val == Drupal.t("Enter user name")) {
        $('#edit-last-name').val('');
      }
    });

    function disablefun(val) {
      $("#customer_name,#edit-bid,#account_number").attr('disabled', '');
      if (val == "No") {
        $("#edit-bid").attr('disabled', 'disabled');
      }
      else if (val == "Yes") {
        $("#customer_name,#account_number").attr('disabled', 'disabled');
      }
    }
  });
</script>		
<table class="form-item-table-full">
  <tr>
    <td>
      <h2><?php echo t('User Activity Monitor'); ?></h2>
    </td>
    <td align="right">
    </td>
  </tr>
  <tr>
    <td valign="top">
      <div>
        <label><?php echo t('Search for a User:'); ?></label>
      </div>
      <div id="softwarelist_page1" class="oval_search_wraper">
        <?php echo $widgets['filter-field_last_name_value']->widget; ?>
      </div>
      <div class="views-exposed-widget views-submit-button" style="padding-top : 10px;" >
        <?php echo $button; ?>	
      </div>	
    </td>
    <td valign="top" >
      <table class="form-item-user-table">
        <tbody>
          <tr>
            <td>
              <div>
                <label><?php echo t('Filter Categories:'); ?> </label>
              </div>
              <table class="border_div">
                <tbody>
                  <tr>
                    <td>
                      <label for="edit-hardware-type"><?php echo t('Select Role'); ?> </label>
                      <?php echo $widgets['filter-field_app_role_pk_nid']->widget; ?>
                    </td>
                    <td>
                      <label for="edit-hardware-name"><?php echo t('Covidien Employee'); ?> </label>
                      <?php echo $widgets['filter-field_covidien_employee_value_many_to_one']->widget; ?>
                    </td>
                    <td>
                      <label for="edit-hardware-ver"><?php echo t('Covidien Business Unit'); ?> </label>
                      <?php echo $widgets['filter-field_business_unit_nid']->widget; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="edit-hardware-name"><?php echo t('Customer Name'); ?> </label>
                      <?php echo $widgets['filter-title']->widget; ?>
                    </td>
                    <td>
                      <label for="edit-hardware-acc"><?php echo t('Customer Account Number'); ?> </label>
                      <?php echo $widgets['filter-field_bu_customer_account_number_value']->widget; ?>
                    </td>
                    <td>
                      &nbsp;
                    </td>
                  </tr>
                </tbody>
              </table>							
            </td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>				
</table>
