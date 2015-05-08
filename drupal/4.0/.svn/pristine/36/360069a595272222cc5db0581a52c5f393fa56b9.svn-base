<style>
  .country-fooder {
    margin-left:17px;
  }
  #configuration_list {
    padding-top: 10px;
  }
  #country-fooder .secondary_submit {
    height: 25px;
  }
  .trade-embargo-filter-form-table, .trade-embargo-filter-form-table tbody, .trade-embargo-filter-form-table td{
    border: 0;
  }
  #country-fooder {
    padding: 10px 10px 0 17px;
  }
</style>
<div id="div_list">
  <div class="form-item-left">
    <h4><?php echo t('Trade Embargo Exception List'); ?></h4>
  </div>
  <?php global $user; ?>
  <?php if ($user->uid == 1) { ?>
    <div class="form-item-right">
      <?php echo l('Trade Embargo Country List', 'trade_embargo_country/list', array('attributes' => array('class' => 'form-submit secondary_submit'))); ?>
    </div>
  <?php } ?>
  <div style="clear: both"></div>
  <div id="country-header">
    <table class="trade-embargo-filter-form-table sticky-enabled sticky-table">
      <tbody>
        <tr>
          <td width="65">
            <div class="form-item-left">
              <label>Device Type</label>
            </div>
          </td>
          <td>
            <div class="form-item-left">
              <?php echo drupal_render($trade_embargo['form']['device_type']); ?>
            </div>
          </td>
          <td>
            <?php if (check_user_has_edit_access('trade_embargo')) { ?>
              <div class="form-item-right">
                <a href="<?php echo url('trade_embargo_country/upload_exception_list'); ?>" class="form-submit secondary_submit iframe cboxElement" id="upload_exception_list">Upload Exception List</a>
              </div>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td>
            <div class="form-item-left">
              <label>Country</label>
            </div>
          </td>
          <td>
            <div class="form-item-left">
              <?php echo drupal_render($trade_embargo['form']['country']); ?>
            </div>
          </td>
          <td>
            <?php if (check_user_has_edit_access('trade_embargo')) { ?>
              <div class="form-item-right">
                <a href="<?php echo url('trade_embargo_country/analyze_exceptions'); ?>" class="form-submit secondary_submit" id="analyze_exceptions">Analyze Exceptions</a>
              </div>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div class="form-item-left">
              <?php echo drupal_render($trade_embargo['form']['serail_number']); ?>
            </div>
            <div class="form-item-left" style="margin-left:20px;">
              <?php echo drupal_render($trade_embargo['form']['submit']); ?>
            </div>
          </td>
          <td>
            <?php if (check_user_has_edit_access('trade_embargo')) { ?>
              <div class="form-item-right">
                <a href="<?php echo url('trade_embargo_country/apply_exceptions'); ?>" class="form-submit secondary_submit" id="apply_exceptions" onclick="if (!confirm('Are you sure you want to apply exceptions?')) {
                      return false;
                    }">Apply Exceptions</a>
              </div>
            <?php } ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div id="country_list">
    <?php echo $trade_embargo['table']; ?>
  </div>

  <div id="country-fooder">
    <div class="form-item-left">
      <a href="<?php echo url('trade_embargo_country/download_exception_list'); ?>" class="form-submit secondary_submit">Download Exception List</a>
    </div>
    <div class="form-item-right">
      <a href="<?php echo url('covidien/home'); ?>" class="form-submit secondary_submit">Back</a>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    //add new customer
    $('a.iframe').colorbox({
      iframe: true,
      width: "500px",
      height: "290px",
      scrolling: false,
      onLoad: function() {
        $('#cboxClose').remove();
      },
      onClosed: function() {
        location.reload(true);
      }
    });

    $('#trade_embargo_go').click(function() {
      var device_type_id = $('#edit-field-device-type-nid').val();
      var country = $('#country').val();
      var serail_number = $('#serail_number').val();
      var url = Drupal.settings.basePath + 'trade_embargo/get_country_table';
      var data = {'device_type_id': device_type_id, 'country': country, 'serail_number': serail_number};
      $.get(url, data, function(response) {
        response = Drupal.parseJson(response);
        if (response.status == 'success') {
          $('#country_list').html(response.data);
        }
      });
    });
  });

</script>