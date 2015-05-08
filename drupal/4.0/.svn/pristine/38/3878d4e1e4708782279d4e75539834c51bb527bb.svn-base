<?php
global $base_url;
$file_id = $firmware['id'] ? $firmware['file_id'] : '';
$action = $firmware['id'] ? '/firmware/update' : '/firmware/save';
?>
<style>
  #firmware_file-wrapper {
    margin-top: -28px;
    margin-top: -22px\9;
    opacity: 0;
    position: relative;
    text-align: right;
    width: 200px;
    z-index: 2;
  }
  #firmware_file-wrapper input{
    width: 200px;
  }
  #edit-filefield-upload, #edit-filefield-remove {
    float: left;
  }
  #file-message {
    padding-left: 8px;
    color: red;
    clear: both;
    display: none;
  }
</style>
<div id='error-message' style='color:red;'></div>
<div>
  <table class="form-item-table-full add_new">
    <tbody>
      <?php if ($firmware['id']) { ?>
        <tr>
          <td style="padding-left : 0px;">
            <h4><?php echo t('The Firmware item can be edited or archived here.'); ?></h4>
          </td>
        </tr>
      <?php } ?>
      <tr>
        <td style="padding-left: 0px;">
          <h4>1. Select Device Type</h4>
        </td>
      </tr>
      <tr>
        <td>
          <div class="form-item-div">
            <div class="form-item-left">
              <span title="This field is required." class="form-required">*</span>
            </div>
            <div class="form-item" id="edit-field-device-type-nid-nid-wrapper">
              <?php echo $select_device; ?>	
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <h4>2. Enter Information about the new Firmware</h4>
        </td>
      </tr>
      <tr>
        <td>
          <div class="label_left">
            <label>Firmware Name:</label>
          </div>
          <div class="form-item-div">
            <div class="form-item-left">
              <span class="form-required" title="This field is required.">*</span>
            </div>
            <div>
              <div class="form-item" id="edit-title-wrapper">
                <?php echo drupal_render($form['firmware_name']); ?>
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="label_left">
            <label title="Enter '0' if there is no Part #">Firmware Part #:</label>
          </div>
          <div class="form-item-div">
            <div class="form-item-left">
              <span class="form-required" title="This field is required.">*</span>
            </div>
            <div>
              <div class="form-item">
                <?php echo drupal_render($form['firmware_part']); ?>
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="label_left">
            <label>Firmware Version:</label>
          </div>
          <div class="form-item-div">
            <div class="form-item-left">
              <span class="form-required" title="This field is required.">*</span>
            </div>
            <div>
              <div class="form-item">
                <?php echo drupal_render($form['firmware_version']); ?>
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="form-item-div without_label_left">
            <div class="form-item-left">
              <label>Firmware Description:</label>
              <div>
                <div class="form-item">
                  <?php echo drupal_render($form['firmware_description']); ?>
                </div>
              </div>
            </div>
          </div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left">
            <label title="Enter '0' if there is no Part #">Firmware Status:</label>
          </div>
          <div class="form-item-div">
            <div class="form-item-left">
              <span title="This field is required." class="form-required">*</span>
            </div>
            <div>
              <div class="form-item" id="edit-field-device-firmware-version-0-value-wrapper">
                <?php echo $select_firmware_status; ?>
              </div>
            </div>
          </div>
        </td>
      </tr>     
      <tr>
        <td>
          <div class="form-item-div">
            <?php echo drupal_render($form['file_id']); ?>
            <div class="label_left"><label><?php echo t('File Name: (Browse to select a file)'); ?></label></div>
            <div class="form-item-left">
              <span title="This field is required." class="form-required">*</span>
            </div>
            <?php $upload_display = ($file_id) ? 'style="display:none"' : ''; ?>
            <?php $remove_display = ($file_id) ? '' : 'style="display:none"'; ?>
            <div id="firmware-file-div">
              <!-- upload file -->
              <div id="firmware-file-upload" <?php echo $upload_display ?>>
                <div class="form-item-left">
                  <input type="text" name="file_name" value="<?php echo $firmware['file']; ?>" readonly="readonly" style="width: 130px;" id="fw_upload_localize_path">
                  <input type="button" style="height: auto;" value="Browse" id="fw_upload_localize_but">
                  <?php echo drupal_render($form['firmware_file']); ?>
                </div>
                <div class="form-item-left">
                  <input type="button" class="form-submit" value="Upload" id="edit-filefield-upload" name="op" />
                  <div class="ahah-progress ahah-progress-throbber"><div class="throbber">&nbsp;</div></div>
                </div>
              </div>
              <!-- remove file -->
              <div id="firmware-file-remove"  <?php echo $remove_display; ?>>
                <div class="form-item-left" id="display-file-name"><?php echo $firmware['file']; ?></div>
                <div class="form-item-left" style="margin-left: 10px;">
                  <input type="button" class="form-submit" value="Remove" id="edit-filefield-remove" name="op" />
                  <div class="ahah-progress ahah-progress-throbber"><div class="throbber">&nbsp;</div></div>              
                </div>
              </div>
            </div>
            <!-- no file -->
            <div class="form-item-left" style="padding-left:22px;">
              <?php echo $no_file; ?>
            </div>
          </div>
          <div id="file-message"><?php echo t('Please check file.'); ?></div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <h4>3. Select the Hardware item from the table below to filter Hardware configuration(s)</h4>
        </td>
      </tr>
      <tr>
        <td>
          <div id="div-hardware-list">
            <?php echo $hw_list; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <h4>4. Select the Hardware configuration(s) from the table below that are compatible with the firmware</h4>
        </td>
      </tr>
      <tr>
        <td>
          <?php echo $hc_list; ?>
        </td>
      </tr>
      <tr>
        <td>
          <div id="hardware-message" style="color:red;"><br/></div>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 0px;">
          <h4>4. Select Regulatory Exception</h4>
        </td>
      </tr>
      <tr>
        <td>
          <div style="float:left">
            <?php echo $reg_excep_list; ?>
          </div>
          <div style="float:left; padding-left:20px">
            <input type="button" value="Add" class="form-submit" onclick="addRegulatoryExp()" />
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <table id="regulatory_exp_list" style="width: 40%">
            <tr>
              <th style="width: 70%">Country</th>
              <th style="width: 30%"></th>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <br/>
        </td>
      </tr>
      <tr>
        <td>
          <table width="100%" style="border: none">
            <tbody style="border: none">
              <tr>
                <td width="75%" align="right">
                  <?php if ($firmware['id']) { ?>
                    <!-- not show delete button --> 
                    <div style="display: none;">
                      <a id="edit-delete" class="secondary_submit" href="<?php echo $base_url ?>/firmware/delete?nid=<?php echo $firmware['id']; ?>&name=<?php echo $firmware['name']; ?>">Delete</a>
                    </div>
                  <?php } ?>
                </td>
                <td align="right">
                  <a href="<?php echo url('firmware/list'); ?>" id="secondary_submit">Cancel</a>
                </td>
                <td>
                  <?php echo drupal_render($form['submit']); ?>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<input type="hidden" name="device_type_name"/>
<input type="hidden" name="old_file_path" value="<?php echo $old_file_path ?>"/> 
<input type="hidden" name="device_type_list" id="device_type_list"/>
<input type="hidden" name="device_type_id_list" id="device_type_id_list"/>
<input type="hidden" value="asc" id="edit-hw-list-sort" name="hw_list_sort"/>
<input type="hidden" value="title" id="edit-hw-list-order" name="hw_list_order"/>
<input type="hidden" value="0" id="edit-hw-list-page" name="hw_list_page"/>
<input type="hidden" id="firmware_id" name="firmware_id" value="<?php echo $firmware['id'] ?>" />
<input type="hidden" id="selectedCountryStr" name="selectedCountryStr" value="<?php echo $selectedCountryStr ?>" />

<script>
  $(document).ready(function() {
    var device_type = "<?php echo check_plain($_GET['device_type']); ?>";
    $("#edit-field-device-type-nid option[value='" + device_type + "']").attr("selected", "selected");
  });
</script>



