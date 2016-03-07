<?php
/**
 * PHP SDK for weixin
 *
 * @author mxg
 * @version 1.0
 */
include_once SUISHI_PHP_PATH . '/API/WeiXinError.class.php';
include_once SUISHI_PHP_PATH . '/API/WeiXinApiRequest.class.php';

/**
 * 微信操作类
 *
 *
 * @author mxg
 * @version 2.0
 */
class WeiXinApi
{

	/**
     * 应用APP ID
     */
	public $app_id;

	/**
     * 应用APP SECRET
     */
	public $app_secret;

	/**
     * 应用TOKEN
     */
	public $token;

	/**
     * 微信api平台host地址
     */
	public $host = "https://api.weixin.qq.com/cgi-bin/";

	/**
	 * 微信api平台多媒体host地址
	 * @var url
	 */
	public $hostMedia = "http://file.api.weixin.qq.com/cgi-bin/";

	/**
     * 最后错误代码
     */
	protected $_error_code = 0;

	/**
     * 最后错误信息
     */
	protected $_error_message = '';

	/**
     * Set get token API URLS
     */
	public function accessTokenURL()
	{
		return $this->host . 'token?grant_type=client_credential';
	}

	/**
     * 构造函数
     *
     * @access public
     * @param mixed $app_id 微信平台应用APP KEY
     * @param mixed $app_secret 微信平台应用APP SECRET
     * @param mixed $access_token 微信平台放回的token
     * @return void
     */
	public function __construct($app_id, $app_secret, $token = NULL)
	{
		$this->app_id = $app_id;
		$this->app_secret = $app_secret;
		$this->token = $token;
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
     * 获取token
     *
     * 对应API：{@link https://api.weixin.qq.com/cgi-bin/token}
     *
     * @access public
     * @return object WX_Token
     */
	public function getToken()
	{
		$params = array ();
		$params['appid'] = $this->app_id;
		$params['secret'] = $this->app_secret;
		$response = WeiXinApiRequest::get($this->accessTokenURL(), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseToken'
		));
	}

	/**
     * 设置token
     *
     * function_description
     *
     * @author mxg
     * @param  string $token
     * @return void
     */
	public function setToken($token)
	{
		$this->token = $token;
	}

	/**
     * 获取用户信息
     *
     * 对应API：{@link https://api.weixin.qq.com/cgi-bin/user/info}
     *
     * @author mxg
     * @param  string $user_id 微信用户ID
     * @return object WX_User
     */
	public function getUser($user_id)
	{
		$params = array ();
		$params['openid'] = $user_id;
		$path = 'user/info';
		$response = WeiXinApiRequest::GET($this->_genUrl($path), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseUser'
		));
	}

	/**
     * 拉取公众账户关注用户列表
     *
     * 对应API：{@link https://api.weixin.qq.com/cgi-bin/user/get}
     *
     * @param string $next_openid 获取关注用户列表, 从next_openid开始的用户，可选项 最多10000条
     * @return array
     * array(
     *    'total' => int,//总数
     *    'count'=> int ,//当前数
     *    'data' => array() //openid数组
     * )
     */
	public function getUserList($next_openid = '')
	{
		$params = array ();
		$params['next_openid'] = $next_openid;
		$path = 'user/get';
		$response = WeiXinApiRequest::GET($this->_genUrl($path), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseUserList'
		));
	}

	/**
     * 获取单条附件信息
     *
     * 对应API：{@link https://api.weixin.qq.com/cgi-bin/media/get}
     *
     * @author mxg
     * @param  string $media_id
     * @return string $url
     */
	public function getMediaUrl($media_id)
	{
		$params = array ();
		$params['media_id'] = $media_id;
		$path = 'media/get';
		return $this->_genUrl($path, $params, true);
	}

	/**
     * 给指定用户发送消息接口
     *
     * @param object WX_Message_Body
     * @return bool
     */
	public function sendMessage($message_body)
	{
		return $this->_sendMessage($message_body);
	}

	/**
     * 客服消息发送接口
     * @param WX_Message_Body $message_body
     * @return Ambigous <boolean, string, mixed>
     */
	public function sendOperatorMessage($message_body)
	{
		return $this->_sendMessage($message_body);
	}

	/**
	 * 群发接口发送
	 * @param string $url
	 * @param array $data
	 * @return mixed
	{
		"errcode":0,
		"errmsg":"send job submission success",
		"msg_id":34182
	}
	 */
	public function sendMass($url,$params){
		$path = $this->_genUrl($url);
		$response = WeiXinApiRequest::post($path, $params);
		//记录日志
		$this->_log();
		//因为返回值 成功也是errcode=0所以，调用以下方法将有异常
		return $response;
		/*
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseSend'
		));
		*/
	}
	/**
	 * 群发创建图文
	 * @param array $data 
	 */
	public function createNews($data){
		
		$path = 'media/uploadnews';
		$path = $this->_genUrl($path);
		$response = WeiXinApiRequest::post($path, $data);
		Logger::error("zhongyu:打印创建图文的res",array('path'=>$path,'res'=>$response));
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseUpload'
		));
	}
	/**
	 * 群发获取视频id
	 * @param array $data
	 */
	public function createMassVideo($data){
		$path = '/media/uploadvideo';
		$path = $this->_genUrl($path);
		$arr=array(
				'media_id'=>$data['media_id'],
				'title'=>$data['title'],
				'description'=>$data['description']
		);
		$response = WeiXinApiRequest::post($path, $arr);
		Logger::error("zhongyu:打印群发视频的res",array('path'=>$path,'data'=>$arr,'res'=>$response));
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseUpload'
		));
	}
	/**
     * 创建图片
     * @param string $path 本地磁盘绝对地址
     * @return string media id
     */
	public function createImage($path)
	{
		return $this->_upload('image', $path);
	}

	/**
     * 创建音频
     * @param string $path 本地磁盘绝对地址
     * @return string media id
     */
	public function createVoice($path)
	{
		return $this->_upload('voice', $path);
	}

	/**
     * 创建视频
     * @param string $path 本地磁盘绝对地址
     * @return array array('media id' => '', 'thumb_media_id' => '')
     */
	public function createVideo($path)
	{
		return $this->_upload('video', $path);
	}

	/**
     * 创建缩略图
     * @param string $thumb_path 本地磁盘绝对地址
     * @return string media id
     */
	public function createThumb($path)
	{
		return $this->_upload('image', $path);
	}

	/**
	 * 创建自定义菜单接口
	 * @param object WX_Menu
	 * @return bool
	 */
	public function createMenu($menu)
	{
		return $this->_createMenu($menu);
	}

	/**
     * 获取自定义菜单接口
     * @return object WX_Menu
     */
	public function getMenu()
	{
		$path = 'menu/get';
		$response = WeiXinApiRequest::GET($this->_genUrl($path));
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseMenu'
		));
	}

	/**
     * 删除自定义菜单接口
     * @return bool
     */
	public function deleteMenu()
	{
		$path = 'menu/delete';
		$response = WeiXinApiRequest::GET($this->_genUrl($path));
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response
		));
	}

	/**
     * 获取带参数二维码ticket
     * @param int $sceneId 二维码id
     *  当type 为1时scene_id为32位整型，2时为最大1000的正整数
     * @param int $type 1:动态临时二维码，2：永久有效二维码
     * @param int $expire 过期时间 当type 为1时 最大时间为1800 秒
     *  @return array array(ticket:'', expire_seconds:'')
     */
	public function getQrc($sceneId, $type = 1, $expire = 1800)
	{
		$ticketRet = $this->getQrcTicket($sceneId, $type, $expire);
		if (! $ticketRet) {
			return null;
		}
		return $this->getQrcUrl($ticketRet['ticket']);
	}

	/**
     * 获取带参数二维码ticket
     * @param int $sceneId 二维码id
     *  当type 为1时scene_id为32位整型，2时为最大1000的正整数
     * @param int $type 1:动态临时二维码，2：永久有效二维码
     * @param int $expire 过期时间 当type 为1时 最大时间为1800 秒
     *  @return array array(ticket:'', expire_seconds:'')
     */
	public function getQrcTicket($sceneId, $type = 1, $expire = 1800)
	{
		$path = 'qrcode/create';
		$_param = array (
				'action_info' => array (
						'scene' => array (
								'scene_id' => $sceneId
						)
				)
		);
		if ($type == 1) {
			$_param['action_name'] = "QR_SCENE";
			$_param['expire_seconds'] = $expire;
		} else if ($type == 2) {
			$_param['action_name'] = "QR_LIMIT_SCENE";
		}
		$response = WeiXinApiRequest::post($this->_genUrl($path), $_param);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseTicket'
		));
	}

	/**
	 * 获取二维码图片地址
	 * @param string $ticket
	 */
	public function getQrcUrl($ticket)
	{
		return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
	}

	/**
     * 发送消息操作处理
     *
     * @author mxg
     * @param WX_Message_Body $message_body
     * @param string $api_type api接口类型 新增类型custom
     * @return bool
     */
	protected function _sendMessage($message_body)
	{
		// 参数验证
		if (! $this->_checkSendMessageData($message_body)) {
			return false;
		}
		$params = array ();
		$params['touser'] = $message_body->to_users;
		$params['msgtype'] = $message_body->type;
		switch ($message_body->type) {
			case 'text' :
				$params['text'] = array (
						'content' => $this->_textEncode($message_body->content)
				);
				break;
			case 'news' :
				$params['news']['articles'] = $message_body->articles;
				break;

			case 'image' :
			case 'voice' :
			case 'video' :
				$media_id = $message_body->media_id;
				//新改变api接口
				if (! $message_body->media_id && $message_body->attachment) {
					$media_id = $this->_upload($message_body->type, $message_body->attachment);
					if (! $media_id) {
						$this->_setError(WX_Error::CREATE_MEDIA_ID_ERROR, false);
						return false;
					}
				}

				if ('video' == $message_body->type) {
					$params['video']['title'] = @ $message_body->title ? @ $this->_textEncode($message_body->title) : '';
					$params['video']['description'] = @$message_body->description ? @ $this->_textEncode($message_body->description) : '';
				}
				$params[$message_body->type]['media_id'] = $media_id;
				break;
			case 'music' :
				$thumb_media_id = $message_body->thumb_media_id;
				if (! $message_body->thumb_media_id && $message_body->thumb_path) {
					$media_id = $this->_upload('thumb', $message_body->thumb_path);
					if (! $media_id) {
						$this->_setError(WX_Error::CREATE_MEDIA_ID_ERROR, false);
						return false;
					}
					$thumb_media_id = $media_id;
				}
				$params['music'] = array (
						'title' => $this->_textEncode($message_body->title),
						'description' => $this->_textEncode($message_body->description),
						'musicurl' => $message_body->music_url,
						'hqmusicurl' => $message_body->hq_music_url,
						'thumb_media_id' => $thumb_media_id
				);
				break;
			case 'template' :
				unset($params['msgtype']);
				$params['template_id'] = $message_body->template_id;
				$params['data'] = $message_body->data;
				//$params = json_decode(urldecode(json_encode($params)),true);
				return $this->_sendTemplateMessage($params);
				break;
			/* case 'link':
				$params['msgtype'] = $message_body->type;
				$media_id = $this->_upload('thumb', $message_body->thumb_path);
				if (! $media_id) {
				return false;
				}
				$params['link'] = array(
						'title' => $this->_textEncode($message_body->title),
						'description' => $this->_textEncode($message_body->description),
						'url' => $message_body->url,
						'thumb_media_id' => $media_id,
				);

				break; */
			default :
				$this->_setError(WX_Error::PARAM_ERROR, false);
				return false;
		}
		return $this->_send($params);
	}

	/**
     * 创建自定义菜单处理
     * @param object WX_Menu
     * @return bool
     */
	protected function _createMenu($menu)
	{
		// 参数验证
		if (! $this->_checkCreateMenuData($menu)) {
			return false;
		}
		$params['button'] = $menu->button;
		$path = 'menu/create';
		$response = WeiXinApiRequest::post($this->_genUrl($path), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseSend'
		));
	}

	/**
     * 发送消息参数检查
     *
     * @param  WX_Menu $menu
     * @return bool
     */
	protected function _checkCreateMenuData($menu)
	{
		//检测数据
		if (! is_object($menu) || ! $menu->button) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$is_error = false;

		if (! is_array($menu->button)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}

		$num = 0;
		foreach ($menu->button as $key => &$value) {
			++ $num;
			if (! is_array($value)) {
				$is_error = true;
				break;
			}
			if ($num > 3) {
				$is_error = true;
				break;
			}

			if (! isset($value['sub_button']) && empty($value['sub_button'])) {
				if (! $value['type'] || ! $value['name']) {
					$is_error = true;
					break;
				}
				if ('view' == $value['type']) {
					$value['url'] = urlencode($value['url']);
				}
			} else {
				$num_sub = 0;
				if (! is_array($value['sub_button'])) {
					$is_error = true;
					break;
				}
				foreach ($value['sub_button'] as $k => &$v) {
					++ $num_sub;
					if ($num_sub > 5) {
						$is_error = true;
						break;
					}
					if (! $v['type'] || ! $v['name']) {
						$is_error = true;
						break;
					}
					$v['name'] = $this->_textEncode($v['name']);
					if ('view' == $v['type']) {
						$v['url'] = urlencode($v['url']);
					}
				}
			}
			$value['name'] = $this->_textEncode($value['name']);
			//$menu->button[$key] = $value;
		}

		if ($is_error) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		return true;
	}

	/**
     * 文本加密
     *
     * @param  string $text
     * @return string
     */
	protected function _textEncode($text)
	{
		if (! $text) return null;
		return urlencode(addslashes($text));
	}

	/**
     * 发送消息参数检查
     *
     * @param WX_Message_Body $message_body
     * @return bool
     */
	protected function _checkSendMessageData($message_body)
	{
		//检测数据
		if (! is_object($message_body) || ! $message_body->type || ! $message_body->to_users) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$is_error = false;
		$pregstr = "/[\x{4e00}-\x{9fa5}]+/u";
		switch ($message_body->type) {
			case 'text' :
				if (! $message_body->content) {
					$is_error = true;
				}
				break;
			case 'image' :
			case 'voice' :
			case 'video' :
				if (! $message_body->media_id && ! $message_body->attachment) {
					$is_error = true;
				} else {
					if (! $message_body->media_id) {
						$attachment = $message_body->attachment;
						if (! $attachment || preg_match($pregstr, $attachment)) {
							$is_error = true;
						} else {
							$ext = strtolower(substr($attachment, strripos($attachment, '.') + 1));
							if ('image' == $message_body->type && 'jpg' != $ext) {
								$is_error = true;
							}
							if ('voice' == $message_body->type && 'amr' != $ext) {
								$is_error = true;
							}
							if ('video' == $message_body->type && 'mp4' != $ext) {
								$is_error = true;
							}
						}
					}
				}
				break;
			case 'news' :
				$articles = $message_body->articles;
				if (! is_array($articles)) {
					$is_error = true;
				} else {
					$num = 0;
					foreach ($articles as $key => $value) {
						++ $num;
						if ($num > 10) {
							$is_error = true;
							break;
						}
						if (! is_array($value) || ! $value) {
							$is_error = true;
							break;
						}
						if (! $value['title'] || ! $value['description'] || ! $value['url'] || ! $value['picurl']) {
							$is_error = true;
							break;
						}
						$value['title'] = $this->_textEncode($value['title']);
						$value['description'] = $this->_textEncode($value['description']);
						$value['url'] = urlencode($value['url']);
						$articles[$key] = $value;
					}
					$message_body->articles = $articles;
				}
				break;
			case 'music' :
				if (! $message_body->title || ! $message_body->description || ! $message_body->music_url || (! $message_body->thumb_path && ! $message_body->thumb_media_id)) {
					$is_error = true;
				}
				if ($message_body->thumb_path) {
					if (preg_match($pregstr, $message_body->thumb_path)) {
						$is_error = true;
					}
					$ext = strtolower(substr($message_body->thumb_path, strripos($message_body->thumb_path, '.')));
					if ('.jpg' != $ext) {
						$is_error = true;
					}
				}
				break;
			case 'template' :
				if (! $message_body->template_id) {
					$is_error = true;
				}
				if (! is_array($message_body->data) || ! $message_body->data) {
					$is_error = true;
				}
				break;
			/* case 'link':
        		if (! $message_body->title || ! $message_body->description || ! $message_body->url) {
        		$is_error = true;
        		}

        		if (! $message_body->attachment || preg_match($pregstr, $message_body->attachment)) {
        		$is_error = true;
        		}
        		$ext = strtolower(substr($message_body->attachment, strripos($message_body->attachment, '.')));
        		if ('.jpg' != $ext) {
        		$is_error = true;
        		}
        		break; */
			default :
				$is_error = true;
		}
		if ($is_error) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		return true;
	}

	/**
     * 媒体消息发送
     *
     * 对应API：{@link https://api.weixin.qq.com/cgi-bin/media/send}
     *
     * @author mxg
     * @param  array $params
     * array(
     *    'type' => string 图片（image）、语音（voice）、视频（video）,
     *    'touser' => string 用户ID,
     *    'media' => string 媒体绝对路径,
     *    )
     * @return string bool
     */
	protected function _sendMediaMessage($params)
	{
		$path = 'media/send';
		$response = WeiXinApiRequest::post($this->_genUrl($path), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseSend'
		));
	}

	/**
     * 发送模板消息
     * @param array $params
     * @return bool
     */
	protected function _sendTemplateMessage($params)
	{
		$path = 'message/template/send';
		$response = WeiXinApiRequest::post($this->_genUrl($path), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseSend'
		));
	}

	/**
     * 向服务器发送消息
     *
     * 对应API：{@link https://api.weixin.qq.com/cgi-bin/message/send}
     * @param  array  $params
     * @param  string $api_type 新增API接口
     * @return bool
     */
	protected function _send($params)
	{
		$path = 'message/custom/send';
		$response = WeiXinApiRequest::post($this->_genUrl($path), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseSend'
		));
	}

	/**
     * 上传附件
     *
     * 对应API：{@link http://api.weixin.qq.com/cgi-bin/media/upload}
     *
     * @param stirng $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     * @param string $attachment 要上传附件的路径：绝对路径
     * @return array $media array('media_id' => , 'thumb_media_id' => )
     */
	protected function _upload($type, $attachment)
	{
		$params = array ();
		$params['type'] = $type;
		$params['media'] = '@' . $attachment;
		$path = 'media/upload';
		$response = WeiXinApiRequest::post($this->_genUrl($path, array(), true), $params, false, false);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseUpload'
		));
	}

	/**
     * 生成api请求的URL
     *
     * @param  string $path
     * @param  array  $params 参数
     * @return string $url
     */
	protected function _genUrl($path, $params = array(), $isMedia = false)
	{
		$path = trim($path);
		$length = strlen($path);
		if (0 === strpos($path, '/')) {
			$length -= 1;
			$path = substr($path, 1, $length);
		}
		if (($length - 1) === strrpos($path, '/')) {
			$path = substr($path, 0, $length - 1);
		}
		$host = $isMedia ? $this->hostMedia : $this->host;
		$url = $host . $path . '?access_token=' . $this->token;

		if ($params) {
			$url .= '&' . (is_array($params) ? http_build_query($params) : $params);
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
			return call_user_func_array(array (
					$this,
					$func_name
			), array (
					$response
			));
		}
		return true;
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
		/* var_dump($code);
        echo '<br>';
        var_dump(WeiXinApiRequest::$http_info);
        echo '<br>';
        var_dump(WeiXinApiRequest::$response);
        echo '<br>';
        var_dump($response);
        exit; */
		$this->_error_code = WX_Error::NO_ERROR;
		if (200 == $code && (isset($response['errcode']) && $response['errcode'])) {
			$code = $response['errcode'];
		}
		//与微信链接失败
		if (0 == $code) {
			$code = 5100;
		}

		switch ($code) {
			case 200 :
				return true;
			//http code
			case 404 :
				$error_code = WX_Error::HTTP_FORBIDDEN_ERROR;
				break;
			case 503 :
				$error_code = WX_Error::HTTP_SERVICE_UNAVAILABLE_ERROR;
				break;
			//response code
			case 40002 :
				$error_code = WX_Error::INVALID_GRANT_TYPE_ERROR;
				break;
			case 41002 :
				$error_code = WX_Error::APP_ID_MISSING_ERROR;
				break;
			case 41004 :
				$error_code = WX_Error::APP_SECRET_MISSING_ERROR;
				break;
			case 40013 :
				$error_code = WX_Error::INVALID_APP_ID_ERROR;
				break;
			case 40001 :
				$error_code = WX_Error::INVALID_CREDENTIAL_ERROR;
				break;
			case 40003 :
				$error_code = WX_Error::INVALID_USER_ERROR;
				break;
			case 42001 :
				$error_code = WX_Error::TOKEN_EXPIRED_ERROR;
				break;
			case 40004 :
				$error_code = WX_Error::INVALID_MEDIA_TYPE_ERROR;
				break;
			case 40005 :
				$error_code = WX_Error::INVALID_FILE_TYPE_ERROR;
				break;
			case 41005 :
				$error_code = WX_Error::MEDIA_DATA_MISSING_ERROR;
				break;
			case 43002 :
				$error_code = WX_Error::REQUIRE_POST_METHOD_ERROR;
				break;
			case 40008 :
				$error_code = WX_Error::INVALID_MESSAGE_TYPE_ERROR;
				break;
			case 40007 :
				$error_code = WX_Error::MEDIA_ID_MISSING_ERROR;
				break;
			case 47001 :
				$error_code = WX_Error::DATA_FORMAT_ERROR;
				break;
			case 40012 :
				$error_code = WX_Error::INVALID_THUMB_SIZE_ERROR;
				break;
			case 44003 :
				$error_code = WX_Error::EMPTY_NEWS_DATA_ERROR;
				break;
			case 45008 :
				$error_code = WX_Error::ARTICLE_SIZE_OUT_ERROR;
				break;
			case 40006 :
				$error_code = WX_Error::INVALID_MEIDA_SIZE_ERROR;
				break;
			case 45007 :
				$error_code = WX_Error::PLAYTIME_OUT_ERROR;
				break;
			case 45009 :
				$error_code = WX_Error::API_FREQ_OUT_ERROR;
				break;
			case - 1 :
				$error_code = WX_Error::SYSTEM_ERROR;
				break;
			case 41001 :
				$error_code = WX_Error::KOTEN_MISSING_ERROR;
				break;
			case 40016 :
				$error_code = WX_Error::INVALID_BUTTON_SIZE;
				break;
			case 40017 :
				$error_code = WX_Error::INVALID_BUTTON_TYPE;
				break;
			case 40018 :
				$error_code = WX_Error::INVALID_BUTTON_NAME;
				break;
			case 40019 :
				$error_code = WX_Error::INVALID_BUTTON_KEY;
				break;
			case 40023 :
				$error_code = WX_Error::INVALID_SUB_BUTTON_SIZE;
				break;
			case 40024 :
				$error_code = WX_Error::INVALID_SUB_BUTTON_TYPE;
				break;
			case 40025 :
				$error_code = WX_Error::INVALID_SUB_BUTTON_NAME;
				break;
			case 40026 :
				$error_code = WX_Error::INVALID_SUB_BUTTON_KEY;
				break;
			case 46003 :
				$error_code = WX_Error::MENU_NO_EXIST;
				break;
			case 43004 :
				$error_code = WX_Error::REQUIRE_SUBSCRIBE;
				break;
			case 45015 :
				$error_code = WX_Error::RESPONSE_OUT_TIME;
				break;
			case 48001 :
				$error_code = WX_Error::API_UNAUTHORIZED;
				break;
			default :
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
		if ($log_enabled)
			$this->_log();

		$this->_error_code = $code;
		$this->_error_message = WX_Error::getMessage($code);
	}

	/**
     * 解析token
     *
     * @param  array  $response
     * @return object WX_Token
     */
	protected function _parseToken($response)
	{
		if (! isset($response['access_token']) || ! $response['access_token']) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		return new WX_Token($response['access_token'], $response['expires_in']);
	}

	/**
     * 解析用户
     *
     * function_description
     *
     * @author mxg
     * @param  array  $response
     * @return objeck WX_User
     */
	protected function _parseUser($response)
	{
		if (! isset($response['openid']) || ! $response['openid'] || ! isset($response['subscribe'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		$wxUser = new WX_User($response['openid'], $response['subscribe']);
		if ($response['subscribe']) {
			$wxUser->nickname = $response['nickname'];
			$wxUser->sex = $response['sex'];
			$wxUser->language = $response['language'];
			$wxUser->city = $response['city'];
			$wxUser->province = $response['province'];
			$wxUser->country = $response['country'];
			$wxUser->headimgurl = $response['headimgurl'];
			$wxUser->picture = $response['headimgurl'];
			$wxUser->subscribe_time = @$response['subscribe_time'];
		}
		return $wxUser;
	}

	/**
     * 解析用户列表
     *
     * @author mxg
     * @param  array  $response
     * @return array
     * array(
     *    'total' => int,//总数
     *    'count'=> int ,//当前数
     *    'data' => array() //openid数组
     * )
     */
	protected function _parseUserList($response)
	{
		if (! isset($response['count']) || ! isset($response['data'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		$users['total'] = $response['total'];
		$users['count'] = $response['count'];
		$users['data'] = $response['data']['openid'];
		$users['next_openid'] = $response['next_openid'];
		return $users;
	}

	/**
     * 分析发送消息结果
     *
     * @author mxg
     * @param  array  $response
     * @return string|null $message_id
     */
	protected function _parseSend($response)
	{
		if (! isset($response['errcode']) || ! isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return true;
		}
		$this->_setError(1000000);
		return false;
	}

	/**
     * 分析发送消息结果
     *
     * @param  array  $response
     * @return string $media_id
     */
	protected function _parseUpload($response)
	{
		if (! isset($response['type'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		$media_id = '';
		switch ($response['type']) {
			case 'thumb' :
				if (! isset($response['thumb_media_id']) || ! $response['thumb_media_id']) {
					$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
					return null;
				}
				$media_id = $response['thumb_media_id'];
				break;
			default :
				if (! isset($response['media_id']) || ! $response['media_id']) {
					$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
					return null;
				}
				$media_id = $response['media_id'];
		}
		return $media_id;
	}

	/**
     * 解析菜单
     *
     * @param  array  $response
     * @return objeck WX_Menu
     */
	protected function _parseMenu($response)
	{
		if (! isset($response['menu'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		$wxMenu = new WX_Menu($response['menu']['button']);

		return $wxMenu;
	}

	/**
     * 解析token
     *
     * @param  array  $response
     * @return object WX_Token
     */
	protected function _parseTicket($response)
	{
		if (! isset($response['ticket']) || ! $response['ticket']) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		return $response;
	}

	/**
     * 记录错误日志
     *
     * @author mxg
     * @return void
     */
	protected function _log()
	{
		$params = array ();
		$params['data'] = WeiXinApiRequest::$params;
		$params['response'] = WeiXinApiRequest::$response;
		Logger::error('WeiXinApi->_log：Contains the last API call url: ' . WeiXinApiRequest::$url, $params);
	}
	
	/**
	 * 获取jsapi_ticket
	 *
	 * 对应API：{@link https://api.weixin.qq.com/cgi-bin/ticket/getticket}
	 *
	 * @access public
	 * @return object WX_Token
	 */
	public function getJsApiTicket($type = 'jsapi')
	{
		$type = in_array($type, array('jsapi', 'wx_card')) ? $type : 'jsapi';
		$params = array ();
		$params['type'] = $type;
		$path = 'ticket/getticket';
		$response = WeiXinApiRequest::GET($this->_genUrl($path), $params);
		return call_user_func_array(array (
				$this,
				'_parse'
		), array (
				WeiXinApiRequest::$http_code,
				$response,
				'_parseJsApiTicket'
		));
	}
	
	/**
	 * 解析token
	 *
	 * @param  array  $response
	 * @return array
	 */
	protected function _parseJsApiTicket($response)
	{
		if (! isset($response['errcode']) || ! isset($response['errmsg']) || ! isset($response['ticket'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
	
		return $response['ticket'];
	}
}