<?php
/**
 * 5100--ACTION类
 */
class CancelAction extends Action
{
    private $_Model;
    
    public function __construct(){
        parent::__construct();
        $this->_Model = loadModel('Index.Cardto');
        
    }               
   
    
    
    /**
    * 核销卡券记录
    * 
    */
    public function cancelCard(){
        //$openid = $this->getParam("openid");    
        //$cardid = $this->getParam("cardid"); 
        $code = $this->getParam("code"); 
        $str = $this->getParam("str"); 
        if($str != 123){
            printJson(null, 0, '验证失败');
            exit;   
        }
        $res = $this->_Model->listGetCodeLog($code);
        if(!$res){
            printJson(null, 0, '没有卡券');
            exit;    
        }
        if($res['state'] == 3){
            printJson(null, 3, '已被核销');
            exit;       
        }
        //根据code更新卡券为核销
        $ret = $this->_Model->upCancelCard($code);
        if(!$ret){
            printJson(null, 2, '核销失败');
            exit;       
        }
        printJson(null, 1, '核销成功');
        exit;
           
    }


}
