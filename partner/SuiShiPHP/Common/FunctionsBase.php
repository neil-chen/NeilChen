<?php
/**
 * 全局共用函数
 *
 * @author paizhang  2012-05-10
 */
//获取配置信息
function C ($name = null, $value = null) {
	if ($value !== null) {
		return SuiShiPHPConfig::set($name, $value);
	}
	return SuiShiPHPConfig::get($name);
}
//加载model
function M ($model) {
	return loadModel($model);
}
//加载action
function A ($action) {
	return loadAction($action);
}

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
		if (class_exists('Logger')) {
			Logger::error ( "action file not exist : " . $file );
		}
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
	if (! file_exists ( $file ) && class_exists('Logger')) {
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
//将参数添加到指定url后
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

/**
 * 判断是否为ajax请求
 * @return bool
 */
function isAjax () {
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
		if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}
	}
	if(HttpRequest::get(SuiShiPHPConfig::get('VAR_AJAX_SUBMIT'))) {
		// 判断Ajax方式提交
		return true;
	}
	return false;
}

/**
 *  URL重定向
 */
function redirect($url,$time=0,$msg='')
{
	//多行URL地址支持
	$url = str_replace(array("\n", "\r"), '', $url);
	if(empty($msg))
		$msg    =   "系统将在{$time}秒之后自动跳转到{$url}！";
	if (!headers_sent()) {
		// redirect
		if(0===$time) {
			header("Location: ".$url);
		}else {
			header("refresh:{$time};url={$url}");
			echo($msg);
		}
		exit();
	}else {
		$str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
		if($time!=0)
			$str   .=   $msg;
		exit($str);
	}
}

/**
 * 输出json数据
 * @param mixed $data 主数据
 * @param int $error error code
 * @param string $msg error message
 */
function printJson ($data = null, $error = 0, $msg = '', $exit = true) {
	echo json_encode(array('data'=>$data, 'error'=>$error, 'msg'=>$msg));
	if ($exit === true) {
		myExit();
	}
}


/**
 * 终止程序函数
 */
function myExit($msg = '') {
	//TODO 处理终止前程序
	Factory::getSystemLog()->flush();
	if ($msg) echo $msg;
	exit();
}

//生成url
function url($action = null, $method = null, $params = array(), $prefixUrl = null) {
	$params[SuiShiPHPConfig::ACTION_NAME] = $action;
	$params[SuiShiPHPConfig::METHOD_NAME] = $method;
	$query = http_build_query($params);
	if(!isset($prefixUrl) || $prefixUrl == null){
		return  HttpRequest::getUri(). '/index.php' . ($query ? '?'.$query : '');
	}else{
		$prefixUrl = ltrim($prefixUrl,'/');
		return resetUrl(HttpRequest::getUri(). '/'.$prefixUrl,$params);		
	}
}

//子模板调用
function tpl($tplName) {
	Template::include_tpl($tplName);
}

/**
 * 获取微信token
 *
 * @param string $appId
 * @param string $appSercet
 * @param bool $refresh  如果cache中不存在是否刷新cache
 * @return string
 */
function getToken($appId, $appSercet, $refresh = true){

	$cacherId = SuiShiPHPConfig::get('WX_API_TOKEN') . $appId;
	$cacher = new RedisCache(SuiShiPHPConfig::get('REDIS_HOST_TOKEN'), SuiShiPHPConfig::get('REDIS_PORT_TOKEN'));
	$token = $cacher->get ( $cacherId );
	//TODO test
	//$token = '2FsxZXKoX6NAS9eV28UIZQz3YwoPXvBf2Gjr1O8bNl9nzKBpZub7_1zZ4gsWC1_LdzcwAJ7lW9oWLDghMWXvAn3w3Gcj63pX7ljpHprqCUE';
	if (true !== $refresh) {
		return $token;
	}
	if (! $token) {
		// 引入微信api
		if (! class_exists ( "WeiXinClient" )) {
			include_once dirname ( __FILE__ ) . "/../API/WeiXinApiCore.class.php";
		}
		$weixnApi = WeiXinApiCore::getClient ( $appId, $appSercet );
		$token = $weixnApi->getToken ();
		if ($token) {
			$token = $token->token;
			$cacher->set ( $cacherId, $token, 6600/*一小时50分钟*/);
		}
	}
	return $token;
}
/**
 * 获取微信ticket
 *
 * @param string $appId
 * @param string $appSercet
 * @param bool $refresh  如果cache中不存在是否刷新cache
 * @return string
 */
function getJsApiTicket($appId, $appSecret, $type = 'jsapi', $refresh = true) {
	$type = in_array($type, array('jsapi', 'wx_card')) ? $type : 'jsapi';
	if ('jsapi' == $type) {
		$cacherId = SuiShiPHPConfig::get('WX_JS_API_TICKET') . $appId;
	} else {
		$cacherId = SuiShiPHPConfig::get('WX_CARD_API_TICKET') . $appId;
	}

	$cacher = new RedisCache(SuiShiPHPConfig::get('REDIS_HOST_TOKEN'), SuiShiPHPConfig::get('REDIS_PORT_TOKEN'));
	$ticket = $cacher->get ( $cacherId );
	//TODO test
	//$token = '2FsxZXKoX6NAS9eV28UIZQz3YwoPXvBf2Gjr1O8bNl9nzKBpZub7_1zZ4gsWC1_LdzcwAJ7lW9oWLDghMWXvAn3w3Gcj63pX7ljpHprqCUE';
	if (true !== $refresh) {
		return $ticket;
	}
	if (! $ticket) {
		// 引入微信api
		if (! class_exists ( "WeiXinClient" )) {
			include_once dirname ( __FILE__ ) . "/../API/WeiXinApiCore.class.php";
		}
		$token = getToken($appId, $appSecret);
		$weixnApi = WeiXinApiCore::getClient ( $appId, $appSecret, $token);
		$ticket = $weixnApi->getJsApiTicket ($type);
		if ($ticket) {
			$cacher->set ( $cacherId, $ticket, 6600/*一小时50分钟*/);
		}
	}
	return $ticket;
}


/**
 * 过滤数组中无效的键值（一维数据）
 *
 * @param   array   $params 要过滤的参数
 * @param   array   $allow  要过滤的值
 *
 * @return  void
 */
function invalidDataFilter(array &$params, array $allow = array(null))
{
    if (!empty($params) && is_array($params) && !empty($allow) && is_array($allow)) {
        foreach ($params as $key => $val) {
            foreach ($allow as $v) {
                if ($val === $v) {
                    unset($params[$key]);
                }
            }
        }
    }
}

/**
 * 过滤数组中无效的键值（多维数据）
 *
 * @param   array   $params 要过滤的参数
 * @param   array   $allow  要过滤的值
 *
 * @return  void
 */
function invalidDataFilterRecursive(array &$params, array $allow = array(null))
{
    if (!empty($params) && is_array($params) && !empty($allow) && is_array($allow)) {
        foreach ($params as $key => $val) {
            if (is_array($val)) {
                invalidDataFilterRecursive($params[$key], $allow);
            } else {
                foreach ($allow as $v) {
                    if ($val === $v) {
                        unset($params[$key]);
                    }
                }
            }
        }
    }
}