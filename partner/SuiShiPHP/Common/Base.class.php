<?php
/**
 * action 和 model 的共用父类
 */

class Base 
{
	protected $_tmpFiles = array();
	
	public function __construct() {}
	
	/**
	 * 获取http parameter
	 *
	 * @param string $name http参数key
	 * @param bool $htmQuotes 是否转义html
	 * @param string $tags 允许保留到标签,all 为去全部
	 * @return string | array
	 */
	public function getParam ($name = null, $default = null, $htmQuotes = true, $tags = null)
	{
		return HttpRequest :: get($name, $default, $htmQuotes, $tags);
	}
	
	/**
	 * 生成唯一id,
	 * id格式为当前时间加上5位随机数：YYYYMMDDhhmmssrr，r为随机数
	 * @param string $prefix 前缀
	 * @return string
	 */
	public function uniqid ($prefix = '') {
		$id = date("ymdHis");
		for ($i = 0; $i < 3; $i++) {
			$id .= rand(0, 9);
		}
		return $prefix.$id;
	}
	
	//记录临时文件
	public function pushTmpFile ($file) {
		if (!$file || !is_string($file)) return;
		array_push($this->_tmpFiles, $file);
	}
	
	public function __destruct() {
		foreach ($this->_tmpFiles as $file) {
			if (is_file($file)) {
				@unlink($file);
			}
		}
	}
}