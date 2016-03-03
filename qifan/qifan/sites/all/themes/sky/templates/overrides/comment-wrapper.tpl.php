<?php
// $Id$

/**
 * @file
 * Outputs the wrapper markup for comments.
 *
 * @see template_preprocess_comment_wrapper(), preprocess/preprocess-comment-wrapper.inc
 * http://api.drupal.org/api/function/template_preprocess_comment_wrapper/6
 */
?>
<div<?php print $comment_wrapper_attributes; ?>>
  <?php if ($title): ?>
    <h3><?php print $title; ?></h3>
  <?php endif; ?>
  <?php print $comment_count; ?>
  <?php print $content; ?>
</div>
