<?php

/**
 * 后台管理
 */
class IndexAction extends Action {

    private $_config;
    private $_username;
    private $_password;
    private $_verify;
    private $_card_id;
    private $_p;
    private $_model;
    private $_admin_model;
    private $_memberEdit;
    private $_member;
    private $_cardid;

    /**
     * 构造方法-初始化数据
     */
    public function __construct() {
        parent::__construct();
        $this->_model = loadModel('Index');
        $this->_admin_model = loadModel('Admin.Admin');
        $this->_config = array('verify_error' => '验证码错误', 'userNull' => '用户信息不能为空', 'userError' => '用户名密码错误');
        $this->_username = $this->getParam("username");
        $this->_password = $this->getParam("password");
        $this->_verify = $this->getParam("verify");
        $this->_p = $this->getParam('p') ? intval($this->getParam('p')) : 0;
        $this->_openid = $this->getParam("openid");
        $this->_memberEdit = $this->getParam("memberEdit");
        $this->_member = $this->getParam("member");
        $this->_cardid = $this->getParam("cardid");

        //获取card id
        $this->_card_id = $this->getParam('card_id');
        if (!$this->_card_id) {
            $id = $this->getParam('id') ? intval($this->getParam('id')) : 1;
            $this->_card_id = $this->_model->getCardId($id);
        }

        //验证是否登录用户
        if ((!isset($_COOKIE['huishi_admin_uid']) || !$_COOKIE['huishi_admin_uid']) && ($this->getParam("m") != 'login') && ($this->getParam("m") != 'index') && ($this->getParam("m") != 'verify')) {
            header('location:' . url('index', 'index', array(), 'admin.php'));
            exit();
        }
    }

    /**
     * 首页入口
     */
    public function index() {
        $this->display('Admin.index');
    }

    /**
     * 登陆验证入口
     */
    public function login() {
        if (isset($_REQUEST['username'])) {
            $this->_username = $_REQUEST['username'];
        }
        if (isset($_REQUEST['password'])) {
            $this->_password = $_REQUEST['password'];
        }
        if (isset($_REQUEST['verify'])) {
            $this->_verify = $_REQUEST['verify'];
        }
        $check = $this->_model->checkLogin($this->_username, $this->_password, $this->_verify);

        if ($check == "success") {
            $result = array('error' => 0, 'code' => 'welcome', 'msg' => '登录成功');
        } else if ($check == "jyzsuccess") {
            $result = array('error' => 0, 'code' => 'jyz', 'msg' => '登录成功');
        } else {
            $result = array('error' => 1, 'code' => 'index', 'msg' => $this->_config[$check]);
        }
        printJson($result);
    }

    /**
     * 生成验证码
     */
    public function verify() {
        Image::buildImageVerify(4, 1, "jpeg", 80, 28);
    }

    /**
     * 积分修改记录
     */
    public function scoreChangeLog() {
        $param = array(
            'openid' => $this->_openid,
            'cardid' => $this->_cardid,
        );
        //数据列表
        $pagesize = 10;
        $list = $this->_model->scoreChangeDetail($pagesize, $this->_p, $param);
        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);
        $pageObj = new Page($count, $pagesize);
        $pageObj->parameter = "&" . http_build_query($param);
        $page = $pageObj->show();
        $this->assign('param', $param);

        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('page', $page);

        $this->display("Admin.showScoreChangeLog");
    }

    /**
     * 更改会员卡
     */
    public function updateCard() {
        $id = $this->getParam('id') ? intval($this->getParam('id')) : 1;
        //读取配置信息
        $data = $this->_admin_model->getMemberCardConfig($id, $this->_card_id);
        $card_config = $data['card'];
        //调用API更新卡信息
        $get = $this->_admin_model->updateCardApi($card_config);
        printJson($get);
    }

    /**
     * 创建会员卡
     */
    public function createCard() {
        //默认为1
        $id = $this->getParam('id') ? intval($this->getParam('id')) : 1;
        //读取配置信息
        $data = $this->_admin_model->getMemberCardConfig($id);
        //调用API创建卡券，更新卡券card_id
        $get = $this->_admin_model->createCardApi($id, $data);
        printJson($get);
    }

    /**
     * 获取会员卡信息
     */
    public function getCardInfo() {
        $data = array('card_id' => $this->_card_id);
        $card_info = $this->_admin_model->getCardApi($data);
        if ($this->getParam('debug')) {
            echo '<pre>';
            print_r($card_info);
            echo '</pre>';
            exit;
        } else {
            $status = array('card_id' => $this->_card_id, 'status' => $card_info['card']['member_card']['base_info']['status']);
        }
        printJson($status);
    }

    /**
     * 获取卡券列表
     * status 参数 
     * “CARD_STATUS_NOT_VERIFY”,待审核；
     * “CARD_STATUS_VERIFY_FALL”,审核失败；
     * “CARD_STATUS_VERIFY_OK”，通过审核；
     * “CARD_STATUS_USER_DELETE”，卡券被用户删除；
     * “CARD_STATUS_USER_DISPATCH”，在公众平台投放过的卡券 
     */
    public function getCardList() {
        $data = array(
            'offset' => 0,
            'count' => 100,
            'status_list' => array($this->getParam("status")),
        );
        $card_list = $this->_admin_model->getCardList($data);
        //var_dump($card_list);
        printJson($card_list);
    }

    /**
     * 获取会员信息
     */
    public function getMemberInfo() {
        $data = array('card_id' => $this->_card_id, 'code' => $this->getParam("code"));
        $user_info = $this->_admin_model->getMemberCardUserInfo($data);
        var_dump($user_info);
    }

    /**
     * 企业会员卡
     */
    public function memberCard() {
        $member_card_config = C('MEMBER_CARD');
        $param = array(
            'member' => $this->_member,
        );
        $pagesize = 10;
        $list = $this->_model->memberCardDetail($pagesize, $this->_p, $param);
        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);
        $pageObj = new Page($count, $pagesize);
        $pageObj->parameter = "&" . http_build_query($param);
        $page = $pageObj->show();
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('page', $page);
        $this->assign('code_type', $member_card_config['card_type']);
        $this->assign('color', $member_card_config['color']);
        $this->display('Admin.memberCardDisplay');
    }

    /**
     * 积分变更记录
     */
    public function creditChangeRecord() {
        $param = array(
            'openid' => $this->_openid,
            'cardid' => $this->_cardid,
        );

        //数据列表
        $pagesize = 10;
        $list = $this->_model->scoreChangeDetail($pagesize, $this->_p, $param);
        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);

        $pageObj = new Page($count, $pagesize);
        $pageObj->parameter = "&" . http_build_query($param);
        $page = $pageObj->show();
        $this->assign('param', $param);
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('page', $page);

        $this->display("Admin.showScoreChangeLog");
    }

    /**
     * 会员积分编辑页
     */
    public function memberEdit() {
        $param = array(
            'id' => $this->getParam('id'),
        );
        $res = $this->_model->memberEdit($param);
        $member_card_config = C('MEMBER_CARD');
        $this->assign('card_type', $member_card_config['card_type']);
        $this->assign('color', $member_card_config['color']);
        $this->assign('code_type', $member_card_config['code_type']);
        $this->assign('date_type', $member_card_config['date_type']);
        $this->assign('url_name_type', $member_card_config['url_name_type']);
        $this->assign('res', $res);
        $this->display('Admin.memberCardModify');
    }

    /**
     * 会员修改
     */
    public function membeModify() {
        $param = array(
            'modify_id' => $this->getParam('modify_id'),
            'modify_card_id' => $this->getParam('modify_card_id'),
            'modify_card_type' => $this->getParam('modify_card_type'),
            'modify_logo_url' => $this->getParam('modify_logo_url'),
            'modify_code_type' => $this->getParam('modify_code_type'),
            'modify_brand_name' => $this->getParam('modify_brand_name'),
            'modify_title' => $this->getParam('modify_title'),
            'modify_sub_title' => $this->getParam('modify_sub_title'),
            'modify_color' => $this->getParam('modify_color'),
            'modify_notice' => $this->getParam('modify_notice'),
            'modify_service_phone' => $this->getParam('modify_service_phone'),
            'modify_description' => $this->getParam('modify_description'),
            'modify_use_limit' => $this->getParam('modify_use_limit'),
            'modify_get_limit' => $this->getParam('modify_get_limit'),
            'modify_date_type' => $this->getParam('modify_date_type'),
            'modify_date_fixed_term' => $this->getParam('modify_date_fixed_term'),
            'modify_date_fixed_begin_term' => $this->getParam('modify_date_fixed_begin_term'),
            'modify_sku_quantity' => $this->getParam('modify_sku_quantity'),
            'modify_url_name_type' => $this->getParam('modify_url_name_type'),
            'modify_custom_url' => $this->getParam('modify_custom_url'),
            'modify_custom_url_name' => $this->getParam('modify_custom_url_name'),
            'modify_promotion_url_name' => $this->getParam('modify_promotion_url_name'),
            'modify_promotion_url' => $this->getParam('modify_promotion_url'),
            'modify_prerogative' => $this->getParam('modify_prerogative'),
            'modify_bonus_cleared' => $this->getParam('modify_bonus_cleared'),
            'modify_bonus_rules' => $this->getParam('modify_bonus_rules'),
            'modify_activate_url' => trim($_POST['modify_activate_url']),
            'modify_custom_field1_name_type' => $this->getParam('modify_custom_field1_name_type'),
            'modify_custom_field1_url' => $this->getParam('modify_custom_field1_url'),
            'modify_custom_field2_name_type' => $this->getParam('modify_custom_field2_name_type'),
            'modify_custom_field2_url' => $this->getParam('modify_custom_field2_url'),
            'modify_custom_field3_name_type' => $this->getParam('modify_custom_field3_name_type'),
            'modify_custom_field3_url' => $this->getParam('modify_custom_field3_url'),
            'modify_custom_cell1_name' => $this->getParam('modify_custom_cell1_name'),
            'modify_custom_cell1_tips' => $this->getParam('modify_custom_cell1_tips'),
            'modify_custom_cell1_url' => $this->getParam('modify_custom_cell1_url'),
            'modify_custom_cell2_name' => $this->getParam('modify_custom_cell2_name'),
            'modify_custom_cell2_tips' => $this->getParam('modify_custom_cell2_tips'),
            'modify_custom_cell2_url' => $this->getParam('modify_custom_cell2_url'),
        );
        $this->_model->memberModify($param);
        header('Location:' . url('Index', 'memberCard', array(), 'admin.php'));
        exit();
    }

    /**
     * 用户会员卡
     */
    public function userMemberCard() {
        $param = array(
            'openid' => $this->getParam('openid'),
            'card_num' => $this->getParam('card_num'),
        );
        $pagesize = 10;
        $list = $this->_model->userMemberCard($pagesize, $this->_p, $param);
        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);
        $pageObj = new Page($count, $pagesize);
        $page = $pageObj->show();
        $this->assign('param', $param);
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('page', $page);
        $this->display('Admin.userMemberCardDisplay');
    }

    /**
     * 批量添加用户到白名单
     */
    public function addToWhite() {
        $openids = $this->_admin_model->getUserOpenid();
        $data = array('openid' => $openids, 'username' => array());
        $this->_admin_model->addUserToWhite($data);
    }

    /**
     * 用户会员卡显示
     */
    public function usermemberEdit() {
        $param = array(
            'id' => $this->getParam('id'),
        );
        $pagesize = 10;
        $list = $this->_model->userMemberEdit($pagesize, $this->_p, $param);

        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);
        $pageObj = new Page($count, $pagesize);
        $page = $pageObj->show();
        $this->assign('list', $list['data']);
        $this->assign('count', $count);
        $this->assign('page', $page);
        $this->display('Admin.usermembeModify');
    }

    /**
     * 用户会员修改
     */
    public function usermembeModify() {
        $param = array(
            'usermember' => $this->getParam('usermember'),
            'modify_card_openid' => $this->getParam('modify_card_openid'),
            'modify_adddate' => $this->getParam('modify_adddate'),
            'modify_card_id' => $this->getParam('modify_card_id'),
            'modify_activated' => $this->getParam('modify_activated'),
            'modify_activate_date' => $this->getParam('modify_activate_date'),
            'modify_code' => $this->getParam('modify_code'),
            'modify_membership_number' => $this->getParam('modify_membership_number'),
            'modify_sell_date' => $this->getParam('modify_sell_date'),
            'modify_deleted' => $this->getParam('modify_deleted'),
            'modify_delete_date' => $this->getParam('modify_delete_date'),
            'modify_outer_id' => $this->getParam('modify_outer_id'),
            'modify_bonus' => $this->getParam('modify_bonus'),
            'modify_grade' => $this->getParam('modify_grade'),
        );
        $this->_model->usermemberModify($param);
        header('Location:' . url('Index', 'userMemberCard', array(), 'admin.php'));
        exit();
    }

    /**
     * 修改密码
     */
    public function password() {
        $password = $this->getParam('password');
        $password = md5($password);

        $userId = $this->getParam('user_id');
        $newpassword = $this->getParam('newpassword');
        $repassword = $this->getParam('repassword');

        if ((isset($_COOKIE['huishi_admin_uid']) || $_COOKIE['huishi_admin_uid'])) {
            $id = $_COOKIE['huishi_admin_uid'];
            $user_pass = $this->_model->readPassword($id);
        }

        if (!empty($password) && !empty($userId) && !empty($newpassword) && !empty($repassword)) {
            if ($newpassword == $repassword) {
                if ($user_pass == $password) {
                    $result = $this->_model->setPassword($userId, $newpassword);
                    if ($result) {
                        $result = array('error' => 0, 'msg' => '修改成功。');
                    } else {
                        $result = array('error' => 1, 'msg' => '修改失败请重试。');
                    }
                } else {
                    $result = array('error' => 1, 'msg' => '旧密码输入错误。');
                }
            } else {
                $result = array('error' => 1, 'msg' => '新密码与重复密码不同。');
            }
        } else {
            $result = array('error' => 1, 'msg' => '修改密码信息不完整。');
        }
        echo json_encode($result);
        exit;
    }

    /**
     * 退出
     */
    public function signout() {
        $link = url('Index', 'index', array(), 'admin.php');
        //设置cookie失效
        setcookie('huishi_admin_uid', '', time() - 3600);
        header("location:$link");
        exit;
    }

}
