<?php tpl('Admin.Common.header'); ?>
<body>
    <style>
        .select2-results .select2-result-label{ width:100px}
    </style>
    <div class="mainpanel">
        <div class="contentpanel">

            <div class="panel panel-default">

                <div class="panel-body">
                    <form class="form-inline" method="POST" action="<?php echo url('Card', 'cardInfoList', '', 'admin.php'); ?>">
                        <!--查询-->
                        <div class="form-group"><label>关键字：</label>
                            <input class="form-control" type="text" name="order_id" style="width:200px;" placeholder="可输入卡券名、编号、card_id进行查询"  maxlength="100" value="<?php echo $param['order_id']; ?>">
                        </div>
                        <div class="form-group">
                            <label>生成时间段:</label>
                            <input style="cursor: pointer;cursor: hand;background-color: #ffffff" name="create_time" class="form-control datepicker" value="<?php echo $param['create_time']; ?>" placeholder="请选择日期" type="text" readonly> 

                        </div>
                        <div class="form-group">
                            <label>类型 :</label>
                            <select name="status1" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                                <option value="">全部</option>
                                <?php foreach ($status1 as $key => $val) {
                                    ?>
                                    <?php if ($key == $param['status1']) {
                                        ?>
                                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                    <?php }
                                    ?>

                                <?php }
                                ?>
                            </select>
                        </div> 


                        <div class="form-group">
                            <label>是否可补充 :</label>
                            <select name="status2" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                                <option value="">全部</option>
                                <?php foreach ($status2 as $key => $val) {
                                    ?>
                                    <?php if ($key == $param['status2']) {
                                        ?>
                                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                    <?php }
                                    ?>

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
                            <a href="<?php echo url('Card', 'makingCard', array(), 'admin.php'); ?>" class="btn btn-primary">添加卡券</a>

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
                                    })


                                });
                            </script>
                        </div>
                        <table class="table table-bordered mb30">
                            <thead>
                                <tr> 
                                    <th>卡券编号</th>
                                    <th>卡券名</th>
                                    <th width="200">card_id</th>
                                    <th>库存</th>
                                    <th>生成日期</th>
                                    <th>类型</th>
                                    <th>是否可补充</th>
                                    <th>快捷操作</th>
                                    <th width="100">　详情</th>
                                </tr>
                            </thead>
                            <tbody id="staff-body">

                                <?php
                                foreach ($list as $key => $val) {
                                    ?>
                                    <tr class="lis">
                                        <td><?php echo $val['card_sn']; ?></td>
                                        <td><?php echo $val['card_name']; ?></td>
                                        <td><?php echo $val['card_id']; ?></td>
                                        <td><?php echo $val['card_num']; ?></td>
                                        <td> <?php echo date('Y-m-d', $val['create_time']); ?></td>
                                        <td><?php
                                            foreach ($status1 as $key => $value) {
                                                if ($key == $val['type']) {
                                                    echo $value;
                                                }
                                            }
                                            ?></td>
                                        <td><?php
                                            foreach ($status2 as $key => $value) {
                                                if ($key == $val['status']) {
                                                    echo $value;
                                                }
                                            }
                                            ?></td>
                                        <td><a href="<?php echo url('Card', 'upcard', array('id' => $val['id']), 'admin.php'); ?>" class="btn btn-danger btn-sm">编辑</a></td>
                                        <td><a class="more">+</a></td>
                                    </tr>
                                    <tr class="liscon">
                                        <td colspan="10">
                                            <div class="newnnn">
                                                <a class="btn btn-default">卡券编号 ：  <?php echo $val['card_sn']; ?></a><a class="btn btn-default">卡券名：  <?php echo $val['card_name']; ?></a><a class="btn btn-default">CARD_ID： <?php echo $val['card_id']; ?></a><a class="btn btn-default">有效期：  <?php echo date('Y-m-d', $val['from_time']); ?>  至  <?php echo date('Y-m-d', $val['end_time']); ?></a><a class="btn btn-default">当前库存 ：<?php echo $val['card_num']; ?></a><a class="btn btn-default">生成时间：   <?php echo date('Y-m-d', $val['create_time']); ?></a><a class="btn btn-default">卡券类型：  <?php
                                                    foreach ($status1 as $key => $value) {
                                                        if ($key == $val['type']) {
                                                            echo $value;
                                                        }
                                                    }
                                                    ?></a><a class="btn btn-default">可补充</a>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                }
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
</div>
<!-- mainwrapper -->

<?php tpl('Admin.Common.footer'); ?>