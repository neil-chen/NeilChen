<?php

class CardModel extends Model {

    private $_db;
    private $_statusConfig = array();
    private $_cardType = array();
    private $_partnerModel;

    /**
     * 构造方法,初始化
     */
    public function __construct() {
        parent::__construct();
        $this->_statusConfig = array(
            '0' => '待审核',
            '1' => '已补充',
            '2' => '拒绝补充'
        );
        $this->_partnerModel = loadModel('Admin.Partner');
        $this->_db = $this->getDb();
    }

    public function getOpenidPackageCardInfo($openid) {
        $sql = "
                SELECT i
                FROM
                (
                    SELECT (@i:=@i+1) as i,wx_partner_statistics.*
                    FROM wx_partner_statistics,(SELECT @i := 0 ) tmp
                    ORDER BY wx_partner_statistics.id DESC
                ) a
                WHERE a.openid = '{$openid}'
            ";
        return $this->_db->getOne($sql);
    }

    /**
     * 检查抽取大奖列表
     */
    public function listPartnerCardPackageAll($pagesize, $page, $param) {
        
        $param = $this->_checkInput($param);
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;
        $sql = "SELECT a.id, a.`name`,a.`code`, b.openid, b.par_species , b.par_number, b.par_supplement, b.par_issue, b.par_issued, b.par_receiv, b.par_cancel  
        FROM wx_partner_info a 
        JOIN wx_partner_statistics b ON b.openid = a.openid";

        if (!empty($param['cfrom'])) {
            $start_date = strtotime($param['cfrom'] . " 00:00:00");
            $sql .=" AND UNIX_TIMESTAMP(a.`create_time`) > {$start_date} ";
        }
        if (!empty($param['cto'])) {
            $end_date = strtotime($param['cto'] . " 23:59:59");
            $sql .=" AND UNIX_TIMESTAMP(a.`create_time`) < {$end_date} ";
        }
        if (!empty($param['name'])) {
            $sql .= " AND (a.name LIKE '%{$param['name']}%' OR a.code LIKE '%{$param['name']}%' OR a.phone LIKE '%{$param['name']}%') ";
        }

        if ($param['state'] >= 0 && $param['state'] != '') {
            $sql .= " AND a.state = {$param['state']}";
        }

        if (!empty($param['sex'])) {
            $sql .= " AND a.sex = {$param['sex']}";
        }

        if (!empty($param['grade'])) {
            $score = $this->_partnerModel->getPartnerLevel($param['grade']);
            $sql .= " AND a.integral >= {$score['from_score']} AND a.integral < {$score['score']}";
        }

        if (!empty($param['channel'])) {
            $sql .= " AND a.channel = {$param['channel']}";
        }

        $count_sql = "SELECT count(*) FROM ($sql) AS t";
        $sql .= " ORDER BY b.id DESC LIMIT {$limit}, {$pagesize}";
        $data = $this->_db->getAll($sql);
        /* $rows = array();
          if ($data) {
          $now = time();
          foreach ($data as $k => $v) {
          $rows[$v['id']]['id'] = $v['ub_id'];
          $rows[$v['id']]['name'] = $v['name'];
          $rows[$v['id']]['openid'] = $v['openid'];
          $rows[$v['id']]['par_species'] = $v['par_species'];
          $rows[$v['id']]['par_number'] = $v['par_number'];
          $rows[$v['id']]['par_supplement'] = $v['par_supplement'];
          $rows[$v['id']]['par_issue'] = $v['par_issue'];
          $rows[$v['id']]['par_issued'] = $v['par_issued'];
          $rows[$v['id']]['par_receiv'] = $v['par_receiv'];
          $rows[$v['id']]['par_cancel'] = $v['par_cancel'];
          }
          } */

        $count = $this->_db->getOne($count_sql);

        return array('count' => $count, 'data' => $data);
    }

        public function allRefuse($id) {
        $arr = ltrim($id, ",");
        $array = explode(",", $arr);
        $param = array(
            'sub_status' => 2,
            'sup_time' => time()
        );
        
        
       

        if (is_array($array)) {
            foreach ($array as $key => $val) {
                $where = "`id` = '{$val}'";
                $sql = "UPDATE wx_partner_card_supplement SET ";
                if (isset($param['sub_status']) && !empty($param['sub_status'])) {
                    $sql .=" `sub_status` = '{$param['sub_status']}', ";
                }
                if (isset($param['sup_time']) && !empty($param['sup_time'])) {
                    $sql .=" `sup_time` = '{$param['sup_time']}', ";
                }
                $sql .= " `refused_msg` = '批量拒绝' WHERE `id` = '{$val}' ";
                $res = $this->_db->query($sql);
            }
         

            return $res;
        }
    }

    /**
     * 
     * @param type $pagesize
     * @param type $page
     * @param type $param
     * @return type
     */
    public function CardInfoList($pagesize, $page, $param) {
        $param = $this->_checkInput($param);
        $page = $page ? $page : 1;
        $limit = abs(intval($page - 1)) * $pagesize;
        $where = "";
        if (isset($param['order_id']) && !empty($param['order_id'])) {
            $where .= "AND (`card_name` like '%{$param['order_id']}%' OR `card_sn` like '%{$param['order_id']}%' OR `card_id` like '%{$param['order_id']}%')";
        }
        if (isset($param['create_time']) && !empty($param['create_time'])) {

            //$starttime = time($param['start_date']);
            //  $starttime = date("Y-m-d ", $starttime ); 
            $starttime = strtotime($param['create_time'] . "00:00:00");

            $where .= "AND `create_time` = '{$starttime}' ";
        }
        if (isset($param['status1']) && !empty($param['status1'])) {
            $where .="AND `type` = '{$param['status1']}' ";
        }
        if (isset($param['status2']) && !empty($param['status2'])) {
            $where .="AND `status` ='{$param['status2']}' ";
        }
        $sql_count = "SELECT count(*) FROM `wx_card_info` WHERE 1 " . $where;
        $sql = "SELECT * FROM `wx_card_info` where 1 " . $where . "ORDER BY id DESC LIMIT {$limit},{$pagesize}";
        $data = $this->_db->getAll($sql);
        $count = $this->_db->getOne($sql_count);
        return array('count' => $count, 'data' => $data);
    }

    /**
     * 根据openid查询合伙人卡券统计
     *  
     * @param mixed $openid
     */
    public function listCardStatistics($openid) {
        $sql = "SELECT * from wx_partner_card_statistics WHERE openid = '{$openid}' ";
        $data = $this->_db->getAll($sql);
        return $data;
    }

    /**
     * 添加卡券信息
     */
    public function CardInfoAdd($param) {
        $param = $this->_checkInput($param);
        $start_date = strtotime($param['start_date'] . "00:00:00");
        $end_date = strtotime($param['end_date'] . "00:00:00");
        $time = date('Y-m-d', time());
        $time = strtotime($time . "00:00:00");
        
        $arr = array(
            'card_sn' => '',
            'card_id' => $param['card_id'],
            'card_name' => $param['card_name'],
            'card_num' => $param['card_num'],
            'type' => $param['type'],
            'status' => $param['status'],
            'from_time' => $start_date,
            'end_time' => $end_date,
            'card_img' => $param['file'],
            'card_msg' => $param['card_msg'],
            'create_time' => $time,
            'update_time' => 0,
        );
        try {
            $this->_db->insert("wx_card_info", $arr);
            $id = $this->_db->insertId();
            $where = "`id` = {$id}";
            $code = 'KQ' . $this->dispRepair($id, 16, 0, 1);
            $this->_db->update('wx_card_info', $where, array('card_sn'=>$code));
            return $id;
        } catch (Exception $e) {
            Logger::error('插入wx_card_info表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
        
        
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

    //查询卡券详情
    public function queryCard($id) {
        $sql = "select * from `wx_card_info` where id ='{$id}'";
        $data = $this->_db->getAll($sql);

        return $data;
    }

    //查询渠道
    public function queryChannel() {
        $sql = "select * from `wx_channel`";
        $channel = $this->_db->getAll($sql);
        foreach ($channel as $k => $v) {
            $data[$v['id']]['id'] = $v['id'];
            $data[$v['id']]['name'] = $v['name'];
        }
        return $data;
    }

    //查询卡券
    public function queryCardid() {
        $sql = "select * from `wx_card_info`";
        $cardInfo = $this->_db->getAll($sql);
        foreach ($cardInfo as $k => $v) {
            $data[$v['id']]['id'] = $v['id'];
            $data[$v['id']]['card_id'] = $v['card_id'];
        }
        return $data;
    }

    //查询补充审核详情
    public function querySupList($pagesize, $page, $param) {
       
        $param = $this->_checkInput($param);
        $page = $page ? $page : 1;
        $limit = abs(intval($page - 1)) * $pagesize;
        $where = " 1=1 ";

        if (isset($param['code']) && !empty($param['code'])) {
            $where .=" AND (a.`code` like '%{$param['code']}%' OR a.`name` like '%{$param['code']}%' OR a.`phone` LIKE '%{$param['code']}%')";
        }
        if (isset($param['create_time']) && !empty($param['create_time'])) {
            $start_date = strtotime($param['create_time'] . " 00:00:00");
            $where .=" AND b.`create_time` > {$start_date} ";
        }
         if (isset($param['end_time']) && !empty($param['end_time'])) {
            $end_date = strtotime($param['end_time'] . " 23:59:59");
            $where .=" AND b.`create_time` < {$end_date} ";
        }
        if (isset($param['sub_status']) && $param['sub_status'] !== '') {
            $where .=" AND `sub_status` = '{$param['sub_status']}' ";
        }
        if (isset($param['channel']) && $param['channel'] !== '') {
            $where .=" AND c.id = '{$param['channel']}' ";
        }
        if (isset($param['card_type']) && $param['card_type'] !== '') {
            $where .=" AND d.id = '{$param['card_type']}' ";
        }
    

        $sql_count = "SELECT count(*) FROM `wx_partner_card_supplement` b join `wx_partner_info` a "
                . "on a.openid = b.openid left join `wx_channel` c on a.channel = c.id join `wx_card_info` d "
                . "on b.card_id = d.card_id  WHERE " . $where;

        $sql = "SELECT c.id AS channel, b.id,b.openid, a.code, b.tosup_num, a.name, b.create_time, b.card_name, b.sup_num,b.refused_msg, b.sup_time, b.sub_status, b.sup_sn, b.card_id, b.card_sn 
                FROM `wx_partner_card_supplement` b 
                join `wx_partner_info` a on a.openid = b.openid 
                left join `wx_channel` c on a.channel = c.id
                join `wx_card_info` d on b.card_id = d.card_id
                WHERE " . $where . "ORDER BY b.id DESC LIMIT {$limit},{$pagesize}";

        $data = $this->_db->getAll($sql);
        foreach ($data as $k => $v) {
            $data[$k]['sub_status'] = $this->_statusConfig[$v['sub_status']];
            $data[$k]['sup_time'] = $v['sup_time'] == 0 ? 0 : date('Y-m-d H:i:s', $v['sup_time']);
            $data[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
            // $data[$k]['channel'] = $v['channel'];
        }
        $count = $this->_db->getOne($sql_count);
        return array('data' => $data, 'count' => $count);
    }

    //修改卡券信息
    public function CardInfoUpdate($param) {
        $param = $this->_checkInput($param);
        $time = time();
        $start_date = strtotime($param['start_date'] . "00:00:00");
        $end_date = strtotime($param['end_date'] . "00:00:00");
        $sql = "UPDATE wx_card_info SET ";
        if (isset($param['card_name']) && !empty($param['card_name'])) {
            $sql .=" `card_name` = '{$param['card_name']}', ";
        }
        if (isset($param['card_id']) && !empty($param['card_id'])) {
            $sql .=" `card_id` = '{$param['card_id']}', ";
        }
        if (isset($param['card_num']) && !empty($param['card_num'])) {
            $sql .=" `card_num` = '{$param['card_num']}', ";
        }

        if (isset($param['type']) && !empty($param['type'])) {
            $sql .=" `type` = '{$param['type']}', ";
        }
        if (isset($param['status']) && !empty($param['status'])) {
            $sql .=" `status` = '{$param['status']}', ";
        }
        if (isset($param['file']) && !empty($param['file'])) {
            $sql .=" `card_img` = '{$param['file']}', ";
        }
        if (isset($param['card_msg']) && !empty($param['card_msg'])) {
            $sql .=" `card_msg` = '{$param['card_msg']}', ";
        }
        if (isset($start_date) && !empty($start_date)) {
            $sql .=" `from_time` = '{$start_date}', ";
        }
        if (isset($end_date) && !empty($end_date)) {
            $sql .=" `end_time` = '{$end_date}', ";
        }
        $sql .=" `update_time` = '{$time}' ";
        $sql .= " WHERE `id` = '{$param['id']}' ";
        return $this->_db->query($sql);
    }

    //卡券列表详细信息
    public function detailInfomation($openid) {
        $sql = "SELECT a.code,a.name,b.sup_num,b.tosup_num, FROM `wx_partner_info` as a left join `wx_partner_card_supplement where openid = '{$openid}'";
        $data = $this->_db->getAll($sql);
        return $data;
    }

    //卡包管理--卡包列表  导出补充记录 数据获取
    public function exportsupplement($cardid = false, $openid = false) {
        $where = "";

        if ($cardid && $openid) {
            $where = " AND a.card_id = '$cardid' and a.openid = '$openid' ";
        }
        $sql = "SELECT a.sup_sn,a.openid,b.`name`,a.create_time,a.sup_time,a.sup_num,a.tosup_num,a.card_sn,
                       a.card_id,a.card_name,a.sub_status
                FROM wx_partner_card_supplement a
                LEFT JOIN wx_partner_info b
                ON a.openid = b.openid where a.sub_status = 1 
                $where ";


        $result = $this->_db->getAll($sql);
        return $result;
    }

    //卡包管理--卡包列表  导出补充记录/导出发放明细 数据获取 
    public function exportissue($id = false, $cardid = false, $openid = false) {
        $where = " WHERE 1";
        $where = $id ? $where . " AND a.id = '$id'" : $where;
        $where = $cardid ? $where . " AND a.cardid = '$cardid'" : $where;
        $where = $openid ? $where . " AND a.openid = '$openid'" : $where;

        $sql = "SELECT a.id,b.`code`,b.`name`,a.create_time,a.issue_num,a.receiv_num,
                       a.cancel_num,c.card_sn,a.cardname,a.cardid 
                FROM wx_partner_card_send a
                LEFT JOIN wx_partner_info b 
                ON a.openid = b.openid
                LEFT JOIN wx_card_info c
                ON a.cardid = c.card_id
                $where";

        $result = $this->_db->getAll($sql);
        return $result;
    }

    //卡包管理--卡包列表  导出领取/核销记录 数据获取 status 1 领取 3核销
    public function exportdrawfl($state = 0, $cardid = false, $openid = false) {
        if (!intval($state)) {
            return false;
        }
        if($state == 1){
            $field = "";
            $join = "";
            $where = " WHERE a.state != 0";
        }else{
            $field = ",a.cancel_time,
                       CASE WHEN a.sue_id = 0 THEN a.openid 
											  ELSE d.openid END as cancelopenid,
					   CASE WHEN a.sue_id = 0 THEN a.create_time
											  ELSE d.create_time END as sendtime ";
            $join = " LEFT JOIN wx_partner_card_send d
				      ON a.sue_id = d.id ";
            $where = " WHERE a.state = $state";    
        }
        
        $where = $cardid ? $where . " AND a.cardid = '$cardid'" : $where;
        $where = $openid ? $where . " AND a.openid = '$openid'" : $where;
        $sql = "SELECT a.id,a.cardid,b.card_sn,b.card_name,a.`code` as cardcode,
                       a.create_time,a.openid,a.source_openid,c.`code` as partnercode,
                       c.`name` {$field}
                FROM wx_getcode_log a
                LEFT JOIN wx_card_info b
                ON a.cardid = b.card_id
                LEFT JOIN wx_partner_info c
                ON a.openid = c.openid
                {$join}
                {$where}
                ";

        $result = $this->_db->getAll($sql);
        return $result;
    }

    //查询允许补充的数据
    public function querySupData($id) {

        $sql = "select b.id,b.openid,a.code,a.name,b.card_id,b.card_name,b.sup_num,b.tosup_num,b.refused_msg,c.card_number,c.card_ceiling 
            from wx_partner_card_supplement b 
            join wx_partner_info a on b.openid = a.openid 
            join wx_partner_card_statistics c on c.cardid = b.card_id where b.openid = c.openid AND b.id ='{$id}' ";
        $data = $this->_db->getRow($sql);
        return $data;
    }

    /**
     * 添加数据到合伙人code表
     * 
     * @param mixed $arr
     */
    public function addPartnerCodeData($openid, $cardid, $num) {


        try {
            $time = time();
            $sql = "INSERT INTO wx_partner_card_code (openid, `status`, `code`, create_time, cardid)
                (SELECT '{$openid}', 0, `code`, '{$time}', '{$cardid}' FROM wx_card_code where card_id='{$cardid}' AND `state`=0 limit {$num})";
            $this->_db->query($sql);
            $sqlto = "UPDATE wx_card_code set `state`=1,times_used='{$time}' where card_id='{$cardid}' AND `state` = 0 limit {$num}";
            $this->_db->query($sqlto);


            //减少库存
            $sqlup = "UPDATE wx_card_info set card_num = card_num - {$num} where card_id = '{$cardid}' ";
            $this->_db->query($sqlup);
        } catch (Exception $e) {
            Logger::error('插入wx_partner_card_code表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
    }

    //修改允许补充数据
    public function updateData($id, $param) {

        try {
            $where = "`id` = '{$id}'";
            return $this->_db->update('wx_partner_card_supplement', $where, $param);
        } catch (Exception $e) {
            Logger::error('修改wx_partner_card_supplement表信息失败；sql:' . $this->_db->getLastSql(), $e->getMessage());
            return false;
        }
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
     *  查询合伙人全部记录添加到合伙人卡券统计
     * 
     * @param mixed $cardid
     * @param mixed $cardname
     */
    public function ListPartnerInfoAll($id, $cardid, $cardname) {
        
        
        $sql = "INSERT INTO wx_partner_card_statistics (card_info_id, openid, cardid, cardname, card_ceiling, card_number, card_supplement, card_issue, card_issued, card_receiv, card_cancel)
                (SELECT {$id},openid,'{$cardid}','{$cardname}', 100,0,0,0,0,0,0 FROM wx_partner_info )";
            $this->_db->query($sql);
        
    }

    /**
     * 添加合伙人卡券统计
     * 
     * @param mixed $cardid
     * @param mixed $openid
     */
    public function AddPartnerCardStatistics($openid, $cardid, $cardname) {
        $arr = array(
            'openid' => $openid,
            'cardid' => $cardid,
            'cardname' => $cardname,
            'card_ceiling' => 100,
            'card_number' => 0,
            'card_supplement' => 0,
            'card_issue' => 0,
            'card_issued' => 0,
            'card_receiv' => 0,
            'card_cancel' => 0,
        );
        try {
            return $this->_db->insert("wx_partner_card_statistics", $arr);
        } catch (Exception $e) {
            Logger::error('插入wx_partner_card_statistics表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
    }

    /**
     * 查询卡券还剩多少张
     * 
     * @param mixed $cardid
     */
    public function listCardCount($cardid) {
        $sql = "SELECT count(id) FROM wx_card_code WHERE card_id = '{$cardid}' AND state = 0 ";
        return $this->_db->getOne($sql);
    }
    
    
    /**
    * 调用合伙人核销卡券测试
    */
    public function curlCancelCardCode(){
        $sendParam = array(
            'code' => '3000010000'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://test.sh.socialjia.com/5100Partner/www/index.php?a=Cancel&m=cancelCard&str=123');
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $body = http_build_query($sendParam);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($curl);
        curl_close($curl);
        //$accessObj = json_decode($response, true);
        print_r($response);
        exit;         
    }
    
    
    /*public function testzx(){
        $sql = "select `code` from wx_getcode_log ";   
        $result = $this->_db->getAll($sql);
        foreach($result as $v){
            $sqls = "select `state` from wx_card_code where `code` = '{$v['code']}' ";   
            $st = $this->_db->getRow($sqls);
            if($st['state'] == 0){
                $sqlto = "update wx_card_code set `state` = 1,times_used = 1447999860 where `code` = '{$v['code']}' limit 1";
                $this->_db->query($sqlto);     
            }
               
            
        }
    }*/


}
