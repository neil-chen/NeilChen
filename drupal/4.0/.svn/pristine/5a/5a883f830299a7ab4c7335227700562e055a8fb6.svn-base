<?php
global $base_url, $user;
?>

<!-- Layout -->


<h2>Add Regulatory Exclusions</h2>
<div class="tabs_wrapper">
</div>
<!--    -->
<div>
  <table class="form-item-table-full add_roles regulatary_approval">
    <tbody><tr>
        <td>
          <div class="form-item-div">
            <div class="form-item-left"><label>Device Type:</label></div>
          </div>
        </td>
        <td>
          <input type="text" value="<?php echo check_plain($_GET['type']); ?>" disabled="">
        </td>
      </tr>
      <tr>
        <td>
          <div class="form-item-div">
            <div class="form-item-left"><label>Feature Name:</label></div>
          </div>
        </td>
        <td>
          <?php  echo drupal_render($exclusions_form['feature_nid']); ?>
          <input type="text" value="<?php echo check_plain($_GET['name']); ?>" disabled="">
        </td>
      </tr>
      <tr>
        <td>
          <div class="form-item-div">
            <div class="form-item-left"><label>Feature Description:</label></div>
          </div>
        </td>
        <td>
          <input type="text" value="<?php echo check_plain($_GET['desc']); ?>" disabled="">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div class="form-item-div">
            <div class="form-item-left" style="padding: 28px 5px 0px 0px;">
              <span title="This field is required." class="form-required">*</span>
            </div>
            <div class="form-item-left">
              <div><label>Country:</label></div>
              <div class="reg_country">
                <div class="form-item" id="edit-field-reg-approved-country-nid-nid-wrapper">
                  <?php  echo drupal_render($exclusions_form['select_country']); ?>

                </div>
              </div>
            </div>
          </div>
        </td>
      </tr>



      <tr>
        <td colspan="2">&nbsp;
        </td>
      </tr>
      <tr>
        <td>
           <a id="secondary_submit" href="javascript:void(0)" onclick="javascript:parent.$.colorbox.close();
             return false;">Cancel</a>
        </td>
        <td>
          <input type="submit" name="op" id="edit-submit" value="Add Exclusions" class="non_active_blue" disabled="" onclick="return exclusions_submit()">
        </td>
      </tr>
    </tbody>
  </table>
</div>




<script type="text/javascript">

  function select_feature_country(){
    if($('#select_country').val()!=0){
      $('#edit-submit').attr("class", "form-submit");
      $('#edit-submit').attr("disabled", false);
    }else{
      $('#edit-submit').attr("class", "non_active_blue");
      $('#edit-submit').attr("disabled", true);
    }
  }

  function  exclusions_submit(){	
    if($('#select_country').val()!=0){
      parent.$.fn.colorbox.close();
      return true ;
    }else{
      return false ;
    }
  }

</script>



