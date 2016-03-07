<?php tpl('Index.Common.header');?>
<div class="bglayer" style="display: none;">
    <div class="layer">
        <div class="nam">发放成功！</div>
        <a>关闭</a>
    </div>
</div>
<script>
$(function(){
    $(".lqcheack a").click(function(){
        $(".lqcheack a").removeClass("dq");
        $(".box1").removeClass("dq");
        $(this).addClass("dq");
        $(".box1").eq($(this).index()).addClass("dq");
        })
    })

</script>
<div class="vip new">
    <span class="vip1">vip</span><span><?php echo $cardone['cardname'] ?></span> <span class="time">（<?php echo date("Y-m-d ", $cardone['from_time']);  ?>&nbsp;至&nbsp;<?php echo date("Y-m-d ", $cardone['end_time']);  ?>&nbsp;有效）</span>
</div>

<div class="bccs new new3">
    <dd><img src="./Public/Index/images/ico7.png"><span>当前库存：<?php echo $cardone['card_number'] ?>/<?php echo $cardone['card_ceiling'] ?></span><b>（可发/总量）</b></dd>
    <dd class="a2"><img src="./Public/Index/images/ico8.png"><span>补充次数：<?php echo $cardone['card_supplement'] ?></span></dd>
    <dd class="a2"><img src="./Public/Index/images/ico9.png"><span>累计补充：<?php echo $cardone['card_issue'] ?></span></dd>
  <dd class="n1"><img src="./Public/Index/images/a2.png"><span>发放情况：<?php echo $cardone['card_receiv'] ?>/<?php echo $cardone['card_issued'] ?> </span><b>（领取/发放）</b></dd>
    <dd class="a2"><img src="./Public/Index/images/ico9a.png"><span>核销情况：<?php echo $cardone['card_cancel'] ?>/<?php echo $cardone['card_receiv'] ?></span><b>（核销/领取）</b></dd>
</div>

<div class="lqcheack">
  <a class="dq">自己领取</a><a >发放给朋友 </a>
</div>
<div class="box1 dq">
    <div class="lqyiz">（每次只限领一张）</div>
    <a href="javascript:;" class="butlq" id="gets">立即领取</a>
</div>

<div class="box1">
    <div class="pyfs">
        <dd><span>发放数量：</span><input class="ii2" id="issuenum" type="tel" /></dd>
        <dd><span>领取限制：</span>每人限领取<input class="i2" id="limitnum" type="tel" value="1" />&nbsp;张</dd>
        <dd><span>领取方式：</span><input type="radio" id="radio" checked="true" /><label for="radio">先到先得</label></dd>
        <a href="javascript:;" class="butlq" id="fafang">确认发放</a>
    </div>
</div>


<script type="text/javascript">
isSuccess = false; 
idval = 0;
$(function(){
    $(".bglayer .layer a").click(function(){
        $(".bglayer").hide();
        if(isSuccess){
            var url = "<?php echo url('Card', 'issueWeb', array(), 'index.php'); ?>";
            issuenum = $('#issuenum').val();
            limitnum = $('#limitnum').val();
            window.location.href = url + "&id=" + idval; 
            return;  
        }
        })
    })
    
isloading = true;
$('#fafang').on('click',function(){
        if(!isloading){
            return false;     
        }
        
        issuenum = $('#issuenum').val();
        limitnum = $('#limitnum').val();
        if(issuenum == ''){
            $('.nam').html('发放数量不能为空！');   
            $('.bglayer').show();  
            return;      
        }
        if(limitnum == ''){
            return false;
            $('.nam').html('领取限制不能为空！');   
            $('.bglayer').show();  
            return;      
        }
        isloading = false;
        postData = {
            'cardid':'<?php echo $cardid ?>',
            'limitnum':limitnum,
            'issuenum':issuenum
        };
        $.get(
            "<?php echo url('Card', 'ajaxIssueCard', array(), 'index.php'); ?>",
            postData
            ,
            function (json) { 
                $('.nam').html(json['msg']);   
                isloading = true;
                $('.bglayer').show();
                if(json['error'] == 0){
                    idval = json['data'];
                    isSuccess = true;
                }
            }, 'json'
        );
})



var isPost = true;
$("#gets").click(function() {
    var url = "<?php echo url('Card', 'getPartnerMyCard', array(),'index.php');?>";
        if (!isPost) {
            return false;
        }   
        isPost = false;  
        $.post(url,
            {          
                cardid:'<?php echo $cardone['cardid'] ?>'
            },function(data) {
            var json = JSON.parse(data);
                
                if(json.error==0){
                    //isPost = false;
                    atr = json.data;
                    
                    var readyFunc = function onBridgeReady() {
                        WeixinJSBridge.invoke('batchAddCard', atr, function(res){
                            if(res.err_msg=='batch_add_card:ok') {
                                giveCardCode(json.msg);
                            }
                            /*else{
                                alert('领取失败！');
                            }*/   
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
                isPost = true;
        })
            
  
    })
    
function giveCardCode(code){
        var url = "<?php echo url('Card', 'successPartnerCard', array(), 'index.php'); ?>";
        // 用户确认分享后执行的回调函数
        $.ajax({ 
            url: url, 
            data:{
                cardid:'<?php echo $cardone['cardid'] ?>',
                code:code
            },
            type:'get',
            success: function(res){
              
                var res = jQuery.parseJSON(res); 
                if(res.error == 0){
                    
                    return;
                }
                $('.nam').html(res.msg);   
                $('.bglayer').show();
                return; 
            }
        });
}  

</script>

<div style="height:60px"></div>
<?php tpl('Index.Common.footer');?>