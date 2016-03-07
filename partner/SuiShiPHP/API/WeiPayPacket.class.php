<?php

/* 
 * 红包发送
 */
class WeiPayPacket {
    
    public $apiUrl = 'https://wxapp.tenpay.com/app/v1.0/wxhb_payreq_sp.cgi';
    
    public $sendNumber = 50;
    
    public $enabledStart = 8;
    
    public $inputCharset = 'UTF-8';   
    
    public $appId = null;
    
    public $appkey = null;
    
    public $spid = null;
    
    public $dayMaxNumber = 10000;
    
    public $minuteMaxNumber = 50;
    
    public $userDayMaxNumber = 2;
    
    public $userMonthMaxNumber = 10;
    
    private $maxMoney = 100;
    
    private $minMoney = 1;
    
    private $error = '';
    
    private $param = array();

    public function __construct($appId ,$appkey,$spid) {
        $this->appId = $appId;
        $this->appkey = $appkey;
        $this->spid = $spid;
    }
    /**
     * 格式化参数列表 
     * @param array $paraMap 要格式化的数据
     * @param boolean $urlencode 是否将值urlencode
     * @return string
     */
    static public function formatParam($paraMap,$urlencode = false){
        $buff = "";
        ksort($paraMap);        
        foreach ($paraMap as $k => $v){
            if (null != $v && "sign" != $k) {
                $urlencode && $v = self::urlEncode($v);                
                $buff .= $k.'='.$v.'&';
            }
        }
       return substr($buff, 0, -1);       
    }   
    
    /**
     * MD5签名方式
     * @param array $unSignPara 待签名数组
     * @param boolean $lower 参数数组的键是否转化为小写
     * @return string 签名后的数据
     */
    public function md5Sign($unSignPara){
        $unSignParaString = self::formatParam($unSignPara);        
        return strtoupper(md5($unSignParaString.'&key='.$this->appkey));
    }
    
    private function createPacketParam(){      
        $this->param['input_charset'] = $this->inputCharset;
        $this->param['spid'] = $this->spid;
        $this->param['wxappid'] = $this->appId;
        isset($this->param['client_ip']) || $this->param['client_ip'] = getIp();            
        if(!$this->checkMoney()){
            $this->setError('红包金额必须为1-100元这间！');
            return false;
        }else{//红包单位是分
            $this->param['total_amount'] *= 100;
        }
        $this->param['max_value'] = $this->param['min_value'] = $this->param['total_amount'];          
        $this->param['total_num'] = 1;     
        $sign = $this->md5Sign($this->param);
        $this->param['sign'] = $sign;
        return true;
    }
    
    public function sendPacket($param){

        if(!$this->sendCheck()){
            $this->setError('当前时间段不允许发送红包！');
            return false;
        }
        $this->setParam($param);

        if($this->createPacketParam()){
            /*class_exists('WeiXinApiRequest') ||
                include_once SUISHI_PHP_PATH.'/API/WeiXinApiRequest.class.php'; 

            $result = WeiXinApiRequest::post($this->apiUrl, http_build_query($this->param),0,0); */ 
//echo http_build_query($this->param);
//exit;
            $r = WeiPayPacket_http_post($this->apiUrl, $this->param);

            return json_decode($r, true); 
          
        }
        
        
    }
    
    static public function urlEncode($str){
        return str_replace('+', '%20',urlencode($str));
    }
    
    private function checkMoney(){     
        return isset($this->param['total_amount'])                 
                && $this->param['total_amount'] >= $this->minMoney 
                && $this->param['total_amount'] <= $this->maxMoney;
    }
    
    private function setParam($param){
        $this->param = array();        
        foreach($param as $key => $value){
            $key = trim($key);
            $value = trim($value);
            empty($value) || empty($key) || $this->param[$key] = $value;
        }
    }
    
    private function setError($msg){
        $this->error = $msg;
    }
    
    public function getError(){
        return $this->error;
    }

    /**
     * 检查是否在允许发送红包的时间 <br />
     * 北京时间 0：00-8：00 不能触发红包赠送 <br />
     * 这里提前2分钟停止发送，推后2分钟开始发送
     * @return boolean
     */
    public function sendCheck(){
        $now = time();
        $today = strtotime('today');
        $start = $today + $this->enabledStart * 3600 + 120;
        return $now > $start && 3600*24 - $now + $today > 120;
    }
    
}

	function WeiPayPacket_http_post($url, $postdata, $timeout=10) {
			$data = '';
			foreach($postdata as $k => $v){
				$data .= $k.'='.$v.'&';
			}
			$data = rtrim($data,'&');
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);

  
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //

			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$return_content = curl_exec($ch);
			if (!$return_content) {

			}
			curl_close($ch);
			return $return_content;
	}


/*
ini_set('display_errors',1);
error_reporting(E_ALL);
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');


$appId  = 'wx4b4bd4343de3f32b';
$appkey = '42478edad91129dce1765b92f40378ea';
$spid   = '1220155201';


$arr = array(
'sign'=>null,
'sp_billno'=>'1220155201201408150000000036',
'spid'=>null,
'wxappid'=>null,
'nick_name'=>'测1试1',						
'send_name'=>'测试',						//oSET1jqCbZVBynuNHHCd6JnCPoq8  坚
're_openid'=>'oSET1jjK5W8y8Xfvd6HHnoNaOxBc',//oSET1jjK5W8y8Xfvd6HHnoNaOxBc  我
'total_amount'=>1,
'min_value'=>1,
'max_value'=>1,
'total_num'=>1,
'wishing'=>'祝你好运',
'client_ip'=>'10.148.150.151',
);

$c = new WeiPayPacket($appId ,$appkey,$spid);

$r = $c->sendPacket($arr);
echo '<pre>';
print_r($r);
echo '<hr>';
print_r($c);*/

