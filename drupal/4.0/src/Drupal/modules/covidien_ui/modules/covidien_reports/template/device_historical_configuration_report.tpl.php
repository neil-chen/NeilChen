<div class="message">
  <div class="messages error">
    <ul>
      <li>
      </li>
      <li>
      </li>
    </ul>
  </div>
</div>

<div class="filter_title">Filters</div>
<table class="report_printing">
  <tbody>
    <tr>
      <td style="width : 30%">Class of Trade:</td>
      <td style="width : 25%"><?php echo $pro_line_name ?></td>
      <td style="width : 30%">Device serial number:</td>
      <td style="width : 35%"><?php echo $ds_number ?></td>
    </tr>

    <tr>
      <td style="width : 30%">Device Type:</td>
      <td style="width : 25%"><?php echo $device_type_name ?></td>
      <td style="width : 30%">Country:</td>
      <td style="width : 25%"><?php echo $country ?></td>
    </tr>
    
    <tr>
      <td style="width : 30%">Region:</td>
      <td style="width : 35%"><?php echo $region ?></td>
      <td style="width : 30%">Customer Name:</td>
      <td style="width : 25%"><?php echo $customer_name ?></td>
    </tr>
    
    <tr>
      <td style="width : 30%">User Assigned Facility Name:</td>
      <td style="width : 35%"><?php   ?></td>
      <td style="width : 30%">Last dock date:</td>
      <td style="width : 25%"><?php echo $dock_date ?></td>
    </tr>
    
  </tbody>
</table>

<br><br>

<div class="view view-report-3 view-id-report_3 view-display-id-page_1 view-dom-id-1">
  <br>
  <div ><?php echo $result ; ?></div>


  <div class="view-footer form-item-div">
    <div style="width : 50px;" class="form-item-right">
      <a id="secondary_submit" href=<?php echo url('covidien/reports/filter/12') ?> >Return</a>
    </div>
  </div>
</div>







