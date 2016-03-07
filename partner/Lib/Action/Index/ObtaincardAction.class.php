<?php
/**
 * 5100--ACTION类
 */
class ObtaincardAction extends WebAction
{
    private $_Model;
    private $_openid;
    
    public function __construct(){
        parent::__construct();
        $this->_Model = loadModel('Index.Cardto');
        /*$this->_openid = $this->getParam("openid");
        if(!isset($_COOKIE['5100openid']) || empty($_COOKIE['5100openid']) ){
            if (!isset($this->_openid) && empty($this->_openid)) {
                $nowUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $url = "http://call.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=" . C('ENT_ID') . "&url=" . urlencode($nowUrl);
                header("location:$url");
                exit;    
            }
            setcookie("5100openid", $this->_openid, time() + 86400);
            $_COOKIE['5100openid'] = $this->_openid;       
        }else{
            $this->_openid = $_COOKIE['5100openid'];    
        }*/
        $this->_openid = $this->_openId;
        //$this->_openid = 'oaCwJs_TMDNrapbDen7v1sBfdu6I';
                                                                                                                
        //$partner = $this->_Model->getPartner($this->_openid);
        
        //$this->assign('partner', $partner);
        $this->assign('openid', $this->_openid); 
        
    }               
   
    
    /**
    * 领取卡券
    */
    public function receiveCard(){
        $openid = $this->_openid;
        $usopenid = $this->getParam('usopenid');
        $id = $this->getParam('id');    
        $cardid = $this->getParam('cardid');    
        $cardone = $this->_Model->listCardOne($usopenid,$cardid);
        $cardissue = $this->_Model->listPartnerCardIssue($id);
        $this->assign('cardissue', $cardissue);
        $this->assign('cardone', $cardone);
        $this->assign('usopenid', $usopenid);
        $this->assign('title', '领取发放');
        $this->display('Index.Card.receivecard');    
    }
    
  
    
    
    
    /**
    * ajax获取卡券
    * 
    */
    public function getCard(){
        
        $sue_id = $this->getParam('sueid');
        $card_id = $this->getParam('cardid');
        $usopenid = $this->getParam('usopenid');
        $openid = $this->_openid;
        //检查卡券是否过期
        $checkcard = $this->_Model->checkCardSend($card_id);
        if(!$checkcard){
            printJson(null, 2, '次卡券已经过期！');  
            exit();    
        }
        
        // 获取该$openid的分享的code
        $usercard = $this->_Model->getDrawflCardCode($card_id, $usopenid,$sue_id); 
         
        if (!$usercard) {
            printJson(null, 2, '没有卡券了！');
            exit();
        }
        if($usercard['state'] > 0){
            printJson(null, 3, '卡券已被领取！');
            exit();    
        }
        //查询判断合伙人设置的一个卡券能领取多少
        $data = $this->_Model->listPartnerCardIssue($sue_id);
        
        $count = $this->_Model->listCardCodeCount($openid,$sue_id);
        
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
    public function successCard(){
        $code = $this->getParam("code"); 
        $id = $this->getParam("id"); 
        $usopenid = $this->getParam('usopenid');
        $cardid = $this->getParam('cardid');
        $openid = $this->_openid;   
        //更改卡券状态
        $up = $this->_Model->upCardDrawfl($code,$openid,$usopenid);
        if (!$up) {
            printJson(null, 2, '参数错误');
            exit();
        }  
        
        $cardStu = $this->_Model->checkPartnerCard($cardid, $usopenid);
        $arr = array(
            'card_receiv' => $cardStu['card_receiv']+1,
            //'card_number' => $cardStu['card_number']-1
        );  
        //更改合伙人卡券统计发放数
        $this->_Model->upPartnerCardStatistics($cardid, $usopenid, $arr);
        $partnerSta = $this->_Model->listPartnerStatisticsOne($usopenid);
        
        //更改合伙人卡券发放数据
        $this->_Model->upParCardSend($id);
        
        
        $arrto = array(
            //'par_number' => $partnerSta['par_number']-1, 
            'par_receiv' => $partnerSta['par_receiv']+1
        );
        //更改合伙人统计发放数
        $this->_Model->upPartnerStatistics($usopenid, $arrto);
            
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
        $signature->add_data($this->_openid);
        $sign = $signature->get_signature();

        return $sign;
    }



}
