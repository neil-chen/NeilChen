<?php
/**
 * 微信api获取实例
 */
set_time_limit(0);
include_once SUISHI_PHP_PATH . '/API/WeiXinStruct.class.php';
class WeiXinApiCore
{
	public static function getClient($app_id, $app_secret, $token = NULL)
	{
		$client = null;
		include_once SUISHI_PHP_PATH . '/API/WeiXinApi.class.php';
		$client = new WeiXinApi($app_id, $app_secret, $token);
		return $client;
	}

	/**
     * 获取OAuth 授权方式api client
     * @param string $app_id
     * @param string $app_secret
     * @param int $version
     * @return WeiXinOAuthApi
     */
	public static function getOAuthClient($app_id, $app_secret, $version = 1)
	{
		include_once SUISHI_PHP_PATH . '/API/WeiXinOAuthApi.class.php';
		return new WeiXinOAuthApi($app_id, $app_secret);
	}
}