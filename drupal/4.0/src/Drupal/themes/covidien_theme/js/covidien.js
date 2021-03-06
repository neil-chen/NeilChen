//set ajax time out 30m * 60s * 1000ms
$.ajaxSetup({
  timeout: 1800000
});

var selected_value_temp = 0;
$(document).ready(function() {
  $('input[type=text]').focus(function() {
    var arr = ["First Name", "Last Name", "Email address", "Enter user name"];
    var val = $(this).val();
    if ($.inArray(val, arr) != -1) {
      $(this).val('');
    }
  });
  $("input[type=password]").bind("keydown", function(e) {
    if (e.keyCode == 32) //space
      return false;
  });
  $("input[type=password]").bind("paste", function() {
    idval = $(this).attr('id');
    setTimeout(
            function setvalue() {
              var regex = new RegExp("^[a-zA-Z0-9-_@\.]+$");
              var isValid = regex.test($('#' + idval).val());
              if (!isValid) {
                $('#' + idval).val('');
                return false;
              }
            }, 100);
  });
  $('#edit-name').change(function() {
    $('#edit-mail').val($(this).val());
  });

  var radios = $('input[type="radio"]:checked').val();

  if (radios != "1") {
    $(".register_form").css("display", "none");
    $("#covidien-" + radios).css("display", "");
  }

  //GATEWAY-2993 set radio default value is first 
  $('.white_background').find('input[name^="options"]').each(function() {
    var role_name = $(this).attr('name');
    if (!$('input[name="' + role_name + '"]:checked').val()) {
      $('input[name="' + role_name + '"]:first').attr('checked', true);
    }
  });

  $('select').ajaxStop(function() {
    $('select option:nth-child(2n+1)').addClass('color_options');
  });
});

function redirect(path, obj) {
  var id = obj.options[obj.selectedIndex].value;
  window.location = path + id;
}

function covidien_customer_acl(filter, id, url) {

  // Get the url from the child autocomplete hidden form element
  var arg = $('#' + filter).val();
  if (arg == '') {
    arg = 'all';
  }
  // Alter it according to parent value  
  var arg = '/' + arg;
  url = Drupal.settings.basePath + "covidien/admin/user/" + url + "/filter" + arg;
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#' + id).attr('autocomplete', 'OFF')[0];
  covidien_username_recreateACR(input, url);
}
function covidien_username_recreateACR(input, url) {
  $(input).unbind();
  Drupal.attachBehaviors();
  var acdb = new Drupal.ACDB(url);
  $(input.form).submit(Drupal.autocompleteSubmit);
  new Drupal.jsAC(input, acdb);
}

/*
 * User email autocomplate check on password forget page
 */
var check_mail_value_temp = 0;
var check_security_value_temp = 0;
function covidien_user_mail_acl(id, url) {
  var mail = $('#' + id).val();
  $.get(Drupal.settings.basePath + url + '/' + mail, function(data) {
    if (id == 'email') {
      check_mail_value_temp = data;
    }
    if (id == 'security_text') {
      check_security_value_temp = data;
    }
    if ((check_mail_value_temp == 1) && (check_security_value_temp == 1)) {
      $('#edit-submit').removeClass('non_active_grey');
      $('#edit-submit').removeAttr('disabled');
    } else {
      $('#edit-submit').addClass('non_active_grey');
      $('#edit-submit').attr('disabled', 'disabled');
    }
  });
}

//move English, US English, International English, to before
function SortLanguageOption(selectName, item_id) {
  var $dd = $(selectName);
  var seleted_id = $dd.find("option:selected").val();
  if (!$dd.length) {
    return false;
  }
  var null_lan = $dd.find("option[value='']");
  if (null_lan.length) {
    null_lan.remove();
  }
  $dd.find('option:first').before($dd.find("option[text='International English']"));
  $dd.find('option:first').before($dd.find("option[text='US English']"));
  $dd.find('option:even').addClass('color_options');
  $dd.find('option:odd').removeClass('color_options');
  if (!item_id) {
    seleted_id = $dd.find('option[text="US English"]').val();
  }
  $dd.val(seleted_id);
}

function update_device_type_by_product_line(selectName, not_all) {
  var $dd = $(selectName);
  if (!$dd.length) {
    return false;
  }
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "covidien/hardware/devicetype",
    data: {"product_line": $('#global_product_line').val()},
    dataType: 'json',
    success: function(response) {
      var sel_arr = new Array();
      $dd.find('option').each(function() {
        var option_val = $(this).val();
        var flag = 0;
        for (var i = 0; i < response.length; i++) {
          if (response[i] == option_val) {
            flag = 1;
          }
        }
        if (flag == 0) {
          $dd.find("option[value='" + option_val + "']").remove();
        }
      });
      //not all 
      if (not_all) {
        $dd.find("option[value='All']").remove();
      }
      //GATEWAY-1966 filter device type and product line 
      no_display_device_type($dd);

      $dd.find('option:even').addClass('color_options');
      $dd.find('option:odd').removeClass('color_options');
      $dd.change();
    }
  });
  return true;
}

function update_device_url_by_device_type() {
  var dt_nid = $('#edit-field-device-type-nid').val();
  if (!dt_nid) {
    dt_nid = $('#edit-device-type').val();
  }
  if (!dt_nid) {
    dt_nid = $('#sel_device_type').val();
  }

  if (dt_nid) {
    var params = {device_type: dt_nid};
    var str = $.param(params);
    $('#anch_devices').attr('href', Drupal.settings.basePath + 'covidien/devices?' + str);
  }

  return false;
}