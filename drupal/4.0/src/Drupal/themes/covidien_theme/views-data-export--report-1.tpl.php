<?php
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
//note:For Query Debug
//db_prefix_tables($view->build_info['query']);
drupal_add_js(drupal_get_path('module', 'covidien_reports') . '/js/report1.js');
$agrs = device_current_configuration_report_args();
$report_filter = device_current_configuration_report_filter($agrs);
$covidien_reports_sub_table = device_current_configuration_report_sw_version_by_account();
$covidien_reports_sub2_table = device_current_configuration_report_sw_version_country_by_device_type();
$product_line = get_nodetitle($report_filter['Class of Trade']);
$device_type = get_nodetitle($report_filter['Device Type']);
$country = get_nodetitle($report_filter['Country']);
?>

<div class="filter_title"><?php echo t("Filters"); ?></div>
<table class="report1_printing">
  <tbody>
    <tr>
      <td style="width : 25%">Class of Trade:</td>
      <td style="width : 20%"><?php echo $product_line ? $product_line : 'All'; ?></td>	
      <td style="width : 20%">Device Type:</td>
      <td style="width : 35%"><?php echo $device_type ? $device_type : 'All'; ?></td>
    </tr>
    <tr>
      <td style="width : 25%">Customer Name:</td>
      <td style="width : 20%"><?php echo $report_filter['Customer Name'] ? $report_filter['Customer Name'] : 'All'; ?></td>	
      <td style="width : 20%">Customer Account Number:</td>
      <td style="width : 35%"><?php echo $report_filter['Customer Account Number'] ? $report_filter['Customer Account Number'] : 'All'; ?></td>
    </tr>
    <tr>
      <td style="width : 25%">Country:</td>
      <td style="width : 20%"><?php echo $country ? $country : 'All'; ?></td>	
      <td style="width : 20%">Device Serial Number:</td>
      <td style="width : 35%"><?php echo $report_filter['Device Serial Number'] ? $report_filter['Device Serial Number'] : 'All'; ?></td>
    </tr>
    <tr>
      <td style="width : 25%">Hardware Name:</td>
      <td style="width : 20%"><?php echo $report_filter['Hardware Name'] ? $report_filter['Hardware Name'] : 'All'; ?></td>	
      <td style="width : 20%">Hardware Revision:</td>
      <td style="width : 35%"><?php echo $report_filter['Hardware Revision'] ? $report_filter['Hardware Revision'] : 'All'; ?></td>
    </tr>
    <tr>
      <td style="width : 25%">Hardware Part #:</td>
      <td style="width : 20%"><?php echo $report_filter['Hardware Part'] ? $report_filter['Hardware Part'] : 'All'; ?></td>	
      <td style="width : 20%">Software Name:</td>
      <td style="width : 35%"><?php echo $report_filter['Software Name'] ? $report_filter['Software Name'] : 'All'; ?></td>
    </tr>
    <tr>
      <td style="width : 25%">Software Version:</td>
      <td style="width : 20%"><?php echo $report_filter['Software Version'] ? $report_filter['Software Version'] : 'All'; ?></td>	
      <td style="width : 20%">Software Part #:</td>
      <td style="width : 35%"><?php echo $report_filter['Software Part'] ? $report_filter['Software Part'] : 'All'; ?></td>
    </tr>
  </tbody>
</table>

<br/>
<div class="<?php print $classes; ?>">
  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <br/>
  <table class="report1_noborder">
    <tr>
      <td class="report1_noborder">
        <?php echo 'Total at each SW version by Account'; ?>
        <?php echo $covidien_reports_sub_table; ?>
      </td>
      <td class="report1_noborder">
        <?php echo 'Total at each SW version for each country by device type'; ?>
        <?php echo $covidien_reports_sub2_table; ?>
      </td>
    </tr>
  </table>

  <div class="view-footer form-item-div">
    <?php global $base_url; ?>
    <?php if (empty($covidien_reports_noresult)) { ?>
      <div class="form-item-left">
        <a href="<?php echo $base_url . '/covidien/report/1/pdf/Device_Current_Configuration_Report?' . $export_filter_param; ?>" id="secondary_submit">Download as PDF</a>
      </div>
      <div class="form-item-left">
        <a href="<?php echo $base_url . '/covidien/report/1/xls?' . $export_filter_param; ?>" id="secondary_submit">Download as XLS</a>
      </div>
      <div class="form-item-left">
        <a href="<?php echo $base_url . '/covidien/report/1/csv?' . $export_filter_param; ?>" id="secondary_submit">Download as CSV</a>
      </div>
    <?php } ?>
    <div class="form-item-right" style="width : 50px;">
      <a href="<?php print $base_url; ?>/covidien/reports/filter/1" id="secondary_submit"><?php echo t("Return"); ?></a>
    </div>
  </div>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div> <?php /* class view */ ?>
