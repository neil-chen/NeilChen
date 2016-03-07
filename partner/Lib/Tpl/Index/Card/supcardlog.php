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

page = 1;
isloading = true;
function pullUpAction () {
    setTimeout(function () {    // <-- Simulate network congestion, remove setTimeout from production!
        if(!isloading){
            return false;    
        }
        isloading = false;
        var el, li, i;
        el = document.getElementById('thelist');
        page++;
        postData = {
            'page':page,
            'cardid':'<?php echo $cardid ?>'
        };
        $.get(
            "<?php echo url('Card', 'ajaxSupCardLog', array(), 'index.php'); ?>",
            postData
            ,
            function (json) {  
                if (json['error'] == 0) { 
                     _html = '';
                     $.each(json['data'],function(n,value) { 
                        _html += '<li><dd>'+value['create_time']+'</dd><dd>'+value['sub_status']+'</dd><dd>'+value['tosup_num']+'</dd></li>';  
                    })   
                    isloading = true;
                } else {
                    _html = '<span style="color:red">没有数据！</span>';
                    $('.pullUpLabel').hide();
                    $('.pullUpIcon').hide();
                }            
                $('#thelist').append(_html);
                myScroll.refresh();  // Remember to refresh when contents are loaded (ie: on ajax completion)
            }, 'json'
        );         
        
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
                pullUpAction();    // Execute custom function (ajax call?)
            }
        }
    });
    
    setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
}



document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);
</script>
<div class="vip new">
    <span class="vip1">vip</span><span><?php echo $cardone['cardname'] ?></span> 
</div>

<div class="bccs">
    <dd><span>补充次数：</span><?php echo $cardstu['card_supplement'] ?></dd>
    <dd><span>累积补充：</span> <?php echo $cardstu['card_issue'] ?></dd>
</div>


<div class="tableName">
    <dd>申请时间</dd><dd>申请状态</dd><dd>补充数量</dd>
</div>

<div class="bfnew">
<div id="wrapper">
    <div id="scroller">
        <div id="pullDown" style="height:0px">
        </div>
        <?php
            if($list){
        ?>
        <ul id="thelist">
            <?php foreach($list as $v){ ?>
                <li><dd><?php echo $v['create_time'] ?></dd><dd><?php echo $v['sub_status'] ?></dd><dd><?php echo $v['tosup_num'] ?></dd></li>
            <?php } ?>
            
        </ul>
        <div id="pullUp">
            <span class="pullUpLabel">下拉获取更多</span><span class="pullUpIcon"></span>
        </div>
        <?php
             }else{
                 echo '<span style="color:red">没有数据！</span>';
             }
        ?>
    </div>
</div>
</div>


<div style="height:60px"></div>


<div style="height:60px"></div>
<?php tpl('Index.Common.footer');?>