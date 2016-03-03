<?php
/**
 * 图片上传类
 * http参数：
	1，formName：file input name定义，默认upfile
	2，printFormat：输出格式，html或json或proxy，默认为html，如果有跨域为题请使用proxy模式
	3，callback：js函数名称，默认parent.callback，当printFormat为html时会调用此函数
	   当printFormat为html：输出为js代码callback({'error': 0, 'msg': 'message', 'file': 'img url'});
	   当printFormat为json：输出 {'error': 0, 'msg': 'message', 'file': 'img url'}
	4，proxy_url: 代理url, 当printFormat为proxy时此参数必传,result和callback将以get方式传递
 *@author grh
 */

error_reporting(0);
ini_set('display_errors', 'off');
header("Content-Type:text/html; charset=utf-8");

define("DOCUMENT_ROOT", dirname(dirname(dirname(__FILE__))));
define('FILE_SAVE_PATH', DOCUMENT_ROOT . '/weixinapp/upload');

class UploadImage
{	
	public static $urlPath = 'http://pic.weibopie.com/imgUpload/weixinapp/upload/';
	//public static $uploadPath = './upload';     //上传图片路径
	public static $uploadPath = FILE_SAVE_PATH;     //上传图片路径
	public static $max_file_size = 2000000;     //上传图片大小
	public static $uptypes = array(             //上传图片支持类型
								'.jpg',
					    		'.jpeg',
							    '.png',
							    '.pjpeg',
							    '.gif',
							    '.bmp',
							    '.zip'
							);
	public static $formName = 'upfile';   //form file name
	public static $callback = 'parent.callback';  //callback function name 
	public static $printFormat = 'html';
	
	/**
	 * 文件上传
	 */
	public function uploadFile () {	
		$this->initUpTypes();
		$file_size_max = (int)@$_REQUEST['max_size'];
		if ($file_size_max > 0) {
			self::$max_file_size = $file_size_max;
		}
		
		$callback = trim(@$_REQUEST['callback']);
		if (!empty($callback)) {
			self::$callback = $callback;
		}
		$printFormat = strtolower(trim(@$_REQUEST['printFormat']));
		if (!empty($printFormat) && in_array($printFormat, array('json', 'html','proxy'))) {
			self::$printFormat = $printFormat;
		}
		
		$formFileName = trim(@$_REQUEST['formName']);
		if (!empty($formFileName)) {
			self::$formName = $formFileName;
		}

		$file = $_FILES[self::$formName];
		if (empty($file)) {
			echo self::printResult('', 'resource'); //图片资源不可用
	        exit();
		}
		$uploadPath = self::$uploadPath;	
		
		if ($file["size"] == 0 || $file["error"] > 0) {
			 echo self::printResult('', 'resource'); //图片资源不可用
	         exit();
		}
		if (!is_uploaded_file($file['tmp_name'])){ 
	         echo self::printResult('', 'invalid'); //图片不存在
	         exit();
	    }	    
	    if(self::$max_file_size < $file["size"]){
	        echo self::printResult('', 'size');     //检查文件大小
	        exit;
	    }	
	    $fileType = $this->getFileType($file['name']);
	    if(!in_array($fileType, self::$uptypes)){
	        echo self::printResult('', 'type');     //检查文件类型
	        exit;
	    }	
	    if(!file_exists($uploadPath)) {
	    	mkdir($uploadPath,0777, true);   //检查文件目录是否存在
	    }
	    
	    $filename=$file["tmp_name"];
	    $filePath=pathinfo($file["name"]);//返回文件路径的信息
	    $suffix = $filePath["extension"];  //文件后缀
		$imgDate=date("YmdHis");
		$name = $imgDate . rand("1000", "9999") . "." . $suffix;
		$fname = self::$urlPath.$name;			    
	    if (file_exists($fname)){
	        echo self::printResult('', 'exsit'); 	//同名文件已经存在了
	        exit;
	    }
	    if(!move_uploaded_file ($filename, $uploadPath . "/" .$name)){
	        echo self::printResult('', 'move');  	//移动文件出错
	        exit;
	    }   
	    echo self::printResult($fname);
	}
	
	/**
	 * 初始化可以上传文件类型
	 */
	public function initUpTypes () {
		$upTypes = @$_REQUEST['upTypes'];
		if (!$upTypes) {
			return;
		}
		$typeArr = explode(',', $upTypes);
		if (!$typeArr) {
			return;
		}
		$arr = array();
		foreach ($typeArr as $v) {
			$v = strtolower(trim($v));
			array_push($arr, $v);
		}
		//var_dump($arr);
		self::$uptypes = $arr;
	}
	
	public function getFileType ($fileName) {
		$type = substr($fileName, strrpos($fileName, '.'));
		return strtolower(trim($type));
	}
	
	/**
	 * 输出返回信息
	 * @param string $file_path  上传文件的路径
	 * @param string $errorType  错误类型
	 */
	function printResult($file_path, $errorType = null) {
	    $result = array('error'=>0, 'msg'=>'', 'file'=>'');
	    if ($errorType === null){
	        $result['file'] = $file_path;
	    } else {
	        switch ($errorType) {
	            case "size":
	                $result['error'] = 1;
	                $result['msg'] = '上传文件过大';
	                break;
	            case 'type':
	                $result['error'] = 2;
	                $result['msg'] = '上传文件类型错误';
	                break;
	            case 'exsit':
	                $result['error'] = 3;
	                $result['msg'] = '上传文件已存在';
	                break;
	            case 'invalid':
	                $result['error'] = 4;
	                $result['msg'] = '上传文件无效';
	                break;
	            case 'resource':
	                $result['error'] = 5;
	                $result['msg'] = '图片资源不可用';
	                break;
	            default:
	               $result['error'] = 6;
	               $result['msg'] = '上传文件失败';     
	        }
	    }
		if (self::$printFormat == 'json') {
			echo json_encode($result);exit;
		} else if (self::$printFormat == 'proxy') {
			$url = @$_REQUEST['proxy_url'];
			if ($url) {
				header("Location: " . self::genCallbackUrl($url, $result));
			} else {
				echo "当参数printFormat为proxy 时，参数proxy_url为必传参数";
			}
			exit;
		}
		$str = '<html>';
		$str.= '<head>';
		$str.= '</head>';
		$str.= '<body>';
		$str.= '<script type="text/javascript">';
		$str.= self::$callback . "(".json_encode($result).");";
		$str.= '</script>';
		$str.= '</body>';
		$str.= '</html>';
	    echo  $str; exit;
	}
	
	
	private function genCallbackUrl ($url, $result) {
		$param = array('callback' => self::$callback,
						'result' => base64_encode(json_encode($result)),	
				);
		$index = strpos($url, '?');
		return $url . ($index === false ? '?' : '&') . http_build_query($param);
	}
}

$img = new UploadImage();
$img->uploadFile();
