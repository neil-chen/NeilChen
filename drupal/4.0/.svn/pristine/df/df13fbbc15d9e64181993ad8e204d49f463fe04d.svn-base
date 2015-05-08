<style>
  #edit-schedule-date-wrapper .description {
    display: none;
  }
  #schedule-item-info {
    margin-left: 10px;
  }
</style>
<?php echo drupal_render($form['schedule_id']); ?>
<table class="form-item-table-full add_new">
  <tbody>
    <tr>
      <td style="padding-left: 0px;">
        <div class="form-item-left">
          <lable>
            <?php echo t('Schedule Date'); ?>
          </lable>
        </div>
      </td>
      <td>
        <div class="form-item-div">
          <div class="form-item-left">
            <?php echo drupal_render($form['schedule_date']); ?>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <div class="form-item-left">
          <lable>
            <?php echo t('Recipients'); ?>
          </lable>
        </div>
      </td>
      <td>
        <div class="form-item-div">
          <div id="covidien-only-radio" class="form-item-left">
            <?php echo drupal_render($form['schedule_covidien_only']); ?>
          </div>
          <div id="div-device-type" class="form-item-left">
            <?php echo drupal_render($form['select_device_type']); ?>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <div class="form-item-left">
          <lable>
            <?php echo t('Subject Line'); ?>
          </lable>
        </div>
      </td>
      <td>
        <div class="form-item-div">
          <div class="form-item-left" id="edit-description-wrapper">
            <?php echo drupal_render($form['subject_line']); ?>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <div class="form-item-left">
          <lable>
            <?php echo t('Activate Schedule Item'); ?>
          </lable>
        </div>
      </td>
      <td>
        <div class="form-item-div">
          <div id="active-status-radio" class="form-item-left">
            <?php echo drupal_render($form['schedule_active_status']); ?>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <?php if (isAdmin() && arg(1) == 'notification') { ?>
      <tr>
        <td style="padding-left: 0px; width: 160px;">
          <div class="form-item-left">
            <input id="delete-schedule" type="button" value="Delete Schedule Item" class="secondary_submit non_active_grey" disabled="disabled"/>
          </div>
        </td>
        <td>
          <div class="form-item-left">
            <input id="save-schedule" type="button" value="Save Schedule Item" class="form-submit non_active_blue" disabled="disabled"/>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<input type="hidden" name="schedule_alert_event" id="schedule_alert_event"/>
<script type="text/javascript">
  $(document).ready(function() {
    //check radio update form
    $('#schedule-item-list table input:radio').change(function() {
      click_schedule_item_input($(this));
    });
    //$('[id$="date-datepicker-popup-0"]').datepicker({ "minDate": new Date()});
    //submit Schedule Item form
    schedule_item_input_validate();
    $('input').change(schedule_item_input_validate);
    $('submit').change(schedule_item_input_validate);

    $('#save-schedule').click(function() {
      var notification_id = $('#edit-notification-id').val();
      if (notification_id) {
        save_schedule();
      } else {
        submit_alert_notification_form();
      }
    });

    //remove Schedule Item
    $('#delete-schedule').click(function() {
      var schedule_id = $('#edit-schedule-id').val();
      var notification_id = $('#edit-notification-id').val();
      var data = {notification_id: notification_id, schedule_id: schedule_id};
      var url = Drupal.settings.basePath + 'alert/notification/schedule/' + notification_id + '/delete/' + schedule_id;
      $.get(url, data, function(response) {
        var response = Drupal.parseJson(response);
        if (response.status == 'success') {
          disable_schedule_item_button();
          $('#schedule-item-list .form-item-table_list').html(response.data);
          $('#schedule-item-list .form-item-table_list').find('input:radio').change(function() {
            click_schedule_item_input($(this));
            //validate button
            schedule_item_input_validate();
          });
          clear_schedule_item_form();
        }
      });
    });

    //time zone
    update_schedule_display_time_zone();
    $('#time_zone').change(function() {
      update_schedule_display_time_zone();
    });
  });
  //end document reafy

  function submit_alert_notification_form() {
    var post_data = $('#alert-notification-form').serialize();
    var form_url = Drupal.settings.basePath + 'alert/notification/ajax/save';
    $.post(form_url, post_data, function(response) {
      var response = Drupal.parseJson(response);
      if (response.status == 'success') {
        var notification_id = response.notification_id;
        $('#edit-notification-id').val(notification_id);
        save_schedule();
        $(document).ajaxComplete(function() {
          document.location = Drupal.settings.basePath + "alert/notification/edit/" + notification_id;
        });
      } else {
        location.reload();
      }
    });
  }

  function save_schedule() {
    var schedule_id = $('#edit-schedule-id').val();
    var notification_id = $('#edit-notification-id').val();
    var data = {
      notification_id: notification_id,
      schedule_id: schedule_id,
      schedule_date: $('#edit-schedule-date-datepicker-popup-0').val(),
      schedule_time: $('#edit-schedule-date-timeEntry-popup-1').val(),
      covidien_only: $('#covidien-only-radio input:checked').val(),
      active_status: $('#active-status-radio input:checked').val(),
      on_completion: $('#on-completion-radio input:checked').val(),
      field_device_type_nid: $('#edit-field-device-type-nid :selected').val(),
      schedule_alert_event: $('#schedule_alert_event').val(),
      subject_line: $('#subject_line').val()
    };
    var url = Drupal.settings.basePath + 'alert/notification/schedule/' + notification_id + '/add';
    if (schedule_id) {
      url = Drupal.settings.basePath + 'alert/notification/schedule/' + notification_id + '/edit/' + schedule_id;
    }
    $.post(url, data, function(response) {
      var response = Drupal.parseJson(response);
      if (response.status == 'success') {
        disable_schedule_item_button();
        $('#schedule-item-list .form-item-table_list').html(response.data);
        $('#schedule-item-list .form-item-table_list').find('input:radio').change(function() {
          click_schedule_item_input($(this));
          //validate button
          schedule_item_input_validate();
        });
        update_schedule_display_time_zone();
        clear_schedule_item_form();
      }
    });
  }

  function update_schedule_display_time_zone() {
    $('#schedule-item-list .form-item-table_list tbody').find('tr').each(function() {
      var date_obj = $(this).find('td:eq(1)');
      var date_value = $.trim(date_obj.html()).substr(0, 20);
      var time_zone = $('#time_zone').val();

      time_zone = Math.round(time_zone / 36);
      if (time_zone > -1) {
        time_zone = '+' + time_zone;
      }

      date_obj.html(date_value + ' ' + time_zone);
    });
    return false;
  }

  function clear_schedule_item_form() {
    $('#edit-schedule-id').val('');
    $('#edit-schedule-date-datepicker-popup-0').val('');
    $('#edit-schedule-date-timeEntry-popup-1').val('');
    $('#subject_line').val('');
    $('#edit-schedule-covidien-only-Y').attr('checked', false);
    $('#edit-schedule-covidien-only-N').attr('checked', false);
    $('#edit-schedule-active-status-Y').attr('checked', false);
    $('#edit-schedule-active-status-N').attr('checked', false);
    $('#edit-schedule-on-completion-Y').attr('checked', false);
    $('#edit-schedule-on-completion-N').attr('checked', false);
  }

  function click_schedule_item_input(event) {
    //get value
    var id = event.val();
    var schedule_val = event.parent().next().text();
    var recipients = event.parent().next().next().text();
    var subject_line = event.parent().next().next().next().text();
    var status = event.parent().next().next().next().next().text();
    //set value
    $('#edit-schedule-id').val(id);
    var schedule_arr = schedule_val.split(' ');
    $('#edit-schedule-date-datepicker-popup-0').val(schedule_arr[0]);
    $('#edit-schedule-date-timeEntry-popup-1').val(schedule_arr[1]);
    if (recipients == 'Covidien Only') {
      $('#edit-schedule-covidien-only-Y').attr('checked', true);
    } else if (recipients == 'All Users') {
      $('#edit-schedule-covidien-only-N').attr('checked', true);
    } else {
      var device_type = recipients.substring(13);
      $('#edit-field-device-type-nid').find('option[text="' + device_type + '"]').attr("selected", "selected");
    }
    $("#subject_line").val(subject_line);
    if (status == 'Yes') {
      $('#edit-schedule-active-status-Y').attr('checked', true);
    } else if (status == 'No') {
      $('#edit-schedule-active-status-N').attr('checked', true);
    } else {
      $('#edit-schedule-active-status-Y').attr('checked', false);
      $('#edit-schedule-active-status-N').attr('checked', false);
    }
  }

  function schedule_item_input_validate() {
    var validate = true;
    if ($('#edit-schedule-date-datepicker-popup-0').val() == '') {
      validate = false;
    }
    if ((!$('input[name=schedule_covidien_only]:checked').val() || $('input[name=schedule_covidien_only]:checked').val() == '')
            && (!$('#edit-field-device-type-nid').val())) {
      validate = false;
    }
    if ($('#subject_line').val() == '') {
      validate = false;
    }
    if (!$('input[name=schedule_active_status]:checked').val() || $('input[name=schedule_active_status]:checked').val() == '') {
      validate = false;
    }
    if (validate) {
      $('#save-schedule').attr('disabled', false);
      $('#save-schedule').removeClass('non_active_blue');
    } else {
      $('#save-schedule').attr('disabled', true);
      $('#save-schedule').addClass('non_active_blue');
    }
    //validate delete
    schedule_item_delete_validate();
  }

  function schedule_item_delete_validate() {
    var schedule_id = $('#edit-schedule-id').val();
    var notification_id = $('#edit-notification-id').val();
    if (notification_id && schedule_id) {
      $('#delete-schedule').attr('disabled', false);
      $('#delete-schedule').removeClass('non_active_grey');
    } else {
      $('#delete-schedule').attr('disabled', true);
      $('#delete-schedule').addClass('non_active_grey');
    }
  }

  function disable_schedule_item_button() {
    $('#save-schedule').attr('disabled', true);
    $('#save-schedule').addClass('non_active_blue');
    $('#delete-schedule').attr('disabled', true);
    $('#delete-schedule').addClass('non_active_grey');
  }
</script>