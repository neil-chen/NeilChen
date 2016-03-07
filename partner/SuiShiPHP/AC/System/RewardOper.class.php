<?php
/**
 * 奖励操作模型层
 */
class RewardOper {
	
	private static $instance;
	
	/**
	 * @return RewardOper
	 */
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 通过活动id获取该活动的奖励配置信息
	 * @param int $aid 活动id
	 * @param int $type 奖励方案类型 默认为1(因为有的活动是根据不同的条件会有多套奖励方案)
	 * @return array 
	 */
	public function getRewardInfoByAid($aid) {
		try{
			$strsql = "SELECT * FROM ".DBConfig::$table['reward']." WHERE `aid` = '{$aid}' ORDER BY `rank` DESC";
			$res = Factory::getDb("weixin_active")->getAll($strsql);
			$rewardConfig = array();
			if($res && is_array($res)) {
				foreach($res as $k => $v) {
					$rewardConfig[$v['rid']] = $v; 
				}
			}
			return $rewardConfig;
		} catch (Exception $e) {
			Logger::error("通过活动id获取该活动的奖励配置信息失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 查询该活动奖励分布信息
	 * @param int $aid 活动id
	 * @param int $isToday 是否今天数据 (默认1为今天的数据,2-为全服数据)
	 * @return array
	 */
	public function getSpreadByAid($aid,$isToday=1) {
		try{
			if($isToday == 1) {
				$startTime = strtotime(date('Y-m-d'));
				$endTime = $startTime + 24*60*60;
				$strsql = "SELECT `rid`,COUNT(*) as 'num' FROM ".DBConfig::$table['ureward']." WHERE `aid` = {$aid} AND `time` >= {$startTime} AND `time` < {$endTime} GROUP BY `rid`";
			} else {
				$strsql = "SELECT `rid`,COUNT(*) as 'num' FROM ".DBConfig::$table['ureward']." WHERE `aid` = {$aid} GROUP BY `rid`";
			}
			$sqlData = Factory::getDb("weixin_active")->getAll($strsql);
			
			$res = array();
			if(($sqlData) && is_array($sqlData)) {
				foreach($sqlData as $k => $v) {
					$res[$v['rid']] = $v['num'];
				}
			}
			return $res;
		} catch (Exception $e) {
			Logger::error("查询该活动奖励分布信息失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 查询用户活动获奖信息
	 * @param int $isToday 是否今天数据 (默认1为今天的数据,2-为全服数据)
	 */
	public function getSpreadByUid($aid,$uid,$isToday=1) {
		try{
			if($isToday == 1) {
				$startTime = strtotime(date('Y-m-d'));
				$endTime = $startTime + 24*60*60;
				$strsql = "SELECT `rid`,COUNT(*) as 'num' FROM ".DBConfig::$table['ureward']." WHERE `aid` = {$aid} AND `uid` = '{$uid}' AND `time` >= {$startTime} AND `time` < {$endTime} GROUP BY `rid`";
			} else {
				$strsql = "SELECT `rid`,COUNT(*) as 'num' FROM ".DBConfig::$table['ureward']." WHERE `aid` = {$aid} AND `uid` = '{$uid}' GROUP BY `rid`";
			}
			$sqlData = Factory::getDb("weixin_active")->getAll($strsql);
			
			$res = array();
			if($sqlData && is_array($sqlData)) {
				foreach($sqlData as $k => $v) {
					$res[$v['rid']] = $v['num'];
				}
			}
			return $res;
		} catch (Exception $e) {
			Logger::error("查询用户活动获奖信息失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 插入用户获奖信息
	 * @param int $aid 活动id
	 * @param string $uid 用户id
	 * @param int $rid 奖项id
	 */
	public function insertRewardInfo($aid,$uid,$rid) {
		try{
			$strsql = "INSERT INTO ".DBConfig::$table['ureward']."(`aid`,`uid`,`rid`,`time`) VALUES ({$aid},'{$uid}',{$rid},".time().")";
			Factory::getDb("weixin_active")->query($strsql);
			return Factory::getDb("weixin_active")->insertId();
		} catch (Exception $e) {
			Logger::error("查询用户活动获奖信息失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 根据用户奖励记录id获取奖励数据
	 */
	public function getRewardInfoByID($id) {
		try{
			$strsql = "SELECT * FROM ".DBConfig::$table['ureward']." WHERE `id` = '{$id}' ";
			return Factory::getDb("weixin_active")->getRow($strsql);
		} catch (Exception $e) {
			Logger::error("根据用户奖励记录id获取奖励数据失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 更新用户最近的获奖记录状态
	 * @param int $id 记录id
	 * @param int $state 状态
	 */
	public function updateLastRewardInfo($id,$state) {
		try{
			$strsql = "UPDATE ".DBConfig::$table['ureward']." SET `state` = {$state} WHERE `id` = '{$id}'";
			Factory::getDb("weixin_active")->query($strsql);
			return Factory::getDb("weixin_active")->affectedRows();
		}catch (Exception $e) {
			Logger::error("更新用户最近的获奖记录状态".$e->getmessage());
			return false;
		}
	}

}