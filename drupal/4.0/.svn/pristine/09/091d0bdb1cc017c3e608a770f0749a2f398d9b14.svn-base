<?php
global $base_url, $user;
?>

<style>
  table tr td {
    border: 0px;
  }
  input.form-autocomplete {
    background-image: url(../../misc/throbber.gif);
    background-repeat: no-repeat;
    background-position: 100% 2px; /* LTR */
  }
  input.autothrobbing {
    background-image: url(../../misc/throbber.gif);
    background-repeat: no-repeat;
    background-position: 100% -18px; /* LTR */
  }

  div.firmware_search_wraper div input[type="text"]
  {
    color : #696B73; 
    font-size : 11px;
    border: 1px solid #A8A8A7;
    padding : 2px;
    -webkit-border-radius:10px;
    -moz-border-radius:10px;
    -ms-border-radius:10px;
    border-radius:10px;
    width:300px;
  }
</style>

<table class="form-item-table-full" style="margin-bottom: 20px;">
  <tr>
    <td>
      <div class="form-item-left">
        <h4><?php echo t('Firmware Catalog'); ?></h4>
      </div>
      <div class="form-item-div">
        <div class="form-item-right">
          <?php if (is_array($user->devices_access['firmware'])) { ?>
            <?php if (in_array('edit', $user->devices_access['firmware'])) { ?>
              <input type="button" class="form-submit secondary_submit"  onclick="addFirmware();"  value="Add New Firmware" id="edit-add-new"/>			
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-item-div">
        <!-- select device type -->
        <div class="form-item-left"><label for="edit-field-device-type-nid">Select Device Type:</label></div>
        <div class="form-item-left" style="padding-left: 5px;">
          <?php echo $select_device; ?>
        </div>
      </div>
      <div style="clear: both;"></div>
      <!-- search name input -->
      <div class="form-item-div" style="padding-top: 15px;">
        <div class="form-item-left"  style="padding-left: 5px;">
          <div class="firmware_search_wraper"  style="padding-top: 3px;">
            <div class="form-item">
              <input type="text" name="search_name" class="form-autocomplete" onkeyup="autoFinish();" id="txt_search_name" autocomplete="OFF" title="Search - Enter Firmware Name" value="<?php echo $search_name; ?>" />
              <input type="hidden" disabled="disabled" value="<?php echo $base_url . '/firmware/autocomplete' ?>" id="edit-title-autocomplete" class="autocomplete autocomplete-processed">
              <input type="hidden" value="" id="edit-filter-hidden-hwverson" name="filter_hidden_hwverson">
              <div id="autocomplete" style="display: none;width: 300px"  onmouseover="this.style.display = 'block'" onmouseout="this.style.display = 'none'" >
                <ul id="tipText"></ul>
              </div>
            </div>
          </div>
        </div>
        <!-- search name button -->
        <div class="form-item-left" style="padding-left: 5px;">
          <div class="views-exposed-widget views-submit-button">
            <input type="button" class="form-submit" value="Filter" id="edit-submit-Hardwarelist"  onclick="searchFirmwareSubmit()" />
          </div>
        </div>
      </div>

    </td>
  </tr>
</table>
<div id="firmware_list_tbl">
  <?php
  //print resoult table list
  echo $result_table;
  ?>
</div>

<script>
  $(document).ready(function() {
<?php if (is_array($user->devices_access['firmware'])) { ?>
  <?php if (!in_array('edit', $user->devices_access['firmware'])) { ?>
        hide_edit_link($("#tbody_result"));
  <?php } ?>
<?php } ?>
    firmware_filter_device_type("sel_device_type");
    $(".config last").addClass("active");
    $(".config").find("a").each(function(index, value) {
      $(".config").addClass("active");
    });

    $("#sel_device_type").bind("change", function() {
      $.ajax({
        type: "POST",
        url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
        data: {value: $('#sel_device_type').val()},
        success: function(ret) {
        }
      });
    });
  });

  function addFirmware() {
    window.location = '<?php echo $base_url . '/firmware/add'; ?>';
  }

  function autoFinish() {
    var url = "<?php echo $base_url . '/firmware/autocomplete' ?>";
    var key = $("#txt_search_name").val();
    if (key.length > 2) {
      $("#txt_search_name").attr("class", "autothrobbing");
      $.post(url, {"keyword": key}, function(data, status) {
        if (status == "success") {
          $("#txt_search_name").attr("class", "form-autocomplete");
          var tipText = eval("(" + data + ")");
          var tipHtml = "";
          if (tipText.length <= 0) {
            $("#autocomplete").hide();
            return;
          }
          else
            $("#autocomplete").show();
          for (var key in tipText) {
            tipHtml += "<li>" + key + "</li>";
          }
          var wid = parseInt($("#txt_search_name").width());
          var height = parseInt($("#txt_search_name").scrollHeight);

          $("#tipText").html(tipHtml).width(wid);
          $("#autocomplete").css("position", "absolute");

          $(function() {  //5 
            $("#tipText li").mouseover(function() {
              $(this).css("background", "#D1D3D4").siblings("li").css("background", "white");
            });
            $("#tipText li").click(function() {
              $("#autocomplete").hide();
              $("#txt_search_name").val($(this).text());
            });
          })
        } else {
          alert("AJAX error ");
        }
      });
    }

  }


  function searchFirmwareSubmit() {
    var url = "<?php echo $base_url . '/firmware/list' ?>";

    var search_name = $("#txt_search_name").val();
    if (search_name != '') {
      url += '&search_name=' + search_name;
    }
    window.location = url;
  }

  function fix_select(select_id, select_array, default_value) {
    $("#" + select_id).empty();
    $.each(select_array, function(index, value) {
      if (index == default_value) {
        $("#" + select_id)[0].options.add(new Option(value, index, false, true));
      } else {
        $("#" + select_id)[0].options.add(new Option(value, index, false, false));
      }
    });
  }

  function firmware_filter_device_type(id) {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/firmware/devicetype",
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
        });
        //GATEWAY-1966 filter device type and product line 
        no_display_device_type($("#" + id));
      }
    });
  }

</script>