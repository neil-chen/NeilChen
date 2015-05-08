<style>
  #remover, #file_name, #file_remove {
    float: left;
  }
  #file_name {
    padding: 0 5px;
  }
  #uploader_container {
    padding: 0;
  }
  .plupload_header {
    display: none;
  }
  #uploader_filelist {
    height: auto;
  }
  #uploader_filelist li.plupload_droptext {
    height: auto;
    line-height: 0;
  }
</style>
<?php
/**
 * @file
 * Used to customize the hardware node form.
 */
global $base_url;

$deviceTypeRelation = get_device_type_relation_with_gateway_version();
$deviceTypeRelationStr = '';
foreach ($deviceTypeRelation as $key => $value) {
  $deviceTypeRelationStr .= $key . ',' . $value . '|';
}
if (arg(0) == 'node' && arg(1) == 'add') {
  ?>
  <table class="form-item-table-full add_new">
    <tbody>
      <tr>
        <td style="padding-left : 0px;">
          <h4><?php echo t('1. Select Device Type'); ?></h4>
        </td>
      </tr>
      <tr>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <span title="This field is required." class="form-required">*</span></div><div><?php echo $sw_device_type; ?>
            </div>
          </div>
        </td>
      </tr>
      <!-- Select Device Type end -->
      <tr>
        <td style="padding-left : 0px;">
          <h4><?php echo t('2. Enter Information about the new Software'); ?></h4>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left"><label><?php echo t('Software Name:'); ?></label></div>
          <div class="form-item-div sw_title"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $sw_title; ?></div></div><div class="sw_external"><?php echo $sw_mandatory_update; ?></div>
        </td>
      </tr>
      <!-- Software Name end -->
      <tr>
        <td>
          <div class="label_left"><label title="<?php echo t("Enter '0' if there is no Part #"); ?>"><?php echo t('Software Part #:'); ?></label></div>
          <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $sw_part; ?></div></div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left"><label><?php echo t('Software Version:'); ?></label></div>
          <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $sw_version; ?></div></div>
        </td>
      </tr>

      <tr>
        <td>				
          <div class="form-item-div without_label_left">
            <div class="form-item-left">
              <label><?php echo t('Software Description:'); ?></label>
              <div><?php echo $sw_description; ?></div>
            </div>
            <div class="form-item-div">
              <div class="form-item-div">
                <div><label style="padding-left : 30px;"><?php echo t('Select Software Language:'); ?></label></div>
                <div class="form-item-left" style="padding-left : 22px;"><span title="This field is required." class="form-required">*</span></div>
                <div><?php echo $sw_language; ?></div>
              </div>
            </div>
          </div>				
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left"><label><?php echo t('Software Type:'); ?></label></div>
          <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $sw_type; ?></div></div>								

        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left"><label><?php echo t('Software Status:'); ?></label></div>
          <div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php echo $sw_status; ?></div></div>
        </td>
      </tr>

      <tr>
        <td>				
          <div class="form-item-div">
            <div class="label_left"><label><?php echo t('File Name: (Browse to select a file)'); ?></label></div>
            <div class="form-item-left">
              <span title="This field is required." class="form-required">*</span>
            </div>
            <div class="form-item-left">
              <input type="hidden" name="filesize" id="filesize" value="<?php echo $filesize; ?>"/>
              <div id="uploader"></div>
              <div id="remover" style="display: none;">
                <div id="file_name"></div>
                <input type="button" class="form-submit ahah-processed" value="Remove" id="file_remove" name="file_remove">
                <div class="ahah-progress ahah-progress-throbber"><div class="throbber">&nbsp;</div></div>
              </div>
              <!-- GATEWAY-2971 -->
              <div class="clear_div" style="display: none;">
                <?php echo $sw_file; ?>
              </div>
            </div>
            <div class="form-item-left" style="padding-left:22px;">
              <div class="clear_div"><?php echo $no_file; ?></div>
            </div>
          </div>	
          <div style="clear : both;"></div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left"><label ><?php echo t('CRC:'); ?></label></div>
          <div class="form-item-div">
            <div class="form-item-left"><span class="form-required" style="visibility:hidden;">*</span></div>
            <div><input type="text" name="crc" id="crc" maxlength="50" value="<?php echo $crc; ?>" class="form-text required"
                        placeholder="Enter CRC" /></div>
          </div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left">
            <label title="Number only"><?php echo t('Comparison Order:'); ?></label>
          </div>
          <div class="form-item-div">
            <div class="form-item-left">
              <span title="This field is required." class="form-required">*</span></div>
            <div>
              <input title="Number only" type="text" name="sw_priority" id="sw_priority" maxlength="5" value="<?php echo $sw_priority; ?>" class="form-text required"   placeholder="Enter Software Comparison Order" onkeyup="this.value = this.value.replace(/[^\d]/, '')"/>
            </div>
          </div>
        </td>
      </tr>

      <tr id='hardware_selection_header'>
        <td style="padding-left : 0px;">
          <h4><?php echo t('3. Select the Hardware item(s) from the table below that are compatible with the new software'); ?></h4>
        </td>
      </tr>

      <tr id='hardware_selection_body'>
        <td style="padding-left : 0px;">
          <div class="form-item">
            <table class="form-item-table-full">
              <tbody>
                <tr>
                  <td width="10%;">
                    <label><?php echo t('Filter by hardware type:'); ?></label>
                    <?php echo $hw_list_filter_select; ?>
                  </td>
                  <td valign="bottom" style="padding-left : 0px">
                    <?php echo $hw_list_filter_go; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
      <tr id='hardware_selection_footer'>
        <td>
          <?php echo $hw_list; ?>
          <div id="<?php echo $hidden_hw_list_id; ?>" style="display:none;">
            <?php echo $hidden_hw_list; ?>
          </div>
        </td>
      </tr>

      <tr id='hw_cfg_selection_header'>
        <td style="padding-left : 0px;">
          <h4><?php echo t('3. Select the Hardware configuration(s) from the table below that are compatible with the software'); ?></h4>
        </td>
      </tr>
      <tr id='hw_cfg_selection_footer'>
        <td>
          <div id="hc_list_wraper"></div>
        </td>
      </tr>

      <tr id='fw_cfg_selection_header'>
        <td style="padding-left : 0px;">
          <h4><?php echo t('4. Select the Firmware configuration(s) from the table below that are compatible with the software'); ?></h4>
        </td>
      </tr>
      <tr id='fw_cfg_selection_footer'>
        <td>
          <div id="fc_list_wraper"></div>
        </td>
      </tr>

      <tr>
        <td>
          <br/>
        </td>
      </tr>
      <tr>
        <td>
          <table style="border:none">
            <tbody style="border:none">
              <tr>
                <td width="75%" align="right"><a id="secondary_submit" href="<?php print $base_url; ?>/covidien/admin/software"><?php echo t('Cancel'); ?></a></td>
                <td width="25%"><?php echo $form_submit; ?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
  </table>
  <input type="hidden" id="device_type_relation" name="device_type_relation" value="<?php echo $deviceTypeRelationStr; ?>" />
  <div style="display:none;">
    <?php print $form_render; ?>
  </div>
<?php } else {
  ?>

  <table class="form-item-table-full edit_new" >
    <tr>
      <td colspan="2" style="padding-left : 0px;">
        <h4><?php echo t('The Software item can be edited or archived here.'); ?></h4>
      </td>
    </tr>
    <tr>
      <td width="25%"><span title="This field is required." class="form-required">*</span><label><?php echo t('Software Name:'); ?> </label></td>

      <td>	
        <div><?php echo $sw_title; ?></div>
      </td>
      <td style="padding-left : 0px;">	
        <div><?php echo $sw_mandatory_update; ?></div>
      </td>

    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Device Type:'); ?> </label></td>
      <td><div><?php echo $sw_device_type; ?></div></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label title="<?php echo t("Enter '0' if there is no Part #"); ?>"><?php echo t('Software Part #:'); ?></label></td>
      <td><div><?php echo $sw_part; ?></div></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Software Version:'); ?></label></td>
      <td><div><?php echo $sw_version; ?></div></td>
    </tr>
    <tr>
      <td><div class="without_label_left"><label><?php echo t('Software Description:'); ?></label></div></td>
      <td><?php echo $sw_description; ?></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Software Language:'); ?> </label></td>
      <td><div><?php echo $sw_language; ?></div></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Software Type:'); ?></label></td>			
      <td><?php echo $sw_type; ?></td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required">*</span><label><?php echo t('Software Status:'); ?> </label></td>
      <td><div><?php echo $sw_status; ?></div></td>
    </tr>
    <tr>
      <td valign="middle">
        <span title="This field is required." class="form-required">*</span><label><?php echo t('File Name: (Browse to select a file)'); ?></label>
      </td>
      <td>
        <div class="form-item-left">
          <input type="hidden" name="filesize" id="filesize" value="<?php echo $filesize; ?>"/>
          <div id="uploader"></div>
          <div id="remover" style="display: none;">
            <div id="file_name"></div>
            <input type="button" class="form-submit ahah-processed" value="Remove" id="file_remove" name="file_remove">
            <div class="ahah-progress ahah-progress-throbber"><div class="throbber">&nbsp;</div></div>
          </div>
          <!-- GATEWAY-2971 -->
          <div class="clear_div" style="display: none;">
            <?php echo $sw_file; ?>
          </div>
        </div>
        <div class="form-item-left" style="padding-left:22px;">
          <div class="clear_div"><?php echo $no_file; ?></div>
        </div>
      </td>
    </tr>
    <tr>
      <td><span title="This field is required." class="form-required" style="visibility:hidden;">*</span><label><?php echo t('CRC:'); ?></label></td>			
      <td><input type="text" name="crc" id="crc" maxlength="50" value="<?php echo $crc; ?>" class="form-text required"
                 placeholder="Enter CRC" /></td>
    </tr>
    <tr>
      <td>
        <span title="This field is required." class="form-required">*</span>
        <label title="Number only"><?php echo t('Comparison Order:'); ?></label>
      </td>			
      <td>
        <input title="Number only" type="text" name="sw_priority" id="sw_priority" maxlength="5" value="<?php echo $sw_priority; ?>" class="form-text required"
               placeholder="Enter Comparison Order" onkeyup="this.value = this.value.replace(/[^\d]/, '')"/>
      </td>
    </tr>
    <tr id='hardware_selection_header'>
      <td valign="top">
        <div class="without_label_left"><label><?php echo t('Compatible Hardware:'); ?></label></div>
      </td>
      <td valign="top">
        <div class="form-item-div">
          <div><label><?php echo t('Filter by hardware type:'); ?></label></div>
          <div class="form-item-left"><?php echo $hw_list_filter_select; ?></div>
          <div class="form-item-left" style="padding-left : 20px;"><?php echo $hw_list_filter_go; ?></div>
        </div>				
      </td>	
    </tr>
    <tr id='hardware_selection_footer'>
      <td colspan="3">
        <?php echo $hw_list; ?>
        <div id="<?php echo $hidden_hw_list_id; ?>" style="display:none;">
          <?php echo $hidden_hw_list; ?>
        </div>
      </td>
    </tr> 
    <tr id='hw_cfg_selection_footer'>
      <td colspan="3">
        <div id="hc_list_wraper"></div>
      </td>
    </tr>
    <tr id='fw_cfg_selection_footer'>
      <td colspan="3">
        <div id="fc_list_wraper"></div>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <div id="hardware-message" style="color:red;"><br/></div>
      </td>
    </tr>
    <tr>	
      <td colspan="3" style="padding-left : 0px">
        <table style="border:none">
          <tbody style="border:none">
            <tr>
              <!-- not show delete button --> 
              <td width="25%" align="left" style="display: none"><?php echo $form_delete; ?></td>
              <td width="30%" align="left"><a id="secondary_submit" href="<?php print $base_url; ?>/covidien/admin/<?php print arg(1); ?>/sw_regulatory_approval/<?php print $id; ?> "><?php echo t('Regulatory Exception'); ?></a></td>
              <td width="25%" align="right"><a id="secondary_submit" href="<?php print $base_url; ?>/covidien/admin/software"><?php echo t('Cancel'); ?></a></td>
              <td width="20%"><?php echo $form_submit; ?></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>

  </table>
  <input type="hidden" id="software_id" name="software_id" value="<?php echo arg(1); ?>" />
  <input type="hidden" id="device_type_relation" name="device_type_relation" value="<?php echo $deviceTypeRelationStr; ?>" />
  <div style="display:none">
    <?php print $form_render; ?>
  </div>

<?php } ?>
<input id="node_type" type="hidden" name="node_type" value="software"/>
<script type="text/javascript">
  $(document).ready(function() {
    $('#global_product_line').attr("disabled", "disabled");
  });
</script>


