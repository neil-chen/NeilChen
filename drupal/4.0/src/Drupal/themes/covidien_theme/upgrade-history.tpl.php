<?php
global $base_url;
global $wordwraplength, $wordwrapchar;
$topic = filter_xss($_GET['topic']);
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.after tr:first,.before tr:first').before('<tr><th colspan="3" style="text-align:center"><?php print t('Hardware'); ?></th><th colspan="3" style="text-align:center"><?php print t('Software'); ?></th></tr>');
    $('body').css('margin-top', '25px');
  });

</script>
<table class="form-item-table-full" style="width:600px">
  <tr>
    <td width="90px" valign="top"><label><?php echo t('Device Type:'); ?></label></td>
    <td width="100px" valign="top"><label><b><?php print $device_type; ?></b></label></td>
    <td width="90px" valign="top"><label><?php echo t('Device Serial Number:'); ?></label></td>
    <td width="150px" valign="top"><label><b><?php print wordwrap($serial_number, $wordwraplength, $wordwrapchar, TRUE); ?></b></label></td>
  </tr>
  <tr>
    <td valign="top"><label><?php echo t('Customer Name:'); ?></label></label></td>
    <td valign="top"><label><b><?php print wordwrap($customer_name, $wordwraplength, $wordwrapchar, TRUE); ?></b></label></td>
    <td valign="top"><label><?php echo t('Service Person:'); ?></label></td>
    <td valign="top"><label><b><?php print $person; ?></b></label></td>
  </tr>
  <tr>
    <td valign="top"><label><?php echo t('Date & Time:'); ?></label></td>
    <td valign="top" colspan="3"><label><b><?php print $date; ?></b></label></td>
  </tr>
</table>

<p><strong>Before Upgrade</strong></p>
<?php echo $before_upgrade; ?>

<p><strong>After Upgrade</strong></p>
<?php echo $after_upgrade; ?>

<div style="margin-top:50px; clear:both" align="right"><a id="secondary_submit" href="javascript:void(0)" onclick="javascript:parent.$.colorbox.close();
    return false;"><?php echo t('Ok'); ?></a> <?php print $save; ?></td></tr>
</div>