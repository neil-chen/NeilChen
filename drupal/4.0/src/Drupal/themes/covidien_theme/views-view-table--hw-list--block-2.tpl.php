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
global $base_path;
?>

<div style="float: left; position: relative; width: 45%;">
	<span title="This field is required." class="form-required">*</span>Candidate
	Hardware items

	<div style="overflow: auto; max-height: 400px;">

		<table class="<?php print $class; ?>" <?php print $attributes; ?>
			id='left_hardware_table'>
			<?php if (!empty($title)) : ?>
			<caption>
			<?php print $title; ?>
			</caption>
			<?php endif; ?>
			<thead>
				<tr>
				<?php foreach ($header as $field => $label): ?>
					<th class="views-field views-field-<?php print $fields[$field]; ?>">
					<?php if ($fields[$field] != 'nid') { ?> <a
						id="hw-list-sort-<?php print $fields[$field]; ?>" sort="ascending"
						order="<?php print $fields[$field]; ?>" class="views-processed"
						title="sort by <?php print $label; ?>"
						label="<?php print $label; ?>"><?php print $label; ?><img
							id="sort-ico" width="13" height="13" title="sort ascending"
							alt="sort icon" src="<?php echo $base_path; ?>misc/arrow-asc.png">
					</a> <?php } else { ?> <?php print $label; ?> <?php } ?>
					</th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($rows as $count => $row): ?>
				<tr class="<?php print implode(' ', $row_classes[$count]); ?>">
				<?php foreach ($row as $field => $content): ?>
					<td class="views-field views-field-<?php print $fields[$field]; ?>">
					<?php print $content; ?>
					</td>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>

<div style="float: left">
	<br>
	<table style="border: 0px;">
		<tbody style="border: 0px;">
			<tr onclick="move_hardware_item_right();">
				<td style="border: 0px;"><input type="button" class="form-submit"
					style="border: 0px; text-decoration: none;" value="-->" />
				</td>
			</tr>
			<tr onclick="move_hardware_item_left();">
				<td style="border: 0px;"><input type="button" class="form-submit"
					style="border: 0px; text-decoration: none;" value="<--" />
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div style="float: left; position: relative; width: 45%;">
	<span title="This field is required." class="form-required">*</span>Selected
	Hardware items
	<div style="overflow: auto; max-height: 400px;">
		<table id='right_hardware_table'>
			<thead>
				<tr>
					<th>Select</th>
					<th>Hardware Name</th>
					<th>Part Number</th>
					<th>Revision</th>
					<th>Hardware Type</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
