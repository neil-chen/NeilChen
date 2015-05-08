<?php

drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/newjquery.min.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery.colorbox-min.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery-ui.min.js');
drupal_add_css(drupal_get_path('module', 'covidien_users') . '/css/colorbox.css');

global $base_url;

$add_url =  $base_url ."/feature_license/regulatory_approval/add"
  ."?type=". $feature['device_type_name']
  ."&feature_nid=" . $feature['nid']
  ."&name=" . $feature_form['feature_name']['#value']
  ."&desc=" . $feature_form['feature_description']['#value'] ;
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
  <tbody>
    <tr>
      <td align="right">
        <a class="iframe" id="secondary_submit" href="<?php print $add_url; ?>" >
          <?php echo t('Add Exclusions'); ?>
        </a>
      </td>
    </tr>

    <tr>
      <td align="center" colspan="2">
        <table class="form-item-table-full regulatary_approval" style="width : 55%;">
          <tbody>
            <tr>
              <td align="left"><label>Feature Name:</label> </td>
              <td><?php  echo drupal_render($feature_form['feature_name']); ?></td>
            </tr>
            <tr>
              <td align="left"><label>Feature Description:</label> </td>
              <td><?php  echo drupal_render($feature_form['feature_description']); ?></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>


    <tr>
      <td align="center" colspan="2">
        <div>

          <!-- div class="view-content">
            <table class="views-table cols-1" style="width:50%">
              <thead>
                <tr>
                  <th class="views-field views-field-title">
                    <a class="active">Country </a> &nbsp; (Inherit SW Regulatory Exclusions)
                    <input align="right" type="checkbox" name="" checked="checked"/>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="odd views-row-first views-row-last">
                  <td class="views-field views-field-title" align="left">
                    <p>China</p>
                    <p>England</p>
                    <p>United States</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div -->

          <br/>

          <div class="view-content">
            <table class="views-table cols-1" style="width:50%">
              <thead>
                <tr>
                  <th class="views-field views-field-title">
                    <a class="active">Country</a>
                  </th>
                </tr>
              </thead>
              <tbody>

                <?php if($feature_exclusions_array) foreach ($feature_exclusions_array as $feature_exclusions) { ?>
                <tr class="odd views-row-first views-row-last">
                  <td class="views-field views-field-title" align="left">
                        <?php  echo  $feature_exclusions ; ?>
                  </td>
                </tr>
                    <?php }  ?>

              </tbody>
            </table>
          </div>

          <table class="form-item-table-full" style="width : 55%;">
            <tbody><tr>
                <td align="right" valign="top" style="padding-right : 18px;">
                  <a href="javascript:history.go(-1);" id="secondary_submit">Cancel</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
  </tbody></table>


<script type="text/javascript">
  $(document).ready(function() {
    var hash = window.location.hash;
    if (hash != "") {
      if (hash == '#add') {
        $.colorbox({iframe: true, open: true, href: "<?php echo url('/node/add/software-approval-unavailable/'.$id); ?>", width: "500px", height: "500px", scrolling: false, overlayClose: false, onLoad: function() {
            $('#cboxClose').remove();url('/node/add/software-approval-unavailable/'.$id)
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
