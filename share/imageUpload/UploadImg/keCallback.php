<?php
header('Content-type:text/html;charset="utf-8"');
function callback(){
	$ret = array('error'=>0, 'url'=>'', 'message'=>'');
	$callback = $_GET['callback'] ? $_GET['callback'] : 'parent.callback';
	if(!$_GET['result']){
		$ret['error'] = 1;
		$ret['message'] = "图片上传失败";
		//die ("<script>".$callback."('图片上传失败',false)</script>");
		echo json_encode($ret);
		die;
	}
	$result = json_decode(base64_decode($_GET['result']));
	if($result -> error > 0){
		$ret['error'] = 1 ;
		$ret['message'] = $result -> msg;
		echo json_encode($ret);
		die;
	}

	$ret['error'] = 0;
	$ret['message'] = $result -> msg;
	$ret['url']     = $result -> file;
	echo json_encode($ret);
}
callback();
?>
