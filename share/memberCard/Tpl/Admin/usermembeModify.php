<?php tpl("Admin.Common.header") ?>
<?php tpl("Admin.Common.menu"); ?>
<html>
    <head>
        <style>
            label{
                display: inline-block;width:100px;
            }
        
        </style>
    </head>
    <body>
        <form method="POST" action="<?php echo url('Index', 'usermembeModify', array('usermember' => $list[0][0]['id']), 'admin.php'); ?>">
            <input type="hidden" value="<?php echo $list[0][0]['id']; ?>" name="modify_id" id="sty"  disabled="disabled"/>
            <label>openid:</label><input type="text" value="<?php echo $list[0][0]['openid']; ?>" name="modify_card_openid" id="sty" disabled="disabled"/><br/><br/>
            <label>领取时间:</label><input type="text" value="<?php echo date("Y-m-d H:i:s",$list[0][0]['adddate']); ?>" name="modify_adddate" id="sty" disabled="disabled"/><br/><br/>
            <label>卡券ID:</label><input type="text" value="<?php echo $list[0][0]['card_id']; ?>" name="modify_card_id" id="sty" disabled="disabled"/><br/><br/>
            <label>激活状态:</label><input type="text" value="<?php echo $list[0][0]['activated'] ? '0' : '1' ? '未激活' : '已激活'; ?>" name="modify_activated" id="sty" disabled="disabled"/><br/><br/>
            <label>激活时间:</label><input type="text" value="<?php echo $list[0][0]['activate_date']; ?>" name="modify_activate_date" id="sty" disabled="disabled"/><br/><br/>
            <label>卡券号:</label><input type="text" value="<?php echo $list[0][0]['code']; ?>" name="modify_code" id="sty" disabled="disabled"/><br/><br/>
            <label>会员卡编号:</label><input type="text" value="<?php echo $list[0][0]['membership_number']; ?>" name="modify_membership_number" id="sty" disabled="disabled"/><br/><br/>
            <label>核销时间:</label><input type="text" value="<?php echo $list[0][0]['sell_date']; ?>" name="modify_sell_date" id="sty" disabled="disabled"/><br/><br/>
            <input type="hidden" value="<?php echo $list[0][0]['delete_date']; ?>" name="modify_delete_date" id="sty" disabled="disabled"/>
            <input type="hidden" value="<?php echo $list[0][0]['outer_id']; ?>" name="modify_outer_id" id="sty" disabled="disabled"/>
            <label>积分:</label><input type="text" value="<?php echo $list[0][0]['bonus']; ?>" name="modify_bonus" id="view"/><br/><br/>
            <label>等级:</label><input type="text" value="<?php echo $list[0][0]['grade']; ?>" name="modify_grade"  id="view"/><br/><br/> 
            <input type="submit" value="提交" style="width:100px;"/>
        </form>
    </body>
</html>
<?php tpl('Admin.Common.footer'); ?>