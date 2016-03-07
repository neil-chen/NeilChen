<?php tpl('Admin.Common.header'); ?>
<style>
    .select2-results .select2-result-label{ width:100px}
</style>
<div class="mainpanel">
    <div class="contentpanel">

        <div class="panel panel-default">

            <div class="panel-body">
                <form class="form-inline" method="post" action="<?php echo url('Partner', 'checkPartnerList', array(), 'admin.php'); ?>">
                    <!--查询-->
                    <div class="form-group"><label>关键字：</label>
                        <input class="form-control" type="text" name="name" value="<?php echo $param['name']; ?>" style="width:260px;" maxlength="100" placeholder="可输入合伙人编号、姓名、电话进行查询"  />
                    </div>
                    <div class="form-group">
                        <label>注册时间段:</label>
                        <input style="cursor: pointer;cursor: hand;background-color: #ffffff" name="sTime" class="form-control datepicker" value="<?php echo $param['sTime']; ?>" placeholder="请选择日期" type="text" readonly> ~
                        <input style="cursor: pointer;cursor: hand;background-color: #ffffff" name="eTime" class="form-control datepicker" value="<?php echo $param['eTime']; ?>" placeholder="请选择日期" type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label>状态 :</label>
                        <select name="state" id="state" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="">全部</option>
                            <option value="0" <?php if ($param['state'] == '0') { ?> selected="selected" <?php } ?>>待审核</option>
                            <option value="2" <?php if ($param['state'] == '2') { ?> selected="selected" <?php } ?>>已拒绝</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>性别 :</label>
                        <select name="sex" id="sex" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="">全部</option>
                            <option value="1" <?php if ($param['sex'] == '1') { ?> selected="selected" <?php } ?>>男</option>
                            <option value="2" <?php if ($param['sex'] == '2') { ?> selected="selected" <?php } ?>>女</option>
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
                        <a class="btn btn-primary" id="batchPass">批量通过</a>　
                        <a class="btn btn-danger" id="batchRefuse">批量拒绝</a>
                        &nbsp;&nbsp;
                        <a class="btn btn-primary" id="batchExport">批量导出</a>
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

                            var istg = true;
                            //ajax请求 改变状态
                            function ajaxBatch(ids, openids, type) {
                                if (!istg) {
                                    return false;
                                }
                                istg = false;
                                var url = "<?php echo url('Partner', 'stateOperation', array(), 'admin.php'); ?>";
                                var urlto = "<?php echo url('Partner', 'ajaxAddCardCode', array(), 'admin.php'); ?>";
                                if (ids && ids.length > 0) {
                                    $.ajax({
                                        url: url, // 跳转到 action    
                                        data: 'ids=' + ids + '&openids=' + openids + '&type=' + type,
                                        type: 'post',
                                        success: function (data) {
                                            if (data == 1) {
                                                alert('操作成功');

                                                //location.reload();
                                            } else {
                                                alert('操作失败');
                                            }
                                            istg = true;
                                        }
                                    });

                                } else {
                                    alert("请最少选择一条需要操作记录");
                                    istg = true;
                                    return false;
                                }

                            }


                            jQuery(document).ready(function () {

//批量通过
                                $("#batchPass").click(function () {

                                    var ids = [];//定义一个数组      
                                    var openids = [];//定义一个数组      
                                    $('.ids:checked').each(function () {//遍历每一个名字为interest的复选框，其中选中的执行函数      
                                        ids.push($(this).val());//将选中的值添加到数组chk_value中      
                                        openids.push($(this).attr('alt'));//将选中的值添加到数组chk_value中      
                                    });


                                    ajaxBatch(ids, openids, 1);

                                });

                                //批量导出
                                $("#batchExport").click(function () {
                                    var ids = [];
                                    $('.ids:checked').each(function () {
                                        ids.push($(this).val());
                                    });
                                    var data = {
                                        name: $("[name='name']").val(),
                                        sTime: $("[name='sTime']").val(),
                                        eTime: $("[name='eTime']").val(),
                                        state: $("[name='state']").val(),
                                        sex: $("[name='sex']").val(),
                                        grade: $("[name='grade']").val(),
                                        channel: $("[name='channel']").val()
                                    };
                                    var url = "<?php echo url('Partner', 'exportCheckPartner', array(), 'admin.php'); ?>";
                                    url += '&name=' + data.name +
                                            '&sTime=' + data.sTime +
                                            '&eTime=' + data.eTime +
                                            '&state=' + data.state +
                                            '&sex=' + data.sex +
                                            '&grade=' + data.grade +
                                            '&channel=' + data.channel +
                                            '&ids=' + ids;
                                    location.href = url;
                                });
//批量拒绝
                                $("#batchRefuse").click(function () {

                                    var ids = [];//定义一个数组      
                                    var openids = [];//定义一个数组      
                                    $('.ids:checked').each(function () {//遍历每一个名字为interest的复选框，其中选中的执行函数      
                                        ids.push($(this).val());//将选中的值添加到数组chk_value中      
                                        openids.push($(this).attr('alt'));//将选中的值添加到数组chk_value中      
                                    });

                                    ajaxBatch(ids, openids, 2);


                                });

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
                                //复制URL
                                function copyToClipboard(txt) {

                                    if (window.clipboardData) {
                                        window.clipboardData.clearData();
                                        clipboardData.setData("Text", txt);
                                        alert("复制成功！");

                                    } else if (navigator.userAgent.indexOf("Opera") != -1) {
                                        window.location = txt;
                                    } else if (window.netscape) {
                                        try {
                                            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                                        } catch (e) {
                                            alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");
                                        }
                                        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
                                        if (!clip)
                                            return;
                                        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
                                        if (!trans)
                                            return;
                                        trans.addDataFlavor("text/unicode");
                                        var str = new Object();
                                        var len = new Object();
                                        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
                                        var copytext = txt;
                                        str.data = copytext;
                                        trans.setTransferData("text/unicode", str, copytext.length * 2);
                                        var clipid = Components.interfaces.nsIClipboard;
                                        if (!clip)
                                            return false;
                                        clip.setData(trans, null, clipid.kGlobalClipboard);
                                        alert("复制成功！");
                                    }
                                    else {
                                        alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");
                                    }
                                }
                                // TODO 2015-11-11 [熊飞龙]  不知道干嘛用的
                                // $(".copurl").click(function(){
                                // 	var url="http://www.k1982.com//design/101010.htm";
                                // 	copyToClipboard(url);
                                // 	})

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
                        <th>合伙人编号</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>联系电话</th>
                        <th>注册日期</th>
                        <th>状态</th>
                        <th width="300">快捷操作</th>
                        <th width="100">　详情</th>
                        </tr>
                        </thead>
                        <tbody id="staff-body">

<?php foreach ($partnerList as $k => $v) { ?>
                                <tr class="lis">
                                    <td>
                                        <div class="ckbox ckbox-primary">
                                            <input type="checkbox" class="ids" id="checkbox<?php echo $v['id']; ?>" alt="<?php echo $v['openid']; ?>" value="<?php echo $v['id']; ?>">
                                            <label for="checkbox<?php echo $v['id']; ?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $v['code']; ?></td>
                                    <td><?php echo $v['name']; ?></td>
                                    <td><?php echo ($v['sex'] == 1) ? "男" : "女"; ?></td>
                                    <td style="text-align: left;color:gray"><?php echo $v['phone']; ?></td>
                                    <td><?php echo $v['create_time']; ?></td>
                                    <td><?php
                                        if ($v['state'] == 0) {
                                            echo "待审核";
                                        } elseif ($v['state'] == 1) {
                                            echo "已通过";
                                        } elseif ($v['state'] == 2) {
                                            echo "已拒绝";
                                        } elseif ($v['state'] == 3) {
                                            echo "冻结";
                                        }
                                        ?></td>
                                    <td><a class="btn btn-danger btn-sm" onclick="ajaxBatch('<?php echo $v['id']; ?>', '<?php echo $v['openid']; ?>', '1')">通过</a>&nbsp;

                                        <?php if ($v['state'] == 2) { ?>
                                            <a href="javascript:void(0);" class="btn btn-info btn-sm copurl"  style="background-color:#9D9D9D;" >拒绝</a>&nbsp;
    <?php } else { ?>

                                            <a href="javascript:void(0);" class="btn btn-info btn-sm copurl" onclick="ajaxBatch('<?php echo $v['id']; ?>', '<?php echo $v['openid']; ?>', '2')">拒绝</a>&nbsp;
    <?php } ?>

                                        <a class="btn btn-primary btn-sm" href="<?php echo url('Partner', 'partnerEdit', array('id' => $v['id'], 'type' => 'checkPartnerList'), 'admin.php'); ?>">编辑</a></td>
                                    <td><a class="more">+</a></td>
                                </tr>
                                <tr class="liscon">
                                    <td colspan="9">
                                        <div class="newnnn">
                                            <a class="btn btn-default">合伙人编号 ： <?php echo $v['code']; ?></a>
                                            <a class="btn btn-default">姓名： <?php echo $v['name']; ?></a>
                                            <a class="btn btn-default">性别：  <?php echo ($v['sex'] == 1) ? "男" : "女"; ?></a>
                                            <a class="btn btn-default">联系电话： <?php echo $v['phone']; ?></a>
                                            <a class="btn btn-default">区域：  <?php echo $v['area']; ?></a>
                                            <a class="btn btn-default">地址：  <?php echo $v['address']; ?></a>
                                            <a class="btn btn-default">身份证：  <?php echo $v['identity_card']; ?></a>
                                            <a class="btn btn-default">职业：  <?php echo $v['profession']; ?></a>
                                            <a class="btn btn-default">注册时间：  <?php echo $v['create_time']; ?></a>
                                            <a class="btn btn-default">备注：  <?php echo $v['msg']; ?></a>
                                        </div>
                                    </td>
                                </tr>

<?php } ?>

                        </tbody>
                    </table>

                </form>
                <div class="panel-footer">
                    <div class="row">

                        <div class="col-xs-12">
                            <div class="pagenumQu">
<?php tpl('Admin.Common.page'); ?>
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


        });
    </script>


</div>
<!-- mainpanel -->
</div>
<!-- mainwrapper -->

<?php tpl('Admin.Common.footer'); ?>