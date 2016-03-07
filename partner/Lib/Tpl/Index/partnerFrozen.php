<?php tpl('Index.Common.header'); ?>
<div class="use">
    <div class="u1">
        <?php if (!empty($data['wx_img'])) { ?>
            <img src="<?php echo $data['wx_img']; ?>" class="n1"><br>
        <?php } else { ?>
            <img src="./Public/Index/images/u1.png" class="n1"><br>
        <?php } ?>

        <p>编号：<?php echo $data['code']; ?></p><?php echo $level['level']['name']; ?>
    </div>

    <table width="100%" class="u2">
        <tr>
            <td class="l1">
                <span>￥<?php echo!isset($data['rebate']) ? '0.00' : $data['rebate']; ?></span><br>返利
            </td>
            <td class="r1">
                <b><span><?php echo $data['integral']; ?></span><br>积分</b> 

                <?php if ($data['integral'] < $level['next_level']['score']) { ?>
                    <b class="b">还需要<span><?php echo intval($level['next_level']['from_score'] - $data['integral']); ?></span>积分升级为<?php echo $level['next_level']['name']; ?></b>
                <?php } else { ?>
                    <b class="b">恭喜您，已经成为了顶级合伙人！</b>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>

<!--审核-->
<div class="sh1 two"><img src="./Public/Index/images/sh2.png"><br>很遗憾，您的账号已被冻结。<br>
    （如有问题，请致电 <img class="a1" src="./Public/Index/images/dh1.png"/><a href="tel:400-890-5100">400-890-5100</a>  咨询）</div>

<fieldset class="botto">
    <legend>水质决定品质<br /> 
        海拔5100米极地冰泉<br /> 
        肌肤的冰泉饮
    </legend>
</fieldset>
</body>
</html>