<?php tpl('Admin.Common.header'); ?>
<div class="mainpanel">
    <div class="contentpanel">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-btns">
                            <a href="" class="panel-minimize tooltips" data-toggle="tooltip" title="折叠"><i class="fa fa-minus"></i></a>
                            <a href="" class="panel-close tooltips" data-toggle="tooltip" title="隐藏面板"><i class="fa fa-times"></i></a>
                        </div>
                        <!-- panel-btns -->
                        <h4 class="panel-title">允许补充</h4>
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body nopadding">
                        <form class="form-horizontal" id="form-data-supply"  action="" method="post" >
                            <div class="row">
                                <div class="col-sm-12 bc">

                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo $list['id']; ?>" />    
                                        <label class="col-sm-3 control-label">合伙人编号 ：</label>
                                        <div class="col-sm-9 linheigt"><input type="text" name="card_sn" value="<?php echo $list['code']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">合伙人姓名 ：</label>
                                        <div class="col-sm-9 linheigt"><input type="text" name="name" value="<?php echo $list['name']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">待补充卡券 ：</label>
                                        <div class="col-sm-9 linheigt">  <input type="text" name="supply" value="<?php echo $list['card_name']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">可用卡券数  ：</label>
                                        <div class="col-sm-9 linheigt"> <input type="text" name="card_name" value="<?php echo $list['card_number']; ?>" disabled/></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">最大补充数 ：</label>
                                        <div class="col-sm-9 linheigt"><input type="text" id="mixnum" name="card_num" value="<?php echo $list['card_ceiling']-$list['card_number']; ?>" disabled/></div>
                                    </div>

                                    <!-- form-group -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">本次补充：</label>

                                        <div class="col-sm-6" style="line-height:30px" id="radio">
                                            <label><input type="radio" name="optionsRadios" class="optionsRadios" alt='1' atl='<?php echo $list['card_ceiling']-$list['card_number']; ?>' checked>最大值</label>
                                            <label style="margin-left:50px"><input type="radio" name="optionsRadios" alt='2' class="optionsRadios" >自定义：</label>&nbsp;<input class="form-control" id="valnum" style="display: none;" type="text" value="<?php echo $list['card_ceiling']-$list['card_number']; ?>" >
                                        </div>
                                    </div>   



                                </div>
                            </div>

                            <div class="panel-footer" style="padding-left:12.5%">
                                <a class="btn btn-primary mr20" id="putform" style="width:130px;" >提交</a>
                            </div>

                        </form>
                    </div>
                    <!-- panel-body -->
                </div>
                <!-- panel -->

            </div>
            <!-- col-md-6 -->
        </div>
        <!-- row -->
    </div>
    <!-- contentpanel -->
    <script>
        jQuery(document).ready(function() {
            jQuery('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            jQuery('.select2').select2({
                minimumResultsForSearch: -1
            });
            $('.optionsRadios').on('click',function(){
                _val = $(this).attr('alt');    
                if(_val == 1){
                    _num = $(this).attr('atl');
                    $('#valnum').val(_num);    
                    $('#valnum').hide();    
                }else{
                    $('#valnum').show();    
                }
            })         

        });   


    </script>

    <script>
    isclick = true;
        $(function() {
            var re = /^[0-9]+.?[0-9]*$/;
            $("#putform").click(function() {
                if(!isclick){
                    return false;    
                }                                      
                val = parseInt($("#valnum").val());
                id = $("[name='id']").val();
                mixnum = parseInt($('#mixnum').val());
                if(val > mixnum){
                    alert('自定义数量不能超过最大补充数');
                    return false;    
                }
                if (!val) {
                    alert('自定义可用卡券数不能为空');
                    return;
                }
                if (!re.test(val))
                {
                    alert("自定义可用卡券数必须是数字");
                    return;
                }
                
                var postData = {
                    'id': id, 
                    'openid': "<?php echo $list['openid'] ?>", 
                    'cardid': "<?php echo $list['card_id'] ?>", 
                    'tosup_num': val


                };
                isclick = false;
                $.post(
                        "<?php echo url('Card', 'updateData', array(), 'admin.php'); ?>",
                        postData,
                        function(json) {
                            alert(json['msg']);
                            if (json['error'] == 1) {
                                window.location.href = "<?php echo url('Card', 'cardSupAuditList', array(), 'admin.php'); ?>";
                                return;
                            } 
                        }, 'json');
            });
        });







    </script>


</div>
<!-- mainpanel -->
</div>
<?php tpl('Admin.Common.footer'); ?>