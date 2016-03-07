<?php

!defined("AC") && exit("NO SYSTEM OPER");

/**
 * 活动中心类
 * @author Andy Zheng
 */
class ActionCenter {

	/**
	 * 开始运行
	 */
	public static function run($actionId) {
		if(is_string($actionId)) {
			$actionInfo = ActionOper::getInstance()->getInfoByActionKey($actionId);					//通过关键字获取活动信息
		} else {
			$actionInfo = ActionOper::getInstance()->getInfoByActionID($actionId);					//获取活动信息
		}
		$actionInfo['reward'] = RewardOper::getInstance()->getRewardInfoByAid($actionInfo['id']);	//活动配置奖励信息
		if(($actionInfo['start'] < time()) && (time() < $actionInfo['end'])) {
			if(is_array($actionInfo) && $actionInfo) {												//判断活动是否配置
				return new InterfaceAction($actionInfo);
			} else {
				return array('falg'=>0,'desc'=>'活动不存在');
			}
		} else {
			 return array('flag'=>0,'desc'=>'活动没开放');
		}
	}
}