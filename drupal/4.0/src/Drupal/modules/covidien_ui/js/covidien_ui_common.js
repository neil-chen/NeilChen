$(document).ready(function() {
  $('#global_product_line').change(function() {
    var id = $(this).val();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/globalcot/ajax",
      data: {value: id},
      success: function(ret) {
        window.location.href = ret;
      }
    });
  });
  $('select option:nth-child(2n+1)').addClass('color_options');
});

function get_covidien_customer_name(val, id) {
  var v = $.trim(val);
  if (v != "") {
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + "covidien/admin/user/customername/getname",
      data: {value: v},
      success: function(ret) {
        if (ret != '') {
          $('#' + id).val(ret);
          if ($("#next").length != 0 || ($("#edit-submit").length != 0)) {
            validate_submitbtn();
          }
        }
        return;
      }
    });
  }
}

function get_covidien_customer_name_for_device(val, id) {
	var v = $.trim(val);
	if (v != "") {
		$.ajax({
			type : "POST",
			url : Drupal.settings.basePath
					+ "covidien/admin/device/customername/getname",
			data : {
				value : v
			},
			success : function(ret) {
				if (ret != '') {
					$('#' + id).val(ret);
					if ($("#next").length != 0
							|| ($("#edit-submit").length != 0)) {
						validate_submitbtn();
					}
				}
				return;
			}
		});
	}
}

function recover_sel_device_type() {
	$("#sel_device_type").html('');	
	var jsonObj = eval('(' + $("#device_type_list").val() + ')');
	for ( var i = 0; i < jsonObj.length; i++) {
		$("#sel_device_type").append(
				"<option value='" + jsonObj[i].name + "'>" + jsonObj[i].title
						+ "</option>");
	}
}

function getDeviceTypeByProductLineInFirmware(baseUrl, productId) {

	$("#div_table_choose").find("input").each(function(index, value) {
		if ($(value).attr("type") != "checkbox") {
			return 0;
		}
		$(value).parent().parent().css("display", "none");
	});

	$.ajax({
		type : 'get',
		url : baseUrl + '/named-config/productLine',
		data : 'productionId=' + productId,
		success : function(response) {
			var resp = eval('(' + response + ')');
			var idArray = new Array();
			for ( var i = 0; i < resp.length; i++) {
				idArray.push(resp[i].id);
			}

			recover_sel_device_type();
			// hide the device type acoording to the product line
			var isValueSet = false;
			$("#sel_device_type").find("option").each(function(index, value) {
				if ($(value).val() == "All") {
					return 0;
				}
				if (!idArray.contains($(value).val())) {
					$(value).remove();
				}
			});
		}

	});
}

function filterNamedConfigByProductLine(baseUrl, productId) {
	$("#div_table_choose").find("input").each(function(index, value) {
		if ($(value).attr("type") != "checkbox") {
			return 0;
		}
		$(value).parent().parent().css("display", "none");
	});
	$.ajax({
		type : 'get',
		url : baseUrl + '/named-config/productLine',
		data : 'productionId=' + productId,
		success : function(response) {			
			var resp = eval('(' + response + ')');
			var idArray = new Array();
			for ( var i = 0; i < resp.length; i++) {
				idArray.push(resp[i].id);
			}

			$("#div_table_choose").find("input").each(function(index, value) {
				if ($(value).attr("type") != "checkbox") {
					return 0;
				}
				if (idArray.contains($(value).attr("devicetypeid"))) {
					$(value).parent().parent().removeAttr("style");					
				} else {
					$(value).parent().parent().css("display", "none");
				}
			});
		
		}

	});
}

function getDeviceTypeByProductLine(baseUrl, productId) {

	$("#div_table_choose").find("input").each(function(index, value) {
		if ($(value).attr("type") != "checkbox") {
			return 0;
		}
		$(value).parent().parent().css("display", "none");
	});

	$.ajax({
		type : 'get',
		url : baseUrl + '/named-config/productLine',
		data : 'productionId=' + productId,
		success : function(response) {
			var resp = eval('(' + response + ')');
			var idArray = new Array();
			for ( var i = 0; i < resp.length; i++) {
				idArray.push(resp[i].id);
			}

			$("#div_table_choose").find("input").each(function(index, value) {
				if ($(value).attr("type") != "checkbox") {
					return 0;
				}
				if (idArray.contains($(value).attr("devicetypeid"))) {
					$(value).parent().parent().removeAttr("style");
				} else {
					$(value).parent().parent().css("display", "none");
				}
			});

			recover_sel_device_type();
			// hide the device type acoording to the product line
			var isValueSet = false;
			$("#sel_device_type").find("option").each(function(index, value) {
				if ($(value).val() == "All") {
					return 0;
				}
				if (!idArray.contains($(value).val())) {
					$(value).remove();
				}
			});
		}

	});
}

function hide_edit_link(comp){
	$(comp).find("a").each(function(index,value){
		$(value).parent().html($(value).html());
	});
}