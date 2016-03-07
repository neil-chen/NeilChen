

<div style="height:60px"></div>
<footer>
    <dd><a class="<?php if($_GET['a'] == 'Invitation') echo "dq";?>" href="<?php echo url('Invitation','index', null, 'index.php'); ?>">呼唤朋友</a></dd>
    <dd class="d2"><a class="<?php if($_GET['a'] == 'Card') echo "dq";?>" href="<?php echo url('Card','MyCard', null, 'index.php'); ?>">我的卡包</a></dd>
    <dd class="d3"><a class="<?php if(isset($a) && $a == 'Rebate') echo "dq";?>" href="<?php echo url('Rebate','rebate',null,'index.php')?>">我的返利</a></dd>
    <dd class="d4"><a class="<?php if($_GET['a'] == 'User') echo "dq";?>" href='<?php echo url('User','partnerInfo', null, 'index.php'); ?>'>个人信息</a></dd>
</footer>

</body>
</html>
<?php tpl('Index.Common.wxjs');?>