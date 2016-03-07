<?php
/**
 * 全局共用函数
 *
 * @author paizhang  2012-05-10
 */

/**
 * 获取ip地址
 */
function getIp() {
	if (getenv ( 'HTTP_CLIENT_IP' )) {
		$ip = getenv ( 'HTTP_CLIENT_IP' );
	} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
		$ip = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} elseif (getenv ( 'HTTP_X_FORWARDED' )) {
		$ip = getenv ( 'HTTP_X_FORWARDED' );
	} elseif (getenv ( 'HTTP_FORWARDED_FOR' )) {
		$ip = getenv ( 'HTTP_FORWARDED_FOR' );
	} elseif (getenv ( 'HTTP_FORWARDED' )) {
		$ip = getenv ( 'HTTP_FORWARDED' );
	} else {
		$ip = $_SERVER ['REMOTE_ADDR'];
	}
	return empty ( $ip ) ? 'unknown' : $ip;
}

/**
 * 转义字符
 *
 * @param mixed $var
 */
function faddslashes($var) {
	if (is_array ( $var )) {
		foreach ( $var as $k => $v ) {
			$var [$k] = faddslashes ( $v );
		}
	} else {
		$var = addslashes ( $var );
	}
	return $var;
}
/**
 * 去除转义标签
 * @param mixed $var
 * @return mixed
 */
function tripslashes ($var) {
	if (is_array ( $var )) {
		foreach ( $var as $k => $v ) {
			$var [$k] = tripslashes( $v );
		}
	} else {
		$var = stripcslashes ( $var );
	}
	return $var;
}

/**
 * 转义html字符
 *
 * @param string|array $var
 */
function fhtmlspecialchars($var) {
	if (is_array ( $var )) {
		foreach ( $var as $k => $v ) {
			$var [$k] = fhtmlspecialchars ( $v );
		}
	} else if (is_string ( $var )) {
		$var = htmlspecialchars ( $var, ENT_COMPAT, 'UTF-8' );
	}
	return $var;
}

/**
 * 过滤html标签.
 *
 * @param string $var target string
 * @param string $tags 允许保留到标签,all 为去全部
 */
function fstripTags($var, $tags = 'all') {
	$tags = strval ( $tags );
	if ($tags !== 'all') {
		if (is_array ( $var )) {
			foreach ( $var as $k => $v ) {
				$var [$k] = fstripTags ( $v );
			}
		} else if (is_string ( $var )) {
			$var = strip_tags ( $var, $tags );
		}
	}
	return $var;
}

/**
 * 加载action
 *
 * @param string $action package 格式 从Action目录开始使用 "."分割
 */
function loadAction($action) {
	if (empty ( $action ))
		return null;
	static $actions = array ();
	if (isset ( $actions [$action] )) {
		return $actions [$action];
	}
	$actArr = explode ( '.', $action );
	if (count ( $actArr ) > 1) {
		$actionName = $actArr [count ( $actArr ) - 1] . 'Action';
	} else {
		$actionName = $action . 'Action';
	}
	$file = LIB_PATH . '/Action/' . str_replace ( '.', '/', $action ) . 'Action.class.php';
	if (! file_exists ( $file )) {
		Logger::error ( "action file not exist : " . $file );
		return null;
	}
	include_once ($file);
	$actions [$action] = new $actionName ();
	return $actions [$action];
}

/**
 * 加载model
 *
 * @param string $model	package 格式 从Model目录开始使用 "."分割
 */
function loadModel($model) {
	if (empty ( $model ))
		return null;
	static $models = array ();
	if (isset ( $models [$model] )) {
		return $models [$model];
	}
	$modelArr = explode ( '.', $model );
	if (count ( $modelArr ) > 1) {
		$modelName = $modelArr [count ( $modelArr ) - 1] . 'Model';
	} else {
		$modelName = $model . 'Model';
	}
	$file = LIB_PATH . '/Model/' . str_replace ( '.', '/', $model ) . 'Model.class.php';
	if (! file_exists ( $file )) {
		Logger::error ( "model file not exist : " . $file );
		return null;
	}
	include_once ($file);
	$models [$model] = new $modelName ();
	return $models [$model];
}

/**
 * 获取当前堆栈.
 */
function getBacktrace() {
	$traces = debug_backTrace ();
	$str = "\n\nback trace:";
	for($i = 1; $i < count ( $traces ); $i ++) {
		$trace = $traces [$i];
		$class = @$trace ['class'] ? @$trace ['class'] . @$trace ['type'] : '';
		$str .= "\n##$i " . @$trace ['file'] . " (" . @$trace ['line'] . "), call function $class" . @$trace ['function'] . "(";
		if ($i > 1) {
			foreach ( @$trace ['args'] as $arg ) {
				if (is_array ( $arg )) {
					$str .= "Array, ";
				} else if (is_Object ( $arg )) {
					$str .= "Object, ";
				} else if (is_bool ( $arg )) {
					$str .= $arg ? 'true, ' : 'false, ';
				} else {
					$str .= "$arg, ";
				}
			}
		}
		$str .= ");";
	}
	return $str;
}

/**
 * 加载某个目录下的php文件
 */
function loadDir($dir) {
	$dir = realpath ( $dir );
	$h = @opendir ( $dir );
	if (! $h) {
		return;
	}
	while ( false !== ($file = readdir ( $h )) ) {
		if (substr ( $file, 0, 1 ) == '.' || strtolower ( substr ( $file, - 3, 3 ) ) != 'php') {
			continue;
		}

		$realFile = $dir . '/' . $file;

		if (is_file ( $realFile )) {
			include_once $realFile;
		} else if (is_dir ( $realFile )) {
			loadDir ( $realFile );
		}
	}
	closedir ( $h );
}

/**
 * 截取字符串 参考 discuz
 */
function cutstr_dis($string, $length, $dot = '...') {
	if (strlen ( $string ) <= $length) {
		return $string;
	}

	$pre = chr ( 1 );
	$end = chr ( 1 );
	$string = str_replace ( array (
			'&amp;',
			'&quot;',
			'&lt;',
			'&gt;'
	), array (
			$pre . '&' . $end,
			$pre . '"' . $end,
			$pre . '<' . $end,
			$pre . '>' . $end
	), $string );

	$strcut = '';
	if (strtolower ( 'utf-8' ) == 'utf-8') {

		$n = $tn = $noc = 0;
		while ( $n < strlen ( $string ) ) {

			$t = ord ( $string [$n] );
			if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1;
				$n ++;
				$noc ++;
			} elseif (194 <= $t && $t <= 223) {
				$tn = 2;
				$n += 2;
				$noc += 2;
			} elseif (224 <= $t && $t <= 239) {
				$tn = 3;
				$n += 3;
				$noc += 2;
			} elseif (240 <= $t && $t <= 247) {
				$tn = 4;
				$n += 4;
				$noc += 2;
			} elseif (248 <= $t && $t <= 251) {
				$tn = 5;
				$n += 5;
				$noc += 2;
			} elseif ($t == 252 || $t == 253) {
				$tn = 6;
				$n += 6;
				$noc += 2;
			} else {
				$n ++;
			}

			if ($noc >= $length) {
				break;
			}
		}
		if ($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr ( $string, 0, $n );
	} else {
		for($i = 0; $i < $length; $i ++) {
			$strcut .= ord ( $string [$i] ) > 127 ? $string [$i] . $string [++ $i] : $string [$i];
		}
	}

	$strcut = str_replace ( array (
			$pre . '&' . $end,
			$pre . '"' . $end,
			$pre . '<' . $end,
			$pre . '>' . $end
	), array (
			'&amp;',
			'&quot;',
			'&lt;',
			'&gt;'
	), $strcut );

	$pos = strrpos ( $strcut, chr ( 1 ) );
	if ($pos !== false) {
		$strcut = substr ( $strcut, 0, $pos );
	}
	return $strcut . $dot;
}


/**
 * 截取小数点位数
 *
 * @param int $number 需要格式化的数字
 * @param int $precision 小数点后几位 默认是两位
 * @return string
 */
function subNumber($num, $prec = 2) {
	return sprintf ( "%01.2f", ($num), $prec );
}

function myRound ($val, $precision = 0) {
	$precision = (int)$precision;
	return sprintf ( "%.".$precision."f", $val);
}

/**
 * 获取微信token
 *
 * @param string $appId
 * @param string $appSercet
 * @param bool $refresh  如果cache中不存在是否刷新cache
 * @return string
 */
function getToken($appId, $appSecret, $refresh = true) {
	$cacherId = GlobalCatchId::WX_API_TOKEN . $appId;
	if ((defined ( "IS_LOCAL_MODULE" ) && IS_LOCAL_MODULE === true) || strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
		if ($appId == 'wx1f82add86fc7b5a5') {
			$data = @file_get_contents ( "http://call.socialjia.com/t.php?id=" . $cacherId );
			$data = trim ( $data );
			if (empty ( $data ) || ! $data = @unserialize ( $data )) {
				return null;
			}
			return @$data ['data'];
		}

		$cacher_host = ConfigBase::LOCAL_REMOTE_CACHER_HOST;
		$cacher_port = ConfigBase::LOCAL_REMOTE_CACHER_PORT;
	} else {
		$cacher_host = ConfigBase::REMOTE_CACHER_HOST;
		$cacher_port = ConfigBase::REMOTE_CACHER_PORT;
	}

	// 引入cacher
       if (false != ConfigBase::PUBLIC_SERVICE && class_exists('Redis')) {
		$cacher = Factory::getGlobalCacher();
	} else {
		if (! class_exists ( "RemoteCacher" )) {
			include_once dirname ( __FILE__ ) . "/../Cache/RemoteCacher.class.php";
		}
		$cacher = new RemoteCacher ( $cacher_host, $cacher_port, 'weixin' );
	}

	$token = $cacher->get ( $cacherId );
	if (true !== $refresh) {
		return $token;
	}
	if (! $token) {
		// 引入微信api
		if (! class_exists ( "WeiXinClient" )) {
			include_once dirname ( __FILE__ ) . "/../Api/WeiXinApiCore.class.php";
		}
		$weixnApi = WeiXinApiCore::getClient ( $appId, $appSecret );
		$token = $weixnApi->getToken ();
		if ($token) {
			$token = $token->token;
			$cacher->set ( $cacherId, $token, GlobalCatchExpired::WX_API_TOKEN );
		} else {
			if (class_exists("Logger")) {
				Logger::error("fun::getToken error: ".$weixnApi->getErrorMessage()."; code:".$weixnApi->getErrorCode());
			}
		}
	}
	return $token;
}


function clearToken ($appId) {
	$cacherId = GlobalCatchId::WX_API_TOKEN . $appId;
	//如果是本地运行
	if ((defined ( "IS_LOCAL_MODULE" ) && IS_LOCAL_MODULE === true) || strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
		$cacher_host = ConfigBase::LOCAL_REMOTE_CACHER_HOST;
		$cacher_port = ConfigBase::LOCAL_REMOTE_CACHER_PORT;
	} else {
		$cacher_host = ConfigBase::REMOTE_CACHER_HOST;
		$cacher_port = ConfigBase::REMOTE_CACHER_PORT;
	}
	// 引入cacher
	if (false != ConfigBase::PUBLIC_SERVICE && class_exists('Redis')) {
		$cacher = Factory::getGlobalCacher();
	} else {
		if (! class_exists ( "RemoteCacher" )) {
			include_once dirname ( __FILE__ ) . "/../Cache/RemoteCacher.class.php";
		}
		$cacher = new RemoteCacher ( $cacher_host, $cacher_port, 'weixin' );
	}
        return $cacher->clear($cacherId);
}


/**
 * 获取password
 *
 * @param string $salt
 * @param string[optional] $passd
 * @return string MD5
 */
function getPassword($salt, $passd = "123456") {
	if ($passd == null) {
		$passd = "123456";
	}
	return md5 ( md5 ( $passd ) . $salt );
}

/**
 * 获取salt值
 *
 * @param int $minLength 密钥的最小长度
 * @param int $maxLength 密钥最大长度
 * @return string
 */
function getSalt($minLength = 5, $maxLength = 10) {
	$salt_data = array (
			'0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g',
			'!','@','#','$','%','^','&','*','(',')','-','+','='
	);
	$num = rand ( $minLength, $maxLength );
	$salt = '';
	for($i = 0; $i <= $num; $i ++) {
		$salt .= $salt_data [array_rand ( $salt_data )];
	}
	return $salt;
}

/**
 * 获取微信web链接
 *
 * @param Array $param
 * @return string the url
 */
function getWxWebUrl($param) {
	$token = encodeWxWebToken ( $param );
	return ConfigBase::WX_WEB_REQUEST_URI . '?' . ConfigBase::WX_WEB_TOKEN_NAME . '=' . urlencode ( $token );
}

/**
 * 获取微信web链接token
 * #note:参数 $param 中禁止使用'=',';' ,key中禁止使用'sig','time' ,并且是一维数组#
 *
 * @param array $param
 * @return string
 */
function encodeWxWebToken($param, $isTimer = true) {
	$arr = array ();
	if ($param) {

		foreach ( $param as $k => $v ) {
			array_push ( $arr, $k . '=' . $v );
		}
	}
	if ($isTimer) {
		$arr [] = 'time=' . time ();
	}
	$arr [] = 'sig=' . genWxWebTokenSig_ ( implode ( ';', $arr ) );
	$str = implode ( ';', $arr );
	return base64_encode ( $str );
}

/**
 * 转义微信web链接token
 *
 * @param string $token
 * @return array
 */
function decodeWxWebToken($token) {
	$token = base64_decode ( trim ( $token ) );
	if (! $token)
		return false;

	$tokenArr = explode ( ';', $token );
	if (! $tokenArr)
		return false;

	$tokenParam = array ();
	$tokenCheck = array ();
	foreach ( $tokenArr as $k => $v ) {
		$oneArr = explode ( '=', $v );
		if ($oneArr && @$oneArr [0]) {
			$tokenParam [$oneArr [0]] = @$oneArr [1];
			if ($oneArr [0] != 'sig') {
				array_push ( $tokenCheck, $v );
			}
		}
	}
	$tokenSig = isset ( $tokenParam ['sig'] ) ? trim ( $tokenParam ['sig'] ) : '';
	if (! $tokenSig)
		return false;

	unset ( $tokenParam ['sig'] );
	$newSig = genWxWebTokenSig_ ( implode ( ';', $tokenCheck ) );
	if ($tokenSig != $newSig) {
		// 签名无效
		return false;
	}
	return $tokenParam;
}

/**
 * 生成签名,
 *
 * @param string $str
 * @return string
 * @internal
 *
 */
function genWxWebTokenSig_($str) {
	return md5 ( $str . ConfigBase::WX_WEB_TOKEN_KEY );
}

/**
 * 群发任务队列导入通知
 * @param int $taskId
 * @return bool
 */
function importTaskData ($taskId) {
	//PHP路径
	$php_cli_path = ConfigBase::PHP_CLI_PATH;
	$dir_path = dirname(__FILE__) . '/../CPU/Shells/MassMessage/ImportTaskData.shell.php';
	$cmd = "{$php_cli_path} {$dir_path} {$taskId} &";
	//开启进程
	$out = popen($cmd, "r");
	Logger::debug('cmd: ' . $cmd."  status: ". (int)!!$out);
	pclose($out);
	return !!$out;
}

function genShortLinkByToken ($token, $param = null) {
	if (!$token) {
		return null;
	}
	return ConfigBase::WX_SHORT_LINK_URI . $token . ($param?('?' . http_build_query($param)):'');
}

/**
 * 计算时间差
 * @param string|timestamp $begin_time
 * @param string $end_time
 * @return string
 */
function time_diff($begin_time, $end_time = null)
{
	if (! is_numeric($begin_time)) {
		$begin_time = strtotime($begin_time);
	}
	$end_time = $end_time ? $end_time : time();

	if($begin_time < $end_time){
		$starttime = $begin_time;
		$endtime = $end_time;
	}
	else{
		$starttime = $end_time;
		$endtime = $begin_time;
	}

	$timediff = $endtime-$starttime;
	$days = intval($timediff/86400);
	$remain = $timediff%86400;
	$hours = intval($remain/3600);
	$remain = $remain%3600;
	$mins = intval($remain/60);
	$secs = $remain%60;

	$time_format = '';
	if ($days) {
		$time_format .= $days.'天';
	}
	if ($hours) {
		$time_format .= $hours.'小时';
	}
	if ($mins) {
		$time_format .= $mins.'分钟';
	}
	if ($secs) {
		$time_format .= $secs.'秒';
	}
	return $time_format;
}
/**
 * 生成与第三方通讯认证参数
 * @param string $apiKey
 * @param string $apiSecret
 * @return array
 */
function getAuthQueryData ($apiKey, $apiSecret) {
	$timestamp = time();
	return array(
			ConfigBase::REQUEST_AUTH_API_KEY => $apiKey,
			ConfigBase::REQUEST_AUTH_TIMESTAMP => $timestamp,
			ConfigBase::REQUEST_AUTH_SIGNATURE => md5($apiKey.$apiSecret.$timestamp)
	);
}
//生成带参数二维码链接参数
function getQrcAuthQueryData ($apiKey, $apiSecret, $param) {
	$timestamp = time();

	$param[ConfigBase::REQUEST_AUTH_API_KEY] = $apiKey;
	$param[ConfigBase::REQUEST_AUTH_TIMESTAMP] = $timestamp;
	$param[ConfigBase::REQUEST_AUTH_SIGNATURE] = getQrcAuthSig($apiKey, $apiSecret, $param);
	return $param;

}
//生成带参数二维码签名
function getQrcAuthSig ($apiKey, $apiSecret, $param) {
	$param = array_merge(array_values($param), array($apiKey, $apiSecret));
	$param = array_unique($param);
	foreach ($param as $key => $p) {
		$param[$key] = (string)$p;
	}
	sort($param,SORT_STRING);
	$str = implode('', $param);
	return md5($str);
}

/**
 * 生成一般签名
 * @param array $param
 * @return string
 */
function genSimpleSig ($param) {
	ksort($param);
	$str = implode(",", $param);
	return md5($str.ConfigBase::WX_WEB_TOKEN_KEY);
}
/**
 * 生成微信OAuth 2.0 请求链接
 * @param string $appId
 * @param string $apiKey
 * @param string $apiSecret
 * @param string $scope oauth2.0 权限
 * @param array $redirectParam 参数
 * @return string
 */
function genWxOAuthUrl ($appId, $apiKey, $apiSecret, $scope, $authData, $redirectParam) {
	$redirectUrlParam = getQrcAuthQueryData($apiKey, $apiSecret, $authData);
	if (!empty($redirectParam) && is_array($redirectParam)) {
		$redirectUrlParam = array_merge($redirectUrlParam, $redirectParam);
	}
	$redirectUrl = resetUrl(Config::SH_WX_OAUTH_CALLBACK_URL, $redirectUrlParam);
	$redirectUrl = Config::SH_WX_OAUTH_CALLBACK_URL . '?' . http_build_query($redirectUrlParam);
	$matchs = array('APP_ID','REDIRET_URI','SCOPE','STATE');
	$replace = array($appId, urlencode($redirectUrl), $scope, QrCodeParamter::STATE_VALUE);
	return str_replace($matchs, $replace, Config::SCAN_WX_URL);
}


function parseImageUrl($url){
	if(!$url) return null;
	if (strrpos($url, 'mmsns.qpic.cn') === false) {
		return $url;
	}
	return '/image.php?url='.urlencode(trim($url));
}

function parseMediaUrl ($url) {
	if(!$url) return null;
	return "/media.php?url=".urlencode($url);
}

/**
 * 根据dialog id 生成媒体资源url
 * @param int $entId
 * @param int $dialogId
 * @return string
 */
function getMediaUrlByDialogId ($entId, $dialogId) {
	if(!$dialogId) return null;
	$params = array(
			'a' => 'Media',
			'm' => 'source',
			'dialog_id' => $dialogId,
			'ent_id' => $entId
			);
	$params['sig'] = genSimpleSig($params);
	return '/Resource/index.php?'.http_build_query($params);
}

/**
 * 根据task id 生成媒体资源url,群发历史里使用
 * @param int $entId
 * @param int $TaskId
 * @param bool $isMass 是群发的还是api
 * @return string
 */
function getMediaUrlByTaskId ($entId, $TaskId, $isMass = true) {
	if(!$TaskId) return null;
	$params = array(
			'a' => 'Media',
			'm' => $isMass ? 'massSource' : 'apiSource',
			'task_id' => $TaskId,
			'ent_id' => $entId
	);
	$params['sig'] = genSimpleSig($params);
	return '/Resource/index.php?'.http_build_query($params);
}

/**
 * 根据media id 生成媒体资源url,客服，企业后台使用
 * @param int $entId
 * @param string $mediaId
 * @param string $toType
 * @return NULL|string
 */
function getMediaUrlByMediaId ($entId, $mediaId, $toType = 'mp3') {
	if(!$entId || !$mediaId || !$toType) return null;
	$params = array(
			'a' => 'Media',
			'm' => 'sourceWithMediaId',
			'media_type' => $toType,
			'ent_id' => $entId,
			'media_id'=>$mediaId
	);
	$params['sig'] = genSimpleSig($params);
	return '/Resource/index.php?'.http_build_query($params);
}

/**
 * 向第三方push 数据
 * @param string $apiKey
 * @param string $apiSecret
 * @param string $type  ThirdPartyPushType 中定义
 * @param string $message  数据采集子系统客户上行原始信息（xml）
 * @param string $openId
 * @param unknown_type $oparId
 */
function pushToThirdParty ($apiKey, $apiSecret, $url, $type, $message, $openId = '',
		$oparId = 0)
{
	if (!class_exists("RequestClient")) {
		include_once dirname(__FILE__) . '/../Http/RequestClient.class.php';
	}
	$url = trim($url,'&');
	$param = getAuthQueryData($apiKey, $apiSecret);
	$param['type'] = $type;
	switch ($type) {
		case PushToThirdpartyKey::CLOSE_SESSION://关闭会话
			$param['openid'] = $openId;
			$param['operatorid'] = $oparId;
			$postStr = '';
			break;
		case PushToThirdpartyKey::TEXT:
		case PushToThirdpartyKey::IMAGE:
		case PushToThirdpartyKey::LOCATION:
		case PushToThirdpartyKey::SUBSCRIBE:
		case PushToThirdpartyKey::UNSUBSCRIBE:
			$postStr = $message;
			break;
		default:
			return false;
	}
	$url = sprintf($url.'%s'.http_build_query($param), ((strrpos($url, '?') === false)?'?':'&'));
	RequestClient::request(RequestClient::POST, $url, 80, array(), $postStr);
	if (RequestClient::$httpCode != 200 && class_exists("Logger")) {
		Logger::error("pushToThirdParty error from base function", RequestClient::$httpInfo);
		return false;
	}
	return true;
}

/**
 * pv code
 */
function getMonitorPVCode ($entId, $posId)
{
	return '&lt;script&gt;'
		.'var __SUISHI_MONITOR_PARAM__ = {'
		.'fn:\' __SUISHI_MONITOR__.original\','
		.'ent_id: '.$entId.','
		.'point4_id:' . $posId
		.'}&lt;/script&gt;'
		.'&lt;script src="http://pic.weibopie.com/weixin/monitor/monitorPV.js"&gt;&lt;/script&gt;';
}

/**
 * click code
 */
function getMonitorClickCode ($entId, $campaignID, $creativeId, $posID,$mediaId,
		$sourcePosID, $visitId, $t)
{
	$param = array(
			$entId,
			$campaignID,
			$creativeId,
			$posID,
			$mediaId,
			$sourcePosID,
			$visitId,
			't='.$t
	);
	return ConfigBase::MONITOR_PATH . '?'. implode(";", $param);
}


//生成短链(二维码用)
function makeShortUrl($url){
	$make_url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=1681459862&url_long='.urlencode($url);
	$content = @file_get_contents($make_url);
	$data = json_decode($content,true);
	if(!$data){
		return false;
	}
	return $data[0]['url_short'];
}


//生成二维码图片 返回图片地址
function makeQrcodeImage( $url, $size = 50, $EC_level = 'L', $margin = '0' ){
	//获取二维码图片流
	$ch = curl_init();
	$url = urlencode($url);
	curl_setopt($ch, CURLOPT_URL, 'http://chart.apis.google.com/chart');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$response = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	if($info['http_code']!=200){
		return false;
	}
	//保存图片
	$fileName = '/tmp/'.uniqid('tmp_').'.png';
	$fp = fopen($fileName,'w+');
	fwrite($fp,$response);
	fclose($fp);

	//模拟上传到图片服务器
	$url = "http://pic.weibopie.com/imgUpload/action/weixin/UploadImage.php";
	$post_data = array (
		"upfile" =>'@'.$fileName,
		'upTypes'=>'.png',
		'printFormat' => 'json'
	);
	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL, $url);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Expect:'));
	$output = curl_exec($ch2);
	$info = curl_getinfo($ch2);
	curl_close($ch2);
	if($info['http_code']!=200){
		@unlink($fileName);
		return false;
	}
	@unlink($fileName);
	$return = json_decode($output,true);
	if($return['error']!=0){
		return false;
	}
	return $return['file'];
}

/**
 * 生成图文监测
 * @param array $news 图文数据
 * @param array $monitorData 监测数据
 * @param array $params 附加参数 appKey, appSecret, openId
 * @param WX_Message 上行消息对象
 * @return array
 */
function genNewsMonitor($news, $monitorData, $params, $message = null) {
	$newsMonitor = array();
	if (! $news  ||! is_array($news)) {
		return $newsMonitor;
	}

	foreach ($news as $k => $v) {
		if ($v['news_text']) {
			$url = genNewsTextUrlWithMonitorData($v['news_index'], $monitorData, $params, $message);
		} else {
			$url = genNewsOriginalUrlWithMonitorData($v['news_index'], $v['url'], $monitorData, $params, $message);
		}
		$newsMonitor[$k]['title'] = $v['title'];
		$newsMonitor[$k]['description'] = $v['description'];
		$newsMonitor[$k]['picurl'] = $v['picurl'];
		$newsMonitor[$k]['url'] = $url;
	}
	return $newsMonitor;
}

/**
 * 生存图文正文URL带监测数据
 * @return string
 */
function genNewsTextUrlWithMonitorData($newsIndex, $monitorData, $params, $message)
{
	if (! $newsIndex || (! isset($monitorData[MonitorParams::MATERIAL_ID]) && ! $monitorData[MonitorParams::MATERIAL_ID])) {
		return null;
	}

	$queryData = array(
			MonitorHttpParams::MATERIAL_ID => (int) $monitorData[MonitorParams::MATERIAL_ID],
			MonitorHttpParams::INDEX => $newsIndex,
			MonitorHttpParams::MONITOR_DATA => formatMonitorData($newsIndex, $monitorData, $message),
			MonitorHttpParams::OPEN_ID => $params[MonitorHttpParams::OPEN_ID]
	);

	$queryData = getQrcAuthQueryData($params[Config::REQUEST_AUTH_API_KEY], $params[Config::REQUEST_AUTH_API_SECRET], $queryData);
	$queryData[MonitorHttpParams::M_FROM] = $params[MonitorHttpParams::M_FROM];
	$queryData[MonitorHttpParams::OAUTHED] = $params[MonitorHttpParams::OAUTHED];
	$url = Config::NEWS_TEXT_URL . (false == strrpos(Config::NEWS_TEXT_URL, '?')?'?':'&').http_build_query($queryData);
	return $url;
}

/**
 * 生成图文原文URL带监测数据
 * @return string
 */
function genNewsOriginalUrlWithMonitorData($newsIndex, $newsUrl, $monitorData, $params, $message)
{
	if (! $newsUrl) {
		return null;
	}
	if (! $monitorData || ! is_array($monitorData)) {
		return $newsUrl;
	}

	$target = $newsUrl;
	$queryData = array(
			MonitorHttpParams::MONITOR_DATA => formatMonitorData($newsIndex, $monitorData, $message),
			MonitorHttpParams::OPEN_ID => $params[MonitorHttpParams::OPEN_ID]
	);
	$queryData = getQrcAuthQueryData($params[Config::REQUEST_AUTH_API_KEY], $params[Config::REQUEST_AUTH_API_SECRET], $queryData);
	$queryData[MonitorHttpParams::M_FROM] = $params[MonitorHttpParams::M_FROM];
	$queryData[MonitorHttpParams::OAUTHED] = $params[MonitorHttpParams::OAUTHED];
	$queryData[MonitorHttpParams::TARGET] = $target;
	return resetUrl(Config::NEWS_ORIGINAL_URL, $queryData);
}

/**
 * 格式化监测数据
 */
function formatMonitorData($newsIndex, $monitorData, $message)
{
	$formatArray = array(
			MonitorParams::ENT_ID => (int) @$monitorData[MonitorParams::ENT_ID],
			MonitorParams::MATERIAL_ID => trim(@$monitorData[MonitorParams::MATERIAL_ID]),
			MonitorParams::MATERIAL_INDEX => @$newsIndex,
			MonitorParams::SOURCE_ID => @$monitorData[MonitorParams::SOURCE_ID],
			MonitorParams::MOUDEL => @$monitorData[MonitorParams::MOUDEL],
			MonitorParams::MODUEL_ID => @$monitorData[MonitorParams::MODUEL_ID],
			MonitorParams::RULE_ID => @$monitorData[MonitorParams::RULE_ID],
			MonitorParams::OPERATOR_ID => @$monitorData[MonitorParams::OPERATOR_ID],
			MonitorParams::USE_OAUTH => @$monitorData[MonitorParams::USE_OAUTH],
			MonitorParams::MSG_SOURCE => @$monitorData[MonitorParams::MSG_SOURCE],
			MonitorParams::QRC_APP_ID => @$monitorData[MonitorParams::QRC_APP_ID],
			MonitorParams::EVENT_KEY => @$monitorData[MonitorParams::EVENT_KEY],
			MonitorParams::MATERIAL_SOURCE => @$monitorData[MonitorParams::MATERIAL_SOURCE],
			MonitorParams::EVENT_TYPE => ''
	);
	if (is_object($message) && $message->event && $message->event->event_type) {
		$formatArray[MonitorParams::EVENT_TYPE] = $message->event->event_type;
	}
	return implode(MonitorParams::DELIMITER, $formatArray);
}
//j将参数添加到指定url后
function resetUrl ($url, $queryData = array()) {
	if (empty($queryData) || !is_array($queryData)) {
		return $url;
	}
	$fragment = '';
	$findex = strpos($url, '#');
	if (false !== $findex) {
		$fragment = substr($url, $findex);
	}
	$url = rtrim(str_replace($fragment, '', $url), '&');
	$url = $url.(false == strrpos($url, '?')?'?':'&').http_build_query($queryData).$fragment;
	return $url;
}
