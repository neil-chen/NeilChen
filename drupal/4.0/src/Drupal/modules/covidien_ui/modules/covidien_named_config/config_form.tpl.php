<?php
global $base_url, $user;
$default_config_name = $config['id'] ? $config ['name'] : '';
$default_version_name = $config['id'] ? $config ['version'] : '';
$default_description_name = $config['id'] ? $config ['description'] : '';
$submit_value = $config['id'] ? t('Save Changes') : t('Add New Configuration');

if ($_GET['op'] == 'clone') {
  $config['id'] = 0;
}

$clone_display = ($config['id']) ? '' : 'style="display:none;"';
$clone_display_title = ($_GET['op'] == 'clone') ? '' : 'style="display:none;"';
?>
<script type="text/javascript" src="<?php print $base_url ?>/sites/all/libraries/jquery.ui/ui/jquery.ui.all.js"></script>
<link rel="stylesheet" type="text/css" href="<?php print $base_url ?>/sites/all/libraries/jquery.ui/themes/default/ui.all.css"></link>
<style>
  #div_table_choose {
    margin: 0 0 0 20px;
  }
  #div_table_choose .hsf-configuration-list-table tr th {
    text-align: center;
  }
  #div_table_choose .hsf-configuration-list-table tr td {
    margin: 0;
    padding: 0;
    width: 33%;
    text-align: center;
    border: 0 none;
  }
  #div_table_choose .hsf-configuration-item-table {
    padding: 0;
    margin: -1px 0 -1px -1px;
    /*width: 284px;*/
  }
  #div_table_choose tr th,#div_table_choose tr td,#div_table_choose .hsf-configuration-item-table tr td {
    padding: 5px;
  }
  table.dispaly_class {
    border :0 ;
  }
  table.dispaly_class tbody{
    border-top :0 ;
  }
  table.dispaly_class td{
    border-right :0 ;
  }
  #div_regulatory_exp {
    clear: both;
  }
  #left_table_f, #left_table_s, #left_table_h {
    width: 95%;
  }
  #clone {
    float: right;
    height: 30px;
    width: 50px;
    margin-top: 5px;
  }
  /*software config*/
  #div_table_choose {
    position: relative;
    border: 0;
    height: 250px;
  }
  #div_table_choose .named-config-select-table-button table {
    height: 100px;
  }
  #div_table_choose thead {
    position: absolute;
    z-index: 20;
    height: 20px;
    border: 0;
  }
  #div_table_choose .no-result {
    margin: 0;
    padding: 0;
    display: none;
  }
  #div_table_choose th, #div_table_choose table {
    border: 0;
  }
  #div_table_choose #left_table_h tbody, #div_table_choose #right_table_h tbody {
    width: 337px;
  }
  #div_system .hsf-configuration-list-table thead {
    position: relative;
    width: 100%;
  }
  #sys_hardware_configuration thead, #sys_software_configuration thead, #sys_firmware_configuration thead {
    position: absolute;
  }
  #div_system .hsf-configuration-list-table thead:first-child {
    border-bottom: 1px solid #d1d3d4;
  }
  #sys_hardware_configuration tbody, #sys_software_configuration tbody, #sys_firmware_configuration tbody {
    position: absolute;
    top: 61px;
    border: 1px solid #d1d3d4;
    width: 282px;
    max-height: 180px;
    overflow-y: auto;
  }
  #sys_hardware_configuration tbody td:first-child, #sys_software_configuration tbody td:first-child, #sys_firmware_configuration tbody td:first-child {
    width: 20px;
  }
  #sys_hardware_configuration tbody td:nth-child(2), #sys_software_configuration tbody td:nth-child(2), #sys_firmware_configuration tbody td:nth-child(2) {
    width: 150px;
  }
  #sys_hardware_configuration tbody td:nth-child(3), #sys_software_configuration tbody td:nth-child(3), #sys_firmware_configuration tbody td:nth-child(3) {
    width: 80px;
  }
  .named-config-select-table-left-content tbody, .named-config-select-table-right tbody {
    position: absolute;
    max-height: 180px;
    overflow-y: auto;
    border: 1px solid #d1d3d4;
  }
  #div_table_choose th, #div_table_choose td  {
    padding: 5px 0 0 5px;
  }
  /*hardware config*/
  #div_table_choose #left_table_h thead, #div_table_choose #right_table_h thead {
    width: 339px;
  }
  #left_table_h thead th, #right_table_h thead th {
    padding: 10px 5px;
    border: 0;
  }
  #left_table_h tbody, #right_table_h tbody {
    top: 61px;
    overflow-y: auto;
    border: 1px solid #d1d3d4;
  }
  #left_table_h thead th:first-child, #right_table_h thead th:first-child, 
  #left_table_h thead td:first-child, #right_table_h thead td:first-child {
    width: 20px;
  }
  #left_table_h th:nth-child(2), #right_table_h th:nth-child(2), 
  #left_table_h td:nth-child(2), #right_table_h td:nth-child(2) {
    width: 120px;
  }
  #left_table_h th:nth-child(3), #right_table_h th:nth-child(3), 
  #left_table_h td:nth-child(3), #right_table_h td:nth-child(3) {
    width: 80px;
  }
  #left_table_h th:nth-child(4), #right_table_h th:nth-child(4), 
  #left_table_h td:nth-child(4), #right_table_h td:nth-child(4)  {
    width: 80px;
  }
  /*IE CSS*/
  #left_table_h th:first-child + th, #right_table_h th:first-child + th, 
  #left_table_h td:first-child + td, #right_table_h td:first-child + td {
    width: 117px\9;
  }
  #left_table_h th:first-child + th + th, #right_table_h th:first-child + th + th, 
  #left_table_h td:first-child + td + td, #right_table_h td:first-child + td + td {
    width: 80px;
  }
  #left_table_h th:first-child + th + th + th, #right_table_h th:first-child + th + th + th, 
  #left_table_h td:first-child + td + td + td, #right_table_h td:first-child + td + td + td {
    width: 80px;
  }
  /*IE CSS end*/
  /*software config*/
  #div_table_choose #left_table_s thead, #div_table_choose #right_table_s thead {
    width: 360px;
  }
  #div_table_choose #left_table_s tbody, #div_table_choose #right_table_s tbody {
    width: 358px;
    width: 360px\9;
    top: 70px;
  }
  #div_software .named-config-select-table-left, #div_software .named-config-select-table-right {
    width: 380px;
  }
  #div_software .named-config-select-table-left span, #div_hardware .named-config-select-table-left span, #div_firmware .named-config-select-table-left span {
    margin-left: 20px;
  }
  #left_table_s th:first-child, #right_table_s th:first-child, #left_table_s td:first-child, #right_table_s td:first-child {
    width: 20px;
  }
  #left_table_s th:nth-child(2), #right_table_s th:nth-child(2), #left_table_s td:nth-child(2), #right_table_s td:nth-child(2) {
    width: 50px;
  }
  #left_table_s th:nth-child(3), #right_table_s th:nth-child(3), #left_table_s td:nth-child(3), #right_table_s td:nth-child(3) {
    width: 110px;
  }
  #left_table_s th:nth-child(4), #right_table_s th:nth-child(4), #left_table_s td:nth-child(4), #right_table_s td:nth-child(4) {
    width: 55px;
  }
  #left_table_s th:nth-child(5), #right_table_s th:nth-child(5), #left_table_s td:nth-child(5), #right_table_s td:nth-child(5) {
    width: 40px;
  }
  #left_table_s th:nth-child(6), #right_table_s th:nth-child(6), #left_table_s td:nth-child(6), #right_table_s td:nth-child(6) {
    width: 60px;
  }
  /*IE CSS*/
  #left_table_s th:first-child + th, #right_table_s th:first-child + th, 
  #left_table_s td:first-child + td, #right_table_s td:first-child + td {
    width: 50px;
  }
  #left_table_s th:first-child + th + th, #right_table_s th:first-child + th + th, 
  #left_table_s td:first-child + td + td, #right_table_s td:first-child + td + td {
    width: 110px;
  }
  #left_table_s th:first-child + th + th + th, #right_table_s th:first-child + th + th + th, 
  #left_table_s td:first-child + td + td + td, #right_table_s td:first-child + td + td + td {
    width: 55px;
  }
  #left_table_s th:first-child + th + th + th + th, #right_table_s th:first-child + th + th + th + th, 
  #left_table_s td:first-child + td + td + td + td, #right_table_s td:first-child + td + td + td + td {
    width: 40px;
  }
  #left_table_s th:first-child + th + th + th + th + th, #right_table_s th:first-child + th + th + th + th + th, 
  #left_table_s td:first-child + td + td + td + td + td, #right_table_s td:first-child + td + td + td + td + td {
    width: 66px\9;
  }
  /*IE CSS end*/
  /*firmware config*/
  #div_table_choose #left_table_f thead, #div_table_choose #right_table_f thead {
    width: 339px;
  }
  #div_table_choose #left_table_f tbody, #div_table_choose #right_table_f tbody {
    width: 337px;
    top: 50px;
  }
  #left_table_f thead th, #right_table_f thead th {
    padding: 5px;
  }
  #left_table_f thead th:first-child, #right_table_f thead th:first-child, #left_table_f thead td:first-child, #right_table_f thead td:first-child {
    width: 20px;
  }
  #left_table_f th:nth-child(2), #right_table_f th:nth-child(2), #left_table_f td:nth-child(2), #right_table_f td:nth-child(2) {
    width: 120px;
  }
  #left_table_f th:nth-child(3), #right_table_f th:nth-child(3), #left_table_f td:nth-child(3), #right_table_f td:nth-child(3) {
    width: 80px;
  }
  #left_table_f th:nth-child(4), #right_table_f th:nth-child(4), #left_table_f td:nth-child(4), #right_table_f td:nth-child(4) {
    width: 80px;
  }
  /*IE CSS*/
  #left_table_f th:first-child + th, #right_table_f th:first-child + th, 
  #left_table_f td:first-child + td, #right_table_f td:first-child + td {
    width: 120px;
  }
  #left_table_f th:first-child + th + th, #right_table_f th:first-child + th + th, 
  #left_table_f td:first-child + td + td, #right_table_f td:first-child + td + td {
    width: 80px;
  }
  #left_table_f th:first-child + th + th + th, #right_table_f th:first-child + th + th + th, 
  #left_table_f td:first-child + td + td + td, #right_table_f td:first-child + td + td + td {
    width: 77px\9;
  }
  /*IE CSS end*/
  /*system config*/
  #sys_hardware_configuration {
    max-height: 400px;
    overflow-y: auto;
  }
  /* pop up class */
  #cboxOverlay {
    cursor: auto;
    display: block;
    left: 0;
    top: 0;
    opacity: 0.9;
    background: none repeat scroll 0 0 #fff;
    height: 100%;
    width: 100%;
    position: fixed;
    z-index: 9999;
    text-align: center;
  }
  #modal {
    position: absolute;
    background: gray;
    padding: 8px;
    width: 500px;
  }
  #modal-content {
    background: white;
    padding: 20px;
  }
  #modal-content li {
    background: white;
    padding: 0;
    margin-left: 70px;
    text-align: left;
  }
</style>

<form action="<?php echo $base_url ?>/named-config/save" accept-charset="UTF-8" method="post" id="node-form" enctype="multipart/form-data">
  <input type="hidden" name="id" id="config_id" value="<?php echo $config['id'] ? $config['id'] : 0; ?>" />
  <h3 <?php echo $clone_display_title; ?>>Clone name is <?php echo $default_config_name; ?> to here.</h3>
  <table class="dispaly_class">
    <tr>
      <td>
        <div>
          <table class="form-item-table-full add_new" style="margin-left: -5px;">
            <tbody>
              <tr>
                <td style="padding-left: 0px;">
                  <h4>1. Select Device Type:</h4>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="form-item-div">
                    <div class="form-item-left">
                      <span title="This field is required." class="form-required">*</span>
                    </div>
                    <div>
                      <div class="form-item" id="div_device_type">
                        <?php echo $select_device_type; ?>	
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 0px;">
                  <h4>2. Enter Information for the new Configuration:</h4>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="label_left">
                    <label>Configuration Name:</label>
                  </div>
                  <div class="form-item-div">
                    <div class="form-item-left">
                      <span title="This field is required." class="form-required">*</span>
                    </div>
                    <div>
                      <div class="form-item" id="edit-title-wrapper">
                        <input type="text" maxlength="255" name="txt_name" id="txt_name" size="60" value="<?php echo $default_config_name; ?>" class="form-text required"
                               placeholder="Enter Configuration Name" />
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr id="tr-cfg-version">
                <td>
                  <div class="label_left">
                    <label>Configuration Version Number:</label>
                  </div>
                  <div class="form-item-div">
                    <div class="form-item-left">
                      <span title="This field is required." class="form-required">*</span>
                    </div>
                    <div>
                      <div class="form-item">
                        <input type="text" name="txt_version" id="txt_version" size="60" value="<?php echo $default_version_name; ?>" class="form-text required text"
                               placeholder="Enter Configuration Version Number" />
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="label_left">
                    <label>Configuration Description:</label>
                  </div>
                  <div class="form-item-div">
                    <div class="form-item-left">
                      <span title="This field is required." class="form-required">*</span>
                    </div>
                    <div>
                      <div class="form-item">
                        <input type="text" name="txt_description" id="txt_description" size="120" value="<?php echo $default_description_name ?>" class="form-text required text" placeholder="Enter Configuration Description" />
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="label_left">
                    <label>Configuration Status:</label>
                  </div>
                  <div class="form-item-div">
                    <div class="form-item-left">
                      <span title="This field is required." class="form-required">*</span>
                    </div>
                    <div>
                      <div class="form-item">
                        <?php echo $select_config_status; ?>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr id="obsolete_section">
                <td>
                  <div class="label_left">
                    <label>Obsolete From:</label>
                  </div>
                  <div class="form-item-div">
                    <div class="form-item-left">
                      <span title="This field is required." class="form-required">*</span>
                    </div>
                    <div>
                      <div class="form-item">
                        <input type="text" name="obsolete_time" id="obsolete_time" size="10" style="width: 100px" value="<?php echo $config['obsolete_time']; ?>"
                               class="form-text required text" placeholder="Enter Date" />
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <?php
                  $warning_checked = '';
                  $warning_select_style = '';
                  if ($normal_id == $config['substatus'] || !$config['id']) {
                    $warning_select_style = ' style="display: none;" ';
                  } else {
                    $warning_checked = ' checked="checked" ';
                  }
                  ?>
                  <div class="label_left" style="margin-top: 5px;">
                    <input type="checkbox" id="is_warning" name="is_warning" value="1" <?php echo $warning_checked; ?>/> This is Warning Configuration.
                  </div>
                  <div id="warning_status" <?php echo $warning_select_style; ?>>
                    <div class="label_left">
                      <label>Configuration Warning Status:</label>
                    </div>
                    <div class="form-item-div" style="padding-left: 8px;">
                      <div>
                        <div class="form-item">
                          <?php echo $select_substatus; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 0px;">
                  <h4>3. Select Named Configuration Type:</h4>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="form-item-div">
                    <div class="form-item-left">
                      <span title="This field is required." class="form-required">*</span>
                    </div>
                    <div class="form-item" id="div_config_type">
                      <?php echo $select_config_type; ?>	
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
      <td valign="top">
        <div id="clone" <?php echo $clone_display; ?>>
          <!-- Neil hide Clone button 
          <a href="?op=clone" id="secondary_submit">Clone</a>
          -->
        </div>
        <div style="clear:both;"></div>
        <div id="showContentText" style="display:block;float:right;width:300px; height:auto; border:#ccc 1px solid; padding:10px;">
          Prerequisite for submission  <br/>
          - Fields marked with * must be filled <br/>
          - System configuration: must have a hw configuration selected. must have at least one SW or one FW configuration selected. <br/>
          - Hardware configuration: must have at least a hardware item selected <br/>
          - Software configuraiotn: must have at least a software item selected <br/>
          - Firmware configuration: must have at least a firmware item selected <br/>
        </div>
      </td>
    </tr>
  </table>
  <div style="clear:both;">
    <h4>4. Select elements for this configuration:</h4>
    <div id="div_table_choose">
      <div class="form-item-div" id="div_system">
        <?php
        if ($config['id']) {
          echo $config_table;
        }
        ?>
      </div>
      <div class="form-item-div" id="div_hardware" style="display: none;">
        <?php
        if ($config['id']) {
          echo $hardware_table;
        }
        ?>
      </div>
      <div class="form-item-div" id="div_software" style="display: none;">
        <?php
        if ($config['id']) {
          echo $software_table;
        }
        ?>
      </div>
      <div class="form-item-div" id="div_firmware" style="display: none;">
        <?php
        if ($config['id']) {
          echo $firmware_table;
        }
        ?>
      </div>
    </div>
  </div>
  <div id="div_regulatory_exp">
    <table class="form-item-table-full add_new" style="margin-left: -5px;">
      <tbody>
        <tr>
          <td style="padding-left: 0px;">
            <h4>5. Display Regulatory Exclusion</h4>
          </td>
        </tr>
        <tr>
          <td>
            <table id="regulatory_exp_list" style="width: 60%">
              <thead>
                <tr>
                  <th class="available_table_head" style="width: 40%">Country</th>
                  <th class="available_table_head" style="width: 60%">Excluded From</th>
                </tr>
              </thead>
              <tbody>
                <?php //echo $selectedCountryStr;      ?>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="form-item-div" id="div_button" style="clear: both; padding: 10px 10px 0 0;">
    <div class="form-item-right" style="width: 300px;">
      <div style="float: left;">
        <a id="secondary_submit" href="<?php echo $base_url ?>/named-config/list">Cancel</a>
      </div>
      <div style="float: right;">
        <input id="btn_submit" type="submit" value="<?php echo $submit_value; ?>" class="non_active_blue" disabled />
      </div>
    </div>
  </div>
  <input type="hidden" id="selectedCountryStr" name="selectedCountryStr" value="<?php echo $selectedCountryStr ?>" />
</form>
