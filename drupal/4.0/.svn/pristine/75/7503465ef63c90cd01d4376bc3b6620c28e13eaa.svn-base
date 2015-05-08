<style>
  table tr td {
    border: 0px;
  }
  input.form-autocomplete {
    background-image: url(../../misc/throbber.gif);
    background-repeat: no-repeat;
    background-position: 100% 2px; /* LTR */
  }
  input.throbbing {
    background-image: url(../../misc/throbber.gif);
    background-repeat: no-repeat;
    background-position: 100% -18px; /* LTR */
  }
</style>
<?php
global $base_url;
$action = $base_url . '/covidien/device/' . $device_id . '/' . $sno . '?topic=log_viewer';
if (isset($serviceDate) && trim($serviceDate) != '') {
  $current_date = date('m/d/Y', strtotime($serviceDate));
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>/sites/all/modules/date/date_popup/themes/datepicker.css">
<script type="text/javascript"src="<?php echo $base_url ?>/sites/all/libraries/jquery.ui/ui/packed/ui.datepicker.packed.js"></script>
<div id="div_search" style="text-align: center; width: 100%; border: 0px;">
  <form action="<?php echo $action ?>" method="get">
    <input type="hidden" name="topic" value="log_viewer" />
    <table class="noborder">
      <tr>
        <td style="width: 10%;">&nbsp;</td>
        <td style="width: 30%;">
          <?php echo t('Log Type:') ?>
          <input type="text" id="txt" name="logType" value='<?php echo $logType; ?>' class="form-autocomplete" style="width: 150px" onkeyup="autoFinish();" autocomplete="OFF">
          <div id="autocomplete" style="display: none;" onmouseover="this.style.display = 'block'" onmouseout="this.style.display = 'none'">
            <ul id="tipText"></ul>
          </div>
        </td>
        <td style="width: 30%;">
          <?php echo t('Service Date:'); ?>
          <input type="text" id="serviceDateDisplay" value='<?php echo $current_date ?>' name="serviceDateDisplay" style="width: 150px" onchange="setTime(this.value)" readonly="readonly"/> 
          <input type="hidden" id="serviceDate" name="serviceDate" value='<?php echo $serviceDate; ?>' />
        </td>
        <td style="width: 20%; text-align: left">
          <input type="submit" class="form-submit" value="Go" /></td>
        <td style="width: 10%;">&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
<div id="div_list">
  <?php echo $logList; ?>
</div>
<div id="div_page">
  <?php echo theme('pager', NULL, 10, 0); ?>
</div>

<script>

  function openLogDetails(event) {
    var deviceType = '';
    var div_content = $("#content-part");
    $(div_content).find("b").each(function(index, value) {
      if (index == 0) {
        deviceType = $(value).html();
        return 1;
      }
    });

    var action = $(event).attr('href') + deviceType;
    window.open(action, 'newwindow', 'height=600,width=1200,top=200,left=400,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no')
  }

  function setTime(time) {
    var times = time.split('/');
    if (times.length != 3) {
      $("#serviceDate").val('');
      return;
    }
    var month = times[0];
    var date = times[1];
    var year = times[2];
    $("#serviceDate").val(year + "-" + month + "-" + date);
  }

  $("#serviceDateDisplay").datepicker({showButtonPanel: true, dateFormat: 'mm/dd/yy'});
  $('input').keyup(function() {
    var event = event || window.event;
    if (event.keyCode == 13) {
      $("form").submit();
    }
  });

  function autoFinish() {
    var url = '<?php echo $base_url ?>/covidien/logType/autocomplete';
    var key = $("#txt").val();
    if (key.length > 2) {
      $("#txt").attr("class", "throbbing");
      $.post(url, {"keyword": key}, function(data, status) {
        if (status == "success") {
          $("#txt").attr("class", "form-autocomplete");
          var tipText = $.parseJSON(data);
          var tipHtml = "";
          if (tipText.length <= 0) {
            $("#autocomplete").hide();
            return;
          }
          else
            $("#autocomplete").show();
          for (var key in tipText) {
            tipHtml += "<li>" + key + "</li>";
          }

          var wid = parseInt($("#txt").width());
          var left = parseInt($("#txt").offset().left);
          var top = parseInt($("#txt").offset().top);
          var height = parseInt($("#txt").scrollHeight);

          $("#tipText").html(tipHtml).width(wid);

          $("#autocomplete").css("position", "absolute").offset({top: top + height, left: left});
          $(function() {  //5 
            $("#tipText li").mouseover(function() {
              $(this).css("background", "#D1D3D4").siblings("li").css("background", "white");
            });
            $("#tipText li").click(function() {
              $("#autocomplete").hide();
              $("#txt").val($(this).text());
            });
          })
        }
        else {
          alert("AJAX error ");
        }
      });
    }
  }

</script>