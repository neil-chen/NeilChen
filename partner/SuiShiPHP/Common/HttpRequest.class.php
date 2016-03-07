<?php
/**
 * 处理http参数类
 */

class HttpRequest
{
	private static $DATA = array();
	private static $METHOD;

	/**
     * 获取参数值
     * @param string $name http参数key
     * @param bool $htmQuotes 是否转义html
     * @param string $tags 允许保留到标签,all 为去全部
     * @return string | array
     */
	public static function get ($name = null, $default =null, $htmQuotes = true, $tags = null) {
        if (!$name) return self::$DATA;
        if (!isset(self::$DATA[$name])) {
        	return $default;
        }
        $str = self::$DATA[$name];
        if ($htmQuotes) {
        	$str = fhtmlspecialchars($str);
        }
        if ($tags !== 'all') {
        	$str = fstripTags($str, $tags);
        }
        return $str;
    }


	/**
	 * 请求方式
	 */
	public static function method() {
		return self::$METHOD;
	}

	/**
	 * 获取当前请求到url
	 * @return string
	 */
	public static function getUri () {
		//TODO
		if (isset($_SERVER['HTTP_HOST'])) {
			$uri = dirname($_SERVER['SCRIPT_NAME']);
			if ('/' == $uri || '\\' == $uri) {
				return 'http://' . $_SERVER['HTTP_HOST'] ;
			}
			return 'http://' . $_SERVER['HTTP_HOST'] . $uri ;
		}
		return '';
	}


	/**
	 * 初始化http参数数据
	 */
	public static function init () {
		if (!get_magic_quotes_gpc()) {
			$_POST  = faddslashes($_POST);
            $_GET = faddslashes($_GET);
            $_COOKIE = faddslashes($_COOKIE);
            $_FILES = faddslashes($_FILES);
            $_REQUEST = faddslashes($_REQUEST);
		}
		self::$DATA = array_merge($_GET, $_POST);
		self::$METHOD = @$_SERVER['REQUEST_METHOD'];
	}
}
