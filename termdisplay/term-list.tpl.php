<div class="content-block">
  <?php
  if (count($terms)) {
    foreach ($terms as $item) {
      $path = $item->nid ? 'node/' : ((count($item->children)) ? 'mpper/' : 'mpp/');
      if ($item->status) {
        ?>
        <a href="<?php echo url($path . ($item->nid ? $item->nid : $item->tid)); ?>">
          <div class="product-item category-item">
            <?php echo $item->name; ?>
          </div>
        </a>
        <?php
      }
    }
  }
  ?>
</div>
