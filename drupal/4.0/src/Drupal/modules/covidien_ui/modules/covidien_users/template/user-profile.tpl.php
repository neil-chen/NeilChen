<?php
global $user;
global $base_url;
?>
<table width="100%" class="form-item-user-table">
  <tr>
    <td valign="top" class="form-item-user-table-left">
      <div class="reports_menu">
        <div class="users_list_left">
          <a href="<?php print base_path(); ?>covidien/users/settings/user_profile" style="color:#000"><?php print t('Display User Profile'); ?></a><br />
          <a href="<?php print base_path(); ?>covidien/users/settings/change_password"><?php print t('Change Password'); ?></a><br />
          <!-- GATEWAY-2626 -->
          <!--<a href="<?php print base_path(); ?>covidien/users/settings/notification"><?php print t('Email Notification'); ?></a><br />-->
        </div>				
      </div>
    </td>
    <td class="form-item-user-table-right">
      <table class="noborder" style="width:100%">
        <tr>
          <td class="noborder" colspan="2">
            <h4><?php echo t('Display User Profile'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;" width="30%">
            <div><label><?php echo t('First Name:'); ?></label></div>
          </td>	
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo $firstname; ?></label></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo t('Last Name:'); ?></label></div>
          </td>	
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo $lastname; ?></label></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo t('Email Address:'); ?></label></div>
          </td>	
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo $email; ?></label></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo t('Covidien Employee:'); ?></label></div>
          </td>	
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo $employee; ?></label></div>
          </td>	
        </tr>
        <?php if ($employee == 'Yes') { ?>
          <tr>
            <td class="noborder" style="padding-left : 14px;">
              <div><label><?php echo t('Business Unit:'); ?></label></div>
            </td>	
            <td class="noborder" style="padding-left : 14px;">
              <div><label><?php echo $bunit; ?></label></div>
            </td>	
          </tr>
        <?php } else { ?>
          <tr>
            <td class="noborder" style="padding-left : 14px;">
              <div><label><?php echo t('Customer Name:'); ?></label></div>
            </td>	
            <td class="noborder" style="padding-left : 14px;">
              <div><label><?php echo $customer; ?></label></div>
            </td>	
          </tr>
          <tr>
            <td class="noborder" style="padding-left : 14px;">
              <div><label><?php echo t('Customer Account Number:'); ?></label></div>
            </td>	
            <td class="noborder" style="padding-left : 14px;">
              <div><label><?php echo $account_number; ?></label></div>
            </td>	
          </tr>
        <?php } ?>				
        <tr>
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo t('Country:'); ?></label></div>
          </td>	
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo $country; ?></label></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo t('Language:'); ?></label></div>
          </td>	
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo $language; ?></label></div>
          </td>	
        </tr>
        <tr>
          <td class="noborder" style="padding-left : 14px;" valign="top">
            <div><label><?php echo t('Class of  Trade authorized to access:'); ?></label></div>
          </td>	
          <td class="noborder" style="padding-left : 14px;">
            <div><label><?php echo implode(', ', $cot); ?></label></div>
          </td>	
        </tr>
      </table>
    </td>
  </tr>
</table>