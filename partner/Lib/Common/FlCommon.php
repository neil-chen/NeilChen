<?php
/**
* 函数库
*
* @author     熊飞龙
* @date       2015-11-05
* @copyright  Copyright (c)  2015
* @version    $Id$
*/


/**
 * 返回 json 格式数组
 *
 * @param  string  $message     消息
 * @param  boolean $status      状态
 * @param  array   $data        需要传递的数据
 *
 * @return string
 */
function jsonExit($message = 'ok', $status = true, array $data = array())
{
    $result = array(
        'message' => $message,
        'status'  => (bool) $status,
        'data'    => $data,
    );

    exit(json_encode($result));
}

function showMsg($msg = '未知错误')
{
    echo $msg;
    exit;
}


/**
 * 获得用户登录的信息
 */
if (!function_exists('getUserInfo')) {
    function getUserInfo()
    {
        return !isset($_SESSION['userInfo']) ? array() : $_SESSION['userInfo'];
    }
}

/**
 * 追加用户信息
 */
if (!function_exists('appendUserInfo')) {
    function appendUserInfo(&$params, $key)
    {
        $user = getUserInfo();
        $params[$key . '_time']      = date('Y-m-d H:i:s');
        $params[$key . '_user_id']   = $user['user_id'];
        $params[$key . '_user_name'] = $user['user_name'];
    }
}

/**
 * 追加用户创建信息
 */
if (!function_exists('appendCreateInfo')) {
    function appendCreateInfo(&$params)
    {
        appendUserInfo($params, 'create');
    }
}

/**
 * 追加用户更新信息
 */
if (!function_exists('appendUpdateInfo')) {
    function appendUpdateInfo(&$params)
    {
        appendUserInfo($params, 'update');
    }
}

/**
 * 追加用户创建更新信息
 */
if (!function_exists('appendCreateUpdate')) {
    function appendCreateUpdate(&$params)
    {
        appendCreateInfo($params);
        appendUpdateInfo($params);
    }
}