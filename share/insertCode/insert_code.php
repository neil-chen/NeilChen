<?php

//定义头编码
header('Content-Type:text/html;charset=UTF-8');
//定义文件路径
define(CODE_FILE_NAME, 'quan.csv');

//打开code文件
$file = fopen(dirname(__FILE__) . '/' . CODE_FILE_NAME, 'r');
$codes = array();
while (!feof($file)) {
    $codes[] = array_filter(fgetcsv($file));
}
fclose($file);

//链接数据库
$con = mysql_connect('124.248.33.194', 'root', 'root');
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
//选择数据库
mysql_select_db('weixinapp_cocacola_station', $con);
//截断Code表
mysql_query("TRUNCATE wx_code");
//批量插入Code
foreach ($codes as $line) {
    //解析code数组拼写为sql语句
    $insert = "INSERT INTO wx_code (code) VALUES " . implode(',', array_map('addKuohao', $line));
    try {
        mysql_query($insert);
    } catch (Exception $e) {
        //执行错误抛出异常
        echo $e->getMessage();
    }
}
//插入结束关闭链接
mysql_close($con);

//处理元素用于插入
function addKuohao($v) {
    return "('$v')";
}
