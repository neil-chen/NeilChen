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
                        <h4 class="panel-title">合伙人信息编辑</h4>
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body nopadding">

                        <form class="form-horizontal" id="partner" method="post" action="<?php echo url('Partner', 'edit', array(), 'admin.php'); ?>">
                            <input type="hidden" name="id" value="<?php echo $partner['id']; ?>" >
                            <input type="hidden" name="type" value="<?php echo $m; ?>" >
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">编    号：</label>
                                        <div class="col-sm-9 linheigt"><?php echo $partner['code']; ?></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">注册时间：</label>
                                        <div class="col-sm-9 linheigt"><?php echo $partner['create_time']; ?></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">等    级：</label>
                                        <div class="col-sm-9 linheigt"><?php echo $level['name']; ?></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">姓    名：</label>
                                        <div class="col-sm-9"><input class="form-control" type="text" value="<?php echo $partner['name']; ?>" style="width:337px; display:inline-block" name="name" id="name"></div>
                                    </div>  

                                    <!-- form-group -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">性    别：</label>
                                        <div class="col-sm-6" style="line-height:30px" id="radio">
                                            <label><input type="radio" <?php if ($partner['sex'] == 1) { ?>checked<?php } ?> name="sex"  value="1" >男</label>
                                            <label style="margin-left:80px"><input <?php if ($partner['sex'] == 2) { ?>checked<?php } ?> type="radio" name="sex"  value="2">女</label>
                                        </div>
                                    </div> 

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">渠道：</label>


                                        <div class="col-sm-9">
                                            <select class="channel "  name="channel"  style="width:100px;padding:0 10px;">

                                                <option value="">全部</option>
                                                <?php foreach ($channel as $value) { ?>

                                                    <option value="<?php echo $value['id']; ?>" <?php if ($partner['channel'] == $value['id']) { ?>selected="selected" <?php } ?>>
                                                        <?php echo $value['name']; ?>
                                                    </option>
                                                <?php } ?>

                                            </select> 
                                        </div>
                                    </div>  


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">所在地：</label>


                                        <div id="city_4" class="col-sm-9">
                                            <select class="prov "  name="prov"  style="width:100px;padding:0 10px;"></select> 
                                            <select class="city "  name="city"  style="width:100px;padding:0 10px;" disabled="disabled"></select>
                                            <select class="dist "  name="dist"  style="width:100px;padding:0 10px;"disabled="disabled"></select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">详细地址：</label>
                                        <div class="col-sm-9"><input class="form-control" type="text" value="<?php echo $partner['address']; ?>" style="width:337px; display:inline-block" name="address" id="address"></div>
                                    </div>  

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">生    日：</label>
                                        <div class="col-sm-9">

                                            <input style="cursor: pointer;cursor: hand;background-color: #ffffff; display:inline-block" name="birthday" id="birthday" class="form-control datepicker" value="<?php echo $partner['birthday'] ? $partner['birthday'] : ""; ?>" placeholder="请选择日期" type="text" readonly>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">职    业：</label>
                                        <div class="col-sm-9"><input class="form-control" type="text" value="<?php echo $partner['profession']; ?>" style="width:337px; display:inline-block" name="profession" id="profession"></div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">身份证：</label>
                                        <div class="col-sm-9"><input class="form-control" type="text" value="<?php echo $partner['identity_card']; ?>" style="width:337px; display:inline-block" name="identity_card" id="identity_card"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">手    机：</label>
                                        <div class="col-sm-9"><input class="form-control" type="text" value="<?php echo $partner['phone']; ?>" style="width:337px; display:inline-block" name="phone" id="phone"></div>
                                    </div>    
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">备    注：</label>
                                        <div class="col-sm-9"><textarea class="form-control" style="width:337px; " id="msg" name="msg"><?php echo $partner['msg']; ?></textarea></div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">积    分：</label>
                                        <div class="col-sm-9"><input class="form-control" type="text" value="<?php echo $partner['integral']; ?>" style="width:337px; display:inline-block" name="integral" id="integral"></div>
                                    </div>    

                                </div>
                            </div>

                            <div class="panel-footer" style="padding-left:12.5%">
                                <input class="btn btn-primary mr20" value="保存" style="width:130px;" type="submit"/>
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
    <script type="text/javascript" src="http://www.sucaihuo.com/Public/js/other/jquery.js"></script>
    <script type="text/javascript" src="./Public/Admin/js/jquery.cityselect.js"></script>
    <script src="./Public/Admin/js/jquery.validate.js" type="text/javascript"></script>
    <script>

        jQuery(document).ready(function () {

            $("#partner").validate({
                rules: {
                    name: "required",
                    birthday: "required",
                    profession: "required",
                    identity_card: "required",
                    address: "required",
                    //channel: "required",
                    phone: {
                        required: true,
                        digits: true,
                        rangelength: [11, 11]
                    },
                    integral: "required",
                },
                messages: {
                    name: "请输入姓名",
                    birthday: "请选择生日",
                    profession: "请输入职业",
                    identity_card: "请输入身份证",
                    phone: {
                        required: "请输入手机",
                        digits: '手机号码格式错误',
                        rangelength: '手机号码格式错误'
                    },
                    integral: "请输入积分",
                    address: "请输入详细地址",
                    //channel: "请选择渠道组",
                }
            });


            $("#city_4").citySelect({
                prov: "<?php echo $prov; ?>",
                city: "<?php echo $city; ?>",
                dist: "<?php echo $dist; ?>",
                nodata: "none"
            });

            jQuery('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            jQuery('.select2').select2({
                minimumResultsForSearch: -1
            });


        });
    </script>


</div>
<!-- mainpanel -->
</div>
<!-- mainwrapper -->

<?php tpl('Admin.Common.footer'); ?>