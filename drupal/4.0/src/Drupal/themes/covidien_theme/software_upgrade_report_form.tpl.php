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
            <h4><?php echo t('Software Upgrade Report'); ?></h4>	
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
          <td colspan="2" class="noborder">
            <table>
              <tbody>
                <tr>
                  <td class="noborder">
                    <div class="label_left"><label><?php echo t('Customer Name:'); ?></label></div>
                    <div class="form-item-div">
                      <div class="form-item-left"><span title="This field is required." class="form-required">*</span></div>
                      <?php echo $customer_name; ?>
                    </div>
                  </td>	
                  <td class="noborder">
                    <div class="form-item-left">
                      <div><label><?php echo t('and / or'); ?></label></div>
                      <?php echo $condition_button; ?>
                      <?php echo $hid_condition; ?>
                    </div>
                    <div class="form-item-right" style="margin-right: 40px;">
                      <div><label><?php echo t('Country:'); ?></label></div>
                      <?php echo $country; ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class="noborder" style="width : 33%; padding-left : 14px;">
            <div class="form-item-left">
              <div><label><?php echo t('Customer Account Number:'); ?></label></div>
              <?php echo $account_number; ?>
            </div>
          </td>
          <td class="noborder">
            <div class="form-item-left">
              <div><label><?php echo t('From Date:'); ?></label></div>
              <?php echo $from_date; ?>
            </div>
            <div class="form-item-right" style="margin-right: 115px;">
              <div><label><?php echo t('To Date:'); ?></label></div>
              <?php echo $to_date; ?>
            </div>
          </td>	
        </tr>	
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div class="form-item-div">
              <div class="form-item-left">
                <div><label><?php echo t('Status:'); ?></label></div>
              </div>
              <div class="form-item-left" style="padding-left : 30px;">
                <?php echo $pass_fail_status; ?>
              </div>
            </div>
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

<script type="text/javascript">

  $(document).ready(function() {
    $('#hid_condition').val($("#condition_button").val());
  });

  function change_condeition() {
    var condition = $("#condition_button").val() == "or" ? "and" : "or";
    $("#condition_button").val(condition);
    $('#hid_condition').val(condition);

    return false;

  }

</script>

