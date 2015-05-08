<?php
global $base_url, $drupal_abs_path;
?>
<style>
  #alert-info {
    border: 0;
    border-collapse: separate;
  }
  #alert-info tr {
    border: 0;
  }
  #alert-info tr td {
    border: 0;
    padding: 0;
  }
  .alert-comment {
    background-color: #cccccc;
    width: 95%;
    line-height: 20px;
    font-size: 12px;
    padding: 5px 0 5px 5px;
    margin: 1px 0;
  }
  .alert-comment ul {
    margin: 0;
    padding: 0;
  }
  .alert-comment li {
    list-style: none;
  }
  .comment-link {
    float: right;
    padding: 0 5px;
  }
  #edit-comment {
    display: none;
  }
</style>
<table class="form-item-table-full add_new" style="margin-left: -5px;" id="alert-config-form-tbl">
  <tbody>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('1. Alert Information:'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <!-- alert information -->
        <table id="alert-info">
          <tbody>
            <tr>
              <td width="150"><?php echo t('Device Type:'); ?></td>
              <td><?php echo $alert['device_type']; ?></td>
            </tr>
            <tr>
              <td><?php echo t('Device Serial Number:'); ?></td>
              <td><?php echo $alert['serial_number']; ?></td>
            </tr>
            <tr>
              <td><?php echo t('Alert Event:'); ?></td>
              <td><?php echo $alert['alert_event']; ?></td>
            </tr>
            <tr>
              <td><?php echo t('Alert Category:'); ?></td>
              <td><?php echo $alert['alert_category']; ?></td>
            </tr>
          </tbody>
        </table>
        <!-- alert information end -->
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('2. Alert Status:'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="form-item-div">
          <div class="form-item-left" style="width: 150px;"> 
            <?php echo t('Alert Status:'); ?>
          </div>
          <div class="form-item-left">
            <?php echo drupal_render($form['sel_alert_status']); ?>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding-left: 0px;">
        <h4>
          <?php echo t('3. Alert Comments:'); ?>
        </h4>
      </td>
    </tr>
    <tr>
      <td>
        <div class="alert-comments">
          <?php echo $comments; ?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <span id="add-comment">Add Comment</span>
        <span id="edit-comment" style="display:none;">Edit Comment. If you need add comment, please check <a href="#">Add</a></span>
        <?php echo drupal_render($form['alert_comment']); ?>
      </td>
    </tr>
  </tbody>
</table>
<input type="hidden" value="<?php echo $alert['alert_category']; ?>" name="alertCategory" />
<?php
echo drupal_render($form['alert_id']);
echo drupal_render($form['comment_id']);
?>
<div class="form-item-div" id="div_button" style="clear: both; float: right; width: 90%; padding-right: 35px;">
  <div class="form-item-right" style="width: 300px; padding-right: 10px;">
    <div style="float: left; padding-left: 100px;">
      <a id="secondary_submit" href="<?php echo url('alert/config/list'); ?>"><?php echo t('Cancel'); ?> </a>
    </div>
    <div style="float: right;">
      <?php echo drupal_render($form['submit']); ?>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#global_product_line').attr("disabled", true);
	if($("input[name='alertCategory']").val() == "Informational alert"){
	    $('#sel_alert_status').attr("disabled","disabled");
	    $('#sel_alert_status').parent().parent().parent().parent().parent().nextAll().remove();
	    $('.form-submit').remove();
	}
    //edit comment
    $("a[id^='edit-comment']").click(function() {
      var this_id = $(this).attr('id');
      var comment_id = this_id.replace('edit-comment-', '');
      var parent_div = $(this).parent().parent().parent();
      var this_comment = $(this).parent().nextAll('.comment-content').html();
      $('#alert_comment').val(this_comment);
      $('#edit-comment-id').val(comment_id);
      parent_div.hide();
      $('.alert-comment[id!=' + parent_div.attr('id') + ']').show();
      $('#add-comment').hide();
      $('#edit-comment').show();
      return false;
    });

    //add comment
    $('#edit-comment a').click(function() {
      $('#add-comment').show();
      $('#edit-comment').hide();
      $('.alert-comment').show();
      $('#alert_comment').val('');
      $('#edit-comment-id').val('');
    });
    //end document ready
  });

  function disableSubmit() {
    $("#btn-submit").removeClass("form-submit");
    $("#btn-submit").addClass("non_active_blue");
    $("#btn-submit").attr("disabled", true);
  }

  function enableSubmit() {
    $("#btn-submit").removeClass("non_active_blue");
    $("#btn-submit").addClass("form-submit");
    $("#btn-submit").removeAttr("disabled");
  }

  function validateForm() {
    if ($('#alert_comment').val()) {
      enableSubmit();
      return true;
    } else {
      disableSubmit();
      return false;
    }
  }
</script>