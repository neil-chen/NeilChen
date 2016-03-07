<?php
/**
* 登录
*
* @author     熊飞龙
* @date       2015-11-05
* @copyright  Copyright (c)  2015
* @version    $Id$
*/
class LoginAction extends AdminAction {

    private $_Model = null;

    /*
    * 构造函数
    */
    public function __construct() {
        parent::__construct();
        $this->_Model = loadModel("Admin.Manage");
    }

    /**
     * 登录界面
     */
    public function index ()
    {
        // 验证是否登录了
        $userInfo = getUserInfo();
        if (!empty($userInfo)) {

            $url = url('Partner', 'partnerList', null, 'admin.php');
            header("Location:{$url}");
            exit;
        }

        $this->display('Admin.Login.index');
    }

    /**
     * 获取验证码
     */
    public function verify ()
    {
        Image::buildImageVerify(4, 1, "png", 80, 28);
    }

    /**
     * 登录
     */
    public function login ()
    {
        $result = $this->_Model->checkLogin($this->getParam());

        if ($result === false) {
            jsonExit($this->_Model->getError(), false);    
        }

        jsonExit('ok', true);
    }

    /**
     * 注销
     */
    public function logout ()
    {
        unset($_SESSION['userInfo']);

        $url = url('Login', 'index', null, 'admin.php');

        header("Location:{$url}");
        exit;
    }
}