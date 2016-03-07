<?php tpl('Index.Common.header');?>
<style type="text/css">
html,body{ min-height:100%; height:auto;}
body{ background:url(./Public/Index/images/newbg.jpg) no-repeat center bottom #ebf6fc; background-size:100% auto}
footer{ display:none}
</style>
<div class="bglayer" style="display: none;">
    <div class="layer">
        <div class="nam">成功！</div>
        <a>关闭</a>
    </div>
</div>
<div class="vip">
    <span class="vip1">vip</span><span><?php echo $cardone['cardname'] ?></span>              <b>有效期：<?php echo date("Y-m-d", $cardone['from_time']) ?>至<?php echo date("Y-m-d", $cardone['end_time']) ?></b>
</div>

<div class="hdgz new">
<p>使用须知：</p>
    <div>
    <?php echo stripslashes(htmlspecialchars_decode($cardone['card_msg'])) ?>
    </div>
    
</div>

<div class="vip2">仅剩<b> <?php echo $cardissue['issue_num']-$cardissue['receiv_num'] ?>张</b> 可领取                            <span>（每人限领<?php echo $cardissue['limit_num'] ?>张）</span></div>

<div class="but1" id="gets"><a  href="javascript:;">立即领取</a></div>

<script type="text/javascript">
$(function(){
    $(".bglayer .layer a").click(function(){
        $(".bglayer").hide();  
        });
    
var isPost = true;
$("#gets").click(function() {
    
    var url = "<?php echo url('Obtaincard', 'getCard', array(),'index.php');?>";
        if (!isPost) {
            return false;
        }   
        isPost = false;  
        $.post(url,
            {
                usopenid:'<?php echo $usopenid ?>',
                sueid:'<?php echo $cardissue['id'] ?>',
                cardid:'<?php echo $cardone['cardid'] ?>'
            },function(data) {
            var json = JSON.parse(data);
                if(json.error==0){
                    //isPost = false;
                    atr = json.data;
                    
                    var readyFunc = function onBridgeReady() {
                        WeixinJSBridge.invoke('batchAddCard', atr, function(res){
                            err_msg = res.err_msg;
                            if(err_msg == 'batch_add_card:ok') {
                                giveCardCode(json.msg,'<?php echo $cardone['cardid'] ?>','<?php echo $usopenid ?>');
                                alert('领取成功');
                            }  
                        }) 
                    }
                    if (typeof WeixinJSBridge === "undefined") {
                        document.addEventListener('WeixinJSBridgeReady', readyFunc, false);
                    }else {
                        readyFunc();
                    }
                }else{
                    $('.nam').html(json.msg);   
                    $('.bglayer').show();   
                    
                }
        })
            
  
    })
    
    });
    
function giveCardCode(code,cardid,usopenid){
        var url = "<?php echo url('Obtaincard', 'successCard', array(), 'index.php'); ?>";
        // 用户确认分享后执行的回调函数
        $.ajax({ 
            url: url, 
            data:{
                cardid:cardid,
                id:'<?php echo $cardissue['id'] ?>',
                usopenid:usopenid,
                code:code
            },
            type:'get',
            success: function(res){
              
                var res = jQuery.parseJSON(res); 
                if(res.error == 0){
                    location.reload();
                    return;
                }
                $('.nam').html(res.msg);   
                $('.bglayer').show();
                return;                                   
            }
        });
}

</script>


<?php tpl('Index.Common.footer');?>