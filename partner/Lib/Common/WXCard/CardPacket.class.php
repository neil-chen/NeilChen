<?php
/**
 * 微信卡包处理
 * @author gzss
 * @version 2014-11-10
 */
define("WX_CARD",dirname(__FILE__));
class CardPacket{
	
	//创建
	const create		= 'https://api.weixin.qq.com/card/create?access_token=%s';
	//导入门店
	const create_shop 	= 'https://api.weixin.qq.com/card/location/batchadd?access_token=%s';
	//门店列表
	const shop_list		= 'https://api.weixin.qq.com/card/location/batchget?access_token=%s';
	//颜色值
	const color			= 'https://api.weixin.qq.com/card/getcolors?access_token=%s';
	//生成卡券二维码
	const create_qrcard	= 'https://api.weixin.qq.com/card/qrcode/create?access_token=%s';
	//核销
	const consume		= 'https://api.weixin.qq.com/card/code/consume?access_token=%s';
	//开发者白名单
	const white			= 'https://api.weixin.qq.com/card/testwhitelist/set?access_token=%s';
	
	//批量查询卡券列表
	const card_list		= 'https://api.weixin.qq.com/card/batchget?access_token=%s';
	//查询卡券详情
	const card_info		= 'https://api.weixin.qq.com/card/get?access_token=%s';
	//删除卡券详情
	const card_del		= 'https://api.weixin.qq.com/card/delete?access_token=%s';
	//查询卡券code详情
	const code_info 	= 'https://api.weixin.qq.com/card/code/get?access_token=%s';
	
	//JSAPI拉取卡券获取数据解码获取code接口
	const decrypt_code	= 'https://api.weixin.qq.com/card/code/decrypt?access_token=%s';
	
	private $debug; //true为开启写入系统日志 ,默认不写
	
	public $card;//卡券
	private $token;
	private $card_type = array(
			"GENERAL_COUPON",
			"GROUPON",
			"DISCOUNT",
			"GIFT",
			"CASH",
			"MEMBER_CARD",
			"SCENIC_TICKET",
			"MOVIE_TICKET" 
	);
	
	/*
	 * 加载WeiXinApiRequest
	 */
	public function __construct($token, $debug=FALSE) {
		class_exists('WeiXinApiRequest') || include_once SUISHI_PHP_PATH.'/API/WeiXinApiRequest.class.php';

		$this->token = $token; 
		$this->debug = $debug;
	}
	
	/**
	 * 创建卡券对象
	 * @param unknown $data
	 */
	public function createCardObj($data){
		$data['type'] = strtoupper($data['type']);
		if(!in_array($data['type'], $this->card_type)){
			return false;
		}
		switch ($data['type']) {
			case 'GENERAL_COUPON':
				//创建通用券
				if(!class_exists('CardGeneralCoupon')){
					include WX_CARD.'/CardGeneralCoupon.class.php';
				}
				
				$this->card = new CardGeneralCoupon($data);
				break;
			case 'CASH':
				//创建代金券
				if(!class_exists('CardCash')){
					include WX_CARD.'/CardCash.class.php';
				}
				
				$this->card = new CardCash($data);
				break;
			case 'GROUPON':
				//创建团购券
				if(!class_exists('CardGroupon')){
					include WX_CARD.'/CardGroupon.class.php';
				}
				
				$this->card = new CardGroupon($data);
				break;
			case 'DISCOUNT':
				//创建折扣券
				if(!class_exists('CardDiscount')){
					include WX_CARD.'/CardDiscount.class.php';
				}
				
				$this->card = new CardDiscount($data);
				break;
			case 'GIFT':
				//创建礼品券
				if(!class_exists('CardGift')){
					include WX_CARD.'/CardGift.class.php';
				}
				
				$this->card = new CardGift($data);
				break;
			default:
				break;
		}
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket 创建卡券对象：", array('data'=>$data, 'cardObj'=>$this->card));
		
		return $this->card;
	}
	
	/**
	 * 批量查询卡券列表
	 * "offset": 0,
		"count": 10
		@return "card_id_list":["ph_gmt7cUVrlRk8swPwx7aDyF-pg"],"total_num":1
	 */
	public function list_card($data=array('offset'=>0,'count'=>10)){
		
		$url=sprintf(self::card_list, $this->token);
		
		$json = code_unescaped($data);
		$result = WeiXinApiRequest::post($url, $json, false, false);
		
		if($result['errcode']!=0){
			$this->error=array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		
		return $result;
	}
	
	/**
	 * 查询卡券详情
	 * status 1：待审核，2：审核失败，3：通过审核， 4：已删除（飞机票的 status 字段为 1：正常 2：已删除）
	 */
	public function info_card($card_id){
		$data=array(
			'card_id'=>$card_id
		);
		$url=sprintf(self::card_info, $this->token);
		
		$json = code_unescaped($data);
		
		$result = WeiXinApiRequest::post($url, $json, false, false);
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket 查询卡券详情：", array('card_id'=>$card_id, 'result'=>$result));
		
		if($result['errcode']!=0){
			$this->error=array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		
		return $result['card'];
		
	}
	
	/**
	 * 删除卡券
	 */
	public function del_card($card_id){
		$data=array(
				'card_id'=>$card_id
		);

		$url=sprintf(self::card_del, $this->token);
		
		$json = code_unescaped($data);
		$result = WeiXinApiRequest::post($url, $json, false, false);
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket 删除卡券：", array('card_id'=>$card_id, 'result'=>$result));
		
		if($result['errcode']!=0){
			$this->error=array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		return TRUE;
	}
	
	/**
	 * 卡券核销代码
	 * @param array $data
	 * @return array
	 */
	public function consumeCard($data){

		$url=sprintf(self::consume, $this->token);

		$json = code_unescaped($data);
		Logger::debug('$json :',json_encode($data)); 
		$result = WeiXinApiRequest::post($url, $json, false, false);
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket 卡券核销：", array('data'=>$data, 'json'=>$json, 'result'=>$result));
		
		if($result['errcode']!=0){
			$this->error=array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		return $result;
		
	}
	
	/**
	 * 生成卡券
	 * 返回卡券的id
	 */
	public function createCard($data){
		$url=sprintf(self::create, $this->token);
		
		$json = code_unescaped($data);
		$result = WeiXinApiRequest::post($url, $json, false, false);
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket 生成卡券：", array('data'=>$data, 'json'=>$json, 'result'=>$result));
		
		if($result['errcode']!=0){
			$this->error=array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		return $result['card_id'];
	}
	
	/**
	 * 生成卡券的二维码
	 * pSET1jsKHr93TUMYtx6qUz7fbM2Q 测试卡号
	 */
	public function createQrCode($data){
		$url=sprintf(self::create_qrcard, $this->token);
		
		$json = code_unescaped($data);

		$result = WeiXinApiRequest::post($url, $json, false, false);
		
		if($result['errcode']!=0){
			$this->error = array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		$ticket=$result['ticket'];
		$url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=%s";
		$url=sprintf($url,$ticket);
		
		return $url;
	}
	
	/**
	 * 获取颜色列表
	 * 返回颜色的list
	 */
	public function list_color(){

		$data=array();
		$url=sprintf(self::color, $this->token);
		
		$result = WeiXinApiRequest::get($url);
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket 获取颜色列表：", array('result'=>$result));
		
		if($result['errcode']!=0){
			$this->error=array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		return $result['colors'];
	}
	/**
	 * 导入门店信息
	 */
	public function add_shop($data){

// 		$data=array(
// 			'location_list'=>array(
// 					array(
// 							"business_name"=>"广州东风南方中大",
// 							"province"=>"广东省",
// 							"city"=>"广州市",
// 							"district"=>"天河区",
// 							"address"=>"中山大道西棠东895号",
// 							"telephone"=>"020-85553008",
// 							"category"=>"汽车",
// 							"longitude"=>"115.32375",
// 							"latitude"=>"25.097486"			
// 					),
// 			),
// 		);
		$url	= sprintf(self::create_shop, $this->token);

		$json = code_unescaped($data);
		$result	= WeiXinApiRequest::post($url, $json, false, false);
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket 导入门店：", array('data'=>$data, 'json'=>$json, 'result'=>$result));
		
		return $result['location_id_list'];
	}
	
	/**
	 * 拉取门店信息 
	 * $data=array(
				'offset'=>0,
				'count'=>0
		);
	 */
	public function list_shop($data){
		$url	= sprintf(self::shop_list, $this->token);
		
		$json = code_unescaped($data);
		$result = WeiXinApiRequest::post($url, $json, false, false);
		if($result['errcode']!=0){
			$this->error = array('errcode'=>$result['errcode'], 'errmsg'=>$result['errmsg']);
			return $this->error;
		}
		
		return $result['location_list'];
	}
	
	
	/**
	 * 添加测试白名单
	 * @param $data
	 * $data	= array(
				'openid'	=> array('ocJOVjijSz0m0eOPN4hhn-ZW9s3E'),
				'usernmae'	=> array(),
		);
	 */
	public function addWhite($data) {
		$url	= sprintf(self::white, $this->token);
		
		$json = code_unescaped($data);
		$result	= WeiXinApiRequest::post($url, $json, false, false);
		var_dump($result);
	}
	
	/**
	 * 签名认证
	 * @param array $data
	 * @return string
	 */
	public function signature($data){
		Logger::debug ( '加密参数:' . json_encode($data ));
		foreach ($data as &$v){
			$v = strval($v);
		}
		unset($v);
		sort($data);
		return strtoupper(sha1(implode($data)));
	}
	
	/*
	 * 由JSAPI拉起卡券列表进行核销，根据encrypt_code解码获得code
	 */
	public function decrypt_code($encrypt) {
		$url	= sprintf(self::decrypt_code, $this->token);
		
		$json = code_unescaped(array('encrypt_code'=>$encrypt));
		$result = WeiXinApiRequest::post($url, $json, false, false);

		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket encrypt_code拉起卡券解码：", array('encrypt'=>$encrypt, 'result'=>$result));
		
		if($result['errcode']==0){
			return $result['code'];
		}
		
		return FALSE;
	}
	
	/*
	 * 第三方code信息
	 * @param string $code
	 * @param string $card_id
	 */
	public function code_info($code, $card_id) {
		$url = sprintf(self::code_info, $this->token);
		
		$json = code_unescaped(array('code'=>$code, 'card_id'=>$card_id));
		$result = WeiXinApiRequest::post($url, $json, false, false);
		
		//写入系统日志
		$this->debug && Factory::getSystemLog()->push("CardPacket code_info获取卡券领取信息：", array('code'=>$code, 'card_id'=>$card_id, 'result'=>$result));
		
		if($result['errcode']==0){
			return $result['openid'];
		}
		
		return FALSE;
	}
}


class Signature{
	function __construct(){
		$this->data = array();
	}
	function add_data($str){
		array_push($this->data, (string)$str);
	}
	function get_signature(){
		sort( $this->data, SORT_STRING );
		return sha1( implode( $this->data ) );
	}
}


