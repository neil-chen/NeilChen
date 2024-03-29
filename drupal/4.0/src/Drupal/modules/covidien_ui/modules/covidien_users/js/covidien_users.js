Drupal.behaviors.covidien_users = function(context) {
  $('input[type="text"]').bind('paste', function() {
    var filter_Chars = filter_specialChars;
    idval = $(this).attr('id');
    setTimeout(
            function setvalue() {
              var regex = new RegExp(filter_Chars);
              var isValid = regex.test($('#' + idval).val());
              if (!isValid) {
                $('#' + idval).val('');
                return false;
              }
            }, 100);
  });
  $('input.date-popup-init').bind('paste', function() {
    var filter_Chars = filter_specialChars_date;
    idval = $(this).attr('id');
    setTimeout(
            function setvalue() {
              var regex = new RegExp(filter_Chars);
              var isValid = regex.test($('#' + idval).val());
              if (!isValid) {
                $('#' + idval).val('');
                return false;
              }
            }, 100);
  });
  $('input[type="text"]').bind('keypress', function(event) {
    if ($(this).hasClass('date-popup-init')) {
      filter_Chars = filter_specialChars_date;
    } else {
      filter_Chars = filter_specialChars;
    }
    var regex = new RegExp(filter_Chars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8) && (event.keyCode != 9)) {
      event.preventDefault();
      return false;
    }
  });

  $(".productline_roles").each(function() {
    var selected = $(this).val();
    var thisname = $(this).attr('name');
    var name = thisname.split(' ').join('-');
    if (selected == "") {
      $('#default_' + name).attr("disabled", true);
    }
  });

  $(".productline_roles").change(function() {
    var selected = $(this).val();
    var thisname = $(this).attr('name');
    var valArr = [],
            i = 0, size,
            options = $('#edit-roles');
    $(".productline_roles").each(function() {
      if (this.value) {
        valArr.push(this.value);
      }
    });
    size = valArr.length;
    options.val(valArr);
    var name = thisname.split(' ').join('-');
    if (selected == "") {
      $('#default_' + name).attr("disabled", true);
      if ($('#default_' + name + ":checked").val()) {
        $('#default_' + name).attr("checked", false);
        $('#edit-default-role').val('');
      }
    } else {
      $('#default_' + name).attr("disabled", false);
      if ($('#default_' + name + ":checked").val()) {
        $('#edit-default-role').val(selected);
      }
    }
  });

  $("input[name='default']").click(function() {
    var id = $(this).attr('id');
    var name = id.split('_');
    var idname = name[1].split('-').join(' ');
    $('#edit-default-role').val($('select[name="' + idname + '"]').val());
    validate_submitbtn();
  });

  $("#uitabs li").click(function() {
    var class_val = $(this).attr('class');
    if (class_val == "required") {
      return;
    }
    //  First remove class "active" from currently active tab
    $("#uitabs li").removeClass('active');

    //  Now add class "active" to the selected/clicked tab
    $(this).addClass("active");

    //  Hide all tab content
    $(".tab_content").hide();

    //  Here we get the href value of the selected tab
    var selected_tab = $(this).find("a").attr("href");

    //  Show the selected tab content
    $(selected_tab).fadeIn();

    //  At the end, we add return false so that the click on the link is not executed
    return true;
  });
  $('#device_type_list').change(function() {
    $('#edit-field-device-type-nid-nid').val($(this).val());
  });
  $('#trainer_list').change(function() {
    $('#edit-field-trainer-id-nid-nid').val($(this).val());
  });
  $('#covidien-No #customer_name,#covidien-No #account_number').keyup(function() {
    validate_submitbtn();
  });
  $('#auto_generate').click(function() {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/password/ajax",
      data: {value: 'auto'},
      async: false,
      success: function(ret) {
        if ($.type(ret) == 'string') {
          ret = JSON.parse(ret);
        }
        $('#edit-pass').val(ret.data);
        validate_submitbtn();
      }
    });
  });

  $("#next").keydown(function(event) {
    if (event.which == 13) {
      $("#next").click();
      e.preventDefault();
      return false;
    }
  });

  //order language.
  SortLanguageOption('#edit-field-user-language-nid-nid', $('#user-person-nid').val());

  $("#next").keydown(function(event) {
    if (event.which == 13) {
      $("#next").click();
      e.preventDefault();
      return false;
    }
  });

  $("#next").keydown(function(event) {
    if (event.which == 13) {
      $("#next").click();
      e.preventDefault();
      return false;
    }
  });

  $("#next").keydown(function(event) {
    if (event.which == 13) {
      $("#next").click();
      e.preventDefault();
      return false;
    }
  });

  //change box
  if ($.browser.msie) {
    $('input:checkbox').click(function() {
      this.blur();
      this.focus();
    });
    $('input:radio').click(function() {
      this.blur();
      this.focus();
    });
  }

  $("input[type='radio']").click(function() {
    if ($(this).attr("name") == "field_covidien_employee[value]") {
      if ($(".register_form").find('select').val()) {
        selected_value_temp = $(".register_form").find('select').val();
      }
      $(".register_form").css("display", "none");
      $("#covidien-" + $(this).val()).css("display", "");
      $(".register_form:hidden").find('select').val('');
      $(".register_form:visible").find('select').val(selected_value_temp);
    }
  });

};

function showPrivilegeValues(val) {
  var arr = new Array();
  if ($('.device_type_array_text').val() != '') {
    var arr_val = $('.device_type_array_text').val();
    arr = arr_val.split(",");
  }
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "covidien/admin/user/ahah/privilege_item",
    async: false,
    data: {value: val},
    success: function(ret) {
      var obj = JSON.parse(ret);
      var devices = obj[0];
      var roles = obj[1];
      var devicelist = "<select name='device_array[]' class='device_array' onchange='addDeviceValues(this.value,this)'>";
      devicelist += "<option value=''></option>";
      $.each(devices, function(index, value) {
        devicelist += "<option value='" + index + "'>" + value + "</option>";
      });
      devicelist += "</select>";
      var rolelist = "<select name='role_array[]' class='role_array' onchange='getAccessValues(this.value,this)' disabled='disabled'>";
      rolelist += "<option value=''></option>";
      $.each(roles, function(index, value) {
        rolelist += "<option value='" + index + "'>" + value + "</option>";
      });
      rolelist += "</select>";
      var accesslist = "<select name='access_array[]' class='access_array' onchange='addAccessValues()' disabled='disabled'>";
      accesslist += "<option value=' '></option>";
      accesslist += "</select>";
      $('#privilege_table tr:last').after('<tr><td>' + devicelist + '</td><td>' + rolelist + '</td><td>' + accesslist + '</td></tr>');
    }
  });
}
function selectgivenValues(class_val, value) {
  $("." + class_val + ":last").val(value);
}
function addDeviceValues(val, obj) {
  var arr = new Array();
  if ($(obj).val() == '') {
    $(obj).val('');
    val = '';
    resetDevicevalues(obj, val);
    return false;
  }
  $(".device_array").each(function() {
    arr.push($(this).val());
  });
  $('.device_type_array_text').val(arr.join(","));
  resetDevicevalues(obj, val);
}
function resetDevicevalues(obj, val) {
  if (val != '') {
    $(obj).parent('td').parent('tr').find('select').each(function() {
      $(this).attr('disabled', false);
    });
  } else {
    $(obj).parent('td').parent('tr').find('select').each(function() {
      $(this).attr('disabled', true);
      $(this).val('');
    });
    $(obj).attr('disabled', false);
  }
  addAccessValues();
  addRoleValues();
}
function addDeviceValuestotext() {
  var arr = new Array();
  $(".device_array").each(function() {
    arr.push($(this).val());
  });
  $('.device_type_array_text').val(arr.join(","));
}
function addAccessValues() {
  var arr = new Array();
  $(".access_array").each(function() {
    arr.push($(this).val());
  });
  $('.role_access_text').val(arr.join(","));
}
function addRoleValues() {
  var arr = new Array();
  var devices_arr = new Array();
  var roles_arr = new Array();
  var device_val;
  var role;
  var status = true;
  $(".role_array").each(function() {
    var device = $(this).parent('td').prev('td').children('select');
    device_val = $(device).val();
    role = $(this).val();
    if (inArray(device_val, devices_arr) && inArray(role, roles_arr) && device_val != '' && role != '') {
      $(this).val('');
      var select = $(this).parent('td').next('td').children('select');
      $(select).empty();
      $(select).append('<option value=""></option>');
      status = false;
      return false;
    } else {
      devices_arr.push(device_val);
      roles_arr.push(role);
    }
    arr.push($(this).val());
  });
  $('.role_name_text').val(arr.join(","));
  return status;
}
function getAccessValues(val, obj) {
  var arr = new Array();
  var id = "access_array";
  var select = $(obj).parent('td').next('td').children('select');
  if (val == '') {
    $(select).empty();
    $(select).append('<option value=""></option>');
    addAccessValues();
    addRoleValues();
    return;
  }
  if (!addRoleValues()) {
    return;
  }

  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "covidien/admin/user/ahah/access_lists",
    data: {value: val},
    async: false,
    success: function(ret) {
      var obj = JSON.parse(ret);
      $(select).empty();
      $(select).append('<option value=""></option>');
      $.each(obj, function(index, value) {
        $(select).append('<option value="' + index + '">' + value + '</option>');
      });
    }
  });
}
function getPrivilegeValues(uid) {
  var arr = new Array();
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "covidien/admin/user/ahah/allPrivilege_item",
    data: {uid: uid},
    async: false,
    success: function(ret) {
      var obj = JSON.parse(ret);
      var devices = obj[0];
      var roles = obj[1];
      var access = obj[2];
      var selected_devices = obj[3];
      var selected_roles = obj[4];
      var selected_access = obj[5];
      var denied_devices = obj[6];
      for (var i = 0; i < selected_devices.length; i++) {
        var disabled = '';
        if (inArray(selected_devices[i], denied_devices)) {
          disabled = "disabled = 'disabled'";
          continue;
        }
        var devicelist = "<select name='device_array[]' class='device_array' onchange='addDeviceValues(this.value,this)' " + disabled + ">";
        devicelist += "<option value=''></option>";
        $.each(devices, function(index, value) {
          var sel = '';
          if (index == selected_devices[i]) {
            sel = " selected='selected'";
          }
          devicelist += "<option value='" + index + "' " + sel + ">" + value + "</option>";
        });
        devicelist += "</select>";

        var rolelist = "<select name='role_array[]' class='role_array' onchange='getAccessValues(this.value,this)' " + disabled + ">";
        rolelist += "<option value=''></option>";
        var accesslist = "<select name='access_array[]' class='access_array' onchange='addAccessValues()' " + disabled + ">";
        accesslist += "<option value=''></option>";
        $.each(roles, function(index, value) {
          sel = '';
          if (index == selected_roles[selected_devices[i]]) {
            sel = " selected='selected'";
          }
          rolelist += "<option value='" + index + "' " + sel + ">" + value + "</option>";
          if (index == selected_roles[selected_devices[i]]) {
            $.each(access[index], function(index, value) {
              sel = '';
              if (index == selected_access[selected_devices[i]]) {
                sel = " selected='selected'";
              }
              accesslist += "<option value='" + index + "' " + sel + ">" + value + "</option>";
            });
          }
        });
        rolelist += "</select>";
        accesslist += "</select>";
        $('#privilege_table tr:last').after('<tr><td>' + devicelist + '</td><td>' + rolelist + '</td><td>' + accesslist + '</td></tr>');
        //myArray.splice(key, 1);
      }
      addDeviceValuestotext();
      addRoleValues();
      addAccessValues();
    }
  });
}
function getDisabledPrivilegeValues(uid) {
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "covidien/admin/user/ahah/disabledPrivilege_item",
    data: {uid: uid},
    async: false,
    success: function(ret) {
      var obj = JSON.parse(ret);
      var devices = obj[0];
      var roles = obj[1];
      var access = obj[2];
      var selected_devices = obj[3];
      var selected_roles = obj[4];
      var selected_access = obj[5];
      var denied_devices = obj[6];
      for (var i = 0; i < selected_devices.length; i++) {
        var disabled = '';
        if (inArray(selected_devices[i], denied_devices)) {
          disabled = "disabled = 'disabled'";
        } else {
          continue;
        }
        var devicelist = "<select name='device_array[]' class='device_array' onchange='addDeviceValues(this.value,this)' " + disabled + ">";
        devicelist += "<option value=''></option>";
        $.each(devices, function(index, value) {
          var sel = '';
          if (index == selected_devices[i]) {
            sel = " selected='selected'";
          }
          devicelist += "<option value='" + index + "' " + sel + ">" + value + "</option>";
        });
        devicelist += "</select>";

        var rolelist = "<select name='role_array[]' class='role_array' onchange='getAccessValues(this.value,this)' " + disabled + ">";
        rolelist += "<option value=''></option>";
        var accesslist = "<select name='access_array[]' class='access_array' onchange='addAccessValues()' " + disabled + ">";
        accesslist += "<option value=''></option>";
        $.each(roles, function(index, value) {
          sel = '';
          if (index == selected_roles[selected_devices[i]]) {
            sel = " selected='selected'";
          }
          rolelist += "<option value='" + index + "' " + sel + ">" + value + "</option>";
          if (index == selected_roles[selected_devices[i]]) {
            $.each(access[index], function(index, value) {
              sel = '';
              if (index == selected_access[selected_devices[i]]) {
                sel = " selected='selected'";
              }
              accesslist += "<option value='" + index + "' " + sel + ">" + value + "</option>";
            });
          }
        });
        rolelist += "</select>";
        accesslist += "</select>";
        $('#privilege_table tr:last').after('<tr><td>' + devicelist + '</td><td>' + rolelist + '</td><td>' + accesslist + '</td></tr>');
        //myArray.splice(key, 1);
      }
      addDeviceValuestotext();
      addRoleValues();
      addAccessValues();
    }
  });
}
function inArray(needle, haystack) {
  var length = haystack.length;
  for (var i = 0; i < length; i++) {
    if (haystack[i] == needle)
      return true;
  }
  return false;
}

function getTrainersList(obj) {
  var val = obj.options[obj.selectedIndex].value;
  var id = "trainer_list";
  $('#' + id).empty();
  $('#edit-field-trainer-id-nid-nid').val('');
  $('#' + id).append('<option value=""></option>');
  if (val == "") {
    $('#' + id).empty();
    var first = $('#edit-field-trainer-id-nid-nid option:first-child').val();
    $('#edit-field-trainer-id-nid-nid').val('');
    $('#' + id).append('<option value=""></option>');
    $('#' + id).trigger('change');
  } else {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/admin/user/training/trainer/filter",
      data: { device_type_nid: val, person_email: $('#user_email_id').val() },
      success: function(ret) {
        $('#' + id).empty();
        $('#' + id).append('<option value=""></option>');
        if (ret != '') {
          var obj = ret.split("^");
          for (var i = 0; i < obj.length; i++) {
            var keys = obj[i].split("__");
            $('#' + id).append('<option value="' + keys[0] + '">' + keys[1] + '</option>');
          }
        }
        $('#trainer_list').val($('#trainer_list option:first-child').val());
        $('#' + id).trigger('change');
      }
    });
  }
}

function getDeviceTypeList(obj) {
//
  var id = "trainer_list";
  $('#' + id).empty();
  $('#edit-field-trainer-id-nid-nid').val('');
  $('#' + id).append('<option value=""></option>');
  $('#' + id).trigger('change');
//
  var val = obj.options[obj.selectedIndex].value;
  var id = "device_type_list";
  if (val == "") {
    $('#' + id).empty();
    var first = $('#edit-field-device-type-nid-nid option:first-child').val();
    $('#edit-field-device-type-nid-nid').val('');
    $('#' + id).append('<option value=""></option>');

    var id = "trainer_list";
    $('#' + id).empty();
    var first = $('#edit-field-trainer-id-nid-nid option:first-child').val();
    $('#edit-field-trainer-id-nid-nid').val('');
    $('#' + id).append('<option value=""></option>');
    return;
  }
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "covidien/admin/user/training/devicetype/filter",
    data: {value: val},
    success: function(ret) {
      var obj = ret.split("^");
      $('#' + id).empty();
      $('#' + id).append('<option value=""></option>');
      for (var i = 0; i < obj.length; i++) {
        var keys = obj[i].split("__");
        $('#' + id).append('<option value="' + keys[0] + '">' + keys[1] + '</option>');
      }
      $('#device_type_list').val($('#device_type_list option:first-child').val());
    }
  });
}
function covidien_username_acl() {

  // Get the url from the child autocomplete hidden form element
  var url = '';
  var lastname = $('#edit-last-name').val();
  var pl = $('#edit-product-line').val();
  if (lastname == '') {
    lastname = 'all';
  }
  // Alter it according to parent value  
  var arg = '/' + lastname + '/' + pl;
  url = Drupal.settings.basePath + "username_ajax/autocomplete" + arg;
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#edit-username').attr('autocomplete', 'OFF')[0];
  covidien_username_recreateACR(input, url);
}

function covidien_username_recreateACR(input, url) {
  $(input).unbind();
  Drupal.attachBehaviors();
  var acdb = new Drupal.ACDB(url);
  $(input.form).submit(Drupal.autocompleteSubmit);
  new Drupal.jsAC(input, acdb);
}
