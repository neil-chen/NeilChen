<html>
  <head>
    <?php
    global $base_url;
    $default_duration = 'Enter Duration #';
    $default_license_sn = 'Enter License SN';
    $default_license_key = 'Enter License Key';
    $serial_number = $_POST['hid_device_serial_number'] ? check_plain($_POST['hid_device_serial_number']) : $device_feature['device_serial_number'];
    $device_id = $_POST['hid_device_id'] ? check_plain($_POST['hid_device_id']) : $device_feature['device_nid'];
    $start_date = date("m/d/Y", $device_feature ? $device_feature['activation_utc_offset'] : time());
    ?>
    <style>
      select[multiple],select[size] {
        height: auto;
      }
    </style>
    <script type="text/javascript"	src="<?php echo $base_url ?>/misc/jquery.js"></script>
    <link rel="stylesheet" type="text/css"	href="<?php print $base_url ?>/sites/all/modules/date/date_popup/themes/datepicker.css"/>
    <script type="text/javascript"	src="<?php print $base_url ?>/sites/all/libraries/jquery.ui/ui/packed/ui.datepicker.packed.js"></script>
    <script type="text/javascript"	src="<?php print $base_url ?>/sites/all/modules/covidien_ui/js/covidien_common.js"></script>
  </head>
  <body>
    <div align="right" style="margin-top: 20px;"></div>
    <div id="center">
      <div class="right-corner">
        <div class="left-corner">
          <div class="tabs_wrapper"></div>
          <div id="content-part" class="clear-block">
            <form id="form_feature" enctype="multipart/form-data"	method="post" accept-charset="UTF-8" action="<?php echo $base_url ?>/device/feature/save">
              <div>
                <table class="form-item-table-full add_new">
                  <tbody>
                    <tr>
                      <td style="padding-left: 0px;">
                        <h4>1. Enter information for New Feature to be added to Devicice</h4>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="label_left">
                          <label>Device Serial Number:</label>
                        </div>
                        <div class="form-item-div">
                          <div class="form-item-left">
                            <span class="form-required" title="This field is required.">*</span>
                          </div>
                          <div>
                            <div class="form-item" id="edit-title-wrapper">
                              <input type="text" style="width: 150px" disabled="disabled" value='<?php echo $_REQUEST['hid_device_serial_number'] ? $_REQUEST['hid_device_serial_number'] : $device_feature['device_serial_number'] ?>' 	>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>


                    <tr>
                      <td>
                        <div class="label_left">
                          <label>Start Date:</label>
                        </div>
                        <div class="form-item-div">
                          <div class="form-item-left">
                            <span class="form-required" title="This field is required.">*</span>
                          </div>
                          <div>
                            <div class="form-item" id="edit-title-wrapper">
                              <input type="text" id="text_start_date_display" value='<?php echo $start_date; ?>' name="text_start_date_display" style="width: 150px"	onchange="setTime(this.value)">
                              <input type="hidden"	id="hidden_start_date" name="hidden_start_date"	 value='<?php echo $start_date; ?>'    />
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="label_left">
                          <label>Feature Term:</label>
                        </div>
                        <div class="form-item-div">
                          <div class="form-item-left">
                            <span class="form-required" title="This field is required.">*</span>
                          </div>
                          <div>
                            <div class="form-item">
                              <?php echo $select_feature_term ?>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>




                    <tr>
                      <td>
                        <div class="label_left">
                          <label>Duration #:</label>
                        </div>
                        <div class="form-item-div">
                          <div class="form-item-left">
                            <span class="form-required" title="This field is required.">&nbsp;</span>
                          </div>
                          <div>
                            <div class="form-item">
                              <input type="text" maxlength="255" name="txt_duration" id="txt_duration" size="60"	value="<?php echo $device_feature['duration'] ?>"
                                     class="form-text required"   />
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="form-item-div">
                          <div class="label_left">
                            <label>License SN:</label>
                            <div>
                              <div class="form-item">
                                <input type="text" maxlength="255" name="txt_license_sn" id="txt_license_sn" size="60"	value="<?php echo $device_feature['license_serial_number'] ?>"
                                       class="form-text required" onfocus="focusClear(this, '<?php echo $default_license_sn ?>');"
                                       onblur="blurFill(this, '<?php echo $default_feature_term ?>');" />
                                <font id="font_sn" style='display:none;color: #FF0000' >&nbsp;*&nbsp;this license sn already exists</font>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="form-item-div">
                          <div class="label_left">
                            <label>License Key:</label>
                            <div>
                              <div class="form-item">
                                <input type="text" maxlength="255" name="txt_license_key" id="txt_license_key" size="60"	value="<?php echo $device_feature['license_key'] ?>"
                                       class="form-text required" onfocus="focusClear(this, '<?php echo $default_license_key ?>');"
                                       onblur="blurFill(this, '<?php echo $default_feature_term ?>');" />
                                <font id="font_key" style='display:none;color: #FF0000' >&nbsp;*&nbsp;this license key already exists</font>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td style="padding-left: 0px;">
                        <h4>2. Choose the Feature item from the table below that is to be added to the Device </h4>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div id="div_system_hardware" style="float: left; position: relative; width: 100%">
                          <?php
                          echo $feature_catalog_table;
                          ?>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td><br></td>
                    </tr>
                    <tr>
                      <td>
                        <table width="100%" style="border: none">
                          <tbody style="border: none">
                            <tr>

                              <?php if ($device_feature) { ?>
                                <td width="70%" align="right"><a href="#"id="secondary_submit" onclick="goBackList()">Cancel</a></td>
                                <td width="15%"><input type="button" class="form-submit" value="Update Feature" onclick='save_feature()'></td>
                                <td width="15%"><input id="btn_delete" type="button" class="form-submit" value="Delete Feature" onclick='showDeleteWindow()'>
                                <?php } else { ?>
                                <td width="75%" align="right"><a href="#"id="secondary_submit" onclick="goBackList()">Cancel</a></td>
                                <td width="25%"><input id="btn_submit" type="button" class="form-submit" value="Add New Feature" onclick='save_feature()'></td>
                              <?php } ?>


                            </tr>
                          </tbody>
                        </table>

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <input type="hidden" name="hid_device_id" value="<?php echo $device_id ?>"/>
              <input type="hidden" name="hid_device_serial_number" value="<?php echo $serial_number ?>"/>
              <input type="hidden" name="hid_device_feature_id" value="<?php echo $device_feature_id ?>"/>


            </form>





            <div id="div_delete_info" style="position:absolute;display:none;border:2px solid #A6A6A6;color:blue;font-size:14px;font-family: Arial, sans-serif;padding:5px;background-color:#C7EAFB">
              <table>
                <tr>
                  <td colspan=2>Are you sure want to permanently delete current feature?</td>
                </tr>
                <tr>
                  <td style="border-right: 0px"></td>
                  <td style="text-align: right">
                    <input type="button" value="OK" style="width: 50px" onclick="delete_feature()" />
                    <input type="button" value="Cancel"	 onclick="javascript:$('#div_delete_info').slideUp('slow');" style="width: 50px" />
                  </td>
                </tr>
              </table>
            </div>


          </div>


        </div>
        <div id="footer"></div>
      </div>
    </div>




  </body>
</html>

<script>

  $("#text_start_date_display").datepicker({showButtonPanel: true, dateFormat: 'mm/dd/yy'});

  var hardwareListStr;
  $(document).ready(function() {
    $("#sel_feature_term").bind("change", validateComplete);
    //	$("#txt_license_sn").bind("keyup",validateComplete);
    //	$("#txt_license_key").bind("keyup",validateComplete);
    $("#txt_duration").bind("keyup", validateComplete);

    validateComplete();
  });




  function chooseOne(event) {
    var obj = $("input[name^='radio_feature_catalog_id']:checkbox");
    for (i = 0; i < obj.length; i++) {
      if (obj[i] != event) {
        obj[i].checked = false;
      } else {
        obj[i].checked = true;
      }
    }
  }


  function resize() {
    $("#div_delete_info").css("left", $("#btn_delete").offset().left - 80);
    $("#div_delete_info").css("top", $("#btn_delete").offset().top - 80);
  }


  function focusClear(comp, initValue) {
    if ($(comp).val() == initValue) {
      $(comp).val('');
    }
  }

  function blurFill(comp, initVaule) {
    if ($(comp).val() == '') {
      $(comp).val(initVaule);
    }
  }


  function license_sn_check() {
    var license_sn = $("#txt_license_sn").val();
    $.post("<?php echo $base_url ?>/device/feature/license/check", {"license_sn": license_sn},
    function(data) {
      if (data['license_sn'] > 0) {
        $("#font_sn").show();
        return false;
      } else {
        $("#font_sn").hide();
        return true;
      }
    }, "json");
  }

  function license_key_check() {
    var license_key = $("#txt_license_key").val();
    $.post("<?php echo $base_url ?>/device/feature/license/check", {"license_key": license_key},
    function(data) {
      if (data['license_key'] > 0) {
        $("#font_key").show();
        return false;
      } else {
        $("#font_key").hide();
        return true;
      }
    }, "json");
  }


  function validateComplete() {
    if ($("#sel_feature_term").val() != "" && $("#hidden_start_date").val() != ""
            && $("#txt_duration").val() != "" && $("#txt_duration").val() != '<?php echo $default_duration ?>'
            //		  && $("#txt_license_sn").val()!="" &&  $("#txt_license_sn").val()!='<?php echo $default_license_sn ?>'
            //      && $("#txt_license_key").val()!="" &&  $("#txt_license_key").val()!='<?php echo $default_license_key ?>'
            ) {
      enableSubmit();
    } else {
      //		disableSubmit();
    }
  }



  function setTime(time) {
    var times = time.split('/');
    if (times.length != 3) {
      $("#hidden_start_date").val('');
      return;
    }
    var month = times[0];
    var date = times[1];
    var year = times[2];
    $("#hidden_start_date").val(year + "-" + month + "-" + date);
  }



  function showDeleteWindow() {
    $("#div_delete_info").slideDown("slow");
  }


  function delete_feature() {
    $("#form_feature").attr("action", "<?php echo $base_url ?>/device/feature/delete");
    $("#form_feature").submit();
  }

  function filterHardwareByType() {
  }

  function changeProductLine() {
    getDeviceTypeByProductLineInFirmware('<?php print $base_url ?>', $(this).val());
  }


  //function save_feature(){
  //	 $("#form_feature").submit();
  //}

  function save_feature() {
    var txt_duration = $('#txt_duration').val();

    var regex = /^[0-9]*[1-9][0-9]*$/;

    if ($('#feature_term').val() != 0) {
      if ($('#txt_duration').val() == '') {
        alert('Please enter duration value');
        return false;
      }
      if (regex.test(txt_duration)) {

      } else {
        alert('duration must be a number ');
        return false;
      }

    } else {
      if ($('#txt_duration').val() == '' || regex.test(txt_duration)) {

      } else {
        alert('duration must be a number ');
        return false;
      }
    }

    var flag = false;
    $("input[name^='radio_feature_catalog_id']:checkbox").each(function() {
      if ($(this).attr("checked")) {
        flag = true;
        return false;
      }
    })
    if (flag == false) {
      alert('Please checked a feature ');
    } else {
      $("#form_feature").submit();
    }

    /*
     var license_sn = $("#txt_license_sn").val() ;
     var license_key = $("#txt_license_key").val() ;
     $.post("<?php echo $base_url ?>/device/feature/license/check", { "license_sn": license_sn , "license_key": license_key},
     function(data){
     if(data['license_sn']>0){
     $("#font_sn").show();
     return false ;
     }else{
     $("#font_sn").hide();
     }
     if(data['license_key']>0){
     $("#font_key").show();
     return false ;
     }else{
     $("#font_key").hide();
     }
     $("#form_feature").submit();
     }, "json"); */


  }

  function disableSubmit() {
    $("#btn_submit").removeClass("form-submit");
    $("#btn_submit").addClass("non_active_blue");
    $("#btn_submit").attr("disabled", true);
  }

  function enableSubmit() {
    $("#btn_submit").removeClass("non_active_blue");
    $("#btn_submit").addClass("form-submit");
    $("#btn_submit").removeAttr("disabled");
  }

  function goBackList() {
    window.location.href = "<?php echo $base_url . '/covidien/device/' . check_plain($_POST['hid_device_id']) . "/" . check_plain($_POST['hid_device_serial_number']) . '?topic=feature_list' ?>";
  }
</script>