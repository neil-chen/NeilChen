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
                        <h4 class="panel-title">导入组员</h4>
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body nopadding">
                        <form class="form-horizontal" id="form-data-supply" action="<?php echo url('Channel', 'importChanelUsers', array('id' => $channel['id']), 'admin.php'); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">渠道组名：</label>
                                        <div class="col-sm-9 linheigt"><?php echo $channel['name']; ?></div>
                                    </div>  

                                    <!-- form-group -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">状态：</label>
                                        <div class="col-sm-6 linheigt"><?php echo ($channel['status'] == 1) ? '有效' : '无效'; ?></div>
                                    </div> 

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">创建时间：</label>
                                        <div class="col-sm-9 linheigt"><?php echo ($channel['created_at']) ? date('Y-m-d H:i:s', $channel['created_at']) : ''; ?></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">组员人数：</label>
                                        <div class="col-sm-9 linheigt"><?php echo $count; ?></div>
                                    </div>  

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">导入文件：</label>
                                        <div class="col-sm-9 linheigt">
                                            <input name="file" style="width:200px; display:inline-block" type="file" style="display:inline-block" />
                                            <!--<a class="btn btn-info">上传</a>-->
                                        </div>
                                    </div>    

                                    <div class="img" style="background-color:transparent; width:auto; color:#F00; height:auto; margin-left:70px; font-size:16px">注：文件中所有合伙人的渠道组都将更新为  <?php echo $channel['name']; ?></div>

                                </div>
                            </div>

                            <div class="panel-footer" style="padding-left:12.5%">
                                <input type="submit" class="btn btn-primary mr20" id="putform" style="width:130px;" value="导入"/>
                                <!--<button class="btn btn-primary mr20" id="putform" style="width:130px;">导入</button>-->
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


</div>
<!-- mainpanel -->
</div>
<!-- mainwrapper -->

<?php tpl('Admin.Common.footer'); ?>