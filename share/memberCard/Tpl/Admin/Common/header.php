<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>惠氏后台管理系统</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="Public/admin/css/base.css" type="text/css" />
        <link rel="stylesheet" href="Public/admin/css/admin.css" type="text/css" />
        <script type="text/javascript" src="Public/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="Public/js/TouchSlide.1.1.js"></script>
        <script type="text/javascript" src="Public/admin/js/common.js"></script>
        <script type="text/javascript" src="Public/admin/js/popwin.js"></script>
        <script type="text/javascript" src="Public/admin/js/qDialog.js"></script>
        <script type="text/javascript">
            var siteUrl = "{$smarty.const.SITE_URL}";
            var uploadUrl = "{$smarty.const.UPLOAD_URL}";
            var isAdmin = 1;
        </script>
        <script>
            $(function () {
                // 页面高度
                var windowHeight = $(window).height();
                var domHeight = $(document).height();
                if (domHeight > windowHeight) {
                    windowHeight = domHeight;
                }
                if ($(".inner-center").height() < windowHeight - 66) {
                    $(".inner-center").css('min-height', windowHeight - 66);
                    //$('body').css('overflow', 'hidden');
                }

                // 用户设置浮层
                $(".js_userSetBtn").click(function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    $(".js_cardSetBox").addClass('hidden');
                    if ($(".js_userSetBox").hasClass('hidden')) {
                        $(".js_userSetBox").removeClass('hidden');
                    } else {
                        $(".js_userSetBox").addClass('hidden');
                    }
                });


                // 设置密码
                $('.js_userSetting').click(function () {
                    var content = $('<div class="float-prompt-con"><div>\
                        <span>旧密码：</span><input class="oldPwd" type="password" name="password" value=""><br><br>\
                        <span>新密码：</span><input class="newPwd" type="password" name="newpassword" value=""><br><br>\
                        <span>重复密码：</span><input class="rePwd" type="password" name="repassword" value=""><br><br>\
                        </div></div>');
                    content.find('span').css({'display': 'inline-block', 'width': '95px'});

                    var DD = ace.dialog({
                        'title': '修改密码',
                        'content': content,
                        'init': function () {
                            $('.aceDialog').width(400);
                        },
                        'ok': function () {
                            var password = $.trim(content.find('.oldPwd').val()),
                                    newpassword = $.trim(content.find('.newPwd').val()),
                                    repassword = $.trim(content.find('.rePwd').val());
                            var user_id = "<?php echo $_COOKIE['huishi_admin_uid']; ?>";
                            if (!password) {
                                showMsg('旧密码不用为空');
                                return;
                            }
                            if (!newpassword) {
                                showMsg('新密码不用为空');
                                return;
                            }
                            if (!repassword) {
                                showMsg('重复密码不用为空');
                                return;
                            }
                            if (newpassword != repassword) {
                                showMsg('两次密码输入不一致');
                                return;
                            }
                            var postData = {
                                'user_id': user_id,
                                'password': password,
                                'newpassword': newpassword,
                                'repassword': repassword
                            };
                            $.post(
                                    "<?php echo url('Index', 'password', array(), 'admin.php'); ?>",
                                    postData,
                                    function (json) {
                                        showMsg(json['msg']);
                                        if (json['error'] == 0) {
                                            $(".float-prompt").css({'display': 'none'});
                                            $(".float-bg").css({'display': 'none'});
                                        }
                                    }, 'json');
                        },
                        'cancelValue': ''
                    });
                });
            });
        </script>
    </head>
    <body>
        <div id="wrap">
            <div class="header">
                <div class="htop clearfix">
                    <h1 class="logo left">惠氏后台管理系统</h1>
                    <div class="infotop">
                        <a href="javascript:void(0);" class="userpic">
                        </a>
                        <span class="username-right js_userSetBtn"> 
                            <a href="javascript:;" class="username">
                                <?php
                                if (isset($_COOKIE['huishi_admin_username'])) {
                                    echo $_COOKIE['huishi_admin_username'];
                                }
                                ?>
                            </a>
                            <span class="arrowtop"><i></i></span>
                        </span>
                        <div class="poptop poptop-user js_userSetBox hidden">
                            <em>◆</em>
                            <ul>
                                <li><a href="javascript:;" class="js_userSetting">修改密码</a></li>
                                <!--<li><a href="{AnUrl('')}" target="_blank">预览首页</a></li>-->
                                <li><a href="<?php echo url('Index', 'signout', array(), 'admin.php'); ?>">退出登录</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">