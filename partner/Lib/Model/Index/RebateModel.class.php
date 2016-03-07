<?php

class RebateModel extends Model {

    protected $_db;
    protected $_5100db;
    private $_time;

    public function __construct() {
        parent::__construct();
        $this->_db = $this->getDb();
    }

    //获取 返利 统计
    public function getrebateall($openid = '') {
        if (empty($openid)) {
            return false;
        }

        $sql = " SELECT * FROM wx_partner_statistics WHERE openid = '$openid'";
        $row = $this->_db->getRow($sql);

        return $row;
    }

    //获取用户积分
    public function getintegral($openid) {
        if (empty($openid)) {
            return false;
        }
        $sql = "SELECT integral FROM wx_partner_info WHERE openid = '$openid' limit 1";
        $result = $this->_db->getOne($sql);
        return $result;
    }

    //申请提现 rebatemoney 是申请发出时 合伙人的 可提现金额
    public function getcashapply($cash, $openid, $rebate_money) {
        if (empty($openid)) {
            return false;
        }

        $set = array();
        $set['openid'] = $openid;
        $set['money'] = $cash;
        $set['rebate_money'] = $rebate_money;
        $set['state'] = 0;
        $set['create_time'] = date('Y-m-d H:i:s', time());
        $table = "wx_bonus_draw";
        if ($this->_db->insert($table, $set)) {
            //$sql = "UPDATE wx_partner_statistics SET notaccount_money = notaccount_money + $cash WHERE openid = '{$openid}' ";
            //$result = $this->_db->query($sql);
            return true;
        } else {
            return false;
        }
    }

    //合伙人是否已经提交了 提现申请（提交后未处理的申请前，不可再次申请）
    public function ispartnerHascashapply($openid) {
        if (empty($openid)) {
            return false;
        }
        $sql = "SELECT * FROM wx_bonus_draw WHERE openid = '$openid' and state = 0 LIMIT 1";
        return $this->_db->getRow($sql);
    }

    //获取 我的提现 详情
    public function getbonuswithdrawl($limit = '', $openid = '') {
        if (empty($openid)) {
            return false;
        }
        $sql = "SELECT create_time,cancel_time,money,state,
                    CASE WHEN state = 1 THEN '已批准'
                         WHEN state = 2 THEN '已拒绝'
                         WHEN state = 0 THEN '未处理' END 
                         AS state_s 
               FROM wx_bonus_draw 
               WHERE openid = '$openid' AND `state`=1
               ORDER BY create_time DESC 
               LIMIT $limit";
        $result = $this->_db->getAll($sql);

        $total_num = $this->_db->getOne("SELECT count(*) FROM `wx_bonus_draw` WHERE `openid` = '{$openid}' AND `state`=1 ");

        // 获得金额
        $total_money = $this->_db->getOne("SELECT SUM(`money`) FROM `wx_bonus_draw` WHERE `openid` = '{$openid}' AND `state`=1 ");

        return array(
            'total' => intval($total_num),
            'result' => $result,
            'total_money' => floatval($total_money),
        );
    }

    //获取 我的提现 详情 总记录数
    public function getbonuswithdrawlcount($openid = '') {
        if (empty($openid)) {
            return false;
        }
        $sql = "SELECT count(*) FROM wx_bonus_draw WHERE openid = '$openid' AND `state`=1 ";
        $result = $this->_db->getOne($sql);
        return $result;
    }

    //成功提现 次数
    public function getcashsuccess($openid) {
        if (empty($openid)) {
            return false;
        }
        $sql = "SELECT count(*) as `count`,sum(money) as `sum` 
               FROM wx_bonus_draw 
               WHERE openid = '$openid' AND state = 1  ";
        $result = $this->_db->getRow($sql);
        return $result;
    }

    //获取我的卡券核销
    public function getverificlist($limit, $openid, $param) {
        if (empty($openid)) {
            return false;
        }
        $where = "";
        if (isset($param) && isset($param['create_time'])) {
            $createtime = $param['create_time'];
            $where .= " AND o.create_time >= '$createtime' ";
        }
        if (isset($param) && isset($param['end_time'])) {
            $end_time = $param['end_time'];
            $where .= " AND o.create_time <= '$end_time' ";
        }

        $sql = "SELECT * 
                FROM wx_bonus_order o 
                JOIN wx_getcode_log g ON o.card_code = g.code 
                WHERE g.source_openid = '{$openid}' {$where}
                ORDER BY o.create_time DESC 
                LIMIT $limit"; 
        $result = $this->_db->getAll($sql);

        if (!isset($_POST['p']) || (isset($_POST['p']) && $_POST['p'] == 1)) {
            $total = $this->_db->getRow("SELECT count(*) AS total, SUM(`money`) AS total_money, SUM(`score`) AS total_score FROM `wx_bonus_order` o JOIN wx_getcode_log g ON o.card_code = g.code WHERE g.source_openid = '{$openid}' {$where} ");

            return array(
                'total' => intval($total['total']),
                'result' => $result,
                'total_money' => floatval($total['total_money']),
                'total_score' => intval($total['total_score']),
            );
        } else {
            return array(
                'result' => $result,
            );
        }

    }

    //获取我的核销总计
    public function getverificlistcount($openid, $param) {
        if (isset($param) && isset($param['create_time'])) {
            $createtime = $param['create_time'];
            $where = " AND o.create_time >= '$createtime' ";
        }
        $sql = "SELECT count(*) FROM `wx_bonus_order` o JOIN wx_getcode_log g ON o.card_code = g.code WHERE g.source_openid = '{$openid}' {$where}";
        $result = $this->_db->getOne($sql);

        return $result;
    }

    /**
     * 获取用户当月之前返利，更新 可提现返利
     * @param type $openid
     * @return $money
     */
    public function getBeforeMonthRebate($openid) {
        $month = date('m');
        $year = date('Y');
        //开始时间，当月1号
        $date = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, 1, $year));

        //核销订单返利
        $order_rebate = $this->_db->getOne("SELECT SUM(money) FROM wx_bonus_order o
            JOIN wx_getcode_log g ON o.card_code = g.code
            WHERE g.source_openid = '{$openid}' AND o.create_time < '{$date}'");
        //邀请好友返利
        $invitation_rebate = $this->_db->getOne("SELECT SUM(money) FROM wx_partner_invitation 
            WHERE open_id = '{$openid}' AND create_time < '{$date}'");
        //用户已提现返利
        $towithdraw_money = $this->_db->getOne("SELECT towithdraw_money FROM wx_partner_statistics WHERE openid = '{$openid}'");
        //当月之前的所有返利减去已提现返利 为 现有可提现返利
        $money = $order_rebate + $invitation_rebate - $towithdraw_money;
        //更新
        $this->_db->update('wx_partner_statistics', " openid = '{$openid}' ", array('rebate_money' => $money));
        return $money;
    }

    /**
     * 获取用户当月返利，更新 未入账返利
     * @param type $openid
     * @return $money
     */
    public function getCurrentMonthRebate($openid) {
        $month = date('m');
        $year = date('Y');

        //开始时间，当月1号
        $date = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, 1, $year));
        //当月后返利为 未入账返利
        //核销订单返利
        $order_rebate = $this->_db->getOne("SELECT SUM(o.money) FROM wx_bonus_order o
            JOIN wx_getcode_log g ON o.card_code = g.code
            WHERE g.source_openid = '{$openid}' AND o.create_time >= '{$date}'");
        //邀请好友返利
        $invitation_rebate = $this->_db->getOne("SELECT SUM(money) FROM wx_partner_invitation 
            WHERE open_id = '{$openid}' AND create_time >= '{$date}'");

        $money = $order_rebate + $invitation_rebate;
        //更新
        $this->_db->update('wx_partner_statistics', " openid = '{$openid}' ", array('notaccount_money' => $money));
        return $money;
    }

    /**
     * 批量更新合伙人返利数据
     * @return type
     */
    public function updateAllUserRebate() {
        $month = date('m');
        $year = date('Y');
        $id = $this->_db->getOne("SELECT id FROM wx_bonus_update_log WHERE `year`='{$year}' AND `month`='{$month}'");
        if ($id) {
            return $id;
        }
        $rows = $this->_db->getAll("SELECT * FROM wx_partner_statistics");
        foreach ($rows as $item) {
            //更新用户可提现返利
            $this->getBeforeMonthRebate($item['openid']);
            //更新用户未入账返利
            $this->getCurrentMonthRebate($item['openid']);
        }
        //更新后插入更新记录
        $data = array('month' => $month, 'year' => $year, 'run_time' => date('Y-m-d H:i:s'));
        $new_id = $this->_db->insert('wx_bonus_update_log', $data);
        return $new_id;
    }

}
