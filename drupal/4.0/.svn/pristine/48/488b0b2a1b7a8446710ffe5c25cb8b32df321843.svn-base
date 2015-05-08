<style>
  #alert-notification-history-filter-form {
    margin-top: 5px;
  }
  #alert-notification-history-filter-form .form-item, #alert-notification-history-filter-form label {
    float: left;
  }
  #alert-notification-history-filter-form .container-inline-date .form-item, .container-inline-date .form-item input {
    width: auto;
  }
  #alert-notification-history-filter-form .date-clear-block {
    clear: none;
  }
  #alert-notification-history-filter-form .form-item .description {
    display: block;
  }
  #edit-from-date-datepicker-popup-0, #edit-to-date-datepicker-popup-0 {
    margin: 0;
  }
  #edit-from-date-timeEntry-popup-1, #edit-to-date-timeEntry-popup-1 {
    margin-left: -1px;
  }
</style>
<div style="width: 100%;" id="div_list">
  <table class="form-item-table-full" style="margin-bottom: 10px;">
    <tr>
      <td colspan="3">
        <div class="form-item-div">
          <div class="form-item-left">
            <h4><?php echo t('General Notification History List'); ?></h4>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <?php echo $filter_form; ?>
      </td>
    </tr>
  </table>
</div>
<div id="notification-list">
  <?php echo $table_list; ?>
  <a id="alert_notification_history_cancel" href="<?php echo url('alert/notification/list'); ?>">Cancel </a>
</div>
<script>
  $(document).ready(function() {
    //remove date format example.
    $('.container-inline-date  .description').remove();
  });
</script>