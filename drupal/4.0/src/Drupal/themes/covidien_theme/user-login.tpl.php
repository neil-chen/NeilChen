<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>

    <?php
    global $user;
    global $base_url;
    if ($user->uid) {
//
    } else
      $loggedtheme = "";

    $loginval = t("Username (email address)");
    $post = filter_xss_arr($_POST);
    if ($post['name'] != '') {
      $loginval = preg_replace('/[%\"\'\[\]\(\)%&-]/s', '', $post['name']);
    }
    if (isset($_COOKIE['deactivate_user'])) {
      $loginval = $_COOKIE['deactivate_user'];
      setcookie('deactivate_user', '');
    }
    ?>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
    <!--[if lt IE 7]>
    <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
    <script type="text/javascript">
      $(document).ready(function() {
        $('form').unbind('keypress');
        var txt = $("#edit-name");
        var func = function() {
          txt.val($.trim(txt.val()));
        }
        //txt.keyup(func).blur(func);
        txt.blur(func);

      });
      function onsubmitfun() {
        var txt = $("#edit-name");
        if (txt.val() == 'Username (email address)') {
          txt.val('');
        }
        txt.val($.trim(txt.val()));
      }
    </script>	    
  </head>
  <body <?php print phptemplate_body_class($left, $right); ?>><div class="login_page">
      <form action="<?php print $base_url; ?>/user"  accept-charset="UTF-8" method="post" onsubmit="javascript:onsubmitfun();
          return true;" id="user-login">
        <div class="login_logo"><img src="<?php echo $base_url . '/' . path_to_theme(); ?>/logo.png" /></div>	
        <div class="login_title"><h1><?php echo t('Welcome to the Covidien Device Management Portal'); ?></h1></div>
        <noscript>
          <h2><?php echo t("JavaScript required to view this page"); ?></h2>

        </noscript>
        <div class="login_process">
          <h2><?php echo t('Sign into your Account'); ?></h2>
          <?php
          if ($show_messages && $messages) {
            print $messages;
          }
          ?>
          <div id="edit-name-wrapper" class="login_fields">
            <div><input type="text" size="60" id="edit-name" name="name" value="<?php echo $loginval; ?>" maxlength="60"></div>
            <div id="fpage">
              <input type="password" size="60" maxlength="128" id="edit-pass" name="pass" autocomplete="off" value="">
                <input id="edit-pass-clear" type="text" value="Password" autocomplete="off" />
            </div>
            <div class="login_button">
              <a href="<?php echo $base_url; ?>/covidien/forgot_password">Forgot Password?</a>
              <input type="hidden" value="id value removed for security" name="form_build_id" class="form-submit" />
              <input type="hidden" value="user_login" id="edit-user-login" name="form_id" class="form-submit" />
              <input type="submit" value="Login" id="edit-submit" name="op" class="form-submit" />
            </div>
          </div>

        </div>
      </form>
      <div style="clear:both"></div>
      <span class="versioninfo">v<?php echo variable_get('covidien_ui_version', '8.3'); ?></span>
      <div id="div_client_download" style="text-align:center">
        <a id="link_self_registration" href="<?php print $base_url; ?>/self/home"><?php echo t('Request a User ID'); ?></a>
        <a id="link_client_download" href="<?php print $base_url; ?>/download_pic/list"><?php echo t('Download Covidien Client Applications'); ?></a>
      </div>
      <div class="login_footer">
        <div class="inside_login"><?php
          global $contact_info;
          echo $contact_info;
          ?>
        </div>
      </div>
    </div>

  </body>
</html>