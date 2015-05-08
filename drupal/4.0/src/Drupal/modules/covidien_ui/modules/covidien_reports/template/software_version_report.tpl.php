<?php global $base_url; ?>
<style>
  .sticky-table {
    margin: 0;
    width: 100%;
  }
</style>
<div class="filter_title">Filters</div>
<table class="report_printing">
  <tbody>
    <tr>
      <td style="width : 30%">Device Type:</td>
      <td style="width : 25%"><?php echo $device_type; ?></td>
      <td style="width : 30%"></td>
      <td style="width : 35%"></td>
    </tr>
    <tr>
      <td style="width : 30%">Country:</td>
      <td style="width : 25%"><?php echo $country; ?></td>
      <td style="width : 30%">Region:</td>
      <td style="width : 35%"><?php echo $region; ?></td>
    </tr>
    <tr>
      <td style="width : 30%">Customer Name:</td>
      <td style="width : 25%"><?php echo $customer_name; ?></td>
      <td style="width : 30%">Customer Address:</td>
      <td style="width : 35%"><?php echo $customer_address; ?></td>
    </tr>
    <tr>
      <td style="width : 30%">Customer City:</td>
      <td style="width : 25%"><?php echo $customer_city; ?></td>
      <td style="width : 30%">Customer State:</td>
      <td style="width : 35%"><?php echo $customer_state; ?></td>
    </tr>
    <tr>
      <td style="width : 30%">User entered facility:</td>
      <td style="width : 25%"><?php echo $user_facility; ?></td>
      <td style="width : 30%">Device S/N:</td>
      <td style="width : 35%"><?php echo $ds_number; ?></td>
    </tr>
    <tr>
      <td style="width : 30%">Software Version:</td>
      <td style="width : 25%"><?php echo $sw_version; ?></td>
      <td style="width : 30%">Last Date Docked:</td>
      <td style="width : 35%"><?php echo $last_date_docked; ?></td>
    </tr>
  </tbody>
</table>

<br/>
<div class="view view-report-3 view-id-report_3 view-display-id-page_1 view-dom-id-1">
  <div><?php echo $table_list; ?></div>
  <!-- footer button -->
  <div class="view-footer form-item-div">
    <div class="form-item-left">
      <a class="form-submit secondary_submit" id="secondary_submit" href="<?php echo $base_url . '/covidien/reports/software_version_report_pdf' . $filter_url; ?>"><?php echo t("Download as PDF"); ?></a>
    </div>
    <div class="form-item-left">
      <a class="form-submit secondary_submit" id="secondary_submit" href="<?php echo $base_url . '/covidien/reports/software_version_report_xls' . $filter_url; ?>"><?php echo t("Download as XLS"); ?></a>
    </div>
    <div class="form-item-left">
      <a class="form-submit secondary_submit" id="secondary_submit" href="<?php echo $base_url . '/covidien/reports/software_version_report_csv' . $filter_url; ?>"><?php echo t("Download as CSV"); ?></a>
    </div>
    <div class="form-item-right" style="width : 50px;">
      <a href="<?php echo url('covidien/reports/filter/17') ?>" id="secondary_submit" class="form-submit secondary_submit"><?php echo t("Return"); ?></a>
    </div>
  </div>
</div>