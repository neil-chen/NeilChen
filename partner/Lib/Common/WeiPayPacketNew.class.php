<?php

class WeiPayPacketNew {

    //public  $apiUrl         = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack' ;
    public $apiUrl = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    public $appId = null;
    public $appkey = null;
    public $spid = null;
    public $dayMaxNumber = 10000;
    public $minuteMaxNumber = 50;
    public $userDayMaxNumber = 1;
    public $userMonthMaxNumber = 1;
    private $maxMoney = 5000;
    private $minMoney = 1;
    private $error = '';
    private $param = array();
    public $inputCharset = 'UTF-8';
    public $sendNumber = 50;
    public $enabledStart = 8;

    public function __construct($appId, $appkey, $spid) {
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
    static public function formatParam($paraMap, $urlencode = false) {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if (null != $v && "sign" != $k) {
                $urlencode && $v = self::urlEncode($v);
                $buff .= $k . '=' . $v . '&';
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
    public function md5Sign($unSignPara) {
        $unSignParaString = self::formatParam($unSignPara);
        return strtoupper(md5($unSignParaString . '&key=' . $this->appkey));
    }

    private function createPacketParam() {
        //$this->param['input_charset'] = $this->inputCharset;
        // $this-> param['mch_id' ] = $this->spid;
        $this->param['mchid'] = "1237870602";
        //$this-> param['wxappid' ] = $this->appId;
        $this->param['mch_appid'] = "wxf305030001374a81";
        isset($this->param ['spbill_create_ip']) || $this->param['spbill_create_ip'] = getIp();
        /*
          if(!$this->checkMoney()){
          $this->setError( '红包金额必须为1-200元这间！' );
          return false;
          } else{//红包单位是分
          $this-> param['total_amount'] =$this-> param['total_amount']*100;
          }
         */
        //$this-> param['max_value' ] = $this->param['min_value' ] = $this->param['total_amount' ];         
        //$this-> param['total_num' ] = 1;
        //$this-> param['nonce_str' ] = strtoupper(md5(time()));
        $sign = $this->md5Sign($this->param);
        $this->param['sign'] = $sign;
        return true;
    }

    public function sendPacket($param) {

        //if(!$this->sendCheck()){
        //$strXMLData = "<xml><result_code><![CDATA[NOTIME]]></result_code><return_msg><![CDATA[当前时间段不允许发送红包！]]></return_msg></xml>";
        // return $strXMLData;
        //}
        $this->setParam($param);
        $data = false;

        if ($this->createPacketParam()) {
            $strXMLData = "<xml>";
            foreach ($this->param as $key => $val) {
                $strXMLData .= '<' . $key . '>' . $val . '</' . $key . '> ';
            }
            $strXMLData .= '</xml>';

            $data = $this->sendXMLDate($this->apiUrl, $strXMLData);

            //print_r($data);
        }
        return $data;
    }

    static public function urlEncode($str) {
        return str_replace('+', '%20', urlencode($str));
    }

    private function checkMoney() {
        return isset($this->param ['total_amount']) && $this->param['total_amount'] >= $this->minMoney && $this->param['total_amount'] <= $this->maxMoney;
    }

    private function setParam($param) {
        $this->param = array();
        foreach ($param as $key => $value) {
            $key = trim($key);
            $value = trim($value);
            empty($value) || empty($key) || $this->param[$key] = $value;
        }
    }

    private function setError($msg) {
        $this->error = $msg;
    }

    public function getError() {
        return $this->error;
    }

    /**
     * 检查是否在允许发送红包的时间 <br />
     * 北京时间 0：00-8：00 不能触发红包赠送 <br />
     * 这里提前2分钟停止发送，推后2分钟开始发送
     * @return boolean
     */
    public function sendCheck() {
        $now = time();
        $today = strtotime('today');
        $start = $today + $this->enabledStart * 3600 + 120;
        return $now > $start && 3600 * 24 - $now + $today > 120;
    }

    public function sendXMLDate($url, $body) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_SSLCERT,'/projects/weixin_project/wugudaochang/Lib/key/rootca.pem');
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($curl, CURLOPT_SSLCERT, '/projects/weixinapp/5100App/Admin/Lib/Common/WxPay/cacert/apiclient_cert.pem');
        curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($curl, CURLOPT_SSLKEY, '/projects/weixinapp/5100App/Admin/Lib/Common/WxPay/cacert/apiclient_key.pem');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($curl);
        Logger::debug('红利接口返回信息', $response);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($curl);
        curl_close($curl);
        return $response;
    }

}
