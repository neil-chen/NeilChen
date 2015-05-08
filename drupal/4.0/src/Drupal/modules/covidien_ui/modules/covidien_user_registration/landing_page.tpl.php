<?php global $base_url, $theme;
  $path = drupal_get_path('theme', $theme); 
?>   
<script src="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/js/jquery.min.js"></script> 
<script type="text/javascript">
$.noConflict();
jQuery( document ).ready(function( $ ) {   
  $('#captcha').keyup(function (e){
    var captcha_value = $("#captcha").val();
    var captcha_code = $("div.code").text(); 
    if(captcha_value == captcha_code){ 
      $( "a" ).removeClass( "non_active_blue not-active" );
    } else {
      $("a.next-btn").addClass("non_active_blue not-active");
    }
  })  
});  
</script>
<div class="landing-page-wrapper">
  <div class="landing-page-header">
    <div class="login_logo"><img src="<?php print($base_url . '/' . $path); ?>/logo.png" /></div>	
    <div class="login_title"><h1>Welcome to the Covidien Device Management Portal</h1></div>
  </div>
  <div class="landing-page-steps">
    <p>Before using this system to update software in Covidien medical devices, it is necessary to create a user login.
      We will take you through the steps to create your user login.
    </p>
    <br>
    </br>
    <p> <b>Step 1:</b> Enter your user information.</p>
    <p> <b>Step 2:</b> Select your user role (e.g. Service Technician, Biomed, Sales Rep).</p>
    <p> <b>Step 3:</b> Select all Covidien devices that you will work with.</p>
    <p> <b>Step 4:</b> Acknowledge that you have been trained to use this system to update software on medical devices.</p>
    <p> <b>Step 5:</b> Submit your login request.</p>
    <p> <b>Step 6:</b> Wait for an email confirmation that your login account has been created.</p>
    <p> <b>Step 7:</b> Log into the system and change your password. You are now able to update software on Covidien devices.</p>
  </div>
  <?php  
    session_start(); 
    include("captcha/simple-php-captcha.php");
    $_SESSION['captcha'] = simple_php_captcha();  
  ?> 
  <div class="next-page"> 
    <a class="form-submit next-btn non_active_blue not-active" href="<?php print $base_url; ?>/self/register" target="">Next</a>
    <button class="form-submit cancel" onclick="history.back();" type="button">Cancel</button>
    <div class="captcha"><input id="captcha" class="input-mini" type="text" required="" name="captcha"></div>
    <div class="captcha code"><?php print($_SESSION['captcha']['code']);?></div>
  </div>
</div> 