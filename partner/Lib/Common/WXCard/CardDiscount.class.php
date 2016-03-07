<?php
/**
 * 折扣券
 * @author gzss
 * @version 2014-11-10
 */
if(!class_exists('CardBase')){
	include dirname(__FILE__).'/CardBase.class.php';
}
class CardDiscount extends CardBase{
	
	public function __construct($data){
		parent::__construct($data);
		$this->attr['discount']	= isset($data['discount']) ? intval($data['discount']) : 0;
	}
	
}