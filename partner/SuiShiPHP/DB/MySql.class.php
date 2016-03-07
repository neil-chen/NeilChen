<?php
/**
 * mysql db class
 * @author paizhang
 *  date 2013-01-04
 */
include_once SUISHI_PHP_PATH . '/DB/DB.class.php';

class MySql extends DB
{
	private $logDir;
	private $logFile = '%s%s_sql.log';//1.logDir,2.date dir
	private $logStatus = false;
	private $logSql = false;

	public function __construct($host, $user, $password, $dbname , $connect = false,
			$charset = 'utf8') {
		parent::__construct($host, $user, $password, $dbname , $connect = false,
			$charset = 'utf8');

		$this->logDir = SuiShiPHPConfig::getSqlLogDir();
		$this->logSql = SuiShiPHPConfig::get('ENABLE_SQL_LOG');
		//初始化log file
		$this->iniLogConfig();
	}

	/**
	 * 初始化log参数
	 */
	protected function iniLogConfig () {
		$this->logFile = sprintf($this->logFile, $this->logDir, date('Y/m-d'));
		$dir = dirname($this->logFile);
		if (!file_exists($this->logFile) && !is_dir($dir)) {
			$success = mkdir($dir, 0777, true);
			if (!$success) {
				trigger_error("create sql_log_dir error: " . $dir, E_USER_WARNING);
				return;
			}
			$this->logStatus = true;
		}
		$this->logStatus = true;
	}


	//日志
	public function logger ($str, $type = 'sql') {
		if ($this->logStatus == false || ($this->logSql == false && $type != 'error')) {
			return;
		}
		$f = @fopen($this->logFile, 'a+');
		if (!$f) {
			trigger_error("create sql_log_file error: " . $this->logFile, E_USER_WARNING);
			return;
		}

		$str = "[".date('Y-m-d H:i:s')."][".$this->host."][".$this->dbname."][" .$type.  "][runtime:".$this->lastQueryTime."] "  .$str. "\n";
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$str = str_replace("\n", "\r\n", $str);
		}
		fwrite($f, $str);
		fclose($f);
	}

}