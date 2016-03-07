<?php tpl('Admin.Common.header'); ?>
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
                        <h4 class="panel-title">拒绝补充</h4>
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body nopadding">
                        <form class="form-horizontal" id="form-data-supply">
                            <div class="row">
                                <div class="col-sm-12 bc">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">合伙人编号 ：</label>
                                        <input type="hidden" name="id" value="<?php echo $list['id']; ?>"/>
                                        <div class="col-sm-9 linheigt"><input type="text" name="card_sn" value="<?php echo $list['code']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">合伙人姓名 ：</label>
                                        <div class="col-sm-9 linheigt"><input type="text" name="name" value="<?php echo $list['name']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">待补充卡券 ：</label>
                                        <div class="col-sm-9 linheigt"> <input type="text" name="supply" value="<?php echo $list['card_name']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">可用卡券数  ：</label>
                                        <div class="col-sm-9 linheigt"><input type="text" name="card_name" value="<?php echo $list['card_number']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">最大补充数 ：</label>
                                        <div class="col-sm-9 linheigt"><input type="text" name="card_num" value="<?php echo $list['sup_num']; ?>" disabled/></div>
                                    </div>

                                    <!-- form-group -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">拒绝理由：</label>
                                        <div class="col-sm-6" style="line-height:30px" id="radio">
                                            <textarea class="form-control" style="width:337px; " name ="message" value=""><?php echo $list['refused_msg']; ?></textarea>
                                        </div>
                                    </div>   



                                </div>
                            </div>

                            <div class="panel-footer" style="padding-left:12.5%">
                                <a class="btn btn-primary mr20" id="putform" style="width:130px;">提交</a>
                            </div>

                        </form>
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


        });
        var isclick = true;
        $(function() {
            $('#putform').click(function() {
                if(!isclick){
                    return false;   
                }
                id = $("[name='id']").val();
               
                message = $("[name='message']").val();

                if (!message) {
                    alert('拒绝理由不能为空！');
                    return;
                }
                if (message.length > 100 ){
                    alert('拒绝理由长度不能超过100个字符！');
                    return;    
                }
                var postData = {
                    'id': id,
                    'message': message,
                    'openid': "<?php echo $list['openid'] ?>"
                };


                $.post(
                        "<?php echo url('Card', 'upodateRefuseMessage', array(), 'admin.php'); ?>",
                        postData,
                        function(json) {
                            if (json['error'] == 0) {
                                alert("修改成功");
                                window.location.href = "<?php echo url('Card', 'cardSupAuditList', array(), 'admin.php'); ?>";
                            } else {
                                alert("修改失败");
                            }
                            isclick = true;
                        }, 'json');

            });
        });


    </script>


</div>
<!-- mainpanel -->
</div>
<?php tpl('Admin.Common.footer'); ?>