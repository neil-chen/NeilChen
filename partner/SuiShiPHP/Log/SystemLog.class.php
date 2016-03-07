<?php

/**
 * 记录系统log
 * @author gaoruihua
 * @since 2012-05-24
 */
class SystemLog {
	private $logpath = "/tmp/logs/sys";
	private $logname = "sys.log";
	private $logfile;
	private $handle;
	private $logData = array();
	private $enabled = false;
	private $logFormat = 1;
	private $startTime = 0;
	private $endTime = 0;

	//定义log 文本格式
	const FORMAT_TEXT = 1;
	const FORMAT_SERIALIZE = 2;
	const FORMAT_JSON = 3;


	/**
	 * 初始化log
	 * @param string $filepath  文件路径
	 */
	public function __construct ($filepath = '') {
		if (!empty($filepath)) {
			if (substr($filepath, -1, 1) == '/') {
				$this->logpath = substr($filepath, 0, (strlen($filepath) - 1));
			} else {
				$this->logpath = $filepath;
			}
		}
	}

	/**
	 * @param $logpath the $logpath to set
	 */
	public function setLogpath($logpath) {
		if (!empty($logpath)) {
			if (substr($logpath, -1, 1) == '/') {
				$this->logpath = substr($logpath, 0, (strlen($logpath) - 1));
			} else {
				$this->logpath = $logpath;
			}
		}
	}

	/**
	 * @param $logname the $logname to set
	 */
	public function setLogname($logname) {
		$this->logname = $logname;
	}

	/**
	 * 设置log 文本格式
	 * @param int $format
	 */
	public function setLogFormat ($format) {
		$this->logFormat = (int)$format;
	}

	/**
	 * 开启log
	 */
	public function start ($startTime = null) {
		$path = $this->logpath . "/" . date('Y/m-d');
       	if (!is_dir($path)) {
       		if(!mkdir($path, 0777, true)){
       			trigger_error('创建目录失败 : ' . $path, E_USER_WARNING);
       			return;
       		}
       	}
       	$this->logfile = $path . "/" . date("H-") . $this->logname;
       	$this->enabled = true;
        //$this->handle = $handle;
        $this->startTime = empty($startTime) ? microtime(true) : $startTime;
	}

	/**
	 * 写入log
	 * @param string $key
	 * @param string $value
	 */
	public function push ($key, $value) {
		if (!is_string($key)) {
			return;
		}
	    $this->logData[$key] = $value;
	}

	/**
	 * 记录log
	 */
	public function flush () {
		if (!$this->enabled) {
			return;
		}

		$message = $this->genLogMessage();

		$handle=fopen($this->logfile, "ab+"); //创建文件
		if (!$handle) {
			trigger_error('system log file open error : ' . $this->logfile, E_USER_WARNING);
			return;
		}
		$this->handle = $handle;
		//写日志
	    if(!@fwrite($this->handle, $message)){
	      trigger_error('system log file write error : ' . $this->logfile, E_USER_WARNING);
	    }
		$this->enabled = false;
		$this->startTime = 0;
		$this->endTime = 0;
	}


	public function genLogMessage () {
		$this->setBaseInfo();//基本信息
		$message = '';
		switch ($this->logFormat) {
			case self::FORMAT_SERIALIZE://序列化
				$message .= '[format:serialize][[' . serialize($this->logData);
				break;
			case self::FORMAT_JSON: //json
				$message .= '[format:json][[' . $this->_jsonEncode($this->logData);
				break;
			default ://文本
				$message .= '[format:text][[';
				foreach ($this->logData as $k => $v) {
					$message .= $k.'=>'.$v.";;";
				}
		}
		$message .= "]]\n";
		//TODO 兼容php 5.2
		$this->endTime = microtime(true);
		$runtime = sprintf("%.4f", ($this->endTime - $this->startTime) * 1000);
		$message = "[".date('Y-m-d H:i:s')."][runtime:{$runtime}]" . $message;
		return $message;
	}

	private function _jsonEncode ($data) {
		$data = $this->_urlencodeAry($data);
		$data = json_encode($data, JSON_HEX_APOS);
		return urldecode($data);
	}

	private function _urlencodeAry($data)
	{
		if(is_array($data)) {
			foreach($data as $key=>$val) {
				$data[$key] = call_user_func_array(array($this, '_urlencodeAry'), array($val));
			}
			return $data;
		} else if (is_string($data)) {
			return urlencode($data);
		} else {
			return $data;
		}
	}

	/**
	 * 设置基本信
	 * TODO (user) 此函数在生成日志数据前会先被调用
	 */
	public function setBaseInfo () {

	}

    public function __destruct(){
    	@fclose($this->handle);
    	if ($this->enabled) {
    		$this->flush();
    	}
    }
}
