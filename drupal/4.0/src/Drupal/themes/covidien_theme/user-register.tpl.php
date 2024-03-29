<?php
global $base_url;
?>
<script type="text/javascript">
  function toggle() {
    var ele = document.getElementById("toggleText");
    var text = document.getElementById("displayText");
    if (ele.style.display == "block") {
      ele.style.display = "none";
    }
    else {
      ele.style.display = "block";
    }
  }

  var next = false;
  var text = ["edit-field-first-name-0-value", "edit-name", "edit-field-last-name-0-value", "edit-pass", "edit-default-role"];
  var covidien1 = ["edit-roles", "edit-field-user-language-nid-nid", "edit-field-business-unit-nid-nid", "edit-field-device-avail-country-nid-nid"];
  var covidien2 = ["edit-roles", "edit-field-user-language-nid-nid", "customer_name", "account_number", "edit-field-device-avail-country-nid-nid"];
  var errormsg = ["First Name", "Last Name", "Email address"];

  //document ready
  $(document).ready(function() {
    $('#edit-submit').attr('disabled', 'disabled');
    $('#edit-submit').addClass('non_active_blue');

    $('form').unbind('keypress');

    $('input').keyup(function() {
      validate_submitbtn();
    });

    $('select').live('change', function() {
      validate_submitbtn();
    });

    var sub_device_array = $('#edit-device-type-array').val();
    var sub_access_array = $('#edit-role-access-array').val();
    var sub_role_array = $('#edit-role-name-array').val();
    $("input[type='radio']").click(function() {
      this.blur();
      this.focus();
      validate_submitbtn();
    });

    var sub_device_array = $('#edit-device-type-array').val();
    var sub_access_array = $('#edit-role-access-array').val();
    var sub_role_array = $('#edit-role-name-array').val();
    if (sub_device_array != '') {
      var device_array = sub_device_array.split(",");
      var role_array = sub_role_array.split(",");
      var access_array = sub_access_array.split(",");
      for (var i = 0; i < device_array.length; i++) {
        showPrivilegeValues('');
        selectgivenValues('device_array', device_array[i]);
        addDeviceValues(device_array[i], $(".device_array:last"));
        selectgivenValues('role_array', role_array[i]);
        getAccessValues(role_array[i], $(".role_array:last"));
        selectgivenValues('access_array', access_array[i]);
      }
    } else {
      showPrivilegeValues('');
    }

    if (sub_device_array != '') {
      var device_array = sub_device_array.split(",");
      var role_array = sub_role_array.split(",");
      var access_array = sub_access_array.split(",");
      for (var i = 0; i < device_array.length; i++) {
        showPrivilegeValues('');
        selectgivenValues('device_array', device_array[i]);
        addDeviceValues(device_array[i], $(".device_array:last"));
        selectgivenValues('role_array', role_array[i]);
        getAccessValues(role_array[i], $(".role_array:last"));
        selectgivenValues('access_array', access_array[i]);
      }
    } else {
      showPrivilegeValues('');
    }

    $("#next").click(function() {
      validate_submitbtn();
      if (next) {
        return;
      }
      $('#main1').css("display", "none");
      $('#main2').css("display", "");
      $('#center h2').html("Add Roles and User Permissions");
      var first_name = $('#edit-field-first-name-0-value').val();
      var last_name = $('#edit-field-last-name-0-value').val();
      if ((first_name != 'First Name') && (last_name != 'Last Name')) {
        $('#userID').val(first_name + ' ' + last_name);
      }
      var username = $('#edit-name').val();
      if (username != 'Email address') {
        $('#emailID').val($.trim(username));
      }
    });
    $(".back").click(function() {
      location.reload();
      //$('#main2').css("display","none");
      //$('#main1').css("display","");
      //$('#center h2').html("Add a New User");
    });

    //add new customer
    $('a.iframe').colorbox({
      iframe: true,
      width: "500px",
      height: "350px",
      scrolling: false,
      onLoad: function() {
        $('#cboxClose').remove();
      },
      onClosed: function() {
        //location.reload(true);
      }
    });
    $('a.iframe').click(function(e) {
      e.preventDefault();
    });

  });

  function validate_submitbtn() {
    var radios = $('input[class="form-radio"]:checked').val();
    if (radios == 'Yes') {
      var select = covidien1;
    }
    else {
      var select = covidien2;
    }
    var empty = false;
    next = false;
    for (var i = 0; i < text.length; i++) {
      var val = $('#' + text[i]).val();
      if (($('#' + text[i]).val() == '') || ($.inArray(val, errormsg) != -1)) {
        if (text[i] != 'edit-default-role') {
          next = true;
        }
        empty = true;
      }
    }
    for (var i = 0; i < select.length; i++) {
      if ($('#' + select[i]).val() == '' && $('#' + select[i]).attr("id") != "edit-field-business-unit-nid-nid") {
        if (select[i] != 'edit-roles') {
          next = true;
        }
        empty = true;
      }
    }
    if (next) {
      $('#next').addClass('non_active_grey');
      $('#next').attr('disabled', 'disabled');

    } else {
      $('#next').removeClass('non_active_grey');
      $('#next').removeAttr('disabled');
    }
    if (empty) {
      $('#edit-submit').attr('disabled', 'disabled');
      $('#edit-submit').addClass('non_active_blue');

    } else {
      $('#edit-submit').removeAttr('disabled');
      $('#edit-submit').removeClass('non_active_blue');
    }
  }
</script>
<input type="hidden" id="user-person-nid" value="<?php echo $form['#node']->nid; ?>"/>

<table class="form-item-table-full" id="main1">
  <tr>
    <td>
      <div class="form-item">
        <h4><?php echo t('1. Is the new user a Covidien employee?'); ?></h4>
      </div>
    </td>
  </tr>
  <tr>
    <td style="padding-left : 40px;" class="rad_label">
      <?php echo $covidien_user; ?>
    </td>
  </tr>
  <tr>
    <td>
      <h4><?php echo t('2. Enter information for the new user.'); ?></h4>
    </td>
  </tr>
  <tr>
    <td  style="padding-left : 35px;" class="add_user">
      <table class="form-item-table-full user_tables">
        <tr>
          <td>
            <div class="label_left"><label><?php echo t('First name:'); ?></label></div><div class="form-item-div"><div class="form-item-left"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div><div><?php echo $first_name; ?></div></div>
          </td>
          <td>
            <div class="label_left"><label><?php echo t('Last name:'); ?></label></div><div class="form-item-div"><div class="form-item-left"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div><div><?php echo $last_name; ?></div></div>
          </td>
          <td>
            <div class="label_left"><label><?php echo t('Email address:'); ?></label></div><div class="form-item-div"><div class="form-item-left"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div><div><?php echo $mail; ?> <?php echo $name; ?></div></div>
          </td>
        </tr>
        <tr>
          <td>
            <div style="padding-left : 12px;"><label><?php echo t('Country:'); ?></label></div>
            <div class="form-item-div"><div class="form-item-left"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div><div><?php echo $country; ?></div></div>
          </td>
          <td>
            <div class="label_left"><label><?php echo t('Language:'); ?></label></div><div class="form-item-div"><div class="form-item-left"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div><div><?php echo $language; ?></div></div>
          </td>
          <td>
            <div class="label_left">
              <label><?php echo t('Password:'); ?></label></div><div class="form-item-div">
              <div class="form-item-left"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div>
              <div class="form-item-left"><?php echo $pass; ?></div>
              <div class="form-item-left" style="width:110px"> <input type="button" id="auto_generate" value="Auto Generate" class="form-submit secondary_submit active_grey"></div>
              <div class="form-item-left"> <a href="javascript:void(0)" onmouseover="javascript:toggle();" onmouseout="javascript:toggle();"><img src="<?php print base_path(); ?><?php print path_to_theme(); ?>/images/question_mark.gif" width="20" alt="sticky icon" class="sticky" /></a></div>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <div style="margin-left : -5px;">
              <table width="100%" id="covidien-Yes" class="register_form form-item-table-full" style="padding-left:0px">
                <tr>
                  <td width="32%">
                    <div class="label_left"><label><?php echo t('Business Unit:'); ?></label></div><div class="label_left"><div class="form-item-left"></div><div><?php echo $business_unit; ?></div></div>
                  </td>
                </tr>
              </table>
              <table width="460px" id="covidien-No" class="register_form form-item-table-full" style="display:none">
                <tr>
                  <td style="padding-left:0px" width="275px">
                    <div style="padding-left : 8px;"><label><?php echo t('Customer Name:'); ?></label></div><div class="form-item-div"><div class="form-item-left"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div><div><?php echo $other_company; ?></div></div>
                  </td>
                  <td style="padding-left:0px" width="275px">
                    <div style="padding-left : 8px;"><label><?php echo t('Customer Account Number:'); ?></label></div><div class="form-item-div"><div class="form-item-left"style="padding-left : 3px;"><span title="<?php echo t('This field is required.'); ?>" class="form-required">*</span></div><div><?php echo $company_account_number; ?></div></div>
                  </td>
                  <td style="padding-left:0px">
                    <div id="add-customer-link">
                      <?php echo l('Add New Customer', 'covidien/customer/add', array('attributes' => array('class' => 'secondary_submit iframe cboxElement'))); ?>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
        <tr>
          <td align="right" colspan="3" >
            <div class="form-item-div" style="display:none">
              <div class="form-item-right" style="width : 205px;">
                <?php
                echo $roles;
                echo $device_type_array;
                echo $role_access_array;
                echo $role_name_array;
                echo $default_role;
                echo $form_build_id;
                echo $form_id;
                echo $destination;
                echo $timezone;
                echo $form_token;
                echo $company_account;
                ?>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="3" align="right">
            <div class="add_user">
              <div  class="add_user_message" id="toggleText" style="display: none">
                <div><b><?php echo t('Password Construction Guidelines'); ?></b></div>
                <div><?php echo t('Poor, weak passwords are easily cracked, and put the entire system at risk. Therefore, strong passwords are required. Try to create a password that is also easy to remember.'); ?></div>
                <ul>
                  <li><?php echo t('Passwords should contain at least 8 characters.'); ?></li>
                  <li><?php echo t('Passwords should contain at least 1 uppercase letter (e.g. N) and 1 lowercase letter (e.g. t).'); ?></li>
                  <li><?php echo t('Passwords should contain at least 1 numerical character (e.g. 5).'); ?></li>
                  <li><?php echo t('Passwords should contain at least 1 special character (e.g. $).'); ?></li>
                </ul>
              </div>
              <table class="form-item-table-full" style="height : 100px;">
                <tr>
                  <td width="20%" align="left"></td>
                  <td width="64%" align="right">
                    <div><a id="secondary_submit" href="<?php print base_path(); ?>covidien/admin/users/list"><?php echo t('Cancel'); ?></a></div>
                  </td>
                  <td width="12%" align="right">
                    <input type="button" id="next" value="Next" class="form-submit secondary_submit non_active_grey" disabled="disabled">
                  </td>
                  <td width="1%"><div style="display:none"><?php print $render; ?></div></td>
                </tr>
              </table>
          </td>
        </tr>		
      </table>
    </td>
  </tr>
</table>
<table class="form-item-table-full" id="main2" style="display:none" width="100%">
  <tr>
    <td align="center">
      <table style="width:50%;border:none" align="center">
        <tbody style="border:none">
          <tr>
            <td><?php echo t('User Name:'); ?> </td>
            <td><input type="text" readonly id="userID" /> </td>
          </tr>
          <tr>
            <td><?php echo t('User Email ID:'); ?> </td>
            <td><input type="text" readonly id="emailID" /></td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" style="width:75%">
      <div id="tabs_container" class="tabs_wrapper" align="left">
        <ul id="uitabs">	
          <li style="border:none;background:none;color:red">*</li>
          <li class="icon_accept active"><a href="#roles"><?php echo t('Roles'); ?></a></li>
          <li class="icon_accept"><a href="#privilege" title="<?php echo t('Privileges are optional but required for Trainer'); ?>"><?php echo t('Device Type Privileges'); ?></a></li>
        </ul>
      </div>
      <div class="device_tabs">
        <div id="roles" class="tab_content" style="display:block;height:300px;overflow-y:scroll">
          <table style="width:75%">
            <tr>
              <th><?php echo t('Class of Trade'); ?> </th>
              <th><?php echo t('Role'); ?> </th>
              <th><?php echo t('Default'); ?> </th>
              <th><?php echo t('Device Access'); ?> </th>
            </tr>
            <tbody>
              <?php
              foreach ($productline as $k => $v) {
                //GATEWAY-2786 validate  
                if (!array_key_exists($k, $pl)) {
                  continue;
                }
                $sel = '';
                if ($pl['selected'][$k] == 1) {
                  $sel = "checked";
                }
                $pline = str_replace(" ", "-", $k);
                echo '<tr><td>' . $k . '</td><td>' . $pl[$k] . '</td><td><input type="radio" name="default" id="default_' . $pline . '" ' . $sel . ' /></td><td>' . $pl[$pline . '_privilege'] . '</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <div id="privilege" class="tab_content" style="height:300px;overflow-y:scroll">
          <table width="80%" align="center" class="noborder">
            <tbody class="noborder">
              <tr><td width="80%">
                  <table style="width:100%" id="privilege_table">
                    <tr>
                      <th><?php echo t('Device Type'); ?> </th>
                      <th><?php echo t('Privilege'); ?> </th>
                      <th><?php echo t('Authorized'); ?> </th>
                    </tr>
                    <tbody>
                      <?php print $privilege_item_wrapper; ?>
                    </tbody>
                  </table>
                </td><td width="20%" valign="bottom">
                  <table class="form-item-table-full" style="width:100%">
                    <tr>
                      <td align="left"><a id="secondary_submit" href="javascript:void(0)" onclick="javascript:showPrivilegeValues('')"><?php echo t('Add New'); ?></a>
                      </td>
                    </tr>
                  </table>
                </td></tr>
            </tbody></table>
        </div>
      </div>
      <table class="form-item-table-full" style="width:75%">
        <tr>
          <td align="left"><a id="secondary_submit" class="back" href="javascript:void(0)"><?php echo t('Back'); ?></a></td>
          <td align="right"><?php echo $submit; ?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

