$(document).ready(function() {
  var device_type_hidden = 0;
  var edit_customer_name = 0;
  var edit_trainer = 0;

  var formid = "#training-report-form";
  $(formid + " #edit-product-line").ajaxStop(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
    $('#edit-device-type').val($('#edit-device-type-hidden').val());

    if ($(this).attr('id') == 'edit-product-line' && device_type_hidden != 1) {
      $(formid + ' #edit-device-type').trigger('change');
      device_type_hidden = 1;
    }
  });
  $(formid + " #edit-device-type").ajaxStop(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
    $('#edit-trainer-id').val($('#edit-trainer-id-hidden').val());
    if ($(this).attr('id') == 'edit-device-type' && edit_trainer != 1) {
      $('#edit-trainer-id').trigger('change');
      edit_trainer = 1;
    }
  });
  $(formid + ' #edit-product-line').trigger('change');
  $(formid + ' select').change(function() {
    var id = $(this).attr('id');
    var formid = "#training-report-form";
    switch (id) {
      case 'edit-product-line':
        $('#edit-device-type-hidden').val('');
        device_type_hidden = 0;
      case 'edit-device-type':
        if ($('#edit-device-type').val() == 'all' || ($('#edit-device-type-hidden').val() != $('#edit-device-type').val())) {
          $('#edit-trainer-id-hidden').val('');
        }
        $('#edit-device-type-hidden').val($('#edit-device-type').val());
        edit_trainer = 0;
        edit_customer_name = 0;
      case 'edit-trainer-id':
        if (id == 'edit-trainer-id' && $('#edit-trainer-id').val() != 'all') {
          $('#edit-trainer-id-hidden').val($('#edit-trainer-id').val());
        }
      case 'edit-customer-name':
      case 'edit-account-number':
    }
    $('select option:nth-child(2n+1)').addClass('color_options');
  });

});
