<?php
global $base_url;
global $wordwraplength, $wordwrapchar;
$topic = filter_xss($_GET['topic']);
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#hw_sw_table tr:first').before('<tr><th colspan="3" style="text-align:center"><?php echo t('Hardware'); ?></th><th colspan="4" style="text-align:center"><?php echo t('Software'); ?></th></tr>');
    $('#hw_sw_fw_table tr:first').before('<tr><th colspan="3" style="text-align:center"><?php echo t('Hardware'); ?></th><th colspan="2" style="text-align:center"><?php echo t('Software'); ?></th><th colspan="2" style="text-align:center"><?php echo t('Firmware'); ?></th></tr>');
	//As in HW/SW Configuration tab, colorbox functin will impact ajax callback function. Temporally override it.
    if (!jQuery.fn.colorbox){
        jQuery.fn.colorbox = function(){}
    }
    $(".iframe").colorbox({
      iframe: true, width: "500px", height: "500px", scrolling: false, onClosed: function() {
        parent.location.reload();
      }, onLoad: function() {
        $('#cboxClose').remove();
      }
    });
    $(".iframe2").colorbox({
      iframe: true, width: "800px", height: "700px", scrolling: true, onLoad: function() {
        $('#cboxClose').remove();
      }
    });
    bindPreview2DeviceComp();
  });

  function bindPreview2DeviceComp() {
    $("#hw_sw_fw_table tbody td").find("span").each(function() {
      var comp_id = $(this).attr("comp_id");
      $(this).mouseover(function() {
        device_component_preview(comp_id, $(this));
      });
      $(this).mouseout(function() {
        $('#div_device_config_preview').hide();
      });
      $('#div_device_config_preview').mouseout(function() {
        $('#div_device_config_preview').hide();
      });
    });
  }

  function device_component_preview(comp_id, event) {
    //alert("ajax start");
    $("#div_device_config_preview").css("left", event.offset().left);
    $("#div_device_config_preview").css("top", event.offset().top + 20);
    var url = '<?php echo $base_url; ?>/covidien/device/component/view';
    var data = {'comp_id':comp_id,'device_id':'<?php echo $device_id; ?>'};
    $.get(url, data, function(response) {
      response = Drupal.parseJson(response);
      if (response.status == 'success') {
        $("#div_device_config_preview").html(response.data);
        $("#div_device_config_preview").show();
      }
    });
  }
</script>
<table class="form-item-table-full" style="width:700px">
  <tr>
    <td width="120px" valign="top"><label><?php echo t('Device Type:'); ?></label></td>
    <td width="100px" valign="top"><label><b><?php echo $device_name; ?></b></label></td>
    <td width="150px" valign="top"><label><?php echo t('Device Serial Number:'); ?></label></td>
    <td width="150px" valign="top"><label><b><?php echo wordwrap($sno, $wordwraplength, $wordwrapchar, TRUE); ?></b></label></td>
    <td width="50px" valign="top"><label><?php echo t('Country:'); ?></label></td>
    <td width="130px" valign="top"><label><b><?php echo $country; ?></b></label></td>	</tr>
  <tr>
    <td valign="top"><label><?php echo t('Customer Name:'); ?></label></label></td>
    <td valign="top"><label><b><?php echo wordwrap($cus_name, $wordwraplength, $wordwrapchar, TRUE); ?></b></label></td>
    <td valign="top"><label><?php echo t('Customer Account Number:'); ?></label></td>
    <td valign="top"><label><b><?php echo $facility; ?></b></label></td>
    <td valign="top"><label><?php echo t('Region:'); ?></label></td>
    <td valign="top"><label><b><?php echo $region; ?></b></label></td>
  </tr>
  <tr>
    <td valign="top"><label><?php echo t('Maintenance Expires:'); ?></label></td>
    <td valign="top"><label><b><?php echo $maintanance_date; ?></b></label></td>
    <td valign="top"><label><?php echo t('Location:'); ?></label></td>
    <td valign="top" colspan="3"><label><b><?php echo $location; ?></b></label></td>
  </tr>
  <?php if (!empty($device_facility)): ?>	
    <tr>
      <td valign="top"><label><?php echo t('User Entered Facility:'); ?></label></td>
      <td valign="top" colspan="5"><label><b><?php echo $device_facility; ?></b></label></td>
    </tr>
  <?php endif; ?>	
  <?php if (!empty($device_address)): ?>	
    <tr>
      <td valign="top"><label><?php echo t('User Entered Facility Address:'); ?></label></td>
      <td valign="middle" colspan="5"><label><b><?php echo $device_address; ?></b></label></td>
    </tr>
  <?php endif; ?>	
</table>
<div id="tabs_container" class="tabs_wrapper">
  <ul id="uitabs">
    <li <?php
    if ($topic == "") {
      echo 'class="active"';
    }
    ?>><a href="<?php echo $base_url; ?>/covidien/device/<?php echo $device_id; ?>/<?php echo $sno; ?>"><?php echo t('Service History'); ?></a></li>
    <li <?php
    if ($topic == "config") {
      echo 'class="active"';
    }
    ?>><a class="icon_accept" href="<?php echo $base_url; ?>/covidien/device/<?php echo $device_id; ?>/<?php echo $sno; ?>?topic=config"><?php echo t('HW/SW Configuration'); ?></a></li>
    <li <?php
    if ($topic == "discrepancy") {
      echo 'class="active"';
    }
    ?>><a class="icon_accept" href="<?php echo $base_url; ?>/covidien/device/<?php echo $device_id; ?>/<?php echo $sno; ?>?topic=discrepancy"><?php echo t('Component Discrepancy List'); ?></a></li>
    <li <?php
    if ($topic == "log_viewer") {
      echo 'class="active"';
    }
    ?>><a class="icon_accept" href="<?php echo $base_url; ?>/covidien/device/<?php echo $device_id; ?>/<?php echo $sno; ?>?topic=log_viewer"><?php echo t('Log Viewer'); ?></a></li>
    <!-- hide feature list
    <li <?php
    if ($topic == "feature_list") {
      echo 'class="active"';
    }
    ?>><a class="icon_accept" href="<?php echo $base_url; ?>/covidien/device/<?php echo $device_id; ?>/<?php echo $sno; ?>?topic=feature_list"><?php echo t('Feature List'); ?></a></li>
    <li <?php
    if ($topic == "last_known_features_list") {
      echo 'class="active"';
    }
    ?>><a class="icon_accept" href="<?php echo $base_url; ?>/covidien/device/<?php echo $device_id; ?>/<?php echo $sno; ?>?topic=last_known_features_list"><?php echo t('Last Known Features List'); ?></a></li>
    -->
  </ul>
</div>
<div  class="device_tabs">
  <div id="tab1" class="tab_content" <?php
  if ($topic == "") {
    echo 'style="display: block;"';
  }
  ?>>
         <?php echo $device_history; ?>
  </div>
  <div id="tab2" class="tab_content" <?php
  if ($topic == "config") {
    echo 'style="display: block;"';
  }
  ?>>
         <?php
         echo $messages;
         if ($device_type_version >= '3.0') {
           ?>
      <!-- <div class="table_title"><?php echo t('The device applied Named System Configuration is : '); ?><b style="color:red;"><?php echo $applied_config['name']; ?></b></div>  -->
      <?php
    }
    ?>
    <div class="table_title"><?php echo t('Current Hardware/Software components on this device:'); ?></div>
    <?php echo $device_config; ?>
  </div>
  <div id="tab3" class="tab_content" <?php
  if ($topic == "discrepancy") {
    echo 'style="display: block;"';
  }
  ?>>
         <?php
         if ($topic == "discrepancy") {
           echo $discrepancy;
         }
         ?>
  </div>
  <div id="tab4" class="tab_content" <?php
  if ($topic == "log_viewer") {
    echo 'style="display: block;"';
  }
  ?>>
         <?php
         if ($topic == "log_viewer") {
           echo $log_viewer_tab;
         }
         ?>
  </div>
  <div id="tab5" class="tab_content" <?php
  if ($topic == "feature_list") {
    echo 'style="display: block;"';
  }
  ?>>
         <?php
         if ($topic == "feature_list") {
           echo $feature_list;
         }
         ?>
  </div>
  <div id="tab6" class="tab_content" <?php
  if ($topic == "last_known_features_list") {
    echo 'style="display: block;"';
  }
  ?>>
         <?php
         if ($topic == "last_known_features_list") {
           echo $last_known_features_list;
         }
         ?>
  </div>
</div>
<div id="div_device_config_preview" class="ajaxtooltip" style="border: 1px solid silver; position: absolute; height: auto; width: 40%;">
</div>
<div style="margin-top:50px; clear:both" align="right">
  <a id="secondary_submit" href="<?php echo $base_url; ?>/covidien/devices">
    <?php echo t('Find Another Device'); ?>
  </a>
</div>