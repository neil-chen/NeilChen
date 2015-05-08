<?php global $base_url; ?>
<script type="text/javascript">
  var text = ["edit-title"];

  $(document).ready(function() {
    $('#header-region, .head_and_menu,#footer').css('display', 'none');
    $('#container').css('border', 'none');
    $('#wrapper').css('width', '450px');


    validate_submitbtn();

    $('form').unbind('keypress');

    $('input').keyup(function() {
      validate_submitbtn();
    });

    $('#edit-submit').click(function() {
      $('input[type="text"]').each(function() {
        var val = $(this).val();
        if (val == Drupal.t("Enter role description")) {
          $(this).val('');
        }
      });
    });

  });

  function validate_submitbtn() {
    var empty = false;
    for (var i = 0; i < text.length; i++) {
      if (($('#' + text[i]).val() == '') || ($('#' + text[i]).val() == "Enter role name")) {
        empty = true;
      }
    }
    if (empty) {
      $('#edit-submit').attr('disabled', 'disabled'); // updated according to 			
      $('#edit-submit').addClass('non_active_blue');

    } else {
      $('#edit-submit').removeAttr('disabled'); // updated according to 			
      $('#edit-submit').removeClass('non_active_blue');

    }
  }

</script>
<table class="form-item-table-full add_roles" >
  <tr><td><div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div class="form-item-left"><?php echo t('Class of Trade'); ?></div></div></td><td><span style="display:none"><?php print $role_pl; ?></span><?php print $product_line; ?></td></tr>
  <tr><td colspan="2"><div style="padding-left : 7px;"><label><?php echo t('Role:'); ?></label></div><div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required">*</span></div><div><?php print $title; ?></div></div></td></tr>
  <tr><td colspan="2"><div style="padding-left : 7px;"><label><?php echo t('Description:'); ?></label></div><div class="form-item-div"><div class="form-item-left"><span title="This field is required." class="form-required"> &nbsp;</span></div><div><?php print $desc; ?></div></div></td></tr>
  <tr><td colspan="2" style="padding-top:15px;">
      <a id="secondary_submit" href="javascript:void(0)" onclick="javascript:parent.$.colorbox.close();
          return false;"><?php echo t('Cancel'); ?></a> <?php print $save; ?></td></tr>
</table>
<div style="display:none">
  <?php echo $old_role; ?>
  <?php print $render; ?>
</div>