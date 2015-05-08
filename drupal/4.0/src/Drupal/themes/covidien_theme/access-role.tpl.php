<?php
global $user;
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('div.tabs_wrapper ul li.user').addClass('active');
  });
</script>
<table width="100%" class="form-item-user-table"><tr>
    <td valign="top" class="form-item-user-table-left users_list_left">
      <a href="<?php print base_path(); ?>covidien/admin/users/list"><?php print t('Users'); ?></a><br />
      <a href="<?php print base_path(); ?>covidien/admin/access_roles" style="color:#000"><?php print t('Roles & Permissions'); ?></a><br />
      <a href="<?php print base_path(); ?>user/log/activity"><?php print t('User Activity Monitor'); ?></a><br />
      <a href="<?php print base_path(); ?>covidien/self/proxy-config"><?php print t('Default Approving Proxy'); ?></a><br />
      <a href="<?php print base_path(); ?>covidien/self/pending-registration-list"><?php print t('Pending Registration'); ?></a><br />
    </td><td class="form-item-user-table-right">
      <table class="form-item-user-table"><tr><td class="form-item-user-table-left" style="padding-top:200px;  vertical-align:top"><div class="white_background"><h4><?php echo t('Role'); ?></h4>
              <?php print $roles_list; ?></div> 
            <a href="<?php print base_path(); ?>covidien/admin/roles/list" id="secondary_submit"><?php echo t('Manage Roles'); ?></a>
          </td>
          <td class="form-item-user-table_in_and_in">
            <div class="white_background">
              <table width="100%" class="form-item-user-table_in">
                <tr>
                <td width="50%"><h4><?php print $role_name; ?></h4><div class="description"><?php print $desc; ?></div></td>
                </tr>
                <tr>
                  <td colspan="3"><br/></td>
                </tr>
                <tr>
                  <td colspan="3"><?php echo drupal_render($form); ?></td>
                </tr>
              </table>
            </div>	
          </td>
        </tr>
      </table>
    </td></tr>
</table>