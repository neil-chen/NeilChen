<?php
global $base_url, $user;
?>

<style>
  .feature_named_config_table td {
    border: 1px solid #D1D3D4;
  }
</style>


<input type="hidden" name="nid" value="<?php echo $feature['nid'] ?>" /> 
<input type="hidden" name="device_type_name"/>
<input type="hidden" name="device_type_list"    id="device_type_list" />
<input type="hidden" name="device_type_id_list" id="device_type_id_list"/>
<input type="hidden" name="hid_product_line"    id="hid_product_line"/>
<input type="hidden" name="hid_component_nid" id="hid_component_nid" value="<?php echo $feature['component_nid'] ?>"/>

<div>
  <table style="width: 100%" class="form-item-table-full add_new">
    <tbody>
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
              <?php echo drupal_render($form['select_device_type']); ?>
            </div>
          </div>
        </td>
      </tr>


      <tr>
        <td style="padding-left: 0px;">
          <h4>2. Enter Information about the new Feature</h4>
        </td>
      </tr>

      <tr>
        <td>
          <div class="label_left">
            <label>Feature Name:</label>
          </div>
          <div class="form-item-div">
            <div class="form-item-left">
              <span class="form-required" title="This field is required.">*</span>
            </div>
            <div class="form-item" id="edit-title-wrapper">
              <?php echo drupal_render($form['feature_name']); ?>
            </div>
          </div>
        </td>
      </tr>

      <tr>
        <td>
          <div class="form-item-div without_label_left">
            <div class="form-item-left">
              <label>Feature Description:</label>
              <div>
                <div class="form-item">
                  <?php echo drupal_render($form['feature_description']); ?>
                </div>
              </div>
            </div>
          </div>
        </td>
      </tr>


      <tr>
        <td style="padding-left: 0px;">
          <!-- h4>3. Associate to Catalog Item</h4 -->
          <h4>3. Select the Software Item from the table below</h4>
        </td>
      </tr>

      <tr style="display: none">
        <td>
          <input type="checkbox" name="conf_type[]" value="software" onclick="changeDeviceType()" />&nbsp;&nbsp;software compentent&nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="conf_type[]" value="hardware" onclick="changeDeviceType()" />&nbsp;&nbsp;hardware compentent&nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="conf_type[]" value="firmware" onclick="changeDeviceType()" />&nbsp;&nbsp;firmware compentent&nbsp;&nbsp;&nbsp;
        </td>
      </tr>


      <tr>
        <td>
          <div id="div_system_software" style="overflow: auto; max-height: 400px; float: left; position: relative; width: 100%">
            <?php echo $software_table ?>
            <br/>
          </div>
        </td>
      </tr>



      <tr>
        <td>
          <div id="div_system_hardware" style="overflow: auto; max-height: 400px; float: left; position: relative; width: 100%">
            <?php echo $hardware_table ?>
            <br/>
          </div>
        </td>
      </tr>

      <tr>
        <td>
          <div id="div_system_firmware" style="overflow: auto; max-height: 400px; float: left; position: relative; width: 100%">
            <?php echo $firmware_table ?>
            <br/>
          </div>
        </td>
      </tr>




      <tr>
        <td colspan="3" style="padding-left : 0px">
          <table style="border:none;">
            <tbody style="border:none">
              <tr>

                <?php if ($feature['nid']) { ?>
                  <td width="25%" align="left"  style="border-right: 0px;">
                    <?php echo drupal_render($form['delete_feature']); ?>
                  </td>
                  <td width="30%" align="left" style="border-right: 0px;">
                    <a id="secondary_submit" href="<?php echo $base_url ?>/feature_license/admin/<?php echo $feature['nid']; ?>/regulatory_approval/ ">Regulatory Exclusions</a>
                  </td>

                <?php } ?>

                <td width="25%" align="right" style="border-right: 0px;">
                  <a href="<?php echo $base_url ?>/feature_license/list" id="secondary_submit">Cancel</a>
                </td>
                <td width="20%" style="border-right: 0px;" >
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




<script>

  $(document).ready(function() {
    // 	$("#sel_device_type").bind("change",changeDeviceType);
    /*     $("#sel_device_type").bind("change",function(){
     var hid_product_line = $("#global_product_line").val();
     $("#hid_product_line").val(hid_product_line);
     $("#feature-license-form").attr("action",window.location.href);
     $("#feature-license-form").submit();
     }); */

    $('#global_product_line').attr("disabled", true);


    $("input[type=checkbox][name^='chk_component_nid']").bind("change", validateComplete);
    $("#feature_name").bind("keyup", validateComplete);


    $("#global_product_line").unbind();
    $("#global_product_line").bind("change", changeDeviceType);
    //	$("#global_product_line").trigger("change");
    //	$("#global_product_line")[0].onchange=changeProductLine;
    var product_line = "<?php echo check_plain($_POST['hid_product_line']); ?>";
    $("#global_product_line option[value=" + product_line + "]").attr("selected", "selected");

    default_conf_type_check();
    checked_component();
    validateComplete();
  });

  function default_conf_type_check() {
    $("input[type=checkbox][name='conf_type[]']").val(["<?php echo $conf_type ?>"]);
  }

  function changeDeviceType() {
    var hid_product_line = $("#global_product_line").val();
    $("#hid_product_line").val(hid_product_line);
    $("#feature-license-form").attr("action", window.location.href);
    $("#feature-license-form").submit();
  }

  function validateComplete() {
    var flag = true;

    if ($('#select_device_type').val() <= 0) {
      flag = false;
    }

    if ($("#feature_name").val().replace(/\s/g, "") == "") {
      $("#feature_name").focus();
      flag = false;
    }

    var length = $("input[type=checkbox][name^='chk_component_nid']:checked").length;

    if (length < 1) {
      flag = false;
    }

    if (flag && $('#select_device_type').val() > 0) {
      enableSubmit();
    } else {
      disableSubmit();
    }

  }

  function checked_component() {
    var chk_obj = $("input[name^='chk_component_nid']:checkbox");

    var component_nid_array = $("#hid_component_nid").val().split(",");

    for (i = 0; i < chk_obj.length; i++) {
      if ($.inArray($(chk_obj[i]).val(), component_nid_array) > -1) {
        chk_obj[i].checked = true;
      } else {
        chk_obj[i].checked = false;
      }
    }
  }

  function save_feature() {
    var device_type = $('#select_device_type').val();
    var config = $("input:checkbox[name^='chk_component_nid']:checked").length;

    if (device_type > 0) {
      if (config > 0) {
        return true;
      } else {
        alert("No Catalog Item selected !");
        return false;
      }
    } else {
      alert("Please select Device Type ");
      return false;
    }

  }

  function delete_feature() {
    if (confirm("Are you sure to delete this feature ? ")) {
      $("#feature-license-form").attr("action", "<?php echo $base_url . '/feature_license/delete'; ?>");
      return true;
    } else {
      return false;
    }
  }


</script>