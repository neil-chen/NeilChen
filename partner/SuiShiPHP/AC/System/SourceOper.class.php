<?php
/**
 * 用户来源操作记录表
 */
class SourceOper {
	
	private static $instance;
	
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 插入一条用户来源记录
	 * @param int $aid 活动id
	 * @param int $uid 用户id
	 * @paarm int $source 来源值
	 * @param string $memo 备用信息
	 */
	public function insertUsource($aid,$uid,$source,$memo="") {
		try{
			$curTime = time();
			if($sid = $this->getSidBySource($aid, $source)) {											//之前存在来源记录
				$strsql = "INSERT INTO `".DBConfig::$table['usource']."`(`uid`,`aid`,`sid`,`num`,`time`) VALUES ('{$uid}',{$aid},{$sid},'1',{$curTime}) ON DUPLICATE KEY UPDATE `num`=`num`+1,`time`={$curTime}";
				Factory::getDb("weixin_active")->query($strsql);
				return Factory::getDb("weixin_active")->affectedRows();
			} else {
				$sid = $this->insertSource($aid, $source,$memo);
				Factory::getDb("weixin_active")->insert(DBConfig::$table['usource'],array('sid'=>$sid,'aid'=>$aid,'uid'=>$uid,'num'=>1,'time'=>time()));
				return Factory::getDb("weixin_active")->affectedRows();
			}
		} catch (Exception $e) {
			Logger::error("插入一条用户来源记录失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 通过来源记录和活动id查询来源id值
	 * @param int $aid 活动id
	 * @param string $source 来源值
	 */
	public function getSidBySource($aid,$source) {
		try {
			$strsql = "SELECT * FROM ".DBConfig::$table['source']." WHERE `aid` = {$aid} AND `svalue` = '{$source}'";
			$res = Factory::getDb("weixin_active")->getRow($strsql);
			return isset($res['sid']) ? $res['sid'] : 0;
		} catch (Exception $e) {
			Logger::error("通过来源记录和活动id查询来源id值失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 插入一条来源记录
	 * @param int $aid 活动id
	 * @param int $scontent 来源值
	 * @param int $memo 备注信息(默认空字符)
	 * @return int $sid 插入的id即(来源id)
	 */
	public function insertSource($aid,$scontent,$memo=""){
		try {
			$scontent = mysql_real_escape_string($scontent);
			if($memo) $memo = mysql_real_escape_string($memo);
			$sid = Factory::getDb("weixin_active")->insert(DBConfig::$table['source'],array("aid"=>$aid,"svalue"=>$scontent,"memo"=>$memo));
			return $sid;
		} catch (Exception $e) {
			Logger::error("插入一条来源记录失败".$e->getmessage());
			return false;
		}
	}
}