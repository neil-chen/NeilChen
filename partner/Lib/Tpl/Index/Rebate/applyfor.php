<?php tpl('Index.Common.header');?>
<script type="text/javascript" src="./Public/index/js/zepto.min.js"></script>
<!--领取-->
<div class="vip new">
	主银，您已经累积了<strong>￥<?php echo sprintf("%.2f", @$result['total']); ?></strong> 返利了噢！
</div> 

<div class="bccs new new3">
    <dd><span>已提现返利：　￥<?php echo sprintf("%.2f", @$result['towithdraw_money']); ?> </span></dd>
    <dd><span>可提现返利：　<strong>￥<?php echo sprintf("%.2f", @$result['rebate_money']); ?></strong></span></dd>
    <dd class="a2"><span>未入账返利：　￥<?php echo sprintf("%.2f", @$result['notaccount_money']);?> </span><b>（<?php echo date('Y-m-d');?>）</b></dd>
</div>

<div class="tableName new search new1">
    <input type="text" placeholder="提现金额     　(最多可提￥<?php echo sprintf("%.2f", @$result['rebate_money'])?>)" /> <a href="javascript:;" onclick="withdraw(this)">立即提现</a>
</div>

<script>
function withdraw(sendar){
    var withdraw = $(sendar).siblings("input").val();
    var url = "<?php echo url('Rebate','ajaxapplyfor','','index.php')?>";

    var data = {cash:withdraw};
    $.post(url, data, function(response){
        var d = JSON.parse(response);
        alert(d.msg);
        if (d.error == 0) {
            location.reload();
        }
    });
}

</script>


<?php tpl('Index.Common.footer');?>