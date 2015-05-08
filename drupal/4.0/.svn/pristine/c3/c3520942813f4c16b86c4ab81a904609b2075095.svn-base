<style>
  #edit-select-type {
    width: auto;
  }
</style>
<table width="100%" class="form-item-user-table">
  <tr>
    <td valign="top" class="form-item-user-table-left">
      <div style="display: none;" class="reports_product_line">
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
            <h4><?php echo t('Device Historical Configuration Report'); ?></h4>  
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
          	<div class="label_left"><label><?php echo t('Device Serial Number:'); ?></label></div>
            <div class="form-item-div">
            <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
            <?php echo $ds_number; ?></div>
          </td>
        </tr>
        <!--  
        <tr>
          <td class="noborder">
            <?php echo $region; ?>
          </td>
          <td class="noborder">
            <?php echo $country; ?>
          </td>
        </tr>
        
        <tr>
          <td class="noborder">
            <?php echo $customer_name; ?>
          </td>
          <td class="noborder">
            <?php echo $last_dock_date; ?>
          </td>
        </tr>
        
        <tr>
          <td class="noborder">
            <?php echo $software_name; ?>
          </td>
          <td class="noborder">
            <?php echo $software_version; ?>
          </td>
        </tr>
        -->
        <input type='hidden' name='pro_line' id='pro_line' />
        <input type='hidden' name='pro_line_name' id='pro_line_name' />
      
      
        <tr>
          <td class="noborder" colspan="2" align="right"><?php echo $search_button; ?> <?php echo $form_extras; ?></td>
        </tr>
        
      </table>
    </td>
  </tr>
</table>



<script type="text/javascript">

$(document).ready(function() {
    $("#edit-device-type").bind("change", function() {
        $.ajax({
          type: "POST",
          url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
          data: {value: $('#edit-device-type').val()}
        });
      });

});

function enableButton(){
    if($('#edit-device-type').val() != 'all' && $('#edit-device-type').val() != ''
        && $('#edit-ds-number').val() != 'all' && $('#edit-ds-number').val() != ''){
        $('input[id^=edit-new]').attr('disabled', false);
        $('#edit-submit').attr('disabled', false);
        $("#edit-submit").removeClass("non_active_blue");
        $("#edit-submit").addClass("form-submit");
    }else{
        $('input[id^=edit-new]').attr('disabled', true);
        $('#edit-submit').attr('disabled', true);
        $("#edit-submit").removeClass("form-submit");
        $("#edit-submit").addClass("non_active_blue");
    }
}

function parentvalues(autopath) {
    // Get the url from the child autocomplete hidden form element
    var url = '';
    // Alter it according to parent value  
    var arg = '';
    arg = arg + '/' + $('#edit-product-line').val();
    arg = arg + '/' + $('#edit-device-type').val();
    arg = arg + '/' + 'all';//$('#edit-customer-name').val();
    arg = arg + '/' + 'all';//$('#edit-software-name').val();
    arg = arg + '/' + 'all';//$('#edit-part-number').val();
    arg = arg + '/' + 'all';//$('#edit-version').val();
    url = Drupal.settings.basePath + "covidien/" + autopath + "/autocomplete" + arg;
    // Recreate autocomplete behaviour for the child textfield
    var input = $('#edit-ds-number').attr('autocomplete', 'OFF')[0];
    recreateAutoCompleteReport(input, url);
}

</script>
