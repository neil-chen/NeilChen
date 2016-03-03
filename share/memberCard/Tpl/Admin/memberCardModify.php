<?php tpl("Admin.Common.header") ?>
<?php tpl("Admin.Common.menu"); ?>
<style type="text/css">
    #sty{
        width:600px;
    }
    label{ display: inline-block; width: 200px}
    body{
        height:800px;
        background: #f0f3f7;
    }
    #cardId_sty{
        width:600px;
    }
</style>
<script type="text/javascript" src="Public/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    var id = <?php echo $_GET['id'] ?>;
    function getCardInfo()
    {
        $.get("<?php echo url('Index', 'getCardInfo', array(), 'admin.php'); ?>", {"id": id}, function (data) {
            result = JSON.parse(data);
            if (result.error == 0) {
                $("#status").html(result.data.status);
                $("#shenhe").show();//hide
                return;
            }
        });
    }

    function updateCard()
    {
        $.get("<?php echo url('Index', 'updateCard', array(), 'admin.php'); ?>", {"id": id}, function (data) {
            result = JSON.parse(data);
            $("#update").html(result.data.errmsg);
            $("#updatediv").show();
        });
    }



</script>


<form method="POST" action="<?php echo url('Index', 'membeModify', array(), 'admin.php'); ?>" >
    <input type="hidden" value="<?php echo $res['id']; ?>" name="modify_id" id="sty" readonly="true" style="background-color:#D3D3D3;"/>
    <label>卡券id:</label><input type="text" value="<?php echo $res['card_id']; ?>" name="modify_card_id" id="cardId_sty" disabled="disabled"/><br/><br/> 
    <label>Logo链接:</label><input type="text" value="<?php echo $res['logo_url']; ?>" name="modify_logo_url" id="sty"/><br/><br/>
    <label>卡券类型:</label> <select name="modify_card_type" id="sty" disabled="disabled">
        <?php
        foreach ($card_type as $key => $val) {
            if ($key == $res['card_type']) {
                ?>
                <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                <?php
            } else {
                ?>
                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                <?php
            }
        }
        ?>      
    </select><br/><br/>
    <label>卡号显示类型:</label><select name="modify_code_type" id="sty" disabled="disabled">  
        <?php
        foreach ($code_type as $key => $val) {
            if ($key == $res['code_type']) {
                ?>
                <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                <?php
            } else {
                ?>
                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                <?php
            }
        }
        ?>
    </select><br/><br/>
    <label>商户名称:</label><input type="text" value="<?php echo $res['brand_name']; ?>" name="modify_brand_name" id="sty" disabled="disabled"/><br/><br/>
    <label>会员卡名称:</label><input type="text" value="<?php echo $res['title']; ?>" name="modify_title" id="sty" disabled="disabled"/><br/><br/>
    <label>副标题:</label><input type="text" value="<?php echo $res['sub_title']; ?>" name="modify_sub_title" id="sty" disabled="disabled"/><br/><br/>
    <label>颜色:</label>
    <select name="modify_color" id="sty" >
        <?php
        foreach ($color as $key => $val) {
            if ($val == $res['color']) {
                ?>
                <option value="<?php echo $val ?>" selected="selected"> <?php echo $res['color'] ?></option>
                <?php
            } else {
                ?>
                <option value="<?php echo $val ?>"><?php echo $val; ?></option>
                <?php
            }
        }
        ?>
    </select><input type="hidden" id="demo1_text" value=""/>
    <div id="display_color"></div><br/><br/>
    <label>通知:</label><input type="text" value="<?php echo $res['notice']; ?>" name="modify_notice" id="sty"/><br/><br/>
    <label>服务电话:</label><input type="text" value="<?php echo $res['service_phone']; ?>" name="modify_service_phone" id="sty" disabled="disabled"/><br/><br/>
    <label>说明:</label><textarea name="modify_description" id="sty"  style="height:80px;"><?php echo $res['description']; ?></textarea></br><br/>

    <label>用户数量限制:</label><input type="text" value="<?php echo $res['use_limit']; ?>" name="modify_use_limit" id="sty" disabled="disabled"/><br/><br/>
    <label>获取数量限制:</label><input type="text" value="<?php echo $res['get_limit']; ?>" name="modify_get_limit" id="sty" disabled="disabled"/><br/><br/>

    <label>日期类型:</label> 
    <select name="modify_date_type" id="sty" disabled="disabled">
        <?php
        foreach ($date_type as $key => $val) {
            if ($key == $res['date_type']) {
                ?>
                <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                <?php
            } else {
                ?>
                <option value="<?php echo $key ?>"><?php echo $val; ?></option>
                <?php
            }
        }
        ?>
    </select>
    <br/><br/>
    <label>领取后生效天数:</label><input type="text" value="<?php echo $res['date_fixed_term']; ?>" name="modify_date_fixed_term" id="sty" disabled="disabled"/><br/><br/>
    <label>有效期天数:</label><input type="text" value="<?php echo $res['date_fixed_begin_term']; ?>" name="modify_date_fixed_begin_term" id="sty" disabled="disabled"/><br/><br/>
    <label>总数量限制:</label><input type="text" value="<?php echo $res['sku_quantity']; ?>" name="modify_sku_quantity" id="sty" disabled="disabled"/><br/><br/>

    <label>链接类型:</label>
    <select name="modify_url_name_type" id="sty">
        <?php
        foreach ($url_name_type as $key => $val) {
            if ($key == $res['url_name_type']) {
                ?>
                <option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option>
                <?php
            } else {
                ?>
                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                <?php
            }
        }
        ?>

    </select><br/><br/>

    <label>自定义url:</label><input type="text" value="<?php echo $res['custom_url']; ?>" name="modify_custom_url" id="sty"/><br/><br/>
    <label>自定义名称:</label><input type="text" value="<?php echo $res['custom_url_name']; ?>" name="modify_custom_url_name" id="sty"/><br/><br/>
    <label>促销名称:</label><input type="text" value="<?php echo $res['promotion_url_name']; ?>" name="modify_promotion_url_name" id="sty"/><br/><br/>
    <label>促销url:</label><input type="text" value="<?php echo $res['promotion_url']; ?>" name="modify_promotion_url" id="sty"/><br/><br/>
    <label>特权:</label><input type="text" value="<?php echo $res['prerogative']; ?>" name="modify_prerogative" id="sty"/><br/><br/>
    <label>积分清除:</label><input type="text" value="<?php echo $res['bonus_cleared']; ?>" name="modify_bonus_cleared" id="sty"/><br/><br/>
    <label>积分规则:</label><input type="text" value="<?php echo $res['bonus_rules']; ?>" name="modify_bonus_rules" id="sty"/><br/><br/>
    <label>激活链接:</label><input type="text" value="<?php echo $res['activate_url']; ?>" name="modify_activate_url" id="sty"/><br/><br/>

    <label>自定义字段名称:</label> <select name="modify_custom_field1_name_type" id="sty">
        <option><?php echo $res['custom_field1_name_type']; ?></option>
    </select><br/><br/>

    <label>自定url:</label><input type="text" value="<?php echo $res['custom_field1_url']; ?>" name="modify_custom_field1_url" id="sty"/><br/><br/>
    <label>自定义字段名称:</label><input type="text" value="<?php echo $res['custom_field2_name_type']; ?>" name="modify_custom_field2_name_type" id="sty"/><br/><br/>
    <label>自定url:</label><input type="text" value="<?php echo $res['custom_field2_url']; ?>" name="modify_custom_field2_url" id="sty"/><br/><br/>
    <label>自定义字段名称:</label><input type="text" value="<?php echo $res['custom_field3_name_type']; ?>" name="modify_custom_field3_name_type" id="sty"/><br/><br/>
    <label>自定url:</label><input type="text" value="<?php echo $res['custom_field3_url']; ?>" name="modify_custom_field3_url" id="sty"/><br/><br/>
    <label>自定义元素名称:</label><input type="text" value="<?php echo $res['custom_cell1_name']; ?>" name="modify_custom_cell1_name" id="sty"/><br/><br/>
    <label>自定义tips:</label><input type="text" value="<?php echo $res['custom_cell1_tips']; ?>" name="modify_custom_cell1_tips" id="sty"/><br/><br/>
    <label>自定url:</label><input type="text" value="<?php echo $res['custom_cell1_url']; ?>" name="modify_custom_cell1_url" id="sty"/><br/><br/>
    <label>自定义元素名称:</label><input type="text" value="<?php echo $res['custom_cell2_name']; ?>" name="modify_custom_cell2_name" id="sty"/><br/><br/>
    <label>自定义tips:</label><input type="text" value="<?php echo $res['custom_cell2_tips']; ?>" name="modify_custom_cell2_tips" id="sty"/><br/><br/>
    <label>自定url:</label><input type="text" value="<?php echo $res['custom_cell2_url']; ?>" name="modify_custom_cell2_url" id="sty"/><br/></br>  
    <div style="display: none;" id="shenhe">
        审核状态信息:
        <div id="status" value="" style="width:800px;"></div>
    </div><br/><br/>
    <div style="display: none;" id="updatediv">
        更新状态信息:
        <div id="update" value="" style="width:800px;"></div>
    </div><br/><br/>
    <input type="submit" value="提交" style="width:80px;"/>
    <input type="hidden" value="创建会员卡"/>
    <input type="button" value="更新会员卡" onclick="updateCard()" style="display: none;"/>
    <input type="button" value="获取审核状态" onclick="getCardInfo()"/>

</form>

<?php tpl('Admin.Common.footer'); ?>