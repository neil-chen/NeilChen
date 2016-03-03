<div class="sidebar">
    <ul class="sidenav">
        <li class="js_topMenu">
            <a href="javascript:void(0);"><i class="n-icon icon-weixin"></i>会员卡管理<em></em></a>
            <ul class="sidenav2">
                <li <?php
                if ($_GET['m'] == "memberCard") {
                    echo 'class="curr"';
                }
                ?>><a href="<?php echo HttpRequest::getUri(); ?>/admin.php?a=index&m=memberCard">企业会员卡</a></li>
                <li <?php
                if ($_GET['m'] == "userMemberCard") {
                    echo 'class="curr"';
                }
                ?>><a href="<?php echo HttpRequest::getUri(); ?>/admin.php?a=index&m=userMemberCard">用户会员卡</a></li>
                <li <?php
                if ($_GET['m'] == "creditChangeRecord") {
                    echo 'class="curr"';
                }
                ?>><a href="<?php echo HttpRequest::getUri(); ?>/admin.php?a=index&m=creditChangeRecord">积分变更记录</a></li>     
            </ul>
        </li>
    </ul>
</div>
<script>
    $(function () {
        $('.js_topMenu').click(function (e) {
            var s = e.target || e.srcElement;
            if ($(s).parents(".sidenav2").size() > 0) {
                return;
            }

            $(this).siblings().removeClass('curr')
            $(this).siblings().find('ul:visible').slideUp();
            if (!$(this).find('ul:visible').length) {
                $(this).find('ul').slideDown();
                $(this).addClass('curr');
            } else {
                $(this).find('ul').slideUp();
                $(this).removeClass('curr');
            }
        });

        $(".sidenav2 li").each(function (i, n) {
            if ($(this).hasClass('curr')) {
                $(this).closest('ul').show();
                $(this).closest('.js_topMenu').addClass('curr');
            }
            ;
        });
    });
</script>

<div class="center">
    <div class="inner-center">