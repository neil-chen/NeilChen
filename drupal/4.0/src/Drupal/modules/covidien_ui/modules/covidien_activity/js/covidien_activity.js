Drupal.behaviors.covidien_activity = function(context) {
  $('input[type="text"]').bind('paste', function() {
    idval = $(this).attr('id');
    setTimeout(
      function setvalue() {
        var regex = new RegExp(filter_specialChars);
        var isValid = regex.test($('#' + idval).val());
//					alert(isValid);
        if (!isValid) {
          $('#' + idval).val('');
          return false;
        }
      }, 100);
  });
};