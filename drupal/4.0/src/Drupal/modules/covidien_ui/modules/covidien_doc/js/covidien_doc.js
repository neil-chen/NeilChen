$(document).ready(function() {
  if ($('#document_id').val()) {
    $('#global_product_line').attr("disabled", "disabled");
  }
  //initial relation between device type and gateway version.
  if ($('#device_type_relation').val()) {
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
  if ($('#document_page1').children('#edit-title-wrapper').children('input#edit-title').val() == '') {
    $('#document_page1').children('#edit-title-wrapper').children('input#edit-title').val(Drupal.t('Search - Enter document Title'));
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
  update_device_type_by_product_line('#edit-field-device-type-nid-nid', 'not all');

  SortLanguageOption('select#edit-field-document-language-nid-nid', $('#document_id').val());
  // Default value in Textbox
  // Show hw sw fw by device type
  filter_show_item_check_table();
  $('#edit-field-device-type-nid-nid').change(function() {
    filter_show_item_check_table();
  });

  $('#edit-go').click(function() {
    $('#edit-doc-sw-list-page').val(0);
    filter_view_doc_sw_filter();
  });
  $('#edit-filter-type-go').click(function() {
    $('#edit-doc-hw-list-page').val(0);
    filter_view_doc_hw_list();
  });
  $('#edit-go').click(function() {
    $('#edit-doc-sw-list-page').val(0);
    filter_view_doc_sw_filter();
  });
  $('#edit-filter-type-go').click(function() {
    $('#edit-doc-hw-list-page').val(0);
    filter_view_doc_hw_list();
  });
  $('#edit-field-document-language-nid-nid').change(function() {
    $('#edit-filter-lang').val($(this).val());
    filter_view_doc_sw_filter();
  });
  $('#edit-filter-lang').val($('#edit-field-document-language-nid-nid').val());

  $("#views-exposed-form-documentlist-page-1 #edit-field-hw-type-nid").ajaxStop(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
    if ($('#edit-field-doc-hw-list-nid').val() == '') {
      $('#edit-title-2').val('');
      $('#edit-field-hw-version-value').val('');
    }
  });

  $("#views-exposed-form-documentlist-page-1 #edit-field-device-type-nid").ajaxStop(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div select').html());
  });

  function filterconfigtitle() {
    $('#edit-field-config-value').change(function() {
      var formdata = $('#views-exposed-form-documentlist-page-1').serialize();
      formdata += '&field_config_value=' + $(this).val();
      $.ajax({
        type: "POST",
        url: Drupal.settings.basePath + "ahah-dochwtype-exposed-callback",
        data: formdata,
        success: function(response) {
          var wrapper = '#edit-field-hw-type-nid';
          var result = Drupal.parseJson(response);
          $(wrapper).html(result.data);
          $(wrapper).html($(wrapper + ' div').html());
          $(wrapper).val('All');
          $('#edit-title-1').val('All');
          $('#edit-field-sw-status-nid').val('All');
          $('#views-exposed-form-documentlist-page-1 #edit-field-hw-type-nid').trigger('change');
          $('#views-exposed-form-documentlist-page-1 #edit-title-1').trigger('change');
        }
      });
    });
  }

  filterconfigtitle();

  $('#views-exposed-form-documentlist-page-1 #edit-field-device-type-nid').change(function() {
    var formdata = $('#views-exposed-form-documentlist-page-1').serialize();
    formdata += '&field_device_type_nid_value=' + $(this).val();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "ahah-conflist-exposed-callback",
      data: formdata,
      success: function(response) {
        var result = Drupal.parseJson(response);
        $('#edit-field-config-value-wrapper').html(result.data);
        filterconfigtitle();
      }
    });

    $('#edit-field-hw-type-nid').val('All');
    $('#edit-title-1').val('All');
    $('#edit-field-sw-status-nid').val('All');
    $('#views-exposed-form-documentlist-page-1 #edit-field-hw-type-nid').trigger('change');
    $('#views-exposed-form-documentlist-page-1 #edit-title-1').trigger('change');
  });

  filter_hwnamer();
  $('#views-exposed-form-documentlist-page-1 #edit-field-doc-hw-list-nid').trigger('change');
//on page load filter hardware
//filter_view_doc_hw_list();
//filter_view_doc_sw_filter();
// For Button blur/Active state
  var checked = "0";
//checkCBfilled();
  $('input').each(function() {
    $(this).blur(function() {
      checkTBfilled();
    });
  });
  /*
   $('select').each(function(){
   $(this).change(function(){
   checkCBfilled();	});	}); */

//autorefersh confirm

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
    //commented to have confirm window.onbeforeunload = null;
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

  switch_associate_type_selection();

  $('input:submit').click(function() {
    //not checked left table
    $('#left_table_h input:checkbox').attr('checked', false);
    $('#left_table_s input:checkbox').attr('checked', false);
    $('#left_table_f input:checkbox').attr('checked', false);
    //checked right table
    $('#right_table_s input:checkbox').attr('checked', true);
    $('#right_table_f input:checkbox').attr('checked', true);
    $('#right_table_h input:checkbox').attr('checked', true);
  });

  //GATEWAY-2674
  $('form').submit(function() {
    $('form #edit-submit').attr('class', 'non_active_blue');
    $('form #edit-submit').hide();
  });
});
//document ready end 

//Store relation between device type and gateway version.
var deviceTypeRelation = new Object();

// Function For Button blur/Active state -- STARTS
function checkTBfilled(checked) {
  // For Text Box	
  $('#node-form').find('.required').each(function() {
    // ignore id's here
    if ($(this).attr('id') != 'edit-field-document-description-0-value') {
      if (this.value == $(this).attr('title') || this.value == '') {
        $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
        $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
        return false;
      } else {
        $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
        $('form[id="node-form"] #edit-submit').attr("disabled", "");
        var isfile = checkfileupload();
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
    if ($('#edit-field-documnet-type-nid-nid>option:selected').text() == '') {
      $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
      $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
      return false;
    } else {
      $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
      $('form[id="node-form"] #edit-submit').attr("disabled", "");
      checked = "1";
      checkTBfilled(checked);
    }
  });
}

function filenmcopy() {
  var getfilepath = $('#edit-field-document-file-0-upload').val();
  // var getfilename = getfilepath.replace("C:\\fakepath\\", "");
  var getfilename = getfilepath.split('\\').pop();
  $('#document_upload_localize_path').val(getfilename);
  $('#edit-field-document-file-0-upload-wrapper #edit-field-document-file-0-fid').val(1);
}
function checkfileupload() {
  if ($('#edit-field-document-file-0-filefield-upload').val() == 'Upload' && $('#document_upload_localize_path').attr('type') != 'text') {
    $('#edit-field-document-file-0-upload-wrapper .filefield-upload').prepend('<input type="text" id="document_upload_localize_path" style="width:125px;" readonly="readonly"><input type="button" id="document_upload_localize_but" value="' + Drupal.t('Browse') + '" style="height:auto;">');
    /*
     $('#document_upload_localize_but').click(function(e){
     $('#edit-field-document-file-0-upload').click();
     filenmcopy();
     e.preventDefault();
     });*/
    $('#edit-field-document-file-0-upload').change(function() {
      filenmcopy();
    });
  }

//edit-field-sw-file-0-upload-wrapper
  var fid = $('#edit-field-document-file-0-upload-wrapper #edit-field-document-file-0-fid').val();
  var file = $('#edit-field-document-file-0-upload').val();
  if (fid != 0) {
    return true;
  }
  $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
  $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
  return false;
}
// Function For Button blur/Active state -- ENDS

Drupal.behaviors.covidien_doc = function(context) {
  $('#edit-field-document-file-0-filefield-remove').mousedown(function() {
    var nodeaction = $('#edit-field-device-type-nid-nid').attr("disabled");
    if (!nodeaction) {
      $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
      $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
    }
  });
  $('#edit-field-document-file-0-filefield-upload').mousedown(function() {
    checkTBfilled();
  });
//

  if (context == '[object Object]') {
//catalog page
    $('#views-exposed-form-documentlist-page-1 #edit-field-sw-version-value').change(function() {
      $('#edit-field-sw-status-nid').val('All');
    });
    filter_hwnamer();
  }
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
  });

  if (context == '#doc_hw_list_wraper' || context == '[object HTMLDocument]') {
    $('#doc_hw_list_wraper .pager a').click(function(e) {
      e.preventDefault();
      var tmphref = this.href.split('page=');
      if (!IsNumeric(tmphref[1])) {
        var page = 0;
      } else {
        var page = tmphref[1];
      }
      $('#edit-doc-hw-list-page').val(page);
      filter_view_doc_hw_list();
    });
  }

  if (context == '#doc_sw_list_wraper' || context == '[object HTMLDocument]') {
    $('#doc_sw_list_wraper .pager a').click(function(e) {
      e.preventDefault();
      var tmphref = this.href.split('page=');
      if (!IsNumeric(tmphref[1])) {
        var page = 0;
      } else {
        var page = tmphref[1];
      }
      $('#edit-doc-sw-list-page').val(page);
      filter_view_doc_sw_filter();
    });

//For Title sort
    $("a[id^='doc-sw-list-sort-']").click(function() {
      var sort = $(this).attr('sort');
      var order = $(this).attr('order');
      var ico = $(this).children('#sort-ico').attr('src');
      if (sort == 'descending') {
        $(this).children('#sort-ico').attr('src', Drupal.settings.basePath + 'misc/arrow-asc.png');
        $('#edit-doc-sw-list-sort').val('desc');
        $('#edit-doc-sw-list-order').val(order);
        filter_view_doc_sw_filter();
      } else {
        $(this).children('#sort-ico').attr('src', Drupal.settings.basePath + 'misc/arrow-desc.png');
        $('#edit-doc-sw-list-sort').val('asc');
        $('#edit-doc-sw-list-order').val(order);
        filter_view_doc_sw_filter();
      }
    });

  }

  if (context == '#doc_hw_list_wraper' || context == '[object HTMLDocument]') {
//for Hardware title sort
    $("a[id^='doc-hw-list-sort-']").click(function() {
      var sort = $(this).attr('sort');
      var order = $(this).attr('order');
      var ico = $(this).children('#sort-ico').attr('src');
      if (sort == 'descending') {
        $(this).children('#sort-ico').attr('src', Drupal.settings.basePath + 'misc/arrow-asc.png');
        $('#edit-doc-hw-list-sort').val('desc');
        $('#edit-doc-hw-list-order').val(order);
        filter_view_doc_hw_list();
      } else {
        $(this).children('#sort-ico').attr('src', Drupal.settings.basePath + 'misc/arrow-desc.png');
        $('#edit-doc-hw-list-sort').val('asc');
        $('#edit-doc-hw-list-order').val(order);
        filter_view_doc_hw_list();
      }
    });
  }
  _retainchecked('doc_hw_list');
  _retainchecked('doc_sw_list');
  _retainchecked('doc_fw_list');
  checkTBfilled();

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
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });
  $('#document_page1 #edit-title').bind('blur', function() {
    var val = $(this).val();
    if (val == "") {
      $(this).val(Drupal.t("Search - Enter document Title"));
      $(this).attr('title', Drupal.t("Search - Enter document Title"));
    }
  });
};

Drupal.covidien_doc = Drupal.covidien_doc || {};
/**
 * An ajax responder that accepts a packet of JSON data and acts appropriately.
 *
 * The following fields control behavior.
 * - 'display': Display the associated data in the view area.
 */
Drupal.covidien_doc.Ajax = function(target, response) {
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
  _retainchecked('doc_hw_list');
  _retainchecked('doc_sw_list');
};

function _retainchecked(refname) {
  /**
   * To Retain the check
   */
  $('input[name^="field_' + refname + '[nid][nid]"]').each(function() {
    $('#edit-viewfield-' + refname + '-nid-nid-' + $(this).val()).attr('checked', 'checked');
  });
  /*****************   Retain the checkEnd     ****************/
}

var ajax_result_callback_sw = function(data) {
  var result = Drupal.parseJson(data);
  jQuery('#' + result.view_id + '_wraper').html(result.view_output);
  _retainchecked(result.view_id);
  Drupal.attachBehaviors('#doc_sw_list_wraper'); //Don't forget this !!!

  $("a[id^='doc-sw-list-sort-'] img").hide();
  var order = $('#edit-doc-sw-list-order').val();
  $("a[id='doc-sw-list-sort-" + order + "'] img").show();

  $('#relation-item-table tr:not(:first)').hide();
  //$('#doc_sw_list_header').show();
  $('#doc_sw_list_body').show();
}
var ajax_result_callback_cfg = function(data) {
  var result = Drupal.parseJson(data);
  jQuery('#' + result.view_id + '_wraper').html(result.view_output);
  jQuery('#' + result.view_id + '_body .pager li').each(function() {
    var url = $(this).find('a').attr('href');
    $(this).find('a').attr('href', '');
    if (url != undefined && url != '') {
      $(this).bind("click", function() {
        return filter_doc_cfg_table(result.view_id, url);
      });
    }
  });
  jQuery('#' + result.view_id + '_body').show();
}

function filter_view_doc_item_list(type) {
  var device_type_id = $('#edit-field-device-type-nid-nid').val();
  var product_line = $('#global_product_line').val();
  var item_id = $('#document_id').val();
  var data = {product_line: product_line, device_type: device_type_id, item_id: item_id};

  jQuery.get(Drupal.settings.basePath + 'named-config/ajax/get-item-table/' + type, data, function(response) {
    var result = Drupal.parseJson(response);
    switch (type) {
      case 'hardware':
        $('#doc_hw_list_wraper').html(result.data);
        move_table_item_right('h');
        break;
      case 'software':
        $('#doc_sw_list_wraper').html(result.data);
        //remove radio box Primary
        $('#doc_sw_list_wraper #right_table_s th:eq(1)').remove();
        $('#doc_sw_list_wraper #left_table_s th:eq(1)').remove();
        $('#doc_sw_list_wraper').find('#left_table_s tbody tr').each(function() {
          $(this).find('td:eq(1)').remove();
        });
        //remove radio box Primary end
        move_table_item_right('s');
        break;
      case 'firmware':
        $('#doc_fw_list_wraper').html(result.data);
        move_table_item_right('f');
        break;
    }
  });
  // preventing entire page from reloading
  return false;
}

function filter_view_doc_sw_filter() {
  var sort = $('#edit-doc-sw-list-sort').val();
  var order = $('#edit-doc-sw-list-order').val();
  var page = $('#edit-doc-sw-list-page').val();
  var arg1 = $('#edit-field-device-type-nid-nid').val();
  var arg2 = $('#edit-filter-lang').val();
  jQuery.get(Drupal.settings.basePath + 'covidien/document/ajax/doc_sw_list/' + arg1 + '/' + sort + '/' + order + '/' + page + '/' + arg2, null, ajax_result_callback_sw);
  // preventing entire page from reloading
  return false;
}

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function filter_hwnamer() {
  $('#edit-field-doc-hw-list-nid').change(function() {
    var value = $(this).val();
    if (value != '') {
      var valr = value.split(' ,r');
      $('#edit-title-2').val(valr[0]);
      $('#edit-field-hw-version-value').val(valr[1]);
    }
  });
}

function switch_display_area(diaplay_id_prefix) {
  var area_hidden_list = ["doc_hw_list", "doc_sw_list", "doc_fw_list"];
  $('#' + diaplay_id_prefix + '_header').show();
  $('#' + diaplay_id_prefix + '_body').show();
  for (i = 0; i < area_hidden_list.length; i++) {
    $('#' + area_hidden_list[i] + '_header').hide();
    $('#' + area_hidden_list[i] + '_body').hide();
    $('#' + area_hidden_list[i] + '_wraper').html(' ');
  }
}

function switch_associate_type_selection() {
  var deviceTypeName = $.trim($('#edit-field-device-type-nid-nid').find('option:selected').text());
  var gatewaySupportVersion = deviceTypeRelation[deviceTypeName];
  if (gatewaySupportVersion == '2.0') {
    $('#doc_assoicate_type_selection option[value="doc_fw_list"]').hide();
  } else {
    $('#doc_assoicate_type_selection option[value="doc_fw_list"]').show();
  }
}

function move_table_item_left(x) {
  if (x == 's') {
    type = "software";
  } else if (x == 'f') {
    type = "firmware";
  }
  $('#right_table_' + x + ' input[type=checkbox][name^=reference_list]:checked').each(function(event) {
    if (x == 's' || x == 'f') {
      //$(this).bind("click", {"type": type, "operation": "remove"}, displayRegulatoryExp);
      $(this).click();
      //$(this).unbind("click", displayRegulatoryExp);
    }
    var td_str = $(this).parent().parent().html();
    $('#left_table_' + x).append('<tr>' + td_str + '</tr>');
    $(this).parent().parent().remove();
  });
  renderTable('right_table_' + x);
  renderTable('left_table_' + x);
  //validateComplete();
}

function move_table_item_right(x) {
  var type = "";
  if (x == 's') {
    type = "software";
  } else if (x == 'f') {
    type = "firmware";
  }
  $('table#left_table_' + x + ' tr').each(function(event) {
    var this_checked = false;
    var seleted_id = [];
    $(this).find('input[type=checkbox]:checked').each(function(evt) {
      this_checked = true;
      seleted_id[evt] = $(this)[0].id;
    });
    if (this_checked) {
      var tr_str = $(this).html();
      $('#right_table_' + x).append('<tr>' + tr_str + '</tr>');
      if (x == 's' || x == 'f') {
        //$('#right_table_' + x).find('#' + seleted_id[0]).bind("click", {"type": type, "operation": "add"}, displayRegulatoryExp);
        $('#right_table_' + x).find('#' + seleted_id[0]).click();
        //$('#right_table_' + x).find('#' + seleted_id[0]).unbind("click", displayRegulatoryExp);
      }
      $('#right_table_' + x).find('#' + seleted_id[0]).attr('checked', true);
      $('#right_table_' + x).find('#' + seleted_id[1]).attr('checked', true);
      $(this).remove();
    }
  });
  renderTable('right_table_' + x);
  renderTable('left_table_' + x);

}

function renderTable(tblId) {
  $('#' + tblId + ' tr').removeClass('even odd');
  $('#' + tblId).each(function() {
    $('tr:odd', this).addClass('odd');
    $('tr:even', this).addClass('even');
  });
}

function filter_show_item_check_table() {
  filter_view_doc_item_list('hardware');
  filter_view_doc_item_list('software');
  filter_view_doc_item_list('firmware');
}