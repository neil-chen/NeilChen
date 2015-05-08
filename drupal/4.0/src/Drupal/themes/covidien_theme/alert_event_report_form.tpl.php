<?php 
/**
 * Form criteria for Alert Events Report
 */
?>
<?php global $base_url;?>

<table width="100%" class="form-item-user-table">
	<tr>
		<td valign="top" class="form-item-user-table-left">
			<div style="display:none;" class="reports_product_line">
				<div><label><?php echo t('Product Line'); ?></label></div>
				<?php echo $product_line;?>
			</div>
			<div style="padding-top : 50px;" class="reports_menu">
				<?php print $report_menu;?>
			</div>
		</td>
		<td class="form-item-user-table-right">
			<table class="noborder">
				<tr>
					<td class="noborder" colspan="3">
						<h4><?php echo t('Service Records Report'); ?></h4>	
					</td>
				</tr>
				<tr>
					<td class="noborder" colspan="3">
						<div class="label_left"><label><?php echo t('Device Type:'); ?></label></div>
						<div class="form-item-div">
							<div class="form-item-left"><span title="<?php echo t("This field is required."); ?>" class="form-required">*</span></div>
							<?php echo $device_type; ?>
						</div>
					</td>	
				</tr>
				<tr>
					<td class="noborder" width="35%">
						<div class="label_left"><label><?php echo t('Device Serial Number'); ?></label></div>
						<div class="form-item-div">
    						<div class="form-item-left"><span title="<?php echo t("This field is required."); ?>" class="form-required">*</span></div>
    						<?php echo $ds_number; ?>
						</div>
					</td>
					<td class="noborder">
					</td>
					<td class="noborder">
					</td>
				</tr>
				<tr>
					<td class="noborder" width="35%">
						<div class="label_left"><label><?php echo t('From Date:'); ?></label></div>
						<div class="form-item-div">
    						<div class="form-item-left"><span title="<?php echo t("This field is required."); ?>" class="form-required">*</span></div>
						<?php echo $from_date;?>
						</div>
					</td>
					<td class="noborder" width="35%">
						<div><label><?php echo t('To Date:'); ?></label></div>
						<?php echo $to_date;?>
					</td>
					<td class="noborder">
					</td>
				</tr>
				<tr>
					<td class="noborder" colspan="3">
						<div class="label_left"><label><?php echo t('Alert Reason:'); ?></label></div>
						<div class="form-item-div">
						    <div class="form-item-left"></div>
							<?php echo $alert_reason; ?>
						</div>
					</td>	
				</tr>
				<tr>
					<td class="noborder" colspan="3" align="right">
						<?php echo $search_button;?>
						<?php echo $form_extras;?>
					</td>	
				</tr>
			</table>
		</td>
	</tr>
</table>
