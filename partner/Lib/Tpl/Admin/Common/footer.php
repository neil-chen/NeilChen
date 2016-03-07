</section>
	<footer>
		<div class="footerwrapper">Copyright©2008-2011 随视传媒 All Right Reserved. 京ICP备07014109号-5</div>
	</footer>
	

<div class="modal fade" id="msg">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
				<div id="advice_title" class="modal-title"></div>
				<div id="advice_name" style="float:left;color:#999;font-size:12px;"></div>
				<div id="advice_time" style="float:left;margin-left:20px;color:#999;font-size:12px;"></div>
			</div>
			<div id="advice_content" class="modal-body" style="word-break:break-all;"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="close_advice">关闭</button>
			</div>
		</div>
	</div>
</div>
		
		
		
		
		
		
<script src="./Public/Admin/js/jquery-ui-1.10.3.min.js?4.1"></script>
<script src="./Public/Admin/js/bootstrap.min.js?4.1"></script>
<script src="./Public/Admin/js/select2.min.js?4.1"></script>
<script src="./Public/Admin/js/custom.js?4.1"></script>
<script src="./Public/Admin/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
  $(function() {
    $("#distributor-select-search").select2(); //景区查询下拉框     

    $('.allcheck').click(function() {
        if ($(this).text() == '全选') {
            $('#staff-body').find('input').prop('checked', true)
            $(this).text('反选')
        } else {
            $('#staff-body').find('input').prop('checked', false)
            $(this).text('全选')
        };

    });
});


</script>
    </body>
</html>