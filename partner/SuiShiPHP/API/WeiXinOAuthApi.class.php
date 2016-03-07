<?php
include_once WEIXIN_API_ROOT . '/WeiXinError.class.php';
include_once WEIXIN_API_ROOT . '/WeiXinLog.class.php';
include_once WEIXIN_API_ROOT . '/WeiXinApiRequest.class.php';

/**
 * oauth认证授权接口处理文件
 * @author paizhang  2013-04-19
 *
 */
class WeiXinOAuthApi
{
	/**
	 * appid
	 * @var string
	 */
	protected $appId = '';
	/**
	 * app secret
	 * @var string
	 */
	protected $appSecret = '';
	/**
	 * access token
	 * @var string
	 */
	protected $accessToken = '';
	/**
	 * 微信用户openid
	 * @var string
	 */
	protected $openid = '';

	/**
	 * 最后错误代码
	 */
	protected $_error_code = 0;

	/**
	 * 最后错误信息
	 */
	protected $_error_message = '';
	/**
	 * api uri
	 * @var string
	 */
	protected $apiUri = 'https://api.weixin.qq.com/sns/';

	public function __construct($appId, $appSecret) {
		$this->appId = $appId;
		$this->appSecret = $appSecret;
	}

	/**
	 * 获取错误code
	 *
	 * function_description
	 *
	 * @author mxg
	 * @return int
	 */
	public function getErrorCode()
	{
		return $this->_error_code;
	}

	/**
	 * 获取错误信息
	 *
	 * function_description
	 *
	 * @author mxg
	 * @return string
	 */
	public function getErrorMessage()
	{
		return $this->_error_message;
	}

	/**
	 * 设置access token
	 * @param string $token
	 */
	public function setAccessToken($token) {
		$this->accessToken = $token;
	}

	/**
	 * 设置openid
	 * @param string $openId
	 */
	public function setOpenId($openId) {
		$this->openid = $openId;
	}

	/**
	 * 获取access token
	 * @return WX_OAuthToken the access token
	 */
	public function getAccessToken ($code) {
		//appid=&code=%s&secret=&grant_type=authorization_code';
		$param = array(
				'appid' => $this->appId,
				'secret'=> $this->appSecret,
				'grant_type' => 'authorization_code',
				'code'=> $code,
				);
		$url = $this->_getUrl('oauth2/access_token', $param);
		$response = WeiXinApiRequest::GET($url);
		return call_user_func_array(array($this, '_parse'),
				array(WeiXinApiRequest::$http_code, $response, '_parseToken'));

	}

	/**
	 * 根据refresh token 重新获取access token
	 * @param string $refreshToken
	 * @return WX_OAuthToken
	 */
	public function refreshAccessToken ($refreshToken) {
		//TODO 带实现

	}

	/**
	 * 获取用户信息
	 * @param string $openId
	 * @return WX_User
	 */
	public function getUserInfo ($openId, $accessToken = null) {
		//TODO 带实现
		if ($accessToken) {
			$this->setAccessToken($accessToken);
		}
		if (!$this->accessToken) {
			$this->_setError(WX_Error::KOTEN_MISSING_ERROR);
			return null;
		}
		$param = array(
				'access_token' => $this->accessToken,
				'openid'=> $openId,
		);
		$url = $this->_getUrl('userinfo', $param);
		$response = WeiXinApiRequest::GET($url);
		return call_user_func_array(array($this, '_parse'),
				array(WeiXinApiRequest::$http_code, $response, '_parseUser'));
	}
	/**
	 * 获取用户信息 by code
	 * @return WX_User  the user object
	 */
	public function getUserInfoByCode ($code) {
		$oauthToken = $this->getAccessToken($code);
		if (!$oauthToken) {
			return null;
		}
		return $this->getUserInfo($oauthToken->openId, $oauthToken->accessToken);
	}

	/**
	 * 获取api请求url
	 * @param 请求模块路径 $path
	 * @param 参数 $params
	 * @return string
	 */
	protected function _getUrl ($path, $params = array()) {
		$path = trim(trim($path),'/');
		$url = $this->apiUri . $path;

		if ($params) {
			$url .= '?' . (is_array($params) ? http_build_query($params) : ltrim($params, '?'));
		}
		return $url;
	}


	/**
	 * 分析数据结果
	 *
	 * @param int    $code   curl发送请求的状态码
	 * @param array  $response 得到的结果
	 * @param string $fun_name
	 * @return mixed
	 */
	protected function _parse($code, $response, $func_name = '')
	{
		$error = $this->_parseError($code, $response);
		if ($error == false) {
			return false;
		}
		if ($func_name) {
			return call_user_func_array(array($this, $func_name), array($response));
		}
		return true;
	}


	/**
	 * 解析token
	 *
	 * @param  array  $response
	 * @return object WX_OAuthToken
	 */
	protected function _parseToken($response)
	{
		if (! isset($response['access_token']) || ! $response['access_token']
				|| ! isset($response['openid']) || ! $response['openid']) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		return new WX_OAuthToken($response['access_token'], $response['openid'],
				@$response['refresh_token'], @$response['expires_in']);
	}

	/**
	 * 解析微信 返回user信息
	 *
	 * @param  array  $response
	 * @return object WX_User
	 */
	protected function _parseUser ($response) {
		if (! isset($response['openid']) || ! $response['openid']) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		$wxUser = new WX_User($response['openid'], null);
		$wxUser->nickname = @$response['nickname'];
		$wxUser->sex = @$response['sex'];
		$wxUser->city = @$response['city'];
		$wxUser->province = @$response['province'];
		$wxUser->country = @$response['country'];
		$wxUser->headimgurl = @$response['headimgurl'];
		$wxUser->picture = @$response['headimgurl'];
		$wxUser->privilege = @$response['privilege'];
		return $wxUser;
	}

	/**
	 * 分析错误
	 *
	 * @param  int $code
	 * @param  array $response
	 * @return bool
	 */
	protected function _parseError($code, $response)
	{
		$this->_error_code = WX_Error::NO_ERROR;
		if (200 == $code && (isset($response['errcode']) && $response['errcode'])) {
			$code = $response['errcode'];
		}
		//与微信链接失败
		if (0 == $code) {
			$code = 5100;
		}

		switch ($code) {
			case 200:
				return true;
				//http code
			case 404:
				$error_code = WX_Error::HTTP_FORBIDDEN_ERROR;
				break;
			case 503:
				$error_code = WX_Error::HTTP_SERVICE_UNAVAILABLE_ERROR;
				break;
			case 40013:
				$error_code = WX_Error::INVALID_APP_ID_ERROR;
				break;
			case 41001:
				$error_code = WX_Error::KOTEN_MISSING_ERROR;
				break;
			default:
				$error_code = $code;
		}
		$this->_setError($error_code);
		return false;
	}

	/**
	 * 获取api请求错误
	 *
	 * @param  int $code
	 * @return void
	 */
	protected function _setError($code, $log_enabled = true)
	{
		//记录错误日志
		if ($log_enabled) $this->_log();

		$this->_error_code = $code;
		$this->_error_message = WX_Error::getMessage($code);
	}


	/**
	 * 记录错误日志
	 *
	 * @author mxg
	 * @return void
	 */
	protected function _log()
	{
		$params = array();
		$params['data'] = WeiXinApiRequest::$params;
		$params['response'] = WeiXinApiRequest::$response;
		$params['app_id'] = $this->appId;
		$params['http_code'] = WeiXinApiRequest::$http_code;
		$params['http_error_code'] = WeiXinApiRequest::$http_error_code;
		$params['http_error'] = WeiXinApiRequest::$http_error;
		WeiXinLog::error('WeiXinOAuthApi last erorr, url: '. WeiXinApiRequest::$url, $params);
	}
}