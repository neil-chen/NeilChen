<?php
/**
 * 代金券
 * @author gzss
 * @version 2014-11-10
 */
if(!class_exists('CardBase')){
	include dirname(__FILE__).'/CardBase.class.php';
}
class CardCash extends CardBase{
	
	public function __construct($data){
		parent::__construct($data);
		$this->attr['least_cost']	= isset($data['least_cost']) ? trim($data['least_cost']) : '';
		$this->attr['reduce_cost']	= isset($data['reduce_cost']) ? trim($data['reduce_cost']) : '';
	}
	
}