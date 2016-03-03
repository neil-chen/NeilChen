/**
 * 欢迎使用 KinSlideshow 幻灯片『焦点图』插件
 *
 * jQuery KinSlideshow plugin
 * ========================================〓说明〓========================================================
 * jQuery幻灯片插件，基本能满足你在网页上使用幻灯片(焦点图)效果。兼容IE6/IE7/IE8/IE9,FireFox,Chrome*,Opera。
 * 想要兼容Chrome需要在img标签中写上图片的宽度和高度<img src= width="" height="">,其他浏览器不需要。<img src=""> 建议写上宽和高。
 * 使用极其方便、简单，外观样式可以自定义,具体定义样式方法和设置其他参数请参见demo文件
 * 不需要自己定义焦点图宽度和高度，自动读取图片宽和高，所有图片尺寸要保持一致。
 * 所有宽度和高度单位都是像素，设置参数时不需要加单位(px)
 * ========================================================================================================
 * @name jquery.KinSlideshow.js
 * @version 1.1
 * @author Mr.Kin
 * @date 2010-07-25
 * @Email:Mr.Kin@Foxmail.com
 * @QQ:87190493
 *
 * 欲索取最新版本KinSlideshow或是报告Bug，请发送Email至 【Mr.Kin@Foxmail.com】
 *
 **/


(function($) {

$.fn.KinSlideshow = function(settings){

	  settings = jQuery.extend({
		   intervalTime : 5, //切换展示间隔时间 【单位：秒】
		   moveSpeedTime : 400,//切换一张图片所需时间，【单位：毫秒】
		   moveStyle:"left",//切换方向 【 left | right | up | down 】left:向左切换,right:向右切换,up:向上切换,down:向下切换
		   mouseEvent:"mouseclick", //鼠标操作按钮事件,【mouseclick | mouseover】mouseclick：鼠标单击切换。mouseover：鼠标滑过切换。
		   isHasTitleBar:true,//是否显示标题背景，
		   titleBar:{titleBar_height:40,titleBar_bgColor:"none",titleBar_alpha:0.5},//标题背景样式，(isHasTitleBar = true 前提下启用)
		   isHasTitleFont:true,//是否显示标题文字 
		   titleFont:{TitleFont_size:12,TitleFont_color:"#FFFFFF",TitleFont_family:"Verdana",TitleFont_weight:"bold"},//标题文字样式，(isHasTitleFont = true 前提下启用)
		   isHasBtn:true, //是否显示按钮
		   btn:{btn_bgColor:"#666666",btn_bgHoverColor:"#CC0000",btn_fontColor:"#CCCCCC",btn_fontHoverColor:"#000000",btn_fontFamily:"Verdana",btn_borderColor:"#999999",btn_borderHoverColor:"#FF0000",btn_borderWidth:1,btn_bgAlpha:0.7} //按钮样式设置，(isHasBtn = true 前提下启用)
	  },settings);
	  var titleBar_Bak = {titleBar_height:40,titleBar_bgColor:"#000000",titleBar_alpha:0.5}
	  var titleFont_Bak = {TitleFont_size:12,TitleFont_color:"#FFFFFF",TitleFont_family:"Verdana",TitleFont_weight:"bold"}
	  var btn_Bak = {btn_bgColor:"#666666",btn_bgHoverColor:"#CC0000",btn_fontColor:"#CCCCCC",btn_fontHoverColor:"#000000",btn_fontFamily:"Verdana",btn_borderColor:"#999999",btn_borderHoverColor:"#FF0000",btn_borderWidth:1,btn_bgAlpha:0.7} //按钮样式设置，(isHasBtn = true 前提下启用)
	  for (var key in titleBar_Bak){
		  if(settings.titleBar[key] == undefined){
			  settings.titleBar[key] = titleBar_Bak[key];
		  }
	  }	
	  for (var key in titleFont_Bak){
		  if(settings.titleFont[key] == undefined){
			  settings.titleFont[key] = titleFont_Bak[key];
		  }
	  }
	  for (var key in btn_Bak){
		  if(settings.btn[key] == undefined){
			  settings.btn[key] = btn_Bak[key];
		  }
	  }	  
	  
	 var KinSlideshow_BoxObject = this;
	 var KinSlideshow_BoxObjectSelector = $(KinSlideshow_BoxObject).selector;
	 var KinSlideshow_DateArray = new Array();
	 var KinSlideshow_imgaeLength = 0;
	 var KinSlideshow_Size =new Array();
	 var KinSlideshow_changeFlag = 0;
	 var KinSlideshow_IntervalTime = settings.intervalTime;
	 var KinSlideshow_setInterval;
	 var KinSlideshow_firstMoveFlag = true;
	 if(isNaN(KinSlideshow_IntervalTime) || KinSlideshow_IntervalTime <= 1){
			KinSlideshow_IntervalTime = 5;
	 }
	 if(settings.moveSpeedTime > 500){
		 settings.moveSpeedTime = 500;
	 }else if(settings.moveSpeedTime < 100){
		 settings.moveSpeedTime = 100;
	 }
	 
	 function KinSlideshow_initialize(){
		 $(KinSlideshow_BoxObject).css({visibility:"hidden"});
		 $(KinSlideshow_BoxObjectSelector+" a img").css({border:0});
		 KinSlideshow_start();
		 KinSlideshow_mousehover();
	 };
   
     function KinSlideshow_start(){
		 KinSlideshow_imgaeLength = $(KinSlideshow_BoxObjectSelector+" a").length;
		 KinSlideshow_Size.push($(KinSlideshow_BoxObjectSelector+" a img").width());
		 KinSlideshow_Size.push($(KinSlideshow_BoxObjectSelector+" a img").height());
		 
		$(KinSlideshow_BoxObjectSelector+" a img").each(function(i){
			KinSlideshow_DateArray.push($(this).attr(""));		
		});
		$(KinSlideshow_BoxObjectSelector+" a").wrapAll("<div id='KinSlideshow_content'></div>");
		
	    $("#KinSlideshow_content").clone().attr("id","KinSlideshow_contentClone").appendTo(KinSlideshow_BoxObject);
		KinSlideshow_setTitleBar();
		KinSlideshow_setTitleFont();
		KinSlideshow_setBtn();
		KinSlideshow_action();
		KinSlideshow_btnEvent(settings.mouseEvent);
		$(KinSlideshow_BoxObject).css({visibility:"visible"});
	 };
	 function KinSlideshow_setTitleBar(){
		$(KinSlideshow_BoxObject).css({width:KinSlideshow_Size[0],height:KinSlideshow_Size[1],overflow:"hidden",position:"relative"});
		$(KinSlideshow_BoxObject).append("<div class='KinSlideshow_titleBar'></div>");
		var getTitleBar_Height = settings.titleBar.titleBar_height;//获取面板高度
		
		if(isNaN(getTitleBar_Height)){
			getTitleBar_Height = 40;
		}else if(getTitleBar_Height < 25){
			getTitleBar_Height = 25;
		};
		
		$(KinSlideshow_BoxObjectSelector+" .KinSlideshow_titleBar").css({height:getTitleBar_Height,width:"100%",position:"absolute",bottom:0,left:0})
		 if(settings.isHasTitleBar){
		 		$(KinSlideshow_BoxObjectSelector+" .KinSlideshow_titleBar").css({background:settings.titleBar.titleBar_bgColor,opacity:settings.titleBar.titleBar_alpha})	 
		 }
	 };
	 function KinSlideshow_setTitleFont(){
		 if(settings.isHasTitleFont){
			$(KinSlideshow_BoxObjectSelector+" .KinSlideshow_titleBar").append("<h2 class='title' style='margin:3px 0 0 6px;padding:0;'></h2>");	
			$(KinSlideshow_BoxObjectSelector+" .KinSlideshow_titleBar .title").css({fontSize:settings.titleFont.TitleFont_size,color:settings.titleFont.TitleFont_color,fontFamily:settings.titleFont.TitleFont_family,fontWeight:settings.titleFont.TitleFont_weight});
			setTiltFontShow(0);
		 };
		 
	 };
	 function KinSlideshow_setBtn(){
		 if(settings.btn.btn_borderWidth > 2){settings.btn.btn_borderWidth = 2}
		 if(settings.btn.btn_borderWidth < 0 || isNaN(settings.btn.btn_borderWidth)){settings.btn.btn_borderWidth = 0}
		 if(settings.isHasBtn && KinSlideshow_imgaeLength >= 2){
			 $(KinSlideshow_BoxObject).append("<div class='KinSlideshow_btnBox' style='position:absolute;right:10px;bottom:5px; z-index:100'></div>");
			 var KinSlideshow_btnList = "";
			 for(i=1;i<=KinSlideshow_imgaeLength;i++){
					KinSlideshow_btnList+="<li>"+i+"</li>";
			 }
			 KinSlideshow_btnList = "<ul id='btnlistID' style='margin:0;padding:0; overflow:hidden'>"+KinSlideshow_btnList+"</ul>";
			 $(KinSlideshow_BoxObjectSelector+" .KinSlideshow_btnBox").append(KinSlideshow_btnList);
			 $(KinSlideshow_BoxObjectSelector+" .KinSlideshow_btnBox #btnlistID li").css({listStyle:"none",float:"left",width:18,height:18,borderWidth:settings.btn.btn_borderWidth,borderColor:settings.btn.btn_borderColor,borderStyle:"solid",background:settings.btn.btn_bgColor,textAlign:"center",cursor:"pointer",marginLeft:3,fontSize:12,fontFamily:settings.btn.btn_fontFamily,lineHeight:"18px",opacity:settings.btn.btn_bgAlpha,color:settings.btn.btn_fontColor});
			 $("#btnlistID li:eq(0)").css({background:settings.btn.btn_bgHoverColor,borderColor:settings.btn.btn_borderHoverColor,color:settings.btn.btn_fontHoverColor});
		 };
	 };
	 function KinSlideshow_action(){
		switch(settings.moveStyle){
			case "left":  KinSlideshow_moveLeft(); break;
			case "right": KinSlideshow_moveRight();break;
			case "up":    KinSlideshow_moveUp();   break;
			case "down":  KinSlideshow_moveDown(); break;
			default:      settings.moveStyle = "left"; KinSlideshow_moveLeft();
		}	 
	 };
	 function KinSlideshow_moveLeft(){
		$(KinSlideshow_BoxObjectSelector+" div:lt(2)").wrapAll("<div id='KinSlideshow_moveBox'></div>");
		$("#KinSlideshow_moveBox").css({width:KinSlideshow_Size[0],height:KinSlideshow_Size[1],overflow:"hidden",position:"relative"});
		$("#KinSlideshow_content").css({float:"left"});
		$("#KinSlideshow_contentClone").css({float:"left"});
		$(KinSlideshow_BoxObjectSelector+" #KinSlideshow_moveBox div").wrapAll("<div id='KinSlideshow_XposBox'></div>");
		$(KinSlideshow_BoxObjectSelector+" #KinSlideshow_XposBox").css({float:"left",width:"2000%"});
		
		KinSlideshow_setInterval = setInterval(function(){KinSlideshow_move(settings.moveStyle)},KinSlideshow_IntervalTime*1000+settings.moveSpeedTime);
	 };
	 function KinSlideshow_moveRight(){
		$(KinSlideshow_BoxObjectSelector+" div:lt(2)").wrapAll("<div id='KinSlideshow_moveBox'></div>");
		$("#KinSlideshow_moveBox").css({width:KinSlideshow_Size[0],height:KinSlideshow_Size[1],overflow:"hidden",position:"relative"});
		$("#KinSlideshow_content").css({float:"left"});
		$("#KinSlideshow_contentClone").css({float:"left"});
		$(KinSlideshow_BoxObjectSelector+" #KinSlideshow_moveBox div").wrapAll("<div id='KinSlideshow_XposBox'></div>");
		$(KinSlideshow_BoxObjectSelector+" #KinSlideshow_XposBox").css({float:"left",width:"2000%"});
		$("#KinSlideshow_contentClone").html("");
		$("#KinSlideshow_content a").wrap("<span></span>")
		$("#KinSlideshow_content a").each(function(i){
			$("#KinSlideshow_contentClone").prepend($("#KinSlideshow_content span:eq("+i+")").html());
		})
		
		$("#KinSlideshow_content").html($("#KinSlideshow_contentClone").html());
		var KinSlideshow_offsetLeft = (KinSlideshow_imgaeLength-1)*KinSlideshow_Size[0];
		$("#KinSlideshow_moveBox").scrollLeft(KinSlideshow_offsetLeft);
		KinSlideshow_setInterval = setInterval(function(){KinSlideshow_move(settings.moveStyle)},KinSlideshow_IntervalTime*1000+settings.moveSpeedTime);
	 };	 
	 function KinSlideshow_moveUp(){
		$(KinSlideshow_BoxObjectSelector+" div:lt(2)").wrapAll("<div id='KinSlideshow_moveBox'></div>");//用div包裹
		$("#KinSlideshow_moveBox").css({width:KinSlideshow_Size[0],height:KinSlideshow_Size[1],overflow:"hidden",position:"relative"});
		
		$("#KinSlideshow_moveBox").animate({scrollTop: 0}, 1);
		KinSlideshow_setInterval = setInterval(function(){KinSlideshow_move(settings.moveStyle)},KinSlideshow_IntervalTime*1000+settings.moveSpeedTime);
		
	 };	 
	 
	 function KinSlideshow_moveDown(){
		$(KinSlideshow_BoxObjectSelector+" div:lt(2)").wrapAll("<div id='KinSlideshow_moveBox'></div>");//用div包裹
		$("#KinSlideshow_moveBox").css({width:KinSlideshow_Size[0],height:KinSlideshow_Size[1],overflow:"hidden",position:"relative"});
		$("#KinSlideshow_contentClone").html("");
		$("#KinSlideshow_content a").wrap("<span></span>")
		$("#KinSlideshow_content a").each(function(i){
			$("#KinSlideshow_contentClone").prepend($("#KinSlideshow_content span:eq("+i+")").html());
		})
		$("#KinSlideshow_content").html($("#KinSlideshow_contentClone").html());
		
		var KinSlideshow_offsetTop = (KinSlideshow_imgaeLength-1)*KinSlideshow_Size[1];
		$("#KinSlideshow_moveBox").animate({scrollTop: KinSlideshow_offsetTop}, 1);
		KinSlideshow_setInterval = setInterval(function(){KinSlideshow_move(settings.moveStyle)},KinSlideshow_IntervalTime*1000+settings.moveSpeedTime);
	 };
	function KinSlideshow_move(style){
			
			switch(style){
				case "left":
					if(KinSlideshow_changeFlag >= KinSlideshow_imgaeLength){
						KinSlideshow_changeFlag = 0;
						$("#KinSlideshow_moveBox").scrollLeft(0);
						$("#KinSlideshow_moveBox").animate({scrollLeft:KinSlideshow_Size[0]}, settings.moveSpeedTime);
					}else{
						sp =(KinSlideshow_changeFlag+1)*KinSlideshow_Size[0];
						if ($("#KinSlideshow_moveBox").is(':animated')){ 
							$("#KinSlideshow_moveBox").stop();
							$("#KinSlideshow_moveBox").animate({scrollLeft: sp}, settings.moveSpeedTime);
						}else{
							$("#KinSlideshow_moveBox").animate({scrollLeft: sp}, settings.moveSpeedTime);
						}
					}
					setTiltFontShow(KinSlideshow_changeFlag+1);
					break;
				case "right":
					var KinSlideshow_offsetLeft = (KinSlideshow_imgaeLength-1)*KinSlideshow_Size[0];
					if(KinSlideshow_changeFlag >= KinSlideshow_imgaeLength){
						KinSlideshow_changeFlag = 0;
						$("#KinSlideshow_moveBox").scrollLeft(KinSlideshow_offsetLeft+KinSlideshow_Size[0]);
						$("#KinSlideshow_moveBox").animate({scrollLeft:KinSlideshow_offsetLeft}, settings.moveSpeedTime);
					}else{
						if(KinSlideshow_firstMoveFlag){
							KinSlideshow_changeFlag++;
							KinSlideshow_firstMoveFlag = false;
						}
						sp =KinSlideshow_offsetLeft-(KinSlideshow_changeFlag*KinSlideshow_Size[0]);
						if ($("#KinSlideshow_moveBox").is(':animated')){ 
							$("#KinSlideshow_moveBox").stop();
							$("#KinSlideshow_moveBox").animate({scrollLeft: sp}, settings.moveSpeedTime);
						}else{
							$("#KinSlideshow_moveBox").animate({scrollLeft: sp}, settings.moveSpeedTime);
						}
					}
					setTiltFontShow(KinSlideshow_changeFlag);
					break;
				case "up":
					if(KinSlideshow_changeFlag >= KinSlideshow_imgaeLength){
						KinSlideshow_changeFlag = 0;
						$("#KinSlideshow_moveBox").scrollTop(0);
						$("#KinSlideshow_moveBox").animate({scrollTop:KinSlideshow_Size[1]}, settings.moveSpeedTime);
					}else{
						sp =(KinSlideshow_changeFlag+1)*KinSlideshow_Size[1];
						if ($("#KinSlideshow_moveBox").is(':animated')){ 
							$("#KinSlideshow_moveBox").stop();
							$("#KinSlideshow_moveBox").animate({scrollTop: sp}, settings.moveSpeedTime);
						}else{
							$("#KinSlideshow_moveBox").animate({scrollTop: sp}, settings.moveSpeedTime);
						}
					}
					setTiltFontShow(KinSlideshow_changeFlag+1);
					break;
				case "down":
					var KinSlideshow_offsetLeft = (KinSlideshow_imgaeLength-1)*KinSlideshow_Size[1];
					if(KinSlideshow_changeFlag >= KinSlideshow_imgaeLength){
						KinSlideshow_changeFlag = 0;
						$("#KinSlideshow_moveBox").scrollTop(KinSlideshow_offsetLeft+KinSlideshow_Size[1]);
						$("#KinSlideshow_moveBox").animate({scrollTop:KinSlideshow_offsetLeft}, settings.moveSpeedTime);
					}else{
						if(KinSlideshow_firstMoveFlag){
							KinSlideshow_changeFlag++;
							KinSlideshow_firstMoveFlag = false;
						}
						sp =KinSlideshow_offsetLeft-(KinSlideshow_changeFlag*KinSlideshow_Size[1]);
						if ($("#KinSlideshow_moveBox").is(':animated')){ 
							$("#KinSlideshow_moveBox").stop();
							$("#KinSlideshow_moveBox").animate({scrollTop: sp}, settings.moveSpeedTime);
						}else{
							$("#KinSlideshow_moveBox").animate({scrollTop: sp}, settings.moveSpeedTime);
						}
					}
					setTiltFontShow(KinSlideshow_changeFlag);
					break;
			}
			
			KinSlideshow_changeFlag++;
	}	 
	 
	 function setTiltFontShow(index){
		 if(index == KinSlideshow_imgaeLength){index = 0};
		 if(settings.isHasTitleFont){
			$(KinSlideshow_BoxObjectSelector+" .KinSlideshow_titleBar h2").html(KinSlideshow_DateArray[index]);
		 };
		$("#btnlistID li").each(function(i){
			if(i == index){
				$(this).css({background:settings.btn.btn_bgHoverColor,borderColor:settings.btn.btn_borderHoverColor,color:settings.btn.btn_fontHoverColor});						
			}else{
				$(this).css({background:settings.btn.btn_bgColor,borderColor:settings.btn.btn_borderColor,color:settings.btn.btn_fontColor});						
			}
		 })		 
	 };
	
	function KinSlideshow_btnEvent(Event){
		switch(Event){
			case "mouseover" : KinSlideshow_btnMouseover(); break;
			case "mouseclick" : KinSlideshow_btnMouseclick(); break;			
			default : KinSlideshow_btnMouseclick();//如果传值错误默认使用mouseclick切换
		}
	};
	
	function KinSlideshow_btnMouseover(){
		$("#btnlistID li").mouseover(function(){
			var curLiIndex = $("#btnlistID li").index($(this)); 
	  		switch(settings.moveStyle){
				case  "left" :
					KinSlideshow_changeFlag = curLiIndex-1; break;
				case  "right" :
					if(KinSlideshow_firstMoveFlag){
						KinSlideshow_changeFlag = curLiIndex-1; break;
					}else{
						KinSlideshow_changeFlag = curLiIndex; break;
					}
				case  "up" :
					KinSlideshow_changeFlag = curLiIndex-1; break;
				case  "down" :
					if(KinSlideshow_firstMoveFlag){
						KinSlideshow_changeFlag = curLiIndex-1; break;
					}else{
						KinSlideshow_changeFlag = curLiIndex; break;
					}
			}
			KinSlideshow_move(settings.moveStyle);
			$("#btnlistID li").each(function(i){
				if(i ==curLiIndex){
					$(this).css({background:settings.btn.btn_bgHoverColor,borderColor:settings.btn.btn_borderHoverColor,color:settings.btn.btn_fontHoverColor});						
				}else{
					$(this).css({background:settings.btn.btn_bgColor,borderColor:settings.btn.btn_borderColor,color:settings.btn.btn_fontColor});						
				}
			})
		})
			
	};
	function KinSlideshow_btnMouseclick(){
		$("#btnlistID li").click(function(){
			var curLiIndex = $("#btnlistID li").index($(this)); 
			switch(settings.moveStyle){
				case  "left" :
					KinSlideshow_changeFlag = curLiIndex-1; break;
				case  "right" :
					if(KinSlideshow_firstMoveFlag){
						KinSlideshow_changeFlag = curLiIndex-1; break;
					}else{
						KinSlideshow_changeFlag = curLiIndex; break;
					}
				case  "up" :
					KinSlideshow_changeFlag = curLiIndex-1; break;
				case  "down" :
					if(KinSlideshow_firstMoveFlag){
						KinSlideshow_changeFlag = curLiIndex-1; break;
					}else{
						KinSlideshow_changeFlag = curLiIndex; break;
					}					
				
			}
			KinSlideshow_move(settings.moveStyle);
			$("#btnlistID li").each(function(i){
				if(i ==curLiIndex){
					$(this).css({background:settings.btn.btn_bgHoverColor,borderColor:settings.btn.btn_borderHoverColor,color:settings.btn.btn_fontHoverColor});						
				}else{
					$(this).css({background:settings.btn.btn_bgColor,borderColor:settings.btn.btn_borderColor,color:settings.btn.btn_fontColor});						
				}
			})
		})
			
	};	
	function KinSlideshow_mousehover(){
			$("#btnlistID li").mouseover(function(){
				clearInterval(KinSlideshow_setInterval); 
			})
			$("#btnlistID li").mouseout(function(){
				KinSlideshow_setInterval = setInterval(function(){KinSlideshow_move(settings.moveStyle)},KinSlideshow_IntervalTime*1000+settings.moveSpeedTime);
			})
	};
	
	return KinSlideshow_initialize();
};
 })(jQuery);