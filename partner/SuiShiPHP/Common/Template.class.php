<?php
/**
 *  模板文件
 *  @author paizhang
 *  2012-6-23
 */

class Template
{
	private static $TPL_DATA = array();
	private static $TEMPLATE_PATH;
	
	//set template data
	public static function assign($tplVar, $value = null) {
		self::$TPL_DATA[$tplVar] = $value;
	}
	
	/**
	 * 显示模板
	 * @param string $tplName
	 */
	public static function display ($tplName = null) {
		extract(self::$TPL_DATA);
		include_once (self::genTplFile($tplName));
	} 
	
	/**
	 * 包含模板
	 * @param string  $tplName
	 */
	public static function include_tpl ($tplName) {
		extract(self::$TPL_DATA);
		include_once (self::genTplFile($tplName));
	}
	
	//初始化模板数据
	public static function init() {
		self::$TEMPLATE_PATH = realpath(LIB_PATH . SuiShiPHPConfig::TEMPLATE_DIR . SuiShiPHPConfig::get('APP_GROUP')) . '/';
	}
	
	/**
	 * 生成模板文件路径
	 * @param string $tplName
	 * @return string
	 */
	private static function genTplFile($tplName = null) {
		if (!$tplName) {
			return self::$TEMPLATE_PATH . str_replace('.', '/', __ACTION_NAME__)
					. '/' . __ACTION_METHOD__  . SuiShiPHPConfig::TEMPLATE_PREFIX;
		} else {
			if (!strpos($tplName, ':')) {
				return self::$TEMPLATE_PATH . str_replace('.', '/', $tplName) . SuiShiPHPConfig::TEMPLATE_PREFIX;
			}
			return LIB_PATH . SuiShiPHPConfig::TEMPLATE_DIR . str_replace(array(':', '.'), '/', $tplName)
					. SuiShiPHPConfig::TEMPLATE_PREFIX;
		} 
		
	}
}