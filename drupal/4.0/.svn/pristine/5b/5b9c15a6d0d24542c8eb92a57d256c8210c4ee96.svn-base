<style>
  <!--
  .country-fooder {
    margin-left:17px;
  }
  #configuration_list {
    padding-top: 10px;
  }
  .country-fooder .form-item-left {
    padding-top: 10px;
    padding-left: 10px;
  }
  #update_message {
    color: red;
    float: left;
    padding: 12px 0 0 12px;
  }
  -->
</style>
<div id="div_list">
  <div class="form-item-left">
    <h4><?php echo t('Trade Embargo Management'); ?></h4>
  </div>
  <?php global $user; ?>
  <?php if ($user->uid == 1) { ?>
    <div class="form-item-right">
      <?php echo l('Trade Embargo Exception List', 'trade_embargo/list', array('attributes' => array('class' => 'form-submit secondary_submit'))); ?>
    </div>
  <?php } ?>
  <div style="clear: both"></div>
  <div id="configuration_list">
    <?php echo $trade_embargo['country_list']; ?>
  </div>
  <div class="country-fooder">
    <div class="form-item-left">
      <label><?php echo t('Country:'); ?></label>
    </div>
    <div class="form-item-left">
      <?php echo $trade_embargo['country_form']; ?>
    </div>
    <div class="form-item-left">
      <input type="button" class="form-submit secondary_submit" value="Add" id="add-country">
      &nbsp;&nbsp;
      <input type="button" class="form-submit secondary_submit" value="Publish Embargo Country List" id="update-biz-rule">
    </div>
    <div id="update_message"></div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    //add button
    $('#add-country').click(function() {
      var country = $('#country').val();
      console.log(country);
      //add country 
      $.post(Drupal.settings.basePath + 'trade_embargo_country/add', {'country': country}, function(data) {
        var response = Drupal.parseJson(data);
        if (response.status == 'success') {
          //reload table list
          $.get(Drupal.settings.basePath + 'trade_embargo_country/list', function(new_page) {
            var list_load = $(new_page).find('#configuration_list').html();
            $('#configuration_list').html(list_load);
          });
        }
      });
    });
    //Update the Biz role button
    $('#update-biz-rule').click(function() {
      var url = Drupal.settings.basePath + 'trade_embargo/update_biz_rule';
      $.get(url, function(data) {
        var response = Drupal.parseJson(data);
        if (response.status == 'success') {
          $('#update_message').html(response.data);
        }
      });
    });
  });
</script>