<style>
.named-configuration-report-item-table {
    padding: 0px;
    margin: 0px;
    width: 100%;
  }
.cfg-table {
	margin-left: 0px;
}  
.cfg-table tr:first-of-type td:first-of-type{
	padding: 0px;
	margin : 0px;
  }
</style>
<?php
$filter_count = count($filter);
if ($filter_count > 0) {
  ?>
  <div class="filter_title"><?php echo t("Filters"); ?></div>
  <table class="report_printing">
    <?php for ($i = 0; $i < $filter_count; $i++) { ?>
      <tr>
        <?php
        if ($filter[$i]['colspan'] == 2) {
          $htmlattr = 'colspan="3"';
          $html_lblstyle = '';
          $html_valstyle = '';
        } else {
          $htmlattr = '';
          $html_lblstyle = ' style="width : 30%" ';
          $html_valstyle = ' style="width : 20%" ';
        }
        ?>

        <td <?php echo $html_lblstyle; ?>><?php echo $filter[$i]['label']; ?></td>

        <td <?php echo $htmlattr . $html_valstyle; ?>><?php echo $filter[$i]['value']; ?></td>
        <?php if ($htmlattr == '') { ?>
          <td style="width : 30%"><?php echo $filter[++$i]['label']; ?></td>
          <td style="width : 20%"><?php echo $filter[$i]['value']; ?></td>
        <?php } ?>
      </tr>
      <?php
    }
    ?>
  </table>
<?php } ?>
<br/>