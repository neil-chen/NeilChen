<?php tpl('Admin.Common.header'); ?>
<style>
    .form-horizontal .control-label{ font-size:16px}
</style>
<link rel="stylesheet" href="./Public/Admin/kindeditor-4.1.10/themes/default/default.css" />
<script charset="utf-8" src="./Public/Admin/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="./Public/Admin/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            resizeType: 1,
            allowPreviewEmoticons: false,
            /*allowImageUpload : false,*/
            minWidth: 400,
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'link']
        });


    });
</script>
<div class="mainpanel">
    <div class="contentpanel">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-btns">
                            <a href="" class="panel-minimize tooltips" data-toggle="tooltip" title="折叠"><i class="fa fa-minus"></i></a>
                            <a href="" class="panel-close tooltips" data-toggle="tooltip" title="隐藏面板"><i class="fa fa-times"></i></a>
                        </div>
                        <!-- panel-btns -->
                        <h4 class="panel-title">添加卡券</h4>
                    </div>
                    <!-- panel-heading -->
                    <div class="panel-body nopadding">
                        <form class="form-horizontal" id="form-data-supply" action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" >卡券名 ：</label>
                                        <div class="col-sm-9 linheigt">
                                            <input class="form-control width330" id="card_namel" value=""  type="text" maxlength="100"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">card_id ：</label>
                                        <div class="col-sm-9 linheigt"><input  class="form-control width330" id="card_id" value=""  type="text"></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">库存 ：</label>
                                        <div class="col-sm-9 linheigt"><input  class="form-control width330" id="card_num" value=""  type="text"></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">类型 ：</label>
                                        <div class="col-sm-9 linheigt"><select name="type" class="select2 width330" id="status" data-placeholder="Choose One" style="padding:0 10px;">

                                                <?php
                                                foreach ($status as $key => $val) {
                                                    if ($key == 1) {
                                                        ?>
                                                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $key; ?>" ><?php echo $val; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select></div>
                                        <input type="hidden" name="statusname" id="statusname" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">可否补充 ：</label>
                                        <div class="col-sm-9 linheigt"><select name="status" class="select2 width330" id="type" data-placeholder="Choose One" style="padding:0 10px;">

                                                <?php
                                                foreach ($type as $key => $val) {
                                                    if ($key == 1) {
                                                        ?>
                                                        ?>
                                                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select></div>
                                        <input type="hidden" name="typename" id="typename" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">起始日期 ：</label>
                                        <input style="width:500px;cursor: pointer;cursor: hand;" name="start_date" id="start_date" class="form-controla datepicker" value="" placeholder="请选择日期" type="text" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">有效日期 ：</label>
                                        <input style="width:500px;cursor: pointer;cursor: hand;" name="end_date" id ="end_date" class="form-controla datepicker" value="" placeholder="请选择日期" type="text" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">卡券图片 ：</label>
                                        <input type="hidden" name="printFormat" value="proxy" />
                                        <input type="hidden" name="proxy_url" value="http://<?php echo $_SERVER['HTTP_HOST'] ?>/CocaCola/www/UploadImg/imgCallback.php" />
                                        <input type="hidden" name="callback" value="parent.imgUpload_callback" />
                                        <!-- 上传图片大小限制 -->
                                        <input type="hidden" name="max_size" value="20000000" />
                                        <input type="hidden" name="file_path" id="file_path" value="" /> 
                                        <a class="oPhoto" id="oPhoto"><strong  style="padding-top:8px; display: inline-block ">请单击上传图片</strong><br/></a>
                                        <input id="pay_photo" name="upfile" type="file" value="" style="display:none;"/>
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">使用须知 ：</label>
                                        <div class="col-sm-9 linheigt"><textarea id="textarea1" name="content"   style="width:450px;height:200px;"></textarea></div>
                                    </div>

                                </div>
                            </div>

                            <div class="panel-footer" style="padding-left:12.5%">
                                <!-- 隐藏提交按钮 -->
                                <a class="btn btn-primary " id="putform" style="width:130px;display:none;" onclick="check()">提交</a>
                            </div>

                        </form>
                        <iframe name="hidden_frames" id="hidden_frames" style="display: none;"></iframe>

                    </div>
                    <!-- panel-body -->
                </div>
                <!-- panel -->

            </div>
            <!-- col-md-6 -->
        </div>
        <!-- row -->
    </div>
    <!-- contentpanel -->
    <script>
        jQuery(document).ready(function() {
            jQuery('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            jQuery('.select2').select2({
                minimumResultsForSearch: -1
            });

            $('#status').bind('change', function() {
                var v1 = this.value;
                $("#typename").attr('value', $("#status option[value='" + v1 + "']").attr("value"));

            });


        });

        $('.mr20').click(function() {



        })
    </script>

    <script type="text/javascript">
        $(function() {
            $('#oPhoto').click(function() {
                $('#pay_photo').click();
            });
            //file ajax upload
            var form_action = $('form').attr('action');
            fileUpLoad({
                submitBtn: $('#pay_photo'),
                form: $('form')[0],
                url: "http://pic.weibopie.com/imgUpload/weixinapp/action/UploadImage.php",
                complete: function(response) {
                    console.log(response);
                },
                afterUpLoad: function() {
                    $('form').removeAttr('target');
                    $('form').prop('action', form_action);
                }
            });
        }); //end document

        /**
         * Ajax file upload
         */
        var fileUpLoad = function(config, file_form, url) {

            var ifr = null;
            var fm = null;
            var defConfig = {
                submitBtn: $('#pay_photo'), //button
                form: file_form,
                url: url,
                complete: function(response) {
                },
                afterUpLoad: function() {
                }
            };
            //config
            config = $.extend(defConfig, config);
            //bind submit
            config.submitBtn.bind('change', function(e) {
                e.preventDefault();

                //create a hide iframe
                ifr = $('#hidden_frames');
                ifr.appendTo($('body'));
                fm = config.form;
                fm.target = ifr.prop('name'); //target to ifr
                fm.action = config.url;
                fm.enctype = 'multipart/form-data';
                //iframe onload
                ifr.load(function() {
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
                alert(msg);
                return;
            } else {
                $('#file_path').val(msg);
                //图片上传预览，显示本地图片
                // Get a reference to the fileList
                var files = !!$('#pay_photo')[0].files ? $('#pay_photo')[0].files : [];
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
                    reader.onloadend = function() {
                        $("#oPhoto").html('<img src="' + this.result + '" width="150" height="150"/>');
                    }
                }
                //显示远程图片
                $("#oPhoto").html('<img src="' + this.result + '" width="150" height="150"/>');
            }
            //图片上传完成后重置为空
            $('#pay_photo').val('');
        }

        //验证输入
        function check() {

            var re = /^[0-9]+.?[0-9]*$/;
            card_name = $("[id='card_namel']").val();
            card_id = $("[id='card_id']").val();
            card_num = $("[id='card_num']").val();
            type = $("[name='type']").val();
            status = $("[name='status']").val();
            start_date = $("[id='start_date']").val();
            end_date = $("[id='end_date']").val();
            file = $("[id='pay_photo']").val();
            textarea1 = editor.html();

            if (!card_name) {
                alert('卡券名称不能为空');
                return;
            }
            if (!card_id) {
                alert('card_id不能为空');
                return;
            }
            if (!card_num) {
                alert('库存不能为空');
                return;
            }
            if (!re.test(card_num))
            {
                alert("库存请输入数字");
                return;
            }

            if (!status) {
                alert('类型不能为空');
                return;
            }
            if (!type) {
                alert('补充不能为空');
                return;
            }
            if (!start_date) {
                alert('起始时间不能为空');
                return;
            }
            if (!end_date) {
                alert("有效时间不能为空");
                return;
            }

            if (!textarea1) {
                alert('使用须知不能为空');
                return;
            }
            var file_path = $("input[name='file_path']").val();
            if ($.trim(file_path) == "") {
                alert('请上传图片');
                return false;
            }
            if (start_date > end_date) {
                alert("有效日期必须大于起始日期");
                return;
            }

        
            var postData = {
                'file_path': file_path,
                'card_name': card_name,
                'card_id': card_id,
                'card_num': card_num,
                'status': status, //类型
                'type': type, //补充
                'start_date': start_date,
                'end_date': end_date,
                'textarea1': textarea1,
            };


            $.get(
                    "<?php echo url('Card', 'addCardInfo', array(), 'admin.php'); ?>",
                    postData,
                    function(json) {
                        if (json['error'] == 0) {
                            alert("添加成功");
                            window.location.href = "<?php echo url('Card', 'cardInfoList', array(), 'admin.php'); ?>";
                        } else {
                            alert("添加失败");
                        }
                    }, 'json');



        }

    </script>


</div>
<!-- mainpanel -->
</div>
<!-- mainwrapper -->

<?php tpl('Admin.Common.footer'); ?>