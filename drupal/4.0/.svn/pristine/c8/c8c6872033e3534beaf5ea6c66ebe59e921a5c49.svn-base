<?php

$array_ret = json_decode(htmlspecialchars_decode($data, ENT_COMPAT), true);

if ($array_ret['isError']) {
  print_r($array_ret['errorMessage']);
} else {
	$type = check_plain($_GET['type']);
	$filename = check_plain($_GET['filename']);
	$deviceType = check_plain($_GET['deviceType']);
	$page = check_plain($_GET['page']);
/*	
	var_dump($type . '..............');
	var_dump($filename . '..............');
	var_dump($deviceType . '..............');
	var_dump($page);
*/	
	$url = '../covidien/logdetails' . '?type=' . $type . '&filename=' . $filename . '&deviceType=' . $deviceType . '&page=';
	//var_dump($url);
	
	print_r("<a href='../download_pic/downloadlogfile?filePath=".$filepath."'>Click here to download</a>" . " <input type='hidden'  id='totalNumber' style='width:80px; margin-left:650px; margin-right:5px;'></input> <input type='text' class='form-text' name='page' style='width:30px;' onkeyup='checknum(this)' id='logPage'>" . "<button type='button' id='submitButton' style='form-submit non_active_blue;margin-left:2px;' onclick=\"send('". $url ."')\">GO</button><br/><br/>");
	print_r($array_ret['logContent']);
}
?>

<style type='text/css'>
	element.style {
		width : 100%;
	}
	
	#wrapper #container{
		max-width : 100%;
		width : 100%;
	}
</style>

<script text="javascript/css">
/*	window.onload = document.getElementById('logPage').value = <?php 
		$page = check_plain($_GET['page']);
		if(empty($page)){
			print_r('1');
		}else{
			print_r($page);
		}
	?>;
*/	
	window.onload = function(e){
		window.moveTo(0,0);
		window.resizeTo(window.screen.availWidth,window.screen.availHeight);
	
		//TODO document.getElementById("totalNumber").value = document.getElementById("totalNumberHidden").value;
		removeElement(document.getElementById("header-region"));
		//document.getElementById("wrapper").style = "width:90%";
		document.getElementById("wrapper").style.width="90%";
		
		if(window.location.href.indexOf(".dat") <= 0){
			document.getElementById("logPage").style.display="none";
			document.getElementById("submitButton").style.display="none";
		}
	
		document.getElementById('logPage').value = <?php 
			$page = check_plain($_GET['page']);
			if(empty($page)){
				print_r('1');
			}else{
				print_r($page);
			}
		?>;
	}
	
	
	function send(url){
		window.location.href = url + document.getElementById("logPage").value;
	}
	
	function checknum(obj){
		var re = /^\+?[1-9][0-9]*$/;
		if(!re.test(obj.value)){
			alert("Illegal Number!");
			obj.value = "1";
			obj.focus();
			return false;
		}
		
	}
	
	function removeElement(_element){
    	var _parentElement = _element.parentNode;
	    if(_parentElement){
	    	_parentElement.removeChild(_element);  
	    }
	}
	
</script>