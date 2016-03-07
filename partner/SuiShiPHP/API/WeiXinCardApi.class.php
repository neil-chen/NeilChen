<?php
include_once SUISHI_PHP_PATH . '/API/WeiXinError.class.php';
include_once SUISHI_PHP_PATH . '/API/WeiXinApiRequest.class.php';
include_once SUISHI_PHP_PATH . '/Common/Json.class.php';

/**
 * 微信卡包相关api接口文件
 * 
 * @author paizhang 2014-09-29
 */
class WeiXinCardApi
{
	/**
	 * appid
	 * 
	 * @var string
	 */
	protected $appId = '';
	/**
	 * app secret
	 * 
	 * @var string
	 */
	protected $appSecret = '';
	/**
	 * access token
	 * 
	 * @var string
	 */
	protected $accessToken = '';
	/**
	 * 微信用户openid
	 * 
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
	 * 
	 * @var string
	 */
	protected $apiUri = 'https://api.weixin.qq.com/';

	public function __construct($appId, $appSecret, $accessToken)
	{
		$this->appId = $appId;
		$this->appSecret = $appSecret;
		$this->setAccessToken($accessToken);
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
	 * 
	 * @param string $token
	 */
	public function setAccessToken($token)
	{
		$this->accessToken = $token;
	}

	/**
	 *
	 * @param array $baseInfo see createCash()
	 */
	/**
	 * 创建代金券时，检查base_info信息是否合法
	 * 
	 * @param $baseInfo
	 * @return bool
	 */
	protected function _checkBaseInfo($baseInfo)
	{
		$result = array();
		if (empty($baseInfo['logo_url'])) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$codeType = array(
				'CODE_TYPE_BARCODE',
				'CODE_TYPE_TEXT',
				'CODE_TYPE_QRCODE' 
		);
		if (!in_array(@$baseInfo['code_type'], $codeType)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (empty($baseInfo['brand_name']) || (mb_strlen($baseInfo['brand_name']) > 36)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (empty($baseInfo['title']) || (mb_strlen($baseInfo['title']) > 27)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$colorArr = array(
				'Color010',
				'Color020',
				'Color030',
				'Color040',
				'Color050',
				'Color060',
				'Color070',
				'Color080',
				'Color090',
				'Color100' 
		);
		if (!in_array(@$baseInfo['color'], $colorArr)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (empty($baseInfo['notice']) || (mb_strlen($baseInfo['notice']) > 27)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (empty($baseInfo['description']) || (mb_strlen($baseInfo['description']) > 900)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (empty($baseInfo['date_info'])) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (!in_array(@$baseInfo['date_info']['type'], array(
				1,
				2 
		))) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (1 == $baseInfo['date_info']['type']) {
			if (empty($baseInfo['date_info']['begin_timestamp']) || !is_string($baseInfo['date_info']['begin_timestamp'])) {
				$this->_setError(WX_Error::PARAM_ERROR, false);
				return false;
			}
			if (empty($baseInfo['date_info']['end_timestamp']) || !is_string($baseInfo['date_info']['end_timestamp'])) {
				$this->_setError(WX_Error::PARAM_ERROR, false);
				return false;
			}
		} else if (2 == $baseInfo['date_info']['type']) {
			if (empty($baseInfo['date_info']['fixed_term'])) {
				$this->_setError(WX_Error::PARAM_ERROR, false);
				return false;
			}
		}
		if (empty($baseInfo['sku'])) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if (empty($baseInfo['sku']['quantity'])) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		return true;
	}

	/**
	 * 创建代金券卡券接口
	 * 
	 * @param $baseInfo array array (
	 *        logo_url : 卡券的商户logo，尺寸为300*300。(必填)
	 *        code_type : code 码展示类型 "CODE_TYPE_TEXT"，文本"CODE_TYPE_BARCODE"，一维码"CODE_TYPE_QRCODE"，二维码(必填)
	 *        brand_name : 商户名字,字数上限为12 个汉字(必填)
	 *        title : 券名，字数上限为9 个汉字(必填)
	 *        sub_title : 券名的副标题，字数上限为18 个汉字。
	 *        color : 券颜色。按色彩规范标注填写Color010-Color100(必填)
	 *        notice : 使用提醒，字数上限为9 个汉字。（一句话描述，展示在首页）(必填)
	 *        service_phone : 客服电话
	 *        source : 第三方来源名，例如同程旅游、格瓦拉。
	 *        description : 使用说明。长文本描述，可以分行，上限为1000 个汉字。(必填)
	 *        use_limit : 每人使用次数限制
	 *        get_limit : 每人最大领取次数，不填写默认等于quantity。
	 *        use_custom_code : 是否自定义code 码。填写true 或false，不填代表默认为false。
	 *        bind_openid : 是否指定用户领取，填写true 或false。不填代表默认为否。
	 *        can_share : 领取卡券原生页面是否可分享，填写true 或false，true 代表可分享。默认可分享。
	 *        can_give_friend : 卡券是否可转赠，填写true或false,true 代表可转赠。默认可转赠。
	 *        location_id_list : 门店位置ID。商户需在mp平台上录入门店信息或调用批量导入门店信息接口获取门店位置ID。
	 *        date_info : array (
	 *        type: 使用时间的类型,1：固定日期区间，2：固定时长（自领取后按天算）(必填)
	 *        begin_timestamp: 固定日期区间专用，表示起用时间
	 *        end_timestamp: 固定日期区间专用，表示结束时间
	 *        fixed_term: 固定时长专用，表示自领取后多少天内有效
	 *        fixed_begin_term: 固定时长专用，表示自领取后多少天开始生效
	 *        )
	 *        sku : array (
	 *        quantity : 上架的数量(必填)
	 *        )
	 *        url_name_type : 商户自定义cell 名称。"URL_NAME_TYPE_TAKE_AWAY"，外卖
	 *        "URL_NAME_TYPE_RESERVATION"，在线预订
	 *        "URL_NAME_TYPE_USE_IMMEDIATELY"，立即使用
	 *        custom_url : 商户自定义url 地址，支持卡券页内跳转
	 *       
	 *        )
	 * @param float $reduceCost 代金券专用，表示减免金额（单位为分）
	 * @param float $leastCost 代金券专用，表示起用金额（单位为分）
	 * @return string the card id
	 */
	public function createCash($baseInfo, $reduceCost, $leastCost = false)
	{
		// 参数验证
		if (!$this->_checkBaseInfo($baseInfo)) {
			return null;
		}
		$param = array(
				'card' => array(
						'card_type' => 'CASH',
						'cash' => array(
								'base_info' => $baseInfo,
								'least_cost' => $leastCost,
								'reduce_cost' => $reduceCost 
						) 
				) 
		);
		$url = $this->_getUrl('card/create');
		// WeiXinApiRequest::$debug = 1;
		$json = new Json();
		$param = $json->encode($param, false); // print_r($param);return false;
		$response = WeiXinApiRequest::post($url, $param);
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseCreateCard' 
		));
	}
	
	/*
	 * 创建卡券接口(代金券,折扣券)
	 */
	public function createCard($baseInfo, $busInfo, $cardType = 'CASH')
	{
		// 参数验证
		if (!$this->_checkBaseInfo($baseInfo)) {
			return null;
		}
		switch ($cardType) {
			case 'CASH' :
				$param = array(
						'card' => array(
								'card_type' => 'CASH',
								'cash' => array(
										'base_info' => $baseInfo,
										'least_cost' => $busInfo['least_cost'],
										'reduce_cost' => $busInfo['reduce_cost'] 
								) 
						) 
				);
				break;
			case 'DISCOUNT' :
				$param = array(
						'card' => array(
								'card_type' => 'DISCOUNT',
								'discount' => array(
										'base_info' => $baseInfo,
										'discount' => $busInfo['discount'] 
								) 
						) 
				);
				break;
			default :
				$param = array(
						'card' => array(
								'card_type' => 'CASH',
								'cash' => array(
										'base_info' => $baseInfo,
										'least_cost' => $busInfo['least_cost'],
										'reduce_cost' => $busInfo['reduce_cost'] 
								) 
						) 
				);
		}
		$url = $this->_getUrl('card/create');
		// WeiXinApiRequest::$debug = 1;
		$json = new Json();
		$param = $json->encode($param, false);
		$response = WeiXinApiRequest::post($url, $param);
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseCreateCard' 
		));
	}

	/**
	 * 获取卡券详情
	 * 
	 * @param $card_id
	 * @return mixed|null
	 */
	public function getCardInfo($card_id)
	{
		if (empty($card_id)) {
			return null;
		}
		$url = $this->_getUrl('card/get');
		// WeiXinApiRequest::$debug = 1;
		$param = array(
				'card_id' => $card_id 
		);
		$response = WeiXinApiRequest::post($url, json_encode($param));
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseGetCardInfo' 
		));
	}

	/**
	 * 删除卡券（这里不仅仅只能删除代金券，包含了能创建的7种卡券）
	 * 
	 * @param $card_id 卡券id
	 * @return mixed|null
	 */
	public function deleteCard($card_id)
	{
		// 参数验证
		if (empty($card_id)) {
			return null;
		}
		$param = array(
				'card_id' => $card_id 
		);
		$url = $this->_getUrl('card/delete');
		// WeiXinApiRequest::$debug = 1;
		$response = WeiXinApiRequest::post($url, json_encode($param));
		// print_r($response);exit;
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseGeneral' 
		));
	}

	/**
	 * 查询code
	 * 
	 * @param $code
	 * @return mixed|null
	 */
	public function getCodeInfo($code)
	{
		// 参数验证
		if (empty($code)) {
			return null;
		}
		$param = array(
				'code' => $code 
		);
		$url = $this->_getUrl('card/code/get');
		// WeiXinApiRequest::$debug = 1;
		$response = WeiXinApiRequest::post($url, json_encode($param));
		// print_r($response);exit;
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseCodeInfo' 
		));
	}

	/**
	 * 设置卡券失效
	 * 
	 * @param $code
	 * @param null $card_id
	 * @return mixed|null
	 */
	public function setCardCodeUnavailable($code, $card_id = NULL)
	{
		// 参数验证
		if (empty($code)) {
			return null;
		}
		$param = array(
				'code' => $code 
		);
		if ($card_id)
			array_push($param, $card_id);
		$url = $this->_getUrl('card/code/unavailable');
		// WeiXinApiRequest::$debug = 1;
		$response = WeiXinApiRequest::post($url, json_encode($param));
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseGeneral' 
		));
	}

	/**
	 * 生成卡券二维码（返回ticket，根据ticket再换取二维码图片）
	 * 
	 * @param $card_id
	 * @param null $code
	 * @param null $openid
	 * @param null $expire_seconds
	 * @param bool $is_unique_code
	 * @return bool|mixed|null
	 */
	public function createCardQrcode($card_id, $code = null, $openid = null, $expire_seconds = null, $is_unique_code = false)
	{
		// 参数验证
		if (empty($card_id)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$card_info = $this->getCardInfo($card_id);
		if ($card_info['use_custom_code'] && empty($code)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		if ($card_info['bind_openid'] && empty($openid)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$expire_seconds = intval($expire_seconds);
		if ($expire_seconds && ($expire_seconds < 60 || $expire_seconds > 1800)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$action_info = array();
		$action_info['card']['card_id'] = $card_id;
		if ($code) {
			$action_info['card']['code'] = $code;
		}
		if ($openid) {
			$action_info['card']['openid'] = $openid;
		}
		if ($expire_seconds) {
			$action_info['card']['expire_seconds'] = $expire_seconds;
		}
		if ($is_unique_code) {
			$action_info['card']['is_unique_code'] = $is_unique_code;
		}
		$param = array(
				'action_name' => 'QR_CARD',
				'action_info' => $action_info 
		);
		$url = $this->_getUrl('card/qrcode/create');
		// WeiXinApiRequest::$debug = 1;
		$response = WeiXinApiRequest::post($url, json_encode($param));
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseCreateCardQrcode' 
		));
	}

	/**
	 * 获取二维码图片地址
	 * 
	 * @param string $ticket
	 */
	public function getQrcUrl($ticket)
	{
		return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
	}

	/**
	 * 核销卡券code（创建卡券时use_custom_code为true时，card_id必须填写）
	 * 
	 * @param $code
	 * @param null $card_id
	 * @return bool|mixed
	 */
	public function consumeCardCode($code, $card_id = null)
	{
		// 参数验证
		if (empty($code)) {
			$this->_setError(WX_Error::PARAM_ERROR, false);
			return false;
		}
		$url = $this->_getUrl('card/code/consume');
		// WeiXinApiRequest::$debug = 1;
		$param = array();
		$param['code'] = $code;
		if ($card_id)
			$param['card_id'] = $card_id;
		$response = WeiXinApiRequest::post($url, json_encode($param));
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseConsumeCardCode' 
		));
	}

	/**
	 * 导入code接口 （源地址：http://api.weixin.qq.com/card/code/deposit?access_token=ACCESS_TOKEN）
	 * 
	 * @param $card_id
	 * @param $code
	 * @return mixed|null
	 */
	public function deposit($card_id, $code)
	{
		// 参数验证
		if (empty($card_id) || empty($code)) {
			return false;
		}
		$param = array(
				'card_id' => $card_id,
				'code' => $code 
		);
		$url = $this->_getUrl('card/code/deposit');
		// WeiXinApiRequest::$debug = 1;
		$json = new Json();
		$param = $json->encode($param, false);
		$response = WeiXinApiRequest::post($url, $param);
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseDeposit' 
		));
	}

	/**
	 * 设置测试用户白名单
	 * 
	 * @param $openid_arr
	 * @return mixed|null
	 */
	public function setTestWhiteList($openid_arr)
	{
		if (empty($openid_arr)) {
			// openid数组不能为空
			return null;
		}
		$param = array(
				'openid' => $openid_arr 
		);
		$url = $this->_getUrl('card/testwhitelist/set');
		// WeiXinApiRequest::$debug = 1;
		$response = WeiXinApiRequest::post($url, json_encode($param));
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseGeneral' 
		));
	}

	/**
	 * 设置错误信息
	 * 
	 * @param unknown $errorcode
	 * @param unknown $message
	 */
	private function _setErrorMsg($errorcode, $message)
	{
		$this->_error_code = $errorcode;
		$this->_error_message = $message;
	}

	/**
	 * 检查门店数据是否合法
	 * 
	 * @param $location_arr
	 * @return bool
	 */
	protected function _checkLocationInfo($location_arr)
	{
		$result = array();
		if (empty($location_arr)) {
			$this->_setErrorMsg(-1, "门店数据检查出错，参数不能为空或是必须是数组");
			return false;
		}
		foreach ( $location_arr as $rows ) {
			if (empty($rows['business_name'])) {
				$this->_setErrorMsg(-2, "门店数据出错，门店名称不能为空");
				return false;
			}
			if (empty($rows['province'])) {
				$this->_setErrorMsg(-2, "门店数据出错，省名称不能为空");
				return false;
			}
			if (empty($rows['city'])) {
				$this->_setErrorMsg(-2, "门店数据出错，城市不能为空");
				return false;
			}
			if (empty($rows['district'])) {
				$this->_setErrorMsg(-2, "门店数据出错，区域不能为空");
				return false;
			}
			if (empty($rows['address'])) {
				$this->_setErrorMsg(-2, "门店数据出错，详细地址不能为空");
				return false;
			}
			if (empty($rows['telephone'])) {
				$this->_setErrorMsg(-2, "门店数据出错，电话不能为空");
				return false;
			}
			if (empty($rows['category'])) {
				$this->_setErrorMsg(-2, "门店数据出错，分类不能为空");
				return false;
			}
			if (empty($rows['longitude'])) {
				$this->_setErrorMsg(-2, "门店数据出错，纬度不能为空");
				return false;
			}
			if (empty($rows['latitude'])) {
				$this->_setErrorMsg(-2, "门店数据出错，经度不能为空");
				return false;
			}
		}
		return true;
	}

	/**
	 * 批量导入门店信息
	 * 
	 * @param $location_arr
	 * @return mixed|null
	 */
	public function batchAdd($location_arr)
	{
		// 参数验证
		if (!$this->_checkLocationInfo($location_arr)) {
			return false;
		}
		$param = array(
				'location_list' => $location_arr 
		);
		$url = $this->_getUrl('card/location/batchadd');
		// WeiXinApiRequest::$debug = 1;
		$json = new Json();
		$param = $json->encode($param, false);
		$response = WeiXinApiRequest::post($url, $param);
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseBatchAdd' 
		));
	}

	/**
	 * 拉取门店列表
	 * 
	 * @param int $offset
	 * @param int $count
	 * @return mixed
	 */
	public function batchGet($offset = 0, $count = 0)
	{
		$param = array(
				'offset' => $offset,
				'count' => $count 
		);
		$url = $this->_getUrl('card/location/batchget');
		// WeiXinApiRequest::$debug = 1;
		$response = WeiXinApiRequest::post($url, json_encode($param));
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseBatchGet' 
		));
	}

	/**
	 * 获取颜色列表
	 * 
	 * @return mixed
	 */
	public function getColors()
	{
		$url = $this->_getUrl('card/getcolors');
		// WeiXinApiRequest::$debug = 1;
		$response = WeiXinApiRequest::get($url);
		return call_user_func_array(array(
				$this,
				'_parse' 
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseGetColors' 
		));
	}

	/**
	 * JS API 添加到卡包
	 * 
	 * @return mixed|null
	 */
	public function batchAddCard($card_id)
	{
		$card_info = $this->getCardInfo($card_id);
		if ($card_info) {
			$card_ext = array();
			$timestamp = strval(time());
			$card_ext['timestamp'] = $timestamp;
			$paraMap = array(
					$this->appSecret,
					$card_id,
					$timestamp 
			);
			sort($paraMap);
			$signature = sha1(implode($paraMap));
			$card_ext['signature'] = $signature;
			$card_list = array(
					'card_list' => array(
							array(
									'card_id' => $card_id,
									'card_ext' => json_encode($card_ext) 
							) 
					) 
			);
			return json_encode($card_list);
		} else {
			Logger::error('WeiXinCardApi erorr, url: ' . WeiXinApiRequest::$url, '根据card_id：' . $card_id . '查询卡券信息失败！');
			return false;
		}
	}

	/**
	 * 解密code
	 * https://api.weixin.qq.com/card/code/decrypt?access_token=TOKEN
	 * @param string $encrypt_code 加密的code
	 * @return string $decrypt_code 
	 */
	public function decryptCode($encrypt_code)
	{
		// 参数验证
		if (empty($encrypt_code)) {
			return false;
		}
		$param = array(
				'$encrypt_code' => $encrypt_code,
		);
		$url = $this->_getUrl('card/code/decrypt');
		// WeiXinApiRequest::$debug = 1;
		$json = new Json();
		$param = $json->encode($param, false);
		$response = WeiXinApiRequest::post($url, $param);
		return call_user_func_array(array(
				$this,
				'_parse'
		), array(
				WeiXinApiRequest::$http_code,
				$response,
				'_parseDecryptCode'
		));
	}
	
	/**
	 * 获取api请求url
	 * 
	 * @param 请求模块路径 $path
	 * @param 参数 $params
	 * @return string
	 */
	protected function _getUrl($path, $params = array())
	{
		$path = trim(trim($path), '/');
		$url = $this->apiUri . $path . '?access_token=' . $this->accessToken;
		;
		// echo $url;
		if ($params) {
			$url .= '?' . (is_array($params) ? http_build_query($params) : ltrim($params, '?'));
		}
		return $url;
	}

	/**
	 * 分析数据结果
	 *
	 * @param int $code curl发送请求的状态码
	 * @param array $response 得到的结果
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
			return call_user_func_array(array(
					$this,
					$func_name 
			), array(
					$response 
			));
		}
		return true;
	}

	/**
	 * 分析创建卡券结果
	 * 
	 * @author huqian
	 * @param array $response
	 * @return string|null
	 */
	protected function _parseCreateCard($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response['card_id'];
		}
		return false;
	}

	/**
	 * 查询卡券详情结果
	 * 
	 * @param $response
	 * @return bool
	 */
	protected function _parseGetCardInfo($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response['card'];
		}
		return false;
	}

	/**
	 * 生成卡券二维码
	 * 
	 * @param $response
	 * @return bool
	 */
	protected function _parseCreateCardQrcode($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response['ticket'];
		}
		return false;
	}

	/**
	 * 核销卡券code结果
	 * 
	 * @param $response
	 * @return bool
	 */
	protected function _parseConsumeCardCode($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response;
		}
		return false;
	}

	/**
	 * _parseGeneral
	 * 分析执行普通请求返回的结果（返回的数据示例为：{"errcode":0,"errmsg":"OK"}）
	 * 
	 * @author huqian
	 * @param array $response
	 * @return bool
	 */
	protected function _parseGeneral($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return true;
		}
		return false;
	}

	/**
	 * 查询code返回信息结果
	 * 
	 * @author huqian
	 * @param array $response
	 * @return string|null
	 */
	protected function _parseCodeInfo($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return array(
					'openid' => $response['openid'],
					'card' => $response['card'] 
			);
		}
		return false;
	}

	/**
	 * 分析批量导入门店信息结果
	 * 
	 * @author huqian
	 * @param array $response
	 * @return string|null
	 */
	protected function _parseBatchAdd($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response['location_id_list'];
		}
		return false;
	}

	/**
	 * 分析导入CODE结果
	 * 
	 * @author huqian
	 * @param array $response
	 * @return string|null
	 */
	protected function _parseDeposit($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return true;
		}
		return false;
	}
	
	/**
	 * 解析解密code
	 * @param string $response
	 */
	protected function _parseDecryptCode($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response['code'];
		}
		return false;
	}
	

	/**
	 * 拉取门店列表结果
	 * 
	 * @param $response
	 * @return bool
	 */
	protected function _parseBatchGet($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response['location_list'];
		}
		return false;
	}

	/**
	 * 获取颜色列表结果
	 * 
	 * @param $response
	 * @return bool
	 */
	protected function _parseGetColors($response)
	{
		if (!isset($response['errcode']) || !isset($response['errmsg'])) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return false;
		}
		if (0 == $response['errcode'] && strtolower($response['errmsg']) == 'ok') {
			return $response['colors'];
		}
		return false;
	}

	/**
	 * 分析错误
	 *
	 * @param int $code
	 * @param array $response
	 * @return bool
	 */
	protected function _parseError($code, $response)
	{
		$this->_error_code = WX_Error::NO_ERROR;
		if (200 == $code && (isset($response['errcode']) && $response['errcode'])) {
			$code = $response['errcode'];
		}
		// 与微信链接失败
		if (0 == $code) {
			$code = 5100;
		}
		
		switch ($code) {
			case 200 :
				return true;
			// http code
			case 404 :
				$error_code = WX_Error::HTTP_FORBIDDEN_ERROR;
				break;
			case 503 :
				$error_code = WX_Error::HTTP_SERVICE_UNAVAILABLE_ERROR;
				break;
			case 40013 :
				$error_code = WX_Error::INVALID_APP_ID_ERROR;
				break;
			case 41001 :
				$error_code = WX_Error::KOTEN_MISSING_ERROR;
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
	 * @param int $code
	 * @return void
	 */
	protected function _setError($code, $log_enabled = true)
	{
		// 记录错误日志
		if ($log_enabled)
			$this->_log();
		
		$this->_error_code = $code;
		$this->_error_message = WX_Error::getMessage($code);
	}

	/**
	 * 解析token
	 *
	 * @param array $response
	 * @return object WX_Token
	 */
	protected function _parseToken($response)
	{
		if (!isset($response['access_token']) || !$response['access_token']) {
			$this->_setError(WX_Error::RESPONSE_FOMAT_ERROR);
			return null;
		}
		return new WX_Token($response['access_token'], $response['expires_in']);
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
		Logger::error('WeiXinCardApi last erorr, url: ' . WeiXinApiRequest::$url, $params);
	}
}