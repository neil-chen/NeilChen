<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
    <table>
      <tr><td colspan="2"><h2><?php echo t('Covidien'); ?></h2></td></tr>
      <tr><td><?php print t('Title :'); ?></td><td> <?php echo t('Software Upgrade Report'); ?></td></tr>
      <tr><td><?php print t('Date :'); ?></td><td> <?php print date("m/d/Y"); ?></td></tr>
      <tr><td></td></tr>
      <tr><td></td></tr>
      <?php if (count($report_filter) > 0) { ?>

        <?php
        $filter = $report_filter;
        $report_filter_count = count($report_filter);
        for ($i = 0; $i < $report_filter_count; $i++) {
          unset($filter[$i]['colspan']);
          ?>  
          <tr>
            <td><?php echo $filter[$i]['label']; ?></td>
            <td><?php echo $filter[$i]['value']; ?></td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><?php echo $filter[++$i]['label']; ?></td>
            <td><?php echo $filter[$i]['value']; ?></td>
          </tr>
          <?php
        }
        ?>

        <?php
      }
      ?>
      <tr><td></td></tr>
      <tr><td></td></tr>
      <?php print $header_row; ?>
      <tbody>