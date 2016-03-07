<?php
/**
 * 这里是消息流核心处理类文件
 */
class SuiShiPHPCPU
{
	/**
	 * 消息
	 * @var WX_Message
	 */
	private static $_message;

	/**
	 * 原始消息
	 * @var string<xml>
	 */
	private static $_msgStr;
	/**
	 * 与威信响应超时时间 单位秒
	 * @var int
	 */
	const REPLY_TIMEOUT = 5;
	/**
	 * 公共平台接收参数名称
	 * @var string
	 */
	const PARAM_TOKEN = 'token';
	const WX_WEB_TOKEN_KEY = 'ZHP,MXG,ZHPENG,GRH,ZHX,ZHTP';
	//http请求code
	private static $_HTTP_CODE = 0;
	//http请求详细信息
	private static $_HTTP_INFO = NULL;
	//第三方返回的原始信息
	private static $_HTTP_RESPONSE;
	//自定义错误
	private static $_ERROR = '';
	//操作
	private static $_ACTION = '';
	//超时时间
	private static $_TIME_OUT = 3; //秒
	//http error code
	private static $_HTTP_ERROR_CODE = 0;
	//http error
	private static $_HTTP_ERROR = '';

	private static $_noThreadMsgType = array ('text', 'news', 'music');

	/**
	 * 入口
	 */
	public static function run()
	{
		//解析我们自己的token
		$tokenParam = self::_parseToken();
		if (! $tokenParam) {
			self::_errorLog('tokenParam is null');
			exit();
		}
		$token = $tokenParam['token'];
		//验证来源是否是微信
		if (! self::_checkSignature($token)) {
			self::_errorLog('验证来源是否是微信失败');
			exit();
		}
		//验证是否为初次接入
		self::_isAccess();

		//响应微信发送的消息数据
		self::_responseMsg();
	}

	/**
	 * 是否是初次接入微信公共平台
	 * @param string $token
	 * @return boolean
	 */
	private static function _isAccess()
	{
		if (isset($_GET["echostr"]) && ! empty($_GET["echostr"])) {
			echo $_GET["echostr"];
			exit();
		}
	}

	/**
	 * 解析url设定的token值
	 * @return false|array
	 */
	private static function _parseToken()
	{
		$token = @$_GET[self::PARAM_TOKEN];
		$tokenParam = self::_decodeWxWebToken($token);
		if (! isset($tokenParam['token']) && empty($tokenParam['token'])) {
			self::_errorLog('SuiShiPHPCPU->_parseToken:token', $token);
			self::_errorLog('SuiShiPHPCPU->_parseToken:decodeWxWebToken', $tokenParam);
			return false;
		}
		return $tokenParam;
	}

	/**
	 * 转义微信web链接token
	 *
	 * @param string $token
	 * @return array
	 */
	private static function _decodeWxWebToken($token)
	{
		$token = base64_decode(trim($token));
		if (! $token)
			return false;

		$tokenArr = explode(';', $token);
		if (! $tokenArr)
			return false;

		$tokenParam = array ();
		$tokenCheck = array ();
		foreach ($tokenArr as $k => $v) {
			$oneArr = explode('=', $v);
			if ($oneArr && @$oneArr[0]) {
				$tokenParam[$oneArr[0]] = @$oneArr[1];
				if ($oneArr[0] != 'sig') {
					array_push($tokenCheck, $v);
				}
			}
		}
		$tokenSig = isset($tokenParam['sig']) ? trim($tokenParam['sig']) : '';
		if (! $tokenSig)
			return false;

		unset($tokenParam['sig']);
		$newSig = self::_genWxWebTokenSig(implode(';', $tokenCheck));
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
	private static function _genWxWebTokenSig($str)
	{
		return md5($str . self::WX_WEB_TOKEN_KEY);
	}

	/**
	 * 验证密钥来源是否是微信
	 * @param string $token
	 * @return boolean
	 */
	private static function _checkSignature($token)
	{
		$signature = @$_GET["signature"];
		$timestamp = @$_GET["timestamp"];
		$nonce = @$_GET["nonce"];

		$tmpArr = array (
				$token,
				$timestamp,
				$nonce
		);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);

		if ($tmpStr == $signature) {
			return true;
		} else {
			self::_errorLog('SuiShiPHPCPU->_checkSignature:request params ', $_GET);
			self::_errorLog('SuiShiPHPCPU->_checkSignature:gen signature ', $tmpStr);
			return false;
		}
	}

	/**
	 * 响应微信发送的上行数据
	 * @return viod
	 */
	private static function _responseMsg()
	{
		self::_callFetchData();

		self::_callApp();

		self::_exit();
	}

	/**
	 * 调用数据解析器
	 */
	private static function _callFetchData()
	{
		$msgStr = trim(file_get_contents('php://input'));
		if (! $msgStr) {
			self::_errorLog('php://input: is null');
			self::_exit();
		}
		self::$_msgStr = $msgStr;
		$message = self::_parseMessage($msgStr);

		if (! $message || ! is_object($message)) {
			self::_errorLog('weixin push data error', $msgStr);
			self::_exit();
		}

		self::$_message = $message;
		return $message;
	}

	/**
	 * 调用应用
	 * @return
	 */
	private static function _callApp()
	{
		$wxApp = C('WX_APP');

		if (! $wxApp) {
			self::_errorLog('WX_APP param is null');
			return false;
		}

		$execType = $wxApp['EXEC_TYPE'];
		$filePath = $wxApp['FILE_PATH'];
		$className = $wxApp['CLASS_NAME'];
		$methodName = $wxApp['METHOD_NAME'];
		$classType = $wxApp['CLASS_TYPE'];

		$return = false;

		switch ($execType) {
			//本地加载插件方式
			case 'local':
				if (! $filePath || ! $className || ! $methodName || ! $classType) {
					self::_errorLog('WX_APP param error:'.$filePath.'=='.$className.'=='.$methodName .'=='.$classType, $wxApp);
					return false;
				}
				if (! file_exists($filePath)) {
					self::_errorLog('WX_APP filePath error', $filePath);
					return false;
				}

				include_once $filePath;

				if (! class_exists($className, false) || ! method_exists($className, $methodName)) {
					self::_errorLog('class or method not exist');
					return false;
				}

				if ('instance' == $classType) {
					$obj = new $className();
					$return = $obj->$methodName(self::$_message, self::$_msgStr);
				} else if ('static' == $classType) {
					$return = call_user_func(array($className, $methodName), self::$_message, self::$_msgStr);
				}

				break;
			case 'http':
				if (strrpos($filePath, 'http://') === false || strrpos($filePath, 'https://') === false) {
					self::_errorLog('remote url error', $filePath);
					return false;
				}
				$return = self::_thirdApp($filePath, self::$_msgStr);
				break;
		}

		if (! $return) {
			return false;
		}

		if (isset($return['message_body']) && $return['message_body']) {
			$messageBody = $return['message_body'];
			if (! in_array($messageBody->type, self::$_noThreadMsgType)) {
				Logger::debug('需要API发送消息，非5秒响应');
			} else if($messageBody->transfer == 1) {						//做转发功能把原来的消息转到客服服务上
				include_once SUISHI_PHP_PATH . '/CPU/MessageTemplate.class.php';
				$messageBody->type = "transfer_customer_service";
				$messageXML = MessageTemplate::get(self::$_message->ent_weixin, $messageBody);
				Logger::info("echo message xml:", $messageXML);
				echo $messageXML;
			}else {
				include_once SUISHI_PHP_PATH . '/CPU/MessageTemplate.class.php';
				$messageXML = MessageTemplate::get(self::$_message->ent_weixin, $messageBody);
				Logger::info("echo message xml:", $messageXML);
				echo $messageXML;
			}
		}
	}

	/**
	 * 第三方应用
	 * @param string $url
	 * @param string $input  消息文本流
	 * @return bool | WX_Message_Body
	 */
	private static function _thirdApp($url, $input)
	{
		$params = array();
		$return = array();
		$messageBody = '';

		$data = $input;
		$response = self::_http($url, $params, $data);
		$obj = json_decode($response, true);
		if (!$obj || !isset($obj['data'])) {
			if ($this->getError()) {
				self::_error('remote Http request fail. http_code :' . $this->getHttpCode()
						. '; error :' .  $this->getError()
						. "\nhttp_res: " .  $this->getResponse(), $url);
			}
			return false;
		}
		if (is_bool($obj['data'])) {
			return $obj['data'];/*bool*/
		} else if (is_array($obj['data'])) {
			$messageBody = self::_parseResponse($response);
			if (! $messageBody) {
				if ($this->getError()) {
					self::_error('remote Http request fail. http_code :' . $this->getHttpCode()
							. '; error :' .  $this->getError()
							. "\nhttp_res: " .  $this->getResponse(), $url);
				}
				return false;
			}
		}
		$return['message_body'] = $messageBody;
		return $return;
	}

	/**
	 * http 请求
	 * @param string $url
	 * @param array $params
	 * @param string $data
	 * @return string
	 */
	private static function _http($url, $params = array(), $data = null)
	{
		$curl = curl_init();
		if(empty($data)){
			$body = '';
			if(!empty($params)) {
				if (is_array($params)) {
					$body = http_build_query($params);
				}
			}
		}else{
			$url = $url . (strpos($url, '?') ? '&' : '?') . (is_array($params) ? http_build_query($params) : $params);
			$body = $data;
		}
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 3);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::$_TIME_OUT);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		$urlArr = parse_url($url);
		$port = empty($urlArr['port']) ? 80 : $urlArr['port'];
		curl_setopt($curl, CURLOPT_PORT, $port);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
		//获取的信息以文件流的形式返回,不直接输出
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		self::$_HTTP_CODE = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		self::$_HTTP_INFO = curl_getinfo($curl);
		self::$_HTTP_ERROR_CODE = curl_errno($curl);
		self::$_HTTP_ERROR = curl_error($curl);
		curl_close($curl);
		self::$_HTTP_RESPONSE = $response;
		return $response;
	}

	/**
	 * 解析第三放返回结果
	 * @param string $response json string
	 * @return WX_Message_Body
	 */
	private static function _parseResponse ($response)
	{
		//check http code
		if(self::$_HTTP_CODE != 200){
			self::$_ERROR = 'http request error';
			return null;
		}
		if (!$response) {
			self::$_ERROR = "http response empty";
			return null;
		}
		//json_decode
		$result = json_decode($response, true);
		if (! $result || ! @$result['data'] || !isset($result['error']) || $result['error'] != 0) {
			self::$_ERROR = 'http response fomat error';
			return null;
		}
		//create wx_message_body
		$messageBody = self::_createMessageBody($result['data']);
		return $messageBody;
	}

	/**
	 * 创建 wx_message_body
	 * @param array $result
	 * @return NULL|WX_Message_Body
	 */
	private static function _createMessageBody($result)
	{
		$messageBody = new WX_Message_Body ();
		$type = @$result['type'] ? $result['type'] : '';
		$messageBody->type = $type;
		$messageBody->to_users = self::$_message->from_user;
		switch ($type) {
			case 'text' :
				if (!@$result['text']) {
					self::$_ERROR = 'text data empty';
					return null;
				}
				$messageBody->content = trim ($result['text']);
				break;
			case 'news' :
				$articles = @$result['news'];
				if(!$articles || !is_array($articles) || count($articles) > 10){
					self::$_ERROR = 'news data error';
					return null;
				}
				foreach ($articles as $key => $value) {
					if (! is_array($value) || ! $value || ! @$value['title'] || ! @$value['description'] || ! @$value['url']
					|| ! @$value['picurl']) {
						self::$_ERROR = 'news param data error';
						return null;
					}
				}
				$messageBody->articles = $articles;
				break;
			case 'music':
				if (! @$result['title'] || ! @$result['description'] || !@$result['music_url']
				|| !@$result['thumb_url'] || !@$result['hq_music_url']) {
					self::$_ERROR = 'music data error';
					return null;
				}
				$messageBody->title = $result['title'];
				$messageBody->description = $result['description'];
				$messageBody->music_url = $result['music_url'];
				$messageBody->thumb_path = $result['thumb_url'];
				$messageBody->hq_music_url = $result['hq_music_url'];
				break;
			case 'voice':
			case 'image':
			case 'video':
				if (! @$result['media_url']) {
					self::$_ERROR = 'media_url error';
					return null;
				}
				$messageBody->attachment = $result['media_url'];
				break;
			default :
				self::$_ERROR = 'message type not exsit';
				return null;
		}

		return $messageBody;
	}

	/**
	 * 错误日志记录
	 *
	 * @param
	 */
	private static function _errorLog($message, $data = null)
	{
		Logger::error($message, $data);
		//file_put_contents('/tmp/error_log.txt', $message . '   ' . var_export($data,true)."END;\r\n", FILE_APPEND);
	}

	/**
	 * 解析消息
	 * @param string $msgStr
	 * @return bool|object <WX_Message>
	 */
	protected static function _parseMessage($msgStr)
	{
		$msgXmlObj = simplexml_load_string($msgStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		if (! $msgXmlObj) {
			Logger::error('FetchData->_parseMessage() error: xml object error :', $msgStr);
			return null;
		}

		$fromUserName = (string) $msgXmlObj->FromUserName;
		$toUserName = (string) $msgXmlObj->ToUserName;
		$msgType = strtolower((string) $msgXmlObj->MsgType);
		$createTime = (string) $msgXmlObj->CreateTime;
		$messageId = (string) $msgXmlObj->MsgId;

		$recognition = @ (string) $msgXmlObj->Recognition;

		$wxMessage = new WX_Message($messageId, $msgType, $fromUserName, $createTime);

		$wxMessage->ent_weixin = $toUserName;

		switch ($msgType) {
			case 'text' :
				$content = (string) $msgXmlObj->Content;
				$wxMessage->content = trim($content);
				break;
			case 'image' :
				$picUrl = (string) $msgXmlObj->PicUrl;
				$mediaId = (string) $msgXmlObj->MediaId;
				$wxMessage->media_url = $picUrl;
				$wxMessage->media_id = $mediaId;
				break;
			case 'voice' :
				$mediaId = (string) $msgXmlObj->MediaId;
				$format = (string) $msgXmlObj->Format;
				$wxMessage->media_id = $mediaId;
				$wxMessage->format = $format;
				$wxMessage->recognition = $recognition;
				break;
			case 'video' :
				$mediaId = (string) $msgXmlObj->MediaId;
				$thumbMediaId = (string) $msgXmlObj->ThumbMediaId;
				$wxMessage->media_id = $mediaId;
				$wxMessage->thumb_media_id = $thumbMediaId;
				break;
			case 'location' :
				$location_x = (string) $msgXmlObj->Location_X;
				$location_y = (string) $msgXmlObj->Location_Y;
				$scale = (string) $msgXmlObj->Scale;
				$label = (string) $msgXmlObj->Label;
				$wxMessage->location = new WX_Location($messageId, $location_x, $location_y, $scale, $label);
				break;
			case 'link' :
				$title = (string) $msgXmlObj->Title;
				$description = (string) $msgXmlObj->Description;
				$url = (string) $msgXmlObj->Url;
				$wxMessage->title = $title;
				$wxMessage->description = $description;
				$wxMessage->url = $url;
				break;
			case 'event' :
				$event_type = strtolower((string) $msgXmlObj->Event);
				$wxMessage->event = new WX_Event($event_type);
				switch ($event_type) {
					case 'subscribe' :
					//break;
					case 'unsubscribe' :
					//break;
					case 'click' :
					case 'view':
						$event_key = (string) $msgXmlObj->EventKey;
						$wxMessage->event->event_key = $event_key;
						break;
					case 'scan' :
						$wxMessage->event->event_key = (string) $msgXmlObj->EventKey;
						break;
					case 'location' :
						$latitude = (string) $msgXmlObj->Latitude;
						$longitude = (string) $msgXmlObj->Longitude;
						$precision = (string) $msgXmlObj->Precision;
						$wxMessage->event->latitude = $latitude;
						$wxMessage->event->longitude = $longitude;
						$wxMessage->event->precision = $precision;
						break;
					case 'masssendjobfinish':
						$status=(string)$msgXmlObj->Status;
						$totalCount=(string)$msgXmlObj->TotalCount;
						$filterCount=(string)$msgXmlObj->FilterCount;
						$sendCount=(string)$msgXmlObj->SentCount;
						$errorCount=(string)$msgXmlObj->ErrorCount;
						$wxMessage->event->status = $status;
						$wxMessage->event->totalCount = $totalCount;
						$wxMessage->event->filterCount = $filterCount;
						$wxMessage->event->sendCount = $sendCount;
						$wxMessage->event->errorCount = $errorCount;
						$wxMessage->event->MsgID = (string) $msgXmlObj->MsgID;
						break;
					case 'user_scan_product':
						$wxMessage->event->KeyStandard=(string)$msgXmlObj->KeyStandard;
						$wxMessage->event->KeyStr=(string)$msgXmlObj->KeyStr;
						$wxMessage->event->Country=(string)$msgXmlObj->Country;//国家
						$wxMessage->event->Province=(string)$msgXmlObj->Province;//省份
						$wxMessage->event->City=(string)$msgXmlObj->City;//城市
						$wxMessage->event->Sex=(string)$msgXmlObj->Sex;//0未知1男2女
						break;
				}
				break;
			default :
				$wxMessage = null;
		}

		return $wxMessage;
	}

	/**
	 * 获取本次请求原始信息
	 * @return string json string
	 */
	public static function getResponse ()
	{
		return self::$_HTTP_RESPONSE;
	}

	/**
	 * 获取本次请求错误信息
	 * @return string
	 */
	public static function getError ()
	{
		if (self::$_HTTP_ERROR_CODE) {
			return self::$_ERROR  .', http_error_code:' .self::$_HTTP_ERROR_CODE
			. ", http_error:".self::$_HTTP_ERROR;
		}
		return self::$_ERROR;

	}

	/**
	 * 获取本次请求httpcode
	 * @return int
	 */
	public static function getHttpCode ()
	{
		return self::$_HTTP_CODE;
	}

	/**
	 * 获取本次请求httpInfo
	 * @return array
	 */
	public static function getHttpInfo ()
	{
		return self::$_HTTP_INFO;
	}

	/**
	 * 程序终止前调用方法
	 */
	private static function _exit()
	{
		if (! self::$_message || ! self::$_msgStr) {
			exit();
		}
		exit();
	}
}