<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <?php
    global $user;
    global $base_url;
    if (!$user->uid) {
      $loggedtheme = "";
    }
    ?>
    <?php
    print $head;
    ?>
    <title>
      <?php print $head_title ?>
    </title>
    <?php
    print $styles;
    ?>
    <?php
    print $scripts;
    ?>
    <!--[if lt IE 7]>
    <?php
    print phptemplate_get_ie_styles();
    ?>
    <![endif]-->
  </head>
  <body>
    <?php
    print $content;
    ?>
  </body>
</html>