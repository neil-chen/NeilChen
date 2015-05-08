<?php global $base_url; ?>

<div class="view-footer form-item-div">
  <?php if ($filter['count']) { ?>
    <?php $message = "window.alert('Please narrow down your date range to be less than 30 days before you could download the file.');"; 
    if($filter['date_range_valid'] === true): ?>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('<?php echo $base_url . '/covidien/report/5/audit-trail-pdf?' . $filter['url']; ?>', '_blank');
        return true;" value="<?php echo t("Download as PDF"); ?>" id="edit-add-new"></div>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('<?php echo $base_url . '/covidien/report/5/audit-trail-xls?' . $filter['url']; ?>', '_blank');
          return true;" value="<?php echo t("Download as XLS"); ?>" id="edit-add-new"></div>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('<?php echo $base_url . '/covidien/report/5/audit-trail-csv?' . $filter['url']; ?>', '_blank');
          return true;" value="<?php echo t("Download as CSV"); ?>" id="edit-add-new"></div>
    <?php else: ?>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="<?php print($message); ?>" value="<?php echo t("Download as PDF"); ?>" id="edit-add-new"></div>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="<?php print($message); ?>" value="<?php echo t("Download as XLS"); ?>" id="edit-add-new"></div>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="<?php print($message); ?>" value="<?php echo t("Download as CSV"); ?>" id="edit-add-new"></div>
    <?php endif; ?> 
    
  <?php } ?>
  <div class="form-item-right" style="width : 50px;">
    <a href="<?php echo $base_url; ?>/covidien/reports/filter/5" id="secondary_submit" class="form-submit secondary_submit"><?php echo t("Return"); ?></a>
  </div>
</div>