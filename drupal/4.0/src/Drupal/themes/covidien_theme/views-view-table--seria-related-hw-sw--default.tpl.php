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
$group_col3a = 0;
$group_col4 = 0;
?>
<table class="<?php print $class; ?>"<?php print $attributes; ?>>
  <?php if (!empty($rows[0])): ?>
    <thead>
      <tr>
        <th colspan="3" class="available_table_head" align="center"><?php echo t('Hardware'); ?></th>
        <th colspan="4" class="available_table_head" align="center"><?php echo t('Software'); ?></th>
      </tr>
      <tr>
        <?php foreach ($header as $field => $label): ?>
          <th class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php print $label; ?>
          </th>
        <?php endforeach; ?>
      </tr>
    </thead>
  <?php endif; ?>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
        <?php foreach ($row as $field => $content): ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php
            switch ($fields[$field]) {
              case 'field-device-component-nid':
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
              case 'field-hw-description-value':
                if ($group_col3 == 0) {
                  print $content;
                }
                $group_col3++;
                break;
              default:
              case 'nid':
                continue;
                break;
              default:
                print $content;
            }
            ?>		  
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
