<?php

/**
 * 会员卡后台管理
 */
class AdminModel extends Model {

    private $_db;
    private $_token;
    private $_debug = true; // true为开启写入系统日志 ,默认不写

    const create = 'https://api.weixin.qq.com/card/create?access_token=%s';    //创建卡券
    const update = 'https://api.weixin.qq.com/card/update?access_token=%s';    //更改卡券
    const white = 'https://api.weixin.qq.com/card/testwhitelist/set?access_token=%s';    //加入开发者白名单到会员卡
    const card_info = 'https://api.weixin.qq.com/card/get?access_token=%s';    //获取卡信息，status 审核状态
    const activate_card = 'https://api.weixin.qq.com/card/membercard/activate?access_token=%s';    //激活会员卡
    const update_member_card = 'https://api.weixin.qq.com/card/membercard/updateuser?access_token=%s';    //更改会员卡
    const get_card_list = 'https://api.weixin.qq.com/card/batchget?access_token=%s';    //批量查询卡列表
    const get_user_card_list = 'https://api.weixin.qq.com/card/user/getcardlist?access_token=%s';    //获取用户已领取卡券接口
    const get_member_card_user_info = 'https://api.weixin.qq.com/card/membercard/userinfo/get?access_token=%s';    //拉取会员信息（积分查询）接口

    public function __construct() {
        $this->_db = $this->getDbByHost(C('DB_HOST'), C('DB_USER'), C('DB_PWD'), C('DB_NAME'));
        $this->_token = $this->getAccessToken();
    }

    /**
     * 创建会员卡
     */
    public function createCardApi($id, $data) {
        $url = sprintf(self::create, $this->_token);
        $json = code_unescaped($data);
        $result = WeiXinApiRequest::post($url, $json, false, false);
        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("createCard 创建会员卡卡券：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        } else {
            // 创建成功，更新Card_Id
            if ($result ['card_id']) {
                $this->_updateMemberCardId($id, $result ['card_id']);
            }
        }
        return $result;
    }

    /**
     * 更新会员卡
     */
    public function updateCardApi($data) {
        $url = sprintf(self::update, $this->_token);
        $json = code_unescaped($data);
        $result = WeiXinApiRequest::post($url, $json, false, false);
        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("updateCard 更新会员卡券：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        }
        return $result;
    }

    /**
     * 更新Card_Id
     * 
     * @param type $id        	
     * @param type $card_id        	
     */
    private function _updateMemberCardId($id, $card_id) {
        $id = $this->_checkInput($id);
        $card_id = $this->_checkInput($card_id);
        $this->_db->query("UPDATE wx_member_card SET card_id = '{$card_id}' WHERE id = {$id}");
        return $id;
    }

    /**
     * 获取会员卡配置信息
     * 
     * @param type $id        	
     */
    public function getMemberCardConfig($id, $card_id = '') {
        if (!$id) {
            return false;
        }
        $id = $this->_checkInput($id);
        // 查询会员卡配置表
        $sql = "SELECT id, card_id, card_type, logo_url, code_type, brand_name, title, sub_title, color, notice, service_phone, description, 
            use_limit, get_limit, date_type, date_fixed_term, date_fixed_begin_term, sku_quantity, url_name_type, custom_url, custom_url_name, 
            promotion_url_name, promotion_url, prerogative, bonus_cleared, bonus_rules, activate_url, 
            custom_field1_name_type, custom_field1_url, custom_field2_name_type, custom_field2_url, custom_field3_name_type, custom_field3_url, 
            custom_cell1_name, custom_cell1_tips, custom_cell1_url, custom_cell2_name, custom_cell2_tips, custom_cell2_url 
            FROM wx_member_card WHERE id = {$id}";

        $row = $this->_db->getRow($sql);

        // 根据数据库配置config
        $card = array();
        //card_id
        if ($card_id) {
            $card['card']['card_id'] = $card_id;
        }
        //card_type
        if (!$card_id) {
            $card['card']['card_type'] = 'MEMBER_CARD';
        }
        //member_card
        if ($card_id) {
            $card['card']['member_card'] = array(
                'base_info' => array(
					//'title' => $row['title'],
                    'logo_url' => $row['logo_url'],
                    'code_type' => $row['code_type'],
                    'color' => $row['color'],
                    'notice' => $row['notice'],
                    'service_phone' => $row ['service_phone'],
                    'description' => $row ['description'],
                    'use_limit' => (int) $row['use_limit'],
                    'get_limit' => (int) $row['get_limit'],
                    'bind_openid' => false,
                    'can_share' => false,
                    'can_give_friend' => false,
                    'url_name_type' => $row ['url_name_type'],
                    'custom_url' => $row['custom_url'],
                    'custom_url_name' => $row ['custom_url_name'],
                    'promotion_url_name' => $row ['promotion_url_name'],
                    'promotion_url' => $row ['promotion_url'],
					/*
                    'date_info' => array(
                        'type' => $row['date_type'],
                        'fixed_term' => (int) $row ['date_fixed_term'],
                        'fixed_begin_term' => (int) $row ['date_fixed_begin_term']
                    ),*/
                ),
                'supply_bonus' => true,
                'prerogative' => $row ['prerogative'],
                'bonus_cleared' => $row ['bonus_cleared'],
                'bonus_rules' => $row ['bonus_rules'],
                'activate_url' => $row ['activate_url'],
                'custom_field1' => array(
                    'name_type' => $row ['custom_field1_name_type'],
                    'url' => $row ['custom_field1_url']
                ),
                'custom_field2' => array(
                    'name_type' => $row ['custom_field2_name_type'],
                    'url' => $row ['custom_field2_url']
                ),
                'custom_field3' => array(
                    'name_type' => $row ['custom_field3_name_type'],
                    'url' => $row ['custom_field3_url']
                ),
                'custom_cell1' => array(
                    'name' => $row ['custom_cell1_name'],
                    'tips' => $row ['custom_cell1_tips'],
                    'url' => $row ['custom_cell1_url']
                ),
                'custom_cell2' => array(
                    'name' => $row ['custom_cell2_name'],
                    'tips' => $row ['custom_cell2_tips'],
                    'url' => $row ['custom_cell2_url']
                ),
            );
        } else {
            $card['card']['member_card'] = array(
                'base_info' => array(
                    'logo_url' => $row['logo_url'],
                    'code_type' => $row['code_type'],
                    'brand_name' => $row['brand_name'],
                    'title' => $row['title'],
                    'sub_title' => $row['sub_title'],
                    'color' => $row['color'],
                    'notice' => $row['notice'],
                    'service_phone' => $row ['service_phone'],
                    'description' => $row ['description'],
                    'use_limit' => (int) $row['use_limit'],
                    'get_limit' => (int) $row['get_limit'],
                    'use_custom_code' => true,
                    'bind_openid' => false,
                    'can_share' => false,
                    'can_give_friend' => false,
                    'date_info' => array(
                        'type' => $row['date_type'],
                        'fixed_term' => (int) $row ['date_fixed_term'],
                        'fixed_begin_term' => (int) $row ['date_fixed_begin_term']
                    ),
                    'sku' => array(
                        'quantity' => (int) $row ['sku_quantity']
                    ),
                    'url_name_type' => $row ['url_name_type'],
                    'custom_url' => $row['custom_url'],
                    'custom_url_name' => $row ['custom_url_name'],
                    'promotion_url_name' => $row ['promotion_url_name'],
                    'promotion_url' => $row ['promotion_url']
                ),
                'supply_bonus' => true,
                'supply_balance' => false,
                //'need_push_on_view' => false,
                'prerogative' => $row ['prerogative'],
                'bonus_cleared' => $row ['bonus_cleared'],
                'bonus_rules' => $row ['bonus_rules'],
                'activate_url' => $row ['activate_url'],
                'custom_field1' => array(
                    'name_type' => $row ['custom_field1_name_type'],
                    'url' => $row ['custom_field1_url']
                ),
                'custom_field2' => array(
                    'name_type' => $row ['custom_field2_name_type'],
                    'url' => $row ['custom_field2_url']
                ),
                'custom_field3' => array(
                    'name_type' => $row ['custom_field3_name_type'],
                    'url' => $row ['custom_field3_url']
                ),
                'custom_cell1' => array(
                    'name' => $row ['custom_cell1_name'],
                    'tips' => $row ['custom_cell1_tips'],
                    'url' => $row ['custom_cell1_url']
                ),
                'custom_cell2' => array(
                    'name' => $row ['custom_cell2_name'],
                    'tips' => $row ['custom_cell2_tips'],
                    'url' => $row ['custom_cell2_url']
                ),
            );
        }

        return $card;
    }

    /**
     * SQL防注入参数过滤
     * 
     * @param type $param        	
     * @return type
     */
    private function _checkInput($param) {
        if (is_array($param) && count($param)) {
            foreach ($param as $key => $val) {
                $param [$key] = addslashes($val);
            }
        }
        if (is_string($param)) {
            $param = addslashes($param);
        }
        return $param;
    }

    /**
     * 查看会员卡详情
     */
    public function getCardApi($data) {
        $url = sprintf(self::card_info, $this->_token);
        $json = code_unescaped($data);
        $result = WeiXinApiRequest::post($url, $json, false, false);
        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("getCard 查看会员卡信息：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        }
        return $result;
    }

    /**
     * 查看卡券列表
     */
    public function getCardList($data) {
        $url = sprintf(self::get_card_list, $this->_token);
        $json = code_unescaped($data);
        $result = WeiXinApiRequest::post($url, $json, false, false);
        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("getCardList 查看卡券列表：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        }
        return $result;
    }

    /**
     * 查看用户已领取的会员卡
     */
    public function getUserCardList($data) {
        $url = sprintf(self::get_user_card_list, $this->_token);
        $json = code_unescaped($data);
        $result = WeiXinApiRequest::post($url, $json, false, false);
        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("getUserCardList 查看用户已领取的会员卡：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        }
        return $result;
    }

    /**
     * 添加测试白名单
     * @param $data $data
     * array(
     * 'openid'=> array('ocJOVjijSz0m0eOPN4hhn-ZW9s3E'),
     * 'usernmae'=> array(),
     * );
     */
    public function addUserToWhite($data) {
        $url = sprintf(self::white, $this->_token);
        $json = code_unescaped($data);
        $result = WeiXinApiRequest::post($url, $json, false, false);
        return $result;
    }

    public function getUserOpenid() {
        $sql = "SELECT openid FROM wx_user_member_card";
        $rows = $this->_db->getAll($sql);
        $data = array();
        foreach ($rows as $item) {
            $data [] = $item ['openid'];
        }
        return $data;
    }

    /**
     * 激活会员卡
     * @param $data
     */
    public function activateCard($data) {
        $url = sprintf(self::activate_card, $this->_token);

        // 根据openid判断用户是否存在
        $user = $this->_getUserMember($data ['openid']);
        if (empty($user)) {
            $this->error = array(
                'errcode' => 1,
                'errmsg' => "用户不存在"
            );
            return $this->error;
        }

        $data['code'] = $user['code'];
        $data['card_id'] = $user['card_id'];
        //当没有会员编号时 使用code
        if (empty($data['membership_number'])) {
            $data['membership_number'] = $user['code'];
        }
        $jsonData = $data;
        unset($jsonData ['openid']); //去掉不需要传给微信的openid
        unset($jsonData ['customer_id']);
        $json = code_unescaped($jsonData);
        $result = WeiXinApiRequest::post($url, $json, false, false);

        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("activateCard 激活会员卡卡券：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        //激活日志
        $saveLog = array();
        $saveLog['openid'] = $data['openid'];
        $saveLog['membership_number'] = $data['membership_number'];
        $saveLog['init_bonus'] = $data['init_bonus'];
        $saveLog['code'] = $data['code'];
        $saveLog['error'] = $result['errcode'];
        $saveLog['msg'] = $result['errmsg'];
        $saveLog['grade'] = $data['init_custom_field_value1'];
        if ($result ['errcode'] != 0) {
            $saveLog['status'] = 0;
        } else {
            $saveLog['status'] = 1;
        }

        $this->saveActivateLog($saveLog);

        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        } else {
            $updateUser = $this->_updateUserMember($data);
            // 激活成功
            if (empty($updateUser)) {
                $this->error = array(
                    'errcode' => 1,
                    'errmsg' => "激活失败"
                );
                return $this->error;
            }
        }

        return $result;
    }

    /**
     * 保存激活记录
     * @param type $data
     * @return type
     */
    public function saveActivateLog($data) {
        $data = $this->_checkInput($data);
        $time = time();
        $sql = "INSERT INTO  `wx_member_activate_log` (`openid`, `membership_number`, `init_bonus`, `code`, `grade`, `error`, `msg`, `status`, `time`) VALUES 
                    ('{$data['openid']}', '{$data['membership_number']}', '{$data['init_bonus']}', '{$data['code']}', '{$data['grade']}', '{$data['error']}', '{$data['msg']}', '{$data['status']}', '{$time}')";
        return $this->_db->query($sql);
    }

    /**
     * 根据openid 获取用户信息
     * @param unknown $openid        	
     */
    public function _getUserMember($openid) {
        $openid = $this->_checkInput($openid);
        $sql = "select id,openid,adddate,card_id,activated,activate_date,
    	code,membership_number,sell_date,deleted,delete_date,outer_id,bonus,grade from wx_user_member_card where openid='{$openid}'";
        return $this->_db->getRow($sql);
    }

    /**
     * 根据openid跟新用户信息
     */
    public function _updateUserMember($data) {
        $time = time();
        $sql = "UPDATE wx_user_member_card SET activated=1,card_id = '{$data['card_id']}',
    	activate_date={$time},bonus='{$data['init_bonus']}',grade='{$data['init_custom_field_value1']}',customer_id='{$data['customer_id']}' ";

        if (isset($data['cade'])) {
            $sql .= ",code='{$data['cade']}'";
        }
        if (isset($data['membership_number'])) {
            $sql .= ",membership_number='{$data['membership_number']}'";
        }

        $sql .= " WHERE openid = '{$data['openid']}'";

        return $this->_db->query($sql);
    }

    /**
     * 会员卡交易变更
     */
    public function scoreChange($data) {
        $url = sprintf(self::update_member_card, $this->_token);

        // 根据openid判断用户是否存在
        $user = $this->_getUserMember($data ['openid']);
        if (empty($user)) {
            $this->error = array(
                'errcode' => 1,
                'errmsg' => "用户不存在"
            );
            return $this->error;
        }

        $data ['code'] = $user ['code'];
        $data ['card_id'] = $user ['card_id'];
        $jsonData = $data;

        unset($jsonData ['source_score']); // 原始分数
        unset($jsonData ['now_score']); // 现有分数
        unset($jsonData ['openid']); // 去掉不需要传给微信的openid
        $json = code_unescaped($jsonData);
        $result = WeiXinApiRequest::post($url, $json, false, false);

        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("scoreChange 会员卡积分变更：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        $time = time();
        //插入积分变更记录
        $sql = "INSERT INTO `wx_score_change_log` (`openid`,`membership_number`,`source_score`,`now_score`,`score_change`,`message`,`grade`,`time`,`errcode`,`errmsg`)
        VALUES('{$data['openid']}','{$user['membership_number']}','{$data['source_score']}','{$data['now_score']}',
        		'{$data['add_bonus']}','{$data['record_bonus']}','{$data['custom_field_value1']}','{$time}','{$result ['errcode']}',,'{$result ['errmsg']}')";
        $this->_db->query($sql);


        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        } else {

            //修改会员积分与等级
            $sql = "UPDATE wx_user_member_card SET grade='{$data['custom_field_value1']}',bonus = '{$data ['now_score']}'
    	WHERE openid = '{$data['openid']}'";

            $updateUser = $this->_db->query($sql);

            // 修改成功
            if (empty($updateUser)) {
                $this->error = array(
                    'errcode' => 1,
                    'errmsg' => "积分变更失败"
                );
                return $this->error;
            }
        }

        return $result;
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
     * 查看会员信息
     */
    public function getMemberCardUserInfo($data) {
        $url = sprintf(self::get_member_card_user_info, $this->_token);
        $json = code_unescaped($data);
        $result = WeiXinApiRequest::post($url, $json, false, false);
        // 写入系统日志
        $this->_debug && Factory::getSystemLog()->push("getMemberCardUserInfo  拉取会员信息（积分查询）接口：", array(
                    'data' => $data,
                    'json' => $json,
                    'result' => $result
        ));

        if ($result ['errcode'] != 0) {
            $this->error = array(
                'errcode' => $result ['errcode'],
                'errmsg' => $result ['errmsg']
            );
            return $this->error;
        }
        return $result;
    }

}
