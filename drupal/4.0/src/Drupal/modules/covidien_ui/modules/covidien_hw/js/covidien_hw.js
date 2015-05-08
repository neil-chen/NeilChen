$(document).ready(function() {
  $('#views-exposed-form-Hardwarelist-page-1 #edit-field-device-type-nid').change(function() {
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

  update_device_type_by_product_line('#edit-field-device-type-nid-nid', 'not all');

  $('.hardware-node-form-add #edit-field-device-type-nid-nid').change(function() {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
      data: {value: $('#edit-field-device-type-nid-nid').val()},
      success: function(ret) {
        //alert('ret '+ret);
        //window.location.href=ret+"?field_device_type_nid="+$('#edit-field-device-type-nid-nid').val();
      }
    });
  });

  // Default value in Textbox
  if ($('#hardwarelist_page1').children('#edit-title-wrapper').children('input#edit-title').val() == '') {
    $('#hardwarelist_page1').children('#edit-title-wrapper').children('input#edit-title').val(Drupal.t("Enter Hardware Name"));
  }

  //Check if string has "Enter" Request string
  $('input[type="text"]').each(function() {
    if (this.value.indexOf('Enter') >= 0) {
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

  // For Button blur/Active state
  var checked = "0";
  checkCBfilled();
  $('input').each(function() {
    $(this).blur(function() {
      checkTBfilled();
    });
  });
  $('select').each(function() {
    $(this).change(function() {
      checkCBfilled();
    });
  });

  //GATEWAY-2674
  $('form').submit(function() {
    $('form #edit-submit').attr('class', 'non_active_blue');
    $('form #edit-submit').hide();
  });
});
//document ready end

// Function For Button blur/Active state -- STARTS
function checkTBfilled(checked) {
  // For Text Box	
  $('#node-form').find('.required').each(function() {
    // ignore id's here
    if ($(this).attr('id') != 'edit-field-hw-description-0-value') {
      if (this.value == $(this).attr('title') || this.value == '') {
        $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
        $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
        return false;
      } else {
        $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
        $('form[id="node-form"] #edit-submit').attr("disabled", "");
        if (checked != "1") {
          checkCBfilled();
        }
      }
    }
  });
}

function checkCBfilled() {
  $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
  $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
  // For select box
  $('select').each(function() {
    // ignore id's here
    if ($(this).attr('id') != 'edit-field-device-type-nid-nid') {
      if ($('#edit-field-hw-type-nid-nid>option:selected').text() == '') {
        $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
        $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
        return false;
      } else {
        $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
        $('form[id="node-form"] #edit-submit').attr("disabled", "");
        checked = "1";
        checkTBfilled(checked);
      }
    } else {
      if ($(this).val() == 0 || $(this).val() == '') {
        $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
        $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
        return false;
      } else {
        $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
        $('form[id="node-form"] #edit-submit').attr("disabled", "");
        checked = "1";
        checkTBfilled(checked);
      }
    }
  });
}

// Function For Button blur/Active state -- ENDS
Drupal.behaviors.covidien_hw = function(context) {
  //GATEWAY-1728 can use @_- 
  //var filter_specialChars = "^[a-zA-Z0-9\. ]+$"; //white list
  $('input[type="text"]').bind('paste', function() {
    idval = $(this).attr('id');
    //filter_specialChars = ($(this).attr('id') == 'edit-field-hw-part-0-value') ? '^[a-zA-Z0-9-\. ]+$' : '^[a-zA-Z0-9\. ]+$';
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
  $('input[type="text"]').bind('keypress', function(event) {
    //filter_specialChars = ($(this).attr('id') == 'edit-field-hw-part-0-value') ? '^[a-zA-Z0-9-\. ]+$' : '^[a-zA-Z0-9\. ]+$';
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    //add can use - on part number
    var chCode = (event.charCode) ? event.charCode : event.keyCode;
    if (!regex.test(key) && (event.keyCode != 8) && (event.keyCode != 9)) {
      event.preventDefault();
      return false;
    }
  });
  $('#hardwarelist_page1 #edit-title').bind('blur', function() {
    var val = $(this).val();
    if (val == "") {
      $(this).val(Drupal.t("Enter Hardware Name"));
      $(this).attr('title', Drupal.t("Enter Hardware Name"));
    }
  });
};

Drupal.covidien_hw = Drupal.covidien_hw || {};

/**
 * An ajax responder that accepts a packet of JSON data and acts appropriately.
 *
 * The following fields control behavior.
 * - 'display': Display the associated data in the view area.
 */
Drupal.covidien_hw.Ajax = function(target, response) {
  if (response.debug) {
    alert(response.debug);
  }

  var $view = $(target);
  // Check the 'display' for data.
  if (response.status && response.display) {
    var $newView = $(response.display);
    $view.replaceWith($newView);
    $view = $newView;
    Drupal.attachBehaviors($view.parent());
  }
  if (response.messages) {
    // Show any messages (but first remove old ones, if there are any).
    $view.find('.views-messages').remove().end().prepend(response.messages);
  }
  /**
   * To Retain the check
   */
  var refname = 'sw_list';
  $('input[name^="field_' + refname + '[nid][nid]"]').each(function() {
    $('#edit-viewfield-' + refname + '-nid-nid-' + $(this).val()).attr('checked', 'checked');
  });

  /*****************   Retain the checkEnd     ****************/
};
