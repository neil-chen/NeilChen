<?php
/**
 * factory 父类
 */

class Factory
{
	protected static $SYS_LOG = NULL;

	protected static $DBS = array();

	protected static $CACHER = array();

	/**
	 * 获取db
	 *@return MySql
	 */
	public static function getDb($dbname = NULL, $dbClassName = 'MySql')
	{
		if (null == $dbname) {
			$dbId = $dbClassName.':default';
			$config = SuiShiPHPConfig::genDbConfig(C('DB_HOST'), C('DB_USER'), C('DB_PASSWORD'), C('DB_NAME'));
		} else {
			$dbId = $dbClassName.':'.$dbname;
			$config = SuiShiPHPConfig::getDbConfig($dbname);
		}
		
		if (!$config) {
			return null;
		}
		if (!isset(self::$DBS[$dbId])) {
			$db = new $dbClassName($config['DB_HOST'], $config['DB_USER'], $config['DB_PWD'], $config['DB_NAME']);
			self::$DBS[$dbId] = $db;
		}
		return self::$DBS[$dbId];
	}


	/**
	 * 根据host 和 dbname 获取数据
	 * @param string $host host:port
	 * @param string $user db user
	 * @param string $pass db password
	 * @param string $dbname
	 * @return Mysql
	 */
	public static function getDbByHost ($host = '', $user = '', $pass = '', $dbname = '', $dbClassName = 'MySql') {
		$key = $host.'_'.$dbname;
		if (!isset(self::$DBS[$key]) || !self::$DBS[$key]) {
			$config = SuiShiPHPConfig::genDbConfig($host, $user, $pass , $dbname);
			if (!$config) {
				return null;
			}
			$db = new $dbClassName($config['DB_HOST'], $config['DB_USER'], $config['DB_PWD'], $config['DB_NAME']);
			self::$DBS[$key] = $db;
		}
		return self::$DBS[$key];
	}


	/**
	 * 获取缓存类
	 * @param string $type
	 * @return FileCache | RedisCache
	 */
	public static function getCacher ($type = '', $model = '') {
		$type or $type = C('DEFAULT_CACHER');
		if (!in_array($type, array('redis', 'file', 'remote'))) {
			$type = 'redis';
		}
		//如果不是正式服务上，不是用redis缓存
		if (false == SuiShiPHPConfig::get('PUBLIC_SERVICE') && 'redis' == $type) {
			$type = 'file';
		}
		$cacheId = $type.$model;
		if (isset(self::$CACHER[$cacheId])) {
			return self::$CACHER[$cacheId];
		}

		switch ($type) {
			case 'file':
				if (!class_exists("FileCache")) {
					include_once SUISHI_PHP_PATH . '/Cache/FileCache.class.php';
				}
				$c = new FileCache(C('RUN_SHELL'));
				$c->setModel($model);
				$c->setPath(SuiShiPHPConfig::getFileCacheDir());
				self::$CACHER[$cacheId] = $c;
				break;
			case 'remote':
				if (!class_exists("FileCache")) {
					include_once SUISHI_PHP_PATH . '/Cache/RemoteCacher.class.php';
				}
				$c = new RemoteCacher(C('REMOTE_CACHE_HOST'), C('REMOTE_CACHE_PORT'), 'weixinapp');
				self::$CACHER[$cacheId] = $c;
				break;
			default:
				if (!class_exists("RedisCache")) {
					include_once SUISHI_PHP_PATH . '/Cache/RedisCache.class.php';
				}
				$c = new RedisCache(SuiShiPHPConfig::get('REDIS_HOST'), SuiShiPHPConfig::get('REDIS_PORT'));
				self::$CACHER[$cacheId] = $c;
				break;
		}
		return self::$CACHER[$cacheId];
	}
	/**
	 * 获取全局信息
	 * @param bool $runShell
	 * @return FileCache | RedisCache
	 */
	public static function getGlobalCacher () {
		return self::getCacher(null, 'global');
	}
	
	/**
	 * 获取系统日志实例
	 * @return SystemLog
	 */
	public static function getSystemLog () {
		if (!self::$SYS_LOG){
			include_once SUISHI_PHP_PATH . '/Log/SystemLog.class.php';
			$obj = new SystemLog();
			$obj->setLogFormat(SystemLog::FORMAT_JSON);
			$obj->setLogpath(SuiShiPHPConfig::getSysLogDir());
			self::$SYS_LOG = $obj;
		}
		return self::$SYS_LOG;
	}
}