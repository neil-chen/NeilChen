<?php
/**
 * 远程缓存
 * 
 */

/* $c = new RemoteCacher("127.0.0.1", 9921);
 $a = $c->set('1234', array(1,2), 3600);
$b1 = $c->get('1234');
$b2 = $c->clear('1234');
$b3 = $c->get('1234');
var_dump($b1,$b2,$b3); */


class RemoteCacher
{
	protected $host = 'localhost';
	protected $port = 80;
	protected $module = 'weixin';
	
	public $httpCode;
	public $httpInfo;
	
	public function __construct($host, $port = 80, $module = '') {
		$this->host = $host;
		$this->port = $port;
		if (!empty($module)) {
			$this->module = $module;
		}
	}
	
	
	public function get ($id) {
		$rs = $this->_exec('get', $id);
		$rs = trim($rs);
		if ($this->httpCode != 200 || empty($rs)) {
			return false;
		}
		return unserialize($rs);
	}
	
	
	public function set ($id, $value, $left = 3600) {
		$rs = $this->_exec('set', $id, $value, $left);
		$rs = trim($rs);
		if ($this->httpCode != 200) {
			return false;
		}
		return true;
	}
	
	
	public function clear ($id) {
		$rs = $this->_exec('clear', $id);
		$rs = trim($rs);
		if ($this->httpCode != 200 ) {
			return false;
		}
		return true;
	}
	
	protected function _exec ($do, $id, $value = '', $left = '') {
		$param = array('key'=>$id, 'value'=>serialize($value),
				'left'=>$left, 'do'=>$do, 'app'=>$this->module);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->host);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_PORT, $this->port);
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
		//获取的信息以文件流的形式返回,不直接输出
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$contents = curl_exec($curl);
		$this->httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$this->httpInfo = curl_getinfo($curl);
		curl_close($curl);
		return $contents;
	}
	
}
