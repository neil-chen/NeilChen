<?php

/**
 * 5100介绍--ACTION类
 */
class UserAction extends WebAction {

    public function __construct() {
        parent::__construct();
        $this->model = loadModel('Index.User');
        $this->assign('title', '个人信息');
    }

    /**
     * 合伙人首页
     */
    public function index() {
        //根据openid 查询合伙人
        $data = $this->model->getPartner($this->_openId);
        $this->assign('data', $data);

        //合伙人不存在 前往注册页面
        if (empty($data)) {
            $this->assign('title', '注册');
            $this->display('Index.partnerRegister');
        } else {
            $partnerModel = loadModel('Admin.Partner');

            // 获得合伙人等级
            $level = $partnerModel->getPartnerLevelByScore($data['integral']);

            // 升级到下一级所需的积分
            $nextLevel = $partnerModel->getPartnerNextLevelByScore($data['integral']);

            // 获得合伙人可提现返利
            //$statistics = $this->model->getRebateMoney($this->_openId);
            $statistics = $data['rebate'];

            $this->assign('statistics', $statistics);
            $this->assign('level', array('level' => $level, 'next_level' => $nextLevel));

            //根据合伙人审核状态前往不同页面
            if ($data['state'] === "0") { // 审核中
                $this->assign('title', '注册审核中');
                $this->display('Index.partnerAudit');
            } elseif ($data['state'] == 2) { // 未通过
                $this->assign('title', '审核失败');
                $this->display('Index.partnerDefeated');
            } elseif ($data['state'] == 3) { // 冻结
                $this->assign('title', '冻结');
                $this->display('Index.partnerFrozen');
            } else {
                $this->assign('title', '个人中心');
                $this->display('Index.index');
            }
        }
    }

    /**
     * 个人信息
     * 
     */
    public function partnerInfo() {
        //根据openid 查询合伙人
        $data = $this->model->getPartner($this->_openId);
        $this->assign('data', $data);
        //合伙人不存在 前往注册页面
        if (empty($data)) {
            $this->assign('title', '注册');
            $this->display('Index.partnerRegister');
        } else {
            $partnerModel = loadModel('Admin.Partner');

            // 获得合伙人等级
            $level = $partnerModel->getPartnerLevelByScore($data['integral']);

            // 升级到下一级所需的积分
            $nextLevel = $partnerModel->getPartnerNextLevelByScore($data['integral']);

            // 获得合伙人可提现返利
            //$statistics = $this->model->getRebateMoney($this->_openId);
            $statistics = $data['rebate'];

            $this->assign('statistics', $statistics);
            $this->assign('level', array('level' => $level, 'next_level' => $nextLevel));

            //根据合伙人审核状态前往不同页面
            if ($data['state'] === "0") {    // 审核中
                $this->assign('title', '注册审核中');
                $this->display('Index.partnerAudit');
            } elseif ($data['state'] == 2) {    // 未通过
                $this->assign('title', '审核失败');
                $this->display('Index.partnerDefeated');
            } elseif ($data['state'] == 3) {    // 冻结
                $this->assign('title', '冻结');
                $this->display('Index.partnerFrozen');
            } else {
                $this->display('Index.PartnerInfo');
            }
        }
    }

    /**
     * 合伙人注册
     */
    public function partnerRegister() {
        //根据openid 查询合伙人
        $data = $this->model->getPartner($this->_openId);
        $this->assign('data', $data);

        //合伙人不存在 前往注册页面
        if (empty($data)) {
            $this->assign('title', '注册');
            $this->display('Index.partnerRegister');
        } else {
            $partnerModel = loadModel('Admin.Partner');

            // 获得合伙人等级
            $level = $partnerModel->getPartnerLevelByScore($data['integral']);

            // 升级到下一级所需的积分
            $nextLevel = $partnerModel->getPartnerNextLevelByScore($data['integral']);

            // 获得合伙人可提现返利
            //$statistics = $this->model->getRebateMoney($this->_openId);
            $statistics = $data['rebate'];

            $this->assign('statistics', $statistics);
            $this->assign('level', array('level' => $level, 'next_level' => $nextLevel));

            //根据合伙人审核状态前往不同页面
            if ($data['state'] === "0") { // 审核中
                $this->assign('title', '注册审核中');
                $this->display('Index.partnerAudit');
            } elseif ($data['state'] == 2) { // 未通过
                $this->assign('title', '审核失败');
                $this->display('Index.partnerDefeated');
            } elseif ($data['state'] == 3) { // 冻结
                $this->assign('title', '冻结');
                $this->display('Index.partnerFrozen');
            } else {
                $this->display('Index.index');
            }
        }
    }

    /**
     * 发送短信
     */
    public function sendMsg() {
        $code = $this->model->makeCode();
        $phone = $this->getParam('phone');
        $msg = "您的验证码为：{$code}。请不要将验证码泄露给其他人，如非本人操作，可不用理会。";
        // 存入数据库
        $arr = array(
            'openid' => $this->_openId,
            'phone' => $phone
        );

        $arr ['code'] = $code;
        // 发送接口
        if ($this->model->saveCode($arr)) {
            $send_res = $this->model->sendSMS($phone, $msg);
            echo $send_res ? 1 : 0;
            exit();
        }
        echo 0;
        exit();
    }

    /**
     * 检查验证码是否正确
     */
    public function checkCode() {
        $code = trim($this->getParam('code'));
        $phone = trim($this->getParam('phone'));

        if (!$code || !$phone) {
            echo "false";
        } else {
            $rcode = $this->model->checkCode($this->_openId, $phone, $code);

            if ($rcode ['code'] != $code) {
                echo "false";
            } else {
                echo "true";
            }
        }
        exit();
    }

    /**
     * 添加合伙人
     */
    public function addPartner() {

        $param = $this->getParam();
        $param['openid'] = $this->_openId;

        // 不用生成二维码
        //$this->_yrym($param ['phone']);
        // 添加合伙人
        $result = $this->model->updatePartner($param);

        Logger::debug(__METHOD__ . " 用户注册信息 ", $param);
        Logger::debug(__METHOD__ . " 插入用户返回 ", $result);

        if ($result === false) {
            jsonExit($this->model->getError(), false);
        }

        jsonExit('注册成功!', true);
    }

    // 生成二维码
    public function _yrym($phone) {
        $getUser = $this->model->getUserQrc($this->_openId);
        if (!$getUser) {

            $result = $this->model->genUserQrc($this->_openId, $phone);
            if (!$result) {
                $url = url('User', 'partnerRegister', array('openid' => $this->_openId), 'index.php');

                echo "<script> alert('注册失败,请重新操作!');location.href = '{$url}'; </script>";
                exit;
            }
            return true;
        }
    }

    /**
     * 编辑合伙人
     */
    public function editPartner() {
        //重新审核
        $recheck = 0;
        if ($this->getParam('recheck')) {
            $recheck = 1;
        }
        //根据openid获取合伙人信息
        $data = $this->model->getPartner($this->_openId);

        //对省市区字段进行处理
        $area = explode("-", $data['area']);

        //对生日字段进行处理
        $birthday = explode("-", $data['birthday']);

        $this->assign('recheck', $recheck);
        $this->assign('data', $data);
        $this->assign('prov', $area[0]);
        $this->assign('city', $area[1]);
        $this->assign('dist', $area[2]);
        $this->assign('YYYY', $birthday[0]);
        $this->assign('MM', $birthday[1]);
        $this->assign('DD', $birthday[2]);
        $this->display('Index.partnerEdit');
    }

    /**
     * 编辑合伙人保存
     */
    public function edit() {
        $param = $this->getParam();
        $param['openid'] = $this->_openId;

        $phone = $this->getParam('phone');
        $code = $this->getParam('code');
        if (!empty($phone) && !empty($code)) {
            //检查验证码是否正确
            $rcode = $this->model->checkCode($this->_openId, $phone, $code);
            if ($rcode ['code'] != $code) {
                jsonExit('验证码错误,请重新操作!', false);
            }
            $param ['phone'] = $this->getParam('phone');
        }

        //重新审核
        if ($this->getParam('recheck')) {
            $param['state'] = 0;
        }
        //合伙人
        $result = $this->model->updatePartner($param);

        if ($result === false) {
            jsonExit($this->model->getError(), false);
        }
        //重新审核
        if ($this->getParam('recheck')) {
            jsonExit('申请成功!', true);
        }
        jsonExit('修改成功!', true);
    }

    /**
     * 更新用户头像
     */
    public function updateImg() {
        if (false) {
            $this->model->updateImg();
        }
    }

}
