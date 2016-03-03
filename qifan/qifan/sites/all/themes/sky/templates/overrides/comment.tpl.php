<?php
// $Id$

/**
 * @file
 * Output of comment content.
 *
 * @see template_preprocess_comment(), preprocess/preprocess-comment.inc
 * http://api.drupal.org/api/function/template_preprocess_comment/6
 */
?>
<!-- start comment.tpl.php -->
<div<?php print $comment_attributes; ?>>
<?php if ($title): ?>
  <div class="inner">
    <span class="title"> <?php print $title; ?>
    <?php if ($comment->new): ?>
      <span class="new"><?php print $new; ?></span>
    <?php endif; ?>
    </span>
  <?php endif; ?>
  <div class="content"><?php print $content; ?></div>
  <?php if ($submitted): ?>
    <div class="info">
      <?php print $picture; ?>
      <?php print t('Posted by !author on !date', array('!author' => $author, '!date' => $date)); ?>
    </div>
  <?php endif; ?>
  </div>
<?php print $links; ?>
</div>
<!-- end comment.tpl.php -->