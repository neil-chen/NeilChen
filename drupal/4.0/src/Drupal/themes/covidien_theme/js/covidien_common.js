//var filter_specialChars = "^[a-zA-Z0-9-_@\. ]+$"; //white list
//GATEWAY-2251
var filter_specialChars = "^[a-zA-Z0-9-_@\.+!\/ ]+$"; //white list
var filter_specialChars_date = "^[0-9\/ ]+$"; //white list

$(document).ready(function() {
  /*GATEWAY-2544
   if (frames && top.frames.length > 0) {
   top.location.href = self.location;
   }
   */
// For Menu Highlight - Covidien Brackets
  var identifier = window.location.pathname;
  var split = identifier.split("/");
  var vTitle = $(this).attr('title').split("|");

  function check_url($ustring) {
    return $.inArray($ustring, split) > -1;
  }

  if (check_url('settings') && check_url('users')) {
//anch_user_settings
    $('#anch_user_settings').after("<span class='T10C11'>&nbsp; ]</span>");
    $('#anch_user_settings').before("<span class='T10C11'>[ &nbsp;</span>");
  }
  else if (check_url('node') && check_url('edit') && vTitle[0] != "User Settings ") {
//For edit catalogs
    $('#anch_system_admin').attr('class', 'active');
    $('#anch_system_admin').after("<span class='T10C2'>&nbsp; ]</span>");
    $('#anch_system_admin').before("<span class='T10C2'>[ &nbsp;</span>");
  }
  else if (check_url('covidien') && check_url('home')) {
//anch_home
    $('#content-part').attr('style', 'border:0');
    $('#anch_home').attr('class', 'active');
    $('#anch_home').after("<span class='T10C2'>&nbsp; ]</span>");
    $('#anch_home').before("<span class='T10C2'>[ &nbsp;</span>");
  }
  else if (check_url('covidien') && check_url('device') || check_url('devices')) {
//anch_devices
    if (check_url('device')) {
      $('#content-part').attr('style', 'border:0');
    }
    $('#anch_devices').attr('class', 'active');
    $('#anch_devices').after("<span class='T10C2'>&nbsp; ]</span>");
    $('#anch_devices').before("<span class='T10C2'>[ &nbsp;</span>");
  }
  else if (check_url('reports') || check_url('report')) {
//anch_devices
    $('#anch_reports').attr('class', 'active');
    $('#anch_reports').after("<span class='T10C2'>&nbsp; ]</span>");
    $('#anch_reports').before("<span class='T10C2'>[ &nbsp;</span>");
  }
  else if (check_url('covidien') || check_url('activity') || check_url('add') || check_url('add_new') || (check_url('node') && check_url('add')) || check_url('named-config')) {
//anch_system_admin
    $('.manage_role').attr('style', 'border:0');
    $('#anch_system_admin').attr('class', 'active');
    $('#anch_system_admin').after("<span class='T10C2'>&nbsp; ]</span>");
    $('#anch_system_admin').before("<span class='T10C2'>[ &nbsp;</span>");
  }

// Block enter Key for default submit
  $("form input[type='text'],form select,form input[type='button']").bind("keypress", function(e) {
    if (e.keyCode == 13) //Enter
      return false;
  });

// Block Special characters in titles	  
  $('.oval_search_wraper input').bind('keypress', function(event) {
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8) && (event.keyCode != 9)) { //BackSpace  //Tab 
      event.preventDefault();
      return false;
    }
  });

// Login Screen Changes
// For Password Text - !IE 
  $('#fpage #edit-pass-clear').show();
  $('#fpage #edit-pass').hide();

  $('#fpage #edit-pass-clear').focus(function() {
    $('#fpage #edit-pass-clear').hide();
    $('#fpage #edit-pass').show();
    $('#fpage #edit-pass').focus();
  });
  $('#fpage #edit-pass').blur(function() {
    if ($('#fpage #edit-pass').val() == '') {
      $('#fpage #edit-pass-clear').show();
      $('#fpage #edit-pass').hide();
    }
  });
  $('input[type="text"]').each(function() {
    if (this.value.indexOf('Username ') >= 0) {
      $(this).attr("title", this.value);
      this.value = $(this).attr('title');
      $(this).addClass('text-label');
      $(this).focus(function() {
        if (this.value == $(this).attr('title')) {
          this.value = '';
          $(this).removeClass('text-label');
        }
      });
      $(this).blur(function() {
        if (this.value == '') {
          this.value = $(this).attr('title');
          $(this).addClass('text-label');
        }
      });
    }
  });

// For Role Popup
  $('input[type="text"]').each(function() {
    if (this.value.indexOf('Enter role') >= 0) {
      $(this).attr("title", this.value);
      this.value = $(this).attr('title');
      $(this).addClass('text-label');
      $(this).focus(function() {
        if (this.value == $(this).attr('title')) {
          this.value = '';
          $(this).removeClass('text-label');
        }
      });
      $(this).blur(function() {
        if (this.value == '') {
          this.value = $(this).attr('title');
          $(this).addClass('text-label');
        }
      });
    }
  });
  $("select option").each(function(i) {
    this.title = this.text;
  });

//  $('#alert_notification_history_cancel').click(function(){ 
//    goBack(); return false; 
//  });

  if (check_url('alert')) {
    $('.alert').addClass('active');
  }

  //GATEWAY-1966 filter device type and product line 
  no_display_product_line($('#global_product_line'));
  //device type filter
  no_display_device_type($('#edit-field-device-type-nid'));
  no_display_device_type($('#edit-device-type'));
  no_display_device_type($('#sel_device_type'));
});
//document ready end

function popuppage(stype, txtfile) {
  var deviceType = '';
  var div_content = $("#content-part");
  $(div_content).find("b").each(function(index, value) {
    if (index == 0) {
      deviceType = $(value).html();
      return 1;
    }
  });
  var action = Drupal.settings.basePath + "covidien/logdetails?type=" + stype + "&filename=" + txtfile + "&deviceType=" + deviceType;
  window.open(action, 'newwindow', 'height=600,width=1000,top=200,left=400,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no');
}

function goBack() {
  window.history.back()
}

//GATEWAY-1966 filter device type and product line 
function no_display_device_type(device_type) {
  var dt_arr = ['PB840_Ventilator', 'PM1000N', 'PM10N', 'CV1', 'iDrive', 'PM100N'];
  if (device_type.length) {
    device_type.find('option').each(function() {
      if ($.inArray($.trim($(this).text()), dt_arr) > -1) {
        $(this).remove();
      }
    });
    device_type.find('option:even').addClass('color_options');
    device_type.find('option:odd').removeClass('color_options');
    return true;
  }
  return false;
}

//GATEWAY-1966 filter device type and product line 
function no_display_product_line(product_line) {
  var pl_arr = ['Patient Monitoring', 'Stapling'];
  if (product_line.length) {
    product_line.find('option').each(function() {
      if ($.inArray($.trim($(this).text()), pl_arr) > -1) {
        $(this).remove();
      }
    });
    product_line.find('option:even').addClass('color_options');
    product_line.find('option:odd').removeClass('color_options');
    return true;
  }
  return false;
}

//GATEWAY-2934 check parent status
//new popup function
var modal = (function() {
  // Generate the HTML and add it to the document
  var $wapper = $('<div id="cboxOverlay"><div id="modal"></div></div>');
  var $modal = $wapper.find('#modal');
  var $content = $('<div id="modal-content"></div>');
  var $close = $('<a id="close" href="#"></a>');
  $modal.append($content, $close);
  $(document).ready(function() {
    $wapper.hide();
    $('body').append($wapper);
    $wapper.hide();
  });
  $close.click(function(e) {
    e.preventDefault();
    $wapper.hide();
    $content.empty();
  });
  // Open the modal
  return function(content) {
    $content.html(content);
    // Center the modal in the viewport
    $modal.css({
      top: ($(window).height() - $modal.outerHeight()) / 2,
      left: ($(window).width() - $modal.outerWidth()) / 2 - 250
    });
    $wapper.show();
  };
}());

//GATEWAY-2934 check parent status
function check_parent_status(status_obj, item_id) {
  if (!item_id || item_id == 0) {
    return true;
  }
  var status = status_obj.find('option:selected').text();
  var url = Drupal.settings.basePath + 'named-config/validate-item-status/' + status + '/' + item_id;
  $.get(url, function(response) {
    var data = Drupal.parseJson(response);
    if (data.data.check.length > 0) {
      var message = 'Should change status of below parent configurations which depend on current one :';
      $.each(data.data.check, function(index, value) {
        message += ('<li>' + value + '</li>');
      });
      modal(message);
      return false;
    }
  });
}