<div class="panel-footer">
	<div class="row">
         
		<div class="col-xs-12">
			<div class="pagenumQu">
				<ul class="yiiPager" id="yw0">
					<li class="first">
						<a href="/order/history/index"></a>
					</li>
                    <?php if($page['currentPage'] > 1){ ?>
					<li class="previous"><a href="javascript:;" onclick="gotopage(<?php echo $page['currentPage']-1;?>)">上一页</a>
                    <?php } ?>
					</li>
					<?php for($i = $page['minPage']; $i<=$page['maxPage']; $i++){?>
					<?php if($i == $page['currentPage']){?>
					<li class="page selected"><a href=""><?php echo $i?></a>
					</li>
					<?php }else{?>
					<li class="page"><a href="javascript:;" onclick="gotopage(<?php echo $i?>)"><?php echo $i?></a>
					</li>
					<?php }}?>	
                    <?php if($page['currentPage'] < $page['maxPage']){ ?>	 
					<li class="next"><a href="javascript:;" onclick="gotopage(<?php echo $page['currentPage']+1;?>)">下一页</a>
                    <?php } ?>
					</li>
					<li class="last">
						<a href="/order/history/index/page/528"></a>
					</li>
				</ul>
				
				跳转到 <input id="" value="" type="text" onkeyup="submitjump(this,event)" class="form-control"><button onclick="jump(this)" class="btn btn-primary btn-sm" type="submit">GO</button>
				<form id="webdataform" method = "post" action="<?php echo url($a, $m, '', 'admin.php');?>" >
				    <?php if($webdata){
				              foreach($webdata as $k=>$v){
				                  ?>
				                  <input type="hidden" name="<?php echo $k;?>" id="<?php echo $k?>" value="<?php echo $v;?>" />
				                  <?php 
				              }
				          }
				    ?>
				</form>
				<script>
					function gotopage(page){
						var form = $('#webdataform');
						var action = form.attr('action') + "&p=" + page ;
						form.attr('action', action);
						form.trigger('submit');
					}
					function jump(sendar){
						var input = $(sendar).siblings('input');
//						var url = "<?php //echo url($a, $m, '', 'admin.php');?>"
// 						location.href = url + "&p=" + input.val();
						gotopage(input.val());
					}
					function submitjump(sendar,event){
						if(event.keyCode == 13){
							jump($(sendar).siblings('button')[0]);
						}
					}
				</script>
			</div>	
    
		</div>
	</div>
</div>