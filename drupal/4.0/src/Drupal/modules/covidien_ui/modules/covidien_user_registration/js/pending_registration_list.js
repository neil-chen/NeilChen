$(document).ready(function() {
  //use this for Pending Registration Page
  $(".training_detail").click(function(event){  
     var nid = $(this).attr('data') 
      var arg = '';  
      if (nid != '') { 
        arg = '/' + nid;
         $.ajax({
          url: Drupal.settings.basePath + 'covidien/self/view-training-records' + arg,
          /*
          beforeSend: function() {
             $('#logo').css('background', 'url(images/ajax-loader.gif) no-repeat')
          },
          complete: function(){
             $('#logo').css('background', 'none')
          },*/
          success: function(data) {  
            $('#training-dialog').html(data);
            $('.ui-dialog').width(600);
          }
        }); 
      } 
     $("#training-dialog").dialog();
     event.preventDefault();
  });  
  
  
  //use this for archive user 
  $(".archived").click(function(event){
      
      var c = confirm("Are you sure you want to archive this register?");
      if(c == true){ 
        var nid = $(this).attr('data') 
        var arg = '';  
        if (nid != '') { 
          arg = '/' + nid;
           $.ajax({
            url: Drupal.settings.basePath + 'covidien/self/archive' + arg, 
            success: function(data) {  
              location.reload();
            }
          }); 
        } 
      }
      event.preventDefault();
  });  
  
  
  //use this to resend approved email covidien/self/email
  $(".resend_email").click(function(event){
      
      var c = confirm("Are you sure you want to resend another email to this register?");
      if(c == true){ 
        var nid = $(this).attr('data') 
        var arg = '';  
        if (nid != '') { 
          arg = '/' + nid;
           $.ajax({
            url: Drupal.settings.basePath + 'covidien/self/email' + arg, 
            success: function(data) {   
              alert('email had been sent to this user');
            }
          }); 
        } 
      }
      event.preventDefault();
  }); 
  
  
});
 
