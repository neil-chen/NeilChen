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
?>

<?php if (count($report_filter) > 0) { ?>
  <div class="filter_title"><?php echo t("Filters"); ?></div>
  <table class="report_printing">
    <?php
    $filter = $report_filter;
    $report_filter_count = count($report_filter);
    for ($i = 0; $i < $report_filter_count; $i++) {
      ?>  
      <tr>
        <?php
        if ($filter[$i]['colspan'] == 2) {
          $htmlattr = 'colspan="3"';
          $html_lblstyle = '';
          $html_valstyle = '';
        } else {
          $htmlattr = '';
          $html_lblstyle = ' style="width : 40%" ';
          $html_valstyle = ' style="width : 25%" ';
        }
        ?>

        <td <?php echo $html_lblstyle; ?>><?php echo $filter[$i]['label']; ?></td>

        <td  <?php echo $htmlattr . $html_valstyle; ?>><?php echo $filter[$i]['value']; ?></td>	
        <?php if ($htmlattr == '') { ?>
          <td style="width : 30%"><?php echo $filter[++$i]['label']; ?></td>
          <td style="width : 25%"><?php echo $filter[$i]['value']; ?></td>
        <?php } ?>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
}
?>
<br><br>
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

  <div class="dev_con_rep_message"><?php print $covidien_reports_noresult; ?> </div>


  <div class="view-footer form-item-div">
    <?php global $base_url; ?>
    <?php if (empty($covidien_reports_noresult)) { ?>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('<?php echo $base_url . '/covidien/report/2/pdf/Software_Upgrade_Report?' . $export_filter_param; ?>', '_blank');
          return true;" value="<?php echo t("Download as PDF"); ?>" id="edit-add-new"></div>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('<?php echo $base_url . '/covidien/report/2/xlsx?' . $export_filter_param; ?>', '_blank');
          return true;" value="<?php echo t("Download as XLSX"); ?>" id="edit-add-new"></div>
      <div class="form-item-left"><input type="button" class="form-submit secondary_submit" onclick="window.open('<?php echo $base_url . '/covidien/report/2/csv?' . $export_filter_param; ?>', '_blank');
          return true;" value="<?php echo t("Download as CSV"); ?>" id="edit-add-new"></div>
                                       <?php } ?>
    <div class="form-item-right" style="width : 50px;">
      <a href="<?php print $base_url; ?>/covidien/reports/filter/2" id="secondary_submit"><?php echo t("Return"); ?></a>
    </div>
  </div>





  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div> <?php /* class view */ ?>
