<style>
  .form-checkboxes .form-item, .form-radios .form-item {
    float: left;
    margin-left: 10px;
  }
  #schedule-item-list, #schedule-item-info {
    margin-top: 10px;
  }
  .form-radios .form-item:first-child, .form-checkboxes .form-item:first-child {
    margin-left: 0;
  }
  table.form-item-table-full  tr td {
    padding-left: 0;
  }
  #alert-notification-form .form-item .description {
    display: block;
  }
  #alert-notification-form .date-clear-block .form-item {
    float: left;
  }
  #alert-notification-form #edit-from-date-wrapper, #edit-to-date-wrapper, #edit-schedule-date-wrapper{
    width: auto;
  }
  #time_zone {
    width: auto;
  }
</style>
<div id="alert-notification-form">
  <table class="form-item-table-full add_new">
    <tbody>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Alert Event:'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['sel_alert_event']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Notification Name:'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['notification_name']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Select Time Zone'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['sel_time_zone']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Display on Home Page'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['display_on_home']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr id="from-date">
        <td style="padding-left: 20px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('From Date'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['from_date']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr id="to-date">
        <td style="padding-left: 20px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('To Date'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['to_date']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Activate General Notification'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['active_status']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Delivery'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['delivery']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Message'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['message']); ?>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <div class="form-item-left">
            <span title="This field is required." class="form-required">*</span>
            <lable>
              <?php echo t('Summary/Notes'); ?>
            </lable>
          </div>
        </td>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <?php echo drupal_render($form['summary_notes']); ?>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <input type="hidden" name="markCompleted" id="markCompleted"/>
  <input type="hidden" name="isAdmin" id="isAdmin" value="<?php
  if (isAdmin()) {
    echo "Y";
  } else {
    echo "N";
  }
  ?>"/>
         <?php echo drupal_render($form['notification_id']); ?>

  <div id="schedule-item-list">
    <div class="form-item-div">
      <h4>
        <?php echo t('Schedule Item List'); ?>
      </h4>
    </div>
    <div class="form-item-table_list">
      <?php echo $schedule_list; ?>
    </div>
  </div>

  <div id="schedule-item-info">
    <div class="form-item-div">
      <h4>
        <?php echo t('Schedule Item Information'); ?>
      </h4>
    </div>
    <div id="schedule-item-info-form">
      <?php echo $schedule_form; ?>
    </div>
  </div>

  <div class="form-item-div" id="div_button" style="clear: both; float: right; width: 90%">
    <div class="form-item-right" style="width: 350px; padding-right: 10px;">
      <?php if (isAdmin()) { ?>
        <div style="float: right;">
          <?php
          if (arg(1) == 'notification-history') {
            $form['submit']['#value'] = 'Save Notification History';
            $form['submit']['#attributes'] = array();
          }
          ?>
          <?php echo drupal_render($form['submit']); ?>
        </div>
      <?php } ?>
      <div style="float: right; padding-right: 20px;">
        <a id="secondary_submit" href="<?php
        if (arg(1) == 'notification') {
          echo url('alert/notification/list');
        } else {
          echo url('alert/notification-history/list');
        }
        ?>"><?php echo t('Cancel'); ?> </a>
      </div>
      <?php if (isAdmin() && $notification_id && arg(1) == 'notification') { ?>
        <div>
          <input type="submit" class="form-submit" value="Mark as completed" id="mark-submit" name="mark">
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    //remove date format example.
    $('.container-inline-date .description').remove();
    displayDateRange();
    dispalyRecipientsArea();
    validateForm();
    $('input[name="display_on_home"]').change(displayDateRange);
    $('#sel_alert_event').bind('change', dispalyRecipientsArea);
    $('input').change(validateForm);
    $('textarea').change(validateForm);
    $('select').change(validateForm);
    $("#btn-submit").click(formSubmit);
    $("#mark-submit").click(formSubmit);
    //placeholders
    $('#add-placeholders').find('input[type=button]').click(function() {
      var data = $(this).attr('data');
      insertText($('#template_content')[0], data);
    });
    //sel_alert_category
    $('#sel_alert_category').change(function() {
      $.get(Drupal.settings.basePath + 'alert/ajax/get_alert_event_list', {'alert_category': $(this).val()}, function(data) {
        response = Drupal.parseJson(data);
        if (response.status = 'success') {
          var option_html = $(response.data).find('select').html();
          $('#sel_alert_event').html(option_html);
        }
      });
    });
    //fix checkbox change event on IE
    if ($.browser.msie) {
      $('input:radio').click(function() {
        $(this).blur();
        $(this).focus();
        $(this).change();
      });
      $('input:checkbox').click(function() {
        $(this).blur();
        $(this).focus();
        $(this).change();
      });
    }

    if (window.location.pathname.indexOf("notification-history") > -1 || $('#isAdmin').val() == 'N') {
      $('#alert-notification-form input').attr("disabled", true);
      $('#alert-notification-form textarea').attr("disabled", true);
      $('#alert-notification-form input[name=display_on_home]').attr("disabled", false);
      $('#alert-notification-form input[name=notification_id]').attr("disabled", false);
      $('#btn-submit').attr("disabled", false);
      $('#markCompleted').attr("disabled", false);
    }
  });
  //document ready end

  function formSubmit() {
    if ($(this).attr('id') == 'mark-submit') {
      $("#markCompleted").val("markCompleted");
    }
    if ($(this).val() == 'Save Notification History') {
      $("#markCompleted").val('Save Notification History');
    }
    $("form#alert-notification-form").attr("action", Drupal.settings.basePath + "alert/notification/save");
    $("form#alert-notification-form").submit();
  }
  function disableSubmit() {
    $("#btn-submit").removeClass("form-submit");
    $("#btn-submit").addClass("non_active_blue");
    $("#btn-submit").attr("disabled", "disabled");
  }

  function enableSubmit() {
    $("#btn-submit").removeClass("non_active_blue");
    $("#btn-submit").addClass("form-submit");
    $("#btn-submit").removeAttr("disabled");
  }
  function displayDateRange() {
    if ($('input[name="display_on_home"]:checked').val() == 'Y') {
      $('#from-date').show();
      $('#to-date').show();
    } else {
      $('#from-date').hide();
      $('#to-date').hide();
    }
  }
  function dispalyRecipientsArea() {
    $('#schedule_alert_event').val($('#sel_alert_event :selected').text());
    if ($('#sel_alert_event :selected').text() == 'System Upgrade Notice') {
      $('#covidien-only-radio').show();
      $('#div-device-type').hide();
    } else {
      $('#covidien-only-radio').hide();
      $('#div-device-type').show();
    }
  }
  function validateForm() {
    var isValidationPass = true;
    if (!check_input($('#notification_name'))) {
      isValidationPass = false;
    }
    if (!check_input($('input[name="display_on_home"]:checked'))) {
      isValidationPass = false;
    }
    if (!check_input($('#time_zone'))) {
      isValidationPass = false;
    }
    if ($('input[name="display_on_home"]:checked').val() == 'Y') {
      if (!check_input($('#edit-from-date-datepicker-popup-0'))) {
        isValidationPass = false;
      }
      if (!check_input($('#edit-to-date-datepicker-popup-0'))) {
        isValidationPass = false;
      }
    }
    if (!check_input($('input[name="active_status"]'))) {
      isValidationPass = false;
    }
    if (!check_input($('#edit-delivery-1'))) {
      isValidationPass = false;
    }
    if (!check_input($('#summary_notes'))) {
      isValidationPass = false;
    }
    if (!check_input($('#edit-delivery-1'))) {
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
</script>
