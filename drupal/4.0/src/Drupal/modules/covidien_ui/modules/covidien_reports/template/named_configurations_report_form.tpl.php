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
    <td class="form-item-user-table-right" valign="top">
      <table class="noborder">
        <tr>
          <td class="noborder" colspan="2">
            <h4><?php echo t('Named Configurations Report'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Search for Device type:'); ?></label></div>
            <div class="form-item-div">
              <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
              <?php echo drupal_render($form['device_type']); ?>
            </div>
          </td>	
        </tr>
        <tr>
          <td style="border-right:0px">
          	<div class="view-footer form-item-div">
                <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('/covidien/reports/named_configurations_report_pdf/'+$('#edit-device-type').val(), '_blank');
                    return true;" value="<?php echo t("Download as PDF"); ?>" id="edit-new-csv"></div>
                <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('/covidien/reports/named_configurations_report_xls/'+$('#edit-device-type').val(), '_blank');
                    return true;" value="<?php echo t("Download as XLS"); ?>" id="edit-new-pdf"></div>
                <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('/covidien/reports/named_configurations_report_csv/'+$('#edit-device-type').val(), '_blank');
                    return true;" value="<?php echo t("Download as CSV"); ?>" id="edit-new-add"></div>
            </div>
          </td>
          <!-- 
          <td class="noborder" align="right">
            <?php echo drupal_render($form['submit']); ?>
          </td>
           -->	
        </tr>
      </table>
    </td>
  </tr>
</table>
<script>
$(document).ready(function() {
    enableButton();
    $('#edit-device-type').bind('change',enableButton);
    $("#edit-device-type").bind("change", function() {
        $.ajax({
          type: "POST",
          url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
          data: {value: $('#edit-device-type').val()}
        });
      });
});

function enableButton(){
    if($('#edit-device-type').val() != 'all' && $('#edit-device-type').val() != ''){
        $('input[id^=edit-new]').attr('disabled', false);
        $('#edit-submit').attr('disabled', false);
        $("#edit-submit").removeClass("non_active_blue");
        $("#edit-submit").addClass("form-submit");
        $('input[id^=edit-new]').addClass("form-submit");
        $('input[id^=edit-new]').addClass("secondary_submit");
    }else{
        $('input[id^=edit-new]').attr('disabled', true);
        $('#edit-submit').attr('disabled', true);
        $("#edit-submit").removeClass("form-submit");
        $("#edit-submit").addClass("non_active_blue");
        $('input[id^=edit-new]').removeClass("form-submit");
        $('input[id^=edit-new]').removeClass("secondary_submit");
    }
}
</script>