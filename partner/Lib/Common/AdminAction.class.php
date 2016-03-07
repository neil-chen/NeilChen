<?php
/**
* 后台框架统一入口
*
* @author     熊飞龙
* @date       2015-10-13
* @copyright  Copyright (c)  2015
* @version    $Id$
*/
class AdminAction extends Action {

    // 权限白名单(不需要验证权限)
    private $_noCheckMenu = array(
        'Login' => array('index', 'verify', 'login', 'logout'),
    );

    /*
    * 构造函数
    */
    public function __construct()
    {
        $this->_checkAuth();
    }

    /**
     * 权限验证
     */
    private function _checkAuth ()
    {
        // 验证是否登录了
        $action = $this->getParam('a');
        $method = $this->getParam('m');

        // 检查是否登录了
        $userInfo = getUserInfo();
        if (!empty($userInfo)) {
            return true;
        }

        // 过滤权限白名单
        if (in_array($action, array_keys($this->_noCheckMenu))) {

            if (in_array($method, $this->_noCheckMenu[$action])) {
                return true;
            }
        }

        // 重定向到登录页
        $loginUrl = url('Login', 'index', null, 'admin.php');
        header("Location:{$loginUrl}");
        exit;
    }
}