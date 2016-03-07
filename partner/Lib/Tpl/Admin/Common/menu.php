
             <div class="leftpanel">
				<ul class="nav nav-pills nav-stacked" id="child_nav" style="margin-top:10px">
					<li class="parent"><a><i class="fa fa-barcode"></i> <span>合伙人管理</span></a>
						<ul class="children" <?php if($a == "Partner"){ ?> style="display:block" <?php } ?>>
							<li class="<?php if($a == "Partner" && $m == "partnerList"){ echo 'dq'; } ?>"><a href="<?php echo url('Partner', 'partnerList', array(), 'admin.php'); ?>">合伙人列表</a></li>
							<li class="<?php if($a == "Partner" && $m == "checkPartnerList"){ echo 'dq'; } ?>"><a href="<?php echo url('Partner', 'checkPartnerList', array(), 'admin.php'); ?>">合伙人审核</a></li>
                            <li class="<?php if($a == "Partner" && $m == "partnerArgs"){ echo 'dq'; } ?>"><a href="<?php echo url('Partner', 'partnerArgs', array(), 'admin.php'); ?>">合伙人参数设置</a></li>
						</ul>
					</li>
                    <li class="parent"><a><i class="fa fa-file-text"></i> <span>返利管理</span></a>
						<ul class="children" <?php if($a == "Rebate"){ ?> style="display:block" <?php } ?>>
							<li class="<?php if($a == "Rebate" && $m == "index"){ echo 'dq'; } ?>"><a href="<?php echo url('Rebate','index','','admin.php');?>">返利列表</a></li>
                            <li class="<?php if($a == "Rebate" && $m == "withdrawals"){ echo 'dq'; } ?>"><a href="<?php echo url('Rebate','withdrawals','','admin.php')?>">提现申请</a></li>
						</ul>
					</li>
                    <li class="parent"><a><i class="fa fa-barcode"></i> <span>卡包管理</span></a>
						<ul class="children" <?php if($a == "Card"){ ?> style="display:block" <?php } ?> >
							<li class="<?php if($a == "Card" && $m == "cardPackageList"){ echo 'dq'; } ?>"><a href="<?php echo url('Card', 'cardPackageList','', 'admin.php'); ?>">卡包列表</a></li>
                            <li class="<?php if($a == "Card" && $m == "cardSupAuditList"){ echo 'dq'; } ?>"><a href="<?php echo url('Card', 'cardSupAuditList','', 'admin.php'); ?>">补充审核</a></li>
                            <li class="<?php if($a == "Card" && $m == "cardInfoList"){ echo 'dq'; } ?>"><a href="<?php echo url('Card', 'cardInfoList','', 'admin.php'); ?>">卡券列表</a></li>
						</ul>
					</li>
					<li class="parent"><a><i class="fa fa-cog"></i> <span>渠道管理</span></a>
						<ul class="children" <?php if($a == "Channel"){ ?> style="display:block" <?php } ?>>
							<li class="<?php if($a == "Channel" && $m == "index"){ echo 'dq'; } ?>"><a href="<?php echo url('Channel','index','','admin.php')?>">渠道列表</a></li>
						</ul>
					</li>
				
				</ul>
			</div>
	       <!-- leftpanel -->