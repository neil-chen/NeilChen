<html>


<body>

<?php
global $drupal_abs_path;
global $user;
global $base_url ;
?>


		
<?php echo $table_last_known_features ; ?>
		
	
	<form id="form_feature_add" method="post" accept-charset="UTF-8" action="<?php echo $base_url.'/device/feature/add' ?>" >
	  <input type="hidden" name="hid_device_id"  value='<?php echo $device_id ?>' />
	  <input type="hidden" name="hid_device_serial_number" value='<?php echo $device_serial_number ?>' />
	</form>
		
</body>

<script>
	$(document).ready(function(){
      $("#tab6 a" ).each(function(i){
          div = $(this).parent();
          div.append(this.text);
          this.remove();
      });
	});

</script>

</html>