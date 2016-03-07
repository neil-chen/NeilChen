<?php

/**
 * 5100--ACTION类
 */
class CardAction extends WebAction {

    private $_Model;
    private $_ParModel;

    public function __construct() {
        parent::__construct();
        $this->_Model = loadModel('Index.Cardto');
        $this->_ParModel = loadModel('Admin.Partner');
        $this->_CardAdminModel = loadModel('Admin.Card');
        //$this->_openId = 'onwtvs_nLs6xkOnslhqXXY82eEHo';                                                                                                        
        //$partner = $this->_Model->getPartner($this->_openId);
        //$this->assign('partner', $partner);

        $this->assign('title', '我的卡包');
        $this->assign('openid', $this->_openId);
    }

    /**
     * 我的卡包
     */
    public function MyCard() {
        $openid = $this->_openId;

        $partner = $this->_Model->getOpenidPartner($this->_openId);

        //当前等级
        $level = $this->_ParModel->getPartnerLevelByScore($partner['integral']);
        //下一级等级
        $nextlevel = $this->_ParModel->getPartnerNextLevelByScore($partner['integral']);

        //更新合伙人卡券上限根据等级
        $card_max = $level['card_total'];

        $par_card = $this->_Model->upgradePerform($level['award_cards'], $openid);
        //查询是否添加卡券
        if ($par_card) {
            foreach ($par_card as $v) {
                $arrto = array(
                    'openid' => $this->_openId,
                    'card_info_id' => $v['id'],
                    'cardid' => $v['card_id'],
                    'cardname' => $v['card_name'],
                    'card_ceiling' => $card_max,
                    'card_number' => $card_max,
                );
                $this->_ParModel->addPartnerCardStatistics($arrto);
                $this->_CardAdminModel->addPartnerCodeData($this->_openId, $v['card_id'], $card_max);
            }
        }
        //查询卡券上限数
        $par_card_stu = $this->_Model->getParCardStuOne($this->_openId);
        //更改上限
        if ($par_card_stu['card_ceiling'] != $card_max) {
            $this->_Model->updateCardMaxByLevel($this->_openId, $card_max);
            $countCardNum = count($par_card);
            //添加合伙人统计
            $this->_Model->upParStuCardTypeNum($this->_openId, $countCardNum);
        }

        $this->assign('level', $level);
        $this->assign('nextlevel', $nextlevel);
        $cardAll = $this->_Model->listCardAll($openid, $level['award_cards']);
        $cardstu = $this->_Model->listPartnerStatisticsOne($openid, $level['award_cards']);
        $this->assign('cardAll', $cardAll);
        $this->assign('cardstu', $cardstu);
        $this->assign('user_score', $partner['integral']);
        $this->display('Index.Card.mycard');
    }

    /**
     *  卡券发放
     */
    public function IssueCard() {
        $openid = $this->_openId;
        $cardid = $this->getParam('cardid');

        $cardone = $this->_Model->listCardOne($openid, $cardid);
        $this->assign('cardone', $cardone);
        $this->assign('cardid', $cardid);

        $this->assign('title', '卡券发放');
        $this->display('Index.Card.issuecard');
    }

    /**
     * ajax 卡券发放
     */
    public function ajaxIssueCard() {
        $openid = $this->_openId;
        $cardid = $this->getParam('cardid');
        $issuenum = $this->getParam('issuenum');
        $limitnum = $this->getParam('limitnum');
        //检查卡券是否过期
        $checkcard = $this->_Model->checkCardSend($cardid);
        if (!$checkcard) {
            printJson(null, 1, '次卡券已经过期！');
            exit();
        }
        $cardStu = $this->_Model->checkPartnerCard($cardid, $openid);
        if ($issuenum > $cardStu['card_number']) {
            printJson(null, 1, '数量超限了！');
            exit();
        }
        $data = array(
            'issuenum' => $issuenum,
            'limitnum' => $limitnum
        );
        //添加合伙人卡券发放记录
        $issueid = $this->_Model->addIssueCard($cardid, $openid, $data);

        if ($issueid) {
            $arr = array(
                //'card_supplement' => $cardStu['card_supplement']+1,   这是发放  不是补充
                'card_issued' => $cardStu['card_issued'] + $issuenum,
                'card_number' => $cardStu['card_number'] - $issuenum
            );
            //更改合伙人卡券统计发放数
            $this->_Model->upPartnerCardStatistics($cardid, $openid, $arr);
            $partnerSta = $this->_Model->listPartnerStatisticsOne($openid);
            $arrto = array(
                'par_number' => $partnerSta['par_number'] - $issuenum,
                'par_issue' => $partnerSta['par_issue'] + 1,
                'par_issued' => $partnerSta['par_issued'] + $issuenum,
            );
            //更改合伙人统计发放数
            $this->_Model->upPartnerStatistics($openid, $arrto);

            if ($this->_Model->addDrawfl($issueid, $cardid, $openid, $issuenum)) {
                printJson($issueid, 0, '发放码已生成，点击关闭马上分享！');
                exit();
            }
        }
        printJson(null, 1, '发放失败，请重试！');
        exit();
    }

    /**
     * 卡券发放记录
     * 
     */
    public function IssueCardLog() {
        $openid = $this->_openId;
        $cardid = $this->getParam('cardid');
        $cardone = $this->_Model->listCardOne($openid, $cardid);
        $list = $this->_Model->listIssueCardlog($cardid, $openid, 1);
        $uslist = $this->_Model->listIssueCardUslog($cardid, $openid, 1);

        $data = $this->_Model->listIssueCardlogCount($cardid, $openid);
        $usdata = $this->_Model->listIssueCardUslogCount($cardid, $openid);
        $this->assign('count', $data['count']);
        $this->assign('uscount', $usdata);
        $this->assign('data', $data['data']);
        $this->assign('list', $list);
        $this->assign('uslist', $uslist);
        $this->assign('cardone', $cardone);
        $this->assign('cardid', $cardid);
        $this->assign('title', '发放记录');
        $this->display('Index.Card.issuecardlog');
    }

    /**
     * ajax 加载发放记录
     */
    public function ajaxIssueCardLog() {
        $openid = $this->_openId;
        $page = $this->getParam('page');
        $cardid = $this->getParam('cardid');
        $list = $this->_Model->listIssueCardlog($cardid, $openid, $page);

        if (!$list) {
            printJson(null, 1, '没有数据');
            exit();
        }
        printJson($list, 0, '正常');
    }

    /**
     * ajax 加载发放记录
     */
    public function ajaxIssueCardUsLog() {
        $openid = $this->_openId;
        $page = $this->getParam('page');
        $cardid = $this->getParam('cardid');
        $list = $this->_Model->listIssueCardUslog($cardid, $openid, $page);

        if (!$list) {
            printJson(null, 1, '没有数据');
            exit();
        }
        printJson($list, 0, '正常');
    }

    /**
     * 卡券补充记录
     * 
     */
    public function SupCardLog() {
        $openid = $this->_openId;
        $cardid = $this->getParam('cardid');
        $cardone = $this->_Model->listCardOne($openid, $cardid);
        $list = $this->_Model->listSupCardlog($cardid, $openid, 1);
        $cardstu = $this->_Model->checkPartnerCard($cardid, $openid);
        $this->assign('list', $list);
        $this->assign('cardid', $cardid);
        $this->assign('cardone', $cardone);
        $this->assign('cardstu', $cardstu);
        $this->assign('title', '补充记录');
        $this->display('Index.Card.supcardlog');
    }

    /**
     * ajax 加载补充记录
     */
    public function ajaxSupCardLog() {
        $openid = $this->_openId;
        $page = $this->getParam('page');
        $cardid = $this->getParam('cardid');
        $list = $this->_Model->listSupCardlog($cardid, $openid, $page);

        if (!$list) {
            printJson(null, 1, '没有数据');
            exit();
        }
        printJson($list, 0, '正常');
    }

    /**
     * 卡券追踪
     * 
     */
    public function CardTracking() {
        $openid = $this->_openId;
        $cardid = $this->getParam('cardid');

        $cardinfo = $this->_Model->listCardInfo($cardid);


        $data = $this->_Model->listCardTrackingCount($cardid, $openid);

        $this->assign('cardinfo', $cardinfo);
        $this->assign('data', $data);
        $this->assign('title', '卡券追踪');
        $this->display('Index.Card.cardtracking');
    }

    /**
     * ajax 加载卡券追踪
     */
    public function ajaxListCode() {
        $openid = $this->_openId;
        $code = $this->getParam('code');
        $list = $this->_Model->listDrawflCode($code);

        if (!$list) {
            printJson(null, 0, '没有数据');
            exit();
        }
        if ($list['state'] == 1) {
            $list['state'] = '领取';
        } else if ($list['state'] == 2) {
            $list['state'] = '赠送';
        } else if ($list['state'] == 3) {
            $list['state'] = '核销';
        } else {
            $list['state'] = '未领取';
        }
        printJson($list, 1, '正常');
    }

    /**
     * ajax申请补充卡券
     */
    public function ajaxCardApply() {
        $openid = $this->_openId;
        $cardid = $this->getParam('cardid');
        $cardinfo = $this->_Model->checkCardSend($cardid);
        if (!$cardinfo) {
            printJson(null, 0, '主银，此卡劵的有效期已过！');
            exit();
        }
        if ($cardinfo['status'] == 2) {
            printJson(null, 0, '主银，此卡劵不能申请补充噢！');
            exit();
        }
        $list = $this->_Model->listPartnerCard($cardid, $openid);
        $data = $this->_Model->checkPartnerCard($cardid, $openid);

        if ($list) {
            if ($list['sub_status'] == 0) {
                printJson(null, 0, '申请审核中');
                exit();
            }
            /* else if($list['sub_status'] == 2){
              printJson(null, 2, '审核未通过');
              exit();
              } */
        }

        //这里判断是否还能申请卡券
        if ($data['card_ceiling'] > $data['card_number']) { //可以申请
            $res = $this->_Model->addPartnerCardSup($cardid, $openid, $data);


            if ($res) {
                //更改合伙人卡券统计补充次数  和   合伙人统计补充次数
                $this->_Model->upParOrCardStu($cardid, $openid);
                printJson(null, 1, '申请成功');
                exit();
            }
            printJson(null, 1, '申请失败');
            exit();
        }
        printJson(null, 0, '主银，此卡劵不能申请补充噢！');
        exit();
    }

    /**
     *  发放页
     * 
     */
    public function issueWeb() {
        $openid = $this->_openId;
        $id = $this->getParam('id');

        $cardIssue = $this->_Model->listIssueCardWeb($id);
        $this->assign('cardIssue', $cardIssue);
        // 设置分享参数
        $shareParams = array(
            'shareTitle' => '秒入，人人有份！',
            'shareDesc' => '快请肌肤喝杯冰泉饮。5100万现金好礼，手慢无！',
            'shareImg' => 'http://sh.app.socialjia.com/5100Partner/www/Public/Index/images/hb.jpg',
            'shareUrl' => url('Obtaincard', 'receiveCard', array('cardid' => $cardIssue['card_id'], 'usopenid' => $openid, 'id' => $id), 'index.php'),
        );
        $this->setShare($shareParams);
        $this->assign('title', '发放');
        $this->display('Index.Card.issueweb');
    }

    /**
     * 领取卡券
     */
    public function receiveCard() {
        $openid = $this->_openId;
        $usopenid = $this->getParam('usopenid');
        $cardid = $this->getParam('cardid');
        $cardone = $this->_Model->listCardOne($openid, $cardid);
        $this->assign('cardone', $cardone);
        $this->display('Index.Card.receivecard');
    }

    /**
     * ajax合伙人自己获取卡券
     * 
     */
    public function getPartnerMyCard() {
        $card_id = $this->getParam('cardid');
        $openid = $this->_openId;
        //检查卡券是否过期
        $checkcard = $this->_Model->checkCardSend($card_id);
        if (!$checkcard) {
            printJson(null, 2, '次卡券已经过期！');
            exit();
        }
        // 获取该$openid的code
        $usercard = $this->_Model->getPartnerCardCode($card_id, $openid);
        if (!$usercard) {
            printJson(null, 2, '没有卡券了！');
            exit();
        }
        if ($usercard['status'] > 0) {
            printJson(null, 3, '卡券已被领取！');
            exit();
        }
        $code = $usercard['code'];

        //$code = $this->_Model->checkCode($code);


        $app_secret = Config::APP_SECRET;

        $time = time();
        $signArr = array(
            'app_secret' => $app_secret,
            'card_id' => $card_id,
            'code' => $code,
            'time' => $time
        );
        $datas['card_list'][] = array(
            'card_id' => $card_id,
            'card_ext' => json_encode(array(
                'openid' => $this->_openId,
                'code' => $code,
                'timestamp' => strval($time),
                'signature' => $this->_Signature($signArr)
            ))
        );
        printJson($datas, 0, $code);
        exit;
    }

    /**
     * ajax成功领取合伙人自己的卡券
     * 
     */
    public function successPartnerCard() {
        $code = $this->getParam("code");
        $cardid = $this->getParam("cardid");
        $openid = $this->_openId;
        //更改合伙人卡券状态
        $up = $this->_Model->upPartnerCardCode($code);
        if (!$up) {
            printJson(null, 2, '参数错误');
            exit();
        }
        //这里添加一个减少库存
        $cardStu = $this->_Model->checkPartnerCard($cardid, $openid);
        $arr = array(
            'card_receiv' => $cardStu['card_receiv'] + 1,
            'card_number' => $cardStu['card_number'] - 1
        );
        //更改合伙人卡券统计发放数
        $this->_Model->upPartnerCardStatistics($cardid, $openid, $arr);
        $partnerSta = $this->_Model->listPartnerStatisticsOne($openid);
        $arrto = array(
            'par_number' => $partnerSta['par_number'] - 1,
            'par_receiv' => $partnerSta['par_receiv'] + 1
        );
        //更改合伙人统计发放数
        $this->_Model->upPartnerStatistics($openid, $arrto);


        //添加卡券到领取记录
        $add = $this->_Model->addDrawflInfo($cardid, $openid, $code);

        printJson(0, 0, '修改成功');
        exit;
    }

    /**
     * ajax获取卡券
     * 
     */
    public function getCard() {

        $sue_id = $this->getParam('sueid');
        $card_id = $this->getParam('cardid');
        $usopenid = $this->getParam('usopenid');
        $openid = $this->_openId;
        if (empty($sue_id)) {
            $sue_id = '';
        }


        // 获取该$openid的分享的code
        $usercard = $this->_Model->getDrawflCardCode($card_id, $usopenid, $sue_id);
        if (!$usercard) {
            printJson(null, 2, '没有卡券了！');
            exit();
        }
        if ($usercard['state'] > 0) {
            printJson(null, 3, '卡券已被领取！');
            exit();
        }
        //查询判断合伙人设置的一个卡券能领取多少
        $data = $this->_Model->listPartnerCardIssue($sue_id);

        $count = $this->_Model->listCardCodeCount($openid, $sue_id);
        if ($count >= $data['limit_num']) {
            printJson(null, 4, '领取达到上限');
            exit();
        }


        $code = $usercard['code'];
        //修改卡券code为展示中
        $arr = array(
            'status_num' => $usercard['status_num'] + 1
        );
        $this->_Model->upCardCodeStatus($code, $arr);

        $app_secret = Config::APP_SECRET;

        $time = time();
        $signArr = array(
            'app_secret' => $app_secret,
            'card_id' => $card_id,
            'code' => $code,
            'time' => $time
        );
        $datas['card_list'][] = array(
            'card_id' => $card_id,
            'card_ext' => json_encode(array(
                'openid' => $openid,
                'code' => $code,
                'timestamp' => strval($time),
                'signature' => $this->_Signature($signArr)
            ))
        );
        printJson($datas, 0, $code);
        exit;
    }

    /**
     * ajax成功领取卡券
     * 
     */
    public function successCard() {
        $code = $this->getParam("code");
        $openid = $this->_openId;
        //更改卡券状态
        $up = $this->_Model->upCardDrawfl($code, $openid);
        if (!$up) {
            printJson(null, 2, '参数错误');
            exit();
        }
        printJson(0, 0, '修改成功');
        exit;
    }

    /*
     * 生成签名
     */

    private function _Signature($data) {
        $appId = C('APP_ID');
        $appSecret = C('APP_SECRET');
        $jsSign = new WxJsSign($appId, $appSecret);
        $apiTicket = $jsSign->getJsApiTicket('wx_card');
        $apiTicket = empty($apiTicket) ? $data['app_secret'] : $apiTicket;

        include_once LIB_PATH . '/Common/WXCard/CardPacket.class.php';
        $signature = new Signature();
        $signature->add_data($apiTicket);
        $signature->add_data($data['card_id']);
        $signature->add_data($data['code']);
        $signature->add_data($data['time']);
        $signature->add_data($this->_openId);
        $sign = $signature->get_signature();

        return $sign;
    }

    public function getcode() {
        $id = $this->getParam('id');
        $openid = $this->getParam('openid');
        $cardid = $this->getParam('cardid');

        //微信支付
        include_once LIB_PATH . '/Common/phpqrcode/phpqrcode.php';
        // 二维码数据 
        $data = url('Obtaincard', 'receiveCard', array('cardid' => $cardid, 'usopenid' => $openid, 'id' => $id), 'index.php');
        ;
        // 生成的文件名 
        $filename = 'baidu.png';
        // 纠错级别：L、M、Q、H 
        $errorCorrectionLevel = 'M';
        // 点的大小：1到10 
        $matrixPointSize = 2;
        //创建一个二维码文件 
        QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        //输入二维码到浏览器          
        QRcode::png($data);
    }

    public function ajaxCardCheck() {
        $openid = $this->_openId;
        $cardid = $this->getParam('cardid');
        $cardinfo = $this->_Model->checkCardSend($cardid);
        if (!$cardinfo) {
            printJson(null, 0, '主银，此卡劵的有效期已过！');
            exit();
        }
        if ($cardinfo['status'] == 2) {
            printJson(null, 0, '主银，此卡劵不能发放噢！');
            exit();
        }
        printJson(null, 1, '可以发放！');
        exit();
    }

}
