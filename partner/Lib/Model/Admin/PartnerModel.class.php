<?php

class PartnerModel extends Model {

    private $_db;
    //合伙人状态 0审核中1申请通过2未通过3冻结
    private $_status = array(
        0 => '待审核',
        1 => '正常',
        2 => '已拒绝',
        3 => '冻结',
    );
    //性别
    private $_sex = array(
        0 => '',
        1 => '男',
        2 => '女',
    );

    /**
     * 构造方法,初始化
     */
    public function __construct() {
        parent::__construct();
        $this->_db = $this->getDb();
    }

    /**
     * 根据条件获取合伙人列表
     * @param array $param
     * @param String $fields  需要获取的字段
     * return  合伙人数组
     */
    public function getPartnerList($param, $fields = "*") {
        $where = "1";
        if (!empty($param['name'])) {
            $where .= " AND (p.name LIKE '%{$param['name']}%' OR p.phone LIKE '%{$param['name']}%' OR p.code LIKE '%{$param['name']}%')";
        }
        if (!empty($param['sTime'])) {
            $where.= " AND p.create_time >='" . $param['sTime'] . ' 00:00:00' . "'";
        }
        if (!empty($param['eTime'])) {
            $where.= " AND p.create_time <='" . $param['eTime'] . ' 23:59:59' . "'";
        }
        if ($param['state'] >= 0 && $param['state'] != '') {
            $where .= " AND p.state = {$param['state']}";
        }
        if (!empty($param['sex'])) {
            $where .= " AND p.sex = {$param['sex']}";
        }
        if (!empty($param['grade'])) {
            $score = $this->getPartnerLevel($param['grade']);
            $where .= " AND p.integral >= {$score['from_score']} AND p.integral < {$score['score']}";
        }
        if (!empty($param['channel'])) {
            $where .= " AND p.channel = {$param['channel']}";
        }
        if (!empty($param['ids'])) {
            $where .= " AND p.id IN ({$param['ids']})";
        }

        $sql = "SELECT {$fields} FROM wx_partner_info p 
                LEFT JOIN wx_partner_statistics ps ON p.openid = ps.openid
                WHERE {$where} {$param['special']} {$param['order']} ";

        if (isset($param['limit']) && $param['limit']) {
            $sql .= " {$param['limit']} ";
        }
        $data = $this->_db->getAll($sql);

        //获取渠道列表
        $channel = loadModel('Admin.Channel')->getlist();
        $keyChannel = array();
        foreach ($channel as $val) {
            $keyChannel[$val['id']] = $val;
        }
        
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k] = $v;
                //获取用户等级
                $level = $this->getPartnerLevelByScore($v['integral']);
                $data[$k]['level'] = $level;
                $data[$k]['level_name'] = $level['name'];
                $data[$k]['state_name'] = $this->_status[$v['state']];
                $data[$k]['gender'] = $this->_sex[$v['sex']];
                $data[$k]['channel_name'] = $v['channel'] ? $keyChannel[$v['channel']]['name'] : '-';
            }
        }
        return $data;
    }

    /**
     * 获取总记录数
     * @param array $param 参数
     * return 总记录数
     */
    public function getPartnerCount($param) {

        unset($param['order']);
        unset($param['limit']);
        $where = "1";
        if (!empty($param['name'])) {
            $where .= " AND (name LIKE '%{$param['name']}%' OR phone LIKE '%{$param['name']}%' OR code LIKE '%{$param['name']}%')";
        }

        if (!empty($param['sTime'])) {
            $where.= " AND create_time >='" . $param['sTime'] . ' 00:00:00' . "'";
        }

        if (!empty($param['eTime'])) {
            $where.= " AND create_time <='" . $param['eTime'] . ' 23:59:59' . "'";
        }

        if ($param['state'] >= 0 && $param['state'] != '') {
            $where .= " AND state = {$param['state']}";
        }

        if (!empty($param['sex'])) {
            $where .= " AND sex = {$param['sex']}";
        }

        if (!empty($param['grade'])) {
            $where .= " AND grade = {$param['grade']}";
        }

        if (!empty($param['channel'])) {
            $where .= " AND channel = {$param['channel']}";
        }

        if (!empty($param['special'])) {
            $where .= $param['special'];
        }

        $sql = "select count(id) from wx_partner_info where {$where} ";
        return $this->_db->getOne($sql);
    }

    /**
     * 根据id查询合伙人
     * @param int $id
     * return array  $data
     */
    public function getPartner($id) {

        $sql = "select * from wx_partner_info where id = {$id}";
        return $this->_db->getRow($sql);
    }

    /**
     * 合伙人状态操作
     * @param string $ids 
     * @param int $type  状态类型 1申请通过 2申请未通过 3冻结
     */
    public function stateOperation($ids, $type) {
        $sql = "update wx_partner_info set state = {$type} where id in({$ids})";
        return $this->_db->query($sql);
    }

    /**
     * 修改合伙人
     * @param int $id
     * @param array $param  参数
     */
    public function updatePartner($id, $param) {

        return $this->_db->update('wx_partner_info', " id = {$id}", $param);
    }

    /**
     * 获取合伙人等级信息
     * @param type $id 需要查询的返利类型
     * id为等级id 详见表 wx_partner_level 
     */
    public function getPartnerLevel($id = 0) {
        if ($id) {
            $sql = "SELECT * FROM wx_partner_level WHERE id = {$id}";
            return $this->_db->getRow($sql);
        }

        $sql = "SELECT * FROM wx_partner_level";
        $rows = $this->_db->getAll($sql);
        $cards = $this->getCardList();
        $return = array();
        foreach ($rows as $item) {
            $return[$item['id']] = $item;
            $return[$item['id']]['cards'] = array();
            $level_cards = explode(',', $item['award_cards']);
            //$k为card表中的id
            foreach ($cards as $k => $card) {
                //如果card list id 在用户
                if (in_array($k, $level_cards)) {
                    $return[$item['id']]['cards'][$k] = $card;
                }
            }
        }
        ksort($return);
        return $return;
    }

    /**
     * 保存合伙人等级信息
     * @param type $param
     */
    public function savePartnerLevel($param) {
        $id = $param['id'];
        unset($param['id']);
        if ($id) {
            $id = $this->_db->getOne("SELECT id FROM wx_partner_level WHERE id = {$id}");
            if ($id) {
                unset($param['id']);
                return $this->_db->update('wx_partner_level', " id = {$id} ", $param);
            }
        }
        return $this->_db->insert('wx_partner_level', $param);
    }

    /**
     * 获取合伙人返利参数
     * @param type $id 需要查询的返利类型 1为 呼朋唤友奖励, 2为 卡券核销奖励, 默认为 0 返回数组
     * 参考配置文件 ACTIVITY_CONFIGS.partners.partner_award
     */
    public function getPartnerAward($id = 0) {
        if ($id) {
            $sql = "SELECT * FROM wx_partner_award WHERE id = {$id}";
            return $this->_db->getRow($sql);
        }

        $sql = "SELECT * FROM wx_partner_award";
        $rows = $this->_db->getAll($sql);

        $return = array();
        foreach ($rows as $item) {
            $return[$item['id']] = $item;
        }
        return $return;
    }

    /**
     * 保存合伙人返利参数
     * @param type $param
     */
    public function savePartnerAward($param) {
        $id = $param['id'];
        unset($param['id']);
        if ($id) {
            $id = $this->_db->getOne("SELECT id FROM wx_partner_award WHERE id = {$id}");
            if ($id) {
                unset($param['id']);
                return $this->_db->update('wx_partner_award', " id = {$id} ", $param);
            }
        }
        return $this->_db->insert('wx_partner_award', $param);
    }

    /**
     * 根据积分获取合伙人等级信息
     * @param type $score
     */
    public function getPartnerLevelByScore($score) {
        if (is_numeric($score)) {
            $sql = "SELECT * FROM wx_partner_level WHERE from_score <= {$score} AND score > {$score} ORDER BY score ASC LIMIT 1;";
            return $this->_db->getRow($sql);
        }
        //没有积分则返回最低级
        $sql = "SELECT * FROM wx_partner_level ORDER BY score ASC LIMIT 1";
        return $this->_db->getRow($sql);
    }

    /**
     * 根据积分获取合伙人下一等级信息
     * @param type $score
     */
    public function getPartnerNextLevelByScore($score) {
        if (is_numeric($score)) {
            $sql = "SELECT * FROM wx_partner_level WHERE from_score > {$score} ORDER BY score ASC LIMIT 1";
            return $this->_db->getRow($sql);
        }
        //没有积分则返回最低级
        $sql = "SELECT * FROM wx_partner_level ORDER BY score ASC LIMIT 1";
        return $this->_db->getRow($sql);
    }

    /**
     * 添加合伙人统计 
     * $openids 多个openid
     */
    public function addPartnerStatistics($openids) {
        //卡券类的总数
        $levsql = "SELECT award_cards,card_total FROM wx_partner_level WHERE 1 limit 1";
        $data = $this->_db->getRow($levsql);
        $sql = "SELECT count(id) FROM wx_card_info WHERE id in ({$data['award_cards']}) ";
        $count = $this->_db->getOne($sql);
        $numcount = $count * $data['card_total'];
        try {
            $sql = "INSERT INTO wx_partner_statistics (openid, par_species, par_number) 
                    (SELECT openid,'{$count}',{$numcount} FROM wx_partner_info where `openid` in ('{$openids}')  )";
            $this->_db->query($sql);
        } catch (Exception $e) {
            Logger::error('插入wx_partner_statistics表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
    }

    /**
     * 查询全部卡券信息
     * 
     */
    public function listCardInfo() {
        $sqlto = "SELECT card_id,card_name FROM wx_card_info WHERE 1 ";
        $res = $this->_db->getAll($sqlto);
        return $res;
    }

    /**
     * 根据id查询卡券信息
     * 
     */
    public function listCardInfoInId($ids) {
        $sql = "SELECT id,card_id,card_name FROM wx_card_info WHERE id in ({$ids}) ";
        $res = $this->_db->getAll($sql);
        return $res;
    }

    /**
     * 添加合伙人卡券统计
     */
    public function addPartnerCardStatistics($arrto) {
        try {
            return $this->_db->insert("wx_partner_card_statistics", $arrto);
        } catch (Exception $e) {
            Logger::error('插入wx_partner_card_statistics表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
    }

    /**
     * 添加合伙人编号
     * @param type $openid
     */
    public function addPartnerUserCode($openid) {
        $id = $this->_db->getOne("SELECT id FROM wx_partner_info WHERE openid = '{$openid}'");
        $param['code'] = '5100'. date("Y") . $this->dispRepair($id, 8, 0, 1);
        return $this->_db->update('wx_partner_info', " openid = '{$openid}' ", $param);
    }

    /**
     * 补充字符串为多少位
     * @param type $str 原字符串
     * @param type $len 新字符串长度
     * @param type $msg 填补字符
     * @param type $type 类型，0为后补，1为前补
     * @return type
     */
    public function dispRepair($str, $len, $msg, $type = '1') {
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
     * 卡券列表
     * @return type
     */
    public function getCardList() {
        $rows = $this->_db->getAll("SELECT * FROM wx_card_info");
        $data = array();
        if ($rows) {
            foreach ($rows as $item) {
                $data[$item['id']] = $item;
            }
        }
        return $data;
    }

    /**
     * 删除合伙人等级
     * @param type $id
     */
    public function deletePartnerLevel($id) {
        if (is_numeric($id)) {
            return $this->_db->query("DELETE FROM wx_partner_level WHERE id = {$id}");
        }
        return false;
    }

}
