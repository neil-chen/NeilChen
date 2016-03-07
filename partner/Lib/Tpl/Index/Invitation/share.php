<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta id="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1, user-scalable=no" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta name="keywords" content="" />
<meta name="description" content="" />
<script type="text/javascript" src="./Public/Index/js/zepto.min.js"></script>
<link rel="stylesheet" type="text/css" href="./Public/Index/css/index.css">

<style>

html,body{ height:100%; min-height:540px}
body{ background:url(./Public/Index/images/bgnew.jpg) no-repeat center bottom #ebf6fc; background-size:100% 100%}
.hdgz ul li{color:#000}
.hdgz{
	border: none;
	text-shadow: 0px 1px 8px #FFF
}
.hdgz.new{ margin-top:30px}
@media screen and (max-height : 480px) {
    .hdgz.new div{ font-size:0.9em}
    .ewm img{ width:180px}	
}
@media screen and (max-width : 320px) { 
.hdgz.new div{ font-size:0.9em}
    .ewm img{ width:180px}  
}
</style>
</head>
<body>
<!--领取-->
    <div class="vip new">

    </div>



    <div class="hdgz new">
        <div style="padding: 0 20px; text-align: center;line-height: 35px; text-shadow:0 2px 1px #FFF;">
            <?php echo $partnerInfo['name']; ?> 已经加入了一个精彩的世界<br />
            你还在等什么？ COME ON~!<br/>
            （长按二维码，即可加入精彩世界）
        </div>
    </div>

    <?php if (!empty($infoQr)) { ?>
        <div class="ewm" style="text-align:center; padding-top:40px; padding-bottom:0px; position:absolute; width:100%; text-align:center; bottom:0px">
            <img src="<?php echo $infoQr['qrc_url']; ?>" style="bottom:-30px"/><br/>
            <img src="./Public/Index/images/bgnew.png" class="newnn" />
        </div>
    <?php } else { ?>
        <div class="ewm"><br>缺少扫描参数</div>
    <?php } ?>
</body>
</html>