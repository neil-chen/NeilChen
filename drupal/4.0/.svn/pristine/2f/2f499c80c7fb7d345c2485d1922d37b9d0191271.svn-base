<?php
global $base_url;
?>


<html>
  <head>
    <title></title>

    <style>

      input.form-autocomplete {
        background-image: url(../../misc/throbber.gif);
        background-repeat: no-repeat;
        background-position: 100% 2px; /* LTR */
      }
      input.autothrobbing {
        background-image: url(../../misc/throbber.gif);
        background-repeat: no-repeat;
        background-position: 100% -18px; /* LTR */
      }

      div.feature_search_wraper div input[type="text"]
      {
        color : #696B73;
        font-size : 11px;
        border: 1px solid #A8A8A7;
        padding : 2px;
        -webkit-border-radius:10px;
        -moz-border-radius:10px;
        -ms-border-radius:10px;
        border-radius:10px;
        width:300px;
      }
    </style>

    <script type="text/javascript" src="<?php print $base_url?>/misc/jquery.js"></script>
    <script type="text/javascript" src="<?php print $base_url?>/sites/all/modules/covidien_ui/js/covidien_common.js"></script>
    <script type="text/javascript" src="<?php print $base_url?>/sites/all/modules/covidien_ui/js/covidien_ui_common.js"></script>


  <body>

    <?php
    global $drupal_abs_path;

    global $user;
    global $base_url ;


    $default_search_feature_name = 'Search - Enter Feature Name';

    ?>


    <table class="form-item-table-full" style="margin-bottom: 20px;">
      <tr>
        <td>

          <div class="form-item-div">
            <div class="form-item-left">
              <h4><?php echo t('Feature Catalog'); ?></h4>
            </div>
            <div class="form-item-right">
              <?php if(isset($user->devices_access['feature'])&&in_array('edit',$user->devices_access['feature'])) { ?>
                <?php global $base_url?>
              <input type="button" class="form-submit secondary_submit" onclick="addFeature();"	value="Add New Feature" id="edit-add-new" />
                <?php
              }
              ?>
            </div>
          </div>
          <div class="clear_div"></div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="form-item-div">
            <div class="form-item-left"><label for="edit-field-device-type-nid">Select Device Type:</label></div>
            <div class="form-item-left" style="padding-left : 30px;">
              <?php echo $select_device_type; ?>
            </div>
          </div>
        </td>
      </tr>

      <tr>

        <td style="padding-top  : 20px;">
          <div class="clear_div"></div>
          <div class="form-item-div">
            <div class="form-item-left">
              <div class="feature_search_wraper" >
                <div  class="form-item">
                  <input type="text" name="search_name" class="form-autocomplete"  id="txt_search_name" autocomplete="OFF"
                         title='<?php echo $default_search_feature_name?>' value='<?php echo $default_search_feature_name?>'
                         onfocus="focusClear(this,'<?php echo $default_search_feature_name?>');"	onblur="blurFill(this,'<?php echo $default_search_feature_name?>');" />
                  <div id="autocomplete" style="display: none;width: 300px"  onmouseover="this.style.display='block'" onmouseout="this.style.display='none'" >
                    <ul id="tipText"></ul>
                  </div>
                </div>
                <input type="hidden" disabled="disabled" value="<?php echo $base_url.'/feature/autocomplete'?>" id="edit-title-autocomplete" class="autocomplete autocomplete-processed">
              </div>
              <div style="padding-top : 10px;" class="views-exposed-widget views-submit-button">
                <input type="button" class="form-submit" value="Go" id="edit-submit-Hardwarelist"  onclick="searchFeatureSubmit()" />
                <input type="hidden" value="" id="edit-filter-hidden-hwverson" name="filter_hidden_hwverson">
              </div>
            </div>

          </div>

        </td>


      </tr>

    </table>

    <?php
    echo $result_table ;
    ?>



    <form id="addFeature"  method="post" >
      <input type="hidden"  name='select_device_type' id="select_device_type"  />
    </form>

  </body>

  <script>

    $(document).ready(function(){

      $("#global_product_line").unbind();
      $("#global_product_line").bind("change",searchFeatureSubmit);
      //		$("#sel_device_type").bind("change",change_device_type);
    });


    function focusClear(comp,initValue){
      if($(comp).val()==initValue){
        $(comp).val('');
      }
    }

    function blurFill(comp,initVaule){
      if($(comp).val()==''){
        $(comp).val(initVaule);
      }
    }


    function autoFinish() {
      var url =  "<?php echo $base_url.'/firmware/autocomplete'?>" ;
      var key = $("#txt_search_name").val();
      if (key.length > 2) {
        $("#txt_search_name").attr("class" , "autothrobbing" );
        $.post(url, { "keyword": key }, function (data, status) {
          if (status == "success") {
            $("#txt_search_name").attr("class" , "form-autocomplete" );
            var tipText = eval("("+data+")");
            var tipHtml = "";
            if (tipText.length <= 0) { $("#autocomplete").hide(); return; }
            else $("#autocomplete").show();
            for(var key in tipText) {
              tipHtml += "<li>" + key + "</li>";
            }
            var wid = parseInt($("#txt_search_name").width());
            //        var left = parseInt($("#search_name").offset().left);
            //       var top = parseInt($("#search_name").offset().top);
            var height = parseInt($("#txt_search_name").scrollHeight);

            $("#tipText").html(tipHtml).width(wid);
            $("#autocomplete").css("position", "absolute");

            //      $("#autocomplete").css("position", "absolute").offset({left: 200px });
            //      $("#autocomplete").css("position", "absolute").offset({ top: top + height, left: left });
            $(function () {  //5
              $("#tipText li").mouseover(function () {
                $(this).css("background", "#D1D3D4").siblings("li").css("background", "white");
              });
              $("#tipText li").click(function () {
                $("#autocomplete").hide();
                $("#txt_search_name").val($(this).text());
              });
            })
          } else {
            alert("AJAX error ");
          }
        });
      }

    }


    function searchFeatureSubmit(){
      var url = "<?php echo $base_url.'/feature_license/list'?>" ;
      var device_type_id =  $("select[name='sel_device_type']").val();

      if(device_type_id!='All'){
        url += '?device_type_id='+ device_type_id ;
      }

      var product_line = $("#global_product_line").val();

      url += '&product_line='+ product_line ;

      var search_name = $("#txt_search_name").val();
      if(search_name!=''&&search_name!='<?php echo $default_search_feature_name?>'){
        url += '&search_name='+ search_name ;
      }

      window.location= url ;
    }


    function change_device_type(){
      var url = "<?php echo $base_url.'/firmware/changedevicetype'?>" ;
      var device_type_id =  $("select[name='sel_device_type']").val();
      if(sel_device_type!='All'){
        url += '?device_type_id='+ device_type_id ;
      } else{
        return false ;
      }

      $.get(url, { "device_type_id": device_type_id }, function (data, status) {
        if (status == "success") {
          if(data.hardware_type){
            fix_select("hardware_type",data.hardware_type);
          }

          if(data.hardware_name){
            fix_select("hardware_id",data.hardware_name);
          }

          if(data.hardware_version){
            fix_select("hardware_version",data.hardware_version);
          }
        } else {
          alert("AJAX error ");
        }
      } , 'json');
    }


    function fix_select(select_id , select_array , default_value){
      $("#"+select_id).empty();
      //  select_array = eval("("+ select_array +")");
      $("#"+select_id)[0].options.add(new Option("All","",false,false));
      $.each(select_array,function(index,value){
        if(index==default_value){
          $("#"+select_id)[0].options.add(new Option(value,index,false,true));
        }else{
          $("#"+select_id)[0].options.add(new Option(value,index,false,false));
        }
      });
    }

    function addFeature(){
      var device_type_id = $("select[name='sel_device_type']").val();
      $('#addFeature').attr("action", "<?php echo $base_url.'/feature_license/add'?>" );

      $('#select_device_type').val(device_type_id);
      $('#addFeature').submit();

    }

  </script>

