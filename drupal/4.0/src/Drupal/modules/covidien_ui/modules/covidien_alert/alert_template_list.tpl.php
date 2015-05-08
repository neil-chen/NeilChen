<style>
  #template-list {
    margin: 10px 0;
  }
  .secondary_submit {
    padding: 3px 5px 4px;
    margin-left: 30px;
  }
</style>
<form method="get" accept-charset="UTF-8">
  <div style="width: 100%;" id="div_list">
    <table class="form-item-table-full" style="margin-bottom: 20px;">
      <tbody>
        <tr>
          <td colspan="2">
            <div class="form-item-div">
              <div class="form-item-left">
                <h4><?php echo t('Message Template List'); ?></h4>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="form-item-left">
              <label><?php echo t('Select Device Type:'); ?> </label>
            </div>
          </td>
          <td>
            <div class="form-item-left"><?php echo $sel_device_type; ?></div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="form-item-left">
              <label><?php echo t('Select Alert Category:'); ?> </label>
            </div>
          <td>
            <div class="form-item-left"><?php echo $sel_alert_category; ?></div>
            <div style="padding-left: 20px; width: 300px" class="form-item-left">
              <div class="views-exposed-widget views-submit-button">
                <input type="submit" class="form-submit" value="Go"/>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div id="template-list">
    <?php echo $table_list; ?>
  </div>
  <div class="form-item-div" id="div_button" style="clear: both; float: right; width: 90%">
    <div class="form-item-right" style="width: 450px; padding-right: 10px;">
      <div style="float: right;">
        <?php if (check_user_has_edit_access('alert')) { ?>
          <a class="secondary_submit" href="<?php echo url('alert/template/add'); ?>">Add Template</a>
        <?php } ?>
      </div>
      <div style="float: right;">
        <a id="secondary_submit" href="<?php echo url('alert/config/list'); ?>">Cancel</a>
      </div>
    </div>
  </div>
</from>
