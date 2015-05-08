<div style="width: 100%;" id="div_list">
  <table class="form-item-table-full" style="margin-bottom: 10px;">
    <tr>
      <td colspan="2">
        <div class="form-item-div">
          <div class="form-item-left">
            <h4><?php echo t('General Notification List'); ?></h4>
          </div>
          <div class="form-item-right">
            <a id="secondary_submit" href="<?php echo url('alert/notification-history/list') ?>">General Notification History</a>
          </div>
        </div>
      </td>
    </tr>
  </table>
</div>
<div id="notification-list">
  <?php echo $table_list; ?>
</div>
<div class="form-item-div" id="div_button" style="clear: both; float: right; width: 90%; margin-top: 10px;">
  <div class="form-item-right" style="width: 450px; padding-right: 10px;">
    <?php if ($user->uid == 1) { ?>
      <div style="float: right;">
        <a id="secondary_submit" href="<?php echo url('alert/notification/add'); ?>">Add General Notification</a>
      </div>
    <?php } ?>
    <div style="float: right; margin-right: 20px;">
      <a id="secondary_submit" href="<?php echo url('alert/config/list'); ?>">Cancel</a>
    </div>
  </div>
</div>