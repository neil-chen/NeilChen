<?php

class CardAction extends AdminAction {

    private $_Model;
    private $_IndexModel;
    private $_name = null;
    private $_from = null;
    private $_to = null;
    private $_status = null;
    private $_p = null;
    private $_state = null;
    private $_sex = null;
    private $_grade = null;
    private $_channel = null;
    private $_openid = null;
    private $_a = null;
    private $_m = null;
    private $pagesize =20;

    /**
     * 构造方法，初始化
     */
    public function __construct() {
        parent::__construct();
        $this->_name = $this->getParam('cname');
        $this->_from = $this->getParam('from');
        $this->_to = $this->getParam('to');
        $this->_status = $this->getParam('cstatus');
        $this->_p = $this->getParam('p') ? intval($this->getParam('p')) : 0;
        $this->_openid = $this->getParam('copenid');
        $this->_usopenid = $this->getParam('openid');

        $this->_order_id = $this->getParam('order_id');
        $this->_start_date = $this->getParam('start_date');
        $this->_end_date = $this->getParam('end_date');
        $this->_status1 = $this->getParam('status1');
        $this->_status2 = $this->getParam('status2');
        $this->_state = $this->getParam('state');
        $this->_sex = $this->getParam('sex');
        $this->_grade = $this->getParam('grade');
        $this->_channel = $this->getParam('channel');
        $this->_create_time = $this->getParam('create_time');

        $this->_Model = loadModel('Admin.Card');
        $this->_IndexModel = loadModel('Index.Cardto');
        $this->_Channel = loadModel('Admin.Channel');
        $this->_ParModel = loadModel('Admin.Partner');
        $this->_CommonModel = loadModel('Common');
        
        $this->_a = $this->getParam('a');
        $this->_m = $this->getParam('m');
        $this->assign('a', $this->_a);
        $this->assign('m', $this->_m);
        
        $this->_param = array(
            'name' => $this->_name,
            'openid' => $this->_openid,
            'cfrom' => $this->_from,
            'cto' => $this->_to,
            'state' => $this->_state,
            'sex' => $this->_sex,
            'grade' => $this->_grade,
            'code' => $this->getParam('code'),
            'end_time' => $this->getParam('end_time'),
            'sub_status' => $this->getParam('sub_status'),
            'channel' => $this->getParam('channel'),
            'card_type' => $this->getParam('card_type'),
            'order_id' => $this->_order_id,
            'status1' => $this->_status1,
            'status2' => $this->_status2,
            'create_time' => $this->_create_time,
        );
        $this->assign('webdata', $this->_param);
    }

    /**
     * 入口文件
     */
    public function cardPackageList() {
        $pagesize = 20;
        //前端页面默认打开
        if(!empty($this->_usopenid)){
            $num = $this->_Model->getOpenidPackageCardInfo($this->_usopenid); 
            $currentPage = ceil($num /$pagesize); 
            $remain = $num % $pagesize;
        }
        //抽取条件
        $param = array(
            'name' => $this->_name,
            'openid' => $this->_openid,
            'cfrom' => $this->_from,
            'cto' => $this->_to,
            'state' => $this->_state,
            'sex' => $this->_sex,
            'grade' => $this->_grade,
            'channel' => $this->_channel,
        );

        //数据列表
        
        $list = $this->_Model->listPartnerCardPackageAll($pagesize, $this->_p, $param);
        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);

        $page = new Page2($count, $this->pagesize);
        $page->quicklySet(isset($currentPage)?$currentPage:$this->_p,7);
        $limit = $page->returnlimit();
        $this->assign('page', $page->pageArray());
        //获取渠道列表
        $channel = $this->_Channel->getlist();
        //获取等级列表
        $level = $this->_ParModel->getPartnerLevel();

        $this->assign('channel', $channel);
        $this->assign('level', $level);
        $this->assign('openidswitch', isset($remain)?$remain:0);//前端页面 默认打开 需要此参数
        $this->assign('param', $param);
        $this->assign('list', $list['data']);
        $this->assign('count', $count);

        $this->display("Admin.Card.cardpackagelist");
    }

    /**
     * ajax 获取合伙人卡券统计
     *
     */
    public function ajaxListCardStatistical() {
        $openid = $this->getParam('openid');

        $list = $this->_Model->listCardStatistics($openid);
        if (!$list) {
            printJson(null, 1, '没有数据');
            exit();
        }
        printJson($list, 0, '正常');
    }

    /**
     * 卡券列表查询
     *
     */
    public function cardInfoList() {
        $conf = C('ACTIVITY_CONFIGS');
        $card_info_type = $conf['partners']['card_info_type'];
        $card_info_status = $conf['partners']['card_info_status'];
        $pagesize = 10;
        $param = array(
            'order_id' => $this->_order_id,
            'status1' => $this->_status1,
            'status2' => $this->_status2,
            'create_time' => $this->_create_time
        );
        $list = $this->_Model->CardInfoList($pagesize, $this->_p, $param);
        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);

        $page = new Page2($count, $this->pagesize);
        $page->quicklySet(isset($currentPage)?$currentPage:$this->_p,7);
        $limit = $page->returnlimit();
        $this->assign('page', $page->pageArray());

        $this->assign('list', $list['data']);
        $this->assign('param', $param);
        $this->assign('count', $count);
        $this->assign('status1', $card_info_type);
        $this->assign('status2', $card_info_status);

        $this->display("Admin.Card.cardinfolist");
    }

    /**
     * 卡券操作
     *
     */
    public function makingCard() {
        $conf = C('ACTIVITY_CONFIGS');
        $status = $conf['partners']['card_info_type'];
        $type1 = $conf['partners']['card_info_status'];

        $type = $this->getParam('type');

        $this->assign('status', $status);
        $this->assign('type', $type1);
        //添加卡券
        if (!isset($type) || $type == 1) {

            $this->display("Admin.Card.addcard");
            exit;
        }
        $conf = C('ACTIVITY_CONFIGS');
        $status = $conf['partners']['card_info_type'];
        $type1 = $conf['partners']['card_info_status'];

        $this->assign('status', $status);
        $this->assign('type', $type1);
        //修改更新卡券  -- type=2
        $this->display("Admin.Card.upcard");
    }

    public function upcard() {
        $conf = C('ACTIVITY_CONFIGS');
        $status = $conf['partners']['card_info_type'];
        $type1 = $conf['partners']['card_info_status'];

        $id = $this->getParam('id');
        $result = $this->_Model->queryCard($id);
        $this->assign('result', $result[0]);
        $this->assign('status', $status);
        $this->assign('type', $type1);

        $this->display("Admin.Card.upcard");
    }

    /**
     * ajax操作卡券
     *
     */
    public function ajaxCardInfo() {
        $ajax = $this->getParam('ajax'); //1添加2修改
        $param = $this->getParam('param');
        //添加卡券
        if (!isset($ajax) || $ajax == 1) {
            //执行卡券添加
            exit;
        }
    }

    //添加卡券
    public function addCardInfo() {
        $cardid = $this->getParam('card_id');
        $cardname = $this->getParam('card_name');
        $param = array(
            'file' => $this->getParam('file_path'),
            'card_name' => $cardname,
            'card_id' => $cardid,
            'card_num' => $this->getParam('card_num'),
            'type' => $this->getParam('type'), //补充
            'status' => $this->getParam('status'), //类型
            'start_date' => $this->getParam('start_date'), //类型
            'end_date' => $this->getParam('end_date'), //类型
            'card_msg' => $this->getParam('textarea1')
        );
        $result = $this->_Model->CardInfoAdd($param);
        if ($result) {
            $this->_Model->ListPartnerInfoAll($result, $cardid, $cardname);
            $result = array('error' => 0, 'msg' => '添加成功。');
        } else {
            $result = array('error' => 1, 'msg' => '添加失败。');
        }
        echo json_encode($result);
    }

    //修改卡券
    public function updateCardInfo() {
        $param = array(
            'id' => $this->getParam('id'),
            'card_name' => $this->getParam('card_name'),
            'card_id' => $this->getParam('card_id'),
            'card_num' => $this->getParam('card_num'),
            'type' => $this->getParam('type'),
            'status' => $this->getParam('status'),
            'file' => $this->getParam('file_path'),
            'card_msg' => $this->getParam('textarea1'),
            'start_date' => $this->getParam('start_date'),
            'end_date' => $this->getParam('end_date'),
        );
        $result = $this->_Model->CardInfoUpdate($param);
        if ($result) {
            $result = array('error' => 0, 'msg' => '修改成功。');
        } else {
            $result = array('error' => 1, 'msg' => '修改失败。');
        }
        echo json_encode($result);
    }

    //卡券列表详情页
    public function detailInfomation() {
        $openid = $this->getParam('openid');
        $list = $this->_Model->detailInfomation($openid);
        if (!$list) {
            printJson(null, 1, '没有数据');
            exit();
        }
        printJson($list, 0, '正常');
    }

    /**
     * 卡券补充审核
     *
     */
    public function cardSupAuditList() {
         $status = array(
            '0' => '待审核',
            '1' => '已补充',
            '2' => '拒绝补充'
        );

        $pagesize = 20;
        $param = array(
            'code' => $this->getParam('code'),
            'create_time' => $this->getParam('create_time'),
            'end_time' => $this->getParam('end_time'),
            'sub_status' => $this->getParam('sub_status'),
            'channel' => $this->getParam('channel'),
             'card_type' => $this->getParam('card_type')
               
        );
      
        $list = $this->_Model->querySupList($pagesize, $this->_p, $param);
        $channel = $this->_Model->queryChannel();
        $cardType = $this->_Model->queryCardid();
        $count = isset($list['count']) ? $list['count'] : 0;
        unset($list['count']);
        $page = new Page2($count, $this->pagesize);
        $page->quicklySet(isset($currentPage)?$currentPage:$this->_p,7);
        $limit = $page->returnlimit();
        $this->assign('page', $page->pageArray());
        $this->assign('list', $list['data']);
        $this->assign('channel',$channel);
        $this->assign('cardType',$cardType);
        $this->assign('status',$status);
       
        $this->assign('param', $param);

        $this->display("Admin.Card.cardsupauditlist");
    }

    /**
     * 卡券审核
     *
     */
    public function allowSup() {
        $id = $this->getParam('id');
        $list = $this->_Model->querySupData($id);
        $this->assign('list', $list);
        $this->display("Admin.Card.allowsup");
    }

    //允许数据
    public function updateData() {
        $id = $this->getParam('id');
        $num = $this->getParam('tosup_num');
        $openid = $this->getParam('openid');
        $cardid = $this->getParam('cardid');
        $cardcount = $this->_Model->listCardCount($cardid);
        
        if($num > $cardcount){
            printJson(0, 2, '卡券库存不足，剩余'.$cardcount.'张!');
            exit();   
        }
        
        $param = array(
            'sub_status' => 1,
            'sup_time' => time(),
            'tosup_num' => $num,
        );
        $list = $this->_Model->updateData($id, $param);
        if ($list) {
            $this->_Model->addPartnerCodeData($openid, $cardid, $num);   
  
            //合伙人卡券统计
            $cardStu = $this->_IndexModel->checkPartnerCard($cardid, $openid); 
             
            $st = array(
                //'card_supplement' => $cardStu['card_supplement']+1,   //不是允许补充才算补充次数
                'card_number' => $cardStu['card_number']+$num,
                'card_issue' => $cardStu['card_issue']+$num
            );  
            //更改合伙人卡券统计发放数
            $this->_IndexModel->upPartnerCardStatistics($cardid, $openid, $st);
            //合伙人统计
            $partnerSta = $this->_IndexModel->listPartnerStatisticsOne($openid);
            $arrto = array(
                //'par_supplement' => $partnerSta['par_supplement']+1, 
                'par_number' => $partnerSta['par_number']+$num, 
            );
            //更改合伙人统计发放数
            $this->_IndexModel->upPartnerStatistics($openid, $arrto);
            
            $this->_CommonModel->insertOneMessage($openid, '卡包审核成功');
            printJson(0, 1, '补充成功！');
            exit();
        } 
        printJson(0, 0, '补充失败！');
            exit();
    }

    //ajax 执行卡券统计操作   --  没有使用这个方法
    public function ajaxCardCz() {
        $num = $this->getParam('tosup_num');
        $openid = $this->getParam('openid');
        $cardid = $this->getParam('cardid');

        $this->_Model->addPartnerCodeData($openid, $cardid, $num);

        //合伙人卡券统计
        $cardStu = $this->_IndexModel->checkPartnerCard($cardid, $openid);

        $st = array(
            'card_supplement' => $cardStu['card_supplement'] + 1,
            'card_number' => $cardStu['card_number'] + $num,
            'card_issue' => $cardStu['card_issue'] + $num
        );
        //更改合伙人卡券统计发放数
        $this->_IndexModel->upPartnerCardStatistics($cardid, $openid, $st);
        //合伙人统计
        $partnerSta = $this->_IndexModel->listPartnerStatisticsOne($openid);
        $arrto = array(
            'par_supplement' => $partnerSta['par_supplement'] + 1,
            'par_number' => $partnerSta['par_number'] + $num,
        );
        //更改合伙人统计发放数
        $this->_IndexModel->upPartnerStatistics($openid, $arrto);
    }

    /**
     * 拒绝补充
     *
     */
    public function refusedSup() {
        $id = $this->getParam('id');
        $list = $this->_Model->querySupData($id);
        $this->assign('list', $list);
        $this->display("Admin.Card.refusedsup");
    }

    /**
     *  批量拒绝     
     */
    public function allRefuse() {
        $id = $this->getParam('id');
         $openid = $this->getParam('openid');
         $idextends =$this->getParam('idextends');
         if(empty($id) || !isset($id)){
           $id = $idextends;
         }
         
        
       
        $list = $this->_Model->allRefuse($id);
        if ($list) {
            $result = array('error' => 0, 'msg' => '成功');
            
            $openidarray = explode(',', $openid);
            foreach($openidarray as $v){
                if(!empty($v)){
                    $this->_CommonModel->insertOneMessage($v, '卡包审核拒绝');
                }
            }
            
        } else {
            $result = array('error' => 1, 'msg' => '失败');
        }
        echo json_encode($result);
    }

    //修改拒绝理由
    public function upodateRefuseMessage() {
        $id = $this->getParam('id');
        $message = $this->getParam('message');
        $openid = $this->getParam('openid');
        
        $param = array(
            'sub_status' => 2,
            'refused_msg' => $message,
            'sup_time' => time()
        );
        $list = $this->_Model->updateData($id, $param);
        if ($list) {
            $result = array('error' => 0, 'msg' => '修改成功');
            $this->_CommonModel->insertOneMessage($openid, '卡包审核拒绝');
        } else {
            $result = array('error' => 1, ',msg' => '修改失败');
        }
        echo json_encode($result);
    }

    /**
     * 卡包管理--卡包列表  导出补充记录  请求地址
     * @author wangpq
     *  
     */
    public function exportsupplement() {
        $this->downloadpageset();
        $cardid = $this->getParam('cid');
        $openid = $this->getParam('oid');
        
        if (empty($cardid)|| empty($openid)) {
            $result = $this->_Model->exportsupplement();
        } else {
            $result = $this->_Model->exportsupplement($cardid, $openid);
        }
        
        if ($result) {
            foreach ($result as $key => &$value) {
                foreach ($value as $k => &$v) {
                    if ($k == 'sub_status') {
                        $val = '';
                        switch ($v) {
                            case 0:$val = '待审核';
                                break;
                            case 1:$val = '已补充';
                                break;
                            case 2:$val = '拒绝补充';
                                break;
                        }
                        $value['sub_status'] = $val;
                    }
                    if ($k == 'create_time' || $k == 'sup_time') {
                        $v = empty($v) ? '' : date('Y-m-d H:i:s', $v);
                    }
                }
            }
        }
        $fieldlist = array();
        $fieldlist['sup_sn'] = '补充记录ID';
        $fieldlist['openid'] = '合伙人编号';
        $fieldlist['name'] = '合伙人姓名';
        $fieldlist['create_time'] = '申请补充时间';
        $fieldlist['sup_time'] = '实际补充时间';
        $fieldlist['tosup_num'] = '实际补充数量';
        $fieldlist['card_sn'] = '卡券编号';
        $fieldlist['card_id'] = 'card_id';
        $fieldlist['card_name'] = '卡券名';
        $fieldlist['sub_status'] = '状态';
        echo $this->getexportstring($result, $fieldlist);
    }

    /**
     * 卡包管理--卡包列表  导出发放记录/导出发放明细  请求地址
     * @author wangpq
     *
     */
    public function exportissue() {
        $this->downloadpageset();
        $id = $this->getParam('id');
        $cardid = $this->getParam('cid');
        $openid = $this->getParam('oid');
        if (!empty($id)) {
            $result = $this->_Model->exportissue($id);
        } elseif (empty($cardid) || empty($openid)) {
            $result = $this->_Model->exportissue();
        } else {
            $result = $this->_Model->exportissue(false, $cardid, $openid);
        }

        if ($result) {
            foreach ($result as $key => &$value) {
                foreach ($value as $k => &$v) {
                    if ($k == 'create_time') {
                        $v = empty($v) ? '' : date('Y-m-d H:i:s', $v);
                    }
                }
            }
        }

        $fieldlist = array();
        $fieldlist['id'] = '发放记录ID';
        $fieldlist['code'] = '合伙人编号';
        $fieldlist['name'] = '合伙人姓名';
        $fieldlist['create_time'] = '发放时间';
        $fieldlist['issue_num'] = '发放数量';
        $fieldlist['receiv_num'] = '领取数量';
        $fieldlist['cancel_num'] = '核销数量';
        $fieldlist['card_sn'] = '卡券编号';
        $fieldlist['cardname'] = '卡券名';
        $fieldlist['cardid'] = 'card_id';
        echo $this->getexportstring($result, $fieldlist);
    }

    /**
     * 卡包管理--卡包列表  导出领取/核销记录  请求地址
     * @author wangpq
     *
     */
    public function exportdrawfl() {
        $this->downloadpageset(); 
        $s = $this->getParam('s');
        $s = $s == 1 ? 1 : 3;
        $cardid = $this->getParam('cid');
        $openid = $this->getParam('oid');
        if (empty($cardid) || empty($openid)) {
            $result = $this->_Model->exportdrawfl($s);
        } else {
            $result = $this->_Model->exportdrawfl($s, $cardid, $openid);
        }

        if ($result) {
            foreach ($result as $key => &$value) {
                foreach ($value as $k => &$v) {
                    if ($k == 'create_time' || $k == 'cancel_time' || $k == 'sendtime') {
                        if(!strstr($v,'-')){
                            $v = empty($v) ? '' : date('Y-m-d H:i:s', $v);
                        }
                    }
                }
            }
        }
        
        $fieldlist = array();
        $fieldlist['id'] = '发放记录ID';
        $fieldlist['cardid'] = 'card_id';
        $fieldlist['card_sn'] = '卡券编号';
        $fieldlist['card_name'] = '卡券名';
        $fieldlist['cardcode'] = '卡券CODE';
        $fieldlist['create_time'] = '领取时间';
        $fieldlist['openid'] = '领取人openId';
        if($s == 3){
            $fieldlist['cancel_time'] = '核销时间';
            $fieldlist['cancelopenid'] = '核销人openId';
            $fieldlist['sendtime'] = '发放时间';
        }
        $fieldlist['source_openid'] = '合伙人openId';
        $fieldlist['partnercode'] = '合伙人编号';
        $fieldlist['name'] = '合伙人姓名';
        echo $this->getexportstring($result, $fieldlist );
    }

    /**
     * 下载 接口的一段通用代码
     * @author wangpq 
     */
    private function downloadpageset() {
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . date('YmdHis') . ".csv");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
    }

    /**
     * 输出用于csv格式的字符串。
     * @author wangpq
     * @param array $result 数据库结果集数组
     * @param array $transferfield 显示excel列名以及列名的先后顺序<br/>
     * example:<br/>
     * 如果数组为 array('name','desc','age') 那么输出列顺序为 name,desc,age<br/>
     * 如果数组为 array('name'=>'名字','desc'=>'描述','age'=>'年龄') 那么输出列为 名字，描述，年龄
     * @param boolean $testmode 为true时，编码默认'utf8',输出的换行符为'<br/>'，便于网页测试。<br/>
     * 默认为false，输出'\n'用于csv，并且转换为gbk格式。
     * @return string
     */
    private function getexportstring($result, $transferfield = array(), $testmode = false) {
        $string = '';
        if (empty($result) && empty($transferfield)) {
            return $string;
        }
        if (empty($result) && !empty($transferfield)) {
            //没有数据 只有字段名 那么只输出字段名
            foreach ($transferfield as $v) {
                $string .= $testmode ? $v . "," : iconv('utf-8', 'gbk', $v) . ",";
            }
            $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
            return $string;
        }
        if (!empty($result) && empty($transferfield)) {
            //有数据 无字段名，那么按照数据库原样输出excel 字段名就为键名
            $firstloop = true;
            foreach ($result as $v) {
                if ($firstloop) {
                    foreach ($v as $key => $value) {
                        $string .= $testmode ? $key . "," : iconv('utf-8', 'gbk', $key) . ",";
                    }
                    $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
                    $firstloop = false;
                }
                foreach ($v as $key => $value) {
                    $string .= $testmode ? $value . "," : iconv('utf-8', 'gbk', $value) . ",";
                }
                $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
            }
            return $string;
        }
        if (!empty($result) && !empty($transferfield)) {
            //输出 excel 列名（首行）(字段名)
            foreach ($transferfield as $k => $v) {
                $string .= $testmode ? $v . "," : iconv('utf-8', 'gbk', $v) . ",";
            }
            $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);

            //对于 不改变字段名的数组 如：array（'name','age','id'）
            //统一成 array('数据库字段名1'=>'任意值','数据库字段名2'=>'任意值')的形式。
            if (array_key_exists(0, $transferfield)) {
                $transferfield = array_flip($transferfield);
            }

            foreach ($result as $v) {
                foreach ($v as $key => $value) {
                    if (in_array($key, array_keys($transferfield))) {
                        //将值写入新的数组里，目的按照transferfield更改顺序
                        $transferfield[$key] = "\t".$value;
                    }
                }
                //更改完 顺序，输出一行。
                foreach ($transferfield as $v) {
                    $string .= $testmode ? $v . "," : iconv('utf-8', 'gbk', $v) . ",";
                }
                $string = $testmode ? substr_replace($string, "<br/>", -1, 1) : substr_replace($string, "\n", -1, 1);
            }
            return $string;
        }
    }
    
    
    
    /*public function test(){
        $this->_Model->testzx();    
    }*/
    
}
