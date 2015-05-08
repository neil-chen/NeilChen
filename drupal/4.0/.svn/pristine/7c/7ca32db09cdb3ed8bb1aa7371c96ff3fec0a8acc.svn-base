<?php
global $user;
global $base_url;
?>
<table width="100%" class="form-item-user-table">
  <tr>
    <td valign="top" class="form-item-user-table-left">
      <div class="reports_menu">
        <div class="users_list_left">
          <a href="<?php print base_path(); ?>covidien/users/settings/user_profile"><?php print t('Display User Profile'); ?></a><br />
          <a href="<?php print base_path(); ?>covidien/users/settings/change_password"><?php print t('Change Password'); ?></a><br />
          <a href="<?php print base_path(); ?>covidien/users/settings/notification" style="color:#000"><?php print t('Email Notification'); ?></a><br />
        </div>				
      </div>
    </td>
    <td class="form-item-user-table-right">
      <table class="noborder">
        <tr>
          <td class="noborder" colspan="2">
            <h4><?php echo t('Email Notification'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" style="padding-left : 14px;">
            <div><label><?php echo t('Do you want to subscribe to any of the following email notifications?'); ?></label></div>
            <div style="margin-left:20px"><?php echo $notification; ?></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" colspan="2" align="right">
            <table class="noborder" style="width:40%">
              <tr>
                <td class="noborder" width="50%">
                  <a href="<?php echo $base_url; ?>/covidien/users/settings/notification" id="secondary_submit"><?php echo t('Cancel'); ?></a>
                </td>
                <td class="noborder" width="50%"><?php echo $submit; ?></td>
              </tr>
            </table>
            <?php echo $form_extras; ?>
          </td>	
        </tr>
      </table>
    </td>
  </tr>
</table>