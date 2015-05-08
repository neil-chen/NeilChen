$(document).ready(function() {
  var device_type_hidden = 0;
  var edit_customer_name = 0;

  var formid = "#software-upgrade-report-form";
  $(formid + " #edit-product-line").ajaxStop(function() {
    var wrapper = '#' + Drupal.settings.ahah[$(this).attr('id')].wrapper;
    $(wrapper).html($(wrapper + ' div').html());
    $('#edit-device-type').val($('#edit-device-type-hidden').val());
    if ($('#edit-device-type').val() != 'all' && device_type_hidden != 1) {
      $(formid + ' #edit-device-type').trigger('change');
      device_type_hidden = 1;
    }
  });
  $(formid + ' #edit-product-line').trigger('change');
  $(formid + ' select').change(function() {
    child_reset($(this).attr('id'));
    $('select option:nth-child(2n+1)').addClass('color_options');
  });
});

function child_reset(id) {
  var formid = "#software-upgrade-report-form";
  switch (id) {
    case 'edit-product-line':
    case 'edit-device-type':
      $('#edit-device-type-hidden').val($('#edit-device-type').val());
    case 'edit-customer-name':
    case 'edit-account-number':
  }
  return true;
}