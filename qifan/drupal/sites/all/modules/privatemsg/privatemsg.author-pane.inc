<?php
// $Id: privatemsg.author-pane.inc,v 1.1.2.3.2.5 2010/12/23 12:23:23 berdir Exp $

/**
 * @file
 * Provides a preprocess function to integrate Privatemsg with Author Pane.
 */

/**
 * Implements hook_preprocess_author_pane().
 */
function privatemsg_preprocess_author_pane(&$variables) {
  // Check if this preprocess needs to be run given who's calling it.
  if (!author_pane_run_preprocess('privatemsg', $variables['caller'])) {
    return;
  }

  global $user;
  $account = $variables['account'];

  if ($account_id != $user->uid) {
    $url = privatemsg_get_link($account);
    if (!empty($url)) {
      $variables['privatemsg'] = l('<span>' . t('Send PM') . '</span>', $url, array('attributes' => array('class' => array('author-pane-link'), 'title' => t('Send @name a private message', array('@name' => privatemsg_recipient_format($account, array('plain' => TRUE))))), 'html' => TRUE));
    }
  }
}

/**
 * Implementation of hook_author_pane_allow_preprocess_disable().
 */
function privatemsg_author_pane_allow_preprocess_disable() {
  return array('privatemsg' => 'Privatemsg');
}
