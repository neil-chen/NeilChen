<style>
  #edit-select-type {
    width: auto;
  }
  .container-inline-date .description {
    display: none;
  }
  #edit-sw-version {
    width: 173px;
  }
  #software-version-report-form input[type="text"] {
    width: 173px;
  }
</style>
<table width="100%" class="form-item-user-table">
  <tr>
    <td valign="top" class="form-item-user-table-left">
      <div style="display:none;" class="reports_product_line">
        <div><label><?php echo t('Product Line'); ?></label></div>
        <?php echo $product_line; ?>
      </div>
      <div style="padding-top : 50px;" class="reports_menu">
        <?php print $report_menu; ?>
      </div>
    </td>
    <td class="form-item-user-table-right">
      <table class="noborder">
        <tr>
          <td class="noborder" colspan="2">
            <h4><?php echo t('Software Versions Report'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
            <div><label><?php echo t('Device Type:'); ?></label></div>
            <div class="form-item-div">
              <?php echo drupal_render($form['device_type']); ?>
            </div>
          </td>	
        </tr>      
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
            <table style="margin-left: 8px; width: 97%;">              
              <tr>
                <td class="noborder" style="width: 30%;">
                  <div class="label_left"><label><?php echo t('Country:'); ?></label></div>
                  <div class="form-item-div"><?php echo drupal_render($form['country']); ?></div>
                </td>
                <td class="noborder" style="width: 30%;" align="center">
                  <div class="form-item-div">
                    <div><label><?php echo t('and / or'); ?></label></div>
                    <?php echo drupal_render($form['and_or']); ?>
                    <input type="button" class="form-submit" value="AND" id="condition_button"/>
                  </div>
                </td>
                <td class="noborder" style="width: 33%;">
                  <div class="form-item-right" style="margin-right: 40px;">
                    <div><label><?php echo t('Region:'); ?></label></div>
                    <?php echo drupal_render($form['region']); ?>
                  </div>
                </td>
              </tr>
            </table>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left: 22px;">
            <div class="form-item-div">
              <div><label><?php echo t('Customer Name:'); ?></label></div>
              <?php echo drupal_render($form['customer_name']); ?>
            </div>
          </td>	
          <td class="noborder">
            <div class="form-item-right" style="margin-right: 60px;">
              <div><label><?php echo t('Customer Address:'); ?></label></div>
              <?php echo drupal_render($form['customer_address']); ?>
            </div>
          </td>
        </tr>
        <tr>
          <td class="noborder" style="padding-left: 22px;">
            <div class="form-item-div">
              <div><label><?php echo t('Customer City:'); ?></label></div>
              <?php echo drupal_render($form['customer_city']); ?>
            </div>
          </td>	
          <td class="noborder">
            <div class="form-item-right" style="margin-right: 60px;">
              <div><label><?php echo t('Customer State:'); ?></label></div>
              <?php echo drupal_render($form['customer_state']); ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left: 22px;">
            <div class="form-item-div">
              <div><label><?php echo t('User entered facility:'); ?></label></div>
              <?php echo drupal_render($form['user_facility']); ?>
            </div>
          </td>	
          <td class="noborder">
            <div class="form-item-right" style="margin-right: 60px;">
              <div><label><?php echo t('Device serial number:'); ?></label></div>
              <?php echo drupal_render($form['ds_number']); ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left: 22px;">
            <div class="form-item-div">
              <div><label><?php echo t('Software name and version:'); ?></label></div>
              <?php echo drupal_render($form['sw_version']); ?>
            </div>
          </td>	
          <td class="noborder">
            <div class="form-item-div" style="margin-left: 150px;">
              <div><label><?php echo t('Last dock date:'); ?></label></div>
              <?php echo drupal_render($form['last_date_docked']); ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" colspan="2" align="right">
            <?php echo drupal_render($form['submit']); ?>
          </td>	
        </tr>
      </table>
    </td>
  </tr>
</table>
<script type="text/javascript">
  $(document).ready(function() {
    $('#condition_button').click(function() {
      if ($(this).val() == 'AND') {
        $(this).val('OR');
        $('#and_or').val('OR');
      } else {
        $(this).val('AND');
        $('#and_or').val('AND');
      }
    });
  });
  //document ready end
</script>