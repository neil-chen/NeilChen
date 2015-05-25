<?php
/**
 * @file
 * Used to customize the hardware node form.
 */
?>
<?php
if (arg(0) == 'node' && arg(1) == 'add') {
  ?>
  <div class="hardware-node-form-add">
    <table class="form-item-table-full add_new">
      <tbody>
        <tr>
          <td style="padding-left : 0px;">
            <div class="form-item">
              <h4><?php echo t('1. Select Device Type'); ?></h4>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item-left">
                  <?php echo $hardware_device_type; ?>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="padding-left : 0px;">
            <div class="form-item">
              <h4><?php echo t('2. Enter Information for the new Hardware'); ?>:</h4>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="label_left"><label> <?php echo t('Hardware Name'); ?>: </label></div>
            <div class="form-item-div">
              <div class="form-item-left">
                <span title="This field is required." class="form-required">*</span>
              </div>
              <div class="form-item-left">
                <?php echo $hardware_title; ?>
              </div>
            </div>
          </td>
        </tr>

        <tr>
          <td>
            <div class="label_left"><label title="<?php echo t("Enter '0' if there is no Part #"); ?>"><?php echo t('Hardware Part #'); ?>:</label></div>
            <div class="form-item-div">
              <div class="form-item-left">
                <span title="This field is required." class="form-required">*</span>
              </div>
              <div class="form-item-left">
                <?php echo $hardware_part; ?>
              </div>
            </div>
          </td>
        </tr>

        <tr>
          <td>
            <div class="label_left"><label><?php echo t('Hardware Revision'); ?>: </label></div>
            <div class="form-item-div">
              <div class="form-item-left">
                <span title="This field is required." class="form-required">*</span>
              </div>
              <div class="form-item-left">
                <?php echo $hardware_version; ?>
              </div>
            </div>	
          </td>
        </tr>
        <tr>
          <td>
            <div class="without_label_left">
              <div><label><?php echo t('Hardware Description'); ?>: </label></div>
              <div><?php echo $field_hw_description; ?></div>
            </div>
          </td>
        </tr>
        <tr>
          <td>						
            <div class="label_left"><label><?php echo t('Select Hardware Type'); ?>:</label></div>
            <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div>
              <div class="form-item-left" id="inner"><?php echo $hardware_type; ?></div>
            </div>						
          </td>
        </tr>
        <tr>
          <td>						
            <div class="label_left"><label><?php echo t('Select Hardware Status'); ?>:</label></div>
            <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div>
              <div class="form-item-left" id="inner"><?php echo $hardware_status; ?></div>
            </div>						
          </td>
        </tr>
        <!-- GATEWAY-2443
        <tr>
          <td>		
            <div class="without_label_left">
              <div><label><?php echo t('Device Serial Number'); ?>: </label></div>
              <div><?php echo $device_serial_number; ?></div>
            </div>
          </td>
        </tr>
        -->
        <tr>
          <td align="right">
            <table width="100%" style="border:none">
              <tbody style="border:none">
                <tr>
                  <!-- not show delete button --> 
                  <td width="60%"><div style="display: none;"><?php echo $hardware_delete; ?></div></td>
                  <td width="15%"><a id="secondary_submit" href="<?php echo url('covidien/admin/hardware'); ?>"><?php echo t('Cancel'); ?></a></td>
                  <td width="25%"><?php echo $hardware_submit; ?></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <div style="display:none">
      <?php print $hardware_render; ?>
    </div>
  </div>
<?php } else {
  ?>

  <table class="form-item-table-full edit_new" >
    <tr>
      <td colspan="2" style="padding-left : 0px;">
        <h4><?php echo t('The Hardware item can be edited or archived here.'); ?></h4>
      </td>
    </tr>
    <tr>
      <td width="20%">
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Hardware Name:'); ?> </label>
      </td>
      <td>
        <div><?php echo $hardware_title; ?></div>
      </td>
    </tr>
    <tr>
      <td>
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Device Type:'); ?></label>
      </td>
      <td>
        <div class="form-item-div"><div class="form-item-left"></div><div><?php echo $hardware_device_type; ?> 
            </td>
            </tr>
            <tr>
              <td>
                <span title="This field is required." class="form-required">*</span><label title="<?php echo t("Enter '0' if there is no Part #"); ?>"><?php echo t('Hardware Part #:'); ?> </label>
              </td>
              <td>
                <div><?php echo $hardware_part; ?><div>
                    </td>
                    </tr>
                    <tr>
                      <td>
                        <span title="This field is required." class="form-required">*</span><label><?php echo t('Hardware Revision:'); ?> </label>
                      </td>
                      <td>
                        <div><?php echo $hardware_version; ?><div>
                            </td>
                            </tr>
                            <tr>
                              <td>
                                <div class="without_label_left"><label><?php echo t('Hardware Description:'); ?></label></div>
                              </td>
                              <td>
                                <?php echo $field_hw_description; ?>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span title="This field is required." class="form-required">*</span><label><?php echo t('Hardware Type:'); ?></label>
                              </td>
                              <td>
                                <div><?php echo $hardware_type; ?></div>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span title="This field is required." class="form-required">*</span><label><?php echo t('Hardware Status:'); ?></label>
                              </td>
                              <td>
                                <div><?php echo $hardware_status; ?></div>
                              </td>
                            </tr>
                            <!-- GATEWAY-2443
                            <tr>
                              <td>
                                <div class="without_label_left"><label><?php //echo t('Device Serial Number:');           ?></label></div>
                              </td>
                              <td>
                                <div><?php //echo $device_serial_number;            ?></div>
                              </td>
                            </tr>
                            -->
                            <tr>
                              <td colspan="2" style="padding-left : 0px">
                                <table width="100%" style="border:none">
                                  <tbody style="border:none">
                                    <tr>
                                      <!-- not show delete button --> 
                                      <td width="15%" align="left"><div style="display: none;"><?php echo $hardware_delete; ?></div></td>
                                      <td width="60%" align="right"><a id="secondary_submit" href="<?php echo url('covidien/admin/hardware'); ?>"><?php echo t('Cancel'); ?></a></td>
                                      <td width="20%"><?php echo $hardware_submit; ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <div style="display:none">
                              <?php print $hardware_render; ?>
                            </div>
                            </table>
                          <?php } ?>

                          <input type="hidden" name="hardware_id" id="hardware_id" value="<?php echo $hardware_id; ?>"/>