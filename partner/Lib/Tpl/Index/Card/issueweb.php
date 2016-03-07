<?php tpl('Index.Common.header');?>
<div class="vip new">
    <span class="vip1">vip</span><span><?php echo $cardIssue['card_name'] ?></span><span class="time">有效期：<?php echo date("Y-m-d", $cardIssue['from_time']) ?>至<?php echo date("Y-m-d", $cardIssue['end_time']) ?></span> 
</div>

<div class="bccs new new2">
    <dd><img src="./Public/Index/images/a1.png"><span>发放数：</span><b><?php echo $cardIssue['issue_num'] ?></b></dd>
    <dd class="n1"><img src="./Public/Index/images/ico5.png"><span>领取方式：</span> <b>先到先得</b></dd>
</div>

<div class="fs"><b>&nbsp;</b>发放方式</div>

<div class="hdgz new">
    <ul>
        <li>长按下方二维码，发送给朋友</li>
        <li>长按下方二维码，保存至手机，再发送到朋友圈。</li>
        <li>右上角 --> 分享 --> 你懂的 ^-^</li>
    </ul>
</div>

<div class="ewm"><img src="http://sh.app.socialjia.com/5100Partner/www/index.php?a=Card&m=getcode&cardid=<?php echo $cardIssue['card_id']; ?>&id=<?php echo $cardIssue['id']; ?>&openid=<?php echo $cardIssue['openid']; ?>" alt=""><br>扫一扫上面的二维码，领取卡券</div>



<div style="height:60px"></div>
<?php tpl('Index.Common.footer');?>