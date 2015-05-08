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
        <h4><?php echo t('Device Country Change Report'); ?></h4>
        </td>
      </tr>
      <tr>
        <td class="noborder">
          <div class="label_left"><label><?php echo t('Device Type:'); ?></label></div>
          <div class="form-item-div">
            <div class="form-item-left"><span class="form-required" title="This field is required.">*</span></div>
            <?php echo $device_type; ?>
          </div>
        </td>
        <td class="noborder">
        <div class="form-item-left">
        <div><label><?php echo t('User ID:'); ?></label></div>
        <?php echo $user_id; ?></div>
        </td>
      </tr>


      <tr>
        <td class="noborder" style="padding-left: 14px;">
          <div>
            <label><?php echo t('From Date:'); ?></label>
            <span class="form-required" title="This field is required.">*</span>
          </div>
          <?php echo $from_date; ?>
        </td>
        
        
        <td class="noborder">
          <div class="form-item-div">
          <div class="form-item-left">
          <div>
            <label><?php echo t('To Date:'); ?></label>
            <span class="form-required" title="This field is required.">*</span>
          </div>
          <?php echo $to_date; ?></div>
          </div>
        </td>
      </tr>

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
    var device_type_hidden = 0;

    var formid = "#device-country-change-form";
    $(formid + " #edit-product-line").ajaxStop(function() {
      var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
      $(wrapper).html($(wrapper + ' div').html());
      $('#edit-device-type').val($('#edit-device-type-hidden').val());
      if ($('#edit-device-type').val() != 'all' && device_type_hidden != 1) {
        $(formid + ' #edit-device-type').trigger('change');
        device_type_hidden = 1;
      }
    });
    $(formid + ' #edit-product-line').trigger('change');
    $(formid + ' select').change(function() {
//      child_reset($(this).attr('id'));
      $('select option:nth-child(2n+1)').addClass('color_options');
    });
  });


  $(document).ready(function() {
    $('#hid_condition').val($("#condition_button").val());
  });

  function country_change_form_commit(){
    changeDeviceType();
    if($("#edit-device-type").val()>0){
      $('#pro_line').val($('#global_product_line').val());
      $('#pro_line_name').val($('#global_product_line').find("option:selected" ).text());
        
      return true;
    }
	  return false ;
  }

  function changeDeviceType(){
    var device_type_name  = $("#edit-device-type").find("option:selected" ).text();
    $("#edit-device-type-name").val(device_type_name);
  }

</script>
