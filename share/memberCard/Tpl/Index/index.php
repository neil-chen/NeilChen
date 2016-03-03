<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="zh-CN" />
        <meta id="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1, user-scalable=no" name="viewport" />
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <meta content="telephone=no" name="format-detection">
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link rel="stylesheet" type="text/css" href="Public/css/index.css">
        <script src="Public/js/jquery-1.9.1.min.js"></script>
        <script src="Public/js/TouchSlide.1.1.js"></script>
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
                    'checkJsApi',
                    'addCard',
                    'chooseCard',
                    'openCard',
                    'hideMenuItems',
                    'showMenuItems',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'onMenuShareWeibo',
                ]
            });
            $(function () {
                //领取卡券
                var data = {
                    id: 1,
                    appId: '<?php echo $data['appId']; ?>',
                    timestamp: <?php echo $data['timestamp']; ?>,
                    nonceStr: '<?php echo $data['nonceStr']; ?>',
                    signature: '<?php echo $data['signature']; ?>'
                };

                var code = '<?php echo $code; ?>';

                wx.ready(function () {
                    if (code) {
                        wx.openCard({
							cardList: [{
								cardId: '<?php echo $card_id; ?>',
								code: code
							}]// 需要打开的卡券列表
						});
                        return false;
                    }

                    var url = "<?php echo url(__ACTION_NAME__, 'addCard'); ?>";
                    $.post(url, data, function (data) {
                        var json = $.parseJSON(data);
                        if (json.error == 0) {
                            atr = json.data;
                            wx.addCard({
                                cardList: atr.card_list,
                                success: function (res) {
                                    alert('领取成功，进入微信>我>卡包查看');
                                    wx.closeWindow(); //完成后关闭页面
                                }
                            });
                        } else {//if json.error==0
                            alert(json.msg);
                            wx.closeWindow(); //完成后关闭页面
                            return false;
                        }
                    }); //end post

                }); //end wx.ready
            });
        </script>

    </body>
</html>