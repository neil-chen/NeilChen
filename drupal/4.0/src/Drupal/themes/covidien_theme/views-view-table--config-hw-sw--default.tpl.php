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

// Hide from diplay
//field_expiration_datetime_value
$hidearr = array('field-expiration-datetime-value');
$display = 0;
?>
<table class="<?php print $class; ?>"<?php print $attributes; ?>>
  <?php if (!empty($rows[0])): ?>
    <thead>
      <tr>
        <td colspan="4" class="available_table_head"><?php echo t('Available Hardware'); ?></td>
        <td colspan="4" class="available_table_head"><?php echo t('Available Software'); ?></td>
      </tr>
      <tr>
        <?php foreach ($header as $field => $label): ?>
          <?php if (!in_array($fields[$field], $hidearr)): ?>
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
      <?php //empty($row['field_expiration_datetime_value']) ?>
      <?php
      if (empty($row['field_expiration_datetime_value'])) {
        $display++;
        ?>
        <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
          <?php foreach ($row as $field => $content): ?>
            <?php if (!in_array($fields[$field], $hidearr)): ?>
              <td class="views-field views-field-<?php print $fields[$field]; ?>">
                <?php
                switch ($fields[$field]) {
                  case 'hw-name':
                    if ($group_col1 == 0) {
                      print $content;
                    }
                    $group_col1++;
                    break;
                  case 'hw-description':
                    if ($group_col2 == 0) {
                      print $content;
                    }
                    $group_col2++;
                    break;
                  case 'hw-nid':
                    if ($group_col3 == 0) {
                      print $content;
                    }
                    $group_col3++;
                    break;
                  case 'hw-nid active':
                    if ($group_col3a == 0) {
                      print $content;
                    }
                    $group_col3a++;
                    break;
                  case 'hw-nid-1':
                    if ($group_col4 == 0) {
                      print $content;
                    }
                    $group_col4++;
                    break;
                  default:
                    print $content;
                }
                ?>		  
              </td>
            <?php endif; ?>
          <?php endforeach; ?>
        </tr>
      <?php } ?>
    <?php endforeach; ?>
    <?php /* ?>
      <tr class="odd views-row-first views-row-last">
      <td colspan="4" class="views-field views-field-nid-1">No Hardwares available
      </td>
      <td colspan="4" class="views-field views-field-nid">No Softwares available
      </td>
      </tr>
      <?php */ ?>
  </tbody>
</table>
