<?php
/**
 * 汇则成api SDK
 * @author suishi
 *
 */
class HzcApiSDK {
	public $apiKey;
	public $apiSecret;
	public $head_url = "http://api.mobhui.com/index.php?";
	public $debug = false;
	public function __construct($apiKey, $apiSecret, $url = null ) {
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
		if ($url) {
			$this->head_url = $url;
		}
	}
	
	/**
	 * 获取token
	 * @return mixed
	 */
	public function getToken(){		
		$data = array (
				'a'=>'Base',
				'm'=>'getToken',
		);
		$result = $this->_request ( $data );
		return $result;
	}
	/**
	 * 解析推送消息
	 * @param array $getArr 如果为空则取Get参数
	 * @param string $input 如果为空则取http input 数据
	 * @return Array | boolean
	 */
	public function formatPushMessage ($getArr, $input, &$error) {
		if (empty($getArr)) {
			$getArr = $_GET;
		}
		if (!$input) {
			$input = str_replace('%3D','=',file_get_contents("php://input", 'r'));
		}
		$sig = @$getArr['sig'];
		if (empty($getArr) || !$input || !$sig) {
			$error = 'GET或INPUT或SIG参数为空';
			return false;
		}
		//验证签名
		$params = array(
			'timestamp' => @$getArr['timestamp']
		);
		$checkSig = SuiShiParam::checkSig($this->apiKey, $this->apiSecret, @$getArr['sig'], $params, $input);
		if (!$checkSig) {
			$error = '签名错误';
			return false;
		}
		return json_decode(base64_decode($input), true);
	}
	
	public function getUserInfo($openid) {
		$param = array (
				'a' => 'User',
				'm' => 'get'
		);
		$data = array(
				'openid' => $openid
		);
		$result = $this->_request ( $param, $data );
		return $result;
	}
	/**
	 * 获取随视预存门店信息，在微信平台不一定会存在
	 * @param int $startId
	 * @param int $count
	 * @return array array("data"=>array('list'=>array(), "total"=1, "next_id"=>0), "error"=>0,"msg"=>'')
	 */
	public function getShStoreList ($startId = 0, $count = 100) {
		$param = array (
				'a' => 'Store',
				'm' => 'shList'
		);
		$data = array(
				'start_id' => $startId,
				'count'    => $count
		);
		$result = $this->_request ( $param, $data );
		return $result;
	}

	/**
	 * 获取卡券信息接口
	 *
	 * @param array $cardIds
	 */
	public function getCardInfo($cardIds) {
		if (! is_array ( $cardIds )) {
			return false;
		}
		if (! $cardIds ['card_ids']) {
			return false;
		}
		$data = array (
				'a' => 'Coupon',
				'm' => 'getCardInfo'
		);
		$result = $this->_request ( $data, $cardIds );
		return $result;
	}

	/**
	 * 根据code获得openid及卡券有效期接口
	 *
	 * @param array $cardIds
	 */
	public function getCodeInfo($arr_data) {
		if (! is_array ( $arr_data )) {
			return false;
		}
		if (! $arr_data ['code_type'] || ! $arr_data ['card_code']) {
			return false;
		}
		$data = array (
				'a' => 'Coupon',
				'm' => 'getCodeInfo'
		);
		$result = $this->_request ( $data, $arr_data );
		return $result;
	}

	/**
	 * 批量获取某用户的当前卡券接口
	 *
	 * @param string $cardIds
	 */
	public function getUserCards($arr_data) {
		if (! is_array ( $arr_data )) {
			return false;
		}
		if (! $arr_data ['openid']) {
			return false;
		}
		$data = array (
				'a' => 'Coupon',
				'm' => 'getUserCards'
		);
		$result = $this->_request ( $data, $arr_data );
		return $result;
	}

	/**
	 * 卡券核销接口
	 * @param string $code code序列号
	 * @param number $code_type 1:微信明文code 2:随视加密code 3微信加密code
	 * @return boolean|mixed
	 */
	public function appConsume($code,$code_type = 1) {
		if (! $code) {
			return false;
		}
		$data = array (
				'a' => 'Coupon',
				'm' => 'appConsume'
		);
		$arr_data = array (
				'code_type' => $code_type,
				'card_code' => $code,
		);
		$result = $this->_request ( $data, $arr_data );
		return $result;
	}
	
	/**
	 * 获取Oauth授权Url
	 * @param string $url 目标url
	 * @param string $scope  snsapi_base/snsapi_userinfo
	 * @param string $response_type scope=snsapi_userinfo时可选空或者'userinfo'
	 * @return boolean|mixed
	 */
	public function getOauthUrl($url,$scope = 'snsapi_base',$response_type = '') {
		if (! $url) {
			return false;
		}
		$data = array (
				'a' => 'Base',
				'm' => 'getOAuthUrl'
		);
		$arr_data = array (
				'url' => $url,
				'scope' => $scope,
				'response_type' => $response_type
		);
		$result = $this->_request ( $data, $arr_data );
		return $result;
	}
	
	// 请求
	protected function _request($data, $post = array()) {
		$response = ApiRequest::post ( $this->head_url, $this->apiKey, $this->apiSecret, $data, $post );
		$result = json_decode ( $response, true );
		if (true == $this->debug) {
			$this->_debug($post,$response);
		}
		return $result;
	}
	//输出debug
	protected function _debug($postArr,$response) {
		echo '<br/>------GET 参数---------------<br/>';
		print_r(ApiRequest::$_HTTP_PARAMS);
		echo '<br/>------POST 参数---------------<br/>';
		print_r($postArr);
		echo '<br/>------POST INIPUT---------------<br/>';
		print_r(ApiRequest::$_HTTP_INPUT);
		echo '<br/>------HTTP_STATUS---------------<br/>';
		echo 'http-url:'.ApiRequest::$_URL.'<br/>';
		echo 'http-code:'.ApiRequest::$_HTTP_CODE.'<br/>';
		echo 'http-error-code:'.ApiRequest::$_HTTP_ERROR_CODE.'<br/>';
		echo 'http-error:'.ApiRequest::$_HTTP_ERROR.'<br/>';
		echo 'http-response:'.$response.'<br/>';
	}
}
class ApiRequest {
	public static $_URL = '';
	//http请求code
	public static $_HTTP_CODE = 0;
	//http请求详细信息
	public static $_HTTP_INFO = NULL;
	//自定义错误
	public static $_ERROR = '';
	//http error code
	public static $_HTTP_ERROR_CODE = 0;
	//http error
	public static $_HTTP_ERROR = '';
	//input
	public static $_HTTP_INPUT = '';
	public static $_HTTP_PARAMS = NULL;
	/**
	 * 发送post请求
	 * @param string $url
	 * @param string $apiKey
	 * @param string $apiSecret
	 * @param array $getArr
	 * @param array $postArr
	 * @return string
	 */
	public static function post($url, $apiKey, $apiSecret, $getArr, $postArr = array()) {
		// post str
		$input = $postArr ? SuiShiParam::createInput($postArr) : '';
		//get params
		$params = SuiShiParam::createQueryData($apiKey, $apiSecret, $getArr, $input);
		//request url
		$url = self::_resetUrl($url, $params);
		//encode post str
		self::$_HTTP_INPUT = urlencode($input);
		self::$_HTTP_PARAMS = $params;
		$response = self::_request($url, self::$_HTTP_INPUT);
		return $response;
	}
	//发送http请求
	protected static function _request($url, $input) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 3 );
		curl_setopt ( $curl, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $input );
		$urlArr = parse_url ( $url );
		$port = empty ( $urlArr ['port'] ) ? 80 : $urlArr ['port'];
		curl_setopt ( $curl, CURLOPT_PORT, $port );
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, array ('Expect:') );
		// 获取的信息以文件流的形式返回,不直接输出
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		$response = curl_exec ( $curl );
		self::$_HTTP_CODE = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		self::$_HTTP_INFO = curl_getinfo($curl);
		self::$_HTTP_ERROR_CODE = curl_errno($curl);
		self::$_HTTP_ERROR = curl_error($curl);
		self::$_URL = $url;
		curl_close($curl);
		return $response;
	}
	//将参数添加到指定url后
	protected static function _resetUrl ($url, $queryData = array()) {
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
}
class SuiShiParam {
	/**
	 * 生成get参数数据代签名
	 * @param string $apiKey
	 * @param string $apiSecret
	 * @param array $params
	 * @param string $input
	 * @return array
	 */
	public static function createQueryData ($apiKey, $apiSecret, $params = array(), $input = '') {
		$params['timestamp'] = time();
		$sig = self::createSig($apiKey, $apiSecret, $params, $input);
		$params['api_key'] = $apiKey;
		$params['sig'] = $sig;
		return $params;
	}
	/**
	 * 生成post数据
	 * @param array $postArr
	 * @return string
	 */
	public static function createInput ($postArr) {
		return base64_encode ( json_encode ( $postArr ) );
	}
	/**
	 * 解析input数据
	 * @param string $input
	 * @return array
	 */
	public static function decodeInput($input) {
		return json_decode(base64_decode($input), true);
	}
	// 生成sig
	public static function createSig($apiKey, $apiSecret,/*Array*/$data, $input = '') {
		$buff = '';
		$arr = array (
				'api_key' => $apiKey,
				'api_secret' => $apiSecret
		);
		$arr = array_merge ( $arr, $data );
		ksort ( $arr, SORT_STRING );
		foreach ( $arr as $k => $v ) {
			if (null != $v && "null" != $v && "sig" != $k) {
				$buff .= $k . '=' . $v . '&';
			}
		}
		if (strlen ( $buff ) > 0) {
			$buff = substr ( $buff, 0, - 1 );
		}
		$sig = md5 ( $buff . $input );
		return $sig;
	}

	// 验证sig
	public static function checkSig($apiKey, $apiSecret, $sig, $getArr, $input = '') {
		$checkSig = self::createSig($apiKey, $apiSecret, $getArr, $input);
		if ($checkSig == $sig) {
			return true;
		} else {
			return false;
		}
	}
}
