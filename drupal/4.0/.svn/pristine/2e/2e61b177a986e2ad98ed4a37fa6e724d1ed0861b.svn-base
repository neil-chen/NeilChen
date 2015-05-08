<?php global $base_url; ?>
<table width="100%" class="form-item-user-table">
  <tr>
    <td valign="top" class="form-item-user-table-left">
      <div style="display: none;" class="reports_product_line">
        <div><label><?php echo t('Product Line'); ?></label></div>
        <?php echo $product_line; ?></div>
      <div style="padding-top: 50px;" class="reports_menu"><?php print $report_menu; ?></div>
    </td>
    <td class="form-item-user-table-right">
      <table class="noborder">
        <tr>
          <td class="noborder" colspan="2">
            <h4><?php echo t('Device Current Configuration Report'); ?></h4>
          </td>
        </tr>
        <tr>
          <td class="noborder">
            <div class="label_left"><label><?php echo t('Device Type:'); ?></label></div>
            <div class="form-item-div">
              <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
              <?php echo $device_type; ?></div>
          </td>
          <td class="noborder">
            <div class="form-item-left">
              <div><label><?php echo t('Customer Account Number:'); ?></label></div>
              <?php echo $account_number; ?></div>
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="3">
            <table>
              <tr>
                <td class="noborder" style="width: 33%;">
                  <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
                  <div class="label_left"><label><?php echo t('Customer Name:'); ?></label></div>
                  <div class="form-item-div"><?php echo $customer_name; ?></div>
                </td>
                <td class="noborder">
                  <div class="form-item-left">
                    <div><label><?php echo t('and / or'); ?></label></div>
                    <?php echo $condition_button; ?> <?php echo $hid_condition; ?></div>

                  <div class="form-item-right" style="margin-right: 40px;">
                    <div><label><?php echo t('Country:'); ?></label></div>
                    <?php echo $country; ?></div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="noborder" style="padding-left: 14px;">
            <div><label><?php echo t('Hardware Name:'); ?></label></div>
            <?php echo $hw_name; ?></td>
          <td class="noborder">
            <div class="form-item-div">
              <div class="form-item-left">
                <div><label><?php echo t('Hardware Part #:'); ?></label></div>
                <?php echo $hw_part_number; ?></div>
              <div class="form-item-right" style="margin-right: 40px;">
                <div><label><?php echo t('Hardware Revision:'); ?></label></div>
                <?php echo $hw_version; ?></div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="noborder" style="padding-left: 14px;">
            <div><label><?php echo t('Software Name:'); ?></label></div>
            <?php echo $software_name; ?></td>
          <td class="noborder">
            <div class="form-item-div">
              <div class="form-item-left">
                <div><label><?php echo t('Software Part #:'); ?></label></div>
                <?php echo $part_number; ?></div>
              <div class="form-item-right" style="margin-right: 40px;">
                <div><label><?php echo t('Software Version:'); ?></label></div>
                <?php echo $version; ?></div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="noborder" style="padding-left: 14px;">
            <div><label><?php echo t('Device Serial Number'); ?></label></div>
            <?php echo $ds_number; ?>
          </td>
          <td class="noborder">
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" align="right"><?php echo $search_button; ?> <?php echo $form_extras; ?></td>
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
