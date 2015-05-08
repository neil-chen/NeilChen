<?php
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/newjquery.min.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery.colorbox-min.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery-ui.min.js');
drupal_add_css(drupal_get_path('module', 'covidien_users') . '/css/colorbox.css');

global $base_url;
?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".iframe").colorbox({iframe: true, width: "500px", height: "500px", scrolling: false, onLoad: function() {
        $('#cboxClose').remove();
      }
    });



  });
</script>
<table class="form-item-table-full">
  <tr>
    <td><h2><?php echo t('Manage Training Records'); ?></h2></td>
  </tr>
  <tr>
    <td align="right">
      <a class="iframe" id="secondary_submit" href="<?php print $base_url; ?>/node/add/person-training-record/<?php print $id; ?>/mcot"><?php echo t('Add Training Record'); ?></a>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2">
      <table class="form-item-table-full regulatary_approval" style="width : 55%;">		
        <tr>
          <td align="left"><label><?php echo t('User Name:'); ?></label> </td>
          <td><input type="text" value="<?php echo $first_name . ' ' . $last_name; ?>" disabled="disabled" /></td>				
        </tr>
        <tr>
          <td align="left"><label><?php echo t('User Email ID:'); ?></label> </td>
          <td><input type="text" value="<?php echo $user_email; ?>" disabled="disabled" /></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2">
      <div>	


        <div id="download_frm">
          <?php echo $training_list; ?>
        </div>			
        <table class="form-item-table-full" style="width : 60%;">
          <tr>
            <td align="right" valign="top" style="padding-right: 18px;">
              <a href="<?php echo $base_url; ?>/node/<?php echo $id; ?>/edit" id="secondary_submit">Cancel</a>
            </td>
          </tr>
        </table>
      </div>			
    </td>
  </tr>
</table>
<script type="text/javascript">
  $(document).ready(function() {
    var hash = window.location.hash;
    if (hash != "") {
      if (hash == '#add') {
        $.colorbox({iframe: true, open: true, href: "<?php print $base_url; ?>/node/add/person-training-record/<?php print $id; ?>", width: "500px", height: "500px", scrolling: false, overlayClose: false, onLoad: function() {
                    $('#cboxClose').remove();
                  }
                });
              } else {
                var node = hash.split("/");
                $.colorbox({iframe: true, open: true, href: "<?php print $base_url; ?>/node/" + node[1] + "/edit/<?php print $id; ?>", width: "500px", height: "500px", scrolling: false, overlayClose: false, onLoad: function() {
                    $('#cboxClose').remove();
                  }
                });
              }
            }
          });
</script>
