<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
/**
 * 微信 JS SDK 配置
 * 
 * 注意：
 * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
 * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
 * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
 *
 * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
 * 邮箱地址：weixin-open@qq.com
 * 邮件主题：【微信JS-SDK反馈】具体问题
 * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
 */

wx.config({

    debug     : false,
    appId     : '<?php echo !isset($appId) ? '' : $appId; ?>',
    timestamp : '<?php echo !isset($signPackage["timestamp"]) ? '' : $signPackage["timestamp"]; ?>',
    nonceStr  : '<?php echo !isset($signPackage["nonceStr"])  ? '' : $signPackage["nonceStr"]; ?>',
    signature : '<?php echo !isset($signPackage["signature"]) ? '' : $signPackage["signature"]; ?>',

    // 微信控件白名单
    jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'startRecord',
        'stopRecord',
        'onVoiceRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'onVoicePlayEnd',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'translateVoice',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
    ]
});

wx.ready(function () {

    // 分享标题
    shareTitle  = '<?php echo !isset($shareTitle)  ? '' : $shareTitle; ?>';

    // 分享描述
    shareDesc   = '<?php echo !isset($shareDesc)   ? '' : $shareDesc; ?>';

    // 分享链接
    shareLink   = '<?php echo !isset($shareUrl)    ? '' : $shareUrl; ?>';

    // 分享图标
    shareImgUrl = '<?php echo !isset($shareImgUrl) ? '' : $shareImgUrl; ?>',

    // 分享到朋友圈
    wx.onMenuShareTimeline({

        title  : shareTitle,
        desc   : shareDesc,
        link   : shareLink,
        imgUrl : shareImgUrl,
        success: function () {
            // 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
        }
    });

    // 分享给朋友
    wx.onMenuShareAppMessage({
        title  : shareTitle,
        desc   : shareDesc,
        link   : shareLink,
        imgUrl : shareImgUrl,
        type   : '',    // 分享类型,music、video或link，不填默认为link
        dataUrl: '',    // 如果type是music或video，则要提供数据链接，默认为空
        success: function (res) {
            // 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
        }
    });

    // 批量隐藏功能按钮接口
    wx.hideMenuItems({

        // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
        menuList: ['menuItem:share:qq', 'menuItem:share:weiboApp', 'menuItem:favorite', 'menuItem:share:facebook',
            'menuItem:share:QZone', 'menuItem:editTag', 'menuItem:delete',
            'menuItem:originPage', 'menuItem:readMode', 'menuItem:openWithQQBrowser', 'menuItem:openWithSafari',
            'menuItem:share:email', 'menuItem:share:brand', 'menuItem:copyUrl'
        ]
    });
});

wx.error(function(res){
    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
});

</script>