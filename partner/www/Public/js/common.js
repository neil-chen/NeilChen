/**
 * Alltosun - common.js 公用JS函数库
 * Copyright (c) 2009-2011 Alltosun.INC - http://www.alltosun.com
 * Date: 2011/01/06
 * @author gaojj@alltosun.com
 * @requires jQuery v1.4.4+
 * @requires jQuery-ui v1.8.7+
 * $Id: common.js 26148 2013-06-03 01:38:27Z weisd $
 */

/**
 * 防止被其他页面作为iframe包含
 */
if (window != top) top.location.href = location.href;

/**
 * 加入到收藏夹，支持IE、Firefox、Opera
 * @param clickObj 当前点击的对象
 * @return
 */
function addToBookmark(clickObj)
{
  var bookmarkUrl = window.location.href;
  var bookmarkTitle = document.title;

  if (window.sidebar) {
  // Firefox书签
  window.sidebar.addPanel(bookmarkTitle, bookmarkUrl,"");
  } else if( window.external || document.all) {
  // IE收藏夹
  window.external.AddFavorite(bookmarkUrl, bookmarkTitle);
  } else if(window.opera) {
  // Opera
  if (!clickObj instanceof jQuery) {
    clickObj = $(clickObj);
  }
  clickObj.attr("href", bookmarkUrl);
  clickObj.attr("title", bookmarkTitle);
  clickObj.attr("rel", "sidebar");
  clickObj.click();
  } else {
  alert('您的浏览器不支持该功能，请手动将本页面加入收藏夹。');
  }
}

/**
 * 复制到剪贴板
 */
function copyToClipboard(txt)
{
  if(window.clipboardData) {
  window.clipboardData.clearData();
  window.clipboardData.setData("Text", txt);
  } else if(navigator.userAgent.indexOf("Opera") != -1) {
  window.location = txt;
  } else if (window.netscape) {
  try {
    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
  } catch (e) {
    alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
  }
  var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
  if (!clip) {
    return;
  }
  var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
  if (!trans) {
    return;
  }
  trans.addDataFlavor('text/unicode');
  var str = new Object();
  var len = new Object();
  var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
  var copytext = txt;
  str.data = copytext;
  trans.setTransferData("text/unicode",str,copytext.length*2);
  var clipid = Components.interfaces.nsIClipboard;
  if (!clip) {
    return false;
  }
  clip.setData(trans,null,clipid.kGlobalClipboard);
  alert("复制成功！");
  }
}

/**
 * 图片垂直居中
 * @param obj 图片的jQuery对象
 * @param maxHeight 最大高度
 * @param maxWidth 最大宽度
 * @param border 补的边框，可以传none，则不设置border
 * @param backgroundColor 补的背景色
 * @param loadingImg 是否开启loading动画，默认开启
 * @return
 */
function vhCenter(obj, maxHeight, maxWidth, border, backgroundColor, loadingImg){
  if (obj == undefined || maxHeight == undefined || maxWidth == undefined) {
  return;
  }
  var backgroundColor = backgroundColor || "#FFFFFF";
  var border = border || "1px solid #CCCCCC";
  // @FIXME 永远为true
  var loadingImg = loadingImg || true;
  // 图片定位
  var imgPad = function(imgObj){
  var cssAttr = {"background":backgroundColor};
  var paddingV = paddingH = 0;
  var imgHeight = imgObj.height();
  var imgWidth  = imgObj.width();
  // fix img in display:none
  if (imgHeight == 0) {
    $("body").append('<div id="tmpImg" style="position:absolute;width:0px;visibility:hidden;overflow:hidden;"><img src="'+imgObj.attr('src')+'" /></div>');
    imgHeight = $("#tmpImg > img").height();
    imgWidth = $("#tmpImg > img").width();
    $("#tmpImg").remove();
  }
  if (imgHeight < maxHeight) {
    paddingV = (maxHeight - imgHeight)/2;
    $.extend(cssAttr, {"padding-top":paddingV, "padding-bottom":paddingV});
  }
  if (imgWidth < maxWidth) {
    paddingH = (maxWidth - imgWidth)/2;
    $.extend(cssAttr, {"padding-left":paddingH, "padding-right":paddingH});
  }
  if (border != 'none') {
    $.extend(cssAttr, {"border":border});
  }
  imgObj.css(cssAttr);
  };
  $.each(obj, function(k, v){
  var img = $(v);
  if (loadingImg) {
    img.hide();
    var divWidth = maxWidth+2, divHeight = maxHeight+2;
    if (border == 'none') {
    divWidth = maxWidth;
    divHeight = maxHeight;
    }
    img.before('<div class="loadingImg" style="width:'+divWidth+'px; height:'+divHeight+'px;"></div>');
  }
  // 当document.ready完了后img不一定ready，尤其是在强制刷新时易出现取得的img宽高与实际不同
  img.load(function(){
    imgPad(img);
    if (loadingImg) {
    img.prev("div.loadingImg").hide();
    img.show();
    }
  });
  $(window).load(function(){
    imgPad(img);
    if (loadingImg) {
    img.prev("div.loadingImg").hide();
    img.show();
    }
  });
  });
}

/**
 * 给图片加上上一页/下一页的鼠标指针
 * @param img 图片的jQuery对象，也支持div等的jQuery对象
 * @param callback 点击鼠标时触发的回调函数
 * @return
 * @notice 考虑到多种主题的指针样式不同，改为添加class：cursorPrev和cursorNext
 */
function imgCursor(img, callback){
  var imgWidth = img[0].offsetWidth, imgLeft = img.offset().left;
  img.mousemove(function(e){
  if (e.pageX >= imgLeft && e.pageX <= imgWidth/2+imgLeft) {
    // prev
    $(this).removeClass('cursorNext').addClass('cursorPrev');
    $(this).attr('alt', '点击查看上一张').attr('title', '点击查看上一张');
    if (callback != undefined) {
    $(this).unbind('click');
    $(this).click(function(){
      callback('prev');
      return false;
    });
    }
  }
  if (e.pageX >= imgWidth/2+imgLeft && e.pageX <= imgWidth+imgLeft) {
    // next
    $(this).removeClass('cursorPrev').addClass('cursorNext');
    $(this).attr('alt', '点击查看下一张').attr('title', '点击查看下一张');
    if (callback != undefined) {
    $(this).unbind('click');
    $(this).click(function(){
      callback('next');
      return false;
    });
    }
  }
  });
}

/**
 * html实体化
 * @param str
 * @return
 */
function htmlSpecialChars(str){
  str = str.replace(/</g, '&lt;');
  str = str.replace(/>/g, '&gt;');
  str = str.replace(/"/g, '&quot;');
  str = str.replace(/&(?!\w+;)/g, '&amp;');
  return str;
}

function css(el, prop) {
  return parseInt($.css(el[0], prop)) || 0;
}

function width(el) {
  return  el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
}

function height(el) {
  return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
}

/**
 * 验证字符串
 */
function checkStr(str, type)
{
  if (type == 'name') {
   // 用户名只能包括中文，英文，下划线(_)，连接线(-)
  if (str.match(/([\u4E00-\u9FBF]|[\u0041-\u005A]|[\u0061-\u007A]|\u005F|\u002D|\d)/g)) {
    return true;
  }
  return false;
  } else if (type == 'mail') {
  // Email验证
  if (str.match(/^([a-zA-Z0-9]+[\_|\.]?)*[a-zA-Z0-9]*@([a-zA-Z0-9]+\.)([a-zA-Z])+(|\.[a-zA-Z]+)$/g )) {
    return true;
  }
  return false;
  }
}

/**
 * 截取字符串 //2个英文占一个中文位
 */
function cut_str(str, len){
  var tmp     = str.substr(0,len*2);
  var chinese = 0;
  var other   = 0;
  for(var i=0,slen=tmp.length; i<slen; i++){
    var char = tmp[i];
    if(isChinese(char)){
      chinese ++;
    } else {
      other ++;
    }
  }
  
  var cutLen = len*2 - Math.round(chinese/2);
  
  return str.substr(0, cutLen);
}

/**
 * 是否全是中文
 */
function isChinese(str)
{
  return new RegExp("^[\\u4e00-\\u9fa5]+$", "").test(str);
}

/**
 * 是否是汉字加数字
 */
function isChineseNum(str)
{
  return new RegExp("^[\\u4e00-\\u9fa5]+[0-9]*$", "").test(str);
}

/**
 * 精度加法
 */
function accuratePlus(arg1, arg2)
{
  var r1,r2,m;
  try{r1=arg1.toString().split(".")[1].length;}catch(e){r1=0;}
  try{r2=arg2.toString().split(".")[1].length;}catch(e){r2=0;}
  m=Math.pow(10,Math.max(r1,r2));
  return (arg1*m+arg2*m)/m;
}

/**
 * 精度减法
 */
function accurateMinus(arg1, arg2)
{
  var r1,r2,m,n;
  try{r1=arg1.toString().split(".")[1].length;}catch(e){r1=0;}
  try{r2=arg2.toString().split(".")[1].length;}catch(e){r2=0;}
  m=Math.pow(10,Math.max(r1,r2));
  //动态控制精度长度
  n=(r1>=r2)?r1:r2;
  return ((arg1*m-arg2*m)/m).toFixed(n);
}

/**
 * 精度乘法
 */
function accurateMultiply(arg1, arg2)
{
  var m=0,s1=arg1.toString(),s2=arg2.toString();
  try{m+=s1.split(".")[1].length;}catch(e){}
  try{m+=s2.split(".")[1].length;}catch(e){}
  return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m);
}

/**
 * 精度除法
 */
function accurateDivide(arg1, arg2)
{
  var t1=0,t2=0,r1,r2,n;
  try{t1=arg1.toString().split(".")[1].length;}catch(e){}
  try{t2=arg2.toString().split(".")[1].length;}catch(e){}
  with(Math){
    r1=Number(arg1.toString().replace(".",""));
    r2=Number(arg2.toString().replace(".",""));
  // 动态控制精度长度
  n=(t1>=t2)?t1:t2;
  var result = (r1/r2)*pow(10,t2-t1);
    return result.toFixed(n);
  }
}

/**
* 获取图片的缩略图
*/
function pathInfo(path, prefix)
{
  if (!path) {
    return '';
  }
  var file_path = '';
  var path_arr = path.split('/');
  var path_arr_length = path_arr.length;
  //@FIXME 改为读取对应资源的缩略图配置，但是需要函数传入资源类型，待考虑
  if (prefix) {
    path_arr[path_arr_length-1] = prefix+'_'+path_arr[path_arr_length-1];
  }

  path = path_arr.join('/');
  //如果传入的路径没有标明上传文件夹的话，则补全路径
  path = uploadUrl+path;
  return path;
}

/**
 * 验证身份证号是否合法
 */
function checkIdentityCard(v_card)
{
  var reg = /^\d{15}(\d{2}[0-9X])?$/i;
  if (!reg.test(v_card)) {
  return false;
  }
  if (v_card.length==15) {
  var n = new Date();
    var y = n.getFullYear();
    if(parseInt("19" + v_card.substr(6,2)) < 1900 || parseInt("19" + v_card.substr(6,2)) > y){
    return false;
  }
  var birth = "19" + v_card.substr(6,2) + "-" + v_card.substr(8,2) + "-" + v_card.substr(10,2);
  if(!isDate(birth)){
    return false;
  }
  }
  if (v_card.length==18) {
  var n = new Date();
  var y = n.getFullYear();
  if(parseInt(v_card.substr(6,4)) < 1900 || parseInt(v_card.substr(6,4)) > y){
    return false;
  }
  var birth = v_card.substr(6,4) + "-" + v_card.substr(10,2) + "-" + v_card.substr(12,2);
  if(!isDate(birth)){
    return false;
  }
  iW = new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2,1);
  iSum = 0;
  for ( i=0;i<17;i++){
    iC = v_card.charAt(i);
    iVal = parseInt(iC);
    iSum += iVal * iW[i];
  }
  iJYM = iSum % 11;
  if(iJYM == 0) sJYM = "1";
  else if(iJYM == 1) sJYM = "0";
    else if(iJYM == 2) sJYM = "x";
    else if(iJYM == 3) sJYM = "9";
    else if(iJYM == 4) sJYM = "8";
    else if(iJYM == 5) sJYM = "7";
    else if(iJYM == 6) sJYM = "6";
    else if(iJYM == 7) sJYM = "5";
    else if(iJYM == 8) sJYM = "4";
    else if(iJYM == 9) sJYM = "3";
    else if(iJYM == 10) sJYM = "2";
  var cCheck = v_card.charAt(17).toLowerCase();
  if( cCheck != sJYM ){
    return false;
  }
  }
  try {
  var lvAreaId=v_card.substr(0,2);
  if( lvAreaId=="11" || lvAreaId=="12" || lvAreaId=="13" || lvAreaId=="14" || lvAreaId=="15" ||
    lvAreaId=="21" || lvAreaId=="22" || lvAreaId=="23" ||
    lvAreaId=="31" || lvAreaId=="32" || lvAreaId=="33" || lvAreaId=="34" || lvAreaId=="35" || lvAreaId=="36" || lvAreaId=="37" ||
    lvAreaId=="41" || lvAreaId=="42" || lvAreaId=="43" || lvAreaId=="44" || lvAreaId=="45" || lvAreaId=="46" ||
    lvAreaId=="50" || lvAreaId=="51" || lvAreaId=="52" || lvAreaId=="53" || lvAreaId=="54" ||
    lvAreaId=="61" || lvAreaId=="62" || lvAreaId=="63" || lvAreaId=="64" || lvAreaId=="65" ||
    lvAreaId=="71" || lvAreaId=="82" || lvAreaId=="82" ) {
  return true;
  } else {
  return false;
  }
  } catch(ex) {
  }
  return true;
}

/**
 * 验证日期是否正确
 * @param strDate 格式1985-07-13
 * @returns {Boolean}
 */
function isDate(strDate)
{
  var strSeparator = "-"; //日期分隔符
  var strDateArray;
  var intYear;
  var intMonth;
  var intDay;
  var boolLeapYear;
  strDateArray = strDate.split(strSeparator);
  if(strDateArray.length!=3) return false;
  intYear = parseInt(strDateArray[0],10);
  intMonth = parseInt(strDateArray[1],10);
  intDay = parseInt(strDateArray[2],10);
  if(isNaN(intYear)||isNaN(intMonth)||isNaN(intDay)) return false;
  if (intMonth>12||intMonth<1) return false;
  if ((intMonth==1||intMonth==3||intMonth==5||intMonth==7||intMonth==8||intMonth==10||intMonth==12)&&(intDay>31||intDay<1)) return false;
  if ((intMonth==4||intMonth==6||intMonth==9||intMonth==11)&&(intDay>30||intDay<1)) return false;
  if(intMonth==2){
  if(intDay<1) return false;
  boolLeapYear = false;
  if ((intYear%100)==0) {
    if((intYear%400)==0) boolLeapYear = true;
  } else {
    if((intYear%4)==0) boolLeapYear = true;
  }
  if (boolLeapYear) {
    if(intDay>29) return false;
  } else {
    if(intDay>28) return false;
  }
  }
  return true;
}

/**
 * 验证是否是正整数
 * @param str strInt
 * @return bool
 */
function isPosInt(strInt)
{
  return (strInt.match(/^[1-9]{1}[0-9]*$/)!=null);
}

/**
 * 是否在ipad上
 * @return bool
 */
function isOnIpad(){ 
    var ua = navigator.userAgent.toLowerCase(); 
    if(ua.match(/iPad/i)=="ipad") { 
       return true; 
    } else { 
       return false; 
    } 
}

/**
 * 判断网页是否在移动端上
 * @return bool true在手机上，false在PC上
 */
function isOnMobile()
 {
   // platform
   var p = navigator.platform;
   if (p && p.match(/(Win|Mac)/i)) {
     return false;
   }
   
   var userAgent = window.navigator.userAgent;
   if (userAgent.match(/(iPhone|iPod|Android|ios|iPad|mobile)/i)) {
     return true;
   }
   return  !!userAgent.match(/AppleWebKit.*Mobile.*/i)|| !!userAgent.match(/AppleWebKit/i);
 }

/**
 * 追加js
 * @param url
 * @param callback
 * @param charset
 */
function loadJS(url,callback,charset)
{
  var script = document.createElement('script');
  script.onload = script.onreadystatechange = function ()
  {
    if (script && script.readyState && /^(?!(?:loaded|complete)$)/.test(script.readyState)) {
      return;
    }
    script.onload = script.onreadystatechange = null;
    script.src = '';
    script.parentNode.removeChild(script);
    script = null;
    if(callback){ callback(); }
  };
  script.charset=charset || document.charset || document.characterSet;
  script.src = url;
  try {document.getElementsByTagName("head")[0].appendChild(script);} catch (e) {}
}

/**
 * 表单元素没有输入时的默认值
 * @param obj 表单对像如:input
 * @param str 默认文字
 */
function inputPlaceHold(obj, fillStr)
{
  //obj.val(str).css('color', '#888');
  obj.each(function(i){
    $(this).unbind('focus');
    $(this).unbind('blur');
    
    $(this).bind('focus', function(){
      var content = $.trim($(this).val());
      if (fillStr == content) {
        $(this).val('');
      }
    });
    
    // 微博框失去焦点
    $(this).bind('blur', function(){
      var content = $.trim($(this).val());
      if (!content) {
        $(this).val(fillStr);
      }
    });
  });
}

/**
 * 取得某元素离浏览器左侧距离
 * @param element
 * @return int
 */
function getElementLeft(element){
  var actualLeft = element.offsetLeft;
  var current = element.offsetParent;
  
  while (current !== null){
    actualLeft += current.offsetLeft;
    current = current.offsetParent;
  }
  
  return actualLeft;
}

/**
 * 取元素离浏览器的XY
 * @param obj
 * @returns obj {x:, y:}
 */
function getXY(ele) {
  var x = 0, y = 0;
  while (ele.offsetParent) {
    x += ele.offsetLeft;
    y += ele.offsetTop;
    ele = ele.offsetParent;
  }
  return {
    x : x,
    y : y
  };
}

/**
 * 取可视窗口的高度
 */
function getViewportHeight() {
  if (typeof window.innerHeight != "undefined") {
    var _ae = window.innerHeight;
  } else {
    if (typeof document.documentElement !== "undefined"
        && typeof document.documentElement.clientHeight !== "undefined"
        && document.documentElement.clientHeight != 0) {
      var _ae = document.documentElement.clientHeight;
    } else {
      var _ae = document.getElementsByTagName("body")[0].clientHeight;
    }
  }
  return _ae;
}

/**
 * 取可视窗口的宽度
 */
function getViewportWidth() {
    if (typeof window.innerWidth != "undefined") {
        var _ae = window.innerWidth;
      } else {
        if (typeof document.documentElement !== "undefined"
            && typeof document.documentElement.clientwidth !== "undefined"
            && document.documentElement.clientWidth != 0) {
          var _ae = document.documentElement.clientWidth;
        } else {
          var _ae = document.getElementsByTagName("body")[0].clientWidth;
        }
      }
      return _ae;
}

/**
 * 取文档高度
 */
function getDocumentHeight() {
  var _af = document.body, _b0 = document.documentElement;
  return Math.max(_af.scrollHeight, _af.offsetHeight, _b0.clientHeight,
      _b0.scrollHeight, _b0.offsetHeight);
}

/**
 * 取得某元素离浏览器顶部距离
 * @param element
 * @return int
 */
function getElementTop(element){
  var actualTop = element.offsetTop;
  var current = element.offsetParent;
  
  while (current !== null){
    actualTop += current.offsetTop;
    current = current.offsetParent;
  }
  
  return actualTop;
}

/**
 * 元素到浏览器顶部的高度
 * @param obj 要查看的元素对象
 */
function getTop(obj){
    return getXY(obj).y - getScrollTop();
}

/**
 * 元素到浏览器左边的宽度
 */
function getLeft(obj){
    return getXY(obj).x - getScrollLeft();
}

/**
 * 页面滚动的宽度
 */
function getScrollLeft(){
  var scrollLeft = 0;
  if (document.documentElement && document.documentElement.scrollLeft) {
    scrollTop = document.documentElement.scrollLeft;
  } else if (document.body) {
    scrollTop = document.body.scrollLeft;
  }
  return scrollLeft;
}

/**
 * 取得页面滚动的高度
 * @returns int
 */
function getScrollTop()
{
  var srollTop = 0;
  if (document.documentElement && document.documentElement.scrollTop) {
    scrollTop = document.documentElement.scrollTop;
  } else if (document.body) {
    scrollTop = document.body.scrollTop;
  }

  return scrollTop;
}

/**
 * 判断页面是否滚动到底部
 * @returns {Boolean}
 */
function reachBottom() {
  var scrollTop = 0;
  var clientHeight = 0;
  var scrollHeight = 0;

  scrollTop = getScrollTop();

  if (document.body.clientHeight && document.documentElement.clientHeight) {
  clientHeight = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight
    : document.documentElement.clientHeight;
  } else {
  clientHeight = (document.body.clientHeight > document.documentElement.clientHeight) ? document.body.clientHeight
    : document.documentElement.clientHeight;
  }

  scrollHeight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
  ////console.log(scrollTop);
  ////console.log(clientHeight);
  ////console.log(scrollHeight);
  if (scrollTop + clientHeight + 20 >= scrollHeight) {
    return true;
  } else {
    return false;
  }
}

/**
 * 获取页面中选中的checkbox对应的ids
 * @requires checkbox上统一加name="listSelect"
 * @requires tr的class="dataList1"
 * @return Array 所有选中的id数组
 */
function getCheckedIds()
{
  var ids = [];
  $("input[name=listSelect]:checked").not(":disabled").each(function(){
  var selectId = $(this).closest("tr").attr("id").substring(8);
  ids.push(selectId);
  });
  return ids;
}

//对象克隆
function cloneObj(obj) {
  if (obj == null || typeof (obj) != "object") {
    return obj;
  }
  var _93 = obj.constructor();
  for ( var key in obj) {
    _93[key] = cloneObj(obj[key]);
  }
  return _93;
}
/*
 * 取当前时间 格式化时间 
 * @param string format 时间格式
 * @param date 要转的时间
 */

function getTime(str, date){
  if(date){
    var date = date.replace(/-/g, '/');
    var _date = new Date(date);
  } else {
    var _date = new Date();
  }
  
  var D = {};
  D['y'] = _date.getFullYear();
  D['m'] = _date.getMonth()+1;
  D['d'] = _date.getDate();
  D['h'] = _date.getHours();
  D['i'] = _date.getMinutes();
  D['s'] = _date.getSeconds();
  return str.replace(/\b\w+\b/g, function(word){
    //console.log(word.toLowerCase());
    return D[word.toLowerCase()];
  });
}

//加载图片, 如果不是图片格式会通过FileReader转成图片地址
//e: string src路径 || obj file对象
//t: 回调函数，参数为image对象
function loadImage(e, t) {
var n = new Image;
t && (n.onload = function() {
    t(n)
},
n.onerror = function() {
    t()
});
if (typeof e == "string") n.src = e;
else if (e.nodeName && e.nodeName == "IMG") n.src = e.src;
else if (window.FileReader && FileReader.prototype.readAsDataURL) {
    var r = new FileReader;
    r.onload = function(e) {
        n.src = e.target.result
    },
    r.readAsDataURL(e)
} else t()
}

//取节点的document对象
function getDocument(node) {
  if (node.nodeType == 9) {
      return node;
  } else if (typeof node.ownerDocument != undefined) {
      return node.ownerDocument;
  } else if (typeof node.document != undefined) {
      return node.document;
  } else if (node.parentNode) {
      return getDocument(node.parentNode);
  } else {
      throw new Error("getDocument: no document found for node");
  }
}


//取节点的window对象
function getWindow(node) {
  var doc = getDocument(node);
  if (typeof doc.defaultView != undefined) {
      return doc.defaultView;
  } else if (typeof doc.parentWindow != undefined) {
      return doc.parentWindow;
  } else {
      throw new Error("Cannot get a window object for node");
  }
}

//取iframe中的dowcument对象
function getIframeDocument(iframeEl) {
  if ( typeof iframeEl.contentDocument != undefined) {
      return iframeEl.contentDocument;
  } else if (typeof iframeEl.contentWindow != undefined) {
      return iframeEl.contentWindow.document;
  } else {
      throw new Error("getIframeWindow: No Document object found for iframe element");
  }
}

//取iframe中window对象
function getIframeWindow(iframeEl) {
  if(typeof a == undefined)
  if (typeof iframeEl.contentWindow != undefined) {
      return iframeEl.contentWindow;
  } else if (typeof iframeEl.contentDocument != undefined) {
      return iframeEl.contentDocument.defaultView;
  } else {
      throw new Error("getIframeWindow: No Window object found for iframe element");
  }
}
//iframe高度自适应
function autoIframeHeight(iframe){
var dom = getIframeDocument(iframe);
var element = dom.body;
var timer;
var currentHeight;
var lastHeight;
var span,tmp;
function autoHeight(){
  clearTimeout(timer);
  timer = setTimeout(function(){
    if (!span) {
      span = document.createElement('span');
      //trace:1764
      span.id = 'tmp_span'
      span.style.cssText = 'display:block;width:0;margin:0;padding:0;border:0;clear:both;';
      span.innerHTML = '.';
  }
  tmpNode = span.cloneNode(true);
  element.appendChild(tmpNode);
  var ss =parseInt($(iframe).css('minHeight'));
  currentHeight = Math.max(getXY(tmpNode).y + tmpNode.offsetHeight, ss);
  if (currentHeight != lastHeight) {
    $(iframe).css('minHeight',getXY(tmpNode).y + tmpNode.offsetHeight);
    lastHeight = currentHeight;
  }
  $(dom).find('#tmp_span').remove();
  },50);
  
}
autoHeight();
//autoIframeHeight();
}

/*
 * 弹出提示框
 * @param msg string 提示内容
 * @param status string 成功:'ok',不成功 非'ok'
 * @param func cbfn 回调函数提示退出时执行
 */
function showMsg1(msg, status, cbfn){
  alert(msg);return false;
  var status = status || 'err';
  if (status == 'ok') {
    var divClass = 'msg-ok';
    var iconClass = 'msg-ok-icon';
  } else if(status == 'err'){
    var divClass = 'msg-err';
    var iconClass = 'msg-err-icon';
  }
  
  var msgBox = document.createElement('div');
  msgBox.className = 'msg-alert '+divClass;
  msgBox.innerHTML = '</span><p>'+msg+'</p>';
  msgBox.style.top = '-1000px';
  msgBox.style.zIndex="30000";
  document.body.appendChild(msgBox);
  
  var rm = setTimeout(function(){
        document.body.removeChild(msgBox);
        if(cbfn){
            cbfn();
        }
    },1500);
  
  var exitBtn = document.createElement('a');
    exitBtn.href="javascript:void(0)";
    exitBtn.style.cssText = 'position:absolute;top:0px;right:5px;color:#777;width:12px;height;12px;';
    exitBtn.innerHTML = '×';
    exitBtn.onclick = function(){
      document.body.removeChild(msgBox);
      clearTimeout(rm);
    }
    msgBox.appendChild(exitBtn);
  
  var rect = msgBox.getBoundingClientRect();
    var objWidth = rect.right - rect.left;
    var offsetLeft = ((getViewportWidth() -20) - objWidth) / 2;
    
    msgBox.style.left = offsetLeft +'px';
    msgBox.style.top = '5px';
    
    var iconTop = (rect.bottom - rect.top)/2 - 15;
    var iconSpan = document.createElement('span');
  iconSpan.className = 'alert-icon '+iconClass;
  iconSpan.style.top = iconTop +'px';
  msgBox.appendChild(iconSpan);
}
/**
 * 显示大图/号码
 * @param msg
 * @param type
 */
function showBigger(msg, type){

  if (type == 'num'){
    var msg = '<span class="tel-number">'+msg+'</span>';
  }
  
  var showBox = document.createElement('div');
  showBox.className = 'popup-box';
  showBox.innerHTML = '<div class="mask-darker-layer"></div>';
  
  var wrap = document.createElement('div');
  wrap.className = 'file-large-img';
  wrap.innerHTML = msg+'<img class="img-fix" src="/images/file/fix.png" alt="">';
  
  showBox.appendChild(wrap);
  
  /*
  var cover = document.createElement('div');
  cover.className = 'mask-layer';
  showBox.appendChild(cover);
  */
  document.body.appendChild(showBox);
  
  wrap.onclick = function(){
    document.body.removeChild(showBox);
  }
}

/**
 * 停止默认事件
 */
function stopDefault(e){
  if (e && e.preventDefault){
    e.preventDefault();
  } else if(window.event && window.event.returnValue){
     window.event.returnValue = false;
  } 
}

/**
 * 阻止事件冒泡
 */
function stopBubble(e){
  if(e && e.stopPropagation()){
    e.stopPropagation();
  } else if(window.event && window.event.cancelBubble){
  window.event.cancelBubble = true;
  }
}

/**
 * 移动光标位置
 * @param textarea
 * @param pos
 */
function setCurPos ( textarea , pos ) {
  textarea.focus();
  if (textarea.setSelectionRange) {
    textarea.setSelectionRange(pos, pos);
  } else if (textarea.createTextRange) {
    var range = textarea.createTextRange();
    range.collapse(true);
    range.moveEnd('character', pos);
    range.moveStart('character', pos);
    range.select();
  }
}

/**
 * 弹层
 * @param string msg 提示信息
 * @param int type 1:成功 2:警告
 */
//function showMsg(msg, type, callbackFn)
//{
//  var msgType = 'icon-warn';
//  if (type == 1) {
//    msgType = 'icon-success'
//  }
//  var floatBox = $('<div class="pop-bg" style="z-index:20001; display:none;">\
//                    <div class="pop-box pop-warn">\
//                      <a class="btn-close" title="关闭"></a>\
//                      <div class="pop-middle">\
//                        <dl class="pop-warn-con clearfix">\
//                          <dt><em class="'+msgType+'"></em></dt>\
//                          <dd>'+msg+'</dd>\
//                        </dl>\
//                      </div>\
//                    </div>\
//                  </div>');
//  $('body').append(floatBox);
//  
//  floatBox.show();
//  
//  // 自动关闭浮层
//  var rm = setTimeout(function(){
//    floatBox.remove();
//    if(callbackFn){
//      callbackFn();
//    }
//  },1500);
//  
//  floatBox.find('.btn-close').click(function(){
//    floatBox.remove();
//    
//    clearTimeout(rm);
//  });
//}
function showMsg(msg, type, showMask, _postion, callBackfn)
{
  var msgBox = document.createElement('div');
  msgBox.className = 'float-alert float-alert-warning';
  if (type == 1) {
    msgBox.className = 'float-alert';
  }
  var htmlCode = '<div class="float-alert-con clearfix">';
  
  if (type == 1) {
    htmlCode += '<i class="icon-success"></i>';
  } else {
    htmlCode += '<i class="icon-warning"></i>';
  }
  htmlCode += '<p class="">'+msg+'</p>\
                      </div>';
  msgBox.innerHTML = htmlCode;
  //msgBox.style.top = '-1000px';
  msgBox.style.zIndex="30000";

  if (showMask == 1) {
    var showMaskBox = document.createElement('div');
    showMaskBox.className = 'float-bg';
    showMaskBox.style.zIndex="29999";
    document.body.appendChild(showMaskBox);
  }

  document.body.appendChild(msgBox);
  var rm = setTimeout(function(){
      document.body.removeChild(msgBox);
      if (showMaskBox) {
        document.body.removeChild(showMaskBox);
      }
      if(callBackfn){
        callBackfn();
      }
  },3500);
  
    var exitBtn = document.createElement('a');
    exitBtn.href="javascript:void(0)";
    exitBtn.className = "icon-close";
    //exitBtn.style.cssText = 'position:absolute;top:0px;right:5px;color:#777;width:12px;height;12px;';
    exitBtn.innerHTML = '关闭';
    exitBtn.onclick = function(){
      document.body.removeChild(msgBox);
      if (showMaskBox) {
        document.body.removeChild(showMaskBox);
      }
      clearTimeout(rm);
    }
    msgBox.appendChild(exitBtn);
  
    var rect = msgBox.getBoundingClientRect();
    var objWidth = rect.right - rect.left;
    var objheight = rect.bottom - rect.top;
    var offsetLeft = ((getViewportWidth() -20) - objWidth) / 2;
    var offsettop  = getScrollTop();
    if (_postion == 2) {
      offsettop  = ((getViewportHeight() -20) - objheight) / 2 + getScrollTop();
    }
    //msgBox.style.left = offsetLeft +'px';
    //msgBox.style.top = offsettop+'px';
    msgBox.style.marginLeft = '0';
    msgBox.style.marginTop = '0';
    
}

/**
 * 弹出confrim
 * @param msg string 提示内容
 * @param showMask int 遮罩 默认0 不开启 可选参数 1 开启
 * @param callBackAllowFn fn 确定执行的回调函数
 * @param callBackCancelFn fn 取消执行的回调函数
 */
function showConfirm(msg, showMask, callBackAllowFn, callBackCancelFn) {
  var confirmBox = document.createElement('div');
  confirmBox.className = 'float-confirm';
  confirmBox.innerHTML = '<div class="float-confirm-con">\
                        <p>'+msg+'</p>\
                        <div class="float-confirm-btns">\
                          <a id="js_btnAllow" class="btn btn-success btn-sm">确定</a>\
                          <a id="js_btnCancel" class="btn btn-default btn-sm">取消</a>\
                        </div>\
                      </div>';
  confirmBox.style.top = '-1000px';
  confirmBox.style.zIndex="20000";
  document.body.appendChild(confirmBox);

  if (showMask == 1) {
    var showMaskBox = document.createElement('div');
    showMaskBox.className = 'float-bg';
    showMaskBox.style.zIndex="19999";
    document.body.appendChild(showMaskBox);
  }
  var bool = 0;
  var rm = function(){
        document.body.removeChild(confirmBox);
        if (showMaskBox) {
          document.body.removeChild(showMaskBox);
        }
        if (bool ==1) {
          if(callBackAllowFn){
            callBackAllowFn();
          }
        } else {
          if(callBackCancelFn){
            callBackCancelFn();
          }
        }
  };
    var allowBtn = document.getElementById('js_btnAllow');
    allowBtn.onclick = function(){
      bool = 1;
      rm();
    }
    
    var cancelBtn = document.getElementById('js_btnCancel');
    cancelBtn.onclick = function(){
      bool = 0;
      rm();
    }
  
    var rect = confirmBox.getBoundingClientRect();
    var objWidth = rect.right - rect.left;
    var objheight = rect.bottom - rect.top;
    var offsetLeft = ((getViewportWidth() -20) - objWidth) / 2;
    var offsetTop  = ((getViewportHeight() -20) - objheight) / 2 + getScrollTop()-50;
    if (offsetTop < 0) {
      offsetTop = 0;
    }
    
    confirmBox.style.left = offsetLeft +'px';
    confirmBox.style.top = offsetTop+'px';
    confirmBox.style.marginLeft = '0';
    confirmBox.style.marginTop = '0';
}
/**
 * 弹出confrim
 * @param msg string 提示内容
 * @param showMask int 遮罩 默认0 不开启 可选参数 1 开启
 * @param callBackAllowFn fn 确定执行的回调函数
 * @param callBackCancelFn fn 取消执行的回调函数
 */
function showConfirm_1(msg, showMask, callBackAllowFn, callBackCancelFn) {
  var confirmBox = document.createElement('div');
  confirmBox.className = 'float-confirm';
  confirmBox.innerHTML = '<div class="float-confirm-con">\
                        <p>'+msg+'</p>\
                        <div class="float-confirm-btns">\
                          <a id="js_btnAllow_1" class="btn btn-success btn-sm">确定</a>\
                        </div>\
                      </div>';
  confirmBox.style.top = '-1000px';
  confirmBox.style.zIndex="20000";
  document.body.appendChild(confirmBox);

  if (showMask == 1) {
    var showMaskBox = document.createElement('div');
    showMaskBox.className = 'float-bg';
    showMaskBox.style.zIndex="19999";
    document.body.appendChild(showMaskBox);
  }
  var bool = 0;
  var rm = function(){
        document.body.removeChild(confirmBox);
        if (showMaskBox) {
          document.body.removeChild(showMaskBox);
        }
        if (bool ==1) {
          if(callBackAllowFn){
            callBackAllowFn();
          }
        } else {
          if(callBackCancelFn){
            callBackCancelFn();
          }
        }
  };
    var allowBtn = document.getElementById('js_btnAllow_1');
    allowBtn.onclick = function(){
      bool = 1;
      rm();
    }
    
    /*var cancelBtn = document.getElementById('js_btnCancel');
    cancelBtn.onclick = function(){
      bool = 0;
      rm();
    }*/
  
    var rect = confirmBox.getBoundingClientRect();
    var objWidth = rect.right - rect.left;
    var objheight = rect.bottom - rect.top;
    var offsetLeft = ((getViewportWidth() -20) - objWidth) / 2;
    var offsetTop  = ((getViewportHeight() -20) - objheight) / 2 + getScrollTop()-50;
    if (offsetTop < 0) {
      offsetTop = 0;
    }
    
    confirmBox.style.left = offsetLeft +'px';
    confirmBox.style.top = offsetTop+'px';
    confirmBox.style.marginLeft = '0';
    confirmBox.style.marginTop = '0';
}

///**
// * confirm 确证弹出层
// */
//function checkConfirm(msg, ok_fn, cancel_fn)
//{
//  var floatBox = $('<div class="pop-bg" style="z-index:10001; display:none;">\
//      <div class="pop-box pop-prompt">\
//        <div class="pop-top">\
//          <a class="btn-close" title="关闭" style="display:none;"></a>\
//        </div>\
//        <div class="pop-middle">\
//          <div class="pop-prompt-con">\
//            <h4 class="title1">'+msg+'</h4>\
//          </div>\
//          <div class="pop-bottom">\
//            <div class="publish-options clearfix">\
//              <button type="submit" class="publish-btn js_okBtn left">确认</button>\
//              <button type="button" class="btn-concel js_cancelBtn right">取消</button>\
//            </div>\
//          </div>\
//        </div>\
//      </div>\
//    </div>');
//  $('body').append(floatBox);
//  floatBox.show();
//  
//  var flat = false;
//  floatBox.find('.js_okBtn').click(function(){
//      flat = true;
//      floatBox.remove();
//      if(ok_fn){
//        //console.log('okfunction');
//        ok_fn();
//      }
//  });
//  
//  floatBox.find('.js_cancelBtn').click(function(){
//      flat = false;
//      floatBox.remove();
//      if(cancel_fn){
//        cancel_fn();
//      }
//  });
//  
//  return flat;
//}

/**
 * 点击跳到顶部
 * @param obj 点击的对象
 */
function goTopEx(obj){
  if (!obj) {
    return false;
  }
  //console.log(obj);
  function setScrollTop(value){
      if (document.documentElement && document.documentElement.scrollTop) {
        document.documentElement.scrollTop = value;
      } else if (document.body) {
        document.body.scrollTop = value;
      }
  }
  window.onscroll=function(){
    if (getScrollTop()>600) {
      obj.style.display = "block";
      obj.style.zIndex = 1000;
    } else {
      obj.style.display = "none";
      obj.style.zIndex = 0;
    }
  }
  obj.onclick=function(){
      var goTop=setInterval(scrollMove,10);
      function scrollMove(){
        setScrollTop(getScrollTop()/1.1);
        if (getScrollTop()<1) clearInterval(goTop);
      }
  }
}

/**
 * 禁止回车提交表单
 * @param ev
 * @returns {Boolean}
 */
function noSubmit(ev)
{
    if( ev.keyCode == 13 )
    {
        return false;
    }
    return true;
}

/**
 * 空白文件提示显示与隐藏控制
 */
function emptyChange(obj)
{
    ////console.log($(".fileList li").length, $(".fileList li").length > 0);
    if (obj.length > 0) {
      $(".emptyBox").addClass('hidden');
      $(".noMore").addClass('hidden');
    } else {
      $(".emptyBox").removeClass('hidden');
    }
}

Array.prototype.indexOf = function(obj, start) {
     for (var i = (start || 0), j = this.length; i < j; i++) {
         if (this[i] === obj) { return i; }
     }
     return -1;
}

/*
//删除 数组 元素值
Array.prototype.del=function(val) {
  if(!val){
    return;
  }
  var n = null;
  for(var i=0,len=this.length; i<len; i++){
    if(this[i] == val){
      n = i;
    }
  }
  
  if(!n){
    return;
  }

  return this.slice(0,n).concat(this.slice(n+1,this.length));
}
*/
/**
 * console.log();
 */
function consoleLog() {
  if(typeof console != 'undefined' && typeof console.log != 'undefined') {
    for (var i=0,len=arguments.length; i<len; i++) {
      console.log(arguments[i]);
    }
  }
}

/**
 * 输入字符总数
 * @param string content
 * @return int
 */
function getFontNum(content)
{
  var regx = "[\u4e00-\u9fa5]|[\uFE30-\uFFA0]";
  content = content.replace(new RegExp(regx, 'gm'), '11');
  
  return Math.ceil(content.length / 2);
}

/**
 * html5选择照片后的预览(需要特定的class和ID 如：js_upFileBox， js_upFile)
 * @param evt
 * @returns {Boolean}
 */
/**
 * html5选择照片后的预览(需要特定的class和ID 如：js_upFileBox， js_upFile)
 * @param evt
 * @returns {Boolean}
 */
function handleFileSelect(obj, _w, _h)
{
  if (typeof FileReader == "undefined") {
    return false;
  }
  var thisClosest = obj.closest('.perUpOuter');
  if (typeof thisClosest.length == "undefined") {
    return;
  }
  
  var files = obj[0].files;
  var f = files[0];
  if (!isAllowFile(f.name)) {
    showMsg("请上传常规格式的图片,如：jpg, png等");
    return false;
  }
  
  var reader = new FileReader();
  reader.onload = (function(theFile){
      return function (e) {
        var tmpSrc = e.target.result;
        if (tmpSrc.lastIndexOf('data:base64') != -1) {
          tmpSrc = tmpSrc.replace('data:base64', 'data:image/jpeg;base64');
        } else if (tmpSrc.lastIndexOf('data:,') != -1) {
          tmpSrc = tmpSrc.replace('data:,', 'data:image/jpeg;base64,');
        }
        
        var img = '<img src="' + tmpSrc + '" />';
        //consoleLog(reader, img);
        
        thisClosest.find(".js_upFileBox").show().html(img);
        var cssObj = { };
        if (_w && _h) {
          cssObj = { 'width':_w+'px', 'height':_h+'px' };
        } else if (_w) {
          cssObj = { 'width':_w+'px' };
        } else if (_h) {
          cssObj = { 'height':_h+'px' };
        } else {
          cssObj = { 'max-width':'360px', 'max-height':'200px' };
        }
        //consoleLog(cssObj);
        thisClosest.find(".js_upFileBox img").css( cssObj );
      };
  })(f)
  reader.readAsDataURL(f);
}

//取得文件名的后缀
function getFileExt(fileName)
{
  if (!fileName) {
    return '';
  }
  
  var _index = fileName.lastIndexOf('.');
  if (_index < 1) {
    return '';
  }
  
  return fileName.substr(_index+1);
}

// 是合格的文件名
function isAllowFile(fileName, allowType)
{
  var fileExt = getFileExt(fileName).toLowerCase();
  if (!allowType) {
    allowType = ['jpg', 'jpeg', 'png', 'gif'];
  }
  
  if ($.inArray(fileExt, allowType) != -1) {
    return true;
  }
  
  return false;
}

// 字符串截取中英文混合
function cutStr(str,n){
  var r=/[^\x00-\xff]/g;
  if (str.replace(r,"mm").length<=n) {
    return str;
  }
  for (var i=n;i<str.length;i++) {
      if(str.substr(0,i).replace(r,"mm").length>=n){
          return str.substr(0,i);
      }
  }
  return str;
}