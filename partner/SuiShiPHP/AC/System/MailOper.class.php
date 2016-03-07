<?php
/**
 * 此为活动业务数据保存类（涉及活动操作）
 */
class MailOper {
	
	private static $instance;
	
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 插入记录
	 */
	public function insertInfo($data) {
		if(!$uid = $data['uid']) return false;
		if(!$aid = $data['aid']) return false;
		if(!$wid = $data['wid']) return false;
		$name = $data['name'];
		$cardID = $data['cardID'];
		if(!$address = $data['address']) return false;
		$code = $data['code'];
		if(!$tel = $data['tel']) return false;
		if(!$rid = $data['rid']) return false;
		Factory::getDb("weixin_active")->insert(DBConfig::$table['mail'],array('uid'=>$uid,'aid'=>$aid,'wid'=>$wid,'name'=>$name,'cardID'=>$cardID,'address'=>$address,'code'=>$code,'tel'=>$tel,'rid'=>$rid,'time'=>time()));
		return Factory::getDb("weixin_active")->insertId();
	}
}