<?php tpl('Index.Common.header');?>

<div class="use">
    <div class="u1">
        <?php if (!empty($data['wx_img'])) { ?>
            <img src="<?php echo $data['wx_img']; ?>" class="n1"><br>
        <?php } else { ?>
            <img src="./Public/Index/images/u1.png" class="n1"><br>
        <?php } ?>

        <p>编号：<?php echo $data['code'];?></p><?php echo $level['level']['name'];?></div>

    <table width="100%" class="u2">
        <tr>
            <td class="l1">
                <span>￥<?php echo !isset($data['rebate']) ? '0.00' : $data['rebate'];?></span><br>返利
            </td>
            <td class="r1">
                <b><span><?php echo $data['integral'];?></span><br>积分</b> 

                <?php if ($data['integral'] < $level['next_level']['score']) { ?>
                    <b class="b">还需要<span><?php echo intval($level['next_level']['from_score'] - $data['integral']);?></span>积分升级为<?php echo $level['next_level']['name'];?></b>
                <?php } else { ?>
                    <b class="b">恭喜您，已经成为了顶级合伙人！</b>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>

<!--but-->
<div class="Ibut">
    <a class="i1" href="<?php echo url('Invitation','index', null, 'index.php'); ?>">呼朋唤友</a>&nbsp;&nbsp;<a class="i2" href="<?php echo url('Card','MyCard', null, 'index.php'); ?>">我的卡包</a><br>
    <a class="i3" href="<?php echo url('Rebate','rebate',null,'index.php')?>">我的返利</a>&nbsp;&nbsp;<a class="i4" href="<?php echo url('User','partnerInfo', null, 'index.php'); ?>">个人信息</a>
</div>

<?php tpl('Index.Common.indexFooter');?>