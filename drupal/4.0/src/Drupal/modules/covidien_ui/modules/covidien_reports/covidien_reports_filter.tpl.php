<?php
/**
 * Customized in themes.
 */
?>
<?php if (count($covidien_reports_filter) > 0) { ?>
  <table width="600px">
    <?php
    $filter = $covidien_reports_filter;
    $report_filter_count = count($covidien_reports_filter);
    for ($i = 0; $i < $report_filter_count; $i++) {
      ?>  
      <tr>
        <td width="30%"><?php echo $filter[$i]['label']; ?></td>
        <td width="10%"><?php echo $filter[$i]['value']; ?></td>
        <td width="20%">&nbsp;&nbsp;&nbsp;</td>
        <td width="30%"><?php echo $filter[++$i]['label']; ?></td>
        <td width="10%"><?php echo $filter[$i]['value']; ?></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
}
?>