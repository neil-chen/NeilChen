<meta charset="utf-8">
<script src="js/jquery-1.9.1.min.js"></script>
<form action="" method="post" enctype="multipart/form-data">
    <!-- 是否使用代理 -->
    <input type="hidden" name="printFormat" value="proxy" />
    <!-- 使用代理地址 -->
    <input type="hidden" name="proxy_url" value="http://<?php echo $_SERVER['HTTP_HOST'] ?>/share/imageUpload/UploadImg/imgCallback.php" />
    <!-- 使用callback方法 -->
    <input type="hidden" name="callback" value="parent.imgUpload_callback" />
    <!-- 返回图片地址 -->
    <!--<input type="hidden" name="file_path" id="file_path" value="" />-->
    <p class="oPhoto" id="oPhoto">上传当日收银条照片</p>
    <p class="oBtn_c">
        <span id="up-btn">上 传</span>
        <!-- 图片上传预览地址 -->
        <input id="pay_photo" name="upfile" type="file" style="display:none;"/>
    </p>
</form>
<!-- 隐藏iframe 实现跨域异步提交 -->
<iframe name="hidden_frames" id="hidden_frames" style="display: none;"></iframe>

<script type="text/javascript">
    $(function () {
        //点击触发file input
        $('#oPhoto').click(function () {
            $('#pay_photo').click();
        });
        $('#up-btn').click(function () {
            $('#pay_photo').click();
        });

        //图片上传预览
        $("#pay_photo").change(function () {
            // Get a reference to the fileList
            var files = !!this.files ? this.files : [];
            // If no files were selected, or no FileReader support, return
            if (!files.length || !window.FileReader)
                return;
            // Only proceed if the selected file is an image
            if (/^image/.test(files[0].type)) {
                // Create a new instance of the FileReader
                var reader = new FileReader();
                // Read the local file as a DataURL
                reader.readAsDataURL(files[0]);
                // When loaded, set image data as background of div
                reader.onloadend = function () {
                    $("#oPhoto").html('<img src="' + this.result + '" width="150" height="150"/>');
                }
            }
        });

        //调用图片上传方法
        var form_action = $('form').attr('action');
        fileUpLoad({
            submitBtn: $('#pay_photo'),
            form: $('form')[0],
            //CDN服务器接收图片地址
            url: "http://pic.weibopie.com/imgUpload/weixinapp/action/UploadImage.php",
            complete: function (response) {
                //回调内容为《script》".$callback."('".$result -> msg."',false) 《/script》
                //将直接调用回调方法
                //console.log(response);
            },
            beforeUpLoad: function () {
                //上传文件之前
                $("#oPhoto").html('等待图片上传');
            },
            afterUpLoad: function () {
                //已提交上传之后 还没有完成之前
                $('form').removeAttr('target');
                $('form').prop('action', form_action);
            }
        });
    }); //end document ready

    /**
     * JS使用iframe实现异步提交图片
     */
    var fileUpLoad = function (config, file_form, url) {
        var ifr = null;
        var fm = null;
        //预定义config
        var defConfig = {
            submitBtn: $('#pay_photo'), //button
            form: file_form,
            url: url,
            complete: function (response) {
            },
            beforeUpLoad: function () {
            },
            afterUpLoad: function () {
            }
        };
        //加载config
        config = $.extend(defConfig, config);
        //绑定事件
        config.submitBtn.bind('change', function (e) {
            e.preventDefault();
            if (config.beforeUpLoad.call(this) === false) {
                return;
            }
            //iframe
            ifr = $('#hidden_frames');
            ifr.appendTo($('body'));
            fm = config.form;
            fm.target = ifr.prop('name'); //target to ifr
            fm.action = config.url;
            fm.enctype = 'multipart/form-data';
            //iframe onload
            ifr.load(function () {
                var response = this.contentWindow.document.body.innerHTML;
                config.complete.call(this, response);
                //ifr.remove();
                ifr = null; //clear
            });
            fm.submit(); //submit
            //submit event
            config.afterUpLoad.call(this);
        });
    }

    //上传图片回调地址
    function imgUpload_callback(msg, type) {
        if (type == false) {
            //如果失败 打出失败信息
            alert(msg);
            return;
        } else {
            //如果成功路径地址赋值给file_path
            //$('#file_path').val(msg);
            //增加到pay_photo外面的后面
            $('#pay_photo').after('<input type="hidden" name="file_path[]" id="file_path" value="' + msg + '" />');
            //显示上传成功后图片
            //$("#oPhoto").html('<img src="' + msg + '" width="150" height="150"/>');
            //增加到oPhoto外面的后面
            $("#oPhoto").after('<img src="' + msg + '" width="150" height="150"/>');
        }
    }

</script>
