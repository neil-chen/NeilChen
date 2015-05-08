

Drupal.behaviors.covidien_reports = function(context) {
  var idval;
  // Block Special characters in titles	  
  $('#edit-ds-number-wrapper input,#edit-customer-name,#edit-account-number').bind('keypress', function(event) {
    idval = $(this).attr('id');
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });
  $('#edit-ds-number-wrapper input,#edit-last-name-wrapper input,#edit-customer-name,#edit-account-number').bind('paste', function(event) {
    idval = $(this).attr('id');
    setTimeout(
            function setvalue() {
              var regex = new RegExp(filter_specialChars);
              var isValid = regex.test($('#' + idval).val());
              if (!isValid) {
                $('#' + idval).val('');
                return false;
              }
            }, 250);
  });
  $('#edit-last-name-wrapper input').bind('keypress', function(event) {
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });
  $('#edit-username-wrapper input').bind('keypress', function(event) {
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });
  $('#edit-username-wrapper input').bind('paste', function(event) {
    idval = $(this).attr('id');
    setTimeout(
            function setvalue() {
              var regex = new RegExp(filter_specialChars);
              var isValid = regex.test($('#' + idval).val());
              if (!isValid) {
                $('#' + idval).val('');
                return false;
              }
            }, 250);
  });
  $('#edit-from-date-wrapper input,#edit-to-date-wrapper input').bind('paste', function(event) {
    idval = $(this).attr('id');
    setTimeout(
            function setvalue() {
              var regex = new RegExp(filter_specialChars_date);
              var isValid = regex.test($('#' + idval).val());
              if (!isValid) {
                $('#' + idval).val('');
                return false;
              }
            }, 250);
  });
};

function reportparentvalues(autopath, id) {
  // Get the url from the child autocomplete hidden form element
  var url = '';
  // Alter it according to parent value  
  var arg = '';
  arg = arg + '/' + $('#edit-product-line').val();
  arg = arg + '/' + $('#edit-device-type').val();
  if (id == 'edit-account-number') {
    var cname = $('#edit-customer-name').val();
    if (cname == '') {
      cname = 'all';
    }
    arg = arg + '/' + cname;
  } else {
    var acno = $('#edit-account-number').val();
    if (acno == '') {
      acno = 'all';
    }
    arg = arg + '/' + acno;
  }
  url = Drupal.settings.basePath + "covidien/" + autopath + "/autocomplete" + arg;
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#' + id).attr('autocomplete', 'OFF')[0];
  recreateAutoCompleteReport(input, url);
}

function recreateAutoCompleteReport(input, url) {
  $(input).unbind();
  Drupal.attachBehaviors();
  var acdb = new Drupal.ACDB(url);
  $(input.form).submit(Drupal.autocompleteSubmit);
  new Drupal.jsAC(input, acdb);
}

function covidien_customer_report_acl(filter, id, url) {

  // Get the url from the child autocomplete hidden form element
  var name = $('#edit-last-name').val();
  var email = $('#edit-username').val();
  var arg = $('#' + filter).val();
  if (arg == '') {
    arg = 'all';
  }
  if (name == '') {
    name = 'all';
  }
  if (email == '') {
    email = 'all';
  }
  // Alter it according to parent value  
  var arg = '/' + name + '/' + email + '/' + arg;
  url = Drupal.settings.basePath + "covidien/reports/" + url + "/filter" + arg;
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#' + id).attr('autocomplete', 'OFF')[0];
  recreateAutoCompleteReport(input, url);
}
function setcustomername(url) {
  // Alter it according to parent value  
  var arg = '';
  arg = arg + '/' + $('#edit-product-line').val();
  arg = arg + '/' + $('#edit-device-type').val();
  var acno = $('#edit-account-number').val();
  if (acno != '') {
    arg = arg + '/' + acno + '/%20%20%20%20';
    $.getJSON(Drupal.settings.basePath + url + arg, function(ret) {
      var obj = '';
      $.each(ret, function(k, v) {
        obj = k;
      });
      if (obj != '') {
        $('#edit-customer-name').val(obj);
      }
    });
  }
}
