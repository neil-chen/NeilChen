<?php
global $base_url;
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#header-region, .head_and_menu').css('display', 'none');
    $('#container').css('border', 'none');
    $('.left-corner').css('margin-top', '20px');
    $('#wrapper').css('width', '400px');

  });
</script>
<h2><?php print $name; ?></h2>
<table class="form-item-table-full">
  <tr>
    <td colspan="2">
      <div class="form-item-div">
        <div class="form-item-left"><?php echo t('Covidien employee:'); ?></div>
        <div class="form-item-div"><?php print $isemp; ?></div>
      </div>
    </td>
  </tr>

  <?php if ($isemp == "Yes") { ?>
    <tr><td width="37%"><?php echo t('Business Unit:'); ?></td><td><?php print $business; ?></td></tr>
    <!--<tr><td> <?php echo t('Department:'); ?></td><td><?php print $department; ?></td></tr>-->
  <?php } ?>
  <tr><td></td></tr>
  <?php if ($isemp == "No") { ?>
    <tr><td> <?php echo t('Company Name:'); ?></td><td><?php print $company; ?></td></tr>
    <tr><td> <?php echo t('Facility:'); ?></td><td><?php print $facility; ?></td></tr>
  <?php } ?>
  <tr><td></td></tr>
  <tr><td> <?php echo t('Email address:'); ?></td><td><?php print $email; ?></td></tr>
</table>
<div align="right">
  <input type="button" class="form-submit	" onclick="javascript:parent.$.colorbox.close();
      return false;" value="OK" id="edit-add-new">
</div>