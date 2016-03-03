<?php
// $Id$

/**
 * @file
 * Outputs contents of form node types
 *
 * @see template_preprocess_node(), preprocess/preprocess-node.inc
 * http://api.drupal.org/api/function/template_preprocess_node/6
 */
?>
<!-- start node-forum.tpl.php -->
<div<?php print $node_attributes; ?>>
  <div class="forum-wrapper-left">
    <ul class="meta-author">
      <?php if ($picture): // print users picture, if enabled ?>
      <li class="user-picture"><?php print $picture; ?></li>
      <?php endif; ?>
      <li class="user-name"><span><?php print $name; ?></span></li>
      <?php if ($joined): ?>
      <li class="user-joined">
        <label>Joined:</label>
        <span><?php print $joined; ?></span></li>
      <?php endif; ?>
    </ul>
 </div>
  <div class="forum-wrapper-right<?php print $picture ? ' with-picture' : ' without-picture'; // for modifiable min-height ?>">
    <div class="meta-post">
      <span class="date">Posted:</span> <?php print $date; ?></span>
    </div>
    <div class="content">
      <div class="inner">
        <?php print $content; ?>
      </div>
    </div>
  </div>
  <div class="links"><?php print $links; ?> </div>
</div>
<!-- end node-forum.tpl.php -->