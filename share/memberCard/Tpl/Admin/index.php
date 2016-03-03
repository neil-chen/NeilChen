<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>惠氏后台管理系统</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="Public/admin/css/base.css" type="text/css" />
        <link rel="stylesheet" href="Public/admin/css/admin.css" type="text/css" />
        <script src="Public/js/jquery-1.9.1.min.js"></script>
        <script src="Public/js/TouchSlide.1.1.js"></script>
    </head>
    <body style="background:#f0f3f7;">
        <div id="wrap">
            <div class="header">
                <div class="htop clearfix">
                    <h1 class="logo left">惠氏后台管理系统</h1>
                </div>
            </div>
            <div class="container clearfix ">
                <div class="login-con">
                    <div class="login-form">
                        <form id="submit" action="" method="post">
                                <p class="login-form-box">
                                <label for="">用户名：</label><input type="text" name="username" id="username" >
                            </p>
                            <p class="login-form-box">
                                <label for="">密&nbsp;&nbsp;&nbsp;码：</label><input name="password" id="password" type="password">
                            </p>
                            <p class="login-form-box">
                                <label for="">验证码</label><input style="width:130px;margin-right: 20px;" name="verify" id="verify" type="text" />
                                <span style="float:right;"><img src='<?php echo HttpRequest::getUri(); ?>/admin.php?a=Index&m=verify' id="imgs" style="cursor:pointer;width:90px;"/></span>
                            </p>
                            <p class="clearfix"></p>
                            <p class="clearfix">
                                <label for="remember" class="login-form-chk left"><span></span></label>
                                <input type="hidden" name="dopost">
                                <input type="submit" class="btn btn-success btn-xxl right js_loginBtn" value="&nbsp;&nbsp;登&nbsp;录&nbsp;&nbsp;">
                            </p>
                        </form>
                    </div>
                </div>
                <script>
                

                    $(function () {
                        var url = "<?php echo url('Index', 'verify', array(), 'admin.php'); ?>";
                        $("#imgs").click(function () {
                            var imgUrl = url + '&r=' + Math.random();
                            $(this).attr('src', imgUrl);
                        });
                        $("#submit").submit(function () {
                            var userName = $('#username').val();
                            if (!userName) {
                                alert('用户名不能为空');
                                return false;
                            }
                            var password = $('#password').val();
                            if (!password) {
                                alert('密码不能为空');
                                return false;
                            }
                            var verify = $('#verify').val();
                            if (!verify) {
                                alert('验证码不能为空');
                                return false;
                            }
                            var postData = {
                                'username': userName,
                                'password': password,
                                'verify': verify
                            };
                            $.get("<?php echo url('Index', 'login', array(), 'admin.php'); ?>", postData,
                                    function (result) {
                                        if (result.data.error == 0) {
                                            window.location.href = "<?php echo url('Index', 'scoreChangeLog', null, 'admin.php'); ?>";
                                        } else {
                                            alert(result.data.msg);
                                        }
                                    }
                            , 'json'
                                    );
                            return false;
                        });
                    });
                </script>
                <div class="footer">
                    <div class="footer-inner">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>