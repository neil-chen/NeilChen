Drupal.behaviors.covidien_devices = function(context) {
  //var filter_specialChars = "^[a-zA-Z0-9 ]+$"; //white list
  $('input[type="text"]').bind('keypress', function(event) {
    idval = $(this).attr('id');
    //filter_specialChars = (idval == 'customer_name' || idval == 'account_number') ? '^[a-zA-Z0-9- ]+$' : '^[a-zA-Z0-9 ]+$';
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });
  $('input[type="text"]').bind('paste', function() {
    idval = $(this).attr('id');
    //filter_specialChars = (idval == 'customer_name' || idval == 'account_number') ? '^[a-zA-Z0-9- ]+$' : '^[a-zA-Z0-9 ]+$';
    setTimeout(
      function setvalue() {
        var regex = new RegExp(filter_specialChars);
        var isValid = regex.test($('#' + idval).val());
        if (!isValid) {
          $('#' + idval).val('');
          return false;
        }
      }, 100);
  });
  $('#edit-sno').bind('blur', function() {
    var val = $(this).val();
    if (val == "") {
      $(this).val(Drupal.t("Search - Enter Serial Number"));
    }
  });
  $('#edit-sno').bind('focus', function() {
    var val = $(this).val();
    if (val == Drupal.t("Search - Enter Serial Number")) {
      $('#edit-sno').val('');
    }
  });
  $('#edit-device-type').bind('change', function() {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
      data: {value: $(this).val()},
      success: function(ret) {
        //alert('ret '+ret);
        //window.location.href=ret+"?field_device_type_nid="+$('#edit-field-device-type-nid').val();
      }
    });
  });

};
function covidien_devices_acl(autopath) {
  // Get the url from the child autocomplete hidden form element
  var url = '';
  var v = $('#edit-sno').val();
  if (v == "Search - Enter Serial Number") {
    $('#edit-sno').val('');
  }
  // Alter it according to parent value  
  var arg = '/' + $('#edit-device-type').val();
  url = Drupal.settings.basePath + "covidien/" + autopath + "/autocomplete" + arg;
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#edit-sno').attr('autocomplete', 'OFF')[0];
  covidien_devices_recreateACR(input, url);
}

function covidien_devices_recreateACR(input, url) {
  $(input).unbind();
  Drupal.attachBehaviors();
  var acdb = new Drupal.ACDB(url);
  $(input.form).submit(Drupal.autocompleteSubmit);
  new Drupal.jsAC(input, acdb);
}
function covidien_customer_device_acl(filter, id, url) {

  // Get the url from the child autocomplete hidden form element
  var arg = $('#' + filter).val();
  if (arg == '') {
    arg = 'all';
  }
  // Alter it according to parent value  
  var arg = '/' + arg;
  url = Drupal.settings.basePath + "covidien/admin/device/" + url + "/filter" + arg;
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#' + id).attr('autocomplete', 'OFF')[0];
  covidien_devices_recreateACR(input, url);
}
