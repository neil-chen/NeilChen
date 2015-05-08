<tr><td></td></tr>
<tr><td></td></tr>
<tr><td><b><?php echo $covidien_reports_subline; ?></b></td></tr>
<tr><td></td></tr>
<?php if (count($covidien_reports_subkey) > 0) { ?>
  <tr>
    <?php foreach ($covidien_reports_subkey as $key) { ?>
      <td style="text-align:center"><b><?php echo $key; ?></b></td>
      <?php
    }
    ?>
  </tr>
  <?php } ?>
  <?php
  if (count($covidien_reports_subval) > 0) {
    foreach ($covidien_reports_subval as $subval) {
      ?>
      <tr>
        <?php
        foreach ($subval as $val) {
          ?>
          <td style="text-align:center"><?php echo $val; ?></td>
        <?php }
        ?>
      </tr>
    <?php }
  ?>

  <?php
}
?>
  
<?php //Will have to clean up the messy codes when we have time. Temporary just have to leave the messy codes alone ?>
<table>
  <tr></tr>
  <tr></tr>
  <tr><td><b><?php echo $covidien_reports_sub2line; ?></b></td></tr>
  <tr>      
    <?php foreach($covidien_reports_sub2key as $key): ?>
    <td style="text-align:center"><b><?php echo $key;?></b></td>
    <?php endforeach; ?>
  </tr>
  <tr>
    <?php foreach($covidien_reports_sub2val as $value): ?>
    <tr>
      <td style="text-align:center"><?php print($value[0]); ?></td>
      <td style="text-align:center"><?php print($value[1]); ?></td>
      <td style="text-align:center"><?php print($value[2]); ?></td>
      <td style="text-align:center"><?php print($value[3]); ?></td>
    </tr>
    <?php endforeach; ?>
  </tr>
  <tr></tr>
  <tr></tr>
</table>
     
     
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td><?php echo t('Covidien Report'); ?></td></tr>
</tbody>
</table>
</body>
</html>