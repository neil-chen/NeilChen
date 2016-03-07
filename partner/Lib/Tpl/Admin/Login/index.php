<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>后台管理系统</title>

<script src="./Public/Admin/js/jquery-1.8.3.min.js"></script>
<link href="./Public/Admin/css/login.css" rel="stylesheet">

</head>

<body>

<div class="signin">
    <div class="signin-head">后台管理系统</div>
    <form class="form-signin" role="form">
        <input type="text" name="user_name" class="form-control" placeholder="用户名" autocomplete="off" />
        <input type="password" name="password" class="form-control" placeholder="密码" autocomplete="off" />
        <input type="text" name="verify_code" class="form-control con2" placeholder="请输入验证码" autocomplete="off" />
            <img class="imgyzm" src="<?php echo url('Login', 'verify', null, 'admin.php'); ?>" old-src="<?php echo url('Login', 'verify', null, 'admin.php'); ?>" />
        <input type="submit" class="btn btn-lg btn-warning btn-block action-login" value="登录" />
        <div class="login-msg"></div>
    </form>
</div>

<script>


$(document).ready(function() {

    // 注册验证码点击事件
    $(".imgyzm").click(function() {
        $(this).attr("src", $(this).attr("old-src") + '&rand=' + Math.random())
    });

    // 登录
    $("form.form-signin").submit(function() {
        var errorMsg    = '';
        var user_name   = $("input[name=user_name]").val();
        var password    = $("input[name=password]").val();
        var verify_code = $("input[name=verify_code]").val();
        var msgObj      = $(".login-msg");

        if (!user_name) {
            msgObj.text('请输入用户名！');
            $("input[name=user_name]").select();
            return false;
        }

        if (!password) {
            msgObj.text('请输入密码！');
            $("input[name=password]").select();
            return false;
        }

        if (!verify_code) {
            msgObj.text('请输入验证码！');
            $("input[name=verify_code]").select();
            return false;
        }

        msgObj.text('');
        $(".action-login").val('登录中...');
        $(".action-login").attr('disabled', true);

        $.post("<?php echo url('Login', 'login', null, 'admin.php'); ?>", $("form").serialize() , function (response) {

            if (response.status === false) {
                $(".imgyzm").click();
                msgObj.text(response.message);

                $(".action-login").val(' 登 录 ');
                $(".action-login").attr('disabled', false);
                return false;

            } else {
                location.href = "<?php echo url('Partner', 'partnerList', null, 'admin.php'); ?>";
                return false;
            }

        }, 'json');

        return false;
    })
});
</script>
</body>
</html>