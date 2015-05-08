<?php global $base_url; ?>
<table width="100%" class="form-item-user-table">
  <tr>
    <td valign="top" class="form-item-user-table-left">
      <div style="display:none;" class="reports_product_line">
        <div><label><?php echo t('Product Line'); ?></label></div>
        <?php echo $product_line; ?>
      </div>
      <div style="padding-top : 50px;" class="reports_menu">
        <?php print $report_menu; ?>
      </div>
    </td>
    <td class="form-item-user-table-right">
      <table class="noborder">
        <tr>
          <td class="noborder" colspan="2">
            <h4><?php echo t('Total Devices Report'); ?></h4>	
          </td>
        </tr>
        <tr>
          <td class="noborder" colspan="2" valign="bottom" align="right" style="height:200px;">
            <?php echo $search_button; ?>
            <?php echo $form_extras; ?>
          </td>	
        </tr>
      </table>
    </td>
  </tr>
</table>
