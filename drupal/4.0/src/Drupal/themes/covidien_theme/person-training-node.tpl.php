<?php
/**
 * @file
 * base file device_availability-add.tpl.php
 */
?>
<script type="text/javascript">
  $(document).ready(function() {
//	$('#container').css('border','none');
    $('#wrapper').css('width', '450px');
    validate_submitbtn();
    $('form').unbind('keypress');
    $('input').keyup(function() {
      validate_submitbtn();
    });
    $('input').change(function() {
      validate_submitbtn();
    });
    $('select').change(function() {
      validate_submitbtn();
    });
  });

  function validate_submitbtn() {
    $('#edit-field-trainer-id-nid-nid').val($('#trainer_list').val());

    $('#edit-field-device-type-nid-nid').val($('#device_type_list').val());
    var empty = false;
    if ($('#user_pl').val() == '') {
      empty = true;
    }
    if ($('#device_type_list').val() == '') {
      empty = true;
    }
    if ($('#trainer_list').val() == '') {
      empty = true;
    }
    if ($('#edit-field-training-completion-date-0-value-datepicker-popup-0').val() == '') {
      empty = true;
    }
    if ($('#edit-field-active-flag-value').val() == '') {
      empty = true;
    }

    if (empty) {
      $('#edit-submit').attr('disabled', 'disabled'); // updated according to 			
      $('#edit-submit').addClass('non_active_blue');
    } else {
      $('#edit-submit').removeAttr('disabled'); // updated according to 			
      $('#edit-submit').removeClass('non_active_blue');
    }
  }
</script>
<table class="form-item-table-full regulatary_approval">
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left" style="padding-left:12px;"><label><?php echo t('User Name:'); ?></label></div>
      </div>
    </td>
    <td class="add_roles">
      <input type="text" id="user_name" value="<?php echo $username; ?>" disabled />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left" style="padding-left:12px;"><label><?php echo t('User Email ID:'); ?></label></div>
      </div>
    </td>
    <td class="add_roles">
      <input type="text" id="user_email_id" value="<?php echo $user_id; ?>" disabled />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><span title="This field is required." class="form-required">*</span> <label><?php echo t('Class of Trade:'); ?></label></div>
      </div>
    </td>
    <td>
      <?php echo $user_pl; ?>
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><span title="This field is required." class="form-required">*</span> <label><?php echo t('Device Type:'); ?></label></div>
      </div>
    </td>
    <td>
      <?php echo $device_type_list; ?>
      <input type="hidden" id="edit-field-device-type-nid-nid" name="field_device_type[nid][nid]" value="" />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><span title="This field is required." class="form-required">*</span> <label><?php echo t('Trainer User ID:'); ?></label></div>
      </div>
    </td>
    <td>
      <?php echo $trainer_list; ?>
      <input type="hidden" id="edit-field-trainer-id-nid-nid" name="field_trainer_id[nid][nid]" value="" />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><span title="This field is required." class="form-required">*</span> <label><?php echo t('Date of Training:'); ?></label></div>
      </div>
    </td>
    <td>
      <?php echo $training_completion_date; ?>
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><span title="This field is required." class="form-required">*</span> <label><?php echo t('Status:'); ?></label></div>
      </div>
    </td>
    <td class="add_roles">
      <?php echo $active_flag; ?>
    </td>
  </tr>
  <td> 
    <br />
    <a id="secondary_submit" href="javascript:void(0)" onclick="javascript:parent.$.colorbox.close();
        return false;"><?php echo t('Cancel'); ?></a>
  </td>
  <td><br />
    <?php echo $save; ?>
  </td>
</tr>
</table>
<div style="display:none">
  <?php echo $render; ?>
  <?php //echo $trainer; ?>
  <?php //echo $device_type; ?>
</div>