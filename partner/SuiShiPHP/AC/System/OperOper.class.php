<?php
/**
 * 此类为操作记录保存类
 */

class OperOper {
	
	private static $instance;
	
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 插入一条操作记录或更新一条操作记录
	 */
	public function updateRecord($uid,$aid,$key,$filed = "") {
		try {
			$curTime = time();
			if($filed) {
				$strsql = "INSERT INTO `".DBConfig::$table['oper']."`(`uid`,`aid`,`operNum`,`operKey`,`operValue`,`time`) VALUES ('{$uid}',{$aid},1,'{$key}','{$filed}',{$curTime}) ON DUPLICATE KEY UPDATE `operNum`=`operNum`+1,`operValue`=CONCAT(`operValue`,'{$filed}'),`time`={$curTime}";
			} else {
				$strsql = "INSERT INTO `".DBConfig::$table['oper']."`(`uid`,`aid`,`operNum`,`operKey`,`operValue`,`time`) VALUES ('{$uid}',{$aid},1,'{$key}','{$filed}',{$curTime}) ON DUPLICATE KEY UPDATE `operNum`=`operNum`+1,`time`={$curTime}";
			}
			Factory::getDb("weixin_active")->query($strsql);
			return Factory::getDb("weixin_active")->affectedRows();
		} catch (Exception $e) {
			Logger::error("插入业务数据或者更新之失败".$e->getmessage());
			return false;
		}
	}
	
}