<?php
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
drupal_set_title(t("Manage Roles"));

global $user;
global $base_url;
?>
<script type="text/javascript">
  var selected = new Array();
  function validate_checkbox() {
    if ($('#delete_selected').val()) {
      if (!confirm(Drupal.t('Are you sure you want to delete this role?'))) {
        return false;
      } else {
        document.role_frm.submit();
      }
    }
  }
  $(document).ready(function() {
    $('.form-checkbox').change(function() {
      var sel = new Array();
      sel.push(selected);
      $('.form-checkbox').each(function(i) {
        var id = $(this).attr('id');
        if ($('#' + id).is(":checked")) {
          var selected_value = $(this).val();
          if (!duplicate(selected_value, selected)) {
            selected.push(selected_value);
          }
        } else {
          var selected_value = $(this).val();
          if ((duplicate(selected_value, selected))) {
            selected = remove_duplicate(selected, selected_value);
          }
        }
      });
      $('#delete_selected').val(selected.join(','));

      if (selected.length == 0) {
        $('#edit-add-new').attr('disabled', 'disabled');
        $('#edit-add-new').removeClass('secondary_submit');
        $('#edit-add-new').addClass('secondary_submit_disabled');
      } else {
        $('#edit-add-new').removeAttr('disabled');
        $('#edit-add-new').removeClass('secondary_submit_disabled');
        $('#edit-add-new').addClass('secondary_submit');
      }
    });

    var url = document.URL;
    var string = new Array();
    string = extractUrlValue('del', url);
    if (string) {
      $('#delete_selected').val(string);
      selected = string.split(',');

      for (var i = 0; i < selected.length; i++) {
        if ($('#edit-viewfield--nid-nid-' + selected[i]))
          $('#edit-viewfield--nid-nid-' + selected[i]).attr('checked', 'checked');
      }
    }
    if (selected.length != 0) {
      $('#edit-add-new').removeAttr('disabled');
      $('#edit-add-new').removeClass('secondary_submit_disabled');
      $('#edit-add-new').addClass('secondary_submit');
    }

    $('.pager li a').click(function() {
      var url = $(this).attr('href');
      var val = $('#delete_selected').val();
      var value = extractUrlValue('del', url);
      if ((!value) && (!val)) {
        $(this).attr('href', url);
      }
      else if (!value) {
        $(this).attr('href', url + '&del=' + val);
      }
      else {
        var val = 'del=' + $('#delete_selected').val();
        ret_url = url.replace('del=' + value, val);
        $(this).attr('href', ret_url);
      }
    });
  });

  function duplicate(s, sel) {

    for (var i = 0; i < sel.length; i++) {
      if (sel[i] == s) {
        return true;
      }
    }
    return false;
  }

  function remove_duplicate(sel, s) {
    var temp = new Array();
    for (var i = 0; i < sel.length; i++) {
      if (sel[i] == s) {
        continue;
      }
      temp.push(sel[i]);
    }
    return temp;
  }

  function extractUrlValue(key, url)
  {
    if (typeof (url) === 'undefined')
      url = window.location.href;
    var match = url.match('[?&]' + key + '=([^&]+)');
    return match ? match[1] : null;
  }

</script>
<form name="role_frm" method="post" action="<?php print $base_url; ?>/covidien/admin/roles/delete" id="role_frm">
  <table class="<?php print $class; ?>"<?php print $attributes; ?>>
    <?php if (!empty($title)) : ?>
      <caption><?php print $title; ?></caption>
    <?php endif; ?>
    <thead>
      <tr>
        <?php foreach ($header as $field => $label): ?>
          <th class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php print $label; ?>
          </th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $count => $row): ?>
        <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
          <?php foreach ($row as $field => $content): ?>
            <td class="views-field views-field-<?php print $fields[$field]; ?>" <?php if ($fields[$field] == "nid") echo "width='5%'"; ?>>
              <?php print $content; ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</table>
<input type="hidden" value="" name = "delete_selected" id="delete_selected">
</form>
<table class="form-item-table-full"><tr><td>
      <?php if (in_array('edit', $user->devices_access['users'])) { ?>
        <input type="button" class="form-submit secondary_submit_disabled" onclick="validate_checkbox()" value="<?php echo t("Delete Selected"); ?>" id="edit-add-new" disabled="disabled"></td><td align="right" valign="top">
      <?php } ?>
    </td>
    <td align="right">
      <a href="<?php print $base_url; ?>/covidien/admin/access_roles" id="secondary_submit">Cancel</a>
    </td>
  </tr></table>
</div>
