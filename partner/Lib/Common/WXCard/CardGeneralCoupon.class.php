<?php
/**
 * 代金券
 * @author gzss
 * @version 2014-11-10
 */
if(!class_exists('CardBase')){
	include dirname(__FILE__).'/CardBase.class.php';
}
class CardGeneralCoupon extends CardBase{
	
	public function __construct($data){
		parent::__construct($data);
		$this->attr['default_detail']	= isset($data['default_detail']) ? trim($data['default_detail']) : '';
	}
	
}