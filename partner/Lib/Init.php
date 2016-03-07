<?php

set_time_limit(0);
define("LIB_PATH", dirname(__FILE__));
define("APP_NAME", '5100Partner');
error_reporting(E_ALL);
ini_set("display_errors", true);
date_default_timezone_set('PRC');

include_once LIB_PATH . '/../SuiShiPHP/SuiShiPHP.class.php';
include_once LIB_PATH . '/../SuiShiPHP/Log/SystemLog.class.php';
include_once LIB_PATH . '/../SuiShiPHP/Cache/RedisCache.class.php';
include_once LIB_PATH . '/Common/String.class.php';
include_once LIB_PATH . '/Config/Config.php';
//include_once LIB_PATH . '/Config/Define.Config.php';
include_once LIB_PATH . '/Common/Function.php';
include_once LIB_PATH . '/Common/Page.class.php';
include_once LIB_PATH . '/Common/Image.class.php';
include_once LIB_PATH . '/Common/HzcApiSDK.class.php';
include_once LIB_PATH . '/Common/Page2.class.php';
include_once LIB_PATH . '/Common/WeiPayPacketNew.class.php';

include_once LIB_PATH . '/Common/FlCommon.php';
include_once LIB_PATH . '/Common/AdminAction.class.php';
include_once LIB_PATH . '/Common/WebAction.class.php';


// 设置使用 REDIS 存储 SESSION (不要写 127.0.0.1)
if (true) {
    $redisHost = Config::get('REDIS_HOST');
    $redisPort = Config::get('REDIS_PORT');

    if (!$redisHost || !$redisPort) {
        die('未配置 REDIS 服务器！');
    }

    ini_set('session.gc_maxlifetime', 3600);    // session 有效期（秒）
    ini_set("session.save_handler","redis");
    ini_set("session.save_path","tcp://{$redisHost}:{$redisPort}");
}

session_start();

SuiShiPHP::init(Config::$_CONFIGS);

Factory::getSystemLog()->start();
Factory::getSystemLog()->push("http param", HttpRequest::get());