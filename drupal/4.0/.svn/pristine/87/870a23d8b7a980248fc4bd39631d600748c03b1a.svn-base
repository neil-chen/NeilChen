<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language->language ?>" lang="<?php echo $language->language ?>" dir="<?php echo $language->dir ?>">

  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <?php
    global $user;
    global $base_url;
    if ($user->uid) {
//
    } else
      $loggedtheme = "";
    ?>
    <?php echo $head ?>
    <title><?php echo $head_title ?></title>
    <?php echo $styles ?>
    <?php echo $scripts ?>
    <!--[if lt IE 7]>
    <?php echo phptemplate_get_ie_styles(); ?>
    <![endif]-->
    <script type="text/javascript">
      if ($.browser.msie) {
        window.onload = function() {
          return;
        };
      } else {
        window.onbeforeunload = function(event) {
          return; // <-- Message is displayed in *some* browsers
        }
      }
    </script>
  </head>
  <body <?php echo phptemplate_body_class($left, $right); ?>>
    <?php
    $wrapper = 'width:450px; border:none !important';
    $container = 'width:400px; border:none !important';
    if ($popup) {
      $wrapper = 'width:1000px';
      $container = '';
    }
    ?>
    <?php
    if (arg(2) == "history" || (arg(3) == 'new_user_request_info')) {
      $wrapper = 'width:700px; border:none !important';
      $container = 'border:none !important';
    }
    ?>

    <!-- Layout -->
    <?php if ($popup) { ?>			

      <?php if ($loggedtheme != "true") { ?>
        <div id="header-region" class="clear-block">
          <?php echo $header; ?>
          <div class="user_manage">
            <a href="<?php echo url('covidien/users/settings/user_profile'); ?>" id="anch_user_settings"><?php echo $user_name; ?></a>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  
            <a href="<?php echo url('logout'); ?>">Logout</a>
          </div>
        </div>
      <?php } ?>
    <?php } ?>

    <div id="wrapper" style="<?php echo $wrapper; ?>">
      <div id="container" class="clear-block"
      <?php
      if ($loggedtheme == "true")
        echo 'style="border:0px; ' . $container . '"';
      else
        echo 'style="' . $container . '"';
      ?>
           >

        <!--  <div id="header">
            
                            </div>  /header -->
        <?php if ($popup) { ?>			
          <div class="head_and_menu">
            <div id="logo-floater">

              <?php
              // Prepare header
              $site_fields = array();
              if ($site_name) {
                $site_fields[] = check_plain($site_name);
              }
              if ($site_slogan) {
                $site_fields[] = check_plain($site_slogan);
              }
              $site_title = implode(' ', $site_fields);
              if ($site_fields) {
                $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
              }
              $site_html = implode(' ', $site_fields);

              if (($logo || $site_title) && $loggedtheme != "true") {
                echo '<h1><a href="' . $base_url . '/covidien/home" title="' . $site_title . '">';
                if ($logo) {
                  echo '<img src="' . check_url($logo) . '" alt="' . $site_title . '" id="logo" />';
                }
              }
              ?>
            </div>
            <div class="left_title">
              <?php
              if ($site_title && $loggedtheme != "true") {
                echo '<h1><a href="' . $base_url . '/covidien/home" title="' . $site_title . '">' . t('Device Management Portal');
                echo '</a></h1>';
              }
              ?>
            </div> 
            <div id="right_menu">
              <ul class="primary-links">
                <li><a  id="anch_home" class="" href="<?php echo url('covidien/home'); ?>"><?php echo t('Home'); ?></a></li>
                <li><a id="anch_devices" class="" href="<?php echo $device_url; ?>"><?php echo t('Devices'); ?></a></li>
                <li><a id="anch_reports" class="" href="<?php echo url($report_url); ?>"><?php echo t('Reports'); ?></a></li>
                <li><a id="anch_system_admin" class="" href="<?php echo url($admin_page_url); ?>"><?php echo t('Admin'); ?></a></li>
              </ul>
              <?php if (isset($secondary_links)) : ?>
                <?php echo theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
              <?php endif; ?>
            </div>
          </div>
          <div align="right" style="margin-top:20px;"><?php echo $pl_block; ?></div>
        <?php } ?>
        <!--<?php // if ($left):     ?>
         <div id="sidebar-left" class="sidebar">
        <?php //if ($search_box):   ?><div class="block block-theme"><?php //echo $search_box   ?></div><?php //endif;   ?>
        <?php //echo $left  ?>
          </div>
        <?php //endif;  ?> -->


        <div id="center">
          <div class="right-corner">
            <div class="left-corner">
              <?php //echo $breadcrumb;   ?>
              <?php
              if ($mission): echo '<div id="mission">' . $mission . '</div>';
              endif;
              ?>
              <?php
              if ($tabs): echo '<div id="tabs-wrapper" class="clear-block">';
              endif;
              ?>
              <?php
              if ($title && $loggedtheme != "true"): echo '<h2' . ($tabs ? ' class="page_title"' : '') . '>' . $title . '</h2>';
              endif;
              ?>
              <?php /** if ($tabs && $loggedtheme!="true" && (arg(0)!='node' && arg(2)!='edit')): echo '<ul class="tabs">'. $tabs .'</ul></div>'; endif; */ ?>
              <div class="tabs_wrapper">
                <?php echo theme('links', $custom_tabs); ?>
              </div>
              <!--   <?php
              if ($tabs2): echo '<ul class="primary_tab">' . $tabs2 . '</ul>';
              endif;
              ?> -->          
              <?php echo $help; ?>
              <div id="content-part" class="clear-block">
                <?php
                if ($show_messages && $messages): echo '<div class="message">' . $messages . '</div>';
                endif;
                ?>
                <?php echo $content ?>
              </div>
              <?php echo $feed_icons ?>
              <div id="footer"><?php echo $footer_message /* . $footer */ ?> </div>
            </div>
          </div>
        </div><!-- /.left-corner, /.right-corner, /#squeeze, /#center -->

        <?php if ($right): ?>
          <div id="sidebar-right" class="sidebar">
            <?php if (!$left && $search_box): ?><div class="block block-theme"><?php echo $search_box ?></div><?php endif; ?>
            <?php echo $right ?>
          </div>
        <?php endif; ?>

        <!-- /container -->


      </div>
    </div>
    <!-- /layout -->
    <?php
    if ($popup) {
      echo $closure;
    }
    ?>
    <noscript>
      <div align="center">
        <h2><?php echo t("JavaScript required to view this page"); ?></h2>
      </div>
      <style>
        body #center, body #admin-menu{ display:none; }
      </style>
    </noscript>
  </body>
</html>
