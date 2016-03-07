<?php tpl('Index.Common.header'); ?>
<!--zc-->
<form name="reg_testdate" id="reg_testdate" method="post" action="<?php echo url('User', 'edit', array(), 'index.php'); ?>" onsubmit="return false">

    <div class="regist">
        <a href="#" class="logo"><img src="./Public/Index/images/logo.png"></a>
        <p>编号：<?php echo $data['code']; ?></p>
        <dd style="padding-top:10px">姓名</dd>
        <input type="text" maxlength="30" placeholder=" 姓名" name="name" id="name" value="<?php echo $data['name']; ?>"/>
        <div style="clear:both; height:10px"></div>
        <dd>性别</dd>
        <select class="" name = "sex" id="sex" >
            <option value="">性别</option>
            <option value="1" <?php if ($data['sex'] == 1) { ?> selected  <?php } ?>>男</option>
            <option value="2" <?php if ($data['sex'] == 2) { ?> selected  <?php } ?>>女</option>
        </select>
        <dd>所在地</dd>

        <div id="city_4" >
            <select class="prov se1 rightnone" name="prov" style="border-bottom:none"></select><select class="city se1 rightnone"  name="city"  disabled="disabled" style="border-left:none;border-bottom:none"></select><select class="dist se1" name="dist" disabled="disabled"  style="border-left:none;border-bottom:none">
            </select>
        </div>

        <input type="text" class="" maxlength="300" placeholder=" 请输入详细地址" name="address" id="address" value="<?php echo $data['address']; ?>"/>
        <dd>出生日期</dd>
        <select class="se1 rightnone" name="YYYY" onChange="YYYYDD(this.value)" >
            <option value="">年</option>
        </select><select class="se1 rightnone" name="MM" onChange="MMDD(this.value)"  style="border-left:none">
            <option value="">月</option>
        </select><select class="se1" name="DD"  style="border-left:none">
            <option value="">日</option>
        </select>

        <dd>职业</dd><input maxlength="100" type="text" placeholder=" 职业" name="profession" id="profession" value="<?php echo $data['profession']; ?>"/>

        <dd>手机</dd>
        <input type="tel" placeholder=" 手机" maxlength="11" class="" disabled="disabled" name="phone" id="phone" value="<?php echo $data['phone']; ?>"/>
        <input type="hidden" name="original" id="original" value="<?php echo $data['phone']; ?>" >
        <div class="yzm" >
            <input type="tel" placeholder=" 验证码" maxlength="10" disabled="disabled"  class="topnone" id="code" name="code" />
            <a href="###" onclick="showPhone()" id="showPhone" class="ll">修改手机</a>
            <a href="###" id="showCode"  class="send-code" style="display:none;">获取验证码</a>
        </div>

        <dd>身份证</dd><input type="tel" maxlength="18" placeholder=" 身份证"  class="" name="identity_card" id="identity_card" value="<?php echo $data['identity_card']; ?>"/><br /><br />
        <textarea maxlength="400" placeholder=" 为什么要当合伙人" name="msg" id="msg"><?php echo $data['msg']; ?></textarea><br>

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <?php if ($recheck) { ?>
            <input type="hidden" name="recheck" value="1" />
            <input type="submit" class="submit" value="重新申请" />
        <?php } else { ?>
            <input type="submit" class="submit" value="修改" />
        <?php } ?>
    </div>
</form>

<script type="text/javascript" src="http://www.sucaihuo.com/Public/js/other/jquery.js"></script>
<script type="text/javascript" src="./Public/Index/js/jquery.cityselect.js"></script>
<script src="./Public/Index/js/jquery.validate.js" type="text/javascript"></script>

<script language="JavaScript">

// 填充0
                function pad(num, n) {
                    var len = num.toString().length;
                    while (len < n) {
                        num = "0" + num;
                        len++;
                    }
                    return num;
                }

//修改手机
                function showPhone() {

                    if ($("#showPhone").html() == "取消修改") {
                        $("#code").attr("disabled", true);
                        $("#phone").attr("disabled", true);
                        $("#showPhone").html("修改手机");
                        $("#showCode").hide();


                        $("#phone").val($("#original").val());
                        $("#code").val("");
                        $("label").hide();
                    } else {
                        $("#code").attr("disabled", false);
                        $("#phone").attr("disabled", false);
                        $("#showPhone").html("取消修改");
                        $("#showCode").show();
                    }





                }


                $(".send-code").on('click', sendCode);

//发送验证码
                function sendCode() {

                    var phone = $("#phone").val();
                    if (phone == '' || phone.length != 11) {
                        alert("手机号码错误！");
                        return false;
                    }

                    $(".send-code").off('click');

                    var url = "<?php echo url('User', 'sendMsg', array(), 'index.php'); ?>";
                    $.ajax({
                        url: url, // 跳转到 action    
                        data: 'phone=' + phone,
                        type: 'post',
                        success: function (data) {

                            if (data == 1) {
                                alert('发送成功');

                                retryTime = 60;
                                timeId = setInterval(function () {

                                    retryTime--;
                                    $(".send-code").text(retryTime + ' 秒后重试');

                                    if (retryTime == 0) {
                                        clearInterval(timeId);
                                        $(".send-code").text('获取验证码');
                                        $(".send-code").on('click', sendCode);
                                    }

                                }, 1000);
                            } else {
                                alert('发送失败');
                                $(".send-code").on('click', sendCode);
                            }
                        }
                    });
                }

                function YYYYMMDDstart() {
                    MonHead = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                    //先给年下拉框赋内容   
                    var y = new Date().getFullYear();
                    for (var i = (y - 65); i < (y + 30); i++) //以今年为准，前30年，后30年   
                        document.reg_testdate.YYYY.options.add(new Option(" " + i + " 年", i));

                    //赋月份的下拉框   
                    for (var i = 1; i < 13; i++)
                        document.reg_testdate.MM.options.add(new Option(" " + i + " 月", i));

                    document.reg_testdate.YYYY.value = "<?php echo $YYYY; ?>";
                    document.reg_testdate.MM.value = "<?php echo $MM; ?>";
                    var n = MonHead[new Date().getMonth()];
                    if (new Date().getMonth() == 1 && IsPinYear(YYYYvalue))
                        n++;
                    writeDay(n); //赋日期下拉框Author:meizz   
                    document.reg_testdate.DD.value = "<?php echo $DD; ?>";
                }
                if (document.attachEvent)
                    window.attachEvent("onload", YYYYMMDDstart);
                else
                    window.addEventListener('load', YYYYMMDDstart, false);
                function YYYYDD(str) //年发生变化时日期发生变化(主要是判断闰平年)   
                {
                    var MMvalue = document.reg_testdate.MM.options[document.reg_testdate.MM.selectedIndex].value;
                    if (MMvalue == "") {
                        var e = document.reg_testdate.DD;
                        optionsClear(e);
                        return;
                    }
                    var n = MonHead[MMvalue - 1];
                    if (MMvalue == 2 && IsPinYear(str))
                        n++;
                    writeDay(n)
                }
                function MMDD(str)   //月发生变化时日期联动   
                {
                    var YYYYvalue = document.reg_testdate.YYYY.options[document.reg_testdate.YYYY.selectedIndex].value;
                    if (YYYYvalue == "") {
                        var e = document.reg_testdate.DD;
                        optionsClear(e);
                        return;
                    }
                    var n = MonHead[str - 1];
                    if (str == 2 && IsPinYear(YYYYvalue))
                        n++;
                    writeDay(n)
                }
                function writeDay(n)   //据条件写日期的下拉框   
                {
                    var e = document.reg_testdate.DD;
                    optionsClear(e);
                    for (var i = 1; i < (n + 1); i++)
                        e.options.add(new Option(" " + i + " 日", i));
                }
                function IsPinYear(year)//判断是否闰平年   
                {
                    return(0 == year % 4 && (year % 100 != 0 || year % 400 == 0));
                }
                function optionsClear(e)
                {
                    e.options.length = 1;
                }

                jQuery(document).ready(function () {
                    var url = "<?php echo url('User', 'checkCode', array(), 'index.php'); ?>";
                    $("#reg_testdate").validate({
                        // 编辑
                        submitHandler: function () {

                            var sex = $("select[name=sex]").val();
                            var identity_card = $("input[name=identity_card]").val();
                            var birthday = $("select[name=YYYY]").val() + pad($("select[name=MM]").val(), 2) + pad($("select[name=DD]").val(), 2);

                            // 验证身份证
                            var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
                            if (!reg.test(identity_card)) {
                                alert("身份证号码格式不正确！");
                                return  false;
                            }

                            // 验证生日
                            id_birthday = (identity_card.length == 18) ? identity_card.substr(6, 8) : '19' + identity_card.substr(6, 6);
                            if (birthday != id_birthday) {
                                alert("身份证号码与出生日期不匹配！");
                                return  false;
                            }

                            // 验证性别
                            id_sex = (identity_card.length == 18) ? identity_card.substr(16, 1) : identity_card.substr(14, 1);
                            if (!(sex == 1 && id_sex % 2 != 0) && !(sex == 2 && id_sex % 2 == 0)) {
                                alert("身份证号码与性别不匹配！");
                                return false;
                            }

                            $.post("<?php echo url('User', 'edit', null, 'index.php'); ?>", $("form#reg_testdate").serialize(), function (response) {

                                alert(response.message);

                                if (response.status === true) {
                                    location.href = "<?php echo url('User', 'index', null, 'index.php'); ?>";
                                    return false;
                                }

                            }, 'json');
                        },
                        rules: {
                            name: "required",
                            sex: "required",
                            profession: "required",
                            identity_card: "required",
                            address: "required",
                            phone: {
                                required: true,
                                digits: true,
                                rangelength: [11, 11]
                            },
                            code: {
                                required: true,
                                remote: {
                                    url: url, //后台处理程序
                                    type: "post", //数据发送方式
                                    data: {//要传递的数据
                                        code: function () {
                                            return $("#code").val();
                                        },
                                        phone: function () {
                                            return $("#phone").val();
                                        }
                                    }
                                }
                            }
                        },
                        messages: {
                            name: "请输入姓名",
                            sex: "请选择性别",
                            profession: "请输入职业",
                            identity_card: "请输入身份证",
                            address: "请输入详细地址",
                            phone: {
                                required: "请输入手机",
                                digits: '手机号码格式错误',
                                rangelength: '手机号码格式错误'
                            },
                            code: {
                                required: "请输入验证码",
                                remote: "验证码错误"
                            }
                        }
                    });


                    $("#city_4").citySelect({
                        prov: "<?php echo $prov; ?>",
                        city: "<?php echo $city; ?>",
                        dist: "<?php echo $dist; ?>",
                        nodata: "none"
                    });

                });

</script>

</body>
</html>
