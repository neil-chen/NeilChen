<?php tpl("Admin.Common.header") ?>
<?php tpl("Admin.Common.menu"); ?>
<?php $url = url('Index', 'scoreChangeLog', array(), 'admin.php'); ?>
<div class="bodyAll">
    <div class="formUp">
        <div class="form">
            <form action="<?php echo $url; ?>" method="post">
                <label>openid:</label>
                <input type="text" name="openid" style="width:112px;" value="<?php echo $param['openid'];?>"/>
                <label>卡号:</label>
                <input type="text" name="cardid" style="width:112px;" value="<?php echo $param['cardid'];?>"/>
                <input type="submit" value="搜索" class="search">
            </form>
        </div>
    </div>
    <br/>
    <table style="width:100%;height:100%;">
        <tr id="idhead">
            <th>编号</th>
            <th>openid</th>
            <th>变更会员卡卡号</th>
            <th>原有分数</th>
            <th>现有分数</th>
            <th>分数变更</th>
            <th>变更信息</th>
            <th>变更时间</th>
        </tr>
        <?php
        foreach ($list['data'] as $key => $val) {
            ?>   
            <tr>
                <td><?php echo $val['id'] ?></td>
                <td><?php echo $val['openid'] ?></td>
                <td><?php echo $val['membership_number'] ?></td>
                <td><?php echo $val['source_score'] ?></td>
                <td><?php echo $val['now_score'] ?></td>
                <td><?php echo $val['score_change'] ?></td>
                <td><?php echo $val['message'] ?></td>
                <td><?php echo $val['time'] ?></td>
            </tr>

            <?php
        }
        ?>
    </table>
</div>
<div class="row-fluid page js_pageContent" style="margin-top:10px;">
    <?php echo $page; ?>
</div>
<?php tpl('Admin.Common.footer'); ?>