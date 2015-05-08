<?php
global $base_url;
$theme = drupal_get_path('theme', 'covidien_theme');
$module = drupal_get_path('module', 'covidien_users');
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
<div style="width:500px; margin:0 auto;">
  <div class="login_logo"><img src="<?php echo $base_url . '/' . $theme; ?>/logo.png" /></div>	
  <div class="login_title"><h1><?php echo t('Welcome to the Covidien Device Management Portal'); ?></h1></div>
  <div class="login_process">
    <h2><?php echo t('Reset your Password'); ?></h2>
    <?php
    if ($messages): print '<div class="message">' . $messages . '</div>';
    endif;
    ?>
    <div id="edit-name-wrapper" class="forgotpass_fields">
      <div class="fields">
        <?php echo $newpass; ?>
        <input id="newpass-clear" type="text" value="New Password" autocomplete="off" style="width:330px" />
        <a href="javascript:void(0)" onmouseover="javascript:toggle();" onmouseout="javascript:toggle();" class="helpicon"><img src="<?php print $base_url; ?>/<?php print $theme; ?>/images/question_mark.gif" width="20" alt="sticky icon" class="sticky" /></a>
        <div class="user_settings">
          <div  class="add_user_message" id="toggleText" style="display: none; margin-top:20px;">
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
      </div>
      <div class="fields">
        <?php echo $confirmpass; ?>
        <input id="confirmpass-clear" type="text" value="Confirm Password" autocomplete="off" style="width:330px" />
      </div>
      <div class="fields_btn" style="padding-left:180px;">
        <div class="but_float">
          <a href="<?php echo $base_url; ?>" id="secondary_submit"><?php echo t('Cancel'); ?></a>
        </div>
        <div class="but_float"><?php echo $submit; ?></div>
        <div style="clear:both"></div>
      </div>
      <div style='display:none'><?php echo $form_extras; ?></div>

    </div>
  </div>
  <div class="login_footer">
    <div class="inside_login"><?php
      global $contact_info;
      echo $contact_info;
      ?>
    </div>
  </div>
</div>

<script type="text/javascript">

  $('#newpass-clear,#confirmpass-clear').show();
  $('#newpass,#confirmpass').hide();

  $('#newpass-clear').focus(function() {
    $('#newpass-clear').hide();
    $('#newpass').show();
    $('#newpass').focus();
  });
  $('#newpass').blur(function() {
    if ($('#newpass').val() == '') {
      $('#newpass-clear').show();
      $('#newpass').hide();
    }
  });

  $('#confirmpass-clear').focus(function() {
    $('#confirmpass-clear').hide();
    $('#confirmpass').show();
    $('#confirmpass').focus();
  });
  $('#confirmpass').blur(function() {
    if ($('#confirmpass').val() == '') {
      $('#confirmpass-clear').show();
      $('#confirmpass').hide();
    }
  });
</script>