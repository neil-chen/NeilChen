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

<div class="meGrxx">
    <dd><span>姓名</span><?php echo $data['name'];?></dd>
    <dd><span>性别</span><?php echo $data['sex_name'];?></dd>
    <dd><span>生日</span><?php echo $data['birthday'];?></dd>
    <dd><span>职业</span><?php echo $data['profession'];?></dd>
    <dd><span>手机</span><?php echo $data['phone'];?>  </dd>
    <dd><span>身份证</span><?php echo $data['identity_card'];?></dd>
    <dd><span>所在地</span><?php echo $data['area'] . $data['address'];?></dd>
</div>

<div class="but1" style="margin:20px 15px">
    <a href="<?php echo url('User','editPartner', null, 'index.php'); ?>">修改信息</a>
</div>

<?php tpl('Index.Common.footer');?>