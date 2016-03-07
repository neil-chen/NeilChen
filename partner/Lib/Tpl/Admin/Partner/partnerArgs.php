<?php tpl('Admin.Common.header'); ?>
<form id="level_form" method="post" action="<?php echo url('Partner', 'partnerArgsSave', array(), 'admin.php') ?>"
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
                        <div class="panel-body padding">

                            <div class="panel panel-default"><h4 style="color:#000; padding-bottom:20px">等级设置：</h4>
                                <?php foreach ($level as $item) { ?>
                                    <div class="listnew">
                                        <div class="form-group">
                                            <input name="level_id[<?php echo $item['id']; ?>]" type="hidden" value="<?php echo $item['id']; ?>"/>
                                            <input class="form-control input1" type="text" value="<?php echo $item['name']; ?>"  name="level_name[<?php echo $item['id']; ?>]" maxlength="20"/>　：　

                                            <input class="form-control input1" type="text" value="<?php echo $item['from_score']; ?>" readonly="readonly" name="from_score[<?php echo $item['id']; ?>]" maxlength="10"/> - <input class="form-control input1" type="text" value="<?php echo $item['score']; ?>"  name="level_score[<?php echo $item['id']; ?>]" maxlength="10"/>
                                        </div>
                                        <div class="form-group">
                                            <label>持有卡券上限：</label>
                                            <input class="form-control input1" type="text" value="<?php echo $item['card_total']; ?>"  name="card_total[<?php echo $item['id']; ?>]" maxlength="5"/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label>返利百分比：　</label>
                                            <input class="form-control input1" type="text" value="<?php echo $item['rebate']; ?>"  name="rebate[<?php echo $item['id']; ?>]" maxlength="3"/>&nbsp;%
                                        </div>
                                        <div class="form-group">
                                            <input name="cards[<?php echo $item['id']; ?>]" value="<?php echo $item['award_cards']; ?>" type="hidden" class="level_card"/>
                                            <dd>升级后奖励卡券：
                                                <?php foreach ($item['cards'] as $level_card) { ?>
                                                    <span class="voume" data="<?php echo $level_card['id']; ?>"><?php echo $level_card['card_name']; ?><b>X</b></span>
                                                <?php } ?>
                                                <select class="se1">
                                                    <?php foreach ($cards as $card) { ?>
                                                        <option value="<?php echo $card['id']; ?>"><?php echo $card['card_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <a class="btn btn-info btn-sm add">+</a>
                                            </dd>
                                        </div>
                                        <?php if ($end_level && $item['id'] == $end_level['id']) { ?>
                                            <!-- 隐藏删除按钮 -->
                                            <a href="<?php echo url('Partner', 'partnerDelete', array('id' => $item['id']), 'admin.php'); ?>" style="display:none;">删除</a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <div class="addbut"> <a class="btn btn-info btn-lg add2">+</a></div>
                            </div>

                        </div>

                        <div class="panel-body padding">
                            <div class="panel panel-default">
                                <h4 style="color:#000; padding-bottom:20px">呼朋唤友奖励设置：</h4>
                                <div class="form-group">
                                    <label>奖励积分：　</label><input class="form-control input1" type="text" value="<?php if (isset($award[1]['score'])) echo $award[1]['score']; ?>"  name="recommend_score" maxlength="10"/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>奖励现金：　</label><input class="form-control input1" type="text" value="<?php if (isset($award[1]['money'])) echo $award[1]['money']; ?>"  name="recommend_money" maxlength="10"/>
                                </div>	
                            </div>
                        </div>

                        <div class="panel-body padding">
                            <div class="panel panel-default"><h4 style="color:#000; padding-bottom:20px">卡券核销奖励设置：</h4>
                                <div class="form-group">
                                    <label>奖励积分：　</label ><input class="form-control input1" type="text" value="<?php if (isset($award[2]['score'])) echo $award[2]['score']; ?>"  name="card_score" maxlength="10"/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>奖励现金：　</label><input class="form-control input1" type="text" value="<?php if (isset($award[2]['money'])) echo $award[2]['money']; ?>"  name="card_money" maxlength="10"/>
                                </div>
                            </div>
                        </div>

                        <div style="padding-left:8%" class="panel-footer">
                            <!-- 隐藏保存按钮 -->
                            <input type="submit" style="width:130px;display:none;" id="putform" class="btn btn-primary mr20" value="保存" />
                        </div>
                    </div>
                    <!-- col-md-6 -->
                </div>
                <!-- row -->
            </div>
            <!-- contentpanel -->
            <script>

            </script>


        </div>
</form>
<!-- mainpanel -->
</div>

</div>
<!-- mainwrapper -->

<div class="modal fade" id="msg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
                <div id="advice_title" class="modal-title"></div>
                <div id="advice_name" style="float:left;color:#999;font-size:12px;"></div>
                <div id="advice_time" style="float:left;margin-left:20px;color:#999;font-size:12px;"></div>
            </div>
            <div id="advice_content" class="modal-body" style="word-break:break-all;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_advice">关闭</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="./Public/Admin/js/jquery.cityselect.js"></script>
<script type="text/javascript" src="./Public/Admin/js/jquery.validate.js"></script>

<script type="text/javascript">
                $(function () {

                    function clickFunc() {
                        $(".voume b").click(function () {
                            var id = $(this).parent().attr('data');
                            var input = $(this).parent().parent().parent().find('.level_card');
                            var val = input.val();
                            var rstr = new RegExp(id + ',*', 'g');
                            var new_val = val.replace(rstr, '');
                            val = input.val(new_val);
                            $(this).parents(".voume").remove();
                        });
                    }

                    var bindEvent = function ($obj) {
                        clickFunc();
                        $obj.find(".add").click(function () {
                            var a = $(this).html();
                            if (a == '+') {
                                $(this).siblings(".se1").show();
                                $(this).html("添加");
                            } else {
                                $(this).siblings(".se1").hide();
                                $(this).html("+");
                                var htext = $(this).siblings(".se1").find("option:selected").text();

                                //添加选择的
                                var CardId = $(this).siblings(".se1").find("option:selected").val();
                                var hidde = $(this).parents(".listnew").find(".level_card").val();

                                var hiddnn = hidde + ',' + CardId;
                                $(this).parents(".listnew").find(".level_card").val(hiddnn);

                                var html1 = '<span class="voume" data="' + CardId + '">' + htext + '<b>X</b></span>';
                                $(this).siblings(".se1").before(html1);
                            }
                            clickFunc();
                        });
                    }

                    bindEvent($('.listnew'));

                    $('.add2').on('click', function () {
                        var level_id = parseInt($("[name^='level_id']:last").val()) + 1;
                        var from_score = parseInt($("[name^='level_score']:last").val());
                        var html = $($('.listnew:last').get(0).outerHTML);
                        $(this).parents(".addbut").before(html);

                        html.find('input').each(function () {
                            var new_name = $(this).prop('name').replace(/\[\w\]/, '[' + level_id + ']');
                            $(this).prop('name', new_name);
                            if (new_name != 'cards[' + level_id + ']') {
                                $(this).val('');
                            }
                            if (new_name == 'level_id[' + level_id + ']') {
                                $(this).val(level_id);
                            }
                        });
                        $('.listnew:last').find("[name^='from_score']").val(from_score);

                        bindEvent($(html));
                    });

                    jQuery('.datepicker').datepicker({
                        dateFormat: 'yy-mm-dd'
                    });

                    jQuery('.select2').select2({
                        minimumResultsForSearch: -1
                    });

                    $("#distributor-select-search").select2(); //景区查询下拉框     

                    $('.allcheck').click(function () {
                        if ($(this).text() == '全选') {
                            $('#staff-body').find('input').prop('checked', true)
                            $(this).text('反选');
                        } else {
                            $('#staff-body').find('input').prop('checked', false)
                            $(this).text('全选');
                        }
                    });

                    //表单验证
                    $('#putform').click(function (event) {
                        //验证等级设置
                        $("[name^='level_id']").each(function () {
                            var obj = $(this).parent().parent();
                            if (obj.find("[name^='level_name']").val() == '') {
                                alert('请输入等级名称');
                                event.preventDefault();
                                return false; 
                            }
                            if (obj.find("[name^='level_score']").val() == '') {
                                alert('请输入积分段');
                                event.preventDefault();
                                return false;
                            }
                            if (obj.find("[name^='card_total']").val() == '') {
                                alert('请输入持有卡券上限');
                                event.preventDefault();
                                return false;
                            }
                            if (obj.find("[name^='rebate']").val() == '') {
                                alert('请输入返利百分比');
                                event.preventDefault();
                                return false;
                            }
                            
                            var from_score = parseInt(obj.find("[name^='from_score']").val());
                            var level_score = parseInt(obj.find("[name^='level_score']").val());
                            if (level_score <= from_score) {
                                alert('合伙人积分段错误');
                                event.preventDefault();
                                return false;
                            }
                            if (obj.prev().find("[name^='level_id']").length > 0) {
                                var rebate = parseFloat(obj.find("[name^='rebate']").val());
                                var card_total = parseFloat(obj.find("[name^='card_total']").val());
                                var before_card_total = parseFloat(obj.prev().find("[name^='card_total']").val());
                                var before_rebate = parseFloat(obj.prev().find("[name^='rebate']").val());
                                if (card_total < before_card_total) {
                                    alert('持有卡劵上限不能小于上级的上限值');
                                    event.preventDefault();
                                    return false;
                                }
                                if (rebate < before_rebate) {
                                    alert('返利百分比不能小于上级百分比');
                                    event.preventDefault();
                                    return false;
                                }
                            }
                        });

                    });
                });

</script>
<?php tpl('Admin.Common.footer'); ?>