$(document).ready(function() {
  $('#views-exposed-form-Configlist-page-1 #edit-field-device-type-nid').change(function() {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
      data: {value: $('#edit-field-device-type-nid').val()},
      success: function(ret) {
        //alert('ret '+ret);
        //window.location.href=ret+"?field_device_type_nid="+$('#edit-field-device-type-nid').val();
      }
    });
  });

  $('input#edit-field-effective-date-0-value-datepicker-popup-0').addClass('required');

  // Default value in Textbox
  if ($('input#edit-field-effective-date-0-value-datepicker-popup-0').val() == '') {
    $('input#edit-field-effective-date-0-value-datepicker-popup-0').val('MM/DD/YYYY');
  }
  if ($('input#edit-field-device-end-of-life-0-value-datepicker-popup-0').val() == '') {
    $('input#edit-field-device-end-of-life-0-value-datepicker-popup-0').val('MM/DD/YYYY');
  }
//Check if string has "Enter" Request string
  $('input[type="text"]').each(function() {
    if (this.value.indexOf('Enter') >= 0 || this.value.indexOf('MM/DD/YYYY') >= 0) {
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
//
  checkTBfilled();
  $('input').each(function() {
    $(this).change(function() {
      checkTBfilled();
    });
  });

//

  $('#edit-field-device-type-nid-nid').change(function() {
    $('#device_config_hw_listhidden').html('');
    config_hw_sw_view();
  });

  config_hw_sw_view();
});
// Function For Button blur/Active state -- STARTS
function checkTBfilled(checked) {
  $('[name="hidden_end_of_life"]').val($('#edit-field-device-end-of-life-0-value-datepicker-popup-0').val());
  // For Text Box	
  $('#node-form').find('.required').each(function() {
    if ($(this).attr('id') != 'edit-field-device-end-of-life-0-value-datepicker-popup-0') {
      if (this.value == $(this).attr('title') || this.value == '') {
        $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
        $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
        return false;
      } else {
        checkCBfilled();
      }
    }
  });
}
function checkCBfilled() {
  // For checkbox
  var n1;
  var ns1;
  var hws;
  var sws;
  var checked;
  var n = $('#device_config_hw_listhidden input[id^="hidden_edit-viewfield-config_hw_sw_1-nid-nid-"]').length;
  var ns = $('#device_config_hw_listhidden input[id^="hidden_viewfield_config_hw_sw_status_1_nid_nid_"]').length;

  $('#device_config_hw_listhidden input[id^="hidden_edit-viewfield-config_hw_sw_1-nid-nid-"]').each(function() {
    hws = $(this).attr('id').split('-');
    if (ns != 0) {
      ns = $('#device_config_hw_listhidden input[id="hidden_viewfield_config_hw_sw_status_1_nid_nid_' + hws[hws.length - 1] + '"]').length;
    }
    if (n != 0 && ns != 0) {
      n1 = $('#device_config_hw_listhidden input[id^="hidden_edit-viewfield-config_hw_sw-nid-' + hws[hws.length - 1] + '-"]').length;
      if (n1 > 0) {
        $('#device_config_hw_listhidden input[id^="hidden_edit-viewfield-config_hw_sw-nid-' + hws[hws.length - 1] + '-"]').each(function() {
          sws = $(this).attr('id').split('-');
          if (ns1 != 0) {
            ns1 = $('#device_config_hw_listhidden input[id="hidden_viewfield_config_hw_sw_status_nid_' + hws[hws.length - 1] + '_' + sws[sws.length - 1] + '"]').length;
          }
        });
        if (n1 > 0 && ns1 == 0) {
          return false;
        }
      }
    }
  });

  if ((n == 0) || ns == 0 || (n1 > 0 && ns1 == 0)) {
    $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
    $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
  } else {
    $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
    $('form[id="node-form"] #edit-submit').attr("disabled", "");
  }
}
Drupal.behaviors.covidien_device_config = function(context) {
  // Attach a click event to each checkbox so that we can re-evaluate the
  // state of the header checkbox when all items are checked/unchecked.

  $('input:checkbox').click(function() {
    var refid = $(this).attr('value');
    var tagid = $(this).attr('id');
    var tagname = $(this).attr('name');
    var refname = 'device_config_hw_list';
    if ($(this).attr('checked')) {
      var hiden_field = '<input type="hidden" class="form-checkbox" ';
      hiden_field += ' value="' + refid + '" ';
      hiden_field += 'id="hidden_' + tagid + '" ';
      hiden_field += 'original_id="' + tagid + '" ';
      hiden_field += 'original_name="' + tagname + '" ';
      hiden_field += 'name="hidden_' + tagname + '">';
      $('#' + refname + 'hidden').append($(hiden_field));

    } else {
      $('#hidden_' + tagid).remove();
    }
    checkTBfilled();
  });

  $('select[id^="viewfield_config_hw_sw_status"]').change(function() {
    var refid = $(this).attr('value');
    var tagid = $(this).attr('id');
    var tagname = $(this).attr('name');
    var refname = 'device_config_hw_list';
    $('#hidden_' + tagid).remove();
    if ($(this).attr('value') != '') {
      var hiden_field = '<input type="hidden" class="form-checkbox" ';
      hiden_field += ' value="' + refid + '" ';
      hiden_field += 'id="hidden_' + tagid + '" ';
      hiden_field += 'original_id="' + tagid + '" ';
      hiden_field += 'original_name="' + tagname + '" ';
      hiden_field += 'name="hidden_' + tagname + '">';
      $('#' + refname + 'hidden').append($(hiden_field));
    }
    checkTBfilled();
  });

  if (context == '#device_config_hw_list_wraper' || context == '[object HTMLDocument]') {
    $('#device_config_hw_list_wraper .pager a').click(function(e) {
      e.preventDefault();

      var tmphref = this.href.split('page=');


      if (!IsNumeric(tmphref[1])) {
        var page = 0;
      } else {
        var page = tmphref[1];
      }
      $('#edit-device-config-hw-list-page').val(page);
      config_hw_sw_view();
    });
    config_hw_sw_retainchecked();
  }
  checkTBfilled();
};

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
var ajax_result_callback = function(data) {
  var result = Drupal.parseJson(data);
  jQuery('#device_config_hw_list_wraper').html(result.view_output);

  Drupal.attachBehaviors('#device_config_hw_list_wraper'); //Don't forget this !!!
}

function config_hw_sw_view() {
  var sort = $('#edit-device-config-hw-list-sort').val();
  var order = $('#edit-device-config-hw-list-order').val();
  var page = $('#edit-device-config-hw-list-page').val();

  var arg1 = $('#edit-field-device-type-nid-nid').val();
  jQuery.get(Drupal.settings.basePath + 'covidien/configuration/ajax/config_hw_sw/' + arg1 + '/' + sort + '/' + order + '/' + page, null, ajax_result_callback);
  // preventing entire page from reloading
  return false;
}

function config_hw_sw_retainchecked() {
  /**
   * To Retain the check
   */
  $('#device_config_hw_listhidden input[id^="hidden_edit-viewfield-config_hw_sw"]').each(function() {
    $('#' + $(this).attr('original_id')).attr('checked', 'checked');
  });

  $('#device_config_hw_listhidden input[id^="hidden_viewfield_config_hw_sw_status"]').each(function() {
    $('#' + $(this).attr('original_id')).val($(this).val());
  });

  /*****************   Retain the checkEnd     ****************/
}
Drupal.behaviors.covidien_doc = function(context) {
  $('input[type="text"]').bind('paste', function(event) {
    if ($(this).hasClass('date-popup-init')) {
      filter_Chars = filter_specialChars_date;
    } else {
      filter_Chars = filter_specialChars;
    }
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
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });

};

