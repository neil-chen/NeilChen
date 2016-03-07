<?php tpl('Admin.Common.header');?>
<style>
.select2-results .select2-result-label{ width:100px}
</style>
            <div class="mainpanel">
                <div class="contentpanel">
                
                <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <form class="form-inline" method="post" action="<?php echo url('Card', 'cardPackageList','', 'admin.php'); ?>">
                            <!--查询-->
                            <div class="form-group"><label>关键字：</label>
<input class="form-control" type="text" name="cname" style="width:260px;" value="<?php echo $param['name'] ?>"  maxlength="100" placeholder="可输入合伙人编号、姓名、电话进行查询">
</div>               
<div class="form-group">
                        <label>注册时间段:</label>

                        <input style="cursor: pointer;cursor: hand;background-color: #ffffff" name="from" class="form-control datepicker" value="<?php echo $param['cfrom']; ?>" placeholder="请选择日期" type="text" readonly>-<input style="cursor: pointer;cursor: hand;background-color: #ffffff" name="to" class="form-control datepicker" value="<?php echo $param['cto']; ?>" placeholder="请选择日期" type="text" readonly> 
                    </div>

<div class="form-group">
                        <label>状态 :</label>
                        <select name="state" id="state" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="">全部</option>
                            <option value="1" <?php if ($param['state'] == '1') { ?> selected="selected" <?php } ?>>正常</option>
                            <option value="3" <?php if ($param['state'] == '3') { ?> selected="selected" <?php } ?>>冻结</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>性别 :</label>
                        <select name="sex" id="sex" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="">全部</option>
                            <option value="1" <?php if ($param['sex'] == '1') { ?> selected="selected" <?php } ?>>男</option>
                            <option value="2" <?php if ($param['sex'] == '2') { ?> selected="selected" <?php } ?>>女</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>等级 :</label>
                        <select name="grade" id="grade" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="">全部</option>
                            <?php foreach ($level as $item) { ?>
                                <option value="<?php echo $item['id']; ?>" <?php if ($param['grade'] == $item['id']) { ?>selected="selected" <?php } ?>><?php echo $item['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>渠道组 :</label>
                        <select name="channel" id="channel" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
                            <option value="">全部</option>
                            <?php foreach ($channel as $key=> $value) { ?>
                                <option value="<?php echo $value['id']; ?>" <?php if ($param['channel'] == $value['id']) { ?>selected="selected" <?php } ?>>
                                    <?php echo $value['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>        
                          
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm" type="submit">查询</button>
                                </div>

                            </form>
                        </div>
                        <!-- panel-body -->
                    </div>
                
                <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-inline">
                                <div class="form-group">
                                    <a class="btn btn-primary" href="<?php echo url('Card','exportsupplement','','admin.php')?>">导出补充记录</a>&nbsp;&nbsp;
                                    <a class="btn btn-success" href="<?php echo url('Card','exportissue','','admin.php')?>">导出发放记录</a>&nbsp;&nbsp;
                                    <a class="btn btn-info" href="<?php echo url('Card','exportdrawfl',array('s'=>'1'),'admin.php')?>">导出领取记录</a>&nbsp;&nbsp;
                                    <a class="btn btn-warning" href="<?php echo url('Card','exportdrawfl',array('s'=>'2'),'admin.php')?>">导出核销记录</a>&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input class="form-control" type="text" name="order_id" style="width:300px; line-height:40px; height:40px" placeholder="填写发放记录ID，导出发放明细">&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="exportissue(this)">导出发放明细</a>
                                </div>
                              
                            </div>
                        </div>
                        <!-- panel-body -->
                    </div>
                   <script>
						function exportissue(sendar){
							var value = $(sendar).siblings('input').val();
							var jumpurl = "<?php echo url('Card','exportissue','','admin.php')?>";
							location.href = jumpurl + "&id=" + value;
						}
                   </script>
                
                    <ul class="nav nav-tabs">
                        
                        
                    </ul>

                    <div class="tab-content mb30">
                        <div id="t1" class="tab-pane active">
                            <div>
                               
                            </div>
                            <table class="table table-bordered mb30">
                            <thead>
                                <tr>
                                   
                                    <th>合伙人编号</th>
                                    <th>姓名</th>
                                    <th>卡券种类数</th>
                                    <th>卡券库存</th>
                                    <th>总补充次数</th>
                                    <th>发放次数</th>
                                    <th>已发放数</th>
                                    <th>已领取数</th>
                                    <th>已核销数</th>
                                    <th width="100">　详情</th>
                                </tr>
                            </thead>
                            <tbody id="staff-body">
                            
                            <?php
                                 foreach($list as $v){
                             ?>
                              <tr class="lis">
                                  
                                    <td><?php echo $v['code'] ?></td>
                                    <td><?php echo $v['name'] ?></td>
                                    <td><?php echo $v['par_species'] ?></td>
                                    <td><?php echo $v['par_number'] ?></td>
                                    <td><?php echo $v['par_supplement'] ?></td>
                                    <td><?php echo $v['par_issue'] ?></td>
                                    <td><?php echo $v['par_issued'] ?></td>
                                    <td><?php echo $v['par_receiv'] ?></td>
                                    <td><?php echo $v['par_cancel'] ?></td>
                                    <td><a class="more" alt='1' vid='<?php echo $v['id'] ?>' openid='<?php echo $v['openid'] ?>'>+</a></td>
                                 </tr>              
                              <tr class="liscon" id="lis<?php echo $v['id'] ?>">
                            
                              </tr> 
                              
                             <?php
                                 }
                              ?> 
                                
                            </tbody>
                        </table>
                    
                            <div class="panel-footer">
                                <div class="row">

                        <div class="col-xs-12">
                            <div class="pagenumQu">
                                <?php tpl('Admin.Common.page');?>
                            </div>    

                        </div>
                    </div>
                            </div>
                        </div>        

                    </div>


                </div>
                 <script>
                                    jQuery(document).ready(function () {
                                        $('#btn-combine-pay').click(function() {
                                            return $('.need-to-pay:checked').length != 0;
                                        });
                                        
                                        //详情JS
                                        $(".lis .more").click(function(){
                                            _val = $(this).attr('alt');
                                            
                                            if(_val == 1){
                                                
                                                $(this).attr('alt','0');
                                                _openid = $(this).attr('openid');
                                            
                                                _vid = $(this).attr('vid');
                                                $('#lis'+_vid).html('数据加载中...');
                                                var postData = {
                                                    'openid': _openid
                                                };
                                                $.get(
                                                    "<?php echo url('Card', 'ajaxListCardStatistical', array(), 'admin.php'); ?>",
                                                    postData
                                                    ,
                                                    function (json) {  
                                                        if (json['error'] == 0) { 
                                                            _html = '';
                                                            _html += '<td colspan="11">';
                                                            _html += '<div class="newnnn">';
                                                            _html += '<table border="1" width="100%" class="table table-bordered mb30">';
                                                            _html += '<tr>';
                                                            _html += '<td><strong>卡券名</strong></td>';
                                                            _html += '<td><strong>持有上限</strong></td>';
                                                            _html += '<td><strong>目前库存</strong></td>';
                                                            _html += '<td><strong>补充次数</strong></td>';
                                                            _html += '<td><strong>补充总数</strong></td>';
                                                            _html += '<td><strong>已发放数</strong></td>';
                                                            _html += '<td><strong>已领取数</strong></td>';
                                                            _html += '<td><strong>已核销数</strong></td>';
                                                            _html += '<td width="220"><strong>导出</strong></td>';
                                                            _html += '</tr>';

															var arg = '';
															var supurl = "<?php echo url('Card','exportsupplement','','admin.php')?>";
															var issurl = "<?php echo url('Card','exportissue','','admin.php')?>";
															var draurl = "<?php echo url('Card','exportdrawfl','','admin.php')?>";
                                                            
                                                             $.each(json['data'],function(n,value) { 
                                                                arg = '&cid='+ value["cardid"] + '&oid='+value["openid"];
                                                                _html += '<tr>';
                                                                _html += '<td>'+value['cardname']+'</td>';
                                                                _html += '<td>'+value['card_ceiling']+'</td>';
                                                                _html += '<td>'+value['card_number']+'</td>';
                                                                _html += '<td>'+value['card_supplement']+'</td>';
                                                                _html += '<td>'+value['card_issue']+'</td>';
                                                                _html += '<td>'+value['card_issued']+'</td>';
                                                                _html += '<td>'+value['card_receiv']+'</td>';
                                                                _html += '<td>'+value['card_cancel']+'</td>';
                                                                _html += '<td width="220" class="but">';
                                                                _html += '<a href="' + supurl + arg + '" class="btn btn-link">补充记录</a>&nbsp;&nbsp';
                                                                _html += '<a href="' + issurl + arg + '" class="btn btn-link">发放记录</a><br>'
                                                                _html += '<a href="' + draurl + arg + '&s=1" class="btn btn-link">领取记录</a>&nbsp;&nbsp';
                                                                _html += '<a href="' + draurl + arg + '&s=2" class="btn btn-link">核销记录</a></td>';
                                                                _html += '</tr>';    
                                                            });
                                                            
                                                                 
                                                            _html += '</table>';
                                                            _html += '</div>';
                                                            _html += '</td>';
                                                                
                                                            
                                                        } else {
                                                            _html = '<span style="color:red">没有数据！</span>';
                                                        }            
                                                        $('#lis'+_vid).html(_html);
                                                        
                                                    }, 'json'
                                                );    
                                            }
                                            if($(this).html()=="+"){
                                                $(".lis .more").removeClass("zk").html("+")
                                                $(this).addClass("zk").html("-");
                                                $("#staff-body .liscon").hide();
                                                $(this).parents(".lis").next(".liscon").show();
                                                }
                                                else{
                                                    $(this).removeClass("zk").html("+");
                                                    $("#staff-body .liscon").hide();
                                                }
                                            })
                                        
                                        
                                    });
                                </script>
                <!-- contentpanel -->
                <script>
                jQuery(document).ready(function() {

                    jQuery('.datepicker').datepicker({
                        dateFormat: 'yy-mm-dd'
                    });
                    
                    jQuery('.select2').select2({
                        minimumResultsForSearch: -1
                    });
                    //openid 开关
                    
                    /*
                    var openidswitch = "<?php echo $openidswitch;?>";
                    if(openidswitch != '0'){
                        var eq = openidswitch - 1;
                        $(".more:eq("+ eq +")").trigger("click");
                    }*/
                });
                </script>
                <?php if (isset($_GET['openid'])) { ?>
                    <script>
                        jQuery(document).ready(function() {
                            $('a[openid="<?php echo $_GET['openid']; ?>"]').trigger("click");
                        });
                    </script>
                <?php } ?>


            </div>
            <!-- mainpanel -->
        </div>
        <!-- mainwrapper -->
<?php tpl('Admin.Common.footer'); ?>