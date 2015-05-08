<?php
global $user;
global $base_url;
$theme = drupal_get_path('theme', 'covidien_theme');
?>
<style>
  div.user_settings #toggleText {
    margin: -110px 0 0 300px;
    width: 385px;
  }
</style>
<script language="javascript">
  function toggle() {
    var ele = document.getElementById("toggleText");
    var text = document.getElementById("displayText");
    if (ele.style.display == "block") {
      ele.style.display = "none";
    }
    else {
      ele.style.display = "block";
    }
  }
</script>

<table width="100%" class="form-item-user-table">
  <tr>
    <td valign="top" class="form-item-user-table-left">
      <div class="reports_menu">
        <div class="users_list_left">
          <a href="<?php print base_path(); ?>covidien/users/settings/user_profile"><?php print t('Display User Profile'); ?></a><br />
          <a href="<?php print base_path(); ?>covidien/users/settings/change_password" style="color:#000"><?php print t('Change Password'); ?></a><br />
          <!-- GATEWAY-2626 -->
          <!--<a href="<?php print base_path(); ?>covidien/users/settings/notification"><?php print t('Email Notification'); ?></a><br />-->
        </div>				

      </div>
    </td>
    <td class="form-item-user-table-right">

      <table class="noborder">
        <tr>
          <td class="noborder">
            <h4><?php echo t('Change Password'); ?></h4>
          </td>
        </tr>
        <tr>
          <td class="noborder">
            <div><label><?php echo t('Your current Password is:'); ?></label></div>								
            <div class="form-item-left"><?php echo $oldpass; ?></div>
          </td>
        </tr>
        <tr>
          <td class="noborder">
            <div><label><?php echo t('Enter new Password:'); ?></label></div>								
            <div class="form-item-left"><?php echo $newpass; ?></div>
            <div class="form-item-left"> &nbsp; 
              <a href="javascript:void(0)">
                <img src="<?php print $base_url; ?>/<?php print $theme; ?>/images/question_mark.gif" width="20" alt="sticky icon" class="sticky" />
              </a>
            </div>
            <div class="user_settings">
              <div  class="add_user_message" id="toggleText">
                <div>
                  <div><b><?php echo t('Password Construction Guidelines'); ?></b></div>
                  <div><?php echo t('Poor, weak passwords are easily cracked, and put the entire system at risk. Therefore, strong passwords are required. Try to create a password that is also easy to remember.'); ?></div>
                  <ul>
                    <li><?php echo t('Passwords should contain at least 8 characters.'); ?></li>
                    <li><?php echo t('Passwords should contain at least 1 uppercase letter (e.g. N) and 1 lowercase letter (e.g. t).'); ?></li>
                    <li><?php echo t('Passwords should contain at least 1 numerical character (e.g. 5).'); ?></li>
                    <li><?php echo t('Passwords should contain at least 1 special character (e.g. $).'); ?></li>
                    <li><?php echo t('Passwords should not contain the special characters (& < > \' ").'); ?></li>
                  </ul>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="noborder">
            <div><label><?php echo t('Confirm new Password:'); ?></label></div>								
            <div class="form-item-left"><?php echo $confirmpass; ?></div>

          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" align="right">
            <table class="noborder" style="width:40%">
              <tr>
                <td class="noborder" width="50%">
                  <a href="<?php echo $base_url; ?>/covidien/users/settings/change_password" id="secondary_submit"><?php echo t('Cancel'); ?></a>
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