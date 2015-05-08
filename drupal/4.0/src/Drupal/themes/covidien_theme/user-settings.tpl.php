<?php
global $user;
global $base_url;
?>
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
<div class="user_settings">
  <div  class="add_user_message" id="toggleText" style="display: none">
    <div>
      <div><b><?php echo t('Password Construction Guidelines'); ?></b></div>
      <div><?php echo t('Poor, weak passwords are easily cracked, and put the entire system at risk. Therefore, strong passwords are required. Try to create a password that is also easy to remember.'); ?></div>
      <ul>
        <li><?php echo t('Passwords should contain at least 8 characters.'); ?></li>
        <li><?php echo t('Passwords should contain at least 1 uppercase letter (e.g. N) and 1 lowercase letter (e.g. t).'); ?></li>
        <li><?php echo t('Passwords should contain at least 1 numerical character (e.g. 5).'); ?></li>
        <li><?php echo t('Passwords should contain at least 1 special character (e.g. $).'); ?></li>
        <li><?php echo t('Passwords should not contain the special characters & < > \' " '); ?></li>
      </ul>
    </div>
  </div>
</div>
<table class="form-item-table-full edit_new">
  <tr>
    <td style="padding-left : 0px;">
      <div class="form-item user_setting_no_list">
        <?php echo t('1. Password'); ?>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div><label><?php echo t('Your current Password is:'); ?></label></div>								
      <div class="form-item-left"><?php echo $old_pass; ?></div>
    </td>
  </tr>
  <tr>
    <td>
      <div><label><?php echo t('Enter new Password:'); ?></label></div>								
      <div class="form-item-left"><?php echo $new_pass; ?></div>
      <div class="form-item-left"> &nbsp; <a href="javascript:void(0)" onmouseover="javascript:toggle();" onmouseout="javascript:toggle();"><img src="<?php print base_path(); ?><?php print path_to_theme(); ?>/images/question_mark.gif" width="20" alt="sticky icon" class="sticky" /></a></div>
    </td>
  </tr>
  <tr>
    <td>
      <div><label><?php echo t('Confirm new Password:'); ?></label></div>								
      <div class="form-item-left"><?php echo $con_pass; ?></div>

    </td>
  </tr>
  <?php if (empty($user_expired)) { ?>
    <tr>
      <td style="padding-left : 0px;">
        <div class="form-item user_setting_no_list">
          <?php echo t('2. Email Notifications'); ?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="user_setting_content">
          <?php echo t('Do you want to subscribe to any of the following email notifications?'); ?>
          <?php print $notifications; ?>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left : 0px;">
        <div class="form-item user_setting_no_list">
          <?php echo t('3. Language'); ?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div><?php echo $language; ?></div></div>
      </td>
    </tr>
  <?php } ?>

  <tr>
    <td  class="add_user">
      <table class="form-item-table-full">
        <tr>
          <td align="right" colspan="3" >
            <div class="form-item-div">
              <div class="form-item-right" style="width : 205px; display:none">
                <?php echo $render; ?>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="3" align="right">
            <table style="width:370px;" class="form-item-table-full"><tr>
                <td style="width : 150px;"><a id="secondary_submit" href="<?php print $base_url; ?>/covidien/home"><?php print t('Cancel'); ?></a></td>
                <td><div style="width : 150px;"><?php echo $submit; ?></div></td>
                <td></td>
              </tr>
            </table>
          </td>
        </tr>		
      </table>
    </td>
  </tr>
</table>
