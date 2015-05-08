<?php if (count($covidien_reports_filter) > 0) { ?>
  <table width="600px">
    <?php
    $filter = $covidien_reports_filter;
    $report_filter_count = count($covidien_reports_filter);
    for ($i = 0; $i < $report_filter_count; $i++) {
      ?>  
      <tr>
        <td style="width : 15%"><?php echo $filter[$i]['label']; ?></td>
        <?php
        if ($filter[$i]['colspan'] == 2) {
          $htmlattr = 'colspan="3"';
        } else {
          $htmlattr = '';
        }
        ?>
        <td style="width : 30%" <?php echo $htmlattr; ?>><?php echo $filter[$i]['value']; ?></td>
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