<?php tpl('Index.Common.header');?>
<script type="text/javascript" src="./Public/Index/js/zepto.min.js"></script>
<script type="text/javascript" src="./Public/Index/js/iscroll.js"></script>
<script type="text/javascript">
$(function(){
    var hhh=$(".tableName").offset().top+35+60;
    var boxH=$(window).height()-hhh;
    $(".bfnew").css("height",boxH);
    })


var myScroll,
    pullDownEl, pullDownOffset,
    pullUpEl, pullUpOffset,
    generatedCount = 0;
    
istype = 1;
otpage = 1;
uspage = 1;
otstatus = true;
usstatus = true;

isloading1 = true;
isloading2 = true;
function pullUpActionLoad () {
    setTimeout(function () {    // <-- Simulate network congestion, remove setTimeout from production!
        
        var el, li, i;
        el = document.getElementById('thelist');
        _html = '';
        if(istype == 1){
            if(!isloading1){
                return false;    
            }
            isloading1 = false;
            otpage++;
            postData = {
                'page':otpage,
                'cardid':'<?php echo $cardid ?>'
            };
           
            //加载别人领取
            $.get(
                "<?php echo url('Card', 'ajaxIssueCardLog', array(), 'index.php'); ?>",
                postData
                ,
                function (json) {  
                    if (json['error'] == 0) { 
                         url = "<?php echo url('Card', 'issueWeb', array(), 'index.php'); ?>";
                         $.each(json['data'],function(n,value) { 
                             
                            _html += '<li><dd style="width: 25%">'+value['create_time']+'</dd><dd style="width: 25%">'+value['issue_num']+'</dd><dd style="width: 25%">'+value['receiv_num']+'</dd><dd style="width: 25%"><a href="'+ url + '&cardid=' + value['cardid'] + '" class="enter">点击进入</a></dd></li>  ';  
                        })   
                        isloading1 = true;
                    } else {
                        _html = '<span style="color:red">没有数据！</span>';
                        otstatus = false;
                        $('#pullUp').hide();
                        
                    }         
                    pullUpAction (_html);   
                }, 'json'
            );    
        }else{
            if(!isloading2){
                return false;    
            }
            isloading2 = false;
            uspage++;
            postData = {
                'page':uspage,
                'cardid':'<?php echo $cardid ?>'
            };
            //加载自己领取
            $.get(
                "<?php echo url('Card', 'ajaxIssueCardUsLog', array(), 'index.php'); ?>",
                postData
                ,
                function (json) {  
                    if (json['error'] == 0) { 
                         
                         $.each(json['data'],function(n,value) { 
                             
                            _html += '<li><dd style="width: 50%">'+value['receive_time']+'</dd><dd style="width: 50%">1</dd></li>  ';  
                        })   
                        isloading2 = true;
                    } else {
                        _html = '<span style="color:red">没有数据！</span>';
                        usstatus = false;
                        $('#pullUp').hide();
                    } 
                    pullUpAction (_html);           
                }, 'json'
            );    
        }
        
        
                 
        
                
    }, 1000);    // <-- Simulate network congestion, remove setTimeout from production!
}

function loaded() {
    pullDownEl = document.getElementById('pullDown');
    pullDownOffset = pullDownEl.offsetHeight;
    pullUpEl = document.getElementById('pullUp');    
    pullUpOffset = pullUpEl.offsetHeight;
    
    myScroll = new iScroll('wrapper', {
        useTransition: true,
        topOffset: pullDownOffset,
        onRefresh: function () {
            if (pullDownEl.className.match('loading')) {
                pullDownEl.className = '';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
            } else if (pullUpEl.className.match('loading')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '下拉刷新...';
            }
        },
        onScrollMove: function () {
            if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
                pullUpEl.className = 'flip';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手开始更新...';
                this.maxScrollY = this.maxScrollY;
            } else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                this.maxScrollY = pullUpOffset;
            }
        },
        onScrollEnd: function () {
            if (pullUpEl.className.match('flip')) {
                pullUpEl.className = 'loading';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = 'Loading...';                
                pullUpActionLoad();    // Execute custom function (ajax call?)
            }
        }
    });
    
    setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
}

function pullUpAction (strhtml) {
    setTimeout(function () {    // <-- Simulate network congestion, remove setTimeout from production!
        $("#thelist"+istype).append(strhtml);
        myScroll.refresh();        // Remember to refresh when contents are loaded (ie: on ajax completion)
    }, 1000);    // <-- Simulate network congestion, remove setTimeout from production!
}

document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);
</script>
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
        $('#st'+istype).hide();
        $('#load'+istype).hide();
        istype = $(this).attr('alt');
        $('#st'+istype).show();
        $('#load'+istype).show();
        if(usstatus){
            $('#pullUp').show();       
        }
        if(otstatus){
            $('#pullUp').show();       
        }
        })
    })

</script>             
<!--领取-->
<div class="vip new">
    <span class="vip1">vip</span><span><?php echo $cardone['cardname'] ?></span> 
</div>

<div class="bccs new">
    <dd><img src="./Public/Index/images/a1.png"><span>发放次数：<?php echo $count ?></span></dd>
    <dd class="n1"><img src="./Public/Index/images/a2.png"><span>发放情况：<?php echo $cardone['card_receiv'] ?>/<?php echo $cardone['card_issued'] ?></span> <b>（领取/发放）</b></dd>
</div>

<div class="lqcheack">
  <a alt='2'>自己领取</a><a class="dq" alt='1'>发放给朋友 </a>
</div>


<div id="st1">


<div class="name2">已发放 <strong><?php echo $count ?>次</strong>，合计发放 <strong><?php echo $data['issuenum'] ?>张</strong> 卡券，<strong><?php echo $data['receivnum'] ?>张</strong> 被领取</div>


<div class="tableName new">
    <dd>发放时间</dd><dd>发放数量</dd><dd>领取数量</dd><dd>发放页</dd>
</div>
</div>

<div id="st2" style="display: none;">


<div class="name2">已领取<strong><?php echo $uscount ?>张卡券</strong></div>


<div class="tableName new">
    <dd style="width: 50%">领取时间</dd><dd style="width: 50%">领取张数</dd>
</div>
</div>

<div class="bfnew new">
<div id="wrapper">
    <div id="scroller">
        <div id="pullDown" style="height:0px">
        </div>
        <div id="load1">
        <?php
             if($list){
         ?>
        <ul id="thelist1">
            <?php foreach($list as $v){ ?>
            <li><dd style="width: 25%"><?php echo $v['create_time'] ?></dd><dd style="width: 25%"><?php echo $v['issue_num'] ?></dd><dd style="width: 25%"><?php echo $v['receiv_num'] ?></dd><dd style="width: 25%"><a href="<?php echo url('Card', 'issueWeb', array('id'=>$v['id']), 'index.php'); ?>" class="enter">点击进入</a></dd></li>  
            <?php } ?>
        </ul>
        </div>
        <?php
             }else{
                 echo '<span style="color:red">没有数据！</span>';
             }
        ?>
        <div id="load2" style="display: none;">
        <?php
             if($uslist){
         ?>
        <ul id="thelist2">
            <?php foreach($uslist as $v){ ?>
            <li><dd style="width: 50%"><?php echo $v['receive_time'] ?></dd><dd style="width: 50%">1</dd></li>  
            <?php } ?>
        </ul>
        </div>
        <?php
             }else{
                 echo '<span style="color:red">没有数据！</span>';
             }
        ?>
        <div id="pullUp" >
            <span class="pullUpLabel">下拉获取更多</span><span class="pullUpIcon"></span>
        </div>
        
    </div>
</div>
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
    

</script>

<?php tpl('Index.Common.footer');?>