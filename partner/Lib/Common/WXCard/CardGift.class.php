<?php
/**
 * 礼品券
 * @author gzss
 * @version 2014-11-10
 */
if(!class_exists('CardBase')){
	include dirname(__FILE__).'/CardBase.class.php';
}
class CardGift extends CardBase{
	
	public function __construct($data){
		parent::__construct($data);
		$this->attr['gift']	= isset($data['gift']) ? trim($data['gift']) : '';
	}
	
}