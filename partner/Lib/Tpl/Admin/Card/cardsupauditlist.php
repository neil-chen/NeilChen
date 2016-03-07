<?php tpl('Admin.Common.header'); ?>
<style>
    .select2-results .select2-result-label{ width:100px}
</style>
<div class="mainpanel">
    <div class="contentpanel">

        <div class="panel panel-default">

            <div class="panel-body">
                <form class="form-inline" method="post" action="<?php echo url('Card', 'cardSupAuditList', '', 'admin.php'); ?>">
                    <!--查询-->
                    <div class="form-group"><label>关键字：</label>
                        <input class="form-control" type="text" name="code" style="width:260px;" placeholder="可输入合伙人编号、姓名、电话进行查询"  maxlength="100" value="<?php echo $param['code']; ?>">
                    </div>

                    <div class="form-group">
                        <label>申请时间:</label>

                        <input style="cursor: pointer;cursor: hand;background-color: #ffffff" name="create_time" class="form-control datepicker" value="<?php echo $param['create_time']; ?>" placeholder="请选择日期" type="text" readonly>
                        <input style="cursor: pointer;cursor: hand;background-color: #ffffff" name="end_time" class="form-control datepicker" value="<?php echo $param['end_time']; ?>" placeholder="请选择日期" type="text" readonly> 
                    </div>

                    <div class="form-group">
                        <label>状态 :</label>
                        <select name="sub_status" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="" selected="selected">全部</option>
                            <?php foreach ($status as $key => $val) {
                             if($param['sub_status'] == $key && $param['sub_status'] !=''){
                                 ?>
                            <option value="<?php echo $key;?>" selected="selected"><?php echo $val;?></option>
                            <?php
                             }else{
                                 ?>
                            <option value="<?php echo $key;?>"><?php echo $val;?></option>
                            <?php 
                             }
                            }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>卡券 :</label>
                        <select name="card_type" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="" selected="selected">全部</option>
                            <?php foreach($cardType as $key => $val){
                                ?>
                            <option value="<?php echo $key;?>" <?php if($param['card_type'] == $key){ ?>selected="selected"<?php }?> ><?php echo $val['card_id']; ?></option>
                            <?php
                            }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>渠道组:</label>
                        <select name="channel" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="" selected="selected">全部</option>    
                            <?php foreach ($channel as $key => $val) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php if($param['channel'] == $key){?>selected="selected"<?php }?>  ><?php echo $val['name']; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>




                    <div class="form-group">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-sm" type="submit">查询</button>
                    </div>

                </form>
            </div>
            <!-- panel-body -->
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-inline">
                    <div class="form-group">
                        <a class="btn btn-primary  refu" >批量拒绝</a>
                    </div>

                </div>
            </div>
            <!-- panel-body -->
        </div>


        <ul class="nav nav-tabs">
        </ul>

        <div class="tab-content mb30">
            <div id="t1" class="tab-pane active">
                <form action="/order/payments/method/" method="post">
                    <div>
                        <script>
                            jQuery(document).ready(function() {
                                $('#btn-combine-pay').click(function() {
                                    return $('.need-to-pay:checked').length != 0;
                                });

                                //详情JS
                                $(".lis .more").click(function() {
                                    if ($(this).html() == "+") {
                                        $(".lis .more").removeClass("zk").html("+")
                                        $(this).addClass("zk").html("-");
                                        $("#staff-body .liscon").hide();
                                        $(this).parents(".lis").next(".liscon").show();
                                    }
                                    else {
                                        $(this).removeClass("zk").html("+");
                                        $("#staff-body .liscon").hide();
                                    }
                                });

                                $('.refu').click(function() {
                                    val = getselect();
                                    valopenid = getselectopenid();
                                    id = getselectid();
                                    
                                 
                                    var postData = {
                                        'id': val,
                                        'openid':valopenid,
                                        'idextends':id
                                    };
                                    $.get(
                                            "<?php echo url('Card', 'allRefuse', array(), 'admin.php'); ?>",
                                            postData,
                                            function(json) {
                                                if (json['error'] == 0) {
                                                    alert("拒绝成功");
                                                    window.location.href = "<?php echo url('Card', 'cardSupAuditList', array(), 'admin.php'); ?>";

                                                }
                                            }, 'json');


                                });

                                function getselect() {
                                    var value = "";
                                    $(".idsss").each(function() {
                                        if ($(this).prop("checked") == true) {
                                            value += "," + $(this).val();
                                        }
                                    });
                                    return value;
                                }

                                function getselectopenid() {
                                    var value = "";
                                    $(".idss").each(function() {
                                        if ($(this).prop("checked") == true) {
                                            value += "," + $(this).attr('openid');
                                        }
                                    });
                                    return value;
                                }
                                
                                  function getselectid() {
                                    var value = "";
                                    $(".idss").each(function() {
                                        if ($(this).prop("checked") == true) {
                                            value += "," + $(this).val();
                                        }
                                    });
                                    return value;
                                }
                                
                                function gethiden() {
                                    var value = "";
                                    $("#jujue").each(function() {
                                        $(this).hide();

                                    });
                                    return value;
                                }
                            });
                        </script>
                    </div>
                    <table class="table table-bordered mb30">
                        <thead>
                            <tr>
                                <th width="100">
                        <div class="ckbox ckbox-primary">
                            <input type="checkbox" class="ids" id="checkbox-allcheck" value="949">
                            <label for="checkbox-allcheck" id ="haha" class="allcheck">全选</label>
                        </div>
                        </div>
                        </th>
                        <th>合伙人编号</th>
                        <th>姓名</th>
                        <th>申请数量</th>
                        <th>申请时间</th>
                        <th>卡券名</th>
                        <th>补充数量</th>
                        <th>补充时间</th>
                        <th>状态</th>
                        <th>快捷操作</th>
                        <th width="100">　详情</th>
                        </tr>
                        </thead>
                        <tbody id="staff-body">

                            <?php foreach ($list as $key => $val) {
                                ?>
                                <tr class="lis">

                                    <td>
                                        <?php if ($val['sub_status'] == '待审核') { ?>
                                            <div class="ckbox ckbox-primary">  
                                                <input type="checkbox" openid="<?php echo $val['openid'];?>" class="idss" id="checkbox<?php echo $val['id']; ?>" value="<?php echo $val['id']; ?>">
                                                <label for="checkbox<?php echo $val['id']; ?>"></label>
                                            </div>
                                        <?php } ?>
                                    </td>

                            <input type="hidden" name="id" class="idsss" value="<?php echo $val['id']; ?>"/>
                            <td><?php echo $val['code']; ?></td>
                            <td><?php echo $val['name']; ?></td>
                            <td><?php echo $val['sup_num']; ?></td>
                            <td><?php echo $val['create_time']; ?></td>
                            <td><?php echo $val['card_name']; ?></td>
                            <td><?php echo $val['tosup_num']; ?></td>
                            <td><?php echo $val['sup_time'] ?></td>
                            <td><?php echo $val['sub_status']; ?></td>
                            <td>
                                <?php if ($val['sub_status'] == '待审核') { ?>
                                    <a href="<?php echo url('Card', 'allowSup', array('id' => $val['id']), 'admin.php'); ?>" class="btn btn-danger btn-sm">允许补充</a>&nbsp;
                                    <a class="btn btn-primary btn-sm" id="jujue" href="<?php echo url('Card', 'refusedSup', array('id' => $val['id']), 'admin.php'); ?>">拒绝补充</a></td>
                            <?php } ?>

                            <td><a class="more">+</a></td>
                            </tr>
                            <tr class="liscon">
                                <td colspan="10">
                                    <div class="newnnn">
                                        <a class="btn btn-default">合伙人编号 ：  <?php echo $val['code']; ?></a><a class="btn btn-default">姓名：  <?php echo $val['name']; ?></a><a class="btn btn-default">申请记录编号 ：  <?php echo $val['sup_sn']; ?></a><a class="btn btn-default">卡券名：  <?php echo $val['card_name']; ?></a><a class="btn btn-default">卡券编号：  <?php echo $val['card_sn']; ?></a><a class="btn btn-default">card_id: <?php echo $val['card_id']; ?></a>
                                    </div>
                                    <?php if ($val['sub_status'] == '拒绝补充') { ?>
                                        <div class="newnnn">
                                            <a class="btn btn-default">拒绝理由 ： <?php
                                                if (!empty($val['refused_msg'])) {
                                                    echo $val['refused_msg'];
                                                } else {
                                                    echo '无';
                                                }
                                                ?></a>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                        ?>

                        </tbody>
                    </table>

                </form>
                <div class="panel-footer">
                    <div class="row">

                        <div class="col-xs-12">
                            <div class="pagenumQu">
                                <?php tpl('Admin.Common.page');?>
                            </div>    

                        </div>
                    </div>
                </div>
            </div>   

        </div>

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


    </script>


</div>
<!-- mainpanel -->
</div>
<!-- mainwrapper -->
<?php tpl('Admin.Common.footer'); ?>