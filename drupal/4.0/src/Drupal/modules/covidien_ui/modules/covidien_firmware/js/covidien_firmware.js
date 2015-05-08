var temp_check = 0;
//to store selected hw configuraions.
var selected_hw_cfg = new Object();
$(document).ready(function() {
  $('#global_product_line').attr("disabled", "disabled");
  if ($('#firmware_id').val()) {
    $('#edit-field-device-type-nid').attr("disabled", "disabled");
  }
  update_device_type_by_product_line('#edit-field-device-type-nid', 'not all');

  $("#edit-field-device-type-nid").bind("change", function() {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
      data: {value: $('#edit-field-device-type-nid').val()},
      success: function(ret) {
        get_hardware_list();
        get_hardware_config_list();
      }
    });
  });
  //fix checkbox change event on IE
  if ($.browser.msie) {
    $('input:checkbox').click(function() {
      this.blur();
      this.focus();
    });
  }

  $('#firmware_file').change(function() {
    var file_name = $(this).val().split('\\').pop();
    $('#fw_upload_localize_path').val(file_name);
  });

  var form_action = $('#covidien-firmware-form').attr('action');
  //file ajax upload 
  fileUpLoad({
    submitBtn: $('#edit-filefield-upload'),
    form: $('#covidien-firmware-form')[0],
    url: Drupal.settings.basePath + 'firmware/ajax/fileupload',
    complete: function(response) {
      $('#file_id').val(response);
      $('.ahah-progress').hide();
      $('#covidien-firmware-form').removeAttr('target');
      $('#covidien-firmware-form').removeAttr('enctype');
      $('#covidien-firmware-form').attr('action', form_action);
      //show remove botton
      $('#display-file-name').html($('#firmware_file').val());
      $('#firmware-file-upload').hide();
      $('#firmware-file-remove').show();
      validateComplete();
    },
    beforeUpLoad: function() {
      if (!$('#firmware_file').val()) {
        $('#file-message').show();
        return false;
      }
    },
    afterUpLoad: function() {
      $('.ahah-progress').show();
      $('#file-message').hide();
    }
  });
  //file remove 
  $('#edit-filefield-remove').click(function() {
    var url = Drupal.settings.basePath + 'firmware/ajax/fileremove';
    var data = {firmware_id: $('#firmware_id').val(), file_id: $('#file_id').val()};
    $.post(url, data, function(response) {
      var d = Drupal.parseJson(response);
      if (d.status) {
        $('#firmware-file-upload').show();
        $('#firmware-file-remove').hide();
        $('#fw_upload_localize_path').val('');
        $('#firmware_file').val('');
        $('#file_id').val(0);
        validateComplete();
      }
    });
  });

  $("#hw_list_tbl input[type='checkbox']").bind("change", get_hardware_config_list);
  $("#firmware_status").bind("change", validateComplete);
  $("#firmware_name").bind("keyup", validateComplete);
  $("#firmware_part").bind("keyup", validateComplete);
  $("#firmware_version").bind("keyup", validateComplete);
  $("#file_id").bind("change", validateComplete);

  var firmware_file = $('#firmware_fileName').val();
  if (firmware_file) {
    $("#firmware_fileName").css("display", "none");
    $("#btn_browse").css("display", "none");
    $("#btn_upload").css("display", "none");
    $("#btn_remove").css("display", "inline");
    $("#span_file_name").css("display", "inline");
    $("#span_file_name").html($("#firmware_fileName").val());
  }
  validateComplete();

  get_hardware_config_list();

  var countryStr = $('#selectedCountryStr').val();
  if (countryStr != undefined && countryStr != '' && countryStr.indexOf('|') > 0) {
    var countryArr = countryStr.split('|');
    var x;
    countryArr.pop();//remove empety element;
    for (x = 0; x < countryArr.length; x++) {
      var countryRow = countryArr[x];
      if (countryRow != "") {
        var countryDetailArr = countryRow.split(',');
        initialRegulatoryExp(countryDetailArr.shift(), countryDetailArr.shift());
      }
    }
    renderTable('regulatory_exp_list');
  }

  //click the upload file 
  var file_id = $('#file_id').val();
  if ($('#firmware_id').val()) {
    check_no_file_show_input(file_id);
  }
  $('#no_file').change(function() {
    check_no_file_show_input(file_id);
  });

  //GATEWAY-2674
  $('form').submit(function() {
    $('form #btn_submit').attr('class', 'non_active_blue');
    $('form #btn_submit').hide();
  });
});
//document ready end

function check_no_file_show_input(file_id) {
  if ($('#no_file').attr('checked')) {
    $('#file_id').next().next().find('.form-required').hide();
    $('#firmware-file-div').css('margin-left', '8px');
    $('#file_id').val(0);
    //file input 
    if (!file_id || file_id == 0) {
      $('#firmware-file-upload').hide();
      $('#firmware-file-remove').hide();
    } else {
      $('#firmware-file-upload').show();
      $('#firmware-file-remove').hide();
    }
  } else {
    $('#file_id').next().next().find('.form-required').show();
    $('#file_id').val(file_id);
    $('#firmware-file-div').removeAttr('style');
    //file input
    if (!file_id || file_id == 0) {
      $('#firmware-file-upload').show();
      $('#firmware-file-remove').hide();
    } else {
      $('#firmware-file-upload').hide();
      $('#firmware-file-remove').show();
    }
  }
  validateComplete();
}

function setFileValue(value) {
  var fileArray = value.split("\\");
  $("#firmware_fileName").val(fileArray[fileArray.length - 1]);
}

function toggleTable(comp) {
  var next = $(comp).next();
  if (next.css("display") == "none") {
    next.slideDown("slow");
  } else {
    next.slideUp("slow");
  }
  next.css("width", "100%");
}

function save_firmware() {
  var sel_text = $("select[name='sel_device_type']").find("option:selected").text();
  $("input[name='device_type_name']").val(sel_text);
  var device_type_id_list = '';
  $('input[name="chk"]:checked').each(function() {
    device_type_id_list += $(this).attr('id') + ',';
  });
  $("#device_type_id_list").val(device_type_id_list);
  $('table#left_table input[type=checkbox]').attr("checked", false);
  $('table#right_table input[type=checkbox]').attr("checked", true);

}

function focusClear(comp, initValue) {
  if ($(comp).val() == initValue) {
    $(comp).val('');
  }
}

function blurFill(comp, initVaule) {
  if ($(comp).val() == '') {
    $(comp).val(initVaule);
  }
}

function validateComplete() {
  var is_field_pass = false;
  var duplicate_check = false;
  if ($("#firmware_name").val() != "" && $("#firmware_part").val() != "" && $("#firmware_version").val() != ""
          && $("#firmware_status").val() != "All" && $("[name=sel_device_type]").val() != "All"
          && $("#right_table input[type='checkbox']").length && ($('#no_file').attr('checked') || $('#file_id').val() != 0)) {
    is_field_pass = true;
  } else {
    is_field_pass = false;
  }
  //validate duplicate firmware.
  if ($('#firmware_id').val() == "") {
    if ($("#firmware_name").val() != "" && $("#firmware_part").val() != "" && $("#firmware_version").val() != "") {
      $.ajax({
        type: "POST",
        url: Drupal.settings.basePath + "firmware/ajax/fw_duplicate_check",
        data: {"firmware_name": $("#firmware_name").val(), "firmware_part": $("#firmware_part").val(), "firmware_version": $("#firmware_version").val()},
        dataType: 'json',
        success: function(response) {
          if (response == '0') {
            is_duplicate_check = false
            $('#error-message').html("Firmeware alredy exist, please check firmware name, part number and version.");
            $("#firmware_name").addClass('error');
            $("#firmware_part").addClass('error');
            $("#firmware_version").addClass('error');
            $('#error-message').show();
          } else {
            duplicate_check = true;
            $('#error-message').html("");
            $("#firmware_name").removeClass('error');
            $("#firmware_part").removeClass('error');
            $("#firmware_version").removeClass('error');
            $('#error-message').hide();
          }
          if (is_field_pass && duplicate_check) {
            enableSubmit();
          } else {
            disableSubmit();
          }
        }
      });
    }
  }
  //validate firmware form input
  if (is_field_pass) {
    enableSubmit();
  } else {
    disableSubmit();
  }
}

function disableSubmit() {
  $("#btn_submit").removeClass("form-submit");
  $("#btn_submit").addClass("non_active_blue");
  $("#btn_submit").attr('disabled', 'disabled');
}

function enableSubmit() {
  $("#btn_submit").removeClass("non_active_blue");
  $("#btn_submit").addClass("form-submit");
  $("#btn_submit").removeAttr("disabled");
}

function get_hardware_config_list() {
  var device_id = $('#edit-field-device-type-nid').val();
  var firmware_id = $('#firmware_id').val();
  var hw_id_list = "";
  $("#hw_list_tbl input[type='checkbox']:checked").each(function() {
    hw_id_list += $(this).val() + "|";
  });
  var data = {'device_type_id': device_id, 'firmware_id': firmware_id, 'hw_id_list': hw_id_list};
  $.get(Drupal.settings.basePath + 'firmware/ajax_get_config_list', data, get_hardware_config_list_callback);
}

function get_hardware_config_list_callback(data) {
  var result = Drupal.parseJson(data);
  if (result.status == 'success') {
    $('#hc_list_wraper').html(result.data);
    check_hardware_configuration();
  }
  $('#hc_list_wraper').find('input:checkbox').change(function(e) {
    check_hardware_configuration();
  });
  for (var prop in selected_hw_cfg) {
    if (selected_hw_cfg.hasOwnProperty(prop)) {
      $('#right_table').append('<tr>' + selected_hw_cfg[prop] + '</tr>');
      //when move item from right table to left table, the value will be empty, don't need to remove item form left table.
      if (selected_hw_cfg[prop] == "") {
        $('#left_table').find(':input[value="' + prop + '"]').attr('checked', false);
      }
      if (selected_hw_cfg[prop] != "") {
        $('#left_table').find(':input[value="' + prop + '"]').parent().parent().remove();
      }
      $('#right_table').find(':input[value="' + prop + '"]').attr('checked', false);
    }
  }
  move_table_item_right();
}

function get_hardware_list() {
  $.get(Drupal.settings.basePath + 'firmware/ajax_get_hw_list', get_hardware_list_callback);
}

function get_hardware_list_callback(data) {
  var result = Drupal.parseJson(data);
  if (result.status == 'success') {
    $('#div-hardware-list').html(result.data);
  }
  $("#hw_list_tbl input[type='checkbox']").bind("change", get_hardware_config_list);
}

function check_hardware_configuration() {
  var checked = 0;
  $('[name^=field_hc_list]').each(function(event) {
    if ($(this).attr('checked')) {
      checked = 1;
      $('#hardware-message').html('<br/>');
    } else {
      //$('#hardware-message').html('You must select/add hardware configuration.');
    }
  });
  temp_check = checked;
  validateComplete();
  return checked;
}

function addRegulatoryExp() {
  var country_nid = $('select[name="ISOCountry"]').val();
  if (country_nid != '0' && country_nid != '') {
    if (checkDuplicate(country_nid)) {
      var html;
      var id_suffix = (Math.random() + '').split('.').pop();
      var id = 'regulatory_exp_' + id_suffix;
      html = '<tr id="' + id + '">' + '<td><input type="checkbox" name="regulatory_exp[]" checked="checked" style="display:none" value="';
      html = html + country_nid + '"/>';
      html = html + $.trim($('select[name="ISOCountry"] option:selected').text()) + '</td><td>';
      html = html + '<input type="button" value="Delete" class="form-submit secondary_submit" onclick="deleteRegulatoryExp(\'#';
      html = html + id + '\')"/></td></tr>';
      $('#regulatory_exp_list').append(html);
    }
    renderTable('regulatory_exp_list');
  }
}
function checkDuplicate(country_nid) {
  var passFlg = true;
  $('input[name="regulatory_exp[]"]').each(
          function() {
            if ($(this).val() == country_nid) {
              passFlg = false;
              return;
            }
          }
  );
  return passFlg;
}
function deleteRegulatoryExp(selector) {
  $(selector).remove();
  renderTable('regulatory_exp_list');
}
function initialRegulatoryExp(countryNid, countryName) {
  var html;
  var id_suffix = (Math.random() + '').split('.').pop();
  var id = 'regulatory_exp_' + id_suffix;
  html = '<tr id="' + id + '">' + '<td><input type="checkbox" name="regulatory_exp[]" checked="checked" style="display:none" value="';
  html = html + countryNid + '"/>';
  html = html + countryName + '</td><td>';
  html = html + '<input type="button" value="Delete" class="form-submit secondary_submit" onclick="deleteRegulatoryExp(\'#';
  html = html + id + '\')"/></td></tr>';
  $('#regulatory_exp_list').append(html);
}

function renderTable(tblId) {
  $('#' + tblId + ' tr').removeClass('even odd');
  $('#' + tblId).each(function() {
    $('tr:odd', this).addClass('odd');
    $('tr:even', this).addClass('even');
  });
}

function move_table_item_right() {
  $('table#left_table tr').each(function(event) {
    var this_checked = false;
    var seleted_id = [];
    $(this).find('input[type=checkbox]:checked').each(function(evt) {
      this_checked = true;
      seleted_id[evt] = $(this)[0].id;
      selected_hw_cfg[$(this).val()] = $(this).parent().parent().html();
    });

    if (this_checked) {
      var tr_str = $(this).html();
      $('#right_table').append('<tr>' + tr_str + '</tr>');
      $('#right_table').find('#' + seleted_id[0]).attr('checked', 'checked');
      $(this).remove();
    }
  });
  validateComplete();
}

function move_table_item_left() {
  $('#right_table input[type=checkbox]:checked').each(function(event) {
    var td_str = $(this).parent().parent().html();
    $('#left_table').append('<tr>' + td_str + '</tr>');
    selected_hw_cfg[$(this).val()] = "";
    $(this).parent().parent().remove();
  });
  validateComplete();
}

/**
 * Ajax file upload
 */
var fileUpLoad = function(config, file_form, url) {
  var ifr = null;
  var fm = null;
  var defConfig = {submitBtn: $('#J_submit'), //button
    form: file_form,
    url: url,
    complete: function(response) {
    },
    beforeUpLoad: function() {
    },
    afterUpLoad: function() {
    }
  };

  var IFRAME_NAME = 'fileUpLoadIframe';
  //config
  config = $.extend(defConfig, config);

  //bind submit
  config.submitBtn.bind('click', function(e) {
    e.preventDefault();
    if (config.beforeUpLoad.call(this) === false) {
      return;
    }
    //create a hide iframe
    ifr = $('<iframe name="' + IFRAME_NAME + '" id="' + IFRAME_NAME + '" style="display:none;"></iframe>');
    fm = config.form;
    ifr.appendTo($('body'));
    fm.target = IFRAME_NAME; //target to ifr
    fm.action = config.url; //target to ifr
    fm.enctype = 'multipart/form-data'; //target to ifr
    //iframe onload
    ifr.load(function() {
      var response = this.contentWindow.document.body.innerHTML;
      config.complete.call(this, response);
      ifr.remove();
      ifr = null; //clear
    });

    fm.submit(); //submit
    //submit event
    config.afterUpLoad.call(this);
  });
};