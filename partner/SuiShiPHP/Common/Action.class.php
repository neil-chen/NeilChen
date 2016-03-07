<?php
/**
 * action父类
 */

class Action extends Base {
	private $errno = 0; //错误序号

	public function __construct(){
		parent :: __construct();
	}

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
	 * 是否出错
	 *
	 * @author sux
	 */
	function isError()
	{
		return 0 !== $this -> errno;
	}

	/**
	 * 设置错误码
	 *
	 * @author sux
	 */
	function setErrno($errno)
	{
		$this -> errno = $errno;
	}

	/**
	 *
	 * @author sux
	 */
	function getErrno()
	{
		return $this -> errno;
	}


	function assign($tpl_var, $value = null)
	{
		Template::assign($tpl_var, $value);
	}


	function display($tpl_name = null)
	{
		Template::display($tpl_name);
	}

    /**
     +----------------------------------------------------------
     * Action跳转(URL重定向） 支持指定模块和延时跳转
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $url 跳转的URL表达式
     * @param integer $delay 延时跳转的时间 单位为秒
     * @param string $msg 跳转提示信息
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function redirect($url,$delay=0,$msg='') {
        redirect($url,$delay,$msg);
    }

     /**
     +----------------------------------------------------------
     * 是否AJAX请求
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @return bool
     +----------------------------------------------------------
     */
    protected function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                return true;
            }
        }
        $ajax = trim($this->getParam(SuiShiPHPConfig::get('VAR_AJAX_SUBMIT')));
        if($ajax) {
            // 判断Ajax方式提交
            return true;
        }
        return false;
    }

}
