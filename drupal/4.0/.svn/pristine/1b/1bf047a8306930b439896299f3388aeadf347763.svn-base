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
  
});
 
