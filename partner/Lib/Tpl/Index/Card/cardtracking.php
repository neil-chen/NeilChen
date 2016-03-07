<?php tpl('Index.Common.header');?>
<script type="text/javascript">
var isloading = true;
$(function(){
    $('#listcode').on('click',function(){
        if(!isloading){
            return false;    
        }
        codeval = $('#codeid').val();
        $.get(
            "<?php echo url('Card', 'ajaxListCode', array(), 'index.php'); ?>",
            {
                code:codeval
            }
            ,
            function (json) {  
                
                if (json['error'] == 1) { 
                    data = json['data'];
                     _html = '<li><dd>'+data.create_time+'</dd><a href="javascript:;" class="fs">'+data.state+'</a></li>';  
                } else {
                    _html = '<span style="color:red">没有数据！</span>';
                   
                }  
                isloading = true;     
                //$('#wrapper').attr('style','display:block; position:relative; overflow:visible;height:100%');
                $('#thelist').html(_html);
            }, 'json'
        );
    })
})
</script>


<!--领取-->
<div class="vip new">
    <span class="vip1">vip</span><span><?php echo $cardinfo['card_name'] ?></span> 
</div>

<div class="bccs bbsnew">
    
    <dd><span>发放数：</span> <?php echo $data['card_issued'] ?></dd>
    <dd><span>领取数：</span> <?php echo $data['card_receiv'] ?></dd>
    <dd><span>核销数：</span> <?php echo $data['card_cancel'] ?></dd>
</div>


<div class="tableName new search">
    <input type="tel" id="codeid" placeholder="请输入卡券CODE" /> <a href="javascript:;" id="listcode">卡券轨迹查询</a>
</div>

<div class="bfnew new one1">
<div id="wrapper" style="display:block; position:relative; overflow:visible;">                                  

    <div id="scroller">
        <div id="pullDown" style="height:0px">
        </div>
      
        <ul id="thelist">
        </ul>  
    </div>
</div>
</div>
                             
<?php tpl('Index.Common.footer');?>