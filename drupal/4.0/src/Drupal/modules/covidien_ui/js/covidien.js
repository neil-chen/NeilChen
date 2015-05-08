// For Login screen - Reset textbox to prevent successive attempts
$(document).ready(function() {
  $('.login_process input[type=text]').focus(function() {
    var val = $(this).val();
    if (val == "Username (email address)") {
      $(this).val('');
    }
  });
  $('.login_process input[type=password]').focus(function() {
    var val = $(this).val();
    if (val == "Password") {
      $(this).val('');
    }
  });

  // Block Special characters in titles	  
  // Use this function, class name filter-special-chars 
  $('input.filter-special-chars').bind('keypress', function(event) {
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });
});

Drupal.behaviors.covidien_ui = function(context) {
// Block Special characters in titles	  
  $('.oval_search_wraper input').bind('keypress', function(event) {
    var regex = new RegExp(filter_specialChars);
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && (event.keyCode != 8)) {
      event.preventDefault();
      return false;
    }
  });
//IE Longtext option display issue
  $('select').change(function() {
    var id = $(this).attr('id');
    $(this).attr('title', $.trim($('#' + id + ' option:selected').html()));
  });
  //	$("select option").attr( "title", "" );
  $("select option").each(function(i) {
    this.title = this.text;
  });
//

};

function parentSelected(parent, autopath) {
  obj = $("#edit-title");
  if (obj.val() == obj.attr('title')) {
    obj.val('');
    obj.removeClass('text-label');
  }

  // Get the url from the child autocomplete hidden form element
  var url = $("#edit-title").val();
  // Alter it according to parent value  
  url = Drupal.settings.basePath + "covidien/" + autopath + "/autocomplete/" + parent.val();
  // Recreate autocomplete behaviour for the child textfield
  var input = $('#edit-title').attr('autocomplete', 'OFF')[0];
  recreateAutoComplete(input, url);
}

function recreateAutoComplete(input, url) {
  $(input).unbind();
  Drupal.attachBehaviors();
  var acdb = new Drupal.ACDB(url);
  $(input.form).submit(Drupal.autocompleteSubmit);
  new Drupal.jsAC(input, acdb);
}
