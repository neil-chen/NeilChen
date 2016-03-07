<?php
/**
 * 卡券基类对象
 * @author gzss
 * @version 2014-11-10
 */
class CardBase {
	protected $logo_url;			//logo
	protected $code_type;			//code_type_text 文本,code_type_barcode 一维码, code_type_qrcode 二维码
	protected $brand_name;			//商户名称
	protected $title; 				//券名称 -上限9个汉字
	protected $sub_title;			//券副标题 ，18个汉字  -----非必填
	protected $color;				//券颜色
	protected $notice;				//使用提醒
	protected $service_phone;		//客服电话  -----非必填
	protected $source;				//第三方来源名称  -----非必填
	protected $description;			//长文本描述，1000个汉字
	//-----非必填
	protected $use_limit;			//每人使用次数
	protected $get_limit;			//每人最大领取数量
	protected $use_custom_code;		//是否自定义code码 true
	protected $bind_openid;			//是否指定用户领取
	protected $can_share;			//是否可以分享
	protected $can_give_friend;		//是否可以转赠 false
	protected $location_id_list;	//门店地址id
	
	protected $date_info = array(
	// 			'type'=>1,				//固定日期区间，2固定时长，自领取多少天
	// 			'begin_timestamp'=>'',	//type 1开始
	// 			'end_timestamp'=>'',	//type 1结束
	// 			'fixed_term'=>1,		//type2 自领取后多少天内有效
	// 			'fixed_begin_term'=>1,	//type 2自领取后多少天内生效.
	);//使用日期有效期的信息
	protected $sku=array(
	// 			'quantity'=>10100,		//库存
	);//库存
	
	//-----非必填
	protected $url_name_type;		//自定义cell名称
	protected $custom_url;			//自定义url
	
	//自定义
	protected $attr;				//扩展
	//type
	protected $type;				//类型
	
	public function __construct($data) {
		$this->logo_url			= isset($data['logo_url']) ? trim($data['logo_url']) : '';
		$this->code_type		= isset($data['code_type']) ? trim($data['code_type']) : '';
		if(!in_array($this->code_type, array('code_type_text','code_type_barcode','code_type_qrcode'))){
			$this->code_type	= 'code_type_text';
		}
		$this->code_type		= strtoupper($this->code_type);
		$this->brand_name		= isset($data['brand_name']) ? trim($data['brand_name']) : '';
		$this->title			= isset($data['title']) ? trim($data['title']) : '';
		//非必填
		$this->sub_title		= isset($data['sub_title']) ? trim($data['sub_title']) : '';
		$this->color			= isset($data['color']) ? trim($data['color']) : '';
		$this->notice			= isset($data['notice']) ? trim($data['notice']) : '';
		//非必填
		$this->service_phone	= isset($data['service_phone']) ? trim($data['service_phone']) : '';
		//非必填
		$this->source			= isset($data['source']) ? trim($data['source']) : '';
		$this->description		= isset($data['description']) ? trim($data['description']) : '';
		
		$this->use_limit		= isset($data['use_limit']) ? intval($data['use_limit']) : 1;
		$this->get_limit		= isset($data['get_limit']) ? intval($data['get_limit']) : 0;
		
		$this->use_custom_code	= isset($data['use_custom_code']) ? $data['use_custom_code'] : false;
		$this->bind_openid		= isset($data['bind_openid']) ? $data['bind_openid'] : false;
		$this->can_share		= isset($data['can_share']) ? $data['can_share'] : true;
		$this->can_give_friend	= isset($data['can_give_friend']) ? $data['can_give_friend'] : true;
		$this->location_id_list	= isset($data['location_id_list']) ? $data['location_id_list'] : '';
		
		$this->date_info		= isset($data['date_info']) ? $data['date_info'] : array();
		$this->sku				= isset($data['sku']) ? $data['sku'] : array();
		
		$this->url_name_type	= isset($data['url_name_type']) ? trim($data['url_name_type']) : '';
		$this->custom_url		= isset($data['custom_url']) ? trim($data['custom_url']) : '';
		
		$this->type				= strtoupper($data['type']);
	}
	
	public function get_vars() {
		$data = array();
		foreach ($this as $k => $v) {
			if ($k != 'type' && $k != 'attr') {
				if($v===''){
					continue;
				}
				//如果为非必填且为空的则不提交到微信，如不限制用户领取数量则使用默认，避免卡券在使用中遇到其他的问题
				if(empty($v)) continue;
				$data[$k] = $v;
			}			
		}
		$type=strtolower($this->type);
		$data = array (
				'card' => array (
					'card_type' => $this->type,
					$type 		=> array (
						'base_info' => $data 
					) 
				) 
		);
		foreach ( $this->attr as $k => $v ) {
			$data['card'][$type][$k] = $v;
		}
		return $data;
	}
	
	/*
	 * 使用时间类型：1固定日期区间; 2固定时长（自领取后按天算）
	 */
	public function set_date($data) {
		Logger::debug('data:', $data);
		if(in_array($data['type'], array(1, 2))){
			$this->date_info['type'] = $data['type'];
		}

		if($data['type']==1) {
			$this->date_info['begin_timestamp']	= $data['begin'];
			$this->date_info['end_timestamp']	= $data['end'];
		}

		if($data['type']==2) {
			$this->date_info['fixed_term']		= $data['valid_time'];//有效期
			$this->date_info['fixed_begin_term']= $data['valid_begin'];//生效期
		}
	}
	
	/*
	 * 设置商品信息
	 */
	public function set_sku($num=1) {
		$this->sku['quantity'] = $num;
	}
	
}