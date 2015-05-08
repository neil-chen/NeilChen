<?php
/**
 * @file
 * Used to customize the hardware node form.
 */
global $base_url;
?>
<?php if (arg(0) == 'node' && arg(1) == 'add') { ?>
  <table class="form-item-table-full add_new" style="margin-left: -5px;"><tbody>
      <tr>
        <td style="padding-left : 0px;">
          <h4><?php echo t('1. Select Device Type:'); ?></h4>
        </td>
      </tr>

      <tr>
        <td>
          <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $device_type; ?></div></div>
        </td>
      </tr>

      <tr>
        <td style="padding-left : 0px;">
          <h4><?php echo t('2. Enter Information for the new Configuration:'); ?></h4>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left"><label><?php echo t('Configuration Name:'); ?></label></div>
          <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $config_title; ?></div></div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left"><label><?php echo t('Configuration Version Number:'); ?></label></div>
          <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $field_device_config_version; ?></div></div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="form-item-div">					
            <div class="form-item-left"><span title="This field is required." class="form-required">*</span></div>
            <div class="form-item-left"><label><?php echo t('Enter Effective Date:'); ?></label></div>
            <div class="form-item-left" style="padding-left : 18px;"><?php echo $field_effective_date; ?></div>
          </div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="form-item-div" style="padding-left : 8px;">								
            <div class="form-item-left"><label><?php echo t('Enter End of Life Date:'); ?></label></div>
            <div class="form-item-left" style="padding-left : 7px;"><?php echo $field_device_end_of_life; ?></div>
          </div>
        </td>
      </tr>


      <tr>
        <td style="padding-left : 0px;">
          <div class="form-item-div" style="margin-left : -9px;">
            <div class="form-item-left">
              <span title="This field is required." class="form-required">*</span>
            </div>	
            <div class="form-item-left">
              <h4><?php echo t('3. Select items from the Hardware/Software Catalog to add to this Configuration:'); ?></h4>
            </div>
          </div>
        </td>
      </tr>

      <tr>
        <td style="padding-left : 0px;">
          <table class="form-item-table-full">
            <tr>
              <td class="add_edit_config" valign="top" style="padding-left : 0px;">
                <?php echo $config_hw_list; ?>
                <div id="<?php echo $hidden_config_hw_list_id; ?>" style="display:none;">
                  <?php echo $hidden_config_hw_list; ?>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr>
        <td align="right" style="padding-right : 11px;">
          <div style="clear : both;" />
          <div class="form-item-div">
            <div class="form-item-right" style="width : 200px;"><?php echo $form_submit; ?></div>
            <div class="form-item-right"><a id="secondary_submit" href="<?php print $base_url; ?>/covidien/admin/configuration"><?php echo t('Cancel'); ?></a></div>
          </div>
        </td>
      </tr>		
  </table>




  <div style="display:none;">
    <?php print $form_render; ?>
  </div>
<?php } else { ?>
  <table class="form-item-table-full edit_new" >
    <tr>
      <td colspan="2" style="padding-left : 0px;">
        <h4><?php echo t('The Configuration can be edited or deleted here.'); ?></h4>
      </td>
    </tr>
    <tr>
      <td style="width : 25%"><span title="This field is required." class="form-required">*</span><label><?php echo t('Configuration Name:'); ?> </label></td>
      <td><div><?php echo $config_title; ?></div></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Device Type:'); ?> </label></td>
      <td><div><?php echo $device_type; ?></div></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Configuration Version Number:'); ?></label></td>
      <td><div><?php echo $field_device_config_version; ?></div></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Effective Date:'); ?></label></td>
      <td><div><?php echo $field_effective_date; ?></div></td>
    </tr>
    <tr>
      <td><div style="padding-left : 8px;"><label><?php echo t('End of Life Date:'); ?></label><div></td>
            <td><div><?php echo $field_device_end_of_life; ?></div></td>
            </tr>
            <tr>
              <td colspan="2">
                <div style="padding-left : 8px;">
                <?php echo t('Hardware/Software items included in this configuration:'); ?></label></td>
          </div>
    </tr>
    <tr>
      <td colspan="2">
        <table class="form-item-table-full">
          <tr>
            <td valign="top" class="add_edit_config" style="padding-left : 0px;">
              <?php echo $config_hw_list; ?>
              <div id="<?php echo $hidden_config_hw_list_id; ?>" style="display:none;">
                <?php echo $hidden_config_hw_list; ?>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>	
      <td colspan="2" style="padding-left : 0px">
        <div class="form-item-div" style="padding-right : 11px;">
          <div class="form-item-left" style="width : 200px;"><?php echo $form_delete; ?></div>
          <div class="form-item-right" style="width : 200px;"><?php echo $form_submit; ?></div>
          <div class="form-item-right" ><a id="secondary_submit" href="<?php print $base_url; ?>/covidien/admin/configuration"><?php echo t('Cancel'); ?></a></div>
        </div>
      </td>
    </tr>

  </table>
  <div style="display:none">
    <?php print $form_render; ?>
  </div>
<?php } ?>
