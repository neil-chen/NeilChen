<?php

class CardtoModel extends Model {

    protected $_db;
    
    private $_config = array(); 
    private $_cardConfig = array(); 
    private $_redis;
    private $_rows = 5;  //redis最大存储5000个code

    public function __construct() {
        parent::__construct();
        
        //链接redis
        $this->_redis = new Redis();
        $host = C('REDIS_HOST');
        $port = C('REDIS_PORT');
        try {
            $this->_redis->connect($host, $port);
        } catch (Exception $e) {
            Logger::error('初始化redis失败', $e->getMessage());
        }
        $this->_config = array(
            '0' => "初始",
            '1' => "审核通过",
            '2' => "审核未通过",
        );
        $this->_cardConfig = array(
            '0' => "发放",
            '1' => "领取",
            '2' => "赠送",
            '3' => "核销",
        );
        
        $this->_db = $this->getDb();
    }
    
    
    /**
     * 检查存储code
     * return int
     */
    public function getCode() {
        // 获取队列长度
        $size = $this->_redis->lSize('5100_card_code');
        if ($size < 2) {
            $sql = "SELECT code FROM wx_card_code WHERE state=0 ORDER BY `id` ASC limit " . $this->_rows;
            $data = $this->_db->getAll($sql);

            if (!$data) {
                return false;
            }

            foreach ($data as $value) {
                // 检查该券码是否在队列里
                $this->_redis->lRem('5100_card_code', $value['code'], 0);
                $this->_redis->rPush('5100_card_code', $value['code']);
            }
        }
        return true; 
    }
    
     /**
     * 获取对应的一个code
     */
    public function getOneCode() {
        $result = array(
            'error' => 0
        );

        // 检查队列长度
        $numResult = $this->getCode();
        if (!$numResult) {
            return 'no_draw';
        }
        
        $coupons_no = $this->_redis->lPop('5100_card_code');
        // 判断队列返回结果
        if (!$coupons_no) {
            $result['coupons_no'] = $coupons_no;
            $result['error'] = 1;
            $result['msg'] = '获取code失败，请重新获取';
            return $result;
        }

        $this->upCode($coupons_no);    //修改code状态

        $result['coupons_no'] = $coupons_no;
        return $result;
    }
    
    

    /**
     * 更新code状态
     * return int
     */
    public function upCode($code) {
        try {

            return $this->_db->update("wx_card_code", "`code`='" . $code . "'", array(
                        'state' => 1,
                        'times_used' => time()
            ));
        } catch (Exception $e) {
            Logger::error('更新wx_card_code表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
    }
    
    
    /**
    * 添加卡券信息状态
    */
    public function addCard($data){
        try{
            return $this->_db->insert('wx_user_card',$data);
        }catch (Exception $e){
            Logger::error('添加卡券表失败；sql:'.$this->_db->getLastSql(), $e->getMessage());
            return false;
        } 
    }
 
    /**
     * 获取分享人分享的code
     * return int
     */
    public function getShareCode($openid)
    {
        $sql = "SELECT `card_code` FROM wx_user_card WHERE openid='" . $openid . "'";
        $rs = $this->_db->getOne($sql);
        if ($rs) {
            return $rs;
        }
        return false;
    }
    
    /**
    *  根据cardid查询卡券详细
    */
    public function listCardInfo($cardid){
        $sql = "SELECT * FROM wx_card_info WHERE card_id = '{$cardid}'";    
        return $this->_db->getRow($sql);
        
    }
    
    
    /**
    * 根据卡券id查询合伙人卡券信息
    * 
    * @param mixed $openid
    * @param mixed $cardid
    */
    public function listCardOne($openid, $cardid){
        $sql = "SELECT a.openid, a.cardid, a.cardname, a.card_ceiling, a.card_number, a.card_supplement, a.card_issue, a.card_issued, a.card_receiv, a.card_cancel,b.card_msg, 
        b.from_time, b.end_time 
        FROM wx_partner_card_statistics a 
        JOIN wx_card_info b ON a.cardid = b.card_id WHERE a.openid='" . $openid . "' AND a.cardid='" . $cardid . "'";
        $rs = $this->_db->getRow($sql);
        if ($rs) {
            return $rs;
        }
        return false;        
    }
    
    /**
    * 查询合伙人卡券信息
    * 
    * @param mixed $openid
    */
    public function listCardAll($openid, $cards = false){
        $sql = "SELECT a.openid, a.cardid, b.card_name, a.card_ceiling, a.card_number, a.card_supplement, a.card_issue, a.card_issued, a.card_receiv, a.card_cancel, 
        b.from_time, b.end_time 
        FROM wx_partner_card_statistics a 
        JOIN wx_card_info b ON a.cardid = b.card_id WHERE a.openid = '{$openid}'";
        
        if ($cards) {
            $sql .= " AND a.card_info_id IN ({$cards}) ";
        }
        
        $rs = $this->_db->getAll($sql);
        if ($rs) {
            return $rs;
        }
        return false;        
    }
    
    
    
    
    /**
    * 删除redis
    */
    public function delRedisData(){
        $this->_redis->del('5100_card_code');
    }
    
    /**
    * 合伙人发放卡券
    * 
    * @param mixed $cardid
    * @param mixed $openid
    * @param mixed $data
    */
    public function addIssueCard($cardid, $openid, $data){
        $cardinfo = $this->listCardInfo($cardid);
        $arr = array(
            'openid' => $openid,
            'cardid' => $cardid,
            'cardname' => $cardinfo['card_name'],
            'issue_num' => $data['issuenum'],
            'limit_num' => $data['limitnum'],
            'cancel_num' => 0,
            'receiv_num' => 0,
            'create_time' => time(),
        );
        try {
            return $this->_db->insert("wx_partner_card_send", $arr);
        } catch ( Exception $e ) {
            Logger::error('插入wx_partner_card_send表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }    
    }
    
    /**
    * 根据id查询合伙人发放
    *  
    * @param mixed $id
    */
    public function listPartnerCardIssue($id){
        $sql = "SELECT id,openid,limit_num,issue_num,receiv_num FROM wx_partner_card_send WHERE id = '{$id}' ";
        $res = $this->_db->getRow($sql);
        return $res;    
    }
    
    /**
    * 查询用户领取的卡券数量
    * 
    * @param mixed $openid
    * @param mixed $sue_id
    */
    public function listCardCodeCount($openid,$sue_id){
        $sql = "SELECT count(id) FROM wx_getcode_log WHERE openid= '{$openid}' AND sue_id= '{$sue_id}' ";
        $res = $this->_db->getOne($sql);
        if(empty($res)){
            $res = 0;   
        }
        return $res;        
    }
    
    /**
    * 修改合伙人卡券统计数量
    * 
    */
    public function upPartnerCardStatistics($cardid, $openid, $data){
        try {
            $where = "`openid` = '{$openid}' AND `cardid` = '{$cardid}' ";
            return $this->_db->update('wx_partner_card_statistics', $where, $data);
        } catch (Exception $e) {
            Logger::error('修改wx_partner_card_statistics表信息失败；sql:' . $this->_db->getLastSql(), $e->getMessage());
            return false;
        }
    }
    
    
    /**
    * 根据openid查询合伙人统计详情
    * 
    * @param mixed $openid
    */
    public function listPartnerStatisticsOne($openid, $cards = false){
        $sql = "SELECT ps.openid, ps.par_number,
            ps.par_supplement, ps.par_issue, ps.par_issued,
            ps.par_receiv, ps.par_cancel, 
            COUNT(ps.id) AS par_species
          FROM
            wx_partner_statistics ps 
            JOIN wx_partner_card_statistics cs ON ps.openid = cs.openid
          WHERE ps.openid = '{$openid}' ";
        if ($cards) {
            $sql .= " AND cs.card_info_id IN ({$cards}) ";
        }
        $res = $this->_db->getRow($sql);
        
        return $res;
    }
    
    
    /**
    * 修改合伙人统计数量
    * 
    */
    public function upPartnerStatistics($openid, $data){
        try {
            $where = "`openid` = '{$openid}' ";
            return $this->_db->update('wx_partner_statistics', $where, $data);
        } catch (Exception $e) {
            Logger::error('修改wx_partner_statistics表信息失败；sql:' . $this->_db->getLastSql(), $e->getMessage());
            return false;
        }
    }     
    
    
    /**
    * 根据合伙人openid，cardid获取code
    * 
    * @param mixed $openid
    * @param mixed $cardid
    */
    public function getPartnerCardCode($cardid, $openid){   
        
        $sql = "SELECT openid,status,code,create_time,cardid FROM wx_partner_card_code WHERE openid = '{$openid}' AND cardid = '{$cardid}' AND status = 0 ";
        $res = $this->_db->getRow($sql);
        return $res;       
    }
    
    
    /**
    *  修改卡券状态
    */
    public function upPartnerCardCode($code){
        $data = array(
            'status' => 1
        );     
        try {
            $where = "`code` = '{$code}'";
            return $this->_db->update('wx_partner_card_code', $where, $data);
        } catch (Exception $e) {
            Logger::error('修改wx_partner_card_code信息失败；sql:' . $this->_dbHost->getLastSql(), $e->getMessage());
            return false;
        }   
    }
    
    
    
    /**
    * 根据合伙人openid，cardid获取code
    * 
    * @param mixed $openid
    * @param mixed $cardid
    * @param mixed $sue_id
    */
    public function getDrawflCardCode($cardid, $usopenid, $sue_id = ''){
        $where = '';
        if(!empty($sue_id)){
            $where = " AND sue_id = '{$sue_id}' ";    
        }
        
        $sql = "SELECT openid,source_openid,state,code,create_time,receive_time,cardid,status_num FROM wx_getcode_log WHERE source_openid = '{$usopenid}' AND cardid = '{$cardid}' AND state = 0 " . $where ." group by status_num";
        $res = $this->_db->getRow($sql);
        return $res;       
    }
    
    /**
    * 根据code修改状态为展示中
    * 
    * @param mixed $code
    */
    public function upCardCodeStatus($code, $arr){  
        
        
        try {
            $where = "`code` = '{$code}' ";
            return $this->_db->update('wx_getcode_log', $where, $arr);
        } catch (Exception $e) {
            Logger::error('修改wx_getcode_log表信息失败；sql:' . $this->_db->getLastSql(), $e->getMessage());
            return false;
        }        
    }
    
    /**
    * 查询卡券发放记录
    * 
    * @param mixed $openid
    * @param mixed $pagesize
    * @param mixed $page
    */
    public function listIssueCardlog($cardid, $openid, $page){
        $pagesize = 8;
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;       
        $sql = "SELECT id,create_time,openid,cardid,cardname,issue_num,limit_num,receiv_num FROM wx_partner_card_send WHERE openid = '{$openid}' AND cardid = '{$cardid}' ORDER BY id DESC LIMIT {$limit}, {$pagesize}";
                                                            
        $data = $this->_db->getAll($sql);  
        if ($data) {
            $now = time();                
            foreach ($data as $k => $v) {
                $data[$k]['create_time'] = date("Y-m-d", $v['create_time']); 
            }
        }
        return $data;    
    }
    
    
    /**
    * 查询自己卡券领取记录
    * 
    * @param mixed $openid
    * @param mixed $pagesize
    * @param mixed $page
    */
    public function listIssueCardUslog($cardid, $openid, $page){
        $pagesize = 8;
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;       
        $sql = "SELECT receive_time FROM wx_getcode_log WHERE openid = '{$openid}' AND cardid = '{$cardid}' ORDER BY id DESC LIMIT {$limit}, {$pagesize}";
                                                            
        $data = $this->_db->getAll($sql);  
        if ($data) {
            $now = time();                
            foreach ($data as $k => $v) {
                $data[$k]['receive_time'] = date("Y-m-d", $v['receive_time']); 
            }
        }
        return $data;    
    }
    
    /**
    * 计算总数
    * 
    */
    public function listIssueCardlogCount($cardid, $openid){
        $sql = "SELECT sum(issue_num) as issuenum,sum(receiv_num) as receivnum FROM wx_partner_card_send  WHERE openid = '{$openid}' AND cardid = '{$cardid}' ";
        $data = $this->_db->getRow($sql); 
        if(empty($data['issuenum'])) $data['issuenum'] = 0;
        if(empty($data['receivnum'])) $data['receivnum'] = 0;
        
        $count_sql = "SELECT count(*) FROM (SELECT id FROM wx_partner_card_send WHERE openid = '{$openid}' AND cardid = '{$cardid}' ) AS t";
        
        $count = $this->_db->getOne($count_sql);

        return array('count' => $count, 'data' => $data);
           
    }
    
    public function listIssueCardUslogCount($cardid, $openid){
        $sql = "SELECT count(id) FROM wx_getcode_log  WHERE openid = '{$openid}' AND cardid = '{$cardid}' ";
        return $this->_db->getOne($sql); 
           
    }
    
    /**
    *   卡券追踪 -- 统计数据
    *    
    * @param mixed $openid
    * @param mixed $cardid
    */
    public function listCardTrackingCount($cardid,$openid){
        
        //卡券补充数
        $bcsql = "SELECT card_supplement,card_receiv,card_cancel,card_issued FROM wx_partner_card_statistics WHERE  openid = '{$openid}' AND cardid = '{$cardid}'";
        return $this->_db->getRow($bcsql);
        
    }
    
    
    /**
    * 查询卡券补充记录
    * 
    * @param mixed $openid
    * @param mixed $pagesize
    * @param mixed $page
    */
    public function listSupCardlog($cardid, $openid, $page){
        $pagesize = 8;
        $page = $page ? $page : 1;
        $limit = abs((intval($page) - 1)) * $pagesize;       
        $sql = "SELECT create_time,sup_num,sub_status,tosup_num FROM wx_partner_card_supplement WHERE openid = '{$openid}' AND card_id = '{$cardid}'  ORDER BY id DESC LIMIT {$limit}, {$pagesize}";
        $data = $this->_db->getAll($sql);  
        if ($data) {
            $now = time();                
            foreach ($data as $k => $v) {
                $data[$k]['create_time'] = date("Y-m-d", $v['create_time']);
                $data[$k]['sub_status'] = $this->_config[$v['sub_status']];
            }
        }
        
        
        return $data;    
    }
    
    
    

    
    /**
    * 查询卡券是否已经申请
    * 
    * @param mixed $cardid
    * @param mixed $openid
    */
    public function listPartnerCard($cardid, $openid){
        $sql = "SELECT sup_sn,openid,card_sn,card_id,card_name,sup_num,sup_type,sub_status,tosup_num,create_time,sup_time,refused_msg FROM wx_partner_card_supplement WHERE openid = '{$openid}' AND card_id = '{$cardid}' ORDER BY id DESC";
                                                            
        $data = $this->_db->getRow($sql);   
        return $data;     
    }
    
    /**
    * 检查卡券是否能申请
    * 
    * @param mixed $cardid
    * @param mixed $openid
    */
    public function checkPartnerCard($cardid, $openid){
        $sql = "SELECT openid,cardid,cardname,card_ceiling,card_number,card_supplement,card_issue,card_issued,card_receiv,card_cancel FROM wx_partner_card_statistics WHERE openid = '{$openid}' AND cardid = '{$cardid}' ";
                                                            
        $data = $this->_db->getRow($sql);   
        return $data;     
    }
    
    /**
    * 添加卡券申请
    * 
    */
    public function addPartnerCardSup($cardid, $openid, $data){
        $cardinfo = $this->listCardInfo($cardid);
        $sup_sn = 'BC'.time();
        $arr = array(
            'sup_sn' => $sup_sn,
            'openid' => $openid,
            'card_sn' => $cardinfo['card_sn'],
            'card_id' => $cardid,
            'card_name' => $cardinfo['card_name'],
            'sup_num' => $data['card_ceiling'] - $data['card_number'],
            'sup_type' => '0',
            'sub_status' => 0,
            'tosup_num' => 0,
            'create_time' => time(),
            'sup_time' => 0,
            'refused_msg' => '',
        );
        try {
            return $this->_db->insert("wx_partner_card_supplement", $arr);
        } catch ( Exception $e ) {
            Logger::error('插入wx_partner_card_supplement表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
    }
    
    
    /**
    * 添加卡券发放数据记录
    * @param mixed $issueid
    * @param mixed $cardid
    * @param mixed $openid
    * @param mixed $issuenum        //发多少张
    */
    public function addDrawfl($issueid, $cardid, $openid, $issuenum, $type = 1){
        $time = date('Y-m-d H:i:s', time());
        try {
            //插入记录到发放列表
            $sql = "INSERT INTO wx_getcode_log (openid, source_openid, state, `code`, create_time, receive_time, cardid, sue_id, status_num)
                (SELECT '','{$openid}', 0, `code`, '{$time}', '0', '{$cardid}', '{$issueid}',0 FROM wx_partner_card_code where cardid='{$cardid}' AND openid='{$openid}' AND `status` = 0 limit {$issuenum} )";
            Logger::debug('插入wx_getcode_log表数据:', $sql);
            $this->_db->query($sql);
            //更改状态
            $sqlto = "UPDATE wx_partner_card_code SET `status` = 2 WHERE `code` IN (SELECT `code` FROM wx_getcode_log)";
            $this->_db->query($sqlto);
        } catch ( Exception $e ) {
            Logger::error('插入wx_getcode_log表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
        return true;
    }
    
    /**
    * 添加到领取记录
    * 
    * @param mixed $cardid
    * @param mixed $openid
    * @param mixed $code
    */
    public function addDrawflInfo($cardid, $openid, $code){
        $arr = array(
            'openid' => $openid,
            'source_openid' => $openid,
            'state' => 1,
            'code' => $code,
            'create_time' => date('Y-m-d H:i:s', time()),
            'receive_time' => time(),
            'cardid' => $cardid,
            'sue_id' => 0,
            'status_num' => 0
        );   
         
        try {
            $this->_db->insert('wx_getcode_log', $arr);
            
        } catch ( Exception $e ) {
            Logger::error('插入wx_getcode_log表数据error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
    }
    
    
    
    
     /**
    *  修改卡券状态
    *   $type 领取或赠送
    */
    public function upCardDrawfl($code, $openid,$usopenid = '', $type = 1){
        $data = array(
            'openid' => $openid,
            'state' => $type,
            'receive_time' => time()
        );     
        
        try {
            $where = "`code` = '{$code}'";
            if(!empty($usopenid)){
                $where .= " AND source_openid = '{$usopenid}'";   
            }
            return $this->_db->update('wx_getcode_log', $where, $data);
        } catch (Exception $e) {
            Logger::error('根据code修改用户卡券信息失败；sql:' . $this->_dbHost->getLastSql(), $e->getMessage());
            return false;
        }   
    }
    
    /**
    * 根据code查询wx_getcode_log数据
    * 
    * @param mixed $code
    */
    public function listDrawflCode($code){
        $sql = "SELECT openid,source_openid,state,receive_time,create_time,cardid FROM wx_getcode_log WHERE code = '{$code}' limit 1";
                                                            
        $data = $this->_db->getRow($sql); 
         
        return $data;    
    }
    
    
    /**
    * 查询发放记录
    * 
    * @param mixed $id
    */
    public function listIssueCardWeb($id){
        $sql = "SELECT a.id,a.openid,a.issue_num,b.card_name,b.from_time,b.end_time,b.card_id     
            FROM wx_partner_card_send a JOIN wx_card_info b ON a.cardid = b.card_id 
            WHERE a.id={$id} ";
        return $this->_db->getRow($sql); 
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
     * 根据openid查询合伙人
     * @param int $openid
     */
    public function getOpenidPartner($openid) {

        $sql = "select integral from wx_partner_info where openid = '{$openid}' ";
        return $this->_db->getRow($sql);
    }
    
    /**
     * 更新合伙人可持有卡券数量
     * @param type $openid 
     * @param type $card_max 可持有卡券总数
     * @return type
     */
    public function updateCardMaxByLevel($openid, $card_max) {
         try {
            return $this->_db->update("wx_partner_card_statistics", " openid = '{$openid}' ", array('card_ceiling' => $card_max));
        } catch (Exception $e) {
            Logger::error('更新wx_partner_card_statistics表卡券持有上限error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
        return;
    }
    
    
    /**
    *   根据openid查询合伙人卡券统计一条数据
    * $openid  
    */
    public function getParCardStuOne($openid){
        
        $sql = "select card_ceiling from wx_partner_card_statistics where openid = '{$openid}' limit 1 ";
        return $this->_db->getRow($sql);    
    }
    
    
    /**
    *   合伙人升级查询卡券
    */
    public function upgradePerform($ids,$openid){
        $sql = "select * from wx_card_info where id in ({$ids}) and id not in (select card_info_id from wx_partner_card_statistics where openid='{$openid}' GROUP BY card_info_id);";
        return $this->_db->getAll($sql);
    }
    
    
    
    /**
    * 更改合伙人卡券发放数据
    */
    public function upParCardSend($id){
        $sql = "UPDATE wx_partner_card_send set receiv_num = receiv_num+1 where id = {$id} ";
        return $this->_db->query($sql);        
    }
    
    /**
    * 更改合伙人统计卡券类型
    */
    public function upParStuCardTypeNum($openid,$num){
        $sql = "UPDATE wx_partner_statistics set par_species = par_species+{$num} where openid = '{$openid}' ";
        return $this->_db->query($sql);        
    }
    
    
    
    /**
    *   合伙人升级查询卡券
    */
    public function listGetCodeLog($code){
        $sql = "select state from wx_getcode_log where `code`='{$code}' limit 1";
        return $this->_db->getRow($sql);
    }
    
    
    /**
     * 根据code卡券核销
     */
    public function upCancelCard($code) {
         try {
            return $this->_db->update("wx_getcode_log", " `code` = '{$code}' ", array('state' => 3,'cancel_time'=>time()));
        } catch (Exception $e) {
            Logger::error('更新wx_getcode_log表核销error: ' . $e->getMessage() . '; sql:' . $this->_db->getLastSql());
            return false;
        }
        return;
    }
    
    
    /**
    * 判断卡券是否过期
    * 
    * @param mixed $cardid
    */
    public function checkCardSend($cardid){
        $ret = $this->_db->getRow("select end_time,status from wx_card_info where `card_id`='{$cardid}' limit 1");       
        $time = time();
        if($time > $ret['end_time']){
            return false;    
        }
        return $ret;
    }
    
    /**
    * 添加卡券补充   卡券统计和合伙人统计
    * 
    * @param mixed $cardid
    * @param mixed $openid
    */
    public function upParOrCardStu($cardid, $openid){
        //合伙人卡券统计
        $sqlcard = "UPDATE wx_partner_card_statistics SET card_supplement = card_supplement+1 WHERE openid = '{$openid}' AND cardid = '{$cardid}' ";
        $this->_db->query($sqlcard);  
        
        //合伙人统计
        $sqlpar = "UPDATE wx_partner_statistics SET par_supplement = par_supplement+1 WHERE openid = '{$openid}' ";
        $this->_db->query($sqlpar);      
    }
    
    /**
    * 检查code是否使用
    * 
    * @param mixed $code
    */
    public function checkCode($code){
            
    }
    

    

}
