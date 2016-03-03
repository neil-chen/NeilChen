<?php
set_time_limit(0);
define("LIB_PATH", dirname(__FILE__));
define("APP_NAME", 'HuiShi');
error_reporting(E_ALL);
ini_set("display_errors", true);
date_default_timezone_set('PRC');

include_once LIB_PATH . '/../../SuiShiPHP/SuiShiPHP.class.php';
include_once LIB_PATH . '/../../SuiShiPHP/Log/SystemLog.class.php';
include_once LIB_PATH . '/../../SuiShiPHP/Cache/RedisCache.class.php';
include_once LIB_PATH . '/Common/String.class.php';
include_once LIB_PATH . '/Config/Config.php';
//include_once LIB_PATH . '/Config/Define.Config.php';
include_once LIB_PATH . '/Common/Function.php';
include_once LIB_PATH . '/Common/Page.class.php';
include_once LIB_PATH . '/Common/Image.class.php';

SuiShiPHP::init(Config::$_CONFIGS);

Factory::getSystemLog()->start();
Factory::getSystemLog()->push("http param", HttpRequest::get());