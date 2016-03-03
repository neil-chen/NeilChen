<?php tpl("Admin.Common.header") ?>
<?php tpl("Admin.Common.menu"); ?>
<div class="bodyAll">
<form method="POST" action="<?php echo url('Index','userMemberCard',array(),'admin.php')?>">
    <div class="formUp">
        <div class="form">
            <label>openid:</label><input type="text" value="<?php echo $param['openid'];?>" name="openid"/>
             <label>会员卡编号:</label><input type="text" value ="<?php echo $param['card_num'];?>" name="card_num"/>
             <input type="submit" value="搜索" class="search">
     </div>
    </div>

<table class="list-table" cellspacing="0"  cellpadding="0" border="0">
    
        <tr id="idhead">
            <th>编号</th>
            <th>openid</th>
            <th>领取时间</th>
            <th>卡券ID</th>
            <th>激活状态</th>
            <th>激活时间</th>
            <th>卡券号</th>
            <th>会员卡编号</th>
            <th>编辑</th>
        </tr>
     
    <tbody>
        <?php
        foreach ($list['data'] as $key => $val) {
            ?>
            <tr>
                <td><?php echo $val['id'] ?></td>
                <td><?php echo $val['openid'] ?></td>
                <td><?php echo $val['adddate'] ?></td>
                <td><?php echo $val['card_id'] ?></td>
                <td><?php echo $val['activated'] ?></td>
                <td><?php echo $val['activate_date'] ?></td>
                <td><?php echo $val['code'] ?></td>
                <td><?php echo $val['membership_number'] ?></td>
                <td><a href="<?php echo url('Index', 'usermemberEdit', array('id' => $val['id']), 'admin.php'); ?>">编辑</a></td>
            </tr> 
    <?php
}
?>
    <br/>
        <?php ?>

</tbody>
</table>
<div class="row-fluid page js_pageContent" style="margin-top:-10px;">
    <?php echo $page; ?>
</div>
</form>
    </div>

<?php tpl('Admin.Common.footer'); ?>
