<?php

/**
 * 公共model
 *
 */
class CommonModel extends Model {

    protected $_db;

    public function __construct() {
        parent::__construct();
        $this->_db = $this->getDb();
    }

    /**
     * 监测用户
     *
     * @return boolean
     */
    public function checkUser($openid, $title = 'CommonModel') {
        $flag = true;
        if (empty($openid)) {
            Logger::error("{$title}->checkUser openid is null");
            $flag = false;
        } else {
            $userFlag = $this->getUserByOpenid($openid);
            if (!$userFlag) {
                Logger::debug("{$title}->checkUser 用户未关注：openid：" . $openid);
                $flag = false;
            }
        }
        return $flag;
    }

    /**
     * 检测真实用户
     * 
     * @return boolean
     */
    public function checkTrueUser($openid, $title = 'CommonModel') {
        $flag = true;
        if (empty($openid)) {
            Logger::error("{$title}->checkTrueUser openid is null");
            $flag = false;
        } else {
            $userFlag = $this->_getUserByOpenid($openid);
            if (!$userFlag) {
                Logger::error("{$title}->checkTrueUser 用户不存在：openid：" . $openid);
                $flag = false;
            }
        }
        return $flag;
    }

    /**
     * 获取用户信息
     *
     * @param string $openid
     * @return boolean
     */
    public function getUserByOpenid($openid, $title = 'CommonModel') {
        $user = $this->_getUserByOpenid($openid, $title);
        if ($user && 1 == $user['subscribe']) {
            return $user;
        }

        return false;
    }

    /**
     * 获取用户信息
     *
     * @param string $openid
     * @return boolean
     */
    private function _getUserByOpenid($openid, $title = 'CommonModel') {
        $response = $this->getUserToApi($openid);
        if (!$response) {
            Logger::error($title . '->getUserByOpenid() : api 获取用户消息失败!');
            return false;
        }

        $response = json_decode($response, true);
        if ($response['error']) {
            Logger::error($title . '->getUserByOpenid() : api 获取用户消息失败!; code: ' . $response['error'] . ';msg:' . $response['msg']);
            return false;
        }
        if (isset($response['data']) && $response['data']) {
            return $response['data'];
        } else {
            Logger::error($title . '->getUserByOpenid() : api 获取用户信息错误', $response);
        }

        return false;
    }

    /**
     * 通过API获取用户
     *
     * @param string $openid
     * @return mixed
     */
    public function getUserToApi($openid) {
        $sendParam = array(
            'openid' => $openid,
            'a' => 'User',
            'm' => 'get'
        );
        $sendParam = array_merge($this->_getAuthParam(), $sendParam);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, C('API_URL'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        $body = http_build_query($sendParam);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * 通过API获取二维码
     *
     * @param string $media_name
     * @return mixed
     */
    public function getUerQrcToApi($mediaName, $param) {
        $sendParam = array(
            'a' => 'Qrcode',
            'm' => 'genUserSubscrib',
            'media_name' => $mediaName
        );

        $qrcConfig['scan_msg'] = $param['scanMsg'];
        $qrcConfig['subscrib_msg'] = $param['subscribMsg'];
        $qrcConfig['qrc_app_id'] = $param['qrc_app_id'];
        $qrcConfig['media_id'] = $param['media_id'];
        $qrcConfig['is_tip'] = $param['is_tip'];
        $qrcConfig['group_id'] = $param['group_id'];

        $sendParam = array_merge($qrcConfig, $sendParam);
        $sendParam = array_merge($this->_getAuthParam(), $sendParam);
        // 执行curl调用接口
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, C('API_URL'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        $body = http_build_query($sendParam);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * 获取auth
     *
     * @return multitype:string number
     */
    private function _getAuthParam() {
        $apiKey = C('API_KEY');
        $apiSecret = C('API_SECRET');
        $timestamp = time();
        return array(
            'apiKey' => $apiKey,
            'timestamp' => $timestamp,
            'sig' => md5($apiKey . $apiSecret . $timestamp)
        );
    }

    /**
     * 生成oauth url
     *
     * @param string $link
     * @return string
     */
    public function getOauthUrl($link, $type = "address") {
        $entId = C('ENT_ID');
        $redirectUri = urlencode($link);
        $matchs = array(
            'ENT_ID',
            'REDIRET_URI'
        );
        $replace = array(
            $entId,
            $redirectUri
        );
        if ($type == "address") {
            $active_config = C('ACTIVITY_CONFIGS');
            $wxurl = str_replace($matchs, $replace, $active_config['shop']['AUTH_PATH']);
        } else {
            $wxurl = str_replace($matchs, $replace, C('WX_AUTH_PATH'));
        }
        return $wxurl;
    }

    /**
     * API发送消息
     *
     * @param arary $param
     * @return mixed
     */
    public function sendMsg($param, $title = '') {
        $sendParam = array(
            'a' => 'Send',
            'm' => 'send'
        );
        $apiUrl = C('API_URL');

        $sendParam = array_merge($this->_getAuthParam(), $sendParam);
        $sendParam = array_merge($param, $sendParam);
        // var_dump($sendParam);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        $body = http_build_query($sendParam);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($curl);
        curl_close($curl);
        $title = $title ? $title : 'Loss';
        Logger::debug($title . '活动 : 用户API发送消息结果： httpCode：' . $httpCode, array(
            'body' => $body,
            'response' => json_decode($response, true),
            'httpInfo' => $httpInfo
        ));
        return $response;
    }

    /**
     * 获取access_token
     */
    public function getAccessToken() {

        $sendParam = array(
            'a' => 'Base',
            'm' => 'getToken'
        );
        $sendParam = array_merge($this->_getAuthParam(), $sendParam);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, C('API_URL'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        $body = http_build_query($sendParam);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($curl);
        curl_close($curl);

        $accessObj = json_decode($response, true);

        return $accessObj['data'];
    }

    /**
     * 获取api_ticket
     */
    public function getApiTicket($token) {
        if (empty($_COOKIE['ticket'])) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $token . '&type=wx_card');
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $httpInfo = curl_getinfo($curl);
            curl_close($curl);

            $accessObj = json_decode($response, true);
            setcookie('ticket', $accessObj['ticket'], time() + 7200);
            $_COOKIE['ticket'] = $accessObj['ticket'];
            return $accessObj['ticket'];
        }
        return $_COOKIE['ticket'];
    }

}
