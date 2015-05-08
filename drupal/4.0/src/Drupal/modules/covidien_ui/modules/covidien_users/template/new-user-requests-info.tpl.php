<?php
global $base_url;
global $wordwraplength, $wordwrapchar;
$topic = filter_xss($_GET['topic']);
?>
<script type="text/javascript">
  function denyuser(val) {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/admin/user/new_user_request/denied/",
      data: {value: val},
      success: function(ret) {
        if (ret == 1) {
          window.parent.location.href = Drupal.settings.basePath + "covidien/admin/users/new_user_request";
        }
      }
    });
  }
</script>

<h2><?php print $name; ?></h2>
<table class="form-item-table-full">
  <tr><td> <?php echo t('First Name:'); ?></td><td><?php print $firstname; ?></td></tr>
  <tr><td> <?php echo t('Last Name:'); ?></td><td><?php print $last; ?></td></tr>
  <tr><td> <?php echo t('Email address:'); ?></td><td><?php print $login; ?></td></tr>
  <tr><td> <?php echo t('Covidien Employee:'); ?></td><td><?php print $iscovidienemp; ?></td></tr>
  <?php if ($iscovidienemp == "yes") { ?>
    <tr><td width="37%"><?php echo t('Business Unit:'); ?></td><td><?php print $bunit; ?></td></tr>
  <?php } ?>
  <tr><td></td></tr>
  <?php if ($iscovidienemp == "no") { ?>
    <tr><td> <?php echo t('Customer Name:'); ?></td><td><?php print $customer; ?></td></tr>
    <tr><td> <?php echo t('Customer Account Number:'); ?></td><td><?php print $customeraccount; ?></td></tr>
  <?php } ?>
  <tr><td></td></tr>
  <tr><td> <?php echo t('Country:'); ?></td><td><?php print $country; ?></td></tr>
  <tr><td> <?php echo t('Language:'); ?></td><td><?php print $language; ?></td></tr>
  <tr><td> <?php echo t('Notes:'); ?></td><td><?php print $notes; ?></td></tr>
  <tr><td> <?php echo t('Request Date:'); ?></td><td><?php print $request_date; ?></td></tr>
  <tr><td colspan="2">
      <?php if (!empty($cots)) { ?>
        <table width="100%" id="user_requests_list">
          <thead>
            <tr><td><?php echo t('Class of Trade'); ?></td><td><?php echo t('Roles'); ?></td><td><?php echo t('Default'); ?></td></tr>
          </thead>
          <tbody>
            <?php foreach ($cots as $k => $v) { ?>
              <tr><td><?php echo $v['name']; ?></td><td><?php echo $v['role']; ?></td><td></td></tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>	 
</table>
<div align="right">		<a id="secondary_submit" href="javascript:void(0)" onclick="javascript:parent.$.colorbox.close();
    return false;"><?php echo t('Cancel'); ?></a>
  <input type="button" class="form-submit" onclick="window.parent.location.href = Drupal.settings.basePath + 'covidien/admin/users/add_new';" value="<?php echo t('Approved'); ?>" id="edit-add-new"> <a id="secondary_submit" href="javascript:void(0)" onclick="denyuser('<?php echo $id; ?>')"><?php echo t('Deny'); ?></a></div>