
/**
 * Attaches the calendar behavior to all required fields
 */
Drupal.behaviors.date_popup = function(context) {
  for (var id in Drupal.settings.datePopup) {
    $('#' + id).bind('focus', Drupal.settings.datePopup[id], function(e) {
      if (!$(this).hasClass('date-popup-init')) {
        var datePopup = e.data;
        //GATEWAY-2807 use add we can use minDate and maxDate 
        if (datePopup.settings.minDate) {
          datePopup.settings.minDate = eval(datePopup.settings.minDate);
        }
        if (datePopup.settings.maxDate) {
          datePopup.settings.maxDate = eval(datePopup.settings.maxDate);
        }
        // Explicitely filter the methods we accept.
        switch (datePopup.func) {
          case 'datepicker':
            $(this)
                    .datepicker(datePopup.settings)
                    .addClass('date-popup-init')
            $(this).click(function() {
              $(this).focus();
            });
            break;

          case 'timeEntry':
            $(this)
                    .timeEntry(datePopup.settings)
                    .addClass('date-popup-init')
            $(this).click(function() {
              $(this).focus();
            });
            break;
        }
      }
    });
  }
};
