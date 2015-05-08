<?php global $base_url; ?>
<div class="view view-report-3 view-id-report_3 view-display-id-page_1 view-dom-id-1">
  <div><?php echo $filters; ?></div>
  <div><?php echo $table_list; ?></div>
  <!-- footer button -->
  <div class="view-footer form-item-div">
    <?php if ($count) { ?>
      <div class="form-item-left">
        <a class="form-submit secondary_submit" id="secondary_submit" href="<?php echo $base_url . '/covidien/reports/software_audit_report_pdf?select_type=' . check_plain($_GET['select_type']).'&device_type=' . check_plain($_GET['device_type']); ?>"><?php echo t("Download as PDF"); ?></a>
      </div>
      <div class="form-item-left">
        <a class="form-submit secondary_submit" id="secondary_submit" href="<?php echo $base_url . '/covidien/reports/software_audit_report_xls?select_type=' . check_plain($_GET['select_type']).'&device_type=' . check_plain($_GET['device_type']); ?>"><?php echo t("Download as XLS"); ?></a>
      </div>
      <div class="form-item-left">
        <a class="form-submit secondary_submit" id="secondary_submit" href="<?php echo $base_url . '/covidien/reports/software_audit_report_csv?select_type=' . check_plain($_GET['select_type']).'&device_type=' . check_plain($_GET['device_type']); ?>"><?php echo t("Download as CSV"); ?></a>
      </div>
    <?php } ?>
    <div class="form-item-right" style="width : 50px;">
      <a href="<?php echo url('covidien/reports/filter/16') ?>" id="secondary_submit" class="form-submit secondary_submit"><?php echo t("Return"); ?></a>
    </div>
  </div>

</div>