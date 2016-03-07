<?php
/**
 * api日志文件
 * @author paizhang
 *
 */

if (!defined('LOG_E_ALL')) {
	define('LOG_E_ALL', 10000);
	define('LOG_E_ERROR', 1);
	define('LOG_E_WARNING', 10);
	define('LOG_E_INFO', 20);
	define('LOG_E_DEBUG', 30);
}

class LoggerBase {
	private static $LOG_FILE; // error log 文件完整路径，有ini中赋值
	private static $LOG_FILE_NAME = 'error.log'; // 默认log 文件名称

	private static $BASE_DIRECTORY;
	private static $LOG_ENABLED = FALSE; // 是否开启log
	private static $LOG_LEVEL = LOG_E_ALL; // 日志级别 defined Common/Define.php

	private static $writeEnable = false;

	private static $INIT = 0;

	public function __construct() {
		// empty function
	}

	/* 错误 */
	public static function error($message, $var = null) {
		$title = '[error][' . date ( 'Y-m-d H:i:s' ) . '] ';
		self::log ( LOG_E_ERROR, $title . $message, $var );
	}

	// 警告
	public static function warning($message, $var = null) {
		$title = '[warning][' . date ( 'Y-m-d H:i:s' ) . '] ';
		self::log ( LOG_E_WARNING, $title . $message, $var );
	}

	// 内容
	public static function info($message, $var = null) {
		$title = '[info][' . date ( 'Y-m-d H:i:s' ) . '] ';
		self::log ( LOG_E_INFO, $title . $message, $var );
	}

	// debug
	public static function debug($message, $var = null) {
		$title = '[debug][' . date ( 'Y-m-d H:i:s' ) . '] ';
		self::log ( LOG_E_DEBUG, $title . $message, $var );
	}

	/**
	 * 是否开启日志
	 * @param bool $enabled
	 */
	public static function enabled ($enabled) {
		self::$LOG_ENABLED = (bool)$enabled;
	}

	/**
	 * 设置log 级别
	 * @param int $level 参考文件头部常量
	 */
	public static function setLogLevel ($level) {
		switch ($level) {
			case LOG_E_ALL:
			case LOG_E_ERROR:
			case LOG_E_WARNING:
			case LOG_E_INFO:
			case LOG_E_DEBUG:
				self::$LOG_LEVEL = $level;
				break;
		}
	}

	/**
	 * 设置log 目录
	 *
	 * @param string $path
	 * @return bool
	 */
	public static function setLogDir($path) {
		self::$BASE_DIRECTORY = $path;
		if (self::$INIT) {
			self::$INIT = 2; // 重新初始化
			return self::init ();
		}
		return true;
	}

	/**
	 * 设置日志文件名称
	 *
	 * @param string $name
	 * @return boolean
	 */
	public static function setLogFileName($name) {
		if (empty ( $name ))
			return false;
		self::$LOG_FILE_NAME = $name;
		if (self::$INIT) {
			self::$LOG_FILE = self::$BASE_DIRECTORY . date("Y") . '/'
							.date("m-d") . '_' . self::$LOG_FILE_NAME;
		}
		return true;
	}

	/**
	 * 记录日志接口
	 *
	 * @param int $level 日志级别
	 * @param string $message 日志信息
	 * @param mixed $var 日志数据
	 */
	public static function log($level, $message, $var = null) {
		if (! self::$writeEnable || self::$LOG_LEVEL < $level)
			return;
		$message = $message . (isset ( $var ) ? ("\r\n<<var data>> : "
				. var_export ( $var, true )) : '');
		self::write ( $message );
	}

	/**
	 * 写日志
	 *
	 * @param string $message 要输出的信息
	 * @param string[optional] $destination 要输出的文件
	 */
	private static function write($message, $destination = null) {
		$destination or $destination = self::$LOG_FILE;

		$f = @fopen ( $destination, 'a+' );
		if (! $f) {
			trigger_error ( "打开日志文件失败： " . $destination, E_USER_WARNING);
			return false;
		}
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$message = str_replace("\n", "\r\n", $message);
		}
		fwrite ( $f, $message . "EOF;\r\n" );
		fclose ( $f );
		return true;
	}

	/**
	 * 初始化logger 目录.
	 */
	static function init() {
		self::$INIT = 1;
		// 如果没有开启log return
		if (! self::$LOG_ENABLED)
			return;

		$dir = self::$BASE_DIRECTORY . date("Y") . '/';
		if (is_dir ( $dir)) {
			if (! is_writable ( $dir )) {
				trigger_error ( "日志目录不可写： " . self::$BASE_DIRECTORY, E_USER_WARNING);
				return false;
			} else {
				self::$writeEnable = true;
				self::$LOG_FILE = $dir. date("m-d") . '_' .self::$LOG_FILE_NAME;
			}
			return true;
		} else {
			if (! @mkdir ( $dir, 0777, true )) {
				trigger_error ( "创建日志目录失败： " . self::$BASE_DIRECTORY, E_USER_WARNING);
				return false;
			}
		}

		self::$writeEnable = true;
		self::$LOG_FILE = $dir . date("m-d") . '_' . self::$LOG_FILE_NAME;
		return true;
	}
}
?>
