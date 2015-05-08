<?php
global $base_url;

?>


<html>
<head>
<title></title>

<style>
input.form-autocomplete {
  background-image: url(../../misc/throbber.gif);
  background-repeat: no-repeat;
  background-position: 100% 2px; /* LTR */
}
input.autothrobbing {
  background-image: url(../../misc/throbber.gif);
  background-repeat: no-repeat;
  background-position: 100% -18px; /* LTR */
}

div.feature_search_wraper div input[type="text"]
{
color : #696B73; 
font-size : 11px;
 border: 1px solid #A8A8A7;
 padding : 2px;
-webkit-border-radius:10px;
-moz-border-radius:10px;
-ms-border-radius:10px;
border-radius:10px;
width:300px;
}
</style>

<script type="text/javascript" src="<?php print $base_url?>/misc/jquery.js"></script>
<script type="text/javascript" src="<?php print $base_url?>/sites/all/modules/covidien_ui/js/covidien_common.js"></script>
<script type="text/javascript" src="<?php print $base_url?>/sites/all/modules/covidien_ui/js/covidien_ui_common.js"></script>


<body>

<?php
global $drupal_abs_path;

global $user;
global $base_url ;

?>

		

<?php 
 	echo $result_table ;
?>


  <table class="form-item-table-full" style="margin-bottom: 20px;">
		<tr>
			<td>
  			<div class="form-item-div">
					<div class="form-item-left">
				    <?php if($user->devices_access['feature']){ if(in_array('edit',$user->devices_access['feature'])){ ?>      
						<input type="button" class="form-submit"	onclick="addNewFeature()"	value="Add new feature to Device">			
						<?php }}	?>
				  </div>
				</div>
				<div class="clear_div"></div>
			</td>
		</tr>
		
	</table>
	
	<form id="form_feature_add" method="post" accept-charset="UTF-8" action="<?php echo $base_url.'/device/feature/add' ?>" >
	  <input type="hidden" name="hid_device_id"  value='<?php echo $device_id ?>' />
	  <input type="hidden" name="hid_device_serial_number" value='<?php echo $device_serial_number ?>' />
	  <input type="hidden" name="hid_device_type_nid" value='<?php echo $device_type_nid ?>' />
	</form>
		
</body>

<script>

$(function(){
    $('#tbody_result a').each(function(i){
         var url =  '<?php echo $base_url?>'+"/device/feature/edit?id=" + $(this).attr("configid") ;
				 url += "&device_id=" + '<?php echo $device_id ?>' ;
		     url += "&serial_number=" + '<?php echo $device_serial_number ?>' ;
				 $(this).attr("href", url);
				 
				 
//     	var id = $(this).attr("configid");
  //  	$(this).bind("click",alert(id));
//     	$("#global_product_line").unbind();
//     	$("#global_product_line").bind("change",changeProductLine);
//     	$("#global_product_line").trigger("change");
//     	$("#global_product_line")[0].onchange=changeProductLine;

//         $(this).mouseover(function(){
//             var val = $(this).find('a').eq(i).html();
//             alert(val);
//         });

    });
});
  


  function addNewFeature(){
	  $("#form_feature_add").submit();
	}
</script>

</html>