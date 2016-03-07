<?php tpl('Index.Common.header');?>

<div class="bfnew new noe1">
<div id="wrapper">
    <div id="scroller">
        <div id="pullDown" style="height:0px">
        </div>
        <ul id="thelist">
          <div class="ewm one"><img src="<?php echo $qrInfo['qrc_url']; ?>"><br>点击右上分享，召唤好友加入，立享现金返利</div>
            <div class="hdgzclick"><a href="<?php echo url('Invitation','rule', null, 'index.php'); ?>">查看使用规则<img src="./Public/Index/images/ss.png"></a></div>
            <div class="hygz"><img src="./Public/Index/images/ico6.png">已召唤 <?php echo $data['total']; ?> 位好友</div>

            <div class="data-list">
                <?php foreach ($data['list'] as $val) { ?>
                    <li data-id="<?php echo $val['id']; ?>">
                        <div class="l"><img src="<?php echo $val['wx_img']; ?>"></div>
                        <div class="R"><?php echo $val['wx_name']; ?><span><?php echo $val['create_time']; ?></span></div>
                    </li>
                <?php } ?>
            </div>
            
        </ul>
        <div id="pullUp">
            <span class="pullUpLabel">下拉获取更多</span><span class="pullUpIcon"></span>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="./Public/Index/js/iscroll.js"></script>
<script type="text/javascript">
$(function(){

    var boxH=$(window).height()-70;
    $(".bfnew").css("height",boxH);
    })


var myScroll,
    pullDownEl, pullDownOffset,
    pullUpEl, pullUpOffset,
    generatedCount = 0;

// 下拉获取更多
function pullUpAction () {

    var htmls   = '';
    var isExist = '';
    var startId = $("#thelist .data-list li").last().attr("data-id");
    $.post("<?php echo url('Invitation','ajaxGetList', null, 'index.php'); ?>", {"startId": startId}, function (response) {

        if (response.error == 0) {
            for (var key in response.data.list) {

                // 防止重复添加
                isExist = $("#thelist .data-list li[data-id=\""+ response.data.list[key].id + "\"]");
                if (isExist.length == 0) {
                    htmls += '<li data-id="' + response.data.list[key].id + '">';
                        htmls += '<div class="l"><img src="' + response.data.list[key].wx_img + '"></div>';
                        htmls += '<div class="R">' + response.data.list[key].wx_name + '<span>' + response.data.list[key].create_time + '</span></div>';
                    htmls += '</li>';
                }
            }

            $("#thelist .data-list").append(htmls);
        }

        myScroll.refresh();
    }, 'json');
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
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '下拉获取更多';
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
                pullUpAction(); // Execute custom function (ajax call?)
            }
        }
    });
    
    setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
}



document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);

$(function(){
	var winh=$(window).height();
	$("body").css("min-height",winh);
	})
</script>
<?php tpl('Index.Common.footer');?>