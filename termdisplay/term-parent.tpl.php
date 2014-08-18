<?php
$pro = current($terms);
$vocabulary = taxonomy_vocabulary_load($pro->vid);
$proname = ($pro->vid == 5) ? t('Dealer') : $vocabulary->name;
?>
<div class="content-block">
  <?php if ($pro->vid == 5) { ?>
    <div class="content-title">
      <?php echo $proname; ?>
    </div>
  <?php } ?>
  <?php
  if (is_array($terms)) {
    foreach ($terms as $item) {
      //var_dump(get_parent_node_count($item->tid,$item->vid));
      //$hide = get_parent_node_count($item->tid, $item->vid) ? '' : 'class="hide"';
      $children = taxonomy_get_children($item->tid);
      $path = (!empty($children)) ? 'mpper/' : (($pro->vid == 5) ? 'dealers/' : 'mpp/');
      if ($item->status) {
        ?>
        <a href="<?php echo url($path . $item->tid); ?>" <?php echo $hide; ?>>
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
