<?php

class UserModel extends Model {

    private $_db;
    // 性别
    private $_sex = array(
        '1' => '男',
        '2' => '女',
    );

    /**
     * 构造方法,初始化
     */
    public function __construct() {
        parent::__construct();
        $this->_db = $this->getDb();
    }

    /**
     * 发送短信
     */
    public function sendSMS($phone, $content) {
        $post_data = array();
        $post_data['Sn'] = "glacier";
        $post_data['Pwd'] = 'glacier5100';
        $post_data['mobile'] = $phone;
        $post_data['content'] = $content;
        $url = 'http://124.173.70.59:8081/SmsAndMms/mt?';
        $curlPost = "";
        foreach ($post_data as $k => $v) {
            $curlPost.= "$k=" . urlencode($v) . "&";
        }
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  //允许curl提交后,网页重定向
        curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch); //运行curl
        curl_close($ch);
        if ($data == 0) {
            return true;
        }
        return false;
    }

    /**
     * 保存验证码到数据库
     */
    public function saveCode($data) {

        $sql = "SELECT `openid` FROM wx_auth_code WHERE openid='" . $data['openid'] . "'";
        $rs = $this->_db->getRow($sql);
        if ($rs) {
            try {
                $openid = $data['openid'];
                unset($data['openid']);
                $rs = $this->_db->update("wx_auth_code", "openid='" . $openid . "'", $data);
                return $rs;
            } catch (Exception $e) {
                Logger::error('更新用户验证码error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
                return false;
            }
        } else {
            try {
                $rs = $this->_db->insert('wx_auth_code', $data);
                return $rs;
            } catch (Exception $e) {
                Logger::error('更新用户验证码error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
                return false;
            }
        }
    }

    /*
     * 验证验证码是否合法
     */

    public function checkCode($openid, $phone, $code) {
        $phone = trim($phone);
        $code = trim($code);
        $sql = "SELECT * FROM wx_auth_code WHERE openid='" . $openid . "' AND code='" . $code . "' AND phone='" . $phone . "'";
        $rs = $this->_db->getRow($sql);
        return $rs;
    }

    /**
     * 生成6位验证码
     */
    public function makeCode() {
        $str = "123456789";
        $code = "";
        for ($i = 0; $i < 6; $i++) {
            $code.=$str[rand(0, 8)];
        }
        return $code;
    }

    /**
     * 生成二维码
     *
     * @param string $media_name
     * @return booleangetUserQrc
     */
    public function genQrcToApi($mediaName) {
        $params = C('ACTIVITY_CONFIGS');

        $qrConfig = array('qrc_app_id' => 1, 'media_id' => "", 'type' => 'third', 'is_tip' => 1, 'group_id' => 8, 'scanMsg' => array(), 'subscribMsg' => array('type' => 'third', 'third_path' => '1', 'content' => 'http://call.socialjia.com/pay/5100App/partners.php?a=Scan', 'material_id' => '0'));
        //test
        //$qrConfig=array('qrc_app_id'=>1,'media_id'=>"",'type'=>'third','is_tip'=>1,'group_id'=>2,'scanMsg'=>array(),'subscribMsg'=>array('type'=>'third','third_path'=>'1','content'=>'http://wxh.app.socialjia.com/5100App/www/partners.php?a=Scan','material_id'=>'0'));
        // 增加此逻辑（判断是否是商家还是个人）
        $param = $qrConfig;
        $response = loadModel('Common')->getUerQrcToApi($mediaName, $param);

        if (!$response) {
            Logger::error('一人一码 YrymModel->getCodeToApi() : api 获取二维码接口失败!');
            return false;
        }
        $response = json_decode($response, true);
        if ($response['error']) {
            Logger::error('一人一码 YrymModel->getCodeToApi() : api 获取二维码接口失败!; code: ' . $response['error'] . ';msg:' . $response['msg']);
            return false;
        }

        if (isset($response['data']) && $response['data']) {
            return $response['data'];
        } else {
            Logger::error('一人一码 YrymModel->genQrcToApi() : api 获取二维码接口失败!', $response);
        }
        return false;
    }

    /**
     * 生成用户二维码
     * @param string $openid
     * @param string $email
     * @return bool
     */
    public function genUserQrc($openid, $phone) {
        if (!$openid || !$phone) {
            Logger::error('一人一码 生成用户二维码缺少参数：openid:' . $openid . '; email:' . $phone);
            return false;
        }

        $qrcData = $this->genQrcToApi($phone);

        if (!$qrcData || !is_array($qrcData) || !$qrcData['qrc_url'] || !$qrcData['qimg_id']) {
            Logger::error('一人一码返利 生成用户二维码调用接口返回错误：', $qrcData);
            return false;
        }

        $data = array();
        $data['openid'] = $openid;
        $data['qimgId'] = $qrcData['qimg_id'];
        $data['qimgPath'] = $qrcData['qrc_url'];
        $data['phone'] = $phone;

        // 插入二维码表方便下次查询
        if (!$this->addUserQrc($data)) {
            Logger::error('一一人一码返利 生成用户二维码添加用户二维码数据错误');
            return false;
        }
        return $qrcData;
    }

    /**
     * 添加用户二维码数据
     *
     * @param array $data
     * @return array | false
     */
    public function addUserQrc($data) {
        $addData = array(
            'openid' => $data['openid'],
            'qimg_id' => $data['qimgId'],
            'qimg_path' => $data['qimgPath'],
            'phone' => $data['phone'],
            'create_time' => date('Y-m-d H:i:s')
        );
        try {
            $rs = $this->_db->insert('wx_yrymfl_qrc', $addData);
        } catch (Exception $e) {
            Logger::error('一人一码 添加用户二维码数据错误: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
        return $rs;
    }

    /**
     * 获取合伙人二维码
     * @param string $openid
     * @return boolean
     */
    public function getUserQrc($openid) {
        $sql = "SELECT * FROM wx_yrymfl_qrc WHERE openid='" . $openid . "'";
        $rs = $this->_db->getRow($sql);
        if ($rs) {
            return $rs['qimg_path'];
        }
        return false;
    }

    /**
     * 根据openid查询合伙人
     * @param int $openid
     * return array  $data
     */
    public function getPartner($openid) {

        $sql = "select * from wx_partner_info where openid = '{$openid}'";
        $info = $this->_db->getRow($sql);

        if (isset($info['sex'])) {
            $info['sex_name'] = $this->_sex[$info['sex']];
            $rebate_model = loadModel('Index.Rebate');
            $result = $rebate_model->getrebateall($openid);
            $info['rebate'] = $result['rebate_money'] + $result['notaccount_money'] + $result['towithdraw_money'];

            $this->_db->update('wx_partner_info', " openid = '{$openid}' ", array('rebate' => $info['rebate']));
        }

        return $info;
    }

    /**
     * 添加 或 修改合伙人
     * @param array $param  参数
     */
    public function updatePartner(array $params) {
        if (empty($params['openid'])) {
            $this->setError(null, '获取用户信息失败，请刷新后重试！');
            return false;
        }

        if (empty($params['name'])) {
            $this->setError(null, '请填写姓名！');
            return false;
        }

        if (empty($params['phone']) && !isset($params['id'])) {
            $this->setError(null, '请填写手机号码！');
            return false;
        }

        if (empty($params['YYYY']) || empty($params['MM']) || empty($params['DD'])) {
            $this->setError(null, '请选择出生日期！');
            return false;
        }

        // -------------------------------------- 防止重复添加 START -------------------------------------- 
        if (!empty($params['phone'])) {
            $searchParams = array(
                'where' => array(
                    'phone' => !isset($params['phone']) ? null : $params['phone'],
                ),
                'whereNotIn' => array(
                    'id' => !isset($params['id']) ? null : array($params['id']),
                ),
            );
            $detail = $this->_db->get('wx_partner_info', $searchParams, true);
            if (!empty($detail)) {
                $this->setError(null, '该手机号码已经被注册过了！');
                return false;
            }
        }
        // -------------------------------------- 防止重复添加 END -------------------------------------- 

        $update = array(
            'openid' => $params['openid'],
            'name' => $params['name'],
            'sex' => $params['sex'],
            'area' => @$params['prov'] . "-" . @$params['city'] . "-" . @$params['dist'],
            'birthday' => $params['YYYY'] . "-" . $params['MM'] . "-" . $params['DD'],
            'profession' => $params['profession'],
            'identity_card' => $params['identity_card'],
            'phone' => @$params['phone'],
            'msg' => $params['msg'],
            'address' => $params['address'],
            'create_time' => date("Y-m-d H:i:s"),
        );
        //重新审核,更改状态
        if (isset($params['state'])) {
            $update['state'] = $params['state'];
        }

        // 获得微信用户头像
        if (!isset($params['id']) || empty($params['id'])) {
            $info = loadModel('Common')->getUserToApi($params['openid']);
            $info = json_decode($info, true);
            $update ['wx_img'] = !isset($info['data']['headimgurl']) ? '' : $info['data']['headimgurl'];
        }

        if (isset($params["id"]) && !empty($params["id"])) {

            if (!isset($params['phone'])) {
                unset($update['phone']);
            }

            unset($update['create_time']);

            $this->setError(null, '修改失败，请重试！');
            return $this->_db->update('wx_partner_info', " id=" . intval($params["id"]) . " AND `openid`='{$params['openid']}'", $update);
        } else {
            $this->setError(null, '注册失败，请重试！');
            return $this->_db->insert('wx_partner_info', $update);
        }

        return true;
    }

    /**
     * 获得合伙人可提现返利
     * 
     * @param  varchar $openId [description]
     * 
     * @return array
     */
    public function getRebateMoney($openId) {
        if (empty($openId)) {
            return array();
        }

        $paramsSearch = array(
            'where' => array(
                'openid' => $openId,
            ),
        );

        return $this->_db->get('wx_partner_statistics', $paramsSearch, true);
    }

    /**
     * 更新用户头像 （仅处理未获得头像的合伙人）
     */
    public function updateImg() {
        set_time_limit(0);

        // 获得所有没有头像的合伙人
        $search = array(
            'fields' => 'id, openid,wx_img',
            'where' => array(
                'wx_img' => '',
            ),
        );
        $result = $this->_db->get('wx_partner_info', $search);

        $common = loadModel('Common');

        foreach ($result['list'] as $val) {

            if (!empty($val['openid'])) {
                $wxInfo = $common->getUserToApi($val['openid']);
                $wxInfo = json_decode($wxInfo, true);

                if (isset($wxInfo['data']['headimgurl'])) {
                    $update = array(
                        'wx_img' => $wxInfo['data']['headimgurl'],
                    );
                    $this->_db->update('wx_partner_info', " id=" . intval($val["id"]) . " AND `openid`='" . $val["openid"] . "'", $update);
                }
            }
        }
    }

}
