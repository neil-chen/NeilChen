<?php global $base_url; ?>
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
            <h4><?php echo t('Training Report'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2">
            <div class="label_left"><label><?php echo t('Device Type:'); ?></label></div>
            <div class="form-item-div">
              <div class="form-item-left"><span title="This field is required." class="form-required">*</span></div>
              <?php echo $device_type; ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Trainer User ID:'); ?></label></div>
            <?php echo $trainer_id; ?>

          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo t('Customer Name:'); ?></label></div>
            <div >						
              <?php echo $customer_name; ?>
            </div>
          </td>	
          <td class="noborder">
            <div><label><?php echo t('Customer Account Number:'); ?></label></div>
            <div>
              <?php echo $account_number; ?>
            </div>
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Status:'); ?></label></div>
            <?php echo $training_status; ?>

          </td>	
        </tr>
        <tr>
          <td class="noborder" style="width : 33%; padding-left : 14px;">
            <div><span title="This field is required." class="form-required">*</span><label><?php echo t('From Date:'); ?></label></div>
            <?php echo $from_date; ?>
          </td>
          <td class="noborder">
            <div><label><?php echo t('To Date:'); ?></label></div>
            <?php echo $to_date; ?>
          </td>	
        </tr>				

        <tr>
          <td class="noborder" colspan="2" align="right">
            <?php echo $search_button; ?>
            <?php echo $form_extras; ?>
          </td>	
        </tr>
      </table>
    </td>
  </tr>
</table>
