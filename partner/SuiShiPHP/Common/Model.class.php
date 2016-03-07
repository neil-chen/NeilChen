<?php
/**
 * model 父类
 */

class Model extends Base
{
	protected $error = '';
	protected $errorCode = 0;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 返回模型的错误信息
	 * @access public
	 * @return string
	 */
	public function getError(){
		return $this->error;
	}

	/**
	 * 返回模型的错误code
	 * @access public
	 * @return int
	 */
	public function getErrorCode(){
		return $this->errorCode;
	}
	/**
	 * 获取db实例
	 * @param string $dbname 配置中数据库名称
	 * @param string $dbClassName db
	 */
	public function getDb ($dbname = null, $dbClassName = 'MySql') {
		return Factory::getDb($dbname, $dbClassName);
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
		return Factory::getDbByHost($host, $user, $pass , $dbname);
	}

	/**
	 * 设置错误信息
	 * @param int $code
	 * @param string $msg
	 */
	protected function setError($code, $msg)
	{
		$this->errorCode = $code;
		$this->error = $msg;
	}
}

