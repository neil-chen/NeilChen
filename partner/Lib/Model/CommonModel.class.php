<?php
/**
 * 公共Model
 */
class CommonModel extends Model
{
	private $_db;
	private $_dbHost;
	public function __construct()
	{
		parent::__construct();
		$this->_db = Factory::getDb();
	}


	
	/**
	 * 获取auth
	 *
	 * @return multitype:string number
	 */
	private function _getAuthParam()
	{
		$apiKey = C('API_KEY');
		$apiSecret = C('API_SECRET');
		$timestamp = time();
		return array(
				'apiKey' => $apiKey,
				'timestamp' => $timestamp,
				'sig' => md5($apiKey . $apiSecret . $timestamp)
		);
	}
	
	/**
	 * 通过API获取二维码
	 *
	 * @param string $media_name
	 * @return mixed
	 */
	public function getUerQrcToApi($mediaName, $param)
	{
		$sendParam = array(
				'a' => 'Qrcode',
				'm' => 'genUserSubscrib',
				'media_name' => $mediaName
		);

		$qrcConfig['scan_msg'] = $param['scanMsg'];
		$qrcConfig['subscrib_msg'] = $param['subscribMsg'];
		$qrcConfig['qrc_app_id'] = $param['qrc_app_id'];
		$qrcConfig['media_id'] = $param['media_id'];
		$qrcConfig['is_tip'] = $param['is_tip'];
		$qrcConfig['group_id'] = $param['group_id'];
		$sendParam = array_merge($qrcConfig, $sendParam);
		$sendParam = array_merge($this->_getAuthParam(), $sendParam);
		// 执行curl调用接口
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, C('API_URL'));
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, 1);
		$body = http_build_query($sendParam);

		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$httpInfo = curl_getinfo($curl);
		curl_close($curl);
		return $response;
	}
	
	/**
	 * 通过API获取用户
	 *
	 * @param string $openid
	 * @return mixed
	 */
	public function getUserToApi($openid)
	{
		$sendParam = array(
				'openid' => $openid,
				'a' => 'User',
				'm' => 'get'
		);

		$sendParam = array_merge($this->_getAuthParam(), $sendParam);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, C("API_URL"));
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, 1);
		$body = http_build_query($sendParam);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$httpInfo = curl_getinfo($curl);
		curl_close($curl);
		return $response;
	}
    
    /**
     * API发送消息
     *
     * @param arary $param
     * @return mixed
     */
    public function sendMsg($param, $title = '') {
        $sendParam = array(
            'a' => 'Send',
            'm' => 'send'
        );
        $apiUrl = C('API_URL');

        $sendParam = array_merge($this->_getAuthParam(), $sendParam);
        $sendParam = array_merge($param, $sendParam);
        // var_dump($sendParam);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        $body = http_build_query($sendParam);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($curl);
        curl_close($curl);
        $title = $title ? $title : 'Loss';
        Logger::debug($title . '活动 : 用户API发送消息结果： httpCode：' . $httpCode, array(
            'body' => $body,
            'response' => json_decode($response, true),
            'httpInfo' => $httpInfo
        ));
        return $response;
    }
	
	/**
	 * 消息表 插入消息
	 * @author wangpg
	 * @param string $openid 用户openid
	 * @param string $text   消息内容
	 * @return boolean|integer 返回插入成功或失败，成功时返回insertId
	 */
	public function insertOneMessage($openid, $text){
	    $set = array();
	    $set['openid'] = $openid;
	    $set['message'] = $text;
	    $set['create_time'] = time();
	    try{
	       $insertId = $this->_db->insert('wx_partner_message', $set);
	    }catch(Exception $e){
	        Logger::error($e->getMessage()."<br/>".$this->_db->getLastSql());
	        return false;
	    }
        $param['type'] = 'text';
        $param['toUsers'] = $openid;
        $param['content'] = $text;

        $this->sendMsg($param);
	    return $insertId;
	}
        
        /**
        * 微信消息处理
        *
        * @param   string   $openid     用户唯一标识
        * @param   string   $content    文本内容
        *
        * @return  string|bool
        */
        public function msgText($openid, $content = '')
        {
            $template = '<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                        </xml>';
            return sprintf($template, $openid, Config::APP_USER, time(), $content);
        }
}