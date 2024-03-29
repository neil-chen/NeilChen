// $Id: $

Drupal.behaviors.pluploadBuild = function(context) {
  Date.now = Date.now || function() {
    return +new Date;
  };
  var timestemp = Date.now();
  // Setup uploader pulling some info out Drupal.settings
  $("#uploader").pluploadQueue({
    // General settings
    runtimes: 'html5,flash,html4',
    url: Drupal.settings.plupload.url + '?node_type=' + $('#node_type').val() + '&time=' + timestemp,
    max_file_size: '10000mb',
    chunk_size: '500kb',
    max_retries: '3',
    unique_names: false
            //flash_swf_url: Drupal.settings.plupload.swfurl + '?node_type=' + $('#node_type').val() + '&time=' + timestemp
            // Specify what files to browse for
            /*GATEWAY-3105 not use filter
             filters: [
             {title: "Files", extensions: Drupal.settings.plupload.extensions}
             ]*/
  });
};

Drupal.behaviors.pluploadSuccess = function(context) {
  var totalUploadFiles = 0;
  var upload = $('#uploader').pluploadQueue();

  upload.bind('FileUploaded', function(up, file, info) {
    //Called when file has finished uploading
    $('#sw_upload_localize_path').val(file.name);
    $('#file_name').html(file.name);
    info = Drupal.parseJson(info.response);
    $('#edit-field-sw-file-0-fid').val(info.id);
    $('#no_file').attr('checked', false);
    $('#uploader').hide();
    $('#remover').show();
    $('.ahah-progress.ahah-progress-throbber').hide();
    $('#filesize').val(file.size);
    //use backend check
    software_check_file_size(info.id, file.size);
    checkTBfilled();
  });

  upload.bind('ChunkUploaded', function(up, file, info) {
    if ((info.status != 200) || (info.response == 'u_x00') || (info.response == 'u_x01')) {
      console.log("info.status = " + info);
    }
  });

  upload.bind('QueueChanged', function(up, files) {
    totalUploadFiles = upload.files.length;
    //if add new file replace old file 
    for (i = 0; i < totalUploadFiles; i++) {
      if (i != (totalUploadFiles - 1))
        up.removeFile(up.files[i]);
    }
  });

  //add by neil 
  if ($('#edit-field-sw-file-0-fid').val() != 0 && $('#edit-field-sw-file-0-fid').val() != '') {
    $('#uploader').hide();
    $('#remover').show();
    $('#file_name').html($('.filename .filefield-file').html());
  }
  var file_remove = $('#file_remove');
  file_remove.click(function() {
    $('.ahah-progress.ahah-progress-throbber').show();
    $('#filesize').val(0);
    var fid = $('#edit-field-sw-file-0-fid').val();
    $.get(Drupal.settings.basePath + 'plupload-file-remove/' + fid, function(info) {
      var info = Drupal.parseJson(info);
      //refresh  plupload 
      $(".plupload_buttons").css("display", "inline");
      $(".plupload_upload_status").css("display", "inline");
      upload.splice();
      upload.refresh();
      //show plupload 
      $('#uploader').show();
      $('#remover').hide();
      $('#.ahah-progress.ahah-progress-throbber').hide();
      $('#edit-field-sw-file-0-fid').val(0);
      $('#no_file').attr('checked', true);
      checkTBfilled();
    });
  });

};

function software_check_file_size(fid, filesize) {
  $.get(Drupal.settings.basePath + 'covidien/software/ajax_get_file_size/' + fid, function(resp) {
    var data = Drupal.parseJson(resp);
    if (data.filesize != filesize) {
      console.log('Received file size (' + filesize + ') is not same as original (' + data.filesize + '), please re-upload.');
      //$('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
      //$('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
      return false;
    } else {
      //$('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
      //$('form[id="node-form"] #edit-submit').attr("disabled", false);
      //$('#hardware-message').html('<br/>');
      return true;
    }
  });
  return false;
}
