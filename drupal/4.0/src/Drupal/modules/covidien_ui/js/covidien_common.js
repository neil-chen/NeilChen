function stripscript(s) {
	var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥&*（）&'。，、？]");
	var rs = "";
	for ( var i = 0; i < s.length; i++) {
		rs = rs + s.substr(i, 1).replace(pattern, '');
	}
	return rs;
}

function filterXSS(comp){
	var filterValue=stripscript($(comp).val());
	$(comp).val(filterValue);
}

String.prototype.startWith=function(str){     
  var reg=new RegExp("^"+str);     
  return reg.test(this);        
}  

String.prototype.endWith=function(str){     
  var reg=new RegExp(str+"$");     
  return reg.test(this);        
}

String.prototype.contains=function(substr, isIgnoreCase)
{
    if (isIgnoreCase)
    {
         string = this.toLowerCase();
         substr = this.toLowerCase();
    }

    var startChar = substr.substring(0, 1);
    var strLen = substr.length;

    for (var j = 0; j<this.length - strLen + 1; j++)
    {
         if (this.charAt(j) == startChar)
         {
             if (this.substring(j, j+strLen) == substr)
             {
                 return true;
             }   
         }
    }
    return false;
}


Array.prototype.contains = function(obj) { 
	
	for(var j=0;j<this.length;j++) { 
		if (this[j] === obj) { 
			return true; 
		} 
	} 
	return false; 
} 

if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt , from)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;
    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}

if(!String.prototype.trim) {
    String.prototype.trim = function() {
      return this.replace(/^\s+|\s+$/g, ''); 
    };
}
