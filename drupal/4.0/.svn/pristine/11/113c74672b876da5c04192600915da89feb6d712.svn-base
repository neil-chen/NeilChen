<?php
global $base_url;
$theme = drupal_get_path('theme', 'covidien_theme');
$module = drupal_get_path('module', 'covidien_users');
?>
<script type="text/javascript">
<!--
  function new_captcha()
  {
  var c_currentTime = new Date();
    var c_miliseconds = c_currentTime.getTime();
    document.getElementById('captcha').src = '';
    document.getElementById('captcha').src = '<?php echo $base_url; ?>/covidien/register/captcha/' + c_miliseconds;}
-->
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
    <div style="padding:0px 20px"><?php echo t('Please enter your Email address in the box below to request a new password reset link to your email'); ?></div>
    <?php
    if ($show_messages && $messages) {
      print $messages;
    }
    ?>
    <div id="edit-name-wrapper" class="forgotpass_fields">
      <div class="fields">
        <?php echo $email; ?>
      </div>
      <div class="fields">
        <div class="security">
          <?php echo t('Enter Security Code'); ?> 
          <span style="color:red">(case sensitive)</span>
        </div>
        <?php echo $security_text; ?> 
        <img border="0" id="captcha" src="<?php echo $base_url; ?>/covidien/register/captcha" alt="" width="100px" />
        &nbsp;
        <a href="JavaScript: new_captcha();"><img border="0" alt="" src="<?php echo $base_url . '/' . $theme; ?>/images/refresh.png" align="bottom" width="15px" ></a>
        <br/>

      </div>
      <div class="fields_btn">
        <div class="but_float"><a href="<?php echo $base_url; ?>" id="secondary_submit"><?php echo t('Cancel'); ?></a></div>
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