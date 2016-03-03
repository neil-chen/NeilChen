<?php

//entid 易维成配置企业号编号

//获取openid  $_GET['openid']
$nowUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url = "http://call.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=1&url=" . urlencode($nowUrl);
header("location:$url");


//易维城接口获取用户信息   --  是否关注用户 （采用token获取用户信息 -- 基础获取）
//获取用户基本信息   -- 是否关注
//API_KEY = 易维城配置KEY
//API_SECRET = 易维城配置SECRET
//API_KEY = 'api.socialjia.com/index.php'
    $apiKey = C('API_KEY');     
    $apiSecret = C('API_SECRET');
    $apiUrl = C('API_URL');
    $timestamp = time();
    //签名
    $sig = md5($apiKey . $apiSecret . $timestamp);
    $param = array(
        'a' => 'User',
        'm' => 'get',
        'apiKey' => $apiKey,
        'timestamp' => $timestamp,
        'sig' => $sig,
        'openid' => $_GET['openid']
    );  
    $sub_user = $this->getSubUser($param, $apiUrl); 
    $subuser_json = urldecode($sub_user);
    $subuser_arr = json_decode($subuser_json, true);
    //$subuser_arr返回用户信息   
    
/*
 * 获取用户关注信息  关注获取 
 */
function getSubUser($sendParam, $apiUrl)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POST, 1);
    $body = http_build_query($sendParam);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $httpInfo = curl_getinfo($curl);
    curl_close($curl);
    return $response;
}         

/**     返回参数
* {
    "data": {
        "openid": "xxxx",   
        "subscribe": 1,                //1：已关注， 0：未关注 
        "nickname": "xxxx",        //用户昵称
        "sex": 2,                    //性别  1：男 ，2：女 ，0：未知
        "city": "xxxx",                //用户城市
        "province": "xxxx",            //用户省份
        "country": "xxxx"            //用户国家
    },
    "error": 0, 
    "msg": ""
}
注：非关注用户只返回,openid 和 subscribe

*/
    
    
//网页授权获取用户信息   --  跳转微信授权页面
//获取code 调用后返回连接上回带上wxcode   获取方式   $_GET['wxcode']
$nowUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url = "http://call.socialjia.com/Wxapp/weixin_common/oauth2.0/link.php?entid=1&scope=snsapi_userinfo&response_type=code&url=" . urlencode($nowUrl);

//用获取的code调用用户信息
//调用参数同上
//code = $_GET['wxcode']
$apiKey = C('API_KEY');
$apiSecret = C('API_SECRET');
$apiUrl = C('API_URL');
$timestamp = time();
$sig = md5($apiKey . $apiSecret . $timestamp);
$param = array(
    'a' => 'userInfo',
    'm' => 'getUserInfoByCode',
    'apiKey' => $apiKey,
    'timestamp' => $timestamp,
    'sig' => $sig,
    'code' => $_GET['wxcode']
);  
$user_info = $this->getUserInfo($param, $apiUrl);

$user_json = urldecode($user_info);
$user_arr = json_decode($user_json, true);

/*
 * 获取用户基本信息 --网页授权
 */
function getUserInfo($sendParam, $apiUrl)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POST, 1);
    $body = http_build_query($sendParam);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $httpInfo = curl_getinfo($curl);
    curl_close($curl);
    return $response;
}

/**     返回参数
* 
* {
    "data": {
       "openid":" OPENID",
       " nickname": NICKNAME,
       "sex":"1",
       "province":"PROVINCE"
       "city":"CITY",
       "country":"COUNTRY",
       "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46", 
       "privilege":[
         "PRIVILEGE1"
         "PRIVILEGE2"
       ]
    },
    "error": 0, 
    "msg": ""
}
注：
openid:用户的唯一标识
nickname:用户昵称
sex:用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
province:用户个人资料填写的省份
city:普通用户个人资料填写的城市
country:国家，如中国为CN
headimgurl:用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空
privilege:用户特权信息，json 数组，如微信沃卡用户为（chinaunicom）

*/
