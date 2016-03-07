<?php tpl('Index.Common.header');?>

<div class="bglayer" style="display: none;">
    <div class="layer">
        <div class="nam"><p>主银，补充申请已经提交成功！</p>(请耐心等待审核结果)</div>
        <a>关闭</a>
    </div>
</div>

<?php
    $nextscor = $nextlevel['from_score']-$user_score;
?>
<div class="hdgz new kb">
主银，您目前已经是<strong><?php echo $level['name'] ?></strong>！拥有<?php echo $cardstu['par_species'] ?>大类，共<?php echo $cardstu['par_number'] ?>张卡券（可发）！
<?php if($nextscor > 0){ ?>
还需要<?php echo $nextlevel['from_score']-$user_score; ?>积分才能升级为<?php echo $nextlevel['name'] ?>！请继续努力噢！
<?php }else{ ?>
恭喜您，已经成为了顶级合伙人！
<?php } ?>

 </div>

<?php
    if($cardAll){
     foreach($cardAll as $k=>$v){
 ?>
  <div class="cardclass" id="card<?php echo $k ?>" style="display: <?php if($k == 0){ echo 'block';}else{ echo 'none';}?>;">
<div class="vip new">
    <span class="vip1">vip</span><span><?php echo $v['card_name'] ?></span> <span class="time">有效期：<?php echo date("Y-m-d ", $v['from_time']);  ?>至<?php echo date("Y-m-d ", $v['end_time']);  ?></span>
</div>


<div class="bccs new new3"> 
    <dd><img src="./Public/Index/images/ico7.png"><span>当前库存：<?php echo $v['card_number'] ?>/<?php echo $v['card_ceiling'] ?></span><b>（可发/总量）</b></dd>
    <dd class="a2"><img src="./Public/Index/images/ico8.png"><span>补充次数：<?php echo $v['card_supplement'] ?></span></dd>
    <dd class="a2"><img src="./Public/Index/images/ico9.png"><span>累计补充：<?php echo $v['card_issue'] ?></span></dd>
  <dd class="n1"><img src="./Public/Index/images/a2.png"><span>发放情况：<?php echo $v['card_receiv'] ?>/<?php echo $v['card_issued'] ?> </span><b>（领取/发放）</b></dd>
    <dd class="a2"><img src="./Public/Index/images/ico9a.png"><span>核销情况：<?php echo $v['card_cancel'] ?>/<?php echo $v['card_receiv'] ?></span><b>（核销/领取）</b></dd>
</div>



<div class="card10">
<?php
    $time = time();
    $url = url('Card', 'IssueCard', array('cardid'=>$v['cardid']), 'index.php');
    /*if($v['end_time'] < $time || $v['card_number'] == 0){
        $url = 'javascript:;';    
    }*/
?>
<dd><a href="javascript:;" onclick="getCardFf('<?php echo $v['cardid'] ?>',<?php echo $v['card_number'] ?>);">卡券发放</a></dd><dd class="a2"><a href="<?php echo url('Card', 'IssueCardLog', array('cardid'=>$v['cardid']), 'index.php'); ?>">发放记录</a></dd><dd class="a3"><a href="javascript:;" class="applySup" alt="<?php echo $v['cardid'] ?>">申请补充</a></dd><dd class="a4"><a href="<?php echo url('Card', 'SupCardLog', array('cardid'=>$v['cardid']), 'index.php'); ?>">补充记录</a></dd><dd class="a5"><a href="<?php echo url('Card', 'CardTracking', array('cardid'=>$v['cardid']), 'index.php'); ?>">卡券追踪</a></dd>
</div>
</div>
 <?php } ?>

<div class="swiper-container new">
    <div class="swiper-wrapper">
                     
            <?php
            $i = 1;
             foreach($cardAll as $k=>$v){
                 $percent = 0;
                 $color = '';
                 if( $v['card_ceiling'] != 0){
                    $percent = $v['card_number']/$v['card_ceiling'];      
                     if($percent > 0.8){
                        $color = '#01bbdc';    
                     }else if($percent > 0.2 && $percent < 0.8){
                        $color = '#ffc446'; 
                     }else if($percent < 0.2 && $percent > 0.01){   
                        $color = '#ff9ab2';  
                     }else if($percent < 0.01){
                         $percent = 0;
                         $color = '#ff9ab2';  
                     } 
                 }
                 
                 $percent = $percent*100;
         ?>
        <?php if($k == 0){ ?> 
        <div class="swiper-slide">
            <div class="card1"> 
         <?php }else{ ?>
         
            
         <?php 
         if($k%4 == 0){
          ?>
           </div>
                </div> 
           <div class="swiper-slide">
            <div class="card1"> 
         <?php } } ?>
                
                <dd class="<?php if($k == 0){ ?> dq <?php } ?>" alt="<?php echo $k ?>" style="height: 90px;">
                    <div class="range">
                        <b style="background-color:<?php echo $color ?>; width:<?php echo $percent ?>%">&nbsp;</b>
                    </div>
                    <div class="namec">
                        <?php echo $v['card_name'] ?>
                        <br/>
                        已发<?php echo $v['card_ceiling'] - $v['card_number'] ?>张，剩余<?php echo $v['card_number'] ?>张
                    </div>
                </dd>
                          
                
                <?php
           $i++;  }
    }else{ echo '没有卡券';}
        ?>
          
        </div>
            </div> 
        
         
        
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<script type="text/javascript" src="./Public/Index/js/swiper.min.js"></script>
<link rel="stylesheet" type="text/css" href="./Public/Index/css/swiper.min.css">
<script language="javascript"> 
var mySwiper = new Swiper('.swiper-container',{
prevButton:'.swiper-button-prev',
nextButton:'.swiper-button-next'
});

$('.swiper-slide dd').on('click',function(){
    $('.cardclass').hide();
    $('.swiper-slide dd').attr('class','');
    $('#card'+$(this).attr('alt')).show();
    $(this).attr('class','dq');
});
isloading = true;
$(function(){
    $(".bglayer .layer a").click(function(){
        $(".bglayer").hide();
        });
    $('.applySup').on('click',function(){
        if(!isloading){
            return false;     
        }
        isloading = false;
        cardid = $(this).attr('alt');
        postData = {
            'cardid':cardid
        };
        $.get(
            "<?php echo url('Card', 'ajaxCardApply', array(), 'index.php'); ?>",
            postData
            ,
            function (json) {  
               
                $('.nam').html(json['msg']);   
                isloading = true;
                $('.bglayer').show();
            }, 'json'
        );
    });    
});
isff = true;
function getCardFf(cardid,num){
        if(num == 0){
            $('.nam').html('主银，卡券没有了，请申请补充！');   
            isff = true;
            $('.bglayer').show();  
            return false; 
        }
        if(!isff){
            return false;     
        }
        isff = false;
        postData = {
            'cardid':cardid
        };
        $.get(
            "<?php echo url('Card', 'ajaxCardCheck', array(), 'index.php'); ?>",
            postData
            ,
            function (json) {  
                if(json['error'] == 1){
                    urls = "<?php echo url('Card', 'IssueCard', array(), 'index.php'); ?>";
                    location.href=urls + "&cardid=" + cardid;   
                    return;     
                }
                $('.nam').html(json['msg']);   
                isff = true;
                $('.bglayer').show();
            }, 'json'
        );    
}



</script>




<?php tpl('Index.Common.footer');?>