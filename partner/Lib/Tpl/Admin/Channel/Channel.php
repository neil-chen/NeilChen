<?php tpl('Admin.Common.header'); ?>



<style>
    .select2-results .select2-result-label{ width:100px}
</style>		
<div class="mainpanel">
    <div class="contentpanel">

        <div class="panel panel-default">

            <div class="panel-body">
                <form class="form-inline" method="get" action="">
                    <!--查询-->
                    <div class="form-group"><label>关键字：</label>
                        <input class="form-control" type="text" name="keyword" value="<?php echo $param['keyword']; ?>"  maxlength="100" style="width:200px;" placeholder="可输入渠道组名等进行查询">
                    </div>

                    <div class="form-group">
                        <label>状态 :</label>
                        <select name="status" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="">全部</option>
                            <option value="1" <?php if ($param['status'] == 1) echo "selected"; ?>>有效</option>
                            <option value="2" <?php if ($param['status'] == 2) echo "selected"; ?>>无效</option>
                        </select>
                    </div> 

                    <div class="form-group">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-sm" type="submit">查询</button>
                    </div>
                    <input type="hidden" value="Channel" name="a"/>
                    <input type="hidden" value="index" name="m"/>

                </form>
            </div>
            <!-- panel-body -->
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="<?php echo url('Channel', 'Add', array(), 'admin.php') ?>" class="btn btn-primary">添加渠道组</a>&nbsp;&nbsp;
                        <a class="btn btn-success" id="nostatus">批量无效</a>&nbsp;&nbsp;
                        <a class="btn btn-info" id="export">导出组员</a>
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
                            jQuery(document).ready(function () {
                                $('#btn-combine-pay').click(function () {
                                    return $('.need-to-pay:checked').length != 0;
                                });

                                //详情JS
                                $(".lis .more").click(function () {
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
                                })
                            });
                        </script>
                    </div>
                    <table class="table table-bordered mb30">
                        <thead>

                            <tr>
                                <th width="100">
                        <div class="ckbox ckbox-primary">
                            <input type="checkbox" class="ids" id="checkbox-allcheck" value="949">
                            <label for="checkbox-allcheck" class="allcheck">全选</label>
                        </div>
                        </th>
                        <th>渠道组名</th>
                        <th>组员数</th>
                        <th>创建时间</th>
                        <th>状态</th>
                        <th width="300">快捷操作</th>
                        </tr>

                        </thead>
                        <tbody id="staff-body"> 
                            <?php foreach ($result as $v) { ?>
                                <tr class="lis">
                                    <td>
                                        <div class="ckbox ckbox-primary">
                                            <input type="checkbox" class="ids ids2" id="checkbox<?php echo $v['id'] ?>" value="<?php echo $v['id']; ?>">
                                            <label for="checkbox<?php echo $v['id'] ?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $v['name']; ?></td>
                                    <td><?php echo $v['groupnumber'] ?></td>
                                    <td><?php echo $v['created_ats']; ?></td>
                                    <td><?php echo $v['status_name'] ?></td>
                                    <td><a href="<?php echo url('Channel', 'update', array('id' => $v['id']), 'admin.php') ?>" class="btn btn-danger btn-sm">编辑</a>&nbsp;<a class="btn btn-primary btn-sm" href="<?php echo url('Channel', 'importChanelUsers', array('id' => $v['id']), 'admin.php'); ?>">导入组员</a></td> 
                                </tr>
                            <?php } ?>
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
        jQuery(document).ready(function () {

            jQuery('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            jQuery('.select2').select2({
                minimumResultsForSearch: -1
            });
            /**
             * 批量设置无效
             */
            $('#nostatus').click(function () {
                var suburl = "<?php echo url('Channel', 'setchannelstatus', '', 'admin.php') ?>";
                var ids = "";
                $('.ids2').each(function () {
                    ids = $(this).prop('checked') ? ids + $(this).val() + "," : ids;
                });
                ids = ids.length > 0 ? ids.substr(0, ids.length - 1) : '';
                if (ids.length == 0) {
                    return;
                }
                var data = {
                    id: ids,
                    status: 2
                }
                $.post(suburl, data, function (response) {
                    var d = JSON.parse(response);
                    if (d.error != 'OK') {
                        alert(d.msg);
                        return;
                    }
                    location.reload();
                });

            });
            /**
             * 批量导出组员
             */
            $('#export').click(function () {
                var suburl = "<?php echo url('Channel', 'exportChanelUsers', '', 'admin.php') ?>";
                var ids = "";
                $('.ids2').each(function () {
                    ids = $(this).prop('checked') ? ids + $(this).val() + "," : ids;
                });
                ids = ids.length > 0 ? ids.substr(0, ids.length - 1) : '';
                if (ids.length == 0) {
                    return;
                }
                var data = {id: ids};
                location.href = suburl + '&ids=' + ids;
            });

        });
    </script>


</div>
<!-- mainpanel -->
</div>
<!-- mainwrapper -->

<?php tpl('Admin.Common.footer'); ?>