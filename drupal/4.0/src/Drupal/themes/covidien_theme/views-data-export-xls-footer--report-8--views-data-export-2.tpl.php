<tr><td></td></tr>
<tr><td></td></tr>
<?php 

if(count($covidien_reports_subrow)>0){ ?>
<?php
foreach($covidien_reports_subrow as $subval){
?>
<tr>
<td><?php print $subval['label'];?></td>
<td><?php print $subval['value_text'];?></td>
</tr>
<?php }
?>
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