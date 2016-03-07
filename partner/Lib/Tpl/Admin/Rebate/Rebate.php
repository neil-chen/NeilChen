<?php tpl('Admin.Common.header')?>

<style>
.select2-results .select2-result-label{ width:100px}
</style>
    
			<div class="mainpanel">
				<div class="contentpanel">
                
                <div class="panel panel-default">
						
						<div class="panel-body">
							<form class="form-inline" method="post" action="">
                            <!--查询-->
                            <div class="form-group"><label>关键字：</label>
                            
<input class="form-control" type="text" name="keyword" style="width:260px;" value="<?php echo @$webdata['keyword'];?>" maxlength="100" placeholder="可输入合伙人编号，姓名，电话进行查询">
</div>
								<div class="form-group">
									<label>注册时间段:</label>
									<input style="cursor: pointer;background-color: #ffffff" name="createtime" class="form-control datepicker" value="<?php echo @$webdata['createtime'];?>" placeholder="请选择日期" type="text" readonly> ~
                                                                        <input style="cursor: pointer;background-color: #ffffff" name="end_date" class="form-control datepicker" placeholder="请选择日期" type="text" value="<?php echo @$webdata['end_date'];?>" readonly>
								</div>
                               <div class="form-group">
                            <label>状态 :</label>
									<select name="status" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
									  <option value="">全部</option>
										<option value="1" <?php if(@$webdata['status'] == 1) echo "selected"?>>正常</option>
										<option value="3" <?php if(@$webdata['status'] == 3) echo "selected"?>>冻结</option>
									</select>
								</div> 
                                <div class="form-group">
                            <label>性别 :</label>
									<select name="gendar" id="status_link2" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
									  <option value="">全部</option>
										<option value="1" <?php if(@$webdata['gendar'] == 1) echo "selected"?>>男</option>
										<option value="2" <?php if(@$webdata['gendar'] == 2) echo "selected"?>>女</option>
									</select>
								</div>
                                <div class="form-group">
                            <label>等级 :</label>
									<select name="level" id="status_link33" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
									  <option value="">全部</option>
									  <?php foreach($levellist as $k=>$v){?>
										<option value="<?php echo $v['id']?>" <?php if(@$webdata['level'] == $v['id']) echo "selected"?>><?php echo $v['name'];?></option>
								      <?php }?>
									</select>
								</div>
                                
                                <div class="form-group">
                            <label>渠道组 :</label>
									<select name="channel" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
									  <option value="">全部</option>
									  <?php foreach($channellist as $k=>$v){?>
										<option value="<?php echo $v['id'];?>" <?php if(@$webdata['channel'] == $v['id']) echo "selected";?>><?php echo $v['name'];?></option>
									  <?php }?>
									</select>
								</div>
                                
                                <div class="form-group">
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
									<a class="btn btn-primary" id="wpq1">批量导出返利统计</a>&nbsp;&nbsp;
									<a class="btn btn-success" id="wpq2">批量导出返利明细</a>&nbsp;&nbsp;
									<a class="btn btn-info" id="wpq3">批量导出提现明细</a>
								</div>
                              
							</div>
						</div>
						<!-- panel-body -->
					</div>
                     <script>

                        function export2(openid)
                        {
                            var url = "<?php echo url('Rebate','exportrebatedetail','','admin.php')?>";
                            location.href = url + "&openid=" + openid;
                        }

                        function export3(openid)
                        {
                            var url = "<?php echo url('Rebate','exportgetcashdetail','','admin.php')?>";
                            location.href = url + "&openid=" + openid; 
                        }

									$('#wpq1').click(function(e){
										e.preventDefault();
										var url = "<?php echo url('Rebate','exportrebatestatistics','','admin.php');?>";
										location.href = url + "&id=" + getselect(false);
									});
									$('#wpq2').click(function(e){
										e.preventDefault();
                                        export2(getopenid());

										// var url = "<?php echo url('Rebate','exportrebatedetail','','admin.php')?>";
										// location.href = url + "&openid=" + getopenid();		
									});
									$('#wpq3').click(function(e){
										e.preventDefault();
                                        export3(getopenid());

										// var url = "<?php echo url('Rebate','exportgetcashdetail','','admin.php')?>";
										// location.href = url + "&openid=" + getopenid();	
									});
									function ajaxsubmit(url, data){
										$.post(url, data, function(response){
											var d= JSON.parse(response);
											alert(d.msg);
											if(d.error!="OK"){
												return;
											}
											location.reload();
										});
									}
									function getopenid(){
										var value = "";
										$(".wpqselect").each(function(){
											if($(this).prop("checked") == true ){
												value += "," + $(this).attr('openid');	 
											}
										});
										return value.substr(1);
									}
									function getselect(alertflag){
										var value = "";
										var flag = true;
										$(".wpqselect").each(function(){
											if($(this).prop("checked") == true ){
												value += "," + $(this).val();
												if($(this).attr('couldsub') != 1 && alertflag){
													alert('只有状态为未处理的提现，可以操作');
													flag = false;
													return false;
												}
											}
										});
										return flag ? value.substr(1): false;
									}
                    </script>
                
					<ul class="nav nav-tabs">
						
						
					</ul>

					<div class="tab-content mb30">
						<div id="t1" class="tab-pane active">
							<form action="/order/payments/method/" method="post">
                            <div>
								<script>
                                    jQuery(document).ready(function () {
                                        $('#btn-combine-pay').click(function() {
                                            return $('.need-to-pay:checked').length != 0;
                                        });
										
										//详情JS
										$(".lis .more").click(function(){
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
										//复制URL
										function copyToClipboard(txt) {
											  if (window.clipboardData) {
												window.clipboardData.clearData();
												clipboardData.setData("Text", txt);
												alert("复制成功！");
										  
											  } else if (navigator.userAgent.indexOf("Opera") != -1) {
												window.location = txt;
											  } else if (window.netscape) {
												try {
												  netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
												} catch (e) {
												  alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");
												}
												var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
												if (!clip)
												  return;
												var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
												if (!trans)
												  return;
												trans.addDataFlavor("text/unicode");
												var str = new Object();
												var len = new Object();
												var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
												var copytext = txt;
												str.data = copytext;
												trans.setTransferData("text/unicode", str, copytext.length * 2);
												var clipid = Components.interfaces.nsIClipboard;
												if (!clip)
												  return false;
												clip.setData(trans, null, clipid.kGlobalClipboard);
												alert("复制成功！");
											  }
											  else{
												  alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");
											  }
											}
										
										$(".copurl").click(function(){
											var url="http://www.k1982.com//design/101010.htm";
											copyToClipboard(url);
											})
										
                                    });
                                </script>
							</div>
                            <table class="table table-bordered mb30">
							<thead>
								<tr>
									<th width="100">
										<div class="ckbox ckbox-primary">
											<input type="checkbox" class="ids" id="checkbox-allcheck" value="949">
											<label for="checkbox-allcheck" class="allcheck">全选</label>
										</div>
									</th>
									<th>合伙人编号</th>
									<th>姓名</th>
                                    <th>累积返利</th>
									<th>可提现返利</th>
									<th>已提现返利</th>
									<th>未入账返利</th>
                                    <th width="300">快捷操作</th>
									<th width="100">　详情</th>
								</tr>
							</thead>
							<tbody id="staff-body">
							<?php foreach($result as $v){?>
                                <tr class="lis">
                                    <td>
                                        <div class="ckbox ckbox-primary">
                                            <input type="checkbox" openid = "<?php echo $v['openid'];?>"
                                             class="ids wpqselect" id="checkbox<?php echo $v['id'];?>" value="<?php echo $v['id'];?>">
                                            <label for="checkbox<?php echo $v['id'];?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $v['code'];?></td>
                                    <td><?php echo $v['name'];?></td>
                                    <td><?php echo $v['total'];?></td>
                                    <td><?php echo $v['rebate_money'];?></td>
                                    <td><?php echo $v['towithdraw_money'];?></td>
                                    <td><?php echo $v['notaccount_money'];?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="export2('<?php echo $v['openid'];?>')">返利明细</a>&nbsp;
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="export3('<?php echo $v['openid'];?>')">提现明细</a></td>
                                    <td><a class="more">+</a></td>
                   			  </tr>
                              <tr class="liscon">
             					<td colspan="9">
                                	<div class="newnnn">
                                    	<a class="btn btn-default">呼朋唤友返利（累积）： ￥<?php echo $v['summon_money']?></a>
                                    	<a class="btn btn-default">卡券核销返利（累积）： ￥<?php echo $v['orderrebate_money'];?></a><br>
                                    	<a class="btn btn-default">合伙人编号 ：  <?php echo $v['code'];?></a>
                                    	<a class="btn btn-default">姓名：  <?php echo $v['name'];?></a>
                                    	<a class="btn btn-default">性别：  <?php echo $v['sex'];?></a>
                                    	<a class="btn btn-default">联系电话：<?php echo $v['phone'];?></a>
                                    	<a class="btn btn-default">区域：  <?php echo $v['area'];?></a>
                                    	<a class="btn btn-default">地址：  <?php echo $v['address'];?></a>
                                    	<a class="btn btn-default">身份证：  <?php echo $v['identity_card'];?></a>
                                    	<a class="btn btn-default">职业：  <?php echo $v['profession'];?></a>
                                    	<a class="btn btn-default">注册时间： <?php echo $v['create_time'];?></a> 
                                    	<a class="btn btn-default">积分：<?php echo $v['integral'];?></a>
                                    	<a class="btn btn-default">等级：<?php echo $v['grade'];?></a>
                                    	<a class="btn btn-default">状态：<?php echo $v['statename'];?></a>
                                    	<a class="btn btn-default">渠道组：<?php echo $v['channel'];?></a>
                                    </div>
                                </td>
            				  </tr>
                             <?php }?>
                            </tbody>
                        </table>
					
							</form>
							<?php tpl('Admin.Common.page');?>
						</div>
						<!-- tab-pane -->
						<div id="t2" class="tab-pane">
							<form action="/order/payments/method/" method="post">
                            <table class="table table-bordered mb30">
							<thead>
								<tr>
									<th width="100">
										<div class="ckbox ckbox-primary" style="margin-left:17px;">
											<input type="checkbox" class="ids" id="checkbox-allcheck" value="949">
											<label for="checkbox-allcheck" class="allcheck">全选</label>
										</div>
									</th>
									<th>订单号</th>
									<th>供应商</th>
									<th>门票名称</th>
									<th>取票人</th>
									<th>取票人手机号</th>
									<th>游玩日期</th>
									<th>票数</th>
									<th>支付金额</th>
									<th>订单状态</th>
								</tr>
							</thead>
							<tbody id="staff-body">
                                <tr>
                                    <td>
                                        <div class="ckbox ckbox-primary" style="margin-left: 17px;">
                                            <input type="checkbox" class="ids" id="checkbox949" value="949">
                                            <label for="checkbox949"></label>
                                        </div>
                                    </td>
                                    <td><a href="/order/detail/index/id/166357369700323">166357369700323</a></td>
                                    <td>蒙牛</td>
                                    <td style="text-align: left;color:gray">古镇+大佛</td>
                                    <td>adsf</td>
                                    <td>18988876656</td>
                                    <td>2015-02-06</td>
                                    <td>1</td>
                                    <td class="text-danger">11.00</td>
                                    <td class="text-primary">
                                    <span>已结款</span></td>
                       			 </tr>                
                                 <tr>
                                    <td>
                                        <div class="ckbox ckbox-primary" style="margin-left: 17px;">
                                            <input type="checkbox" class="ids" id="checkbox949" value="949">
                                            <label for="checkbox949"></label>
                                        </div>
                                    </td>
                                    <td><a href="/order/detail/index/id/166357369700323">166357369700323</a></td>
                                    <td>蒙牛</td>
                                    <td style="text-align: left;color:gray">古镇+大佛</td>
                                    <td>adsf</td>
                                    <td>18988876656</td>
                                    <td>2015-02-06</td>
                                    <td>1</td>
                                    <td class="text-danger">11.00</td>
                                    <td class="text-hui">
                                    <span>已取消</span></td>
                       			 </tr>  
                            </tbody>
                        </table>
					
							</form>
							<div class="panel-footer">
								<div class="row">
									<div class="col-xs-6">
										<div class="ckbox ckbox-primary" style="display:inline-block;margin:0 22px;vertical-align:middle;">
                                            <input type="checkbox" class="ids" id="checkbox-allcheck1" value="949">
                                            <label for="checkbox-allcheck1" class="allcheck">全选</label>
                                        </div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
                                	<label>订单状态:</label>	
									<select name="status" id="status_link" class="select2" data-placeholder="Choose One" style="width:150px;padding:0 10px;">
										<option value="">订单状态</option>
										<option value="unpaid">未支付</option>
										<option value="cancel">已取消</option>
										<option value="paid">已付款</option>
										<option value="finish">已结束</option>
										<option value="billed">已结款</option>
									</select>

								</div>
                                
									</div>
								</div>
							</div>
						</div>
						<!-- tab-pane -->

					</div>


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

		//openid 开关
		var openidswitch = "<?php echo $openidswitch;?>";
		if(openidswitch != '0'){
			var eq = openidswitch - 1;
			$(".more:eq("+ eq +")").trigger("click");
		}
	
	});
				</script>


			</div>
			<!-- mainpanel -->
		</div>
		<!-- mainwrapper -->
 
<?php tpl('Admin.Common.footer');?>