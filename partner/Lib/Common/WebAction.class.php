<?php

/**
 * 微信开发 - 前端功能类
 *
 * @author     熊飞龙
 * @date       2015-10-13
 * @copyright  Copyright (c)  2015
 * @version    $Id$
 */
class WebAction extends Action {

   // 是否为 Debug 模式 （为 true 时 默认指定 openid 不跳转授权）
    private $_debug = false;

    // 微信 OpenId
    protected $_openId = 'default_open_id';

    // 使用 COOKIE 的名称 (不需要修改 - 初始化时根据项目路径生成 COOKIE 前缀)
    private $_cookieName = '_WX_OPEN_ID';
    // 不检测是否合伙的人白名单
    private $_noPartnerAuth = array(
        'User' => array('index', 'addPartner', 'sendMsg', 'checkCode', 'updateImg'),
        'Invitation' => array('share'),
        'Obtaincard' => array('receiveCard', 'getCard', 'successCard', '_Signature'),
    );

    /**
     * 初始化
     */
    public function __construct() {
        parent::__construct();

        // 初始化 COOKIE NAME
        $this->_cookieName = md5(LIB_PATH) . $this->_cookieName;

        if ($this->_debug === false) {
            $this->_openId = '';

            // 授权
            $this->_oauth();
        }

        // 传递 openId 到 模板
        $this->assign('openId', $this->_openId);

        // 检查用户是否合伙人
        $this->_auth();

        $this->_jsSdk();
    }

    /**
     * 权限认证
     */
    private function _auth() {
        $action = $this->getParam('a');
        $method = $this->getParam('m');

        // 如果是 AJAX 不做处理
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }

        // 过滤白名单
        if (in_array($action, array_keys($this->_noPartnerAuth))) {

            if (in_array($method, $this->_noPartnerAuth[$action])) {
                return true;
            }
        }

        //检查用户是否合伙人，如果不是则重定向到 合伙人申请页
        $partner = loadModel('Index.User')->getPartner($this->_openId);
        //申请通过，申请未通过的 不执行跳转
        if ($partner['state'] != 1 && $partner['state'] != 2) {
            $url = url('User', 'index', null, 'index.php');
            header("location:$url");
            exit();
        }
    }

    /**
     * 授权签名
     */
    private function _oauthSign($time = 0) {
        $time = !empty($time) ? intval($time) : time();

        return array(
            'time' => $time,
            'sign' => md5(sha1($time - 100)),
            'oauthFlag' => 1,
        );
    }

    /**
     * 微信授权 - 获得 openID
     */
    private function _oauth() {
        $params = $this->getParam();
        $openId = !isset($params['openid']) ? '' : $params['openid'];           // openId
        $time = !isset($params['time']) ? '' : intval($params['time']);     // 时间戳
        $sign = !isset($params['sign']) ? '' : $params['sign'];             // 签名
        // 检查是否进行了回跳
        if ($openId && $time && $sign) {

            // 验证签名
            $checkSign = $this->_oauthSign($time);
            if ($sign != $checkSign['sign']) {
                die('微信授权签名错误！');
            }

            // 使用 cookie 记录 openId 有效期1天
            setcookie($this->_cookieName, $openId, time() + 86400);

            $this->_openId = $openId;

            // cookie 记录的 openId 在有效期内
        } else if (isset($_COOKIE[$this->_cookieName]) && !empty($_COOKIE[$this->_cookieName])) {

            $this->_openId = $_COOKIE[$this->_cookieName];

            // 进行跳转授权
        } else {

            // 获得签名
            $backSign = $this->_oauthSign();

            // 回跳地址
            $backUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&' . http_build_query($backSign);

            // 去授权获得 OpenId
            $url = "http://sh.app.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=" . C('ENT_ID') . "&scope=snsapi_userinfo&url=" . urlencode($backUrl);
            header("location:$url");
            exit();
        }
    }

    /**
     * 微信JS SDK 配置信息
     */
    private function _jsSdk() {
        // 如果不是 ajax 的请求则加载微信 JS SDK
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

            $appId = C('APP_ID');
            $appSecret = C('APP_SECRET');

            $jsSign = new WxJsSign($appId, $appSecret);
            $signPackage = $jsSign->getSignPackage();

            $this->assign('appId', $appId);
            $this->assign('signPackage', $signPackage);

            // $this->display('Index.Common.wxjs');  // 该文件在 footer.php 中加载，否则会影响样式
        }
    }

    /**
     * 获取用户信息
     */
    public function userInfo($openId) {
        
    }

    /**
     * 设置分享配置 (* 公共类 勿改！)
     */
    public function setShare(array $params = array()) {
        // 分享的标题
        $shareTitle = !isset($params['shareTitle']) ? '分享标题' : $params['shareTitle'];

        // 分享的描述
        $shareDesc = !isset($params['shareDesc']) ? '分享描述' : $params['shareDesc'];

        // 分享使用的图标
        $shareImg = !isset($params['shareImg']) ? '' : $params['shareImg'];

        // 分享的链接地址 - 默认是当前页面
        $shareUrl = isset($params['shareUrl']) ? $params['shareUrl'] : "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $this->assign('shareTitle', $shareTitle);
        $this->assign('shareDesc', $shareDesc);

        $this->assign('shareUrl', $shareUrl);
        $this->assign('shareImgUrl', $shareImg);
    }

    /**
     * 获得卡券签名信息
     *
     * @param   array   $card    此字段为二维数组， key 为 cardId, value 为 card code
     */
    public function getCardSign(array $card) {
        $result = array();

        foreach ($card as $key => $val) {

            $sign = $this->_cardSign($key, $val);

            $result[] = array(
                'cardId' => $key,
                'cardExt' => json_encode(array(
                    'code' => $sign['code'],
                    'openid' => $sign['openid'],
                    'timestamp' => strval($sign['timestamp']), // 类型必须为 字符串
                    'signature' => $sign['signature'],
                )),
            );
        }

        return $result;
    }

    /**
     * 卡券老版签名
     */
    private function _cardOldSign($cardId, $code = '', $openId = '', $apiTicket = '') {
        $timestamp = strval(time());
        $apiTicket = empty($apiTicket) ? C('APP_SECRET') : $apiTicket;

        $signArr = array($apiTicket, $cardId, $code, $timestamp);

        sort($signArr);

        $signature = sha1(implode($signArr));

        return array(
            'code' => $code,
            'openid' => $openId,
            'card_id' => $cardId,
            'timestamp' => $timestamp,
            'signature' => $signature,
        );
    }

    /**
     * 卡券新版签名 （使用 apiTicket 能兼容老版）
     *
     * 该接口性能不如 _cardOldSign，因为需要获得 AccessToken 与 ApiTicket 仅作为兼容模式使用
     */
    private function _cardSign($cardId, $code = '', $openId = '') {
        $appId = C('APP_ID');
        $appSecret = C('APP_SECRET');

        $jsSign = new WxJsSign($appId, $appSecret);

        $apiTicket = $jsSign->getJsApiTicket('wx_card');

        return $this->_cardOldSign($cardId, $code, $openId, $apiTicket);
    }

}
