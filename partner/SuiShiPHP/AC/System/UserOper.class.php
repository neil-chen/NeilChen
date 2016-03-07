<?php
/**
 * 活动用户表操作
 */
class UserOper {
	
	private static $instance;
	
	public static function getInstance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * 绑定用户(即添加一条信息到数据库中)
	 * @param string $uid 用户id
	 * @param int $aid 活动id
	 * @return int 1-绑定成功
	 */
	public function binding($uid,$aid) {
		try {
			$state = $this->getBindingInfo($uid, $aid);
			if(($state == 0) || ($state == 2)){								//没有绑定或者解绑用户绑定
				try {
					$strsql = "INSERT INTO `".DBConfig::$table['user']."`(`uid`,`aid`,`state`,`time`) VALUES ('{$uid}',{$aid},1,".time().") ON DUPLICATE KEY UPDATE `state`= 1,`time`=".time();
					Factory::getDb("weixin_active")->query($strsql);
					return Factory::getDb("weixin_active")->affectedRows();
				} catch (Exception $e) {
					Logger::error("绑定用户失败".$e->getMessage());
					return false;
				}
			}
			return $state;
		} catch (Exception $e) {
			Logger::error("绑定用户失败".$e->getmessage());
			return false;
		}
	}
	
	/**
	 * 解绑用户(即更新某个字段)
	 * @param string $uid 用户id
	 * @param int $aid 活动id
	 */
	public function unbundling($uid,$aid) {
		try{
			$state = $this->getBindingInfo($uid, $aid);
			if($state == 0) {
				return array('flag'=>0,'desc'=>'用户不是绑定用户');
			} else if($state == 2) {
				return array('flag'=>0,'desc'=>'用户已经是解绑用户');
			}elseif($state == 1) {
				$strsql = "UPDATE ".DBConfig::$table['user']." SET `state` = 2 WHERE `uid` = '{$uid}' AND `aid` = {$aid}";
				Factory::getDb("weixin_active")->query($strsql);
				if(Factory::getDb("weixin_active")->affectedRows()) {
					return array('flag'=>1,'desc'=>'解绑成功');
				}
			} else {
				return array('flag'=>0,'desc'=>'系统错误');
			}
		} catch (Exception $e) {
			Logger::error("解绑用户失败".$e->getmessage());
			return false;
		}
		
	}
	
	/**
	 * 获取用户绑定信息
	 * @param string $uid 用户id
	 * @param int $aid 活动id
	 * @return int state 0-没有参与绑定 1-绑定用户 2-解绑用户
	 */
	public function getBindingInfo($uid,$aid) {
		try{
			$strsql = "SELECT * FROM ".DBConfig::$table['user']." WHERE `uid` = '{$uid}' AND `aid` = {$aid} LIMIT 1";
			$res = Factory::getDb("weixin_active")->getRow($strsql);
			return ($res['state']) ? $res['state'] : 0;
		} catch (Exception $e) {
			Logger::error("获取用户绑定信息失败".$e->getMessage());
			return false;
		}
	}
}