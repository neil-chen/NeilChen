<?php

/**
 * @author fangyan
 */
class IndexModel extends Model {

    private $_db;

    public function __construct() {
        parent::__construct();
        $this->_db = $this->getDbByHost(C('DB_HOST'), C('DB_USER'), C('DB_PWD'), C('DB_NAME'));
    }

    /**
     * 积分修改处理
     */
    public function detailScore($openid) {
        $openid = $this->_checkInput($openid);
        $sql = "SELECT * FROM wx_score_change_log WHERE openid = '{$openid}'";
        $rows = $this->_db->query($sql);
        return $rows;
    }

    /**
     * 积分数据处理
     */
    public function scoreChangeDetail($pagesize, $page, $param) {
        $param = $this->_checkInput($param);
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;
        //有效用户，有效抽取记录，用户没有中过大奖
        $sql = "SELECT * FROM wx_score_change_log WHERE 1 ";
        if (!empty($param['openid'])) {
            $sql .= " And openid LIKE '%{$param['openid']}%' ";
        }
        if (!empty($param['cardid'])) {
            $sql .= " And membership_number LIKE '%{$param['cardid']}%' ";
        }


        $count_sql = "SELECT count(*) FROM ($sql) AS t";
        $sql .= " ORDER BY id DESC LIMIT {$limit}, {$pagesize}";
        $data = $this->_db->getAll($sql);
        $rows = array();
        if ($data) {
            $now = time();
            foreach ($data as $k => $v) {
                $rows[$v['id']]['id'] = $v['id'];
                $rows[$v['id']]['openid'] = $v['openid'];
                $rows[$v['id']]['membership_number'] = $v['membership_number'];
                $rows[$v['id']]['source_score'] = $v['source_score'];
                $rows[$v['id']]['now_score'] = $v['now_score'];
                $rows[$v['id']]['score_change'] = $v['score_change'];
                $rows[$v['id']]['message'] = $v['message'];
                $rows[$v['id']]['time'] = $v['time'] ? date("Y-m-d H:i:s", $v['time']) : '';
            }
        }
        $count = $this->_db->getOne($count_sql);
        return array('count' => $count, 'data' => $rows);
    }

    /**
     * 会员处理
     */
    public function memberCardDetail($pagesize, $page, $param) {
        $param = $this->_checkInput($param);
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;
        $sql = "SELECT id,card_id,card_type,logo_url,brand_name,title FROM wx_member_card ";
        if (!empty($param['id'])) {
            $sql .= " WHERE openid = {$param['id']} ";
        }
        $count_sql = "SELECT count(*) FROM ($sql) AS t";
        $sql .= " ORDER BY id asc LIMIT {$limit}, {$pagesize}";
        $data = $this->_db->getAll($sql);
        $rows = array();
        if ($data) {
            foreach ($data as $k => $v) {
                $rows[$v['id']]['id'] = $v['id'];
                $rows[$v['id']]['card_id'] = $v['card_id'];
                $rows[$v['id']]['card_type'] = $v['card_type'];
                $rows[$v['id']]['logo_url'] = $v['logo_url'];
                $rows[$v['id']]['brand_name'] = $v['brand_name'];
                $rows[$v['id']]['title'] = $v['title'];
            }
        }
        $count = $this->_db->getOne($count_sql);
        return array('count' => $count, 'data' => $rows);
    }

    /**
     * SQL防注入参数过滤
     * @param type $param
     * @return type
     */
    private function _checkInput($param) {
        if (is_array($param) && count($param)) {
            foreach ($param as $key => $val) {
                $param[$key] = addslashes($val);
            }
        }
        if (is_string($param)) {
            $param = addslashes($param);
        }
        return $param;
    }

    /**
     * @param type $id
     * @return type
     */
    public function getCardId($id) {
        $sql = sprintf("SELECT card_id FROM wx_member_card WHERE id=%u", $id);
        return $this->_db->getOne($sql);
    }

    /**
     * 记录点击链接用户Openid
     * @param type $openid
     */
    public function saveOpenid($openid, $card_id) {
        if (!$card_id) {
            //如果card_id没有，获取第一个card_id
            $card_id = $this->_db->getOne("SELECT card_id FROM wx_member_card WHERE card_id != '' ORDER BY id ASC");
        }
        $id = $this->_db->getOne("SELECT id FROM wx_user_member_card WHERE openid = '{$openid}'");
        if ($id) {
            $this->_db->query("UPDATE wx_user_member_card SET card_id = '{$card_id}' WHERE openid = '{$openid}'");
            return $id;
        }
        $now = time(); //领取时间
        $this->_db->query("INSERT INTO wx_user_member_card (openid, card_id, adddate) VALUES ('{$openid}', '{$card_id}', '{$now}')");
        return $this->_db->insertId();
    }

    /**
     * 会员编辑
     */
    public function memberEdit($param) {

        $param = $this->_checkInput($param);

        $sql = "SELECT * FROM wx_member_card WHERE id ='" . $param['id'] . "'";

        $result = $this->_db->getRow($sql);
        return $result;
    }

    /**
     * 会员修改
     */
    public function memberModify($param) {
        $param = $this->_checkInput($param);
        $sql = "UPDATE wx_member_card SET ";
        if ($param['modify_card_id']) {
            $sql .=" `card_id`='{$param['modify_card_id']}', ";
        }
        if ($param['modify_card_id']) {
            $sql .= "`card_type`='{$param['modify_card_type']}',";
        }
        if ($param['modify_logo_url']) {
            $sql .=" `logo_url`='{$param['modify_logo_url']}',";
        }
        if ($param['modify_code_type']) {
            $sql .=" `code_type`='{$param['modify_code_type']}',";
        }
        if ($param['modify_brand_name']) {
            $sql .="`brand_name`='{$param['modify_brand_name']}',";
        }
        if ($param['modify_title']) {
            $sql .="`title`='{$param['modify_title']}',";
        }
        if ($param['modify_sub_title']) {
            $sql .="`sub_title`='{$param['modify_sub_title']}',";
        }
        if ($param['modify_color']) {
            $sql .="`color`='{$param['modify_color']}',";
        }
        if ($param['modify_notice']) {
            $sql .="`notice`='{$param['modify_notice']}',";
        }
        if ($param['modify_service_phone']) {
            $sql .="`service_phone`='{$param['modify_service_phone']}',";
        }
        if ($param['modify_description']) {
            $sql .="`description`='{$param['modify_description']}',";
        }
        if ($param['modify_use_limit']) {
            $sql .="`use_limit`='{$param['modify_use_limit']}',";
        }
        if ($param['modify_get_limit']) {
            $sql .="`get_limit`='{$param['modify_get_limit']}',";
        }
        if ($param['modify_date_type']) {
            $sql .="`date_type`='{$param['modify_date_type']}',";
        }
        if ($param['modify_date_fixed_term']) {
            $sql .="`date_fixed_term`='{$param['modify_date_fixed_term']}',";
        }
        if ($param['modify_date_fixed_begin_term']) {
            $sql .="`date_fixed_begin_term`='{$param['modify_date_fixed_begin_term']}',";
        }
        if ($param['modify_sku_quantity']) {
            $sql .="`sku_quantity`='{$param['modify_sku_quantity']}',";
        }
        if ($param['modify_url_name_type']) {
            $sql .="`url_name_type`='{$param['modify_url_name_type']}',";
        }
        if ($param['modify_custom_url']) {
            $sql .="`custom_url`='{$param['modify_custom_url']}',";
        }
        if ($param['modify_custom_url_name']) {
            $sql .="`custom_url_name`='{$param['modify_custom_url_name']}',";
        }
        if ($param['modify_promotion_url_name']) {
            $sql .="`promotion_url_name`='{$param['modify_promotion_url_name']}',";
        }
        if ($param['modify_promotion_url']) {
            $sql .="`promotion_url`='{$param['modify_promotion_url']}',";
        }
        if ($param['modify_prerogative']) {
            $sql .="`prerogative`='{$param['modify_prerogative']}',";
        }
        if ($param['modify_bonus_cleared']) {
            $sql .="`bonus_cleared`='{$param['modify_bonus_cleared']}',";
        }
        if ($param['modify_bonus_rules']) {
            $sql .="`bonus_rules`='{$param['modify_bonus_rules']}',";
        }
        if ($param['modify_activate_url']) {
            $sql .=" `activate_url`='{$param['modify_activate_url']}',";
        }
        if ($param['modify_custom_field1_name_type']) {
            $sql .=" `custom_field1_name_type`='{$param['modify_custom_field1_name_type']}',";
        }
        if ($param['modify_custom_field1_url']) {
            $sql .="`custom_field1_url`='{$param['modify_custom_field1_url']}',";
        }
        if ($param['modify_custom_field2_name_type']) {
            $sql .="`custom_field2_name_type`='{$param['modify_custom_field2_name_type']}',";
        }
        if ($param['modify_custom_field2_url']) {
            $sql .="`custom_field2_url`='{$param['modify_custom_field2_url']}',";
        }
        if ($param['modify_custom_field3_name_type']) {
            $sql .="`custom_field3_name_type`='{$param['modify_custom_field3_name_type']}',";
        }
        if ($param['modify_custom_field3_url']) {
            $sql .="`custom_field3_url`='{$param['modify_custom_field3_url']}',";
        }
        if ($param['modify_custom_cell1_name']) {
            $sql .="`custom_cell1_name`='{$param['modify_custom_cell1_name']}',";
        }
        if ($param['modify_custom_cell1_tips']) {
            $sql .="`custom_cell1_tips`='{$param['modify_custom_cell1_tips']}',";
        }
        if ($param['modify_custom_cell1_url']) {
            $sql .="`custom_cell1_url`='{$param['modify_custom_cell1_url']}',";
        }
        if ($param['modify_custom_cell2_name']) {
            $sql .="`custom_cell2_name`='{$param['modify_custom_cell2_name']}',";
        }
        if ($param['modify_custom_cell2_tips']) {
            $sql .="`custom_cell2_tips`='{$param['modify_custom_cell2_tips']}',";
        }
        $sql .=" `custom_cell2_url`='{$param['modify_custom_cell2_url']}' ";
        $sql .=" WHERE `id`='{$param['modify_id']}'";
        $this->_db->query($sql);
    }

    /**
     * 用户会员卡查询
     */
    public function userMemberCard($pagesize, $page, $param) {
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;
        $sql = "SELECT * FROM wx_user_member_card WHERE 1";
        if ($param['openid']) {
            $sql .=" AND `openid` like '%{$param['openid']}%'";
        }
        if ($param['card_num']) {
            $sql .=" AND `membership_number` like '%{$param['card_num']}%'";
        }

        $count_sql = "SELECT count(*) FROM ($sql) AS t";
        $sql .= " LIMIT {$limit}, {$pagesize}";
        $data = $this->_db->getAll($sql);
        $rows = array();
        if ($data) {
            foreach ($data as $k => $v) {
                $rows[$v['id']]['id'] = $v['id'];
                $rows[$v['id']]['openid'] = $v['openid'];
                $rows[$v['id']]['adddate'] = $v['adddate'] ? date("Y-m-d H:i:s", $v['adddate']) : '';
                $rows[$v['id']]['card_id'] = $v['card_id'];
                $rows[$v['id']]['activated'] = $v['activated'];
                $rows[$v['id']]['activate_date'] = $v['activate_date'] ? date("Y-m-d H:i:s", $v['activate_date']) : '';
                $rows[$v['id']]['code'] = $v['code'];
                $rows[$v['id']]['membership_number'] = $v['membership_number'];
            }
        }

        $count = $this->_db->getOne($count_sql);
        return array('count' => $count, 'data' => $rows);
    }

    /**
     * 用户会员卡编辑
     */
    public function userMemberEdit($pagesize, $page, $param) {
        $param = $this->_checkInput($param);
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;
        if ($param['id']) {
            $sql = "SELECT * FROM wx_user_member_card WHERE id = '" . $param['id'] . "'";
        }
        $count_sql = "SELECT count(*) FROM ($sql) as t";
        $sql .="ORDER BY id DESC LIMIT {$limit},{$pagesize}";
        $data = $this->_db->getAll($sql);
        $rows = array($data);
        if ($data) {
            foreach ($data as $k => $v) {
                $row[$v['id']]['id'] = $v['id'];
                $row[$v['id']]['openid'] = $v['openid'];
                $row[$v['id']]['adddate'] = $v['adddate'] ? date("Y-m-d H:i:s", $v['adddate']) : '';
                $row[$v['id']]['card_id'] = $v['card_id'];
                $row[$v['id']]['activated'] = $v['activated'] ? date("Y-m-d H:i:s", $v['activated']) : '';
                $row[$v['id']]['activate_date'] = $v['activate_date'] ? date("Y-m-d H:i:s", $v['activate_date']) : '';
                $row[$v['id']]['code'] = $v['code'];
                $row[$v['id']]['membership_number'] = $v['membership_number'];
                $row[$v['id']]['sell_date'] = $v['sell_date'] ? date("Y-m-d H:i:s", $v['sell_date']) : '';
                $row[$v['id']]['deleted'] = $v['deleted'];
                $row[$v['id']]['delete_date'] = $v['delete_date'] ? date("Y-m-d H:i:s", $v['delete_date']) : '';
                $row[$v['id']]['outer_id'] = $v['outer_id'];
                $row[$v['id']]['bonus'] = $v['bonus'];
                $row[$v['id']]['grade'] = $v['grade'];
            }
        }
        $count = $this->_db->getOne($count_sql);
        return array('count' => $count, 'data' => $rows);
    }

    /**
     * 修改提交用户会员卡
     */
    public function usermemberModify($param) {
        $param = $this->_checkInput($param);
        $sql = "update wx_user_member_card set ";
        if ($param['usermember']) {
            $sql .=" `id`='{$param['usermember']}', ";
        }
        if ($param['modify_card_openid']) {
            $sql .="`openid`='{$param['modify_card_openid']}',";
        }
        if ($param['modify_adddate']) {
            $sql .="`adddate`='{$param['modify_adddate']}',";
        }
        if ($param['modify_card_id']) {
            $sql .="`card_id`='{$param['modify_card_id']}',";
        }
        if ($param['modify_activated']) {
            $sql .="`activated`='{$param['modify_activated']}',";
        }
        if ($param['modify_activate_date']) {
            $sql .="`activate_date`='{$param['modify_activate_date']}',";
        }
        if ($param['modify_code']) {
            $sql .="`code`='{$param['modify_code']}',";
        }
        if ($param['modify_membership_number']) {
            $sql .="`membership_number`='{$param['modify_membership_number']}',";
        }
        if ($param['modify_sell_date']) {
            $sql .="`sell_date`='{$param['modify_sell_date']}',";
        }
        if ($param['modify_deleted']) {
            $sql .="`deleted`='{$param['modify_deleted']}',";
        }
        if ($param['modify_delete_date']) {
            $sql .="`delete_date`='{$param['modify_delete_date']}',";
        }
        if ($param['modify_outer_id']) {
            $sql .="`outer_id`='{$param['modify_outer_id']}',";
        }
        $sql .="`bonus`='{$param['modify_bonus']}',";
        $sql .=" `grade`='{$param['modify_grade']}' ";
        $sql .=" where `id`='{$param['usermember']}'";
        $this->_db->query($sql);
    }

    /**
     * 生成用户会员卡code
     * @return type
     */
    public function getCode($openid) {
        //获取code
        $code = $this->getCodeByOpenid($openid);
        if ($code) {
            return $code;
        }
        //如果没有code则生成
        $code = $this->createCodeByOpenid($openid);
        return $code;
    }

    /**
     * 根据openid获取用户code
     * @param type $openid
     * @return boolean
     */
    public function getCodeByOpenid($openid) {
        $openid = $this->_checkInput($openid);
        if (!$openid) {
            return false;
        }
        //获取code
        $code = $this->_db->getOne("SELECT `code` FROM wx_user_member_card WHERE openid='{$openid}'");
        return $code;
    }

    /**
     * 根据openid创建用户code
     * @param type $openid
     * @return boolean|string
     */
    public function createCodeByOpenid($openid) {
        $openid = $this->_checkInput($openid);

        $id = $this->_db->getOne("SELECT `id` FROM wx_user_member_card WHERE openid='{$openid}'");
        if (!$id) {
            return false;
        }
        //根据id生成唯一code
        $code = 'ME' . $this->dispRepair($id, 10, '0');

        $this->_db->query("UPDATE wx_user_member_card SET `code` = '{$code}' WHERE openid = '{$openid}'");
        return $code;
    }

    /**
     * 补充字符串为多少位
     * @param type $str 原字符串
     * @param type $len 新字符串长度
     * @param type $msg 填补字符
     * @param type $type 类型，0为后补，1为前补
     * @return type
     */
    function dispRepair($str, $len, $msg, $type = '1') {
        $length = $len - strlen($str);
        if ($length < 1)
            return $str;
        if ($type == 1) {
            $str = str_repeat($msg, $length) . $str;
        } else {
            $str .= str_repeat($msg, $length);
        }
        return $str;
    }

    /**
     * 检查登录
     * @param string $username
     * @param string $pwd
     * @param string $verify
     * @return string
     */
    public function checkLogin($username, $pwd, $verify) {
        $username = $this->_checkInput($username);
        $pwd = $this->_checkInput($pwd);

        //判断用户名、密码和验证码是否为空
        if (empty($username) || empty($pwd) || empty($verify)) {
            return 'userNull';
        }
        //判断验证码是否正确
        if ($_COOKIE['verify'] != md5($verify)) {
            return "verify_error";
        }
        //查询用户表
        $sql = "SELECT uid, username FROM wx_ht_user WHERE username='" . $username . "' AND password='" . md5($pwd) . "' ";
        $rs = $this->_db->getRow($sql);

        //将用户信息写入SESSION
        if ($rs) {
            setcookie("huishi_admin_uid", $rs['uid'], time() + 86400);
            $_COOKIE['huishi_admin_uid'] = $rs['uid'];
            setcookie("huishi_admin_username", $rs['username'], time() + 86400);
            $_COOKIE['huishi_admin_username'] = $rs['username'];
            return 'success';
        }

        return 'userError';
    }

    /**
     * 修改密码
     * @param string $userId
     * @param string $newpassword
     * @return boolean
     */
    public function setPassword($userId, $newpassword) {
        $userId = $this->_checkInput($userId);
        $newpassword = $this->_checkInput($newpassword);
        $data = array('password' => md5($newpassword));

        try {
            $rs = $this->_db->update("wx_ht_user", "uid={$userId}", $data);
        } catch (Exception $e) {
            Logger::error('ShopModel->setPassword error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }

        return $rs;
    }

    /**
     * 读取数据库密码后台修改用
     */
    public function readPassword($id) {
        $id = $this->_checkInput($id);
        $sql = "SELECT password FROM wx_ht_user WHERE uid = {$id}";
        $result = $this->_db->getOne($sql);
        return $result;
    }

}
