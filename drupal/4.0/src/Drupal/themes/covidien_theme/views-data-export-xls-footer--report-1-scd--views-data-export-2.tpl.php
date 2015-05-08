<tr><td></td></tr>
<tr><td></td></tr>
<tr><td><b><?php echo $covidien_reports_subline; ?></b></td></tr>
<tr><td></td></tr>
<?php if (count($covidien_reports_subkey) > 0): ?>
  <tr>
    <?php foreach ($covidien_reports_subkey as $key): ?>
      <td><?php echo $key; ?></td>
    <?php endforeach; ?>
  </tr>
<?php endif; ?>
<?php if (count($covidien_reports_subval) > 0): ?>
  <?php foreach ($covidien_reports_subval as $subval): ?> 
    <tr>
      <?php foreach ($subval as $val): ?>
        <td><?php echo $val; ?></td>
      <?php endforeach; ?>
    </tr>
  <?php endforeach; ?>
<?php endif; ?> 
<tr></tr>
<tr></tr> 
<tr>  
<tr></tr>
<tr><td><b><?php echo $covidien_reports_sub2line; ?></b></td></tr>
<?php foreach($covidien_reports_sub2key as $key): ?>
  <td><b><?php echo $key;?></b></td>
<?php endforeach; ?>
</tr> 
<?php
$sub1length = count($covidien_reports_subval);
$sub2length = count($covidien_reports_sub2val);
for($i=1;;$i++){
  if($i>$sub1length && $i>$sub2length){
    break;
  }
  ?>
  <tr>
  <?php 
    if($i<=$sub2length){
       foreach(array_shift($covidien_reports_sub2val) as $val){
     ?>
      <td>
      <?php echo $val; ?>
      </td>
     <?php
      }
    }
  ?>
  </tr>
<?php
}
?>
<tr><td></td></tr>
<tr><td></td></tr>
<tr><td><?php echo t('Covidien Report'); ?></td></tr>
</tbody>
</table>
</body>
</html>