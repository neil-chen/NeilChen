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
            <h4><?php echo t('Audit Trail Report'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Search for a User:'); ?></label></div>
            <div class="form-item-div">
              <?php echo $last_name; ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Email Address:'); ?></label></div>
            <div class="form-item-div">
              <?php echo $username; ?></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;" width="35%">
            <div><label><?php echo t('Customer Name:'); ?></label></div>
            <?php echo $cid; ?>
          </td>	
          <td class="noborder" width="65%">
            <div><label><?php echo t('Customer Account Number:'); ?></label></div>
            <?php echo $comp_account_no; ?>
          </td>	
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Select Activity Type:'); ?></label></div>
            <div class="form-item-div">
              <?php echo $activity_type; ?></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;" width="35%">
            <div><span title="This field is required." class="form-required">*</span> <label><?php echo t('From Date:'); ?></label></div>
            <div class="form-item-div">
              <?php echo $from_date; ?>
            </div>
          </td>	
          <td class="noborder">
            <div> <label><?php echo t('To Date:'); ?></label></div>
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
