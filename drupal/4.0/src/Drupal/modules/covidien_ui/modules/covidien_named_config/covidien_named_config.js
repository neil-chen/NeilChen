//document ready 
$(document).ready(function() {
  $('#global_product_line').attr('disabled', 'disabled');
  $('#txt_version').val('1');
  $('#tr-cfg-version').hide();
  $('#obsolete_section').hide();
  //bind input date popup
  $('#obsolete_time').datepicker();

  $('#config_status').change(function() {
    var message1 = 'If you change to In Production, will can not change back to Limited Release.';
    var message2 = 'If you change to Obsolete, will can not change back to In Production.';
    // when regulatory exception has value, select 'obsolete' will confirm
    // the choice.
    if ($.trim($('#config_status option:selected').text()) == 'Obsolete') {
      if ($('#regulatory_exp_list tr').size() > 1) {
        var flg = confirm("This configuration has regulatory excepions, are you sure to obsolete this configuration!");
        if (!flg) {
          $(this).val($(this).val() - 1);
        }
      }
    }
    if ($.trim($('#config_status option:selected').text()) == 'In Production') {
      confirm(message1);
    }
    if ($.trim($('#config_status option:selected').text()) == 'Obsolete') {
      var currentDate = new Date();
      $('#obsolete_time').datepicker("setDate", currentDate);
      confirm(message2);
    }
    //validateComplete
    validateComplete();
    //update system table
    get_config_table_list_by_device_type();

    //GATEWAY-2934 check parent status
    check_parent_status($(this), $('#config_id').val());

  });

  if ($('#config_id').val() == '' || $('#config_id').val() == 0) {
    nc_filter_device_type('edit-field-device-type-nid');
    //update status 
    update_config_status_by_type();
    //GATEWAY-3149 remove check warning configuration on edit page
    show_hide_warning_configuration();
    //GATEWAY-2655 check warning status on add page
    show_table_list_by_warning_status();
    show_warning_status_option_by_is_warning();
  } else {
    //disable all input 
    $('input:text').attr('disabled', true);
    $('input:checkbox').attr('disabled', true);
    $('input:radio').attr('disabled', true);
    $('input:button').attr('disabled', true);
    $('select').attr('disabled', true);
    //enable input
    $('#config_id').attr('disabled', false);
    $('#config_status').attr('disabled', false);
    $('#obsolete_time').attr('disabled', false);
  }

  $("#txt_name").bind("keyup", validateComplete);
  $("#txt_version").bind("keyup", validateComplete);
  $("#txt_description").bind("keyup", validateComplete);
  $("#div_table_choose").find("input:checkbox").bind("change", validateComplete);
  validateComplete();

  // show warning status item
  $("#select_substatus").change(function() {
    show_hide_warning_configuration();
    show_table_list_by_warning_status();
    validateComplete();
  });

  //change box
  if ($.browser.msie) {
    $('input:checkbox').click(function() {
      try {
        this.blur();
        this.focus();
      } catch (e) {
        return false;
      }
    });
  }

  //is warning checkbox change event
  $('#is_warning').change(function() {
    show_warning_status_option_by_is_warning();
    //hide warning 
    show_hide_warning_configuration();
    show_table_list_by_warning_status();
    validateComplete();
  });
  //warning status checkbox end

  $('#edit-field-device-type-nid').change(function(e) {
    //update default device type 
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
      data: {value: $('#edit-field-device-type-nid').val()},
      success: function(res) {
        var device_type_id = $('#edit-field-device-type-nid').val();
        var product_line = $('#global_product_line').val();
        var config_type = $("#config_type").val();
        var params = {
          'device_type_id': device_type_id,
          'product_line': product_line,
          'config_type': config_type
        };
        var str = $.param(params);
        // get product_line device_type_id
      }
    });
    //update system table
    get_config_table_list_by_device_type();
  });

  // bind function to system configuration to show regulatory exceptions from software cfg and firmware cfg.
  $('#sys_software_configuration :checkbox').bind("click", {"type": "software_cfg"}, displayRegulatoryExp);
  $('#sys_firmware_configuration :checkbox').bind("click", {"type": "firmware_cfg"}, displayRegulatoryExp);
  if ($('#config_id').val() != '' && $('#config_id').val() != '0') {
    $('#sys_software_configuration :checked').click();
    $('#sys_firmware_configuration :checked').click();
  }

  //bing change on system configuration only select one 
  sys_config_only_check_one();

  // check required
  sw_list_table_radio();

  choose_display_type();
  move_table_item_right('h');
  move_table_item_right('f');
  move_table_item_right('s');

  // submit before
  $('input[type="submit"]').click(function(event) {
    save_change_config(event);
  });

  //GATEWAY-2674
  $('form').submit(function() {
    $('form #btn_submit').hide();
  });

  //GATEWAY-2802 update system table
  get_config_table_list_by_device_type();

  //GATEWAY-2841 Add New Configuration page should default to whatever type of configuration was selected in previous page
  $('#config_type').change(function() {
    update_config_status_by_type();
    choose_display_type();
    validateComplete();
    get_config_table_list_by_device_type();

    var type_id = $(this).val();
    if (type_id) {
      $.get(Drupal.settings.basePath + 'named-config/global-config-type/ajax/' + type_id, function(response) {
        //console.log(response);
      });
    }
  });

});
//document ready end

function choose_display_type() {
  var div_list = new Array("#div_system", "#div_hardware", "#div_firmware", "#div_software");
  // hide all choose div
  for (var i = 0; i < div_list.length; i++) {
    $(div_list[i]).hide();
  }
  // show choose div
  switch ($("#config_type").find("option:selected").text()) {
    case 'Named System Configuration':
      $("#config_status span option[value='0']").unwrap();
      $("#div_system").show();
      $('#div_regulatory_exp').show();
      break;
    case 'Named Hardware Configuration':
      if ($("#config_status").val() == '0') {
        $("#config_status option[value='0']").wrap("<span>");
        $("#config_status").val('1');
      } else {
        $("#config_status option[value='0']").wrap("<span>");
      }
      $("#div_hardware").show();
      $('#div_regulatory_exp').hide();
      break;
    case 'Named Software Configuration':
      if ($("#config_status").val() == '0') {
        $("#config_status option[value='0']").wrap("<span>");
        $("#config_status").val('1');
      } else {
        $("#config_status option[value='0']").wrap("<span>");
      }
      $("#div_software").show();
      $('#div_regulatory_exp').show();
      break;
    case 'Named Firmware Configuration':
      if ($("#config_status").val() == '0') {
        $("#config_status option[value='0']").wrap("<span>");
        $("#config_status").val('1');
      } else {
        $("#config_status option[value='0']").wrap("<span>");
      }
      $("#div_firmware").show();
      $('#div_regulatory_exp').show();
      break;
  }
}

function focusClear(comp, initValue) {
  if ($(comp).val() == initValue) {
    $(comp).val('');
  } else {
    filterXSS(comp);
  }
}

function blurFill(comp, initVaule) {
  if ($(comp).val() == '') {
    $(comp).val(initVaule);
  } else {
    filterXSS(comp);
  }
}

function validateComplete() {
  if ($("#txt_name").val() && $("#txt_description").val() && $('#edit-field-device-type-nid').val() && $('#config_type').val() && validate_checklist()) {
    enableSubmit();
  } else {
    disableSubmit();
  }
}

function disableSubmit() {
  $("#btn_submit").removeClass("form-submit");
  $("#btn_submit").addClass("non_active_blue");
  $("#btn_submit").attr("disabled", true);
}

function enableSubmit() {
  $("#btn_submit").removeClass("non_active_blue");
  $("#btn_submit").addClass("form-submit");
  $("#btn_submit").removeAttr("disabled");
}

function validate_checklist() {
  //GATEWAY-2655 if edit page or is warning config, not check list 
  if ($('#config_id').val() != 0 || $('#is_warning:checked').val()) {
    return true;
  }
  var valid_rel = false;
  switch ($("#config_type").find("option:selected").text()) {
    case 'Named System Configuration':
      var hwc_check = 0;
      var swc_check = 0;
      var fwc_check = 0;
      if ($('.hsf-configuration-item-table').eq(0).find("input:checked").length == 1) {
        hwc_check = 1;
      } else {
        hwc_check = 0;
      }
      if ($('.hsf-configuration-item-table').eq(1).find("input:checked").length == 1) {
        swc_check = 1;
      } else {
        swc_check = 0;
      }
      if ($('.hsf-configuration-item-table').eq(2).find("input:checked").length == 1) {
        fwc_check = 1;
      } else {
        fwc_check = 0;
      }
      if (hwc_check == 1 && (swc_check == 1 || fwc_check == 1)) {
        valid_rel = true;
      }
      break;
    case 'Named Hardware Configuration':
      if ($("#right_table_h").find("input[type='checkbox']").length > 0) {
        valid_rel = true;
      }
      break;
    case 'Named Software Configuration':
      if ($("#right_table_s").find("input[type='checkbox']").length > 0 && $("#right_table_s").find("input[type='radio']:checked").length > 0) {
        valid_rel = true;
      }
      break;
    case 'Named Firmware Configuration':
      if ($("#right_table_f").find("input[type='checkbox']").length > 0) {
        valid_rel = true;
      }
      break;
  }
  if ($.trim($("#config_status option:selected").text()) == "Obsolete") {
    if ($("#obsolete_time").val() != "") {
      valid_rel = true;
    } else {
      valid_rel = false;
    }
  }
  return valid_rel;
}

function displayRegulatoryExp(event) {
  var from = $.trim($(this).parent().next().text());
  var idKey = $(this).val();
  var checked_flg = false;
  if (event.data.type == 'software' || event.data.type == 'firmware') {
    if (event.data.operation == 'add') {
      checked_flg = true;
    }
    //caused by add primary field.
    if (event.data.type == 'software') {
      from = $.trim($(this).parent().next().next().text());
    }
  } else {
    checked_flg = $(this).attr('checked');
  }
  if (checked_flg) {
    $.ajax({
      type: 'get',
      url: Drupal.settings.basePath + 'named-config/ajax/getRegulatoryExp',
      data: 'type=' + event.data.type + '&id=' + idKey,
      success: function(response) {
        if (response != "") {
          var arrExp = response.split(',');
          for (var i = 0; i < arrExp.length; i++) {
            if (arrExp[i] != "") {
              addRegulatoryExp(idKey, arrExp[i], from);
            }
          }
          renderTable('regulatory_exp_list');
        }
      }
    });
  } else {
    deleteRegulatoryExp(idKey);
  }
}

var regExpObj = new Object();

function addRegulatoryExp(idKey, excetpion, from) {
  var html;
  var id_suffix = (Math.random() + '').split('.').pop();
  var id = 'regulatory_exp_' + id_suffix;
  html = '<tr id="' + id + '"><td>' + excetpion + '</td><td>' + from + '</td></tr>';
  $('#regulatory_exp_list tbody').append(html);
  if (typeof regExpObj[idKey] != "undefined") {
    regExpObj[idKey] = regExpObj[idKey] + id + ',';
  } else {
    regExpObj[idKey] = id + ',';
  }
}

function deleteRegulatoryExp(idKey) {
  if (typeof regExpObj[idKey] != "undefined") {
    if (idKey == 'all') {

    }
    var idArr = regExpObj[idKey].split(',');
    for (var i = 0; i < idArr.length; i++) {
      $('#' + idArr[i]).remove();
    }
    regExpObj[idKey] = '';
  }
  renderTable('regulatory_exp_list');
}

function renderTable(tblId) {
  $('#' + tblId + ' tr').removeClass('even odd');
  $('#' + tblId).each(function() {
    $('tr:odd', this).addClass('odd');
    $('tr:even', this).addClass('even');
  });
}

function move_table_item_right(x) {
  var type = "";
  if (x == 's') {
    type = "software";
  } else if (x == 'f') {
    type = "firmware";
  }
  $('table#left_table_' + x + ' tr').each(function(event) {
    var this_checked = false;
    var seleted_id = [];
    var radio_check = false;
    var radio_id;
    $(this).find('input[type=checkbox]:checked').each(function(evt) {
      this_checked = true;
      seleted_id[evt] = $(this)[0].id;
    });
    $(this).find('input[type=radio]:checked').each(function(evt) {
      radio_id = true;
      radio_id = $(this)[0].id;
    });
    if (this_checked) {
      var tr_str = $(this).html();
      $('#right_table_' + x).append('<tr>' + tr_str + '</tr>');
      if (x == 's' || x == 'f') {
        $('#right_table_' + x).find('#' + seleted_id[0]).bind("click", {"type": type, "operation": "add"}, displayRegulatoryExp);
        $('#right_table_' + x).find('#' + seleted_id[0]).click();
        $('#right_table_' + x).find('#' + seleted_id[0]).unbind("click", displayRegulatoryExp);
      }
      $('#right_table_' + x).find('#' + seleted_id[0]).attr('checked', true);
      $('#right_table_' + x).find('#' + seleted_id[1]).attr('checked', true);
      $('#right_table_' + x).find('#' + radio_id).attr('checked', radio_id);
      $(this).remove();
    }
  });
  renderTable('right_table_' + x);
  renderTable('left_table_' + x);

  $("#div_table_choose").find("input:radio").bind("change", validateComplete);
  validateComplete();
}

function move_table_item_left(x) {
  if (x == 's') {
    type = "software";
  } else if (x == 'f') {
    type = "firmware";
  }
  $('#right_table_' + x + ' input[type=checkbox][name^=reference_list]:checked').each(function(event) {
    if (x == 's' || x == 'f') {
      $(this).bind("click", {"type": type, "operation": "remove"}, displayRegulatoryExp);
      $(this).click();
      $(this).unbind("click", displayRegulatoryExp);
    }
    var td_str = $(this).parent().parent().html();
    $('#left_table_' + x).append('<tr>' + td_str + '</tr>');
    $(this).parent().parent().remove();
  });
  renderTable('right_table_' + x);
  renderTable('left_table_' + x);

  validateComplete();
}

function save_change_config(event) {
  $('table[id^="left_table"] input[name^=reference_list][type=checkbox]').attr("checked", false);
  $('table[id^="right_table"] input[name^=reference_list][type=checkbox]').attr("checked", true);
  //Validate system config software has hardware
  /** GATEWAY-2875 not check software has hardware
   if (!$('#is_warning').attr('checked')) {
   validate_software_has_hardware(event);
   }*/
  return true;
}

function nc_filter_device_type(id) {
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "named-config/filter/devicetype",
    data: {
      "product_line": $('#global_product_line').val()
    },
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

function update_config_status_by_type() {
  var type_id = $('#config_type').val();
  var url = Drupal.settings.basePath + 'named-config/ajax/get/substatus/' + type_id;
  $.get(url, function(response) {
    var data = Drupal.parseJson(response);
    if (data.status == 'success') {
      $('#select_substatus').html(data.data);
      var substatus_id = $('#select_substatus option:visible').val();
      $('#select_substatus').val(substatus_id);
    }
  });
}

function show_hide_warning_configuration() {
  if (!$('#is_warning').attr('checked') && $("#config_type option:selected").text() == 'Named System Configuration') {
    var url = Drupal.settings.basePath + 'named-config/ajax/get-warning-config';
    $.get(url, function(response) {
      var data = Drupal.parseJson(response);
      if (data.status == 'success') {
        $.each(data.data, function(id) {
          $('#reference_list-' + id).attr('checked', false);
          $('#reference_list-' + id).parent().parent().hide();
        });
        $('.hsf-configuration-list-table .hsf-configuration-item-table').each(function() {
          $(this).find('tr:visible:even').attr('class', 'even');
          $(this).find('tr:visible:odd').attr('class', 'odd');
        });
      }
    });
  } else {
    $('.hsf-configuration-list-table').find('input:checkbox').parent().parent().show();
    $('.hsf-configuration-list-table .hsf-configuration-item-table').each(function() {
      $(this).find('tr:visible:even').attr('class', 'even');
      $(this).find('tr:visible:odd').attr('class', 'odd');
    });
  }
}

function validate_software_has_hardware(event) {
  if ($("#config_type option:selected").text() != 'Named System Configuration') {
    return true;
  }
  var software_ids = [];
  var hardware_ids = [];
  $('#sys_software_configuration input:checked').each(function() {
    software_ids.push($(this).val());
  });
  $('#sys_hardware_configuration input:checked').each(function() {
    hardware_ids.push($(this).val());
  });
  var url = Drupal.settings.basePath + 'named-config/ajax/validate-sw-hw';
  var data = {'software_list[]': software_ids, 'hardware_list[]': hardware_ids};

  var output = '';
  $.post(url, data, function(response) {
    var resp = Drupal.parseJson(response);
    if (resp.status == 'success') {
      var sw_error = resp.data;
      if (sw_error) {
        $.each(sw_error, function(sw, hws) {
          var swcf_name = $('#reference_list-' + sw).parent().next().text();
          output += 'Software is [' + swcf_name + '] requites Hardware item. <br/>';
          $.each(hws, function(hw_id, hw_name) {
            output += ('<li>' + hw_name + '</li>');
          });
        });
      }
      //if has error
      if (output != '') {
        modal(output);
        event.preventDefault();
        return false;
      } else {
        //if not has error, submit form
        $('form').submit();
        return true;
      }
    }
  });
  event.preventDefault();
  return false;
}

/**
 * when change this list below 
 * device type * config type * config status 
 * @returns {Boolean}
 */
function get_config_table_list_by_device_type() {
  //get table list 
  var dt_nid = $('#edit-field-device-type-nid').val();
  var status_id = $('#config_status').val();
  var config_id = $('#config_id').val();
  if (config_id != 0) {
    return false;
  }
  disableSubmit();
  $('#regulatory_exp_list tbody').html('');
  switch ($("#config_type").find("option:selected").text()) {
    case 'Named System Configuration':
      get_system_table_list_by_device_type();
      break;
    case 'Named Hardware Configuration':
      get_hardware_table_list_by_device_type();
      break;
    case 'Named Software Configuration':
      get_software_table_list_by_device_type();
      break;
    case 'Named Firmware Configuration':
      var url = Drupal.settings.basePath + 'named-config/ajax/get-firmware-config-table/' + dt_nid + '/' + status_id + '/' + config_id;
      $.get(url, function(res) {
        var response = Drupal.parseJson(res);
        if (response.status == 'success') {
          $('#div_firmware').html(response.data);
          validateComplete();
          $("#div_table_choose").find("input:checkbox").bind("change", validateComplete);
        }
      });
      break;
  }
  validateComplete();
  return false;
}

function sw_list_table_radio() {
  // check required
  $('#div_software').find('.sw-list-table input:checkbox').each(function(event) {
    $(this).change(function(e) {
      var this_id = $(this)[0].id;
      if ($(this).attr('checked')) {
        $('#' + this_id + '-required').removeAttr('disabled');
      } else {
        $('#' + this_id + '-required').attr('checked', false);
        $('#' + this_id + '-required').attr('disabled', 'disabled');
      }
    });
  });
  return false;
}

function sys_config_only_check_one() {
  checkbox_only_check_one('sys_hardware_configuration');
  checkbox_only_check_one('sys_software_configuration');
  checkbox_only_check_one('sys_firmware_configuration');
}

//check only selete one input checkbox when use system configuration
function checkbox_only_check_one(input_box) {
  $('#' + input_box + ' :checkbox').change(function() {
    //only use on system configuration
    if ($("#config_type option:selected").text() == 'Named System Configuration') {
      if ($('#' + input_box + ' :checkbox:checked').length > 0) {
        $('#' + input_box + ' :checkbox').not(':checked').attr('disabled', 'disabled');
      } else {
        $('#' + input_box + ' :checkbox').removeAttr('disabled');
      }
    }
  });
}

function show_warning_status_option_by_is_warning() {
  if ($('#is_warning').attr('checked')) {
    $('#warning_status').show();
  } else {
    $('#warning_status').hide();
  }
}

//show table list by warning status
function show_table_list_by_warning_status() {
  if (!$('#is_warning').attr('checked')) {
    $('.system-table-header li').show();
    $('.system-table-body li').show();
    return false;
  }
  var warning_status = $("#select_substatus :selected").text();
  switch (warning_status) {
    case 'Invalid HW Combination':
      //show hardware configuration
      $('.system-table-header li:eq(0)').show();
      $('.system-table-header li:eq(1)').hide();
      $('.system-table-header li:eq(2)').hide();
      $('.system-table-body li:eq(0)').show();
      $('.system-table-body li:eq(1)').hide();
      $('.system-table-body li:eq(2)').hide();
      break;
    case 'Invalid SW Combination':
      //show software configuration
      $('.system-table-header li:eq(0)').hide();
      $('.system-table-header li:eq(1)').show();
      $('.system-table-header li:eq(2)').hide();
      $('.system-table-body li:eq(0)').hide();
      $('.system-table-body li:eq(1)').show();
      $('.system-table-body li:eq(2)').hide();
      break;
    default:
      //show all configuration
      $('.system-table-header li').show();
      $('.system-table-body li').show();
      break;
  }
  return false;
}

function get_hardware_table_list_by_device_type() {
  var dt_nid = $('#edit-field-device-type-nid').val();
  var status_id = $('#config_status').val();
  var config_id = $('#config_id').val();
  if (config_id != 0) {
    return false;
  }
  disableSubmit();
  var url = Drupal.settings.basePath + 'named-config/ajax/get-hardware-config-table/' + dt_nid + '/' + status_id + '/' + config_id;
  $.get(url, function(res) {
    var response = Drupal.parseJson(res);
    if (response.status == 'success') {
      $('#div_hardware').html(response.data);
      validateComplete();
      $("#div_table_choose").find("input:checkbox").bind("change", validateComplete);
    }
  });
}

function get_software_table_list_by_device_type() {
  var dt_nid = $('#edit-field-device-type-nid').val();
  var status_id = $('#config_status').val();
  var config_id = $('#config_id').val();
  if (config_id != 0) {
    return false;
  }
  var url = Drupal.settings.basePath + 'named-config/ajax/get-software-config-table/' + dt_nid + '/' + status_id + '/' + config_id;
  $.get(url, function(res) {
    var response = Drupal.parseJson(res);
    if (response.status == 'success') {
      $('#div_software').html(response.data);
      validateComplete();
      $("#div_table_choose").find("input:checkbox").bind("change", validateComplete);
      sw_list_table_radio();
    }
  });
}

function get_system_table_list_by_device_type() {
  var dt_nid = $('#edit-field-device-type-nid').val();
  var status_id = $('#config_status').val();
  var config_id = $('#config_id').val();
  if (config_id != 0) {
    return false;
  }
  var url = Drupal.settings.basePath + 'named-config/ajax/get-system-config-table/' + dt_nid + '/' + status_id + '/' + config_id;
  $.get(url, function(res) {
    var response = Drupal.parseJson(res);
    if (response.status == 'success') {
      $('#div_system').html(response.data);
      show_hide_warning_configuration();
      //bind validate
      validateComplete();
      $("#div_table_choose").find("input:checkbox").bind("change", validateComplete);
      // bind function to system configuration to show regulatory exceptions from software cfg and firmware cfg.
      $('#sys_software_configuration :checkbox').bind("click", {"type": "software_cfg"}, displayRegulatoryExp);
      $('#sys_firmware_configuration :checkbox').bind("click", {"type": "firmware_cfg"}, displayRegulatoryExp);
      if ($('#config_id').val() != '' && $('#config_id').val() != '0') {
        $('#sys_software_configuration :checked').click();
        $('#sys_firmware_configuration :checked').click();
      }
      //bing change on system configuration only select one 
      sys_config_only_check_one();
      //check warning configuration
      show_table_list_by_warning_status();
    }
  });
}
