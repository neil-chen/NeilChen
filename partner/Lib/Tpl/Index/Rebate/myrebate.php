<?php tpl('Index.Common.header'); ?>

<script type="text/javascript" src="./Public/Index/js/iscroll.js"></script>
<script type="text/javascript">
    $(function () {

        var boxH = $(window).height() - 70;
        $(".bfnew").css("height", boxH);
    })


    var myScroll,
            pullDownEl, pullDownOffset,
            pullUpEl, pullUpOffset,
            type = 0,
            generatedCount = 0;

    function loaded() {
        pullDownEl = document.getElementById('pullDown');
        pullDownOffset = pullDownEl.offsetHeight;
        pullUpEl = document.getElementById('pullUp');
        pullUpOffset = pullUpEl.offsetHeight;

        myScroll = new iScroll('wrapper', {
            useTransition: true,
            topOffset: pullDownOffset,
            checkDOMChanges: true,
            onRefresh: function () {
                if (pullDownEl.className.match('loading')) {
                    pullDownEl.className = '';
                    pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
                } else if (pullUpEl.className.match('loading')) {
                    pullUpEl.className = '';
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = '下拉刷新...';
                }
            },
            onScrollMove: function () {
                if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
                    pullUpEl.className = 'flip';
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手开始更新...';
                    this.maxScrollY = this.maxScrollY;
                } else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
                    pullUpEl.className = '';
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                    this.maxScrollY = pullUpOffset;

                }
                console.log(this.scrollerH + " <--> " + this.scroller.offsetHeight);
            },
            onScrollEnd: function () {
                if (pullUpEl.className.match('flip')) {
                    pullUpEl.className = 'loading';
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = 'Loading...';

                    if (type == 0) {
                        var strhtml = '<li><div class="l"><img src="images/img1.png"></div><div class="R new"><dd class="w1">塞纳河不结冰</dd><dd class="w2">￥0.5</dd><dd class="w3">1</dd><dd class="w4">09-15</dd></div></li>';
                        var ID = "hhpy";
                        pullUpAction(ID, strhtml);

                    }
                    else if (type == 1) {
                        var hid = $('#iid').val();
                        hid = parseInt(hid) + 1;
                        var create_time = $("#fdate1").val() + "-" + $("#fdate2").val() + "-01";
                        var data = {
                            p: hid,
                            create_time: create_time
                        }
                        var url = "<?php echo url('Rebate', 'ajaxverfic', '', 'index.php') ?>";
                        var strhtml2 = "";
                        $.post(url, data, function (response) {
                            var res = JSON.parse(response);
                            var d = res.data.result;
                            for (var i = 0; i <= d.length - 1; i++) {
                                strhtml2 += "<li><dd>" + d[i].card_code + "</dd>";
                                strhtml2 += "<dd>" + d[i].create_time + "</dd>";
                                strhtml2 += "<dd>￥" + d[i].money + "</dd>";
                                strhtml2 += "<dd>" + d[i].score + "</dd></li>";
                            }
                            var ID = "hxlj";
                            pullUpAction2(ID, strhtml2);
                            $('#iid').val(hid);
                        });
                    }
                    else {
                        var hid = $('#hid').val();
                        hid = parseInt(hid) + 1;

                        var data = {
                            p: hid
                        }
                        var url = "<?php echo url('Rebate', 'ajaxMyrebate', '', 'index.php') ?>";
                        var strhtml3 = "";
                        $.post(url, data, function (response) {
                            var res = JSON.parse(response);
                            var d = res.data.result;
                            for (var i = 0; i <= d.length - 1; i++) {
                                strhtml3 += "<li><dd>" + d[i].create_time + "</dd>";
                                strhtml3 += "<dd>" + d[i].cancel_time + "</dd>";
                                strhtml3 += "<dd>" + d[i].state_s + "</dd>";
                                strhtml3 += "<dd>￥" + d[i].money + "</dd></li>";
                            }
                            var ID = "fltx";
                            pullUpAction2(ID, strhtml3);
                            $('#hid').val(hid);
                        });
                    }




                }



            }
        });

        setTimeout(function () {
            document.getElementById('wrapper').style.left = '0';
        }, 800);
    }

    function searchrebate() {
        var hid = 1;
        var create_time = $("#fdate1").val() + "-" + $("#fdate2").val() + "-01";
        var data = {
            p: hid,
            create_time: create_time
        }
        var url = "<?php echo url('Rebate', 'ajaxverfic', '', 'index.php') ?>";
        var strhtml2 = "";
        $.post(url, data, function (response) {
            var d = response.data.result;
            for (var i = 0; i <= d.length - 1; i++) {
                strhtml2 += "<li><dd>" + d[i].card_code + "</dd>";
                strhtml2 += "<dd>" + d[i].create_time + "</dd>";
                strhtml2 += "<dd>￥" + d[i].money + "</dd>";
                strhtml2 += "<dd>" + d[i].score + "</dd></li>";
            }
            var ID = "hxlj";
            $("#hxlj").children("li").remove();
            pullUpAction2(ID, strhtml2);
            $('#iid').val(hid);

            if (typeof response.data.total != undefined) {
                $(".hxlj .linkHer2 strong.total").text(response.data.total);
                $(".hxlj .linkHer2 strong.money").text('￥' + response.data.total_money);
                $(".hxlj .linkHer2 strong.score").text(response.data.total_score);
            }
        }, 'json');

    }

    function pullUpAction(id, strhtml) {
        ;

        switch (id) {
            case 'hhpy':
                getInvitationList();
                break;
        }
    }

    function pullUpAction2(id, strhtml) {
        setTimeout(function () {	// <-- Simulate network congestion, remove setTimeout from production!
            $("#" + id).append(strhtml);
            myScroll.refresh();		// Remember to refresh when contents are loaded (ie: on ajax completion)
        }, 1000);	// <-- Simulate network congestion, remove setTimeout from production!
    }


// 获得呼唤朋友分页数据
    function getInvitationList()
    {
        var htmls = '';
        var isExist = '';
        var year = $(".hhpy select[name=YYYY]").val();
        var month = $(".hhpy select[name=MM]").val();
        var lgt_create_time = '';

        if (year && month) {
            lgt_create_time = year + '-' + month;
        }

        var startId = $(".hhpy .data-list li").last().attr("data-id");
        $.post("<?php echo url('Invitation', 'ajaxGetList', null, 'index.php'); ?>", {"startId": startId, "lgt_create_time": lgt_create_time}, function (response) {

            if (response.error == 0) {
                for (var key in response.data.list) {

                    // 防止重复添加
                    isExist = $(".hhpy .data-list li[data-id=\"" + response.data.list[key].id + "\"]");
                    if (isExist.length == 0) {

                        htmls += '<li data-id="' + response.data.list[key].id + '">';
                        htmls += '<div class="l"><img src="' + response.data.list[key].wx_img + '"></div>';
                        htmls += '<div class="R new"><dd class="w1">' + response.data.list[key].wx_name + '</dd><dd class="w2">￥' + response.data.list[key].money + '</dd><dd class="w3">' + response.data.list[key].score + '</dd><dd class="w4">' + response.data.list[key].md_create_time + '</dd></div>';
                        htmls += '</li>';
                    }
                }

                $(".hhpy .data-list").append(htmls);
            }

            myScroll.refresh();
        }, 'json');
    }

// 按月份搜索 呼唤朋友数据
    function searchInvitationList()
    {
        var htmls = '';
        var year = $(".hhpy select[name=YYYY]").val();
        var month = $(".hhpy select[name=MM]").val();
        var lgt_create_time = '';

        if ((year && !month) || (month && !year)) {
            alert('请选择年份与月份！');
            return false;
        }

        if (year && month) {
            lgt_create_time = year + '-' + month;
        }

        $.post("<?php echo url('Invitation', 'search', null, 'index.php'); ?>", {"lgt_create_time": lgt_create_time}, function (response) {

            if (response.error == 0) {

                $(".hhpy .data-list").html('');

                for (var key in response.data.list) {

                    // 防止重复添加
                    isExist = $(".hhpy .data-list li[data-id=\"" + response.data.list[key].id + "\"]");
                    if (isExist.length == 0) {

                        htmls += '<li data-id="' + response.data.list[key].id + '">';
                        htmls += '<div class="l"><img src="' + response.data.list[key].wx_img + '"></div>';
                        htmls += '<div class="R new"><dd class="w1">' + response.data.list[key].wx_name + '</dd><dd class="w2">￥' + response.data.list[key].money + '</dd><dd class="w3">' + response.data.list[key].score + '</dd><dd class="w4">' + response.data.list[key].md_create_time + '</dd></div>';
                        htmls += '</li>';
                    }
                }

                $(".hhpy .data-list").html(htmls);

                $(".hhpy .linkHer2 strong.total").text(response.data.total);
                $(".hhpy .linkHer2 strong.money").text('￥' + response.data.total_money);
                $(".hhpy .linkHer2 strong.score").text(response.data.total_score);
            }

            myScroll.refresh();
        }, 'json');
    }
    
    //查询我的返利基本信息
    function searchInfo() {
        var htmls = '';
        var year = $(".Infoquery select[name=YYYY3]").val();
        var month = $(".Infoquery select[name=MM3]").val();
        if ((year && !month) || (month && !year)) {
            alert('请选择年份与月份！');
            return false;
        }

        if (year && month) {
            create_time = year + '-' + month;
        }

        $.post("<?php echo url('Invitation', 'searchInfo', null, 'index.php'); ?>", {"create_time": create_time}, function(response) {

            if (response.error == 0) {
                $(".Infoquery .data-list").html('');

                for (var key in response.data.list) {

                    //防止重复添加
                    isExist = $(".Infoquery .data-list li[data-id=\"" + response.data.list[key].id + "\"]");
                    if (isExist.length == 0) {
                        htmls += '<li data-id="' + response.data.list[key].id + '">';
                            htmls += '<dd class="w11">' + response.data.list[key].create_time + '</dd>';
                            htmls += '<dd class="w11">' + response.data.list[key].cancel_time + '</dd>';
                            htmls += '<dd class="w11">' + response.data.list[key].state_title + '</dd>';
                            htmls += '<dd class="w11">' + response.data.list[key].money + '</dd>';
                        htmls += '</li>';
                    }
                }

                $(".Infoquery .data-list").html(htmls);
                $(".Infoquery .linkHer2 strong.total").text(response.data.total);
                $(".Infoquery .linkHer2 strong.money").text(response.data.total_money);
            }
        },'json');
    }


    $(function () {


        $(".linkHer a").click(function () {
            var index = $(this).index();
            type = index;

            if (index == 0) {
                $("#hxlj,#fltx").hide();
                $("#hhpy").show();

            }
            else if (index == 1) {
                $("#hhpy,#fltx").hide();
                $("#hxlj").show();
            }
            else {
                $("#hhpy,#hxlj").hide();
                $("#fltx").show();
            }
        })

    })


    document.addEventListener('touchmove', function (e) {
        e.preventDefault();
    }, false);
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(loaded, 200);
    }, false);

</script>

</head>
<body>

    <form name="reg_testdate">
        <input type="hidden" value ="1" id="iid" />
        <input type="hidden" value ="1" id="hid" />

        <div class="bfnew new noe1">
            <div id="wrapper">
                <div id="scroller">
                    <div id="pullDown" style="height:0px">
                    </div>
                    <ul id="thelist">
                        <div class="vip new">
                            主银，您已经累积了<strong>￥<?php echo sprintf("%.2f", @$result['total']); ?> </strong> 返利了噢！
                        </div>

                        <div class="bccs new new3">

                            <dd><span>已提现返利：　￥<?php echo sprintf("%.2f", $draw_rebate); ?> </span></dd>
                            <dd><span>可提现返利：　<strong>￥<?php echo sprintf("%.2f", @$result['rebate_money']); ?></strong></span><b><a href="<?php echo url('Rebate', 'applyfor', '', 'index.php'); ?>">点击申请提现</a></b></dd>
                            <dd class="a2"><span>未入账返利：　￥<?php echo sprintf("%.2f", @$result['notaccount_money']); ?> </span><b><?php echo date('Y-m-d'); ?></b></dd>
                            <dd class="a2">
                                <span>已获得积分：　<?php echo $integral; ?> </span>
                                <b>
                                    <?php if ($needscore) { 
                                        echo '升级需'.$needscore.'积分';
                                     } else { 
                                         echo '-';
                                     } ?>
                                </b>
                            </dd>
                        </div>

                        <div class="linkHer">
                            <a class="dq">呼朋唤友</a><a class="p2">核销卡券</a><a class="p3">我的返利</a>
                        </div>


                        <!-- 呼唤朋友 START -->
                        <div class="hhpy" style="display:block" id="hhpy">
                            <div class="kjsearch">
                                <select class="date" name="YYYY" onChange="YYYYDD(this.value)"><option value="">年</option></select>&nbsp;年&nbsp;
                                <select class="date" name="MM" onChange="MMDD(this.value)"><option value="">月</option></select>&nbsp;月&nbsp;<a href="javascript:;" onclick="searchInvitationList()">查询</a>
                            </div>
                            <div class="linkHer2">共召唤<strong class="total"><?php echo $invitation['total']; ?></strong>位好友，获得<strong class="money">￥<?php echo $invitation['total_money']; ?></strong>和<strong class="score"><?php echo $invitation['total_score']; ?></strong>积分</div>

                            <div class="lingkname"><dd class="a1" style="width:35%; font-size:12px">昵称</dd><dd class="a2" style="width:25%; font-size:12px">获得返利</dd><dd class="a3" style="width:20%; font-size:12px">获得积分</dd><dd class="a3" style="width:20%; font-size:12px">日期</dd></div>
                            <div class="data-list">
<?php foreach ($invitation['list'] as $val) { ?>
                                    <li data-id="<?php echo $val['id']; ?>">
                                        <div class="l"><img src="<?php echo $val['wx_img']; ?>"></div>
                                        <div class="R new"><dd class="w1"><?php echo $val['wx_name']; ?></dd><dd class="w2">￥<?php echo $val['money']; ?></dd><dd class="w3"><?php echo $val['score']; ?></dd><dd class="w4"><?php echo $val['md_create_time']; ?></dd></div>
                                    </li>
<?php } ?>
                            </div>
                        </div>
                        <!-- 呼唤朋友 END -->

                        <!-- 核销卡券 -->
                        <div class="hxlj" style="display:none" id="hxlj">
                            <div class="kjsearch">
                                <select class="date" id="fdate1" name="YYYY2" onChange="YYYYDD2(this.value)"><option>年</option></select>&nbsp;年&nbsp;
                                <select class="date" id="fdate2" name="MM2" onChange="MMDD2(this.value)"><option>月</option></select>&nbsp;月&nbsp;
                                <a href="#" onclick="searchrebate()">查询</a>
                            </div>

                            <div class="linkHer2">共核销<strong class="total"><?php echo $myverfic['total']; ?></strong>张卡券，获得<strong class="money">￥<?php echo $myverfic['total_money']; ?></strong>和<strong class="score"><?php echo $myverfic['total_score']; ?></strong>积分</div>

                            <div class="lingkname"><dd>卡券名</dd><dd>核销时间</dd><dd>获得返利</dd><dd>获得积分</dd></div>

                            <?php foreach ($myverfic['result'] as $v) { ?>
                                <li><dd><?php echo $v['card_code'] ?></dd><dd><?php echo $v['create_time'] ?></dd><dd>￥<?php echo $v['money']; ?></dd><dd><?php echo $v['score']; ?></dd></li>
                            <?php } ?>
                        </div>

                        <!-- 我的返利 START -->
                        <div class="Infoquery hxlj" id="fltx" style="display:none">
                            <div class="kjsearch">
                                <select class="date" name="YYYY3" onChange="YYYYDD3(this.value)"><option>年</option></select>&nbsp;年&nbsp;
                                <select class="date"  name="MM3" onChange="MMDD3(this.value)"><option>月</option></select>&nbsp;月&nbsp;
                                <a onclick="searchInfo()">查询</a>
                            </div>

                            <div class="linkHer2">
                                共成功提现<strong class="total"><?php echo empty($row['count']) ? 0 : $row['count']; ?></strong>次累积 <strong class="money">￥<?php echo empty($row['sum']) ? 0 : $row['sum']; ?></strong> 
                            </div>
                            <div class="lingkname"><dd>申请时间</dd><dd>提现时间</dd><dd>状态</dd><dd>提现金额</dd></div>
                            <div class="data-list">
                            <?php foreach ($mybonuswithdrawl['result'] as $v) { ?>
                                <li><dd class="w11"><?php echo $v['create_time'] ?></dd><dd class="w22"><?php echo $v['cancel_time']; ?></dd><dd class="w33"><?php echo $v['state_s'] ?></dd><dd class="w44">￥<?php echo $v['money']; ?></dd></li>
                            <?php } ?>
                            </div>
                        </div>
                        <!-- 我的返利 END -->

                    </ul>
                    <div id="pullUp">
                        <span class="pullUpLabel">下拉获取更多</span><span class="pullUpIcon"></span>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./Public/Index/js/iscroll.js"></script>
        <script language="JavaScript">
                                    function YYYYMMDDstart() {
                                        MonHead = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                                        //先给年下拉框赋内容   
                                        var currentYear = new Date().getFullYear();
                                        var y = 2015;
                                        for (var i = (y); i <= currentYear; i++) { //以今年为准，前30年，后30年   
                                            document.reg_testdate.YYYY.options.add(new Option(" " + i + " 年", i));
                                            document.reg_testdate.YYYY2.options.add(new Option(" " + i + " 年", i));
                                            document.reg_testdate.YYYY3.options.add(new Option(" " + i + " 年", i));
                                        }

                                        //赋月份的下拉框   
                                        for (var i = 1; i < 13; i++) {
                                            document.reg_testdate.MM.options.add(new Option(" " + i + " 月", i));
                                            document.reg_testdate.MM2.options.add(new Option(" " + i + " 月", i));
                                            document.reg_testdate.MM3.options.add(new Option(" " + i + " 月", i));
                                        }

                                        document.reg_testdate.YYYY.value = y;
                                        document.reg_testdate.YYYY2.value = y;
                                         document.reg_testdate.YYYY3.value = y;
                                        document.reg_testdate.MM.value = new Date().getMonth() + 1;
                                        document.reg_testdate.MM2.value = new Date().getMonth() + 1;
                                        document.reg_testdate.MM3.value = new Date().getMonth() + 1;


                                    }
                                    if (document.attachEvent)
                                        window.attachEvent("onload", YYYYMMDDstart);
                                    else
                                        window.addEventListener('load', YYYYMMDDstart, false);
                                    function YYYYDD(str) //年发生变化时日期发生变化(主要是判断闰平年)   
                                    {
                                        var MMvalue = document.reg_testdate.MM.options[document.reg_testdate.MM.selectedIndex].value;
                                        var n = MonHead[MMvalue - 1];
                                        if (MMvalue == 2 && IsPinYear(str))
                                            n++;
                                        //writeDay(n)
                                    }
                                    function YYYYDD2(str) //年发生变化时日期发生变化(主要是判断闰平年)   
                                    {
                                        var MMvalue = document.reg_testdate.MM2.options[document.reg_testdate.MM2.selectedIndex].value;
                                        var n = MonHead[MMvalue - 1];
                                        if (MMvalue == 2 && IsPinYear(str))
                                            n++;
                                        //writeDay(n)
                                    }
                                     function YYYYDD3(str) //年发生变化时日期发生变化(主要是判断闰平年)   
                                {
                                    var MMvalue = document.reg_testdate.MM2.options[document.reg_testdate.MM2.selectedIndex].value;
                                    var n = MonHead[MMvalue - 1];
                                    if (MMvalue == 2 && IsPinYear(str))
                                        n++;
                                    //writeDay(n)
                                }
                                    function MMDD(str)   //月发生变化时日期联动   
                                    {
                                        var YYYYvalue = document.reg_testdate.YYYY.options[document.reg_testdate.YYYY.selectedIndex].value;
                                        var n = MonHead[str - 1];
                                        if (str == 2 && IsPinYear(YYYYvalue))
                                            n++;
                                        //writeDay(n)
                                    }

                                    function MMDD2(str)   //月发生变化时日期联动   
                                    {
                                        var YYYYvalue = document.reg_testdate.YYYY2.options[document.reg_testdate.YYYY2.selectedIndex].value;
                                        var n = MonHead[str - 1];
                                        if (str == 2 && IsPinYear(YYYYvalue))
                                            n++;
                                        //writeDay(n)
                                    }
                                    
                                function MMDD3(str)   //月发生变化时日期联动   
                                {
                                    var YYYYvalue = document.reg_testdate.YYYY2.options[document.reg_testdate.YYYY2.selectedIndex].value;
                                    var n = MonHead[str - 1];
                                    if (str == 2 && IsPinYear(YYYYvalue))
                                        n++;
                                    //writeDay(n)
                                }

                                    function IsPinYear(year)//判断是否闰平年   
                                    {
                                        return(0 == year % 4 && (year % 100 != 0 || year % 400 == 0));
                                    }
                                    function optionsClear(e)
                                    {
                                        e.options.length = 1;
                                    }
                                    
	$(".linkHer a").click(function(){
            $(".linkHer a").removeClass("dq");
            $(this).addClass("dq");
	});
        </script>

<?php tpl('Index.Common.footer'); ?>