<?php
/**
 * 微信 web logger 类
 *
 */
include_once SUISHI_PHP_PATH . '/Log/LogBase.class.php';
class Logger extends LoggerBase
{
	public static function init () {
		self::setLogDir(SuiShiPHPConfig::getLogDir());
		self::enabled(SuiShiPHPConfig::get('ENABLE_RUN_LOG'));
		self::setLogLevel(SuiShiPHPConfig::get('RUN_LOG_LEVEL'));
		parent::init();
	}
}
