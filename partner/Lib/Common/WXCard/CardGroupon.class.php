<?php
/**
 * 团购券
 * @author gzss
 * @version 2014-11-10
 */
if(!class_exists('CardBase')){
	include dirname(__FILE__).'/CardBase.class.php';
}
class CardGroupon extends CardBase{
	
	public function __construct($data){
		parent::__construct($data);
		$this->attr['deal_detail'] = isset($data['deal_detail']) ? trim($data['deal_detail']) : '';
	}
	
}