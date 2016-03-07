<?php
/**
 * 此类为活动配置相关类
 */
class ActionOper {
	
	private static $instance;
	
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 通过活动id获取活动信息
	 */
	public function getInfoByActionID($actionID) {
		try {
			$strsql = "SELECT * FROM `".DBConfig::$table['config']."` WHERE `id` = {$actionID} LIMIT 1";
			$res = Factory::getDb("weixin_active")->getRow($strsql);
			return (is_array($res) && $res) ? $res : array();
		} catch (Exception $e) {
			Logger::error("通过活动id获取活动信息失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 通过活动关键字获取活动信息
	 */
	public function getInfoByActionKey($actionKey) {
		try{
			$strsql = "SELECT * FROM `".DBConfig::$table['config']."` WHERE `key` = '{$actionKey}' LIMIT 1";
			$res = Factory::getDb("weixin_active","MySql")->getRow($strsql);
			return (is_array($res) && $res) ? $res : array();
		} catch (Exception $e) {
			Logger::error("通过关键字获取活动信息失败".$e->getmessage());
			return false;
		}
	}
}