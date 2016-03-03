json文件抽奖

示例文件： textnew.html
数据文件实例：zsh20150623164302.txt（json格式）
详情请查看：textnew.html

使用方法：运行textnew.html,选择zsh20150623164302，输入抽奖数量，抽取，导出支持IE，发送服务器需要后台接收数据然后正确返回，比如

<?php
$data = ".......";
$callback = $_GET['callback'];
echo $callback.'('.json_encode($data).')';
exit; 
?>