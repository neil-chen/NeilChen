<?php

class RebateModel extends Model{
    
    
    private $_db;
    private $tb_bo;//领取金额表
    private $tb_dr;//领取返利表
    private $_partnerModel;
    /**
     * 构造方法,初始化
    */
    public function __construct() {
        parent::__construct();
        $this->_db = $this->getDb();
        $this->_partnerModel = loadModel('Admin.Partner');
    }
    
    
    //获取openid 在wx_parnter_info 降序序号
    public function getopenidordernuminpartnerinfo($openid){
        $sql = "
                SELECT i
                FROM
                (
                    SELECT (@i:=@i+1) as i,wx_partner_info.*
                    FROM wx_partner_info,(SELECT @i := 0 ) tmp
                    ORDER BY wx_partner_info.create_time DESC
                ) a
                WHERE a.openid = '{$openid}'
            ";
        return $this->_db->getOne($sql);
    }
    
    public function getrebatelist($param = '', $limit = ''){

        $this->_checkInput($param);

        $having = " HAVING 1 ";
        $where = " WHERE a.state IN (1,3) ";
        if(isset($param['keyword'])&&!empty($param['keyword'])){
            $keyword = $param['keyword'];
            $where .= " AND (a.name LIKE '%{$keyword}%' OR a.code LIKE '%{$keyword}%' OR a.phone LIKE '%{$keyword}%') ";
        }
        if(isset($param['createtime'])&&!empty($param['createtime'])){
            $where.= " AND a.create_time >='" . $param['createtime'] . ' 00:00:00' . "'";
        }
        if(isset($param['end_date'])&&!empty($param['end_date'])){
            $where.= " AND a.create_time <='" . $param['end_date'] . ' 23:59:59' . "'";
        }
        if(isset($param['status']) && is_numeric($param['status'])){
            $status = $param['status'];
            $where .= " AND a.state = $status ";
        }
        if(isset($param['gendar'])&&!empty($param['gendar'])){
            $gendar = $param['gendar'];
            $where .= " AND a.sex = '$gendar' ";
        }
        if(isset($param['level'])&&!empty($param['level'])){
            $score = $this->_partnerModel->getPartnerLevel($param['level']);
            $where .= " AND a.integral >= {$score['from_score']} AND a.integral < {$score['score']}";
        }
        if(isset($param['channel'])&&!empty($param['channel'])){
            $where .= " AND a.channel = '{$param['channel']}' ";
        }
        if(isset($param['id'])&&!empty($param['id'])){
            $id = $param['id'];
            $where .= " AND a.id in (-1,$id) ";
        }

        $sql = " 
                   SELECT a.id,a.code,a.name,b.rebate_money+b.towithdraw_money+b.notaccount_money as total,
                   b.rebate_money,b.towithdraw_money,b.notaccount_money,b.summon_money,b.orderrebate_money,
                   CASE WHEN a.sex = 1 THEN '男' WHEN a.sex = 2 THEN '女' ELSE '' END AS sex,
                   a.phone,a.area,a.address,a.identity_card,a.profession,a.create_time,a.integral,
                   a.state,CASE WHEN a.state = 0 THEN '审核中'
            					WHEN a.state = 1 THEN '申请通过'
            					WHEN a.state = 2 THEN '未通过'
            					WHEN a.state = 3 THEN '冻结'
            					ELSE '' END AS statename,
            	   CASE WHEN c.`name` is null THEN '-' ELSE c.`name` END as channel,
            	   a.openid
                   FROM wx_partner_info a
                   LEFT JOIN  wx_partner_statistics b
                   ON a.openid = b.openid
                   LEFT JOIN wx_channel c
 				   ON a.channel = c.id
                   {$where}
                   ORDER BY a.create_time DESC
                   {$limit}";

        try{
           $result = $this->_db->getAll($sql);
        }catch(Exception $e){
            Logger::error($e->getMessage()."<br/>".$this->_db->getLastSql());
            return false;
        }
        return $result;
    }
    
    public function getrebatelistcount($param=''){
        $sql = "SELECT count(*) FROM wx_partner_info ";
        if(!empty($param)){
            $param = $this->_checkInput($param);
        }  
        $where = " WHERE a.state IN (1,3) ";
        if(isset($param['keyword'])&&!empty($param['keyword'])){
            $keyword = $param['keyword'];
            $where .= " AND (name LIKE '%{$keyword}%' OR code LIKE '%{$keyword}%' OR phone LIKE '%{$keyword}%') ";
        }
        if(isset($param['createtime'])&&!empty($param['createtime'])){
            $where.= " AND create_time >='" . $param['createtime'] . ' 00:00:00' . "'";
        }
        if(isset($param['end_date'])&&!empty($param['end_date'])){
            $where.= " AND create_time <='" . $param['end_date'] . ' 23:59:59' . "'";
        }
        if(isset($param['status'])&&!empty($param['status'])){
            $status = $param['status'];
            $where .= " AND state = $status ";
        }
        if(isset($param['gendar'])&&!empty($param['gendar'])){
            $gendar = $param['gendar'];
            $where .= " AND sex = '$gendar' ";
        }
        if(isset($param['level'])&&!empty($param['level'])){
            $level = $param['level'];
            $where .= " AND grade = '$level' ";
        }
        if(isset($param['channel'])&&!empty($param['channel'])){
            $channel = $param['channel'];
            $where .= " AND channel = '$channel' ";
        }
          
        
        try{
            $result = $this->_db->getOne($sql.$where);
        }catch(Exception $e){
            Logger::error($e->getMessage()."<br/>".$this->_db->getLastSql());
            return false;
        }
        return $result;
    }
    
    public function getgetcashlistcount($param=''){
        if(!empty($param)){
            $param = $this->_checkInput($param);
        }
        $where = "";
        if(isset($param['keyword'])&&!empty($param['keyword'])){
            $keyword = $param['keyword'];
            $where .= " AND (b.name LIKE '%{$keyword}%' OR b.code LIKE '%{$keyword}%' OR b.phone LIKE '%{$keyword}%') ";
        }
        if(isset($param['createtime'])&&!empty($param['createtime'])){
            $where.= " AND a.create_time >='" . $param['createtime'] . ' 00:00:00' . "'";
        }
        if(isset($param['end_date'])&&!empty($param['end_date'])){
            $where.= " AND a.create_time <='" . $param['end_date'] . ' 23:59:59' . "'";
        }
        if(isset($param['status'])&&!empty($param['status'])||$param['status'] ==='0'){
            $status = $param['status'];
            $where .= " AND a.state = $status ";
        }
        if(isset($param['gendar'])&&!empty($param['gendar'])){
            $gendar = $param['gendar'];
            $where .= " AND b.sex = '$gendar' ";
        }
        if(isset($param['level'])&&!empty($param['level'])){
            $score = $this->_partnerModel->getPartnerLevel($param['level']);
            $where .= " AND b.integral >= {$score['from_score']} AND b.integral < {$score['score']}";
        }
        if(isset($param['channel'])&&!empty($param['channel'])){
            $channel = $param['channel'];
            $where .= " AND b.channel = '$channel' ";
        }
        
        $sql = "SELECT count(*) 
                FROM wx_bonus_draw a
                LEFT JOIN wx_partner_info b
                ON a.openid = b.openid
                WHERE 1 $where ";
        try{
            $result = $this->_db->getOne($sql);
            
        }catch(Exception $e){
            Logger::error($e->getMessage()."<br/>".$this->_db->getLastSql());
            return false;
        }
        return $result;
    }
    
    public function getgetcashlist($param = '' ,$limit =''){
        if(!empty($param)){
            $param = $this->_checkInput($param);
        }
        $where = "";
        if(isset($param['keyword'])&&!empty($param['keyword'])){
            $keyword = $param['keyword'];
            $where .= " AND (b.name LIKE '%{$keyword}%' OR b.code LIKE '%{$keyword}%' OR b.phone LIKE '%{$keyword}%') ";
        }
        if(isset($param['createtime'])&&!empty($param['createtime'])){
            $where.= " AND a.create_time >='" . $param['createtime'] . ' 00:00:00' . "'";
        }
        if(isset($param['end_date'])&&!empty($param['end_date'])){
            $where.= " AND a.create_time <='" . $param['end_date'] . ' 23:59:59' . "'";
        }
        if(isset($param['status'])&&(!empty($param['status'])||$param['status'] ==='0')){
            $status = $param['status'];
            $where .= " AND a.state = $status ";
        }
        if(isset($param['gendar'])&&!empty($param['gendar'])){
            $gendar = $param['gendar'];
            $where .= " AND b.sex = '$gendar' ";
        }
        if(isset($param['level'])&&!empty($param['level'])){
            $score = $this->_partnerModel->getPartnerLevel($param['level']);
            $where .= " AND b.integral >= {$score['from_score']} AND b.integral < {$score['score']}";
        }
        if(isset($param['channel'])&&!empty($param['channel'])){
            $channel = $param['channel'];
            $where .= " AND b.channel = '$channel' ";
        }
        if(isset($param['id'])&&!empty($param['id'])){
            $id = $param['id'];
            $where .= " AND a.id in (-1,$id) ";
        }
        
        $sql = "SELECT b.`code`,b.`name`,a.create_time,a.money,a.rebate_money,a.cancel_time,a.state as bonusstate,
                    CASE WHEN a.state = 0 THEN '待执行'
                         WHEN a.state = 1 THEN '执行成功'
                         WHEN a.state = 2 THEN '已拒绝'
                ELSE '' END as bonusstatename,
    			a.id,a.tradeNo,'微信支付流水号',
                CASE WHEN b.sex = 1 THEN '男' WHEN b.sex = 2 THEN '女' ELSE '' END AS sex,b.phone,b.area,
                b.address,b.identity_card,b.profession,b.create_time as partner_create_time,
                b.integral,
			    b.state as partnerstate,
				CASE WHEN b.state = 0 THEN '审核中'
				WHEN b.state = 1 THEN '申请通过'
				WHEN b.state = 2 THEN '未通过'
				WHEN b.state = 3 THEN '冻结'
				ELSE '' END AS partnerstatename,
			    CASE WHEN c.`name` is null THEN '-' ELSE c.`name` END as channel
                FROM wx_bonus_draw a
                LEFT JOIN wx_partner_info b
                ON a.openid = b.openid
                LEFT JOIN wx_channel c
				ON b.channel = c.id
                WHERE 1 $where
                ORDER BY a.create_time DESC
                $limit";
        
       try{
           $result = $this->_db->getAll($sql);
        }catch(Exception $e){
            Logger::error($e->getMessage()."<br/>".$this->_db->getLastSql());
            return false;
        }
        return $result;      
    }
    
    public function getlevellist(){
        $sql = "SELECT * FROM wx_partner_level ";
        $result = $this->_db->getAll($sql);
        return $result;
    }
    public function getchannellist(){
        $sql = "SELECT * FROM wx_channel ";
        $result = $this->_db->getAll($sql);
        return $result;
    }
    
    //允许提现 联动调整 统计表中的 数值 
    public function agreegetcash($ids){

        $ids = $this->_db->escape($ids); 
        $sql = "SELECT `id`, `openid`, `money` FROM wx_bonus_draw WHERE id in (-1, {$ids})  AND `state`= 0 ";
        $result = $this->_db->getAll($sql);
        if (empty($result)) {
            $this->setError(null, '选择的数据不存在或已处理！');
            return false;
        }

        // 循环处理批量提现
        foreach ($result as $val) {

            // 交易流水号生成
            $tradeNo = date('YmdHis') . uniqid(TRUE) . mt_rand(1000, 9999);

            $set = array(
                'state'       => 1,
                'tradeNo'     => $tradeNo,
                'cancel_time' => date('Y-m-d H:i:s'),
            );

            // 给用户支付提现
            $payResult = $this->_sendEnvelope($val['openid'], $val['money'], $tradeNo);
            if($payResult['result_code'] == 'SUCCESS'){
 
                if ($this->_db->update('wx_bonus_draw', " `id`={$val['id']} AND `openid`='{$val['openid']}'", $set)) {
                    $sql = "UPDATE wx_partner_statistics SET rebate_money = rebate_money - {$val['money']}, towithdraw_money = towithdraw_money + {$val['money']} WHERE `openid` = '{$val['openid']}' ";
                    if (!$this->_db->query($sql)) {
                        Logger::debug('更新用户余额失败！ -> ', $sql);

                        $this->setError(null, '更新用户余额失败！');
                        return false;
                    }
                }
            } else {
                $this->setError(null, $payResult['err_code_des']);
                return false;
            }
        }

        return true;
    }

    //拒绝提现
    public function refusegetcash($id){
      $id = $this->_db->escape($id); 
        $set = array('state' => 2,'cancel_time'=> date('Y-m-d H:i:s'));
        $where = " id in (-1,$id)  ";
        
        $sql = "SELECT openid,money FROM wx_bonus_draw WHERE $where ";
        $result = $this->_db->getAll($sql);
        
        if($this->_db->update('wx_bonus_draw', $where, $set)){
            foreach($result as $value){
                $sql = "UPDATE wx_partner_statistics
                        SET notaccount_money = notaccount_money - {$value['money']}
                        WHERE openid = '{$value['openid']}' ";
                $result = $this->_db->query($sql);
            }
            return true;
        }else{
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
    
    
    //导出 所有两边返利明细
    public function gettworebate($openid=''){
        $where = "";
        $where2 = "";
        if (empty($openid)) {
            $where = "";
            $where2 = "";
        } else {
            //$openid = $this->_checkInput($openid);
            $where = " WHERE a.invitation_open_id in ('-1', $openid) ";
            $where2 = " WHERE g.source_openid in ('-1', $openid) ";
        }
        
        $sql = "
            SELECT b.code,b.phone, a.open_id, b.name wx_name,'朋友召唤返利' as type,a.money,'' as order_id,
                   '' as cardid,'' as cardname, a.invitation_open_id, a.wx_name as inv_name,
                   a.create_time,a.score 
            FROM  wx_partner_invitation a
            LEFT JOIN  wx_partner_info b
            ON a.invitation_open_id = b.openid
            $where
            UNION  
            SELECT b.code,b.phone, b.openid AS open_id,b.`name` AS wx_name,'卡券核销返利' AS TYPE,
            a.money,a.order_no, a.card_id, a.card_code,'' AS invitation_open_id,'' AS inv_name,
                   a.create_time,a.score 
            FROM wx_bonus_order a
            JOIN wx_getcode_log g ON a.card_code = g.code
            JOIN wx_partner_info b ON g.source_openid = b.openid 
            $where2
            ";

        $result = $this->_db->getAll($sql);
        return $result;
    }
    
    public function getGetCashDetail($openid = ''){
        if(!empty($openid)){
            $where = "WHERE b.openid in (-1,$openid) ";
        }else{
            $where = "";
        }
        
        $sql = "
                SELECT b.`code`,b.`name`,b.phone,a.create_time,a.cancel_time,a.money
                FROM wx_bonus_draw a
                LEFT JOIN wx_partner_info b
                ON a.openid = b.openid
                $where
        ";
         
        $result = $this->_db->getAll($sql);
        return $result;
    }
    
    
    /**
     * 合伙人返利
     * @param type $openid 用户openid
     * @param type $money 提现金额
     * @param type $state
     * @return type
     */
    private function _sendEnvelope($openid, $money,  $tradeNo = '', $state = 0) {

        $sendRes = true;
        $money = $money * 100;
        $param['nonce_str'] = '5100Skincare';
        $param['partner_trade_no'] = $tradeNo;
        $param['openid'] = $openid;
        $param['check_name'] = "NO_CHECK";
        $param['amount'] = $money;
        $param['desc'] = "返利";
        $sendRes = $this->_sendPacket($param);
        return $sendRes;
    }

    /**
     * 发送红包base
     * 
     * @param array $param
     * 
     * @return object
     */
    private function _sendPacket($param) {
        //第一个参数是商户appid，第二个参数是财付通密钥(PartnerKey)，第三个参数为财会通商户号(PartnerID)
        $packet = new WeiPayPacketNew(C("APP_ID"), C("WX_PARTNERKEY"), C("WX_PARTHERID"));
        Logger::debug('5100返利红包接口' . $param['openid'], $param);
        $res = $packet->sendPacket($param); //调用发送红包方法

        $objXml = simplexml_load_string($res);

        Logger::debug('5100返利红包接口返回', $res);

        if ($objXml->return_code != 'SUCCESS') {
            Logger::error('5100返利红包接口调用失败' . $param['openid'], $res);
        }

        // 转账日志
        $insert = array(
            'open_id'          => $param['openid'],
            'money'            => number_format(($param['amount'] / 100), 2),
            'pay_id'           => !isset($objXml->pay_id)           ? '' : (string) $objXml->pay_id,
            'mch_appid'        => !isset($objXml->mch_appid)        ? '' : (string) $objXml->mch_appid,
            'mchid'            => !isset($objXml->mchid)            ? '' : (string) $objXml->mchid,
            'nonce_str'        => !isset($objXml->nonce_str)        ? '' : (string) $objXml->nonce_str,
            'result_code'      => !isset($objXml->result_code)      ? '' : (string) $objXml->result_code,
            'partner_trade_no' => $param['partner_trade_no'],
            'payment_no'       => !isset($objXml->payment_no)       ? '' : (string) $objXml->payment_no,
            'payment_time'     => !isset($objXml->payment_time)     ? null : (string) $objXml->payment_time,
            'return_msg'       => !isset($objXml->return_msg)       ? '' : (string) $objXml->return_msg,
            'return_code'      => !isset($objXml->return_code)      ? '' : (string) $objXml->return_code,
            'err_code_des'     => !isset($objXml->err_code_des)     ? '' : (string) $objXml->err_code_des,
            'create_time'      => date('Y-m-d H:i:s'),
        );

        $this->_db->insert('wx_pay_log', $insert);

        return array(
            'result_code'      => (string) $objXml->result_code,
            'err_code_des'     => !isset($objXml->err_code_des)     ? '' : (string) $objXml->err_code_des,
            'partner_trade_no' => !isset($objXml->partner_trade_no) ? '' : (string) $objXml->partner_trade_no,
            'payment_no'       => !isset($objXml->payment_no)       ? '' : (string) $objXml->payment_no,
        );
    }
}