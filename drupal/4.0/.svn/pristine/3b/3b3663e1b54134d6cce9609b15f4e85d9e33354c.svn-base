<?php
global $base_url;
$theme = drupal_get_path('theme', 'covidien_theme');
$module = drupal_get_path('module', 'covidien_users');
?>
<script type="text/javascript">
<!--
  $(document).ready(function() {
    var selected = $('#covidien_emp').val();
    $('.covidien_yes, .covidien_no').hide();
    $('.covidien_' + selected).show();
    $('#covidien_emp').change(function() {
      $('.covidien_yes, .covidien_no').hide();
      if ($(this).val() == 'yes') {
        $('.covidien_yes').show();
      } else {
        $('.covidien_no').show();
      }
    });
  });
  function new_captcha()
  {
  var c_currentTime = new Date();
    var c_miliseconds = c_currentTime.getTime();
    document.getElementById('captcha').src = '';
    document.getElementById('captcha').src = '<?php echo $base_url; ?>/covidien/register/captcha/' + c_miliseconds;
}
-->
</script>
<div class="login_logo"><img src="<?php echo $base_url . '/' . $theme; ?>/logo.png" /></div>	
<div class="login_title"><h1><?php echo t('Welcome to the Covidien Device Management Portal'); ?></h1></div>
<div class="login_process">
  <h2><?php echo t('Signup'); ?></h2>
  <?php
  if ($show_messages && $messages) {
    print $messages;
  }
  ?>
  <div id="edit-name-wrapper" class="register_fields">
    <div class="fields">
      <div class="right"><span class="required">*</span> <?php echo t('Email Address:'); ?></div><div class="left"><?php echo $email; ?></div>
    </div>
    <div class="fields">
      <div class="right"><span class="required">*</span> <?php echo t('First Name:'); ?></div><div class="left"><?php echo $firstname; ?></div>
    </div>
    <div class="fields">
      <div class="right"><span class="required">*</span> <?php echo t('Last Name:'); ?></div><div class="left"><?php echo $lastname; ?></div>
    </div>
    <div class="fields">
      <div class="right"><span class="required">*</span> <?php echo t('Covidien Employee:'); ?></div><div class="left"><?php echo $covidien_emp; ?></div>
    </div>
    <div class="fields covidien_no">
      <div class="right"><span class="required">*</span> <?php echo t('Customer Name:'); ?></div><div class="left"><?php echo $company_name; ?></div>
    </div>
    <div class="fields covidien_no">
      <div class="right"><span class="required">*</span> <?php echo t('Customer Account Number:'); ?></div><div class="left"><?php echo $company_account; ?></div>
    </div>
    <div class="fields covidien_yes">
      <div class="right"><span style='margin-left:10px'> <?php echo t('Business Unit'); ?></span></div><div class="left"><?php echo $business_unit; ?></div>
    </div>
    <div class="fields">
      <div class="right"><span class="required">*</span> <?php echo t('Country:'); ?></div><div class="left"><?php echo $country; ?></div>
    </div>
    <div class="fields">
      <div class="right"><span class="required">*</span> <?php echo t('Language:'); ?></div><div class="left"><?php echo $language; ?></div>
    </div>
    <div class="fields">
      <div class="right"><span style='margin-left:10px'> <?php echo t('Notes:'); ?></span></div><div class="left"><?php echo $notes; ?></div>
    </div>
    <div class="fields">
      <div class="right">
        <span class="required">*</span> <?php echo t('Enter Security Code:'); ?>
      </div>
      <div class="left">
        <?php echo $security_text; ?> <img border="0" id="captcha" src="<?php echo $base_url; ?>/covidien/register/captcha" alt="" width="100" />
        &nbsp;
        <a href="JavaScript: new_captcha();"><img border="0" alt="" src="<?php echo $base_url . '/' . $theme; ?>/images/refresh.png" align="bottom"></a>
      </div>
    </div>
    <div class="fields" style="text-align:center">
      <a id="secondary_submit" href="<?php echo $base_url; ?>/covidien"><?php echo t('Cancel'); ?></a> <?php echo $submit; ?>
    </div>
    <div style='display:none'><?php echo $form_extras; ?></div>

  </div>
  <div class="login_footer"><?php
    global $contact_info;
    echo t('Need help? Contact the Help Desk at !link', array('!link' => $contact_info));
    ?></div>
</div>
