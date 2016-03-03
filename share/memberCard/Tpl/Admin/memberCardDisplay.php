<?php tpl("Admin.Common.header") ?>
<?php tpl("Admin.Common.menu"); ?>


<table class="list-table" cellspacing="0"  cellpadding="0" border="0">
    <thead>
        <tr>
            <th>编号</th>
            <th>卡券id</th>
            <th>卡券类型</th>
            <th>logo</th>
            <th>商户名称</th>
            <th>卡名称</th>
            <th>操作</th>
        </tr>
    </thead>    
    <tbody>
        <?php

        if ($list) {
            foreach ($list['data'] as $key => $val) {
                ?>
                <tr>
                    <td><?php echo $val['id']; ?></td>
                    <td><?php echo $val['card_id']; ?></td>
                    <td><?php echo $code_type[$val['card_type']]; ?></td>	
                    <td><img src="<?php echo $val['logo_url']; ?>"></img></td>
                    <td><?php echo $val['brand_name']; ?></td>      
                    <td><?php echo $val['title']; ?></td>      
                    <td><a href="<?php echo url('Index', 'memberEdit', array('id' => $val['id']), 'admin.php'); ?>">编辑</a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr><td class="txtleft" colspan="9"></td></tr>
        <?php } ?>
    </tbody>
</table>
<div class="row-fluid page js_pageContent" style="margin-top:-10px;">
    <?php echo $page; ?>
</div>
<?php tpl('Admin.Common.footer'); ?>

