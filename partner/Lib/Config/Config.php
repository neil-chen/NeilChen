<?php

define("VERSION", "v1.0");

class Config {

    //微信APP ID
    const APP_USER = 'weixin_app_user';
    const APP_ID = 'weixin_app_id';
    const APP_SECRET = 'weixin_app_secret';
    //API KEY
    const ENT_ID = 0;
    const API_KEY = 'api_key';
    const API_SECRET = 'api_secret';
    const API_URL = 'api.xxx.com/index.php';
    const TOKEN = 'weixin_api_token'; //微信API Token
    const PAGE_LISTROWS = 10;
    const VAR_PAGE = 1;

    public static $_CONFIGS = array(
        'APP_ID' => 'weixin_app_id',
        'APP_SECRET' => 'weinxin_app_secret',
        'ENT_ID' => '0',
        'API_KEY' => 'api_key',
        'API_SECRET' => 'api_secret',
        'TOKEN' => 'weinxin_api_token',
        'PAGE_LISTROWS' => '10',
        'VAR_PAGE' => '1',
        'API_URL' => 'api.xxx.com/index.php',
        'PUBLIC_SERVICE' => true, // 是否为正式服务，否：cache不会启用redis
        'DEBUGGING' => true, // debug 模式
        'ENABLE_RUN_LOG' => TRUE, // 是否开启运行日志
        'ENABLE_SQL_LOG' => TRUE, // 是否开启sql日志
        'ENABLE_SYSTEM_LOG' => FALSE, // 是否开启system日志
        'RUN_SHELL' => false, // 运行方式是否为脚本方式
        'RUN_LOG_LEVEL' => LOG_E_ALL, // 运行日志级别
        'LOG_PATH' => '/home/projects/logs/weixinapp/', // 日志目录，以“/”结束
        'API_LOG_DIR' => '/home/projects/logs/weixinapp/apiLog/', // 对接接口日志记录
        'PHP_CLI_PATH' => '/usr/bin/php', // php脚本命令
        // DB CONFIG
        'DB_HOST' => 'localhost',
        'DB_USER' => 'root',
        'DB_PASSWORD' => '',
        'DB_NAME' => 'weixinapp_partner',
        'DEFAULT_ACTION' => 'Index', // 默认ACTION
        'DEFAULT_METHOD' => 'index', // 默认METHOD
        'APP_GROUP' => '', // App GROUP
        'VAR_AJAX_SUBMIT' => 'ajax', // ajax请求标识
        'ON_INIT_AFTER' => NULL, // SuiShiPHP 初始化后调用callback
        'DEFAULT_CACHER' => 'redis', // 默认cache方式,redis|file|remote
        // redis配置
        'REDIS_HOST' => '127.0.0.1',
        'REDIS_PORT' => '6379',
        'CACHE_PROFIX' => 'wx_partner',
        // 微信OAuth2.0授权接口地址
        'WX_AUTH_PATH' => "http://call.xxx.com/Wxapp/weixin_common/oauth2.0/link.php?entid=ENT_ID&url=REDIRET_URI",
        // 微信授权后回调地址
        'REDIRET_URI' => "",
        //微信支付
        'WX_PARTHERID' => '1234567890', //商户号
        'WX_PARTNERKEY' => '1234556789999999', //商户号
        //活动配置
        'ACTIVITY_CONFIGS' => array(
            //合伙人活动配置
            'partners' => array(
                //合伙人卡券ID								
                "cards_arr" => array('xxxxxxxxx_card_id_1', 'xxxxxx_card_id_2'),
                //合伙人卡券抽奖配置
                "prizes_arr" => array(
                    array('prize_id' => 0, 'card_id' => 'xxxxxx_card_id_30', 'card_name' => '30元代金券', 'value' => '30', 'rate' => 100)
                ),
                'card_info_type' => array(
                    '1' => '折扣券',
                    '2' => '代金券',
                    '3' => '兑换券'
                ),
                'card_info_status' => array(
                    '1' => '是',
                    '2' => '否'
                ),
                //合伙人奖励 对应 wx_partner_award id
                'partner_award' => array(
                    1 => '呼朋唤友奖励',
                    2 => '卡券核销奖励',
                ),
            ),
        )
    );

    /**
     * 获取配置数据
     */
    public static function get($name) {
        if (!$name) {
            return self::$_CONFIGS;
        }
        return @self::$_CONFIGS [$name];
    }

}
