<?php tpl('Admin.Common.header');?>

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
                                    <h4 class="panel-title">添加渠道组</h4>
                                </div>
                                <!-- panel-heading -->

                                <div class="panel-body nopadding">
                                    <form class="form-horizontal" id="form-data-supply">
										<div class="row">
										  <div class="col-sm-12">
                                          
                                          <div class="form-group">
													<label class="col-sm-3 control-label">渠道组名：</label>
													<div class="col-sm-9"><input class="form-control" id='name' type="text" value="" maxlength="100" style="width:337px; display:inline-block" name="groupname"></div>
												</div>  
                                              
                                           <!-- form-group -->
                                                <div class="form-group">
												  <label class="col-sm-3 control-label">状态：</label>
												  <div class="col-sm-6" style="line-height:30px" id="radio">
                                                    	<label><input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked>有效</label>
                                                        <label style="margin-left:60px"><input type="radio" name="optionsRadios" id="optionsRadios2" value="2">无效</label>
													</div>
												</div>   

											
											</div>
										</div>
	
                                        <div class="panel-footer" style="padding-left:12.5%">
                                            <button class="btn btn-primary mr20" id="putform" style="width:130px;">添加</button>
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
		$('#putform').click(function(e){
 			e.preventDefault();
		 	var name = $('#name').val();
		 	var status = '';
		 	$("input[type='radio'][name='optionsRadios']").each(function(){
				if($(this).prop('checked')== true){
					status = $(this).val();
				}
			 });
			 
			var data = {
				name:name,
				status:status
			};
			
			var suburl = "<?php echo url('Channel','addjson',array(),'admin.php')?>";
			$.post(suburl,data,function(response){
				 var d = JSON.parse(response); 
				 if(d.error!='OK'){
					alert(d.msg);
					return;
				 }
				 location.href = "<?php echo url('Channel','index',array(),'admin.php')?>";	

			});
		});
		
	});
				</script>


			</div>
			<!-- mainpanel -->
		</div>
		<!-- mainwrapper -->

<?php tpl('Admin.Common.footer');?>