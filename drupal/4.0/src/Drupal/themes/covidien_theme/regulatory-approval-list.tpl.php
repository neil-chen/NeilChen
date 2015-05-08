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
    <td><h2><?php echo t('Manage Regulatory Exceptions'); ?></h2></td>
  </tr>
  <tr>
    <td align="right">
      <a class="iframe" id="secondary_submit" href="<?php print $base_url; ?>/node/add/software-approval-unavailable/<?php print $id; ?> "><?php echo t('Add Exception'); ?></a>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2">
      <table class="form-item-table-full regulatary_approval" style="width : 55%;">		
        <tr>
          <td align="left"><label><?php echo t('Software Name:'); ?></label> </td>
          <td><input type="text" value="<?php echo $sw_name; ?>" disabled="disabled" /></td>				
        </tr>
        <tr>
          <td align="left"><label><?php echo t('Software Part Number:'); ?></label> </td>
          <td><input type="text" value="<?php echo $sw_part; ?>" disabled="disabled" /></td>
        </tr>
        <tr>
          <td align="left"><label><?php echo t('Software Version:'); ?></label> </td>
          <td><input type="text" value="<?php echo $sw_ver; ?>" disabled="disabled" /></td>
        </tr>
        <tr>
          <td align="left"><label><?php echo t('Software Description:'); ?></label> </td>
          <td><input type="text" value="<?php echo $sw_desc; ?>" disabled="disabled" /></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2">
      <div>	



        <?php echo $sw_regulatory_list; ?>
        <table class="form-item-table-full" style="width : 55%;">
          <tr>
            <td align="right" valign="top" style="padding-right : 18px;">
              <a href="<?php echo $base_url; ?>/node/<?php echo $sw; ?>/edit" id="secondary_submit"><?php echo t('Cancel'); ?></a>
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
        $.colorbox({iframe: true, open: true, href: "<?php print $base_url; ?>/node/add/software-approval-unavailable/<?php print $id; ?>", width: "500px", height: "500px", scrolling: false, overlayClose: false, onLoad: function() {
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
