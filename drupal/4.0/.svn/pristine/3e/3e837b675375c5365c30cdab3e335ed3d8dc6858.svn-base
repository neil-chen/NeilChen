<?php
global $base_url;
global $drupal_abs_path;
global $user;
?>
<center>
  <div id="div_error" style="width: 500px; display: none; font-weight: bold; color: red"></div>
</center>
<div class="tabs_wrapper">
</div>
<form action="<?php print $base_url ?>/alert/config/subscribeSave" accept-charset="UTF-8" method="post" id="node-form">
  <div>
    <?php
    global $user;
    if ($user->uid != 1 && is_cot_admin()) {
      ?>
      <table class="form-item-table-full"
             style="margin-left: -5px;" id="cot-admin-tbl">
        <tbody>
          <tr>
            <td>
              <div class="form-item-div">
                <div class="form-item-left" style="width:210px;">
                  <label for="subscription-type-a" style="display: inline;">Manage Subscription By User Role</label>
                </div>
                <div class="form-item-left">
                  <input type="radio" value="A" name="subscriptionType"
                         id="subscription-type-a" style="float: right; margin: 4px;" <?php echo $subscriptionType['admin']; ?>/>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-item-div">
                <div class="form-item-left" style="width:210px;">
                  <label for="subscription-type-p" style="display: inline;">Manage Subscription For Yourself</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="form-item-left">
                  <input type="radio" value="P" name="subscriptionType"
                         id="subscription-type-p" style="float: right; margin: 4px;" <?php echo $subscriptionType['personal']; ?>/>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <?php
    }
    if ($subscription_page == 'admin') {
      ?>
      <table class="form-item-table-full add_new"
             style="margin-left: -5px;" id="admin-tbl">
        <tbody>
          <tr>
            <td style="padding-left: 0px;">
              <h4>1. Choose Operation Type</h4>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-item-div">
                <div class="form-item-left" style="width:175px;">
                  <span title="This field is required." class="form-required">*</span><label
                    for="operation-type-y" style="display: inline;">Subscribe
                    Alert Event:</label>
                </div>
                <div class="form-item-left">
                  <input type="radio" value="Y" name="operationType"
                         id="operation-type-y" style="float: right; margin: 4px;" />
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-item-div">
                <div class="form-item-left" style="width:175px;">
                  <span title="This field is required." class="form-required">*</span><label
                    for="operation-type-n" style="display: inline;">Enable/Disable
                    Alert Event:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="form-item-left">
                  <input type="radio" value="N" name="operationType"
                         id="operation-type-n" style="float: right; margin: 4px;" />
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="padding-left: 0px;">
              <h4>2. Select Device Type</h4>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item"
                     id="edit-field-device-type-nid-nid-wrapper">
                       <?php echo $select_deivce_type; ?>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="padding-left: 0px;">
              <h4>3. Select Alert Category</h4>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item">
                  <?php echo $select_alert_category; ?>
                </div>
              </div>
            </td>
          </tr>
          <tr id="operation-type-y-4-1">
            <td style="padding-left: 0px;">
              <h4>4. Select Alert Event</h4>
            </td>
          </tr>
          <tr id="operation-type-y-4-2">
            <td>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item" id="div-alert-event">
                  <?php echo $select_alert_event; ?>
                </div>
              </div>
            </td>
          </tr>
          <tr id="operation-type-n-4-1">
            <td style="padding-left: 0px;">
              <h4>4. Enable/Disable Alert Event</h4>
            </td>
          </tr>
          <tr id="operation-type-n-4-2">
            <td>
              <div class="form-item-div">
                <div class="form-item" id="div-enable-disable-alert-event"></div>
              </div>
            </td>
          </tr>
          <tr id="operation-type-y-5-1">
            <td style="padding-left: 0px;">
              <h4>5. Select Delivery</h4>
            </td>
          </tr>
          <tr id="operation-type-y-5-2">
            <td>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item">
                  <?php echo $select_alert_delivery; ?>
                </div>
              </div>
            </td>
          </tr>
          <tr id="operation-type-y-6-1" style="display: none;">
            <td style="padding-left: 0px;">
              <h4>6. Recommended Message Template</h4>
            </td>
          </tr>
          <tr id="operation-type-y-6-2" style="display: none;">
            <td>
              <div class="form-item-div">
                <div class="form-item" id="alert_message_template"></div>
              </div>
            </td>
          </tr>
          <tr id="operation-type-y-7-1" style="display: none;">
            <td style="padding-left: 0px;">
              <h4>7. Select Application Role</h4>
            </td>
          </tr>
          <tr id="operation-type-y-7-2" style="display: none;">
            <td>
              <div class="form-item-div">
                <div class="form-item" id="application_role_list"></div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <?php
    }
    if ($subscription_page == 'personal') {
      ?>
      <table class="form-item-table-full add_new"
             style="margin-left: -5px;" id="non-admin-tbl">
        <tbody>
          <tr>
            <td style="padding-left: 0px;">
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item-left" style="width: 135px;">
                  <label><?php echo t('Select Device Type:'); ?> </label>
                </div>
                <div class="form-item-left">
                  <?php echo $select_deivce_type; ?>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="padding-left: 0px;">
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item-left" style="width: 135px;">
                  <label><?php echo t('Select Alert Category:'); ?> </label>
                </div>
                <div class="form-item-left">
                  <?php echo $select_alert_category; ?>
                </div>
                <div style="padding-left: 20px; width: 300px" class="form-item-left">
                  <div>
                    <input type="button" class="form-submit" onclick="getPersonAlertSubsciption()" value="Go" id="alert-subscription-go">
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr id="div-subscribe-alert-delivery-1" style="display: none;">
            <td style="padding-left: 0px;">
              <h4>Contact Preferences</h4>
            </td>
          </tr>
          <tr id="div-subscribe-alert-delivery-2" style="display: none;">
            <td>
              <div>
                <input type="checkbox" value="Email" id="person_alert_delivery-Email" name="person_alert_delivery[]" checked="checked" /> Email
              </div>
            </td>
          </tr>
          <tr id="div-subscribe-alert-event-1" style="display: none;">
            <td style="padding-left: 0px;">
              <h4>Subscribe/Unsubscribe Alert Event:</h4>
            </td>
          </tr>
          <tr id="div-subscribe-alert-event-2" style="display: none;">
            <td>
              <div class="form-item-div">
                <div class="form-item">
                  <input type="checkbox" value="" id="person-alert-evnet-controller"/> Select/Unselect All
                </div>
                <div class="form-item" id="div-person-alert-event-subscription"></div>
              </div>
            </td>
          </tr>
          <tr id="div-subscribe-country-1" style="display: none;">
            <td style="padding-left: 0px;">
              <h4>Select Country:</h4>
            </td>
          </tr>
          <tr id="div-subscribe-country-2" style="display: none;">
            <td>
              <div class="form-item-div">
                <div class="form-item" id="div-person-country-subscription"></div>
              </div>
            </td>
          </tr>
          <?php
        }
        ?>
        <tr>
          <td>
            <table class="form-item-table-full add_new">
              <tr>
                <td>
                  <table style="border: none">
                    <tbody style="border: none">
                      <tr>
                        <td width="75%" align="right"><a
                            href="<?php echo $base_url; ?>/alert/config/list"
                            id="secondary_submit">Cancel</a>
                        </td>
                        <td width="25%"><?php echo $form_submit; ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>
</form>
<script>
  var recommendedTempalteFlg = true;
  var personAlertSubscriptionEnableFlg = true;
  $(document).ready(function() {
    get_alert_event_list();
    $('#node-form select').bind('change', get_app_role_list_tbl);
    $('#node-form input').bind('change', validateFields);
    $('#alert_category').bind('change', get_alert_event_list);
    $('#operation-type-y').bind('change', switch_operation_area);
    $('#operation-type-n').bind('change', switch_operation_area);
    $("[id^='operation-type-y-']").hide();
    $("[id^='operation-type-n-']").hide();
    $('#subscription-type-a').bind('change', switch_subscription_fn);
    $('#subscription-type-p').bind('change', switch_subscription_fn);
    $('#sel_device_type').bind('change', get_alert_event_status_tbl);
    $('#alert_category').bind('change', get_alert_event_status_tbl);
    $('#person-alert-evnet-controller').bind('change', person_alert_event_all_controller);
    $('#person-alert-evnet-controller').bind('click', person_alert_event_all_controller);
    $('#btn-submit').bind('click', save_alert_change);
    $("#btn-submit").removeClass("form-submit");
    $("#btn-submit").addClass("non_active_blue");
    $("#btn-submit").attr("disabled", true);
    $("#sel_device_type").bind("change", function() {
      $.ajax({
        type: "POST",
        url: Drupal.settings.basePath + "covidien/globaldtype/ajax",
        data: {value: $('#sel_device_type').val()},
      });
    });
    $('#operation-type-y').change();
  });

  function save_alert_change() {
    $('table#left_table input[type=checkbox]').attr("checked", false);
    $('table#right_table input[type=checkbox]').attr("checked", true);
  }

  function person_alert_event_all_controller() {
    if ($('#person-alert-evnet-controller').attr('checked')) {
      $('input[id^="edit-field-person_alert_event_list"]').attr('checked', 'checked');
    } else {
      $('input[id^="edit-field-person_alert_event_list"]').attr('checked', '');
    }
  }

  function switch_operation_area() {
    if ($('input:radio[name=operationType]:checked ').val() == 'Y') {
      $("[id^='operation-type-y-']").show();
      $("[id^='operation-type-n-']").hide();
      get_app_role_list_tbl();
    } else {
      $("[id^='operation-type-y-']").hide();
      $("[id^='operation-type-n-']").show();
      get_alert_event_status_tbl();
    }
  }

  function isValidNumeric(input) {
    var regx = /\d/;
    var res = (regx.test(input));
    return res;
  }

  function getPersonAlertSubsciption() {
    if (isValidNumeric($('#sel_device_type').val()) && isValidNumeric($('#alert_category').val())) {
      var data = {"device_type": $("#sel_device_type").val(), "alert_category": $("#alert_category").val()};
      $.get(Drupal.settings.basePath + 'alert/ajax/get_person_alert_delivery', data, get_person_alert_delivery_callback);
      $.get(Drupal.settings.basePath + 'alert/ajax/get_person_alert_event', data, get_person_alert_event_callback);
      $.get(Drupal.settings.basePath + 'alert/ajax/get_person_alert_country', data, get_person_alert_country_callback);
    } else {
      validateFields();
      $('#div-subscribe-alert-event-1').hide();
      $('#div-subscribe-alert-event-2').hide();
      $('#div-subscribe-country-1').hide();
      $('#div-subscribe-country-2').hide();
      $('#div-subscribe-alert-delivery-1').hide();
      $('#div-subscribe-alert-delivery-2').hide();
    }
  }

  function get_person_alert_country_callback(data) {
    var result = Drupal.parseJson(data);
    if (result.status == 'success') {
      $('#div-person-country-subscription').html(result.data);
      $('#div-subscribe-country-1').show();
      $('#div-subscribe-country-2').show();
    }
    move_table_item_right('left_table', 'right_table');
    $('#right_table .form-checkbox').attr('checked', true);
  }

  function get_person_alert_event_callback(data) {
    var result = Drupal.parseJson(data);
    if (result.status == 'success') {
      if (result.personAlertSubscriptionEnableFlg) {
        personAlertSubscriptionEnableFlg = true;
      } else {
        personAlertSubscriptionEnableFlg = false;
      }
      $('#div-person-alert-event-subscription').html(result.data);
      $('#div-subscribe-alert-event-1').show();
      $('#div-subscribe-alert-event-2').show();
      validateFields();
      if (!personAlertSubscriptionEnableFlg) {
        alert("Cot Admin haven't initial these alert events by this device type. You cannot do subscription.");
      }
      // check the 'Select/Unselect All' checkbox if all alerts ars subscribed.
      var allCnt = $('#alert_event_status_tbl .form-checkbox').size();
      var chkCnt = $('#alert_event_status_tbl .form-checkbox:checked').size();
      if (allCnt > 0 && allCnt == chkCnt) {
        $('#person-alert-evnet-controller').attr('checked', true);
      }
    }
  }

  function get_person_alert_delivery_callback(data) {
    var result = Drupal.parseJson(data);
    if (result.status == 'success') {
      //$('#person_alert_delivery-Email').attr('checked', result.Email);
      $('#div-subscribe-alert-delivery-1').show();
      $('#div-subscribe-alert-delivery-2').show();
    }
  }

  function get_app_role_list_tbl() {
    if (isValidNumeric($('#sel_device_type').val()) && isValidNumeric($('#alert_category').val()) && isValidNumeric($('#alert_event').val())
            && isValidNumeric($('#alert_delivery').val()) && $('input:radio[name=operationType]:checked ').val() == 'Y') {
      var data = {"device_type": $("#sel_device_type").val(), "alert_event": $("#alert_event").val(), "alert_delivery": $("#alert_delivery").val()};
      $.get(Drupal.settings.basePath + 'alert/ajax/get_app_role_list', data, get_app_role_list_callback);
      $.get(Drupal.settings.basePath + 'alert/ajax/get_template_tbl', data, get_template_tbl_callback);
    } else {
      $('#operation-type-y-7-1').hide();
      $('#operation-type-y-7-2').hide();
      $('#operation-type-y-6-1').hide();
      $('#operation-type-y-6-2').hide();
    }
  }

  function get_app_role_list_callback(data) {
    var result = Drupal.parseJson(data);
    if (result.status == 'success') {
      $('#application_role_list').html(result.data);
      $('#application_role_list input').bind('change', validateFields);
      $('#operation-type-y-7-1').show();
      $('#operation-type-y-7-2').show();
    }
    move_table_item_right('left_table', 'right_table');
  }

  function get_template_tbl_callback(data) {
    var result = Drupal.parseJson(data);
    if (result.status == 'success') {
      $('#alert_message_template').html(result.data);
      recommendedTempalteFlg = result.hasTemplate;
      $('#operation-type-y-6-1').show();
      $('#operation-type-y-6-2').show();
    }
    validateFields();
  }

  function get_alert_event_list() {
    if ($('input:radio[name=operationType]').length > 1 && isValidNumeric($('#alert_category').val())) {
      var data = {"alert_category": $("#alert_category").val()};
      $.get(Drupal.settings.basePath + 'alert/ajax/get_alert_event_list', data, get_alert_event_list_callback);
    }
  }

  function get_alert_event_list_callback(data) {
    var result = Drupal.parseJson(data);
    if (result.status == 'success') {
      $('#div-alert-event').html(result.data);
      $('#alert_event').bind('change', get_app_role_list_tbl);
      $('#alert_event').bind('change', validateFields);
      $('#alert_event').find('option:even').addClass('color_options');
      $('#alert_event').find('option:odd').removeClass('color_options');
      get_app_role_list_tbl();
    }
    validateFields();
  }

  function get_alert_event_status_tbl() {
    if ($('input:radio[name=operationType]:checked ').val() == 'N' && isValidNumeric($('#sel_device_type').val()) && isValidNumeric($('#alert_category').val())) {
      var data = {"device_type": $("#sel_device_type").val(), "alert_category": $("#alert_category").val()};
      $.get(Drupal.settings.basePath + 'alert/ajax/get_alert_event_status_tbl', data, get_alert_event_status_tbl_callback);
    } else {
      $('#operation-type-n-4-1').hide();
      $('#operation-type-n-4-2').hide();
    }
    validateFields();
  }

  function get_alert_event_status_tbl_callback(data) {
    var result = Drupal.parseJson(data);
    if (result.status == 'success') {
      $('#div-enable-disable-alert-event').html(result.data);
      $('#div-enable-disable-alert-event input').bind('change', validateFields);
      $('#operation-type-n-4-1').show();
      $('#operation-type-n-4-2').show();
    }
    validateFields();
  }

  function move_table_item_right(left_id, right_id) {
    $('table#' + left_id + ' tr').each(function(event) {
      var this_checked = false;
      var seleted_id = [];
      $(this).find('input[type=checkbox]:checked').each(function(evt) {
        this_checked = true;
        seleted_id[evt] = $(this)[0].id;
      });

      if (this_checked) {
        var tr_str = $(this).html();
        $('#' + right_id).append('<tr>' + tr_str + '</tr>');
        $('#' + right_id).find('#' + seleted_id[0]).attr('checked', false);
        $(this).remove();
      }
    });
    validateFields();
  }

  function move_table_item_left(left_id, right_id) {
    $('#' + right_id + ' input[type=checkbox]:checked').each(function(event) {
      var td_str = $(this).parent().parent().html();
      $('#' + left_id).append('<tr>' + td_str + '</tr>');
      $('#' + left_id).find('input[type=checkbox]:checked').attr('checked', false);
      $(this).parent().parent().remove();
    });
    validateFields();
  }

  function validateFields() {
    var passFlg = true;
    if ($('input:radio[name=operationType]:checked ').val() == 'Y') {
      if (!isValidNumeric($('#sel_device_type').val())
              || $('#sel_device_type').val() == 0
              || !isValidNumeric($('#alert_category').val())
              || !isValidNumeric($('#alert_event').val())
              || $('#alert_event').val() == 0
              || !isValidNumeric($('#alert_delivery').val())
              || !recommendedTempalteFlg) {
        //|| $('#right_table input[type="checkbox"]').length < 1) {
        passFlg = false;
      }
    } else if ($('input:radio[name=operationType]:checked ').val() == 'N') {
      if (!isValidNumeric($('#sel_device_type').val()) || ($('#sel_device_type').val() == 0) || (!isValidNumeric($('#alert_category').val()))) {
        //|| $('#alert_event_status_tbl input[type="checkbox"]:checked').length < 1) {
        passFlg = false;
      }
    } else {
      if ($('input:radio[name=operationType]').length > 0) {
        passFlg = false;
      } else {
        passFlg = personAlertSubscriptionEnableFlg;
      }
    }
    //alert/config/subscribe/personal country
    if ($('#div-person-country-subscription').length) {
      if ($('#div-person-country-subscription #right_table input').length < 1) {
        passFlg = false;
      }
    }
    if (passFlg) {
      $("#btn-submit").removeClass("non_active_blue");
      $("#btn-submit").addClass("form-submit");
      $("#btn-submit").removeAttr("disabled");
    } else {
      $("#btn-submit").removeClass("form-submit");
      $("#btn-submit").addClass("non_active_blue");
      $("#btn-submit").attr("disabled", true);
    }
  }

  function switch_subscription_fn() {
    if ($('input:radio[name=subscriptionType]:checked ').val() == 'A') {
      document.location = Drupal.settings.basePath + "alert/config/subscribe/admin";
    } else {
      document.location = Drupal.settings.basePath + "alert/config/subscribe/personal";
    }
  }
</script>
