<?php tpl('Index.Common.header'); ?>
<div class="use">
    <div class="u1"><img src="./Public/Index/images/u1.png" class="n1"><br><p>编号：-</p>-</div>
    <table width="100%" class="u2 new">
        <tr>
            <td class="l1"><span>-</span><br>返利</td>
            <td class="r1"><b><span>-</span><br>积分</b></td>
        </tr>
    </table>
</div>

<!--审核-->
<div class="sh1 two"><img src="./Public/Index/images/sh2.png"><br>很遗憾，您未通过审核。<br>
    （如有问题，请致电 <img class="a1" src="./Public/Index/images/dh1.png"/><a href="tel:400-890-5100">400-890-5100</a>  咨询）</div>

<div class="ediatUse">
    <a href="<?php echo url('User', 'editPartner', array('recheck' => 1), 'index.php'); ?>">重新申请</a>
</div>

<fieldset class="botto">
    <legend>水质决定品质<br /> 
        海拔5100米极地冰泉<br /> 
        肌肤的冰泉饮
    </legend>
</fieldset>
</body>
</html>