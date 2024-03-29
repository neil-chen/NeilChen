<?php
global $user;
global $base_url;
?>

<div id="div_list">
  <table class="form-item-table-full" style="margin-bottom: 20px;">
    <tr>
      <td>
        <div class="form-item-div">
          <div class="form-item-left">
            <h4><?php echo t('Configuration Management'); ?></h4>
            <p class="discrips"><?php echo t('Named device configurations are listed below.'); ?></p>
          </div>
          <div class="form-item-right">
            <?php if (in_array('edit', $user->devices_access['configuration'])) { ?>
              <a id="secondary_submit" href="<?php echo $base_url . '/named-config/add' ?>">Add New Configuration</a>
            <?php } ?>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 30px;">
        <div class="form-item-div">
          <div class="form-item-left" style="width:135px;">
            <label><?php echo t('Select Device Type:'); ?></label>
          </div>
          <div class="form-item-left">
            <?php echo $select_device_type; ?>
          </div>
          <div style="padding-left : 20px; width : 300px" class="form-item-left">
            <div class="views-exposed-widget views-submit-button">
              <input type="submit" class="form-submit" onclick="selectNameConfByDeviceType()" value="Filter" id="edit-submit-Configlist">
            </div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 30px;">
        <div class="form-item-div">
          <div class="form-item-left" style="width:135px;">
            <label><?php echo t('Select Configuration Type:'); ?></label>
          </div>
          <div class="form-item-left">
            <?php echo $select_config_type; ?>	
          </div>
        </div>
      </td>
    </tr>

  </table>

  <div id="configuration_list">
    <?php echo $result_table; ?>
  </div>

  <div id="div_preview" class="ajaxtooltip" style="border: 1px solid silver; position: absolute; height: auto; width: 840px;">
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function() {
    nc_filter_device_type('edit-field-device-type-nid');
    bindPreview2NC();

    $('#edit-field-device-type-nid').change(function() {
      $.ajax({
        type: "POST",
        url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
        data: {value: $('#edit-field-device-type-nid').val()},
        success: function(res) {
        }
      });
    });

    //GATEWAY-2841 Add New Configuration page should default to whatever type of configuration was selected in previous page
    $('#config_type').change(function() {
      var type_id = $(this).val();
      if (type_id) {
        $.get(Drupal.settings.basePath + 'named-config/global-config-type/ajax/' + type_id, function(response) {
          //console.log(response);
        });
      }
    });

  });

  function selectNameConfByDeviceType(url) {
    if (url == undefined) {
      var url = "<?php echo $base_url . '/named-config/ajax/get/list' ?>";
    }
    var config_type = $('#config_type').val();
    var device_type_id = $('#edit-field-device-type-nid').val();
    var product_line = $("#global_product_line").val();

    data = {'product_line': product_line, 'device_type_id': device_type_id, 'config_type': config_type};
    $.get(url, data, function(response) {
      response = Drupal.parseJson(response);
      if (response.status == 'success') {
        $('#configuration_list').html(response.data);
        //bind pager
        $('#configuration_list .item-list .pager li').each(function() {
          var url = $(this).find('a').attr('href');
          $(this).find('a').attr('href', '');
          if (url != undefined && url != '') {
            $(this).bind("click", function() {
              return selectNameConfByDeviceType(url);
            });
          }
        });
        //bind order
        $('#configuration_list table th').each(function() {
          var url = $(this).find('a').attr('href');
          $(this).find('a').attr('href', '');
          if (url != undefined && url != '') {
            $(this).bind("click", function() {
              return selectNameConfByDeviceType(url);
            });
          }
        });
        //bing preview 
        bindPreview2NC();
      }
    });
    //update admin devices url add device type filter
    update_device_url_by_device_type();
    return false;
  }

  function bindPreview2NC() {
    $("#configuration_list tbody td").find("a").each(function() {
      var config_id = $(this).attr('configid');
      $(this).mouseover(function() {
        config_preview(config_id, $(this));
      });
      $(this).mouseout(function() {
        $('#div_preview').hide();
      });
      $('#div_preview').mouseout(function() {
        $('#div_preview').hide();
      });
    });
  }

  function config_preview(id, event) {
    var url = '<?php echo $base_url; ?>/named-config/preview';
    var data = {'id': id};
    $("#div_preview").css("left", event.offset().left);
    $("#div_preview").css("top", event.offset().top + 20);
    $.get(url, data, function(response) {
      response = Drupal.parseJson(response);
      if (response.status == 'success') {
        $("#div_preview").html(response.data);
        $("#div_preview").show();
      }
    });
    return false;
  }

  function nc_filter_device_type(id) {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "named-config/filter/devicetype",
      data: {"product_line": $('#global_product_line').val()},
      dataType: 'json',
      success: function(response) {
        var sel_arr = new Array();

        $("#" + id + " option").each(function() {
          var option_val = $(this).val();
          var flag = 0;
          for (var i = 0; i < response.length; i++) {
            if (response[i] == option_val) {
              flag = 1;
            }
          }
          if (flag == 0) {
            $("#" + id + " option[value='" + option_val + "']").remove();
          }
          ;
        });
        //GATEWAY-1966 filter device type and product line 
        no_display_device_type($("#" + id));
      }
    });
  }
</script>