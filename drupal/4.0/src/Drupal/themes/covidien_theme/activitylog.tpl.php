
<script type="text/javascript">
  $(document).ready(function() {
    var val = $('#edit-last-name').val();
    if (val == "") {
      $('#edit-last-name').val(Drupal.t('Enter user name'));
    }
    var val = $('#edit-isemp').val();
    if (val != "") {
      disablefun(val);
    }

    $('#edit-last-name').focus(function() {
      var val = $(this).val();
      if (val == Drupal.t("Enter user name")) {
        $('#edit-last-name').val('');
      }
      else {
      }
    });
    $('#edit-isemp').change(function() {
      disablefun($(this).val());
    });
    $('#edit-submit-activity').click(function() {
      var val = $('#edit-last-name').val();
      if (val == Drupal.t("Enter user name")) {
        $('#edit-last-name').val('');
      }
    });

    function disablefun(val) {
      $("#edit-cid,#edit-bid,#edit-did").attr('disabled', '');
      if (val == "No") {
        $("#edit-bid, #edit-did").attr('disabled', 'disabled');
      }
      else if (val == "Yes") {
        $("#edit-cid").attr('disabled', 'disabled');
      }
    }
  });
</script>		
<table class="form-item-table-full">
  <tr>
    <td>
      <h2><?php echo t('User Activity Monitor'); ?></h2>
    </td>
    <td align="right">
    </td>
  </tr>
  <tr>
    <td valign="top">
      <div>
        <label><?php echo t('Search for a User:'); ?></label>
      </div>
      <div id="softwarelist_page1" class="oval_search_wraper">
        <?php echo $roles; ?>
      </div>
      <div class="views-exposed-widget views-submit-button" style="padding-top : 10px;" >
        <?php echo $button; ?>	
      </div>	
    </td>
    <td valign="top" >
      <table class="form-item-user-table">
        <tbody>
          <tr>
            <td>
              <div>
                <label><?php echo t('Filter Categories:'); ?> </label>
              </div>
              <table class="border_div">
                <tbody>
                  <tr>
                    <td>
                      <label for="edit-hardware-type"><?php echo t('Select Role'); ?> </label>
                      <?php print $roles; ?>
                    </td>
                    <td>
                      <label for="edit-hardware-name"><?php echo t('Covidien Employee'); ?> </label>
                      <?php ?>
                    </td>
                    <td>
                      <label for="edit-hardware-ver"><?php echo t('Covidien Business Unit'); ?> </label>
                      <?php ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="edit-hardware-type"><?php echo t('Covidien Department'); ?> </label>
                      <?php ?>
                    </td>
                    <td>

                    </td>
                    <td>
                      <label for="edit-hardware-name"><?php echo t('Other Company'); ?> </label>
                      <?php ?>
                    </td>
                  </tr>
                </tbody>
              </table>							
            </td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>				
</table>
