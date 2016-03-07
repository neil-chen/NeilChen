<?php
/**
 * 此为活动业务数据保存类（涉及活动操作）
 */
class WorkOper {
	
	private static $instance;
	
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 通过用户id和活动id新建一个操作id
	 */
	public function buildWorkID($uid,$aid) {
		try {
			$wid = Factory::getDb("weixin_active")->insert(DBConfig::$table['record'],array("aid"=>$aid,"uid"=>$uid,"state"=>1,"time"=>time()));
			return $wid;
		} catch (Exception $e) {
			Logger::error("通过用户id和活动id新建一个操作id失败".$e->getMessage());
			return false;
		}
	}
	
	/**
	 * 通过操作id获取操作数据(状态)
	 */
	public function getWorkInfoByWID($wid) {
		try {
			$strsql = "SELECT * FROM ".DBConfig::$table['record']." WHERE `wid` = {$wid} LIMIT 1";
			$res = Factory::getDb("weixin_active")->getRow($strsql);
			return ($res && is_array($res)) ? $res : array();
		} catch (Exception $e) {
			Logger::error("通过操作id获取操作数据(状态)失败".$e->getMessage());
			return false;
		}
	}
	
	/**
	 * 通过用户id和活动id获取用户最近该活动的操作记录
	 * @param string $uid 用户id
	 * @param int $aid 活动id
	 * @return int $state 0-不可用  1-正常 2-已经完成  3-领取了奖励
	 */
	public function getWorkInfoByUID($uid,$aid) {
		try {
			$strsql = "SELECT * FROM ".DBConfig::$table['record']." WHERE `uid` = '{$uid}' AND `aid` = '{$aid}' ORDER BY `time` DESC LIMIT 1";
			$res = Factory::getDb("weixin_active")->getRow($strsql);
			return ($res && is_array($res)) ? $res : array();
		} catch (Exception $e) {
			Logger::error("获取用户操作记录失败".$e->getMessage());
			return false;
		}
		
	}
	
	/**
	 * 通过用户id和活动id获取用户参与了多少次活动
	 * @param int $isToday 是否今天  1-活动当天  0-代表全活动周期 2-活动前两天
	 */
	public function getUserWorkCount($uid,$aid,$startTime=0,$endTime=0) {
		try {
			if($startTime > 0) {
				if($endTime < $startTime) $endTime = $startTime;
				$strsql = "SELECT count(*) as 'num' FROM ".DBConfig::$table['record']." WHERE `uid` = '{$uid}' AND `aid` = {$aid} AND `time` >= {$startTime} AND `time` < {$endTime}";
			} else {
				$strsql = "SELECT count(*) as 'num' FROM ".DBConfig::$table['record']." WHERE `uid` = '{$uid}' AND `aid` = {$aid}";
			}
			$res = Factory::getDb("weixin_active")->getRow($strsql);
			return (int)$res['num'];
		} catch (Exception $e) {
			Logger::error("通过用户id和活动id获取用户参与了多少次活动失败".$e->getMessage());
			return false;
		}
	}
	
	/**
	 * 更新用户业务数据状态
	 */
	public function updateState($wid,$data) {
		try {
			$data['time'] = time();
			$where = "`wid` = '{$wid}'";
			Factory::getDb("weixin_active")->update(DBConfig::$table['record'],$where,$data);
			return Factory::getDb("weixin_active")->affectedRows();
		} catch (Exception $e) {
			Logger::error("更新用户业务数据状态失败".$e->getMessage());
			return false;
		}
	}
		
}