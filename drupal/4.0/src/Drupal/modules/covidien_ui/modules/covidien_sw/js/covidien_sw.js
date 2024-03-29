//Store software id
var software_id = '';

//Store relation between device type and gateway version.
var deviceTypeRelation = new Object();
// Function For Button blur/Active state -- STARTS

$(document).ready(function() {
  software_id = $('#software_id').val();

  //software list page
  update_device_type_by_product_line('#edit-field-device-type-nid');
  //software form page
  if (!software_id) {
    update_device_type_by_product_line('#edit-field-device-type-nid-nid', 'not all');
  }

  //initial relation between device type and gateway version.
  if ($('#device_type_relation').val() != '' && $('#device_type_relation').val() != undefined) {
    var relationArr = $('#device_type_relation').val().split('|');
    for (var i = 0; i < relationArr.length; i++) {
      if (relationArr[i] != '') {
        var arr = relationArr[i].split(',');
        deviceTypeRelation[arr[0]] = arr[1];
      }
    }
  }
  $('a').click(function() {
    window.onbeforeunload = null;
  });
  $('#edit-submit').click(function() {
    window.onbeforeunload = null;
  });
  // Default value in Textbox
  if ($('#softwarelist_page1').children('#edit-title-wrapper').children('input#edit-title').val() == '') {
    $('#softwarelist_page1').children('#edit-title-wrapper').children('input#edit-title').val('Search - Enter Software Name');
  }

  //click the upload file 
  $('#no_file').change(function() {
    var uploader = $('#uploader');
    var remover = $('#remover');
    if ($(this).attr('checked')) {
      uploader.hide();
      remover.hide();
    } else {
      if ($('#file_name').html().length > 0) {
        remover.show();
      } else {
        uploader.show();
      }
    }
  });

  if (Drupal.settings.covidien_sw) {
    if (Drupal.settings.covidien_sw.nid) {
      if ($('#edit-field-sw-file-0-fid').val() == 0) {
        $('#no_file').attr('checked', 'checked');
        $('#uploader').hide();
        $('#remover').hide();
      }
    }
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

  // Trigger Calls	
  $('#edit-field-device-type-nid-nid').change(function() {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
      data: {value: $('#edit-field-device-type-nid-nid').val()},
      success: function(ret) {
        //alert('ret '+ret);
        //window.location.href=ret+"?field_device_type_nid="+$('#edit-field-device-type-nid-nid').val();
        $('#hw_listhidden').html('');
        filter_view();
        get_hardware_config_list();
        get_firmware_config_list();
        switch_display_area(deviceTypeRelation);
      }
    });
  });
  switch_display_area(deviceTypeRelation);
  if ($('#hw_list_wraper').length) {
    get_hardware_config_list();
    get_firmware_config_list();
  }
  //GATEWAY-1733 VLEX Client not use Business Rules
  software_type_html = $('#edit-field-sw-type-nid-nid').html();
  vlex_business_rules();

  // Trigger Calls	
  $('#edit-field-device-type-nid-nid').change(function() {
    $('#hw_listhidden').html('');
    //GATEWAY-1733 VLEX Client not use Business Rules
    vlex_business_rules();
    filter_view();
    //GATEWAY-3158 fix device type value
    $('[name="field_device_type[nid][nid]"]').val($(this).val());
  });

  $('#edit-go').click(function() {
    $('#edit-hw-list-page').val(0);
    filter_view();
  });

  var onload_field_hw_version_value = 0;
//list page parent fillter child reset
  $('#views-exposed-form-softwarelist-page-1 #edit-field-hw-type-nid').change(function() {
    $('#views-exposed-form-softwarelist-page-1 #hwverson-ahah').html('<div><div class="form-item"><select id="edit-field-hw-version-value" class="form-select" name="field_hw_version_value"><option selected="selected" value="">All</option></select></div></div>');
    if (onload_field_hw_version_value != 0) {
      $('#edit-filter-hidden-hwverson').val('');
    }
    onload_field_hw_version_value = 1;
  });
  var ajaxtitlecall = 0;
  $("#views-exposed-form-softwarelist-page-1 #edit-field-hw-type-nid").ajaxStop(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
    if (ajaxtitlecall == 0) {
      ajaxtitlecall = 1;
      $('#views-exposed-form-softwarelist-page-1 #edit-title-1').trigger('change');
    }
  });

  //Default value in Textbox
  if ($('#fw_list_wraper').length > 0 || $('#hw_list_wraper').length > 0) {
    filter_view();
  }

  //GATEWAY-2773 software list page 
  $('#views-exposed-form-softwarelist-page-1 #edit-field-device-type-nid').change(function() {
    hide_hardware_filter_by_device_type_version();
    //update hardware filter 
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
      data: {value: $('#edit-field-device-type-nid').val()},
      success: function(ret) {
        //alert('ret '+ret);
        //window.location.href=ret+"?field_device_type_nid="+$('#edit-field-device-type-nid').val();
        $('#edit-field-hw-type-nid').val('All');
        $('#views-exposed-form-softwarelist-page-1 #edit-field-hw-type-nid').trigger('change');
        $('#edit-title-1').val('All');
        $('#edit-filter-hidden-hwverson').val('');
        $('#views-exposed-form-softwarelist-page-1 #edit-title-1').trigger('change');
      }
    });
  });

  $('#views-exposed-form-softwarelist-page-1 #edit-field-hw-type-nid').trigger('change');

// For Button blur/Active state
  var checked = "0";
  checkTBfilled();

  $('#edit-field-sw-type-nid-nid').change(function() {
    if ($('#edit-field-sw-type-nid-nid>option:selected').val() == 0) {
      $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
      $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
    } else {
      checkTBfilled();
    }
  });

  $('input').each(function() {
    $(this).blur(function() {
      checkTBfilled();
    });
  });

  /**
   * custom ahah.js
   * Handler for the form redirection submission.
   */
  Drupal.ahah.prototype.beforeSubmit = function(form_values, element, options) {
    // Disable the element that received the change.
    $(this.element).addClass('progress-disabled').attr('disabled', true);
    //autorefersh confirm
    if ($('#node-form').attr('method') == 'post') {
      window.onbeforeunload = function() {
        return "";
      };
    }
    // Insert progressbar or throbber.
    if (this.progress.type == 'bar') {
      var progressBar = new Drupal.progressBar('ahah-progress-' + this.element.id, eval(this.progress.update_callback), this.progress.method, eval(this.progress.error_callback));
      if (this.progress.message) {
        progressBar.setProgress(-1, this.progress.message);
      }
      if (this.progress.url) {
        progressBar.startMonitoring(this.progress.url, this.progress.interval || 1500);
      }
      this.progress.element = $(progressBar.element).addClass('ahah-progress ahah-progress-bar');
      this.progress.object = progressBar;
      $(this.element).after(this.progress.element);
    }
    else if (this.progress.type == 'throbber') {
      this.progress.element = $('<div class="ahah-progress ahah-progress-throbber"><div class="throbber">&nbsp;</div></div>');
      if (this.progress.message) {
        $('.throbber', this.progress.element).after('<div class="message">' + this.progress.message + '</div>')
      }
      $(this.element).after(this.progress.element);
    }
  };

  /**
   * Custom ahah.js
   * Handler for the form redirection completion.
   */
  Drupal.ahah.prototype.success = function(response, status) {
    var wrapper = $(this.wrapper);
    var form = $(this.element).parents('form');
    // Manually insert HTML into the jQuery object, using $() directly crashes
    // Safari with long string lengths. http://dev.jquery.com/ticket/1152
    var new_content = $('<div></div>').html(response.data);

    // Restore the previous action and target to the form.
    form.attr('action', this.form_action);
    this.form_target ? form.attr('target', this.form_target) : form.removeAttr('target');
    this.form_encattr ? form.attr('target', this.form_encattr) : form.removeAttr('encattr');

    // Remove the progress element.
    if (this.progress.element) {
      $(this.progress.element).remove();
    }
    if (this.progress.object) {
      this.progress.object.stopMonitoring();
    }
    $(this.element).removeClass('progress-disabled').attr('disabled', false);
    //autorefersh confirm
    //commented to have alter window.onbeforeunload = null;
    // Add the new content to the page.
    Drupal.freezeHeight();
    if (this.method == 'replace') {
      wrapper.empty().append(new_content);
    }
    else {
      wrapper[this.method](new_content);
    }

    // Immediately hide the new content if we're using any effects.
    if (this.showEffect != 'show') {
      new_content.hide();
    }

    // Determine what effect use and what content will receive the effect, then
    // show the new content. For browser compatibility, Safari is excluded from
    // using effects on table rows.
    if (($.browser.safari && $("tr.ahah-new-content", new_content).size() > 0)) {
      new_content.show();
    }
    else if ($('.ahah-new-content', new_content).size() > 0) {
      $('.ahah-new-content', new_content).hide();
      new_content.show();
      $(".ahah-new-content", new_content)[this.showEffect](this.showSpeed);
    }
    else if (this.showEffect != 'show') {
      new_content[this.showEffect](this.showSpeed);
    }

    // Attach all javascript behaviors to the new content, if it was successfully
    // added to the page, this if statement allows #ahah[wrapper] to be optional.
    if (new_content.parents('html').length > 0) {
      Drupal.attachBehaviors(new_content);
    }

    Drupal.unfreezeHeight();
  };

  /**
   * Custom
   * Handler for the form redirection error.
   */
  Drupal.ahah.prototype.error = function(response, uri) {
    console.log(Drupal.ahahError(response, uri));
    // Resore the previous action and target to the form.
    $(this.element).parent('form').attr({action: this.form_action, target: this.form_target});
    // Remove the progress element.
    if (this.progress.element) {
      $(this.progress.element).remove();
    }
    if (this.progress.object) {
      this.progress.object.stopMonitoring();
    }
    // Undo hide.
    $(this.wrapper).show();
    // Re-enable the element.
    $(this.element).removeClass('progess-disabled').attr('disabled', false);
    //autorefersh confirm
    window.onbeforeunload = null;
  };

  switch_display_area();
  move_table_item_right('left_hc_table', 'right_hc_table');
  move_table_item_right('left_fc_table', 'right_fc_table');
  move_hardware_item_right();
  //order language. English US English International English
  SortLanguageOption('select#edit-field-sw-language-nid-nid', $('#software_id').val());

  //if status is Archived show a box
  $('#edit-field-sw-status-nid-nid').change(function() {
    /*if ($('#edit-field-sw-status-nid-nid option:selected').text() == Drupal.t('Archived')) {
     if (confirm(Drupal.t('Archived software will be removed from appearing in \nthe search results. However, you can check the \n"Show Software with Archived Status" check box to see it in the list.\nAre you sure you want to Archive this software?'))) {
     }
     }*/
    //GATEWAY-2934 check parent status
    check_parent_status($(this), $('#software_id').val());
  });

  //GATEWAY-1040
  $('#sw_upload_localize_but').blur(function() {
    $('#no_file').focus();
  });

  //GATEWAY-2674
  $('form').submit(function() {
    $('form #edit-submit').attr('class', 'non_active_blue');
    $('form #edit-submit').hide();
  });


});
//document ready end

function checkTBfilled() {
  //form validate
  if (check_relation() && checkfileupload() && check_input_text()) {
    $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
    $('form[id="node-form"] #edit-submit').attr("disabled", false);
    $('#hardware-message').html('<br/>');
    return true;
  } else {
    $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
    $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
    return false;
  }
}

function check_input_text() {
  $('#node-form').find('input.required').each(function() {
    var this_id = $(this).attr('id');
    var this_val = $(this).val();
    if (this_id != 'edit-field-sw-description-0-value' && this_id != 'edit-field-sw-integrity-check-0-value' && this_id != 'crc') {
      if (this_val == $(this).attr('title') || this_val == '') {
        return false;
      }
    }
  });
  if ($('#sw_priority').val() == '') {
    return false;
  }
  return true;
}

function check_relation() {
  // For checkbox
  //GATEWAY-2877 not display config selection and not check 3.0 version relation 
  var deviceTypeName = $.trim($('#edit-field-device-type-nid-nid').find('option:selected').text());
  var gatewaySupportVersion = deviceTypeRelation[deviceTypeName];
  var n = $("#right_hc_table input[type='checkbox']").length + $("#right_hardware_table input[type='checkbox']").length;
  //check 2.0 relation and check software type 
  if ((n == 0 && (gatewaySupportVersion <= '2.0'))) {
    //$('#hardware-message').html('You must select/add hardware/HW configuration.');
    return false;
  } else {
    return true;
  }
}

//sprint 7
function filenmcopy() {
  var getfilepath = $('#edit-field-sw-file-0-upload').val();
  var getfilename = getfilepath.replace("C:\\fakepath\\", "");
  $('#sw_upload_localize_path').val(getfilename);
}

function checkfileupload() {
  //sprint 7
  if ($('#edit-field-sw-file-0-filefield-upload').val() == 'Upload' && $('#sw_upload_localize_path').attr('type') != 'text') {
    $('#edit-field-sw-file-0-upload-wrapper .filefield-upload').prepend('<input type="text" id="sw_upload_localize_path" style="width:125px;" readonly="readonly"><input type="button" id="sw_upload_localize_but" value="' + Drupal.t('Browse') + '" style="height:auto;">');
    $('#edit-field-sw-file-0-upload').change(function() {
      filenmcopy();
    });
  }
  //edit-field-sw-file-0-upload-wrapper
  var fid = $('#edit-field-sw-file-0-fid').val();
  //check the no file or has file
  if ((fid != 0 && fid != '') || $('#no_file').attr('checked')) {
    return true;
  }
  return false;
}
// Function For Button blur/Active state -- ENDS

Drupal.behaviors.covidien_sw = function(context) {
  $('#edit-field-sw-file-0-filefield-remove').mousedown(function() {
    var nodeaction = $('#edit-field-device-type-nid-nid').attr("disabled");
    if (!nodeaction) {
      $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
//            $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
    }
  });
  $('#edit-field-sw-file-0-filefield-upload').mousedown(function() {
    checkTBfilled();
  });
  // Attach a click event to each checkbox so that we can re-evaluate the
  // state of the header checkbox when all items are checked/unchecked.
  $('input:checkbox').click(function() {

    var refid = $(this).attr('value');
    var refname = $(this).attr('refhidden');
    if ($(this).attr('checked')) {
      $('#' + refname + 'hidden').append($('<input type="checkbox" class="form-checkbox" checked="checked" value="' + refid + '" id="edit-field-' + refname + '-nid-nid-' + refid + '" name="field_' + refname + '[nid][nid][' + refid + ']">'));

    } else {
      $('#edit-field-' + refname + '-nid-nid-' + refid).remove();
    }
    checkTBfilled();
  });

  if (context == '#hw_list_wraper' || context == '[object HTMLDocument]') {
    if (context == '[object HTMLDocument]') {
      /*
       $('#edit-submit').click(function(){    
       var status =$('#edit-field-sw-status-nid-nid option:selected').html();
       if(status == Drupal.t('Archived')){
       if(!confirm(Drupal.t('Archived software will be removed from appearing in \nthe search results. However, you can check the \n"Show Software with Archived Status" check box to see it in the list.\nAre you sure you want to Archive this software?'))){return false;}
       }
       });
       */
    }
    $('#hw_list_wraper .pager a').click(function(e) {
      e.preventDefault();
      var tmphref = this.href.split('page=');
      if (!IsNumeric(tmphref[1])) {
        var page = 0;
      } else {
        var page = tmphref[1];
      }
      $('#edit-hw-list-page').val(page);
      filter_view();
    });

//for Hardware title sort
    $("a[id^='hw-list-sort-']").click(function() {
      var sort = $(this).attr('sort');
      var order = $(this).attr('order');
      var ico = $(this).children('#sort-ico').attr('src');
      if (sort == 'descending') {
        $(this).children('#sort-ico').attr('src', Drupal.settings.basePath + 'misc/arrow-asc.png');
        $('#edit-hw-list-sort').val('desc');
        $('#edit-hw-list-order').val(order);
        filter_view();
      } else {
        $(this).children('#sort-ico').attr('src', Drupal.settings.basePath + 'misc/arrow-desc.png');
        $('#edit-hw-list-sort').val('asc');
        $('#edit-hw-list-order').val(order);
        filter_view();
      }
    });

  }
  checkTBfilled();
  //GATEWAY-1728 can use @_- 
  //var filter_specialChars = "^[a-zA-Z0-9\. ]+$"; //white list
  $('input[type="text"]').bind('paste', function() {
    idval = $(this).attr('id');
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
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8) && (event.keyCode != 9)) {
      event.preventDefault();
      return false;
    }
  });
  $('#softwarelist_page1 #edit-title').bind('blur', function() {
    var val = $(this).val();
    if (val == "") {
      $(this).val(Drupal.t("Search - Enter Software Name"));
      $(this).attr('title', Drupal.t("Search - Enter Software Name"));
    }
  });
};

Drupal.covidien_sw = Drupal.covidien_sw || {};
/**  
 * An ajax responder that accepts a packet of JSON data and acts appropriately.
 *
 * The following fields control behavior.
 * - 'display': Display the associated data in the view area.
 */
Drupal.covidien_sw.Ajax = function(target, response) {
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
  hw_retainchecked();
};

function hw_retainchecked() {
  /**    
   * To Retain the check
   */
  var refname = 'hw_list';
  $('input[name^="field_' + refname + '[nid][nid]"]').each(function() {
    $('#edit-viewfield-' + refname + '-nid-nid-' + $(this).val()).attr('checked', 'checked');
  });

  /*****************   Retain the checkEnd     ****************/
}

function fw_retainchecked() {
  //To Retain the check
  var refname = 'fw_list';
  $('input[name^="field_' + refname + '[nid][nid]"]').each(function() {
    $('#edit-viewfield-' + refname + '-nid-nid-' + $(this).val()).attr('checked', 'checked');
  });
  //Retain the checkEnd
}

var ajax_result_callback = function(data) {
  var result = Drupal.parseJson(data);
  jQuery('#hw_list_wraper').html(result.view_output);
  hw_retainchecked();
  Drupal.attachBehaviors('#hw_list_wraper'); //Don't forget this !!!
  $("a[id^='hw-list-sort-'] img").hide();
  var order = $('#edit-hw-list-order').val();
  $("a[id='hw-list-sort-" + order + "'] img").show();
  move_hardware_item_right();
}

function filter_view() {
  var sort = $('#edit-hw-list-sort').val();
  var order = $('#edit-hw-list-order').val();
  var page = $('#edit-hw-list-page').val();

  move_hardware_item_right();
  move_table_item_right('left_hc_table', 'right_hc_table');
  move_table_item_right('left_fc_table', 'right_fc_table');
  var arg1 = $('#edit-filter-hw-type').val();
  var arg2 = $('#edit-field-device-type-nid-nid').val();
  jQuery.get(Drupal.settings.basePath + 'covidien/software/ajax/hw_list/' + arg1 + '/' + sort + '/' + order + '/' + page + '/' + arg2, null, ajax_result_callback);

  $('table#right_hardware_table input[type=checkbox]').attr("checked", true);
  $('table#right_hc_table input[type=checkbox]').attr("checked", true);
  $('table#right_fc_table input[type=checkbox]').attr("checked", true);
  // preventing entire page from reloading
  return false;
}

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function vlex_business_rules() {
  //GATEWAY-1733 VLEX Client not use Business Rules
  if ($('#edit-field-device-type-nid-nid').find("option:selected").text() == 'VLEX Client') {
    $('#edit-field-sw-type-nid-nid').find('option[text="Business Rules"]').next().addClass('color_options');
    $('#edit-field-sw-type-nid-nid').find('option[text="Business Rules"]').remove();
  } else {
    $('#edit-field-sw-type-nid-nid').html(software_type_html);
  }
  return false;
}

function swcatlogconfirm() {
  $('table#left_table input[type=checkbox]').attr("checked", false);
  $('table#right_hc_table input[type=checkbox]').attr("checked", true);
  $('table#right_fc_table input[type=checkbox]').attr("checked", true);
  $('table#left_hardware_table input[type=checkbox]').attr("checked", false);
  $('table#right_hardware_table input[type=checkbox]').attr("checked", true);
  $('#left_hardware_table input[type=checkbox]:checked').each(function() {
    $('#left_hardware_table').find('input[type=checkbox]:checked').attr('checked', false);
    var field_input = $(this)[0].id.replace('view', '');
    $('#hw_listhidden').find('#' + field_input).remove();
  });

  $('#left_hc_table input[type=checkbox]:checked').each(function() {
    $('#left_hc_table').find('input[type=checkbox]:checked').attr('checked', false);
    var field_input = $(this)[0].id.replace('view', '');
    $('#hw_listhidden').find('#' + field_input).remove();
  });
  $('#left_fc_table input[type=checkbox]:checked').each(function() {
    $('#left_fc_table').find('input[type=checkbox]:checked').attr('checked', false);
    var field_input = $(this)[0].id.replace('view', '');
    $('#hw_listhidden').find('#' + field_input).remove();
  });

}

function switch_display_area() {
  var deviceTypeName = $.trim($('#edit-field-device-type-nid-nid').find('option:selected').text());
  var gatewaySupportVersion = deviceTypeRelation[deviceTypeName];


  if (gatewaySupportVersion <= '2.0') {
    $('#hardware_selection_header').css('display', '');
    $('#hardware_selection_body').css('display', '');
    $('#hardware_selection_footer').css('display', '');
    $('#hw_cfg_selection_header').css('display', 'none');
    $('#hw_cfg_selection_footer').css('display', 'none');
    $('#fw_cfg_selection_header').css('display', 'none');
    $('#fw_cfg_selection_footer').css('display', 'none');
  } else if (gatewaySupportVersion >= '2.1') {
    $('#hardware_selection_header').css('display', 'none');
    $('#hardware_selection_body').css('display', 'none');
    $('#hardware_selection_footer').css('display', 'none');
    //GATEWAY-2877 not display config selection 
    $('#hw_cfg_selection_header').css('display', 'none');
    $('#hw_cfg_selection_footer').css('display', 'none');
    $('#fw_cfg_selection_header').css('display', 'none');
    $('#fw_cfg_selection_footer').css('display', 'none');
  } else {
    $('#hardware_selection_header').css('display', 'none');
    $('#hardware_selection_body').css('display', 'none');
    $('#hardware_selection_footer').css('display', 'none');
    $('#hw_cfg_selection_header').css('display', 'none');
    $('#hw_cfg_selection_footer').css('display', 'none');
    $('#fw_cfg_selection_header').css('display', 'none');
    $('#fw_cfg_selection_footer').css('display', 'none');
  }
}

function get_hardware_config_list() {
  var software_id = $('#software_id').val();
  var device_id = $('#edit-field-device-type-nid-nid').val();
  var data = {'device_type_id': device_id, 'software_id': software_id};
  jQuery.get(Drupal.settings.basePath + 'covidien/software/ajax_get_hw_config_list', data, get_hardware_config_list_callback);
}

function get_hardware_config_list_callback(data) {
  var result = Drupal.parseJson(data);
  if (result.status == 'success') {
    $('#hc_list_wraper').html(result.data);
  }
  move_table_item_right('left_hc_table', 'right_hc_table');
}

function get_firmware_config_list() {
  var software_id = $('#software_id').val();
  var device_id = $('#edit-field-device-type-nid-nid').val();
  var data = {'device_type_id': device_id, 'software_id': software_id};
  jQuery.get(Drupal.settings.basePath + 'covidien/software/ajax_get_fw_config_list', data, get_firmware_config_list_callback);
}

function get_firmware_config_list_callback(data) {
  var result = Drupal.parseJson(data);
  if (result.status == 'success') {
    $('#fc_list_wraper').html(result.data);
  }
  move_table_item_right('left_fc_table', 'right_fc_table');
}

function move_table_item_right(left_id, right_id) {
  $('table#' + left_id + ' tr').each(function(event) {
    var this_checked = false;
    var seleted_id = [];
    $(this).find('input[type=checkbox]:checked').each(function(evt) {
      this_checked = true;
      seleted_id[evt] = $(this)[0].id;
    });

    if (this_checked) {
      var tr_str = $(this).html();
      $('#' + right_id).append('<tr>' + tr_str + '</tr>');
      $('#' + right_id).find('#' + seleted_id[0]).attr('checked', false);
      $(this).remove();
    }
  });
  checkTBfilled();
}

function move_table_item_left(left_id, right_id) {
  $('#' + right_id + ' input[type=checkbox]:checked').each(function(event) {
    var td_str = $(this).parent().parent().html();
    $('#' + left_id).append('<tr>' + td_str + '</tr>');
    $('#' + left_id).find('input[type=checkbox]:checked').attr('checked', false);
    $(this).parent().parent().remove();
  });
  checkTBfilled();
}


function move_hardware_item_right() {
  $('table#left_hardware_table tr').each(function(event) {
    var this_checked = false;
    var seleted_id = [];
    $(this).find('input[type=checkbox]:checked').each(function(evt) {
      this_checked = true;
      seleted_id[evt] = $(this)[0].id;
    });

    if (this_checked) {
      var tr_str = $(this).html();
      $('#right_hardware_table').append('<tr>' + tr_str + '</tr>');
      $('#right_hardware_table').find('#' + seleted_id[0]).attr('checked', false);
      $(this).remove();
    }
  });
  checkTBfilled();
}

function move_hardware_item_left() {
  $('#right_hardware_table input[type=checkbox]:checked').each(function(event) {
    var td_str = $(this).parent().parent().html();
    $('#left_hardware_table').append('<tr>' + td_str + '</tr>');
    $('#left_hardware_table').find('input[type=checkbox]:checked').attr('checked', false);
    var field_input = $(this)[0].id.replace('view', '');
    $('#hw_listhidden').find('#' + field_input).remove();
    $(this).parent().parent().remove();
  });
  checkTBfilled();
}

function hide_hardware_filter_by_device_type_version() {
  var hardware_div = $('#hardware-filter-div');
  var deviceTypeName = $.trim($('#edit-field-device-type-nid option:selected').text());
  var gatewaySupportVersion = deviceTypeRelation[deviceTypeName];
  if (!hardware_div.length) {
    return false;
  }
  var display_switch = false;
  $('#edit-field-device-type-nid option').each(function() {
    var this_name = $.trim($(this).text());
    if (deviceTypeRelation[this_name] && deviceTypeRelation[this_name] < '3.0') {
      display_switch = true;
    }
  });
  if (display_switch) {
    hardware_div.show();
  } else {
    hardware_div.hide();
  }
  //if this device type version greater than 2.1, hide hardware filter form
  if (gatewaySupportVersion) {
    if (gatewaySupportVersion >= '2.1') {
      hardware_div.hide();
    } else {
      hardware_div.show();
    }
  }
  return false;
}