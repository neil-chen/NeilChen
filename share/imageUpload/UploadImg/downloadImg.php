<?php
if(isset($_GET['img_url'])){ 
	$filename=$_GET['img_url'];//获取参数
	header('Content-type: image/png'); 
	header("Content-Disposition: attachment; filename=$filename"); 
	readfile("$filename"); 
	exit;//结束程序 
}
?>