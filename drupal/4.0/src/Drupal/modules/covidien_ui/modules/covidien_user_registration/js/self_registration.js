$(document).ready(function() {
  //Validate the Registration Form page
  $('#self-registration-form').validate({ // initialize the plugin
    rules: {
      first_name: {
        required: true,
        minlength: 2
      },
      email: {
        required: true,
        email: true
      },
      confirm_email : {
        minlength : 5,
        equalTo : "#edit-email"
      },
      last_name: {
        required: true,
        minlength: 2
      },
      phone: {
        required: true
      } 
    } 
  })
  
  //Validate password on Reset Password page.
  $('#self-reset-password-form').validate({
    rules : {
      password : {
        minlength : 5
      },
      confirm_password : {
        minlength : 5,
        equalTo : "#edit-password"
      }
    },
    messages: {
        password: "Please enter in your new password.",
        confirm_password: "Password does not match.",
        email: "Please enter in your email address.",
        confirm_email: "Email does not match."
    }
  }); 
  
  //Hide Customer name and account on page load;
  $(".self_registration_form_wrapper #customer-name-wrapper").hide();
  $(".self_registration_form_wrapper #customer-account-wrapper").hide(); 
  //end validate form page
 
 //Validate the Proxy Config Form page
  $('#proxy-config-form').validate({ // initialize the plugin
    rules: { 
      proxy_email: {
        required: true,
        email: true
      } 
    } 
  });
   
  //autoload role and traning table on page loaded.
   
  //Appproving Page JS
  //Check to see if user is Covidien
  var covidien = $('#edit-cov-user:input:checkbox:checked').val();
  $('<span class="form-required" title="This field is required.">*</span>').insertAfter('#edit-approving-manager-wrapper label'); 
  $('<span class="form-required" title="This field is required.">*</span>').insertAfter('#customer-name-wrapper label'); 
  
  if (covidien == 1) { 
    $("#customer-name-wrapper").hide();
    $("#customer-account-wrapper").hide();
  } 
  
  //Approving Page hide/show base on Covidien User checkbox
  $("#customer-account-wrapper").hide();
  $("#edit-cov-user-app").click(function(){ 
    if(this.checked){
      //change from approving proxy back to approving manager
      $("#customer-name-wrapper").hide();
      //$("#customer-account-wrapper").hide();
		} else {
      
      $("#customer-name-wrapper").show();
      //$("#customer-account-wrapper").show();
    } 
  });
  
  //on approval page
  var check_covidien_user = $('#edit-cov-user-app:input:checkbox:checked').val();
  if(check_covidien_user == 1){
    $("#customer-name-wrapper").hide();
  }
  
  $("#edit-save").click(function(){  
    var result = validate_before_submit();
    return result
  });
  
  //End approving page
  
  //Register button
  $("#edit-submit").click(function(){ 
    var result = validate_before_submit();
    return result
  });

}); 

//validate before save, register, or accept
function validate_before_submit(){
    var covidien_user = $('#edit-cov-user:input:checkbox:checked').val();
    var flag = true;
    if(covidien_user == 1){ 
      var manager = $('#edit-approving-manager').val(); 
      if(manager == ''){
        if($("#edit-approving-manager-wrapper .error").length == 0) {
          $('<label class="error" for="edit-approving-manager" generated="true">Please enter in approving manager.</label>').insertAfter('#edit-approving-manager'); 
        }
        flag = false;
      }
    } else { 
      var customer_name = $('#customer-name').val();
      if(customer_name == ''){ 
        if($("#edit-approving-manager-wrapper .error").length == 0) {
          $('<label class="error" for="customer-name" generated="true">Please enter in customer name.</label>').insertAfter('#customer-name'); 
        }
        flag = false;
      }
    } 
    //this check is for approving page
    if($("#edit-approving-manager").length == 0 && flag == false) {
      flag = true;
    } 
    var at_least_one_device_select = false;
    $('.device-checked:checkbox:checked').each(function () {  
       if ($("#acknowledge-wrapper .manual-form-required").length > 0){  
          var acknowledge_check = $('#edit-acknowledge-wrapper-acknowledge:input:checkbox:checked').val(); 
          if(acknowledge_check == 1){ 
            flag = true; 
          } else { 
            alert("Please acknowledge training for selected devices.");
            flag = false;
            return flag;
          }
       } 
       flag = validate_device_training_material($(this).attr("id")); 
       if(flag == false){
         alert("One or more required training records are not specified.");
       }
        
       return flag; 
    });  
    
    //if none of the device is select, then do not allow user to register 
    
    $('.bottom_page input[type=checkbox]').each(function () { 
      if(this.checked == 1 && $(this).attr("id") != 'edit-acknowledge-wrapper-acknowledge'){
        at_least_one_device_select = true; 
        return at_least_one_device_select;
      }
    }); 
       
    if(at_least_one_device_select == false && $(".bottom_page").length == 1){
      alert('You must select at least one or more device before register');
      flag = at_least_one_device_select;
    } 
    return flag; 
  }
  
  
//Set Customer name base on account number
function setcustomername() { 
  var arg = ''; 
  var acno = $('#customer-account').val();
  if (acno != '') {
    arg = '/' + acno;
    $.getJSON(Drupal.settings.basePath + 'self/set_customer_name' + arg, function(ret) {
      var obj = '';
      $.each(ret, function(k, v) {
        obj = k;
      });
      if (obj != '') {
        $('#customer-name').val(obj);
      }
    });
  } 
} 

//Set Account Number base on Customer Name
function setaccountnumber() { 
  var arg = ''; 
  var acno = $('#customer-name').val();
  if (acno != '') {
    arg = '/' + acno;
    $.getJSON(Drupal.settings.basePath + 'self/set_account_number' + arg, function(ret) {
      var obj = '';
      $.each(ret, function(k, v) {
        obj = k;
      });
      if (obj != '') {
        $('#customer-account').val(obj);
      }
    });
  } 
}

//Check email to make sure email is not registered yet.
function checkEmail(){ 
  var arg = ''; 
  var email = $('#edit-email').val();
  if (email != '') {
    arg = '/' + email;
    $.getJSON(Drupal.settings.basePath + 'self/check_email_account' + arg, function(ret) {  
      if (ret.total != 0) {
        //email already registered
        alert('Someone has already registered this email address please use another email.');
        $('#edit-email').val('');
        window.setTimeout(function ()
        {
          $('#edit-email').focus();
        }, 0);
      }
    });
  } 
}

//Only allow number and dash to enter in the textfield
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode != 45 && charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
  return true;
}

//check to make sure date is less than the current date
function checkDate(id) { 
  var object_id = $(id).attr('id'); 
  var EnteredDate = $("#"+object_id).val();
  if(EnteredDate !== '') {
    var dd_mm_yy_array = EnteredDate.split('/'); 

    month = dd_mm_yy_array[0];
    date = dd_mm_yy_array[1];
    year = dd_mm_yy_array[2]; 
    var myDate = new Date(year, month - 1, date); 
    var today = new Date();
    var today_day = today.getDate();
    var today_month = today.getMonth();
    var today_year = today.getFullYear();

    var current_date = new Date(today_year, today_month, today_day); 
    if (dates.compare(myDate,current_date) == -1 ) { 
    }
    else {
      $("#"+object_id).val(''); 
      alert("Date must be less than today date");
       
      window.setTimeout(function ()
      {
        //document.getElementById(id).focus();
        $("#"+object_id).focus();
      }, 0);
    }
  }
}

var dates = {
    convert:function(d) {
        // Converts the date in d to a date-object. The input can be:
        //   a date object: returned without modification
        //  an array      : Interpreted as [year,month,day]. NOTE: month is 0-11.
        //   a number     : Interpreted as number of milliseconds
        //                  since 1 Jan 1970 (a timestamp) 
        //   a string     : Any format supported by the javascript engine, like
        //                  "YYYY/MM/DD", "MM/DD/YYYY", "Jan 31 2009" etc.
        //  an object     : Interpreted as an object with year, month and date
        //                  attributes.  **NOTE** month is 0-11.
        return (
            d.constructor === Date ? d :
            d.constructor === Array ? new Date(d[0],d[1],d[2]) :
            d.constructor === Number ? new Date(d) :
            d.constructor === String ? new Date(d) :
            typeof d === "object" ? new Date(d.year,d.month,d.date) :
            NaN
        );
    },
    compare:function(a,b) {
        // Compare two dates (could be of any type supported by the convert
        // function above) and returns:
        //  -1 : if a < b
        //   0 : if a = b
        //   1 : if a > b
        // NaN : if a or b is an illegal date
        // NOTE: The code inside isFinite does an assignment (=).
        return (
            isFinite(a=this.convert(a).valueOf()) &&
            isFinite(b=this.convert(b).valueOf()) ?
            (a>b)-(a<b) :
            NaN
        );
    },
    inRange:function(d,start,end) {
        // Checks if date in d is between dates in start and end.
        // Returns a boolean or NaN:
        //    true  : if d is between start and end (inclusive)
        //    false : if d is before start or after end
        //    NaN   : if one or more of the dates is illegal.
        // NOTE: The code inside isFinite does an assignment (=).
       return (
            isFinite(d=this.convert(d).valueOf()) &&
            isFinite(start=this.convert(start).valueOf()) &&
            isFinite(end=this.convert(end).valueOf()) ?
            start <= d && d <= end :
            NaN
        );
    }
}

//Validate file. Currently we only allow PDF file
function validateFileExtension(fld) { 
  if(!/(\.pdf)$/i.test(fld.value)) {
    alert("Invalid pdf file type."); 
    fld.value = ''; 
    fld.focus();        
    return false;   
  }   
  return true; 
}
 
//Get Proxy email base on COT
function get_proxy(id){
  if (id.value != '') {
    arg = '/' + id.value;
    $.getJSON(Drupal.settings.basePath + 'self/get_proxy' + arg, function(ret) {  
      if (ret.email != '') { 
        $('#proxy').val(ret.email);
        window.setTimeout(function ()
        {
          $('#proxy').focus();
        }, 0);
      } else {
        $('#proxy').val('');
        window.setTimeout(function ()
        {
          $('#proxy').focus();
        }, 0);
      }
    });
  } 
}

//Set proxy user on COT selection 
function get_cot_proxy(id){
  
  //Check to see if user is Covidien
  var covidien = $('#edit-cov-user:input:checkbox:checked').val();
  //console.log(covidien);
  
  if (id.value != '' && covidien != 1) {
    arg = '/' + id.value;
    $.getJSON(Drupal.settings.basePath + 'self/get_proxy' + arg, function(ret) {  
      if (ret.email != '') { 
        $('#edit-approving-manager').val(ret.email);
      } else {
        $('#edit-approving-manager').val('');
      }
    });
  } 
} 

//Check to make sure proxy email is also a covidien email address.
function validateCovidienEmail(email) {
  if (email.value != '') { 
    var check_email = email.value; 
    if (check_email.indexOf('@covidien.com', check_email.length - '@covidien.com'.length) === -1) {
      alert('Email must be a Covidien e-mail address (your_name@covidien.com).');
        $('#proxy').val('');
        window.setTimeout(function ()
        {
          $('#proxy').focus();
        }, 0);
        return false;
      //check email agaist user table in database. this is extra
      /* do not check covidien email in the user database
      $.getJSON(Drupal.settings.basePath + 'self/check_covidien_email_account/' + check_email, function(ret) {  
      }
      if (ret.total == 0) { 
          alert("This Covidien user email does not existed in our database.");
          $('#proxy').val('');
          window.setTimeout(function ()
          {
            $('#proxy').focus();
          }, 0);
          return false;
        }  
      }); */
      //end check agaist database.
    } /*else {
        alert('Email must be a Covidien e-mail address (your_name@covidien.com).');
        $('#proxy').val('');
        window.setTimeout(function ()
        {
          $('#proxy').focus();
        }, 0);
        return false;
    } */
  }
}

/*
 * Validate each device type on each cot before moving forward.
 */
function validate_device(id){ 
  var input_check = $('#' + id + ':input:checkbox:checked').val(); 
  var array = id.split('-'); 
  var device_id = array[array.length-1]; 
  var cot = array[4];
  var cot_name = array[5]; 
   if(cot_name === "Patient"){
    cot_name = cot_name + "-" + "Monitoring";
  } 
  //if device option is check, then insert in the require attributes
  if(input_check == 1){ 
    //insert start before trainer
    //edit-cot-category-cot-23-Ventilation-27-trainer-trainer27
    var message = '<span class="manual-form-required manual-form-required' + device_id + '" title="This field is required.">*</span>';
    $(message).insertBefore( "#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-trainer-trainer" + device_id );
    $("#"+id).addClass("device-checked");
    //insert before training date
    //edit-cot-category-cot-23-Ventilation-1408221-training-date-training-date1408221-datepicker-popup-0
    //edit-cot-category-cot-23-Ventilation-1408221-training-date-training-date1408221
    $(message).insertBefore( "#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-training-date-training-date" + device_id + "-datepicker-popup-0" );
    $(message).insertBefore( "#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-training-date-training-date" + device_id);
    //console.log("#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-training-date-training-date" + device_id + "-datepicker-popup-0");
    
    //role
    $(message).insertBefore( "#"+cot);
    //file field
    //edit-cot-category-cot-25-Compression-30-files-trainning-certificate-file30
    $(message).insertBefore( "#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-files-trainning-certificate-file" + device_id );
} else {
    $( ".manual-form-required"+device_id ).remove();
  }
}

//Validate Vessel
function validate_special_vessel_devices(id){
  var input_check = $('#' + id + ':input:checkbox:checked').val(); 
  var array = id.split('-'); 
  var device_id = array[array.length-1]; 
  var cot = array[4];
  var cot_name = array[5];  
  //if device option is check, then insert in the require attributes
  if(input_check == 1){  
    var message = '<span class="manual-form-required manual-form-required' + device_id + '" title="This field is required.">*</span>';
    $(message).insertBefore( "#edit-acknowledge-wrapper-acknowledge");
    $(message).insertBefore( "#"+cot);
    $("label[for=edit-acknowledge-wrapper-acknowledge]").css("color", 'red');
    $("#"+id).addClass("device-checked");
    } else {
      $( ".manual-form-required"+device_id ).remove(); 
      if($( "span" ).hasClass( "manual-form-required" ).toString() == 'false') { 
        $("label[for=edit-acknowledge-wrapper-acknowledge]").css("color", 'black');
      }
      
    }
}

//validate_device_training_material
function validate_device_training_material(id){ 
  var array = id.split('-'); 
  var device_id = array[array.length-1]; 
  var cot = array[4];
  var cot_name = array[5]; 
  if(cot_name === "Patient"){
    cot_name = cot_name + "-" + "Monitoring";
  } 
  
  var role = $("#" + cot + " option:selected").val();
   
  var result = true;
  var file_result = true;
  //Validate Trainer Value
  var trainer_check = $("#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-trainer-trainer" + device_id).val();
  
  //Validate Training Date 
  var training_date_check = $("#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-training-date-training-date" + device_id + "-datepicker-popup-0").val();

  if(typeof training_date_check === "undefined"){
    training_date_check = $("#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-training-date-training-date" + device_id).val();
  } 
  //Validate File
  //var training_certificate = $("#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-files-trainning-certificate-file" + device_id ).val();
  if ($("#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-files-trainning-certificate-file" + device_id ).length) {
    var file = $("#edit-cot-category-cot-" + cot + "-" + cot_name + "-" + device_id + "-files-trainning-certificate-file" + device_id ).val();
    //console.log(file);
    if (file === '') {
      // not valid      
      result = false;
      alert('Please select Certificate file to upload.');
    }
  } 
  if(trainer_check == '' || training_date_check == '' || file_result == false || role == ''){
    result = false;
  } 
  return result;
}

/*
 * Validate the Approving Manager on Register page.
 */
function validate_manager_account(id){ 
  var field_id = $(id).attr("id");
  var manager_account_id = $("#"+field_id).val(); 
  if (manager_account_id != '') {
    arg = '/' + manager_account_id + '/1';
    $.getJSON(Drupal.settings.basePath + 'self/validate_approving_manager' + arg, function(ret) {  
      if (ret.valid == '0') { 
        $('#'+field_id).val('');
        alert('Invalid Approving Manager.');
        window.setTimeout(function ()
        {
          $('#'+field_id).focus();
        }, 0);
      }  
    });
  } 
  
}