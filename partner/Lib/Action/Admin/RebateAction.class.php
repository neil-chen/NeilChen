<?php 

class RebateAction extends AdminAction {
    
    private $_a = null;
    private $_m = null;
    private $_p = null;
    private $_model = null;
    private $_keyword = null;
    private $_createtime = null;
    private $_end_date = null;
    private $_status = null;
    private $_gendar = null;
    private $_level = null;
    private $_channel = null;
    private $_param = null;
    private $_id = null;
    private $_openid = null;
    private $pagesize =20;
    
    public function __construct(){
        parent::__construct();

        $this->_a = $this->getParam('a');
        $this->_m = $this->getParam('m');
        $this->assign('a', $this->_a);
        $this->assign('m', $this->_m);
        $this->_p = $this->getParam('p')?$this->getParam('p'):1;
        $this->assign('p', $this->_p);
        
        $this->_model = loadModel('Admin.Rebate');
        
        $this->_keyword = $this->getParam('keyword');
        $this->_createtime = $this->getParam('createtime');
        $this->_status = $this->getParam('status');
        $this->_gendar = $this->getParam('gendar');
        $this->_level = $this->getParam('level');
        $this->_channel = $this->getParam('channel'); 
        $this->_id = $this->getParam('id');
        $this->_openid = $this->getParam('openid');
        $this->_end_date = $this->getParam('end_date');
        
        $this->_param = array(
            'keyword'=>$this->_keyword ,
            'createtime'=>$this->_createtime,
            'end_date'=>$this->_end_date,
            'status' => $this->_status,
            'gendar' => $this->_gendar,
            'level'=>$this->_level,
            'channel'=>$this->_channel
        );
        $this->assign('webdata', $this->_param);
        
       
    }
    public function index(){
        //前端页面默认打开
        if(!empty($this->_openid)){
            $num = $this->_model->getopenidordernuminpartnerinfo($this->_openid); 
            $currentPage = ceil($num /$this->pagesize); //反推 第几页
            $remain = $num % $this->pagesize;//反推某一页的第几条
        }
        //获取总记录数 设置分页
        $totalrecord = $this->_model->getrebatelistcount( $this->_param );
        $page = new Page2($totalrecord,$this->pagesize);
        $page->quicklySet(isset($currentPage)?$currentPage:$this->_p,7);
        $limit = $page->returnlimit();
        $result = $this->_model->getrebatelist($this->_param ,$limit);
        $partnerModel = loadModel('Admin.Partner');

        if ($result) {
            foreach($result as &$value){
                foreach($value as $k=>&$v){
                    if($k == 'integral'){
                        $res = $partnerModel->getPartnerLevelByScore($v);
                        $value['grade'] = $res['name'];
                    }
                }
            }
        }
      
        $this->assign('levellist', $this->_model->getlevellist());
        $this->assign('channellist', $this->_model->getchannellist());
        
        $this->assign('openidswitch', isset($remain)?$remain:0);//前端页面 默认打开 需要此参数
        $this->assign('page', $page->pageArray());
        $this->assign('result', $result?$result:array());
        $this->display('Admin.Rebate.Rebate');
    }
    
    public function withdrawals(){
        
        $totalrecord = $this->_model->getgetcashlistcount($this->_param);

        $page = new Page2($totalrecord,$this->pagesize);
        $page->quicklySet($this->_p,7);
        $limit = $page->returnlimit();

        $result = $this->_model->getgetcashlist( $this->_param ,$limit);
        
        $partnerModel = loadModel('Admin.Partner');
        if ($result) {
            foreach($result as &$value){
                foreach($value as $k=>&$v){
                    if($k == 'integral'){
                        $res = $partnerModel->getPartnerLevelByScore($v);
                        $value['grade'] = $res['name'];
                    }
                }
            }
        }
        
        $this->assign('levellist', $this->_model->getlevellist());
        $this->assign('channellist', $this->_model->getchannellist());
        
        $this->assign('page', $page->pageArray());
        $this->assign('result', $result?$result:array());
        $this->display('Admin.Rebate.Withdrawals');
    }
    
    //处理 提现申请 的批准与拒绝 接口
    public function ajaxdealwithrebate(){
        $id = $this->_id;
        $status = $this->_status;
        if(empty($id)){
            printJson('6','FAILED','id为空');
            exit;
        }
        
        if($status == 1){
            if($this->_model->agreegetcash($id)){
                printJson('1','OK','操作成功');
                exit;
            }else{
                printJson('2','FAILED', $this->_model->getError());
                exit;
            }
        }elseif($status == 2){
            if($this->_model->refusegetcash($id)){
                printJson('3','OK','操作成功');
                exit;
            }else{
                printJson('4','FAILED','系统错误，操作异常');
                exit;
            }
        }else{
            printJson('5','FAILED','status 有误');
        }
    }
    
    //返利列表页-导出返利统计
    public function exportrebatestatistics(){
        $this->downloadpageset();
        $id = $this->_id;
        //id为空，视为导出全部提现记录
        if(empty($id)){
            $result = $this->_model->getrebatelist();
        }else{
            $result = $this->_model->getrebatelist(array('id'=>$id));
        }
                        
        $fieldlist = array();
        $fieldlist['code'] = '合伙人编号';
        $fieldlist['name'] = '合伙人姓名';
        $fieldlist['total'] = '累积返利';
        $fieldlist['summon_money'] = '呼朋唤友累积返利';
        $fieldlist['orderrebate_money'] = '卡券核销累积返利';
        $fieldlist['notaccount_money'] = '未入账返利';
        $fieldlist['rebate_money'] = '可提现返利';
        $fieldlist['towithdraw_money'] = '已提现返利';
        
        echo $this->getexportstring($result, $fieldlist);
    }
    //返利列表页-导出返利明细 
    public function exportrebatedetail(){
        $this->downloadpageset(); 
        $openid = $this->_openid;
        //id为空，视为导出全部提现记录
        if(empty($openid)){
            $result = $this->_model->gettworebate();
        }else{
            $arr = explode(',', $openid);
            foreach($arr as &$v){
                $v = "'" . $v . "'";
            }
            $openid = implode(',', $arr);
            $result = $this->_model->gettworebate($openid);
        }
        
        $fieldlist = array();
        $fieldlist['code'] = '合伙人编号';
        $fieldlist['wx_name'] = '合伙人姓名';
        $fieldlist['phone'] = '合伙人联系电话';
        $fieldlist['type'] = '返利类型';
        $fieldlist['money'] = '返利金额';
        $fieldlist['order_id'] = '订单编号';
        $fieldlist['cardid'] = 'card_id';
        $fieldlist['cardname'] = 'card_code';
        $fieldlist['open_id'] = '朋友openId';
        $fieldlist['inv_name'] = '朋友昵称';
        $fieldlist['create_time'] = '返利时间';
        $fieldlist['score'] = '积分奖励';
   
        echo $this->getexportstring($result, $fieldlist );
    }
    //返利列表页-导出提现明细 
    public function exportgetcashdetail(){
        $this->downloadpageset();
        $openid = $this->_openid;
        //id为空，视为导出全部提现记录
        if(empty($openid)){
            $result = $this->_model->getGetCashDetail();
        }else{
            $arr = explode(',', $openid);
            foreach($arr as &$v){
                $v = "'" . $v . "'";
            }
            $openid = implode(',', $arr);
            $result = $this->_model->getGetCashDetail( $openid );
        }
        //暂时写死 提现方式：自主申请
        foreach($result as &$value ){
           $value['cashmethod'] = '自主申请';
        }
      
        
        $fieldlist = array();
        $fieldlist['code'] = '合伙人编号';
        $fieldlist['name'] = '合伙人姓名';
        $fieldlist['phone'] = '合伙人联系电话';
        $fieldlist['create_time'] = '提现申请时间';
        $fieldlist['cancel_time'] = '提现执行时间';
        $fieldlist['money'] = '提现金额';
        $fieldlist['cashmethod'] = '提现方式';
    
        echo $this->getexportstring($result, $fieldlist);
    }
    //提现页面
    public function exportgetcashrecord(){
        $this->downloadpageset();
        $id = $this->_id;
        //id为空，视为导出全部提现记录
        if(empty($id)){
            $result = $this->_model->getgetcashlist();
        }else{
            $result = $this->_model->getgetcashlist(array('id'=>$id));
        }
       
        $fieldlist = array();
        $fieldlist['id'] = '申请记录编号';
        $fieldlist['tradeNo'] = '提现流水号';
//         $fieldlist['微支付流水号'] = '微支付流水号';
        $fieldlist['code'] = '合伙人编号';
        $fieldlist['name'] = '合伙人姓名';
        $fieldlist['create_time'] = '申请时间';
        $fieldlist['cancel_time'] = '执行时间';
        $fieldlist['money'] = '申请提现金额';
        $fieldlist['bonusstatename'] = '状态';
        
        echo $this->getexportstring($result, $fieldlist);
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
                        $transferfield[$key] = "\t". $value;
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
}
