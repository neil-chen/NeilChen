<table>
  <tr></tr>
  <tr>
    <td><b><?php echo $covidien_reports_subline; ?></b></td>
    <td></td><td></td><td></td><td></td>
    <td><b><?php echo $covidien_reports_sub2line; ?></b></td>
  </tr> 
    
<tr>
<?php
foreach($covidien_reports_subkey as $key){ ?>
<td style="text-align: center"><b><?php echo $key;?></b></td>
<?php
}
?>
<td></td>
<?php
foreach($covidien_reports_sub2key as $key){ ?>
<td style="text-align: center"><b><?php echo $key;?></b></td>
<?php
}
?>
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
    if($i<=$sub1length){
         foreach(array_shift($covidien_reports_subval) as $val){
             ?>
           <td style="text-align: center">
             <?php echo $val;?>
           </td>
     <?php
         }
     ?>
     <td></td>
     <?php 
     }else{
     ?>
         <td></td><td></td><td></td><td></td>
     <?php
     }
     if($i<=$sub2length){
         foreach(array_shift($covidien_reports_sub2val) as $val){
     ?>
             <td style="text-align: center">
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
 