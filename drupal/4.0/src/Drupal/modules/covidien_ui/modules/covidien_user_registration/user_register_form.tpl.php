
<?php
  // This is to check if the request is coming from a specific URL
  $ref = $_SERVER['HTTP_REFERER']; 
  $check_url = $_SERVER['HTTP_HOST'] . '/self/home';  

  if (strpos($ref,$check_url) === false) {
    print("<div>Hotlinking is not permitted!</div>");
    print("</br>");
    print('<div>Please navigate back to Self Registration homepage first <a href="home"> ' . $check_url . '</a></div>' );
    die;
  } 
?>
<?php global $base_url; ?> 
<!--use for local 
<script src="../modules/covidien_ui/modules/covidien_user_registration/js/jquery.min.js"></script> 
<link rel="stylesheet" href="../modules/covidien_ui/modules/covidien_user_registration/libraries/css/jPages.css"> 
<script src="../modules/covidien_ui/modules/covidien_user_registration/libraries/js/jPages.js"></script> 
<link rel="stylesheet" href="../modules/covidien_ui/modules/covidien_user_registration/libraries/css/animate.css">
<script src="../libraries/jquery.ui/ui/ui.datepicker.js"></script>-->
<!-- use for prod -->
<script src="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/js/jquery.min.js"></script> 
<link rel="stylesheet" href="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/libraries/css/jPages.css"> 
<script src="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/libraries/js/jPages.js"></script> 
<link rel="stylesheet" href="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/libraries/css/animate.css">
<script src="<?php print($base_url); ?>/sites/all/libraries/jquery.ui/ui/ui.datepicker.js"></script>
<script type="text/javascript">
$.noConflict();
jQuery( document ).ready(function( $ ) { 
 
  //check to make sure user have enter in the valid approve manager
  var validate_manager = false; 
  $('#edit-submit').on('click', function() {
    var covidien_user = $('#edit-cov-user:input:checkbox:checked').val(); 
    var manager_account_id = $("#edit-approving-manager").val(); 
    if (manager_account_id !== '' && covidien_user == '1') { 
      var arg = '/' + manager_account_id + '/1'; 
        $.ajax({
            url: Drupal.settings.basePath + 'self/validate_approving_manager' + arg,
            type: 'get',
            //data: $('form').serialize(),
            datatype: 'json',
            async: false,
            success: function(data) {
              if (data.valid == '1')
              {  
                $('form').submit();
              } 
            },
            error: function() {
              alert('There has been an error, please alert us immediately');
            }
        });
      } 
      
    if(covidien_user != '1'){ 
      validate_manager = true;
    }  
    return validate_manager;
  });
    
    
  $("div.holder").jPages({
    containerID : "itemContainer",
    perPage: 1,
    next        : "Select More Devices",
    previous    : "Previous" 
  }); 
  
  //Validate device traning materials before moving on to the next device.
 $('a').on("click",function(){  
     var result = true;
     $('.device-checked:checkbox:checked').each(function () { 
         //console.log($(this).attr("id"));
         if ($("#acknowledge-wrapper .manual-form-required").length > 0){  
            var acknowledge_check = $('#edit-acknowledge-wrapper-acknowledge:input:checkbox:checked').val(); 
            if(acknowledge_check == 1){ 
              result = true;
              //return result;
            } else { 
              result = false;
              alert("Please acknowledge training for selected devices.");
              return result;
            }
         }
         result = validate_device_training_material($(this).attr("id")); 
         if(result == false){ 
           alert("One or more required training records are not specified.")
         }
         return result; 
     }); 
     return result;
  })
  
  //add icon to date fields
  $( ".training-date-picker" ).datepicker({
    showOn: "both",
    //buttonImage: "/modules/covidien_ui/modules/covidien_user_registration/images/calendar.gif",
    buttonImage: "<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/images/calendar.gif",
    buttonImageOnly: true,
    buttonText: "Select date",
    onSelect: function(dateText, inst) {
        var date = checkDate($(this)); 
    }
  });
  
  //Select Date
  $('body').on('focus',".training-date-picker", function(){
    $(this).datepicker();
  });
 
  //Select all/none checkbox
  /* Change because of new Requirement
  $("#edit-acknowledge-wrapper-acknowledge").change(function () {
    //console.log('check/uncheck');
    $(".cot-wrapper.half-width input:checkbox").prop('checked', $(this).prop("checked"));
  });*/
   
        
  //hide/show base on Covidien User checkbox
  $("#edit-cov-user").click(function(){ 
    if(this.checked){
      //set message to be Covidien employee
      $(".country-info").text('This is the country of the office you operate out of, could be your domicile.');
      $(".role-info").text('This is the role you wish to perform for Covidien, if you are a Covidien employee.');
      
      //change from approving proxy back to approving manager
      $("#customer-name-wrapper").hide();
      $("#customer-account-wrapper").hide();
      //$("#edit-approving-manager-wrapper").find("label").text("Approving Manager");
      $("#edit-approving-manager-wrapper").show();
      $('#edit-approving-manager').val(''); 
      $('#customer-name').val('');
      $('#customer-account').val('');
      
      //Get New Roles
      $(".role-selection select").each(function() { 
        var cot_id = ($(this).context.id); 
        $.ajax({
          url: Drupal.settings.basePath + 'self/role_list_ajax/' + cot_id + '/covidien',
          dataType: "json",
          success: function(data) {
            var name, select, option;  
            select = document.getElementById(cot_id);  
            select.options.length = 0;

            // Load the new options
            for (name in data) {  
              data[name] = data[name].replace('ANDCODE','&');
              if (data.hasOwnProperty(name)) {
                select.options[select.options.length] = new Option(data[name], name);
              }
            }
          }
        }); 
      });
      
		} else {
      $(".country-info").text('This is the country of the facility where you work.');
      $(".role-info").text('This is the role you wish to perform for the facility.');
      
      $("#customer-name-wrapper").show();
      $("#edit-approving-manager-wrapper").hide();
      
      
      //Get New Roles
      $(".role-selection select").each(function() { 
        var cot_id = ($(this).context.id);
        //console.log(cot_id);
        $.ajax({
          url: Drupal.settings.basePath + 'self/role_list_ajax/' + cot_id + '/none_covidien',
          dataType: "json",
          success: function(data) {
            var name, select, option; 
            //console.log(data);
            // Get the raw DOM object for the select box
            select = document.getElementById(cot_id);  
            select.options.length = 0;

            // Load the new options
            for (name in data) {
              if (data.hasOwnProperty(name)) {
                select.options[select.options.length] = new Option(data[name], name);
              }
            }
          }
        }); 
      });
      //end ajax call 
    }
  }); 

}); 



</script>
  
<div class="self_registration_form_wrapper">
  <div class="self_registration_header">
    <div class="login_logo"><img src="<?php print($base_url . "/sites/all/themes/covidien_theme/logo.png"); ?>"/></div>	
    <div class="login_title"><h1><?php echo t('Welcome to the Covidien Device Management Portal'); ?></h1></div>
  </div> 
    
  <div class="left_page"> 
    <?php print drupal_render( $first_name); ?>
    <?php print drupal_render($last_name);?>
    <?php print drupal_render($email);?>  
    <?php print drupal_render($confirm_email);?>  
    <?php print drupal_render($phone);?>
    <?php print drupal_render($country);?> 
  </div>
  
  <div class="right_page"> 
    <?php //print drupal_render($language);?>
    <?php print drupal_render($cov_user);?> 
    <?php print drupal_render($customer_name );?>
    <?php print drupal_render($customer_account);?>
    <?php print drupal_render($approving_manager );?> 
    <div class="country-info">
      This is the country of the office you operate out of, could be your domicile.
    </div>
  </div>
  
  <div class="bottom_page"> 
    <?php print drupal_render($view_files); ?> 
    <?php print drupal_render($file);?> 
    <ul id="itemContainer">
    <?php foreach($form['cot_category'] as $key => $category): $css_class = '' ?>
    <?php if(is_array($category) && count($category)>1): ?> 
      
      <?php if (strpos($key,'Ablation') !== false): ?>
      <!-- no open li need to generate -->
      <?php else: ?>
        <li> 
      <?php endif; ?> 
          <?php if ((strpos($key,'Ablation') !== false) || (strpos($key,'Vessel Sealing') !== false)): ?> 
            <?php $css_class = 'half-width'; ?> 
          <?php endif; ?>
          <?php if (strpos($key,'Ablation') !== false): ?> 
          <!-- no need to generate second role in Ablation -->
          <?php else: ?> 
          <div class="role-selection"><?php print drupal_render($form['cot_category_role'][$key]); ?>
            <div class="role-info">This is the role you wish to perform for Covidien, if you are a Covidien employee.</div>
          </div>
          
          <?php endif; ?>
          <?php if($css_class=='half-width'): ?>
            <?php print drupal_render($acknowledge_wrapper); ?>
          <?php endif; ?>
          <div class="cot-wrapper <?php print($css_class); ?>">
            <div class="product-line-header <?php print($key);?>">
              <div class="device-header">Device</div> 
              <?php if ((strpos($key,'Ablation') !== false) || (strpos($key,'Vessel Sealing') !== false)): ?> 
              <!-- no header needed -->
              <?php else: ?>
                <div class="trainer-header">Trainer</div> 
                <div class="training-date-header">Training Date</div> 
                <div class="certificate-header">Certificate</div> 
              <?php endif; ?>
            </div>
            <?php 
            foreach($category as $device_item){ 
              if(is_array($device_item)){ 
                if(isset($device_item['devices']) && $device_item['devices'] != ''){
                  print drupal_render($device_item);//exit;
                }
              }
            }
            ?>
          </div>
      
      <?php if (strpos($key,'Vessel Sealing') !== false): ?> 
          <!-- no close li need to generate -->
      <?php else: ?>
        </li>
      <?php endif; ?>
      
      
      
      <?php endif; ?> 
    <?php endforeach; ?> 
     
    </ul>
  <div class="holder"></div>
  <div class="submit_wrapper"> 
    <button type="button" class="form-submit cancel" onclick="history.back();">Cancel</button> 
    <input type="reset" value="Reset All Values" class="form-submit reset" onclick="window.location='javascript:location.reload(true)';" title="Click here to clear out the form" />
    <?php print drupal_render($submit);?>   
  </div>
  
  <?php print drupal_render($form_build_id);?>
  <?php print drupal_render($form_token);?>
  <?php print drupal_render($form_id);?>  

</div>