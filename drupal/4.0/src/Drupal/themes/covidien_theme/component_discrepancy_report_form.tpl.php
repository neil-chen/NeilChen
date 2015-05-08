<?php
/**
 * sprint 7
 */
?>
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
            <h4><?php echo t('Component Discrepancy Report'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2">
            <div class="label_left"><label><?php echo t('Device Type:'); ?></label></div>
            <div class="form-item-div">
              <div class="form-item-left"><span title="<?php echo t("This field is required."); ?>" class="form-required">*</span></div>
              <?php echo $device_type; ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Country:'); ?></label></div>
            <div class="form-item-div">
              <div class="form-item-left"></div>
              <?php echo $country; ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" width="35%">
            <div class="label_left"><label><?php echo t('Customer Name:'); ?></label></div>
            <div class="form-item-div">
              <div class="form-item-left"><span class="form-required" title="<?php echo t("This field is required."); ?>">*</span></div>
              <?php echo $customer_name; ?>							
            </div>
          </td>	
          <td class="noborder" width="65%">
            <div><label><?php echo t('Customer Account Number:'); ?></label></div>
            <div>
              <?php echo $account_number; ?>
            </div>
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Device Serial Number'); ?></label></div>
            <?php echo $ds_number; ?>
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
