<?php
header('Content-type:text/html;charset="utf-8"');
function callback(){
	$callback = $_GET['callback'] ? $_GET['callback'] : 'parent.callback';
	if(!$_GET['result']){
		die ("<script>".$callback."('图片上传失败',false)</script>");
	}
	$result = json_decode(base64_decode($_GET['result']));
	if($result -> error > 0){
		die ("<script>".$callback."('".$result -> msg."',false)</script>");
	}
	$imgUrl = $result -> file;
	echo "<script>$callback('$imgUrl',true)</script>";
}
callback();
?>
