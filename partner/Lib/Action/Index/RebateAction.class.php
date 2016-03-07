<?php

//我的返利
class RebateAction extends WebAction {

    private $_Model;
    private $_p;
    private $_a;
    private $_m;

    public function __construct() {
        parent::__construct();
        $this->_Model = loadModel('Index.Rebate');

        $this->assign('openid', $this->_openId);
        $this->_p = $this->getParam('p');
        $this->_a = $this->getParam('a');
        $this->_m = $this->getParam('m');
        $this->assign('a', $this->_a);
        $this->assign('m', $this->_m);
        $this->assign('title', '我的返利');
        
        //查看数据库是否已更新返利
        $this->_Model->updateAllUserRebate();
    }

    //我的返利页面
    public function rebate() {
        //我的返利数据
        $result = $this->_Model->getrebateall($this->_openId);
        $result['total'] = $result['rebate_money'] + $result['notaccount_money'] + $result['towithdraw_money'];
        $this->assign('result', $result ? $result : array());

        //积分 
        $partnermodel = loadModel('Admin.Partner');
        $integral = $this->_Model->getintegral($this->_openId);
        $score_result = $partnermodel->getPartnerNextLevelByScore($integral);
        $needscore = $score_result['from_score'] - $integral;
        $needscore = ($needscore > 0) ? $needscore : '';
        //我的提现 数据
        $mybonuswithdrawl = $this->getmybonuswithdrawldata(1);
        //卡卷核销 数据
        $create_time = date('Y') . "-" . date("m") . "-01";
        $end_time = date('Y-m-d', strtotime("$create_time +1 month "));
        $myverfic = $this->getmyverificdata(1, array('create_time' => $create_time, 'end_time' => $end_time));

        //提现次数计算
        $row = $this->_Model->getcashsuccess($this->_openId);
        $this->assign('row', $row);

        // 呼唤朋友列表数据
        $invitationParams = array(
            'openid' => $this->_openId,
        );
        $invitation = loadModel('Index.Invitation')->rebateGetList($invitationParams);
        $this->assign('invitation', $invitation);
        
        //提现中的金额
        $draw = $this->_Model->ispartnerHascashapply($this->_openId);
        //已提现返利 = 已到手的返利 + 申请提现中的返利
        $draw_rebate = $result['towithdraw_money'] + $draw['money'];
        
        
        $this->assign('myverfic', $myverfic ? $myverfic : array());
        $this->assign('mybonuswithdrawl', $mybonuswithdrawl ? $mybonuswithdrawl : array());
    
        $this->assign('integral', $integral);
        $this->assign('needscore', $needscore);
        $this->assign('draw_rebate', $draw_rebate);
        $this->display('Index.Rebate.myrebate');
    }

    //获取 我的提现 详情数据
    private function getmybonuswithdrawldata($p) {
        $pagesize = 5;
        $totalrecord = $this->_Model->getbonuswithdrawlcount($this->_openId);
        $page = new Page2($totalrecord, $pagesize);
        $page->setCurrentPage($p);
        $limit = $page->returnlimit(false);
        $myrebate = $this->_Model->getbonuswithdrawl($limit, $this->_openId);
        return $myrebate;
    }

    //获取我的提现详情数据 ajax接口 
    public function ajaxMyrebate() {
        $p = $this->getParam('p');
        $myrebate = $this->getmybonuswithdrawldata($p);
        printJson($myrebate, 'OK', '分页数据');
    }

    //获取 卡券核销 详情数据
    private function getmyverificdata($p, $param) {
        $pagesize = 5;
        $totalrecord = $this->_Model->getverificlistcount($this->_openId, $param);
        // var_dump($totalrecord);
        $page = new Page2($totalrecord, $pagesize);
        $page->setCurrentPage($p);
        $limit = $page->returnlimit(false);

        $myveric = $this->_Model->getverificlist($limit, $this->_openId, $param);

        return $myveric;
    }

    public function ajaxverfic() {
        $p = $this->getParam('p');
        $create_time = $this->getParam('create_time');
        //  var_dump($create_time);
        $end_time = date('Y-m-d', strtotime("$create_time +1 month "));
        //  var_dump($end_time);
        $myverfic = $this->getmyverificdata($p, array('create_time' => $create_time, 'end_time' => $end_time));
      // var_dump($myverfic);
        printJson($myverfic, 'OK', '分页数据');
    }



    //我的提现页面
    public function applyfor() {
        //我的返利数据
        $result = $this->_Model->getrebateall($this->_openId);
        $result['total'] = $result['rebate_money'] + $result['notaccount_money'] + $result['towithdraw_money'];
        $this->assign('result', $result ? $result : array());
        $this->assign('title', '申请提现');
        $this->display('Index.Rebate.applyfor');
    }

    //接口：提取现金申请
    public function ajaxapplyfor() {
        $cash = $this->getParam('cash');

        if (!is_numeric($cash)) {
            printJson('5', 'FAILED', '提现金额输入错误');
            exit;
        }

        //检查是否可以提现申请
        if ($this->_Model->ispartnerHascashapply($this->_openId)) {
            printJson('4', 'FAILED', '不可以重复提交提现申请');
            exit;
        }
        //获取可提现金额
        $result = $this->_Model->getrebateall($this->_openId);
        $rebate = $result['rebate_money'];
        if ($cash <= $rebate) {
            if ($this->_Model->getcashapply($cash, $this->_openId, $rebate)) {
                printJson('0', 'OK', '提交成功');
                exit;
            } else {
                printJson('1', 'FAILED', 'system error');
                exit;
            }
        } else {
            printJson('2', 'FAILED', '提交金额，超过可提现金额');
            exit;
        }
    }

}

?>