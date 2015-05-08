<?php global $base_url; ?>
<!--use for local 
<script src="/modules/covidien_ui/modules/covidien_user_registration/js/jquery.min.js"></script> 
<link rel="stylesheet" href="/modules/covidien_ui/modules/covidien_user_registration/libraries/css/jPages.css"> 
<script src="/modules/covidien_ui/modules/covidien_user_registration/libraries/js/jPages.js"></script> 
<link rel="stylesheet" href="/modules/covidien_ui/modules/covidien_user_registration/libraries/css/animate.css">
<script src="/libraries/jquery.ui/ui/ui.datepicker.js"></script>-->
<!-- use for prod -->
<script src="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/js/jquery.min.js"></script> 
<link rel="stylesheet" href="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/libraries/css/jPages.css"> 
<script src="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/libraries/js/jPages.js"></script> 
<link rel="stylesheet" href="<?php print($base_url); ?>/sites/all/modules/covidien_ui/modules/covidien_user_registration/libraries/css/animate.css">
<script src="<?php print($base_url); ?>/sites/all/libraries/jquery.ui/ui/ui.datepicker.js"></script>
 <script type="text/javascript">
$.noConflict();
jQuery( document ).ready(function( $ ) {
  //remove all button which have disabled class
  $( ".non_active_blue" ).remove();
  //check acknowledge checkbox if one of the device is selected
  $('input:checkbox.half-width').each(function () {
       var count = (this.checked ? $(this).val() : "");
       if(count == 1){
         $('#edit-acknowledge-wrapper-acknowledge').prop('checked', true);
       }
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
     var device_selected = false;
     var acknowledge_check = $('#edit-acknowledge-wrapper-acknowledge:input:checkbox:checked').val(); 
     //This check is for VLEX page
     $('input:checkbox.half-width').each(function () { 
       var count = (this.checked ? $(this).val() : "");
       if(count == 1 && acknowledge_check != 1){
         result = false;
         alert("Please acknowledge training for selected devices."); 
         return result;
       } 
     });
     
     if(result == false){
       return result;
     }
     //This check is for all other pages
     //var acknowledge_check = $('#edit-acknowledge-wrapper-acknowledge:input:checkbox:checked').val();
     $('.device-checked:checkbox:checked').each(function () {  
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
  
  $("#edit-cov-user-app").click(function(){ 
    if(this.checked){
      //change from approving proxy back to approving manager
      $("#customer-name-wrapper").hide();
      $("#customer-account-wrapper").hide();
      //$("#edit-approving-manager-wrapper").find("label").text("Approving Manager");
      $("#edit-approving-manager-wrapper").show();
      $('#edit-approving-manager').val(''); 
      //$('#customer-name').val('');
      //$('#customer-account').val('');
      
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
  
<div class="approving_form_wrapper">
  <div class="self_registration_header"> 
    <div class="login_logo"><img src="<?php print($base_url . "/sites/all/themes/covidien_theme/logo.png"); ?>"/></div>
    <div class="login_title"><h1>Welcome to the Covidien Device Management Portal</h1></div>
    <div class="login_title"><h1 class="main_h1">Supported Applications:</h1><h1 class="sub_h1"> Valleylab Exchange | SCD Updater | Enhanced Service Software</h1></div>
    </br>
    <div class="login_title"><h1><?php echo t('Approve Registration -  Covidien User'); ?></h1></div>
  </div>
  
  <div class="left_page"> 
    <div class="form_label">First Name : <span><?php print($register_user['first_name']); ?></span></div>
    <div class="form_label">Last Name : <span><?php print($register_user['last_name']); ?></span> </div>
    <div class="form_label">Email : <span><?php print($register_user['email']); ?> </span></div>
    <div class="form_label">Phone Number : <span><?php print($register_user['phone_number']); ?> </span></div> 
    <div class="form_label">Country : <span><?php print($register_user['country']); ?> </span></div>
    
  </div>
  
  <div class="right_page">  
    <div class="form_label">Language : <span><?php print($register_user['language']); ?> </span></div> 
    <div class="form_label"><?php print drupal_render($cov_user_app); ?></div> 
    <?php //if($register_user['is_covidien_user'] == "No"): ?>
      <?php print drupal_render($customer_name);?>
      <?php print drupal_render($customer_account);?>   
    <?php //endif; ?>
  </div>
  <div class="training">Training</div>
   
  
  
  
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
          <div class="role-selection"><?php print drupal_render($form['cot_category_role'][$key]); ?></div>
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
    <button class="form-submit go-back" onclick="history.back();" type="button">Back</button>
    <?php print drupal_render($save);?>  
    <?php print drupal_render($deny);?>  
    <?php print drupal_render($submit);?>   
  </div>
  
  <?php print drupal_render($form_build_id);?>
  <?php print drupal_render($form_token);?>
  <?php print drupal_render($form_id);?>  

</div>