<form method="get" accept-charset="UTF-8">
  <div style="width: 100%;" id="div_list">
    <table class="form-item-table-full" style="margin-bottom: 20px;">
      <tr>
        <td colspan="2">
          <div class="form-item-div">
            <div class="form-item-left">
              <h4>
                <?php echo t('Alerts'); ?>
              </h4>
              <p class="discrips">
                <?php echo t('Alerts are listed below.'); ?>
              </p>
            </div>
            <?php if (check_user_has_edit_access('alert')) { ?>
              <div class="form-item-right" style="padding-right: 10px;">
                <a id="secondary_submit" href="<?php echo url('alert/config/subscribe/admin') ?>">Manage Alert Subscriptions</a>
              </div>
            <?php } ?>
            <?php if (is_cot_admin()) { ?>
              <div class="form-item-right" style="padding-right: 10px;">
                <a id="secondary_submit" href="<?php echo url('alert/template/list') ?>">Manage Message Template</a>
              </div>
            <?php } ?>
            <?php if (is_cot_admin()) { ?>
              <div class="form-item-right" style="padding-right: 10px;">
                <a id="secondary_submit" href="<?php echo url('alert/notification/list') ?>">Manage General Notification</a>
              </div>
            <?php } ?>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 30px;">
          <div class="form-item-left">
            <label><?php echo t('Select Device Type:'); ?> </label>
          </div>
        </td>
        <td>
          <div class="form-item-left">
            <?php echo $sel_device_type; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 30px;">
          <div class="form-item-left">
            <label><?php echo t('Select Alert Event:'); ?> </label>
          </div>
        </td>
        <td>
          <div class="form-item-left">
            <?php echo $sel_alert_event; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 30px;">
          <div class="form-item-left">
            <label><?php echo t('Select Alert Status:'); ?> </label>
          </div>
        </td>
        <td>
          <div class="form-item-left">
            <?php echo $sel_alert_state; ?>
          </div>
          <div style="padding-left: 20px; width: 300px" class="form-item-left">
            <div class="views-exposed-widget views-submit-button">
              <input type="submit" class="form-submit" value="Search"/>
            </div>
          </div>
        </td>
      </tr>
    </table>
    <?php echo $table_list; ?>
  </div>
</form>