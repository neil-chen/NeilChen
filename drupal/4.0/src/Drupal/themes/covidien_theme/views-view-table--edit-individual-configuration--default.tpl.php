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
$group_col1 = 0;
$group_col2 = 0;
$group_col3 = 0;
$group_col4 = 0;
?>
<?php if (!empty($rows[0])): ?>
  <table class="popup_in_configuration">
    <tr><td colspan="2"><h5><?php print $rows[0]['title']; ?><h5/></td></tr>
    <tr><td><?php echo t('Version:'); ?> <?php print $rows[0]['field_device_config_version_value']; ?></td>
      <td><?php echo t('Effective Date:'); ?> <?php print $rows[0]['field_effective_date_value']; ?></td></tr>
    <tr><td><?php echo t('Date Created:'); ?> <?php print $rows[0]['created']; ?></td>
      <td><?php echo t('End of Life Date:'); ?> <?php print $rows[0]['field_device_end_of_life_value']; ?></td></tr>
  </table>
  <div style="clear:both"></div>
<?php endif; ?>

<table class="<?php print $class; ?>"<?php print $attributes; ?>>
  <?php if (!empty($rows[0])): ?>
    <thead>
      <tr>
        <td colspan="4" class="available_table_head"><?php echo t('Hardware'); ?></td>
        <td colspan="4" class="available_table_head"><?php echo t('Software'); ?></td>
      </tr>
      <tr>
        <?php foreach ($header as $field => $label): ?>
          <?php
          switch ($fields[$field]) {
            case 'title':
              $lbl_header = true;
              break;
            case 'field-device-config-version-value':
              $lbl_header = true;
              break;
            case 'field-effective-date-value':
              $lbl_header = true;
              break;
            case 'field-device-end-of-life-value':
              $lbl_header = true;
              break;
            case 'created':
              $lbl_header = true;
              break;
            case 'field-expiration-datetime-value':
              $lbl_header = true;
              break;
            case 'field-expiration-datetime-value-1':
              $lbl_header = true;
              break;
            case 'field-sw-status-nid':
              $lbl_header = true;
              break;

            default:
              $lbl_header = false;
          }
          ?>
          <?php if (!$lbl_header): ?>
            <th class="views-field views-field-<?php print $fields[$field]; ?>">
              <?php print $label; ?>
            </th>
          <?php endif; ?>
        <?php endforeach; ?>
      </tr>
    </thead>
  <?php endif; ?>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <?php
      $sw_exp = false;

      if (!empty($row['field_expiration_datetime_value_1']) || $row['field_sw_status_nid'] == 'Archived') {
        $sw_exp = true;
      }

      $gsw_exp = 0;
      $gsw_cnt = count($rows);
      foreach ($rows as $count1 => $row1) {
        if (!empty($row1['field_expiration_datetime_value_1']) || $row1['field_sw_status_nid'] == 'Archived') {
          $gsw_exp++;
        }
      }

      if ($sw_exp) {
        $hw_exp = true;
      } else {
        $hw_exp = false;
      }
      if (!empty($row['field_expiration_datetime_value'])) {
        $hw_exp = true;
      }
      ?>
      <?php if (!$hw_exp) { ?>
        <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
          <?php foreach ($row as $field => $content): ?>
            <?php
            switch ($fields[$field]) {
              case 'title':
                $lbl_header = true;
                break;
              case 'field-device-config-version-value':
                $lbl_header = true;
                break;
              case 'field-effective-date-value':
                $lbl_header = true;
                break;
              case 'field-device-end-of-life-value':
                $lbl_header = true;
                break;
              case 'created':
                $lbl_header = true;
                break;
              case 'field-expiration-datetime-value':
                $lbl_header = true;
                break;
              case 'field-expiration-datetime-value-1':
                $lbl_header = true;
                break;
              case 'field-sw-status-nid':
                $lbl_header = true;
                break;
              default:
                $lbl_header = false;
            }
            ?>
            <?php if (!$lbl_header): ?>

              <td class="views-field views-field-<?php print $fields[$field]; ?>">
                <?php
                switch ($fields[$field]) {
                  case 'title-1':
                    if ($group_col1 == 0) {
                      print $content;
                    }
                    $group_col1++;
                    break;
                  case 'field-hw-version-value':
                    if ($group_col2 == 0) {
                      print $content;
                    }
                    $group_col2++;
                    break;
                  case 'field-device-config-hw-status-value':
                    if ($group_col3 == 0) {
                      print $content;
                    }
                    $group_col3++;
                    break;
                  case 'title-3':
                    if ($group_col4 == 0) {
                      print $content;
                    }
                    $group_col4++;
                    break;
                  default:
                    if (!$sw_exp) {
                      print $content;
                    }
                }
                ?>		  
              </td>

            <?php endif; ?>
          <?php endforeach; ?>
        </tr>
      <?php } ?>
    <?php endforeach; ?>
  </tbody>
</table>
