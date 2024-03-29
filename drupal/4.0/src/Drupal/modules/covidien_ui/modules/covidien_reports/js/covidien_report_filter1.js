$(document).ready(function() {
  var device_type_hidden = 0;
  $("#device-configuration-report-form select").ajaxComplete(function() {
    $('select option:nth-child(2n+1)').addClass('color_options');
  });
  $("#device-configuration-report-form #edit-product-line").ajaxComplete(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
  });
  $("#device-configuration-report-form #edit-software-name").ajaxComplete(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
  });
  $("#device-configuration-report-form #edit-part-number").ajaxComplete(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
  });
  $("#device-configuration-report-form #edit-hw-name").ajaxComplete(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
  });
  $("#device-configuration-report-form #edit-hw-part-number").ajaxComplete(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
  });
  $('#device-configuration-report-form #edit-product-line').trigger('change');
  $('#device-configuration-report-form select').change(function() {
    child_reset($(this).attr('id'));
    $('select option:nth-child(2n+1)').addClass('color_options');
  });
  $('#edit-device-type').change(function() {
    get_software();
    get_report_hardware();
  });
});

function child_reset(id) {
  switch (id) {
    case 'edit-product-line':
      break;
    case 'edit-device-type':
      $('#edit-device-type-hidden').val($('#edit-device-type').val());
      $('#device-configuration-report-form #edit-software-name').html('<option value="all"></option>');
      $('#device-configuration-report-form #edit-hw-name').html('<option value="all"></option>');
      break;
    case 'edit-customer-name':
      break;
    case 'edit-account-number':
      break;
    case 'edit-software-name':
      break;
      $('#device-configuration-report-form #edit-part-number').html('<option value="all"></option>');
      $('#device-configuration-report-form #edit-version').html('<option value="all"></option>');
      break;
    case 'edit-part-number':
      $('#device-configuration-report-form #edit-version').html('<option value="all"></option>');
      break;
    case 'edit-version':
      break;
    case 'edit-hw-name':
      //for software name change no need to reset
      if (id != 'edit-software-name' && id != 'edit-part-number' && id != 'edit-version') {
        $('#device-configuration-report-form #edit-hw-part-number').html('<option value="all"></option>');
        $('#device-configuration-report-form #edit-hw-version').html('<option value="all"></option>');
      }
      break;
    case 'edit-hw-part-number':
      if (id != 'edit-software-name' && id != 'edit-part-number' && id != 'edit-version') {
        $('#device-configuration-report-form #edit-hw-version').html('<option value="all"></option>');
      }
      break;
    case 'edit-hw-version':
      break;
    default:
      break;
  }
  return true;
}

function parentvalues(autopath) {
  // Get the url from the child autocomplete hidden form element
  var url = '';
  // Alter it according to parent value  
  var arg = '';
  arg = arg + '/' + $('#edit-product-line').val();
  arg = arg + '/' + $('#edit-device-type').val();
  arg = arg + '/' + 'all';//$('#edit-customer-name').val();
  arg = arg + '/' + $('#edit-software-name').val();
  arg = arg + '/' + $('#edit-part-number').val();
  arg = arg + '/' + $('#edit-version').val();
  url = Drupal.settings.basePath + "covidien/" + autopath + "/autocomplete" + arg;
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#edit-ds-number').attr('autocomplete', 'OFF')[0];
  recreateAutoCompleteReport(input, url);
}

function get_software() {
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "ahah-report-software-name-exposed-callback",
    data: {device_type: $('#edit-device-type').val()},
    dataType: "json",
    success: function(ret) {
      $('#edit-software-name').html(ret.data);
      $('#device-configuration-report-form #edit-software-name').val($('#device-configuration-report-form #edit-software-name-hidden').val());
      $('#device-configuration-report-form #edit-software-name').trigger('change');
      $('#device-configuration-report-form #edit-part-number').trigger('change');
    }
  });
}

function get_report_hardware() {
  $.ajax({
    type: "POST",
    url: Drupal.settings.basePath + "ahah-report-hw-name-exposed-callback",
    data: {device_type: $('#edit-device-type').val()},
    dataType: "json",
    success: function(ret) {
      $('#edit-hw-name').html(ret.data);
      $('#device-configuration-report-form #edit-hw-name').val($('#device-configuration-report-form #edit-hw-name-hidden').val());
      $('#device-configuration-report-form #edit-hw-name').trigger('change');
    }
  });
}

function report_validate(id) {
  var dtype = $('#edit-device-type').val();
  var cname = $('#edit-customer-name').val();
  var dsnumber = $('#edit-ds-number').val();
  var country = $('#edit-country').val();

  var error = 0;
  var msg = '<div class="message"><div class="messages error"> <ul>';

  $('#edit-device-type').removeClass("error");
  $('#edit-customer-name').removeClass("error");
  if (dtype == 'all' || dtype == '') {
    $('#edit-device-type').addClass("error");
    error = 1;
    msg += '<li>Invalid Device Type</li>';
  }

  if (dsnumber.length > 0) {
    return true;
  } else {
    if (cname === '' && country === 'all') {
      $('#edit-customer-name').addClass("error");
      error = 1;
      msg += '<li>You must select Customer AND/OR Country</li>';
    }
  }

  if (error === 0) {
    return true;
  }
  msg += '</ul>';
  msg += '</div></div>';
  $('#content-part div.message').html('');
  $('#content-part').prepend(msg);
  return false;
}