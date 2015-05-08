$(document).ready(function() {

// For Button blur/Active state
  var checked = "0";
  checkCBfilled();
  $('select').each(function() {
    $(this).change(function() {
      checkCBfilled();
    });
  });
});

// Function For Button blur/Active state -- STARTS

function checkCBfilled() {
  $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
  $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
  // For select box
  $('select').each(function() {
    if ($('#edit-field-reg-approved-country-nid-nid>option:selected').text() == 'Select Country') {
      $('form[id="node-form"] #edit-submit').attr('class', 'non_active_blue');
      $('form[id="node-form"] #edit-submit').attr("disabled", "disabled");
      return false;
    } else {
      $('form[id="node-form"] #edit-submit').attr('class', 'form-submit');
      $('form[id="node-form"] #edit-submit').attr("disabled", "");
      checked = "1";
    }
  });
}
// Function For Button blur/Active state -- ENDS
