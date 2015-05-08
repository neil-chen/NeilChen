<?php

global $user;

if (excludePageTheme()) {
  return;
} else if ($user->uid) {
  include 'page_loggedin.tpl.php';
  return;
} else {
  include 'page_loggedout.tpl.php';
  return;
}

function excludePageTheme() {
  $uri = $_SERVER ['REQUEST_URI'];
  if (strpos($uri, "download/download") || strpos($uri, "download_pic/download")) {
    return true;
  }
  return false;
}

?>