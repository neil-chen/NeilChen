<!DOCTYPE html>
<html>
    <head>
        <title>激活成功</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="zh-CN" />
        <meta id="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1, user-scalable=no" name="viewport" />
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <meta content="telephone=no" name="format-detection">
        <script src="Public/js/jquery-1.9.1.min.js"></script>
    </head>
    <body>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript">
            wx.config({
                debug: false,
                appId: '<?php echo $data['appId']; ?>',
                timestamp: <?php echo $data['timestamp']; ?>,
                nonceStr: '<?php echo $data['nonceStr']; ?>',
                signature: '<?php echo $data['signature']; ?>',
                jsApiList: [
                    'closeWindow',
                ]
            });
            //激活成功后关闭窗口
            wx.ready(function () {
                wx.closeWindow();
            });
        </script>
    </body>
</html>