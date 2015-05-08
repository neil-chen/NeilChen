<?php global $base_url, $theme;
  $path = drupal_get_path('theme', $theme); 
?>  
<div class="reset-password-form-wrapper">
  <div class="reset-password-header">
    <div class="login_logo"><img src="<?php print($base_url . '/' . $path); ?>/logo.png" /></div>	
    <div class="login_title"><h1>Set Your Password</h1></div>
  </div>
  <?php if(isset($form['password']['#title'])): ?>
    <div class="congrat">
      Congratulations! <b><?php print($form['#register_user']['first_name'] . ' ' . $form['#register_user']['last_name']); ?></b>, Your registration was accepted,  please set your password of your account:
    </div> 
    <div class="password-wrapper"> 
      <?php print drupal_render($form['password']); ?>
      <?php print drupal_render($form['confirm_password']); ?>
    </div>  
    <div class="bottom_page_reset_password">   
    </div>
    <div class="submit_wrapper"> 
      <?php print drupal_render($form['submit']);?>   
    </div>

    <?php print drupal_render($form['form_build_id']);?>
    <?php print drupal_render($form['form_token']);?>
    <?php print drupal_render($form['form_id']);?>   
  <?php else: ?>
  
  <div>Your active code is invalid or your account has already activated. Please contact with your approving manager for help.</div>
  
  <?php endif; ?> 
</div> 