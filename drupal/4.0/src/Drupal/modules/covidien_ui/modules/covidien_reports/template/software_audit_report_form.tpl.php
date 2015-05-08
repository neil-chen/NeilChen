<style>
  #edit-select-type {
    width: auto;
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
            <h4><?php echo t('Software Audit Report'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Search Type:'); ?></label></div>
            <div class="form-item-div">
              <?php echo drupal_render($form['select_type']); ?>
            </div>
          </td>	
        </tr>
        <tr id="tr-device-type">
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Device type:'); ?></label></div>
            <div class="form-item-div">
              <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
              <?php echo drupal_render($form['device_type']); ?>
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
<script>
$(document).ready(function() {
    enableButton();
    $('#edit-device-type').bind('change',enableButton);
    $('#edit-select-type').bind('change',enableButton);
    $("#edit-device-type").bind("change", function() {
        $.ajax({
          type: "POST",
          url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
          data: {value: $('#edit-device-type').val()}
        });
      });
});

function enableButton(){
    if($('#edit-select-type').val() == 1){
      $('#tr-device-type').show();
      if($('#edit-device-type').val() != 'all' && $('#edit-device-type').val() != ''){
          $('#edit-submit').attr('disabled', false);
          $("#edit-submit").removeClass("non_active_blue");
          $("#edit-submit").addClass("form-submit");
      }else{
          $('#edit-submit').attr('disabled', true);
          $("#edit-submit").removeClass("form-submit");
          $("#edit-submit").addClass("non_active_blue");
      }
    }else{
        $('#tr-device-type').hide();
        $('#edit-submit').attr('disabled', false);
        $("#edit-submit").removeClass("non_active_blue");
        $("#edit-submit").addClass("form-submit");
    }
}
</script>