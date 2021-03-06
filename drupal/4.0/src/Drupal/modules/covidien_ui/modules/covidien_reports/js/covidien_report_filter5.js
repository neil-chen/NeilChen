$(document).ready(function() { 
  //if user field have the value, then disable the customer name and account
  $( "#audit-trial-report #edit-last-name" ).blur(function() { 
    var user = $('#audit-trial-report #edit-last-name').val();  
    var result = check_user_account(user); 
  }); 
  
});
//if user entered in customer name or account, then the user field will get disabled
function disable_field(id){
  var customer_account = $('#audit-trial-report #account_number').val();
  var customer_name = $('#audit-trial-report #customer_name').val();
  if(customer_account || customer_name){
    $('#audit-trial-report #edit-last-name').attr('disabled',true);
    $('#audit-trial-report #edit-last-name').css('background-color', '#dfdfdf');   
  } else {
    $('#audit-trial-report #edit-last-name').attr('disabled',false);
    $('#audit-trial-report #edit-last-name').css('background-color', 'white');  
  } 
}

function check_user_account(email){  
  if (email !== '') {
    arg = '/' + email;
    $.getJSON(Drupal.settings.basePath + 'covidien/reports/check_covidien_or_noncovidien' + arg, function(ret) {  
      if (ret.value === 'yes') {  
        window.setTimeout(function ()
        {
          $('#audit-trial-report #customer_name').attr('disabled',true);
          $('#audit-trial-report #customer_name').css('background-color', '#dfdfdf'); 
          $('#audit-trial-report #account_number').attr('disabled',true);
          $('#audit-trial-report #account_number').css('background-color', '#dfdfdf');   
        }, 0); 
      } else { 
        window.setTimeout(function ()
        {
          $('#audit-trial-report #customer_name').attr('disabled',false);
          $('#audit-trial-report #customer_name').css('background-color', 'white'); 
          $('#audit-trial-report #account_number').attr('disabled',false);
          $('#audit-trial-report #account_number').css('background-color', 'white');  
       }, 0);
      } 
    });
  } 
}