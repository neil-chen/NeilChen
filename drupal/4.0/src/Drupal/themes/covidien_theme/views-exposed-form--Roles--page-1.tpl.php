<?php
/**
 * @file views-exposed-form.tpl.php
 *
 * This template handles the layout of the views exposed filter form.
 *
 * Variables available:
 * - $widgets: An array of exposed form widgets. Each widget contains:
 * - $widget->label: The visible label to print. May be optional.
 * - $widget->operator: The operator for the widget. May be optional.
 * - $widget->widget: The widget itself.
 * - $button: The submit button for the form.
 *
 * @ingroup views_templates
 */
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/newjquery.min.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery.colorbox-min.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/editor.js');
drupal_add_js(drupal_get_path('module', 'covidien_users') . '/js/jquery-ui.min.js');
drupal_add_css(drupal_get_path('module', 'covidien_users') . '/css/colorbox.css');
global $user;
global $base_url;
?>
<?php if (!empty($q)): ?>
  <?php
  global $base_url;
  // This ensures that, if clean URLs are off, the 'q' is added first so that
  // it shows up first in the URL.
  print $q;
  ?>
<?php endif; ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#edit-plid').change(function() {
      $('form#views-exposed-form-Roles-page-1').submit();
    });
  });
</script>

<div class="manage_role" style="border:0px solid #000">	
  <table class="form-item-table-full">
    <tr>
      <td>
        <h4><?php echo t('Roles'); ?></h4>
      </td>
      <td align="right" valign="top">
        <?php if (in_array('edit', $user->devices_access['users'])) { ?>
          <a class="iframe" id="secondary_submit" class="add_role" href="<?php print $base_url; ?>/node/add/roles"><?php echo t('Add New Role'); ?></a>
        <?php } ?>
      </td></tr></table>

  <script type="text/javascript">
    $(document).ready(function() {
      var hash = window.location.hash;
      if (hash != "") {
        if (hash == '#add') {
          $.colorbox({iframe: true, open: true, href: "<?php print $base_url; ?>/node/add/roles", width: "500px", height: "500px", scrolling: false, overlayClose: false, onLoad: function() {
              $('#cboxClose').remove();
            }
          });
        }
        else if (hash.indexOf('#edit') >= 0) {
          var node = hash.split("/");
          $.colorbox({iframe: true, open: true, href: "<?php print $base_url; ?>/node/" + node[1] + "/edit", width: "500px", height: "500px", scrolling: false, overlayClose: false, onLoad: function() {
              $('#cboxClose').remove();
            }
          });
        }
      }
    });
  </script>

