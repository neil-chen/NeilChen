<?php
/**
 * @file
 * base file device_availability-add.tpl.php
 */
?>
<?php global $base_url; ?>
<script type="text/javascript">
  $(document).ready(function() {

//	$('#container').css('border','none');
    $('#wrapper').css('width', '450px');
  });
</script>
<table class="form-item-table-full add_roles regulatary_approval">
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><label><?php echo t('Device Type:'); ?></label></div>
      </div>
    </td>
    <td>
      <input type="text" value="<?php print $device_type; ?>" disabled />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><label><?php echo t('Software Name:'); ?></label></div>
      </div>
    </td>
    <td>
      <input type="text" value="<?php print $sw_name; ?>" disabled />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><label><?php echo t('Software Part Number:'); ?></label></div>
      </div>
    </td>
    <td>
      <input type="text" value="<?php print $sw_part; ?>" disabled />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><label><?php echo t('Software Version:'); ?></label></div>
      </div>
    </td>
    <td>
      <input type="text" value="<?php print $sw_version; ?>" disabled />
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <div class="form-item-left"><label><?php echo t('Software Description:'); ?></label></div>
      </div>
    </td>
    <td>
      <input type="text" value="<?php print $sw_desc; ?>" disabled />
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div class="form-item-div">
        <div class="form-item-left" style="padding: 28px 5px 0px 0px;">
          <span title="This field is required." class="form-required">*</span>
        </div>
        <div class="form-item-left">
          <div><label><?php echo t('Country:'); ?></label></div>
          <div class="reg_country"><?php print $country; ?></div>
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;
    </td>
  </tr>
  <tr>
    <td>
      <?php
      /**
       * parent.$.colorbox.close(); implemented.
       */
      ?>
      <a id="secondary_submit" href="javascript:void(0)" onclick="javascript:parent.$.colorbox.close();
          return false;"><?php echo t('Cancel'); ?></a>
    </td>
    <td>
      <?php print $save; ?>
    </td>
  </tr>
</table>
<div style="display:none">
  <?php print $render; ?>
</div>