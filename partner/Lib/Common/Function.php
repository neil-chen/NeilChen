<?php
/**
 * 二维数组排序
 * @param array $array
 * @param string $keys
 * @param string $type
 * @return string|Ambigous <multitype:, unknown>
 */
function array_sort($array, $keys, $type = 'desc') {
	if ( ! isset($array) || ! is_array($array) || empty($array)) {
		return '';
	}
	if ( ! isset($keys) || trim($keys) == '') {
		return '';
	}
	if ( ! isset($type) || $type=='' || !in_array(strtolower($type),array('asc','desc'))) {
		return '';
	}
	$keysvalue=array();
	foreach ($array as $key=>$val) {
		$val[$keys] = str_replace('-','',$val[$keys]);
		$val[$keys] = str_replace(' ','',$val[$keys]);
		$val[$keys] = str_replace(':','',$val[$keys]);
		$keysvalue[] =$val[$keys];
	}
	asort($keysvalue); //key值排序
	reset($keysvalue); //指针重新指向数组第一个
	foreach ($keysvalue as $key=>$vals) {
		$keysort[] = $key;
	}
	$keysvalue = array();
	$count=count($keysort);
	if (strtolower($type) != 'asc') {
		for($i=$count-1; $i>=0; $i--) {
			$keysvalue[] = $array[$keysort[$i]];
		}
	} else {
		for($i=0; $i<$count; $i++) {
			$keysvalue[] = $array[$keysort[$i]];
		}
	}
	return $keysvalue;
}
/**
 * 时间变成多少分钟前
 * @param datetime $date
 */
function changeTime ($date) {

	$curr = time();
	$date = strtotime($date);
	$tmp = $curr - $date;
	if($tmp < 60){
		$re = $tmp.'秒前';
	}else if($tmp < 3600){
		$re = floor($tmp/60).'分钟前';
	}else if($tmp < 86400){
		$re = floor($tmp/3600).'小时前';
	}else if($tmp < 259200){//3天内
		$re = floor($tmp/86400).'天前';
	}else{
		$re = date('m月d日',$date);
	}
	return $re;

}
/**
  * 时间检测函数
  * @param string $sTime 
  * @param type $type 日期格式
  * @return boolean
  */
function isTime($sTime , $type = 'Y-m-d') {
	$status = 0;
	switch ($type)
	{
		case 'Y-m-d H:i:s':
			if (preg_match("/^[0-9]{4}\-[][0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $sTime)) {
				$status = 1;
			} else {
				$status = 0;
			}
			break;
		case 'Y-m-d':
			if (preg_match("/^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$/", $sTime)) {
				$status = 1;
			} else {
				$status = 0;
			}
			break;
		default:
			if (preg_match("/^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$/", $sTime)) {
				$status = 1;
			} else {
				$status = 0;
			}
	}
	return $status;
}
/**
 +----------------------------------------------------------
 * 把返回的数据集转换成Tree
 +----------------------------------------------------------
 * @access public
 +----------------------------------------------------------
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 +----------------------------------------------------------
 * @return array
 +----------------------------------------------------------
 */
function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
	// 创建Tree
	$tree = array();
	if(is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data[$pk]] =& $list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$parentId = $data[$pid];
			if ($root == $parentId) {
				$tree[] =& $list[$key];
			}else{
				if (isset($refer[$parentId])) {
					$parent =& $refer[$parentId];
					$parent[$child][] =& $list[$key];
				}
			}
		}
	}
	return $tree;
}
 
/**
 * url编码原生中文字符串 xieph
 * @param unknown $data
 * @return string
 */
function code_unescaped($data){
	if(version_compare(PHP_VERSION,'5.4.0','<')){
		$data=array_map('code_urlencode', $data);
		$code = urldecode(json_encode($data));
		return $code;
	}
	return urldecode(json_encode($data,JSON_UNESCAPED_UNICODE));
}

/**
 * url编码数组和字符串 xieph
 * @param array|string $data
 * @return array|string
 * 因php5.4版本不支持，并且传入的内容有双引号，加上addslashes
 */
function code_urlencode($data){
	if(is_array($data)){
		foreach ($data as $k=>$v){
			if(is_bool($v)) { //布尔型不作处理
				$data[urlencode($k)]=$v;
			} else {
				$v=is_array($v) ? array_map('code_urlencode', $v) : urlencode(addslashes($v));
				$data[urlencode($k)]=$v;
			}
		}
		return $data;
	}else{
		//布尔型不作处理
		if(is_bool($data)) {
			return $data;
		}
		return urlencode(addslashes($data));
	}
}


/**
 * 检查签名
 * Enter description here ...
 * @param unknown_type $param
 * @param unknown_type $appKey
 * @param unknown_type $appSecret
 */

function checkSig($param,$appKey,$appSecret){
	$timestamp = $param['timestamp'];
	if($appKey != $param['apiKey']){
		Logger::error("bind签名验证错误,apiKey参数不正确",$param);
		return false;
	}
	if(!$timestamp || (time() - $timestamp)>10*60){
		Logger::error("bind签名验证错误,无timestamp参数,或已超时",$param);
		return false;
	}
	$newsig = md5($appKey.$appSecret.$timestamp);
	if(!$param['sig'] || $newsig!=$param['sig']){
		Logger::error("bind签名验证错误,无sig参数,或签名错误,newsig:".$newsig,$param);
		return false;
	}
	return true;
}
/**
 * 输出json数据
 * @param mixed $data 主数据
 * @param int $code error code
 * @param string $msg error message
 */
function printJsonCode ($data = null, $code = 0, $msg = '', $exit = true) {
	echo json_encode(array('data'=>$data, 'code'=>$code, 'msg'=>$msg));
	if ($exit === true) {
		myExit();
	}
}

/**
* SQL防注入参数过滤
* @param type $param
* @return type
*/
function checkInput($param) {
    if (is_array($param) && count($param)) {
        foreach ($param as $key => $val) {
            $param[$key] = addslashes($val);
        }
    }
    if (is_string($param)) {
        $param = addslashes($param);
    }
    return $param;
}