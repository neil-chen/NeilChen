<?php

/**
 * 前台入口文件
 */
class IndexAction extends Action {

    private $_model;
    private $_ModelCom;
    private $_openid;
    private $_user_id;
    private $_card_id;
    private $_token;
    private $_admin_model;

    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
        $this->_model = loadModel('Index');
        $this->_ModelCom = loadModel('Common');
        $this->_admin_model = loadModel('Admin.Admin');
        $this->_openid = isset($_COOKIE['huishi_openid']) ? $_COOKIE['huishi_openid'] : $this->getParam("openid");
        $this->_card_id = $this->getParam("card_id");
        $this->_token = $this->_ModelCom->getAccessToken();

        //获取openid
        if (!$this->_openid && empty($_COOKIE['huishi_openid'])) {
            $nowUrl = url('Index', 'index', array(), 'index.php');
            $url = "http://call.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=" . C('ENT_ID') . "&url=" . urlencode($nowUrl);
            header("location:$url");
            exit();
        }

        //获取card id
        if (!$this->_card_id) {
            //默认获取第一个card_id
            $id = $this->getParam('id') ? intval($this->getParam('id')) : 1;
            $this->_card_id = $this->_model->getCardId($id);
        }
        //保存openid到数据库
        if ($this->_openid) {
            $this->_user_id = $this->_model->saveOpenid($this->_openid, $this->_card_id);
        }

        if ($this->_openid && !isset($_COOKIE['huishi_openid'])) {
            setcookie("huishi_openid", $this->_openid, time() + 86400);
            $_COOKIE['huishi_openid'] = $this->_openid;
        }

        $this->assign('title', '惠氏健康生活馆会员卡');
    }

    /**
     * 领取卡券，入口
     */
    public function index() {
        //获取会员卡
        $jsSign = new WxJsSign(Config::APP_ID, Config::API_SECRET);
        $signPackage = $jsSign->GetSignPackage();

        $data = array(
            'appId' => $signPackage['appId'],
            'timestamp' => $signPackage['timestamp'],
            'nonceStr' => $signPackage['nonceStr'], //随机字符串
            'signature' => $signPackage['signature'],
        );

        //查看用户code
        $code = $this->_model->getCodeByOpenid($this->_openid);

        //添加用户到测试白名单，上线后删除此段
        //CARD_STATUS_VERIFY_OK 审核通过后去掉此段
        $whiteData = array('openid' => array($this->_openid), 'username' => array());
        $this->_admin_model->addUserToWhite($whiteData);

        $this->assign('code', $code);
		$this->assign('card_id', $this->_card_id);
        $this->assign('data', $data);
        $this->display('Index.index');
    }

    /**
     * 添加卡券
     * H5页面 AJAX请求
     */
    public function addCard() {
        $time = $this->getParam('timestamp') ? intval($this->getParam('timestamp')) : time();
        //生成和存储code
        $code = $this->_model->getCode($this->_openid);
        $api_ticket = $this->_ModelCom->getApiTicket($this->_token);

        $sign = array(
            $api_ticket, $this->_card_id, $time, $this->_openid, $code
        );
        //签名加密
        foreach ($sign as &$v) {
            $v = strval($v);
        }
        unset($v);
        sort($sign);
        $sign = sha1(implode($sign));

        $card['card_list'][] = array(
            'cardId' => $this->_card_id,
            'cardExt' => json_encode(array(
                'code' => strval($code),
                'openid' => strval($this->_openid),
                'timestamp' => strval($time),
                'signature' => strval($sign),
            )),
        );

        printJson($card);
    }

    /**
     * 获取用户已领取卡券
     */
    public function getUserCardList() {
        $data = array('openid' => $this->_openid, 'card_id' => $this->_card_id);
        $card_list = $this->_admin_model->getCardApi($data);
        if ($this->getParam('debug')) {
            echo '<pre>';
            print_r($card_list);
            echo '</pre>';
            exit;
        }
        printJson($card_list);
    }

}
