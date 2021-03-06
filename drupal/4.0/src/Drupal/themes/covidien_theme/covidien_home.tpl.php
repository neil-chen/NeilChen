<?php
/**
 * Home page customized here.
 */
?>
<script type="text/javascript">
  function recentactivity() {
    if (!$('select[name=recent_activities]').val()) {
      return false;
    }
    var url = $('select[name=recent_activities]').val();
    if (url == "") {
      return false;
    }
    window.location = $('select[name=recent_activities]').val();
  }
  $(document).ready(function() {
    $('#content-part').attr('style', 'border:0');
  });
</script>

<?php if ($notice): ?><div align="center" class="notice"><?php echo $notice; ?></div><?php endif; ?>
<div class="services">
  <marquee direction="up" scrollamount="1" style="width: 800px;height: 18px" id="">
    <?php
    if (!empty($generalNotice)) {
      foreach ($generalNotice as $value) {
        ?>  
        <li>
          <div style="word-wrap:normal; color:red; font-size:18px;"><?php echo $value; ?></div>
        </li>
        <?php
      }
    }
    ?>
  </marquee>

  <h2><?php echo t('What do you want to do today?'); ?></h2>

  <table class="home_service">
    <tr>
      <td>
        <div class="services_dev">
          <div class="service_titles">
            <h3><?php echo t('Devices'); ?></h3>
          </div>
          <div>
            <p><?php echo t('Find & review details about a specific device:'); ?></p>
            <ul>
              <li><a href="<?php echo url('covidien/devices'); ?>"><?php echo t('Service History'); ?></a></li>
              <li><a href="<?php echo url('covidien/devices'); ?>"><?php echo t('HW/SW Configuration'); ?></a></li>
            </ul>
          </div>
        </div>
      </td>
      <td>
        <div class="services_rep">
          <div><h3><?php echo t('Reports'); ?></h3></div>
          <div>
            <p><a href="<?php echo url($report_url); ?>"><?php echo t('Create, View and Print Data Summary Reports'); ?></a></p>
          </div>
        </div>
      </td>
      <td>
        <div class="services_adm">
          <div><h3><?php echo t('Admin'); ?></h3></div>
          <div>
            <p><?php echo t('Manage the system:'); ?></p>
            <ul>
              <li><a href="<?php echo url('covidien/admin/users/list'); ?>"><?php echo t('Manage Users'); ?></a></li>
              <li><a href="<?php echo url($catalog_page_url); ?>"><?php echo t('View & Edit Hardware, Software and Document Catalogs'); ?></a></li>
              <li><a href="<?php echo url($conf_page_url); ?>"><?php echo t('Create and Manage Device Configurations'); ?></a></li>
            </ul>
          </div>
        </div>	
      </td>
    </tr>
  </table>
  <div style="clear  :both;" class="clear_div"></div>			
  <div class="services_fields">
    <div>
      <label><?php echo t('Jump to Your Recent Activity:'); ?></label>
    </div>
    <div class="form-item-div">
      <div class="form-item-left">
        <?php echo drupal_render($form); ?>
      </div>
      <div class="form-item-left" style="padding-left : 20px;">
        <input type="button" class="secondary_submit" value="Go" onclick="return recentactivity()">
      </div>
    </div>
  </div>
</div>
<div style="clear  :both;" class="clear_div"></div>



