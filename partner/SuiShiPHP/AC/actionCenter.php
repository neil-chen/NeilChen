<?php
/**
 * 活动中心加载文件
 */

defined("AC") || define("AC", dirname(__FILE__));					//定义系统绝对路径

defined("AC_CFG") || define("AC_CFG", AC.DIRECTORY_SEPARATOR."Config");

defined("AC_SYS") || define("AC_SYS", AC.DIRECTORY_SEPARATOR."System");

defined("AC_COM") || define("AC_COM", AC.DIRECTORY_SEPARATOR."Common");

defined("AC_API") || define("AC_API", AC.DIRECTORY_SEPARATOR."Api");
 
include AC_COM.'/Common.class.php';									

spl_autoload_register(array('Common','loadClass'));					//自动加载类

class AC extends ActionCenter {}
