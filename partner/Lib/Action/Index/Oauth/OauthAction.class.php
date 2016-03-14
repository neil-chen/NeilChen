<?php

class OauthAction extends Action {

    private $_CommonModel;

    public function __construct() {
        parent::__construct();
        $this->_CommonModel = loadModel('Common');
    }

    /**
     * 授权获取用户信息接口
     * entid 用以验证
     */
    public function getUserOauth() {
        Logger::debug('调用接口 getUserOauth ', $this->getParam());
        if ($this->getParam('entid') != C('ENT_ID')) {
            Logger::debug('getUserOauth entid 错误', $this->getParam());
            echo '{"errcode": 1, "errmsg":" entid error "}';
            exit;
        }
        $nowUrl = url('Oauth', 'getUserInfo', array('backurl' => $this->getParam('backurl')), 'oauth.php');
        $url = "http://sh.app.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=116&scope=snsapi_userinfo&response_type=code&url=" . urlencode($nowUrl);

        header('Location:' . $url);
    }

    /**
     * 网页获取用户信息
     */
    public function getUserInfo() {
        Logger::debug('调用接口 getUserInfo ', $this->getParam());
        $code = $this->getParam('wxcode');
        $backurl = $this->getParam('backurl');
        if (!$code) {
            Logger::debug('getUserInfo 获取code失败', $this->getParam());
            echo '{"errcode": 2, "errmsg":" 获取code失败 "}';
            exit;
        }
        $response = $this->getOpenidAndToken($code);
        if (!$response['access_token']) {
            Logger::debug('getUserInfo 获取access_token失败', $response);
            echo '{"errcode": 3, "errmsg":" 获取access_token失败 "}';
            exit;
        }
        if (!$response['openid']) {
            Logger::debug('getUserInfo 获取openid失败', $response);
            echo '{"errcode": 4, "errmsg":" 获取openid失败 "}';
            exit;
        }
        $user_info = $this->getUserInfoByOpenid($response['access_token'], $response['openid']);
        Logger::debug('getUserInfo 返回用户信息', $user_info);
        if (false === strpos($backurl, '?')) {
            $url = $backurl . '?info=' . $user_info;
        } else {
            $url = $backurl . '&info=' . $user_info;
        }
        Logger::debug('getUserInfo 返回用户信息链接', $url);
        header('location:' . $url);
        exit;
    }

    /**
     * 网页获取openid和access_token
     * @param type $code
     * @return type
     */
    public function getOpenidAndToken($code) {
        $appid = C('APP_ID');
        $appsecret = C('APP_SECRET');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $output = $this->mycurl($url);
        $jsoninfo = json_decode($output, true);
        return $jsoninfo;
    }

    /**
     * 通过access_token和openid获取用户信息
     * @param type $access_token
     * @param type $openid
     * @return type
     */
    public function getUserInfoByOpenid($access_token, $openid) {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $content = $this->mycurl($url);
        return $content;
    }

    /**
     * curl请求
     * @param type $url 提交地址
     * @param type $post_file 提交内容
     * @return type
     */
    public function mycurl($url, $post_file = '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        if ($post_file) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_file);
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        return curl_exec($ch);
    }

}
