<?php
global $user;
global $base_url;
?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".iframe2").colorbox({
      iframe: true, width: "800px", height: "700px", scrolling: true, onLoad: function() {
        $('#cboxClose').remove();
      }
    });
  });
</script>
<table width="100%" class="form-item-user-table"><tr>
    <td valign="top" class="form-item-user-table-left users_list_left">
      <a href="<?php print base_path(); ?>covidien/admin/users/list"><?php print t('Users'); ?></a><br />
      <a href="<?php print base_path(); ?>covidien/admin/access_roles" style="color:#000"><?php print t('Roles & Permissions'); ?></a><br />
      <a href="<?php print base_path(); ?>user/log/activity"><?php print t('User Activity Monitor'); ?></a><br />
    </td><td class="form-item-user-table-right">
      <table class="form-item-user-table"><tr>
          <td class="form-item-user-table_in_and_in">
            <table width="100%" class="form-item-user-table_in">
              <tr>
                <td colspan="3">
                  <h2><?php echo t('New User Requests'); ?></h2>
                  <div align="right"><?php print $form; ?></div>
                  <?php print $user_list; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td></tr>
</table>