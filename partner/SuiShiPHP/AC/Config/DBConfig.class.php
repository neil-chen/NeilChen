<?php

!defined("AC") && exit("NO SYSTEM OPER");

/**
 * 数据配置
 */
class DBConfig {
	
	public static $table = array(
		"config" => "ac_config",			//活动中心配置表
		"record" => "ac_record",			//活动中心操作记录表  
		"oper" => "ac_oper",				//用户操作表
		"data" => "ac_data",				//用户业务数据保存表
		"source" => "ac_source",			//来源记录表
		"usource" => "ac_usource",			//用户来源记录表
		"user" => "ac_user",				//活动用户表
		"reward" => "ac_reward",			//奖励配置表
		"ureward" => "ac_ureward",			//用户奖励信息表
		"mail" => "ac_mail"					//用户邮寄信息表
	);

}