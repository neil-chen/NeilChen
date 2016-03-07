<?php

!defined("AC") && exit("NO SYSTEM OPER");

/**
 * 通用加载类
 */

class Common {

	/**
	 * 自动加载类
	 */
	public static function loadClass($className) {
		$classMap = array(
			"Common" => AC_COM.'/Common.class.php',
			"DBConfig" => AC_CFG.'/DBConfig.class.php',
			"ActionCenter" => AC_SYS.'/ActionCenter.class.php',
			"ActionOper" => AC_SYS.'/ActionOper.class.php',
			"WorkOper" => AC_SYS.'/WorkOper.class.php',
			'OperOper' => AC_SYS.'/OperOper.class.php',
			'DataOper' => AC_SYS.'/DataOper.class.php',
			'SourceOper' => AC_SYS.'/SourceOper.class.php',
			"UserOper" => AC_SYS.'/UserOper.class.php',
			"RewardOper" => AC_SYS.'/RewardOper.class.php',
			"MailOper" => AC_SYS.'/MailOper.class.php',
			"InterfaceAction" => AC_API.'/InterfaceAction.class.php',
		);
		if(isset($classMap[$className])) include ($classMap[$className]);
		return class_exists($className,false) || interface_exists($className,false);
	}
}