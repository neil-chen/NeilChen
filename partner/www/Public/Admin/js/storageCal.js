var storageCal={
	init:{
			timeElement:null,
			calDiv:null,
			totalStorage:-1,
			calDivClose:function(){
				this.init.calDiv.style.display="none";
			},
			handles:[]
		},
	data:{},
	datePrice:{},
	strpad:function(str){
		str=String(str);
		if(str.length==1){
			return "0"+str;
		}else{
			return str;
		}
	},
	outputHtml:function(json,yearmonth,fromDate){
		var d={};
		for(r in json){
			d[r.date]=r.price;
		}		
		var nowtime=new Date();
		if(fromDate){
			
			fromDate=fromDate.split("-");
			fromDate=fromDate.join("/");
			if((new Date(fromDate)).getTime()>nowtime)
			 nowtime=(new Date(fromDate));
		}
		
		nowtime.setHours(0,0,0,0);
		
		nowtime=nowtime.getTime();//凌晨时间
			
		var begintime=yearmonth+"-01";
			begintime=begintime.split("-");
			begintime=begintime.join("/");
		var beginDate=new Date(begintime);
		var year=beginDate.getFullYear();
		var month=beginDate.getMonth()+1;
		var lastmonth=(month-1==0)?12:month-1;
		var nextmonth=(month+1==13)?1:month+1;
		var days=(new Date(beginDate.getFullYear(),beginDate.getMonth()+1,0)).getDate();
		var monthdays=days;
		var emptydays=beginDate.getDay();
		var endtime=yearmonth+"-"+days;
			endtime=endtime.split("-");
			endtime=endtime.join("/");
		var endDate=new Date(endtime);
		days+=beginDate.getDay()+(7-endDate.getDay());

		beginDate.setTime(beginDate.getTime()-(24*3600000*beginDate.getDay()));
		var lastmonth_none=(json.about.mintime*1000-beginDate.getTime()<0)?"":"lastmonth_none";
		var nextmonth_none=(json.about.maxtime*1000-endDate.getTime()>0)?"":"nextmonth_none";
		var html='<div class="storageCal" id="storageCalContent"><div class="monthbox">'+
					'<div class="title"><span class="lastmonth '+lastmonth_none+'"><a title="'+lastmonth+'月" class="fa fa-chevron-left"></a></span><span class="nextmonth '+nextmonth_none+'"><a title="'+nextmonth+'月" class="fa fa-chevron-right"></a></span><span class="year">'+year+'年'+month+'月<div class="ckbox ckbox-warning"><input type="checkbox"  id="checkAll"><label for="checkAll">全选</label></div></span><span class="close"></span><input type="hidden" class="yearmonth" value="'+yearmonth+'"/></div>'+
						'<table>'+
						 '<thead>'+
							'<tr>'+
								'<th class="weeken"><div class="ckbox ckbox-success"><input type="checkbox" id="weekSele0" value="0" class="weekSele"><label for="weekSele0">周日</label></div></th>'+
								'<th><div class="ckbox ckbox-success"><input type="checkbox" id="weekSele1" value="1" class="weekSele"><label for="weekSele1">周一</label></div></th>'+
								'<th><div class="ckbox ckbox-success"><input type="checkbox" id="weekSele2" value="2" class="weekSele"><label for="weekSele2">周二 </label></div></th>'+
								'<th><div class="ckbox ckbox-success"><input type="checkbox" id="weekSele3" value="3" class="weekSele"><label for="weekSele3">周三</label></div></th>'+
								'<th><div class="ckbox ckbox-success"><input type="checkbox" id="weekSele4" value="4" class="weekSele"><label for="weekSele4">周四</label></div></th>'+
								'<th><div class="ckbox ckbox-success"><input type="checkbox" id="weekSele5" value="5" class="weekSele"><label for="weekSele5">周五</label></div></th>'+
								'<th class="weeken"><div class="ckbox ckbox-success"><input type="checkbox" id="weekSele6" value="6" class="weekSele"><label for="weekSele6">周六</label></div></th>'+
							'</tr></thead><tbody>';

		var totalStorage=this.init.totalStorage;
		var totalStorageBegintime=this.init.totalStorageBegintime;
		for(var i=0,j=0;i<days-1;i++){
			if(i%7==0){
				html+='<tr>';
			}
			var date=beginDate.getFullYear()+"-"+this.strpad((beginDate.getMonth()+1))+"-"+this.strpad(beginDate.getDate());
			var price="";
			var priceT="";
			var lprice="";
			var lpriceT="";
			var valid="";
			var validT="";
			var inputHtml="";
			var storage="";
			var storageT="";
			var totalStorageT="";
			var sale="";
			var uid=0;
			var remain;
			if(json.pricelists[j]&&json.pricelists[j].date==date){
				this.datePrice[date]=json.pricelists[j].price;
				price=json.pricelists[j].sprice;
				lcode=json.pricelists[j].lcode;
				
				//priceT=json.pricelists[j].price?"¥"+json.pricelists[j].price:"";
				
				priceT=price!==""?"散客价：¥"+json.pricelists[j].sprice:"";
				
				lprice=json.pricelists[j].lprice
				lpriceT="团客价：¥"+json.pricelists[j].lprice;
				storage=json.pricelists[j].storage;
				sale=json.pricelists[j].sale;
				storageT="日库存："+sale+"/"+storage;
				uid=json.pricelists[j].uid||0;
				totalStorageT=(totalStorage===""||date<totalStorageBegintime)?"":"总库存：余"+(totalStorage-this.init.salesStorage);
				if(storage==-1){
					storageT="日库存：不限";
				}
				j++;
			}
			
			
			
			
			
			
			if(i<emptydays||i>=monthdays+emptydays){
				html+='<td><div class="detail"></div></td>';
			}else if(beginDate.getTime()<nowtime||(json.about.lcode==1&&storageT=="")){
				html+='<td><div date="'+date+'" class="detail"><span>'+beginDate.getDate()+'</span><div class="price"></div></div></td>';
			}else{
				html+='<td><div sprice="'+price+'" storage="'+storage+'" uid="'+uid+'" lprice="'+lprice+'" date="'+date+'" class="detail valid"><div class="ckbox ckbox-primary"><input type="checkbox" id="checkbox-'+beginDate.getDate()+'"><label for="checkbox-'+beginDate.getDate()+'">'+beginDate.getDate()+'</label></div><div class="price">'+priceT+'</br>'+lpriceT+'</br>'+storageT+'</div></div></td>';
			}
			if(i%7==6){
				html+='</tr>';
			}
			beginDate.setTime(beginDate.getTime()+24*3600000);
		}
		html+="</tbody></table></div>";
		return html;
	},
	show:function(yearmonth,pid,fromDate){
		var html;
		storageCal.init.calDiv.style.display="block";
		storageCal.init.calDiv.innerHTML="<div class='loading'><p class='tip'>数据加载中,请稍等....</p></div>";
		that=this;
		
		var bindHtmlEvent=function(){
			$(".weekSele").click(function(){
				var indexNum=this.value;
				if(this.checked==true){
					$("#storageCalContent tbody tr").each(function(){
						$(this).find("td").eq(indexNum).find("input").prop("checked",true);
					})
				}else{
					$("#storageCalContent tbody tr").each(function(){
						$(this).find("td").eq(indexNum).find("input").prop("checked",false);
					})
				}
			})
			$("#storageCalContent #checkAll").click(function(){
				if(this.checked==true){
					$("#storageCalContent input[type='checkbox']").each(function(){
						this.checked=true;
					})
				}else{
					$("#storageCalContent input[type='checkbox']").each(function(){
						this.checked=false;
					})
				}
			})
			$("#storageCalContent div.detail input[type='checkbox']").click(function(){
				var lprice=$(this).parent().parent().attr("lprice");
				var sprice=$(this).parent().parent().attr("sprice");
				var storage=$(this).parent().parent().attr("storage")=="-1"?"":$(this).parent().parent().attr("storage");
				$("#sprice").val(sprice);
				$("#lprice").val(lprice);
				$("#daystorage").val(storage);
			});
			
			/* $("#storageCalContent span.close").click(function(){
				storageCal.init.calDivClose();
			}) */
			var time=yearmonth+"-01";
				time=time.split("-");
				time=time.join("/");
				time=new Date(time);
			var lasttime=new Date(time.getFullYear(),time.getMonth()-1,1);
			var nexttime=new Date(time.getFullYear(),time.getMonth()+1,1);
			var lastmonth=lasttime.getFullYear()+"-"+that.strpad(lasttime.getMonth()+1);
			var nextmonth=nexttime.getFullYear()+"-"+that.strpad(nexttime.getMonth()+1);
			$("#storageCalContent .lastmonth").click(function(){
				storageCal.show(lastmonth,pid,fromDate);
			});
			$("#storageCalContent .nextmonth").click(function(){
				storageCal.show(nextmonth,pid,fromDate);
			});	
		}
		
		
		if(that.data[yearmonth]){
			html=that.outputHtml(that.data[yearmonth],yearmonth,fromDate);
			storageCal.init.calDiv.innerHTML=html;
			bindHtmlEvent();
		}else{
/*
			$.ajax({
				url:"/d/ajaxCall/storage_Calendar_Ajax.php",
				async:true,
				type:"POST",
				dataType:"json",
				data:{"orderMonth":yearmonth,
						"pid":pid
				},
				success:function(json){
					html=storageCal.outputHtml(json,yearmonth,fromDate);
					storageCal.data[yearmonth]=json;
					storageCal.init.calDiv.innerHTML=html;
					bindHtmlEvent();
				}
			})
*/
		
			alert(json.pricelists[0].date)
			
			html=storageCal.outputHtml(json,yearmonth,fromDate);
			storageCal.data[yearmonth]=json;
			storageCal.init.calDiv.innerHTML=html;
			bindHtmlEvent();
		}
		
			//return false;
		
		
	}
}; 