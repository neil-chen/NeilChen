<table width="100%" class="form-item-user-table">
  <td valign="top" class="form-item-user-table-left">
    <a href="<?php echo url('covidien/admin/users/list'); ?>" style="color:#000"><?php echo t('Users'); ?></a><br />
    <a href="<?php echo url('covidien/admin/users/access_roles'); ?>"><?php echo t('Roles & Permissions'); ?></a><br />
    <a href="<?php echo url('user/activity'); ?>"><?php echo t('User Activity Monitor'); ?></a><br />
    <a href="<?php print base_path(); ?>covidien/self/proxy-config"><?php print t('Default Approving Proxy'); ?></a><br />
    <a href="<?php print base_path(); ?>covidien/self/pending-registration-list"><?php print t('Pending Registration'); ?></a><br />
  </td>
  <td class="form-item-user-table-right">
    <table class="noborder">
      <tr><td class="noborder">
          <h2><?php echo t('Users'); ?></h2>
          <?php echo $search; ?>
        </td>
        <td width="40%" class="noborder">		<a class="inline" href="#inline_content" id="secondary_submit"><?php echo t('Advanced Search'); ?></a>
          <div style="display:none"><div id="inline_content" style="padding:10px; background:#fff;"><?php echo $advanced_form; ?>		</div></div>
        </td>
        <td width="20%" class="noborder" valign="top" align="right">
          <?php if (user_access('covidien_users View and Edit')) { ?>
            <a id="secondary_submit" href="<?php echo base_path(); ?>covidien/admin/users/add_new"><?php echo t('Add New'); ?></a></td>
        <?php } ?>
      </tr>
      <tr>
        <td colspan="3" class="noborder">
          <?php echo $form; ?>
        </td>
      </tr>
    </table>
  </td>
</table>
