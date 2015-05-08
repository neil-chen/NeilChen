<style>
  .grippie {
    margin-left: 8px;
  }
  #add-placeholders input {
    height: 20px;
    font-size: 12px;
  }
  #edit-content-wrapper {
    float: left;
    width: 800px;
  }
  .grippie {
    padding: 0;
    margin: 0;
  }
</style>
<table class="form-item-table-full add_new" style="margin-left: -5px;">
  <tbody>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('1. Select Device Type'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="form-item-div">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
          </div>
          <div>
            <div class="form-item-left">
              <?php echo drupal_render($form['sel_device_type']); ?>
            </div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('2. Enter Template Name:'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="form-item-div">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
          </div>
          <div>
            <div class="form-item-left">
              <?php echo drupal_render($form['template_name']); ?>
            </div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('3. Select Alert Category'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="form-item-div">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
          </div>
          <div>
            <div class="form-item-left">
              <?php echo drupal_render($form['sel_alert_category']); ?>
            </div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('4. Select Alert Event'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="form-item-div">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
          </div>
          <div>
            <div class="form-item-left">
              <?php echo drupal_render($form['sel_alert_event']); ?>
            </div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('5. Select Delivery'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="form-item-div">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
          </div>
          <div>
            <div class="form-item-left">
              <?php echo drupal_render($form['sel_delivery']); ?>
            </div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('6. Enter Information for Message Template'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="label_left">
          <label><?php echo t('Template Content:'); ?> </label>
          <div class="form-item" id="add-placeholders">
            <span>Placeholders:</span>
            <input id="add-device-type" data="{device_type}" type="button" class="secondary_submit" value="Device Type" />
            <input id="add-device-serial-nubmer" data="{device_serial_nubmer}" type="button" class="secondary_submit" value="Device Serial Nubmer" />
            <input id="add-reason" data="{reason}" type="button" class="secondary_submit" value="Reason" />
          </div>
        </div>
        <div class="form-item-div">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
          </div>
          <div class="form-item" id="edit-content-wrapper">
            <?php echo drupal_render($form['template_content']); ?>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="label_left">
          <label><?php echo t('Subject Line'); ?> </label>
        </div>
        <div class="form-item-div">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
          </div>
          <div class="form-item" id="edit-description-wrapper">
            <?php echo drupal_render($form['template_subject']); ?>
          </div>
        </div>
      </td>
    </tr>
  </tbody>
</table>
<div class="form-item-div" id="div_button" style="clear: both; float: right; width: 90%">
  <div class="form-item-right" style="width: 350px; padding-right: 10px;">
    <div style="float: left; padding-left: 100px;">
      <a id="secondary_submit" href="<?php echo url('alert/template/list'); ?>"><?php echo t('Cancel'); ?> </a>
    </div>
    <div style="float: right;">
      <?php echo drupal_render($form['submit']); ?>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    validateForm();
    $('input').change(validateForm);
    $('textarea').change(validateForm);
    $('select').change(validateForm);
    $('input').click(validateForm);
    //placeholders
    $('#add-placeholders').find('input[type=button]').click(function() {
      var data = $(this).attr('data');
      insertText($('#template_content')[0], data);
    });
    //sel_alert_category
    var device_option = $('#edit-field-device-type-nid').html();
    var sel_alert_event = $('#sel_alert_event').val();
    technic_no_devicetype(device_option, sel_alert_event);
    $('#sel_alert_category').change(function() {
      technic_no_devicetype(device_option, sel_alert_event);
    });
    $('#edit-field-device-type-nid').change(function() {
      window.selectedDeviceTypeNid = $(this).val();
    });
  });

  function technic_no_devicetype(device_option, sel_alert_event) {
    $.get(Drupal.settings.basePath + 'alert/ajax/get_alert_event_list', {'alert_category': $('#sel_alert_category').val()}, function(data) {
      response = Drupal.parseJson(data);
      if (response.status = 'success') {
        var option_html = $(response.data).find('select').html();
        $('#sel_alert_event').html(option_html);
        $('#sel_alert_event').val(sel_alert_event);
        if ($('#sel_alert_category').find('option:selected').text() == 'Technic') {
          $('#edit-field-device-type-nid').val(26).attr('readonly');
        } else {
          $('#edit-field-device-type-nid').html(device_option).removeAttr('readonly').val(window.selectedDeviceTypeNid);
        }
      }
    });
  }

  function disableSubmit() {
    $("#btn-submit").removeClass("form-submit");
    $("#btn-submit").addClass("non_active_blue");
    $("#btn-submit").attr("disabled", true);
  }

  function enableSubmit() {
    $("#btn-submit").removeClass("non_active_blue");
    $("#btn-submit").addClass("form-submit");
    $("#btn-submit").removeAttr("disabled");
  }

  function validateForm() {
    var isValidationPass = true;
    if (!check_input($('#template_name'))) {
      isValidationPass = false;
    }
    if (!check_input($('#template_content'))) {
      isValidationPass = false;
    }
    if (!check_input($('#template_subject'))) {
      isValidationPass = false;
    }
    if (isValidationPass) {
      enableSubmit();
    } else {
      disableSubmit();
    }
    return isValidationPass;
  }

  function check_input(obj) {
    var input_value = obj.val();
    if (input_value == '' || input_value == 0 || input_value == 'All' || input_value == 'all') {
      return false;
    }
    return true;
  }

  function insertText(obj, str) {
    if (document.selection) {
      obj.focus();
      var sel = document.selection.createRange();
      sel.text = str;
      sel.select();
    } else if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number') {
      var startPos = obj.selectionStart,
              endPos = obj.selectionEnd,
              cursorPos = startPos,
              tmpStr = obj.value;
      obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
      cursorPos += str.length;
      obj.selectionStart = obj.selectionEnd = cursorPos;
    } else {
      obj.value += str;
    }
  }
</script>
