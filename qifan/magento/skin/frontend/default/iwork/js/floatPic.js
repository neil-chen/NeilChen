var isIE=!(navigator.userAgent.indexOf('MSIE')==-1);
var news;
var curNew=0;
var timer;
function init()
{
	var div=document.getElementById("NewsPic");
	if(!div)return;
	var nav=document.createElement("DIV");
	nav.className="Nav";
	var nodes;
	if(isIE)
	{
	    nodes=div.childNodes;
	}
	else
	{
	    nodes=childrenNodes(div.childNodes);
	}
	news=new Array(nodes.length);
	for(var i=nodes.length-1;i>=0;i--)
	{
	    var element=nodes[i];
	    
	    
		news[i]={};
		news[i].Element=element;
		news[i].Text=element.getAttribute("title");
		news[i].Url=element.getAttribute("href");
		
		var n=document.createElement("span");
		n.innerHTML="<a herf=\"javascript:;\" onclick=\"javascript:curNew="+(i-1)+";change();\">"+(i+1)+"</a>";
		if(i==curNew)n.className="Cur";
		nav.appendChild(n);
		
		news[i].LinkElement=n;
	}
	div.appendChild(nav);
	curNew--;
	change();

}
function childrenNodes(node)
{
    var c=new Array();
    for(var i=0;i<node.length;i++)
    {
        if(node[i].nodeName.toLowerCase()=="a")
            c.push(node[i]);
    }
    return c;
}
function change()
{
    var div=document.getElementById("NewsPic");
    var text=document.getElementById("NewsPicTxt");
    if(!div)return;
    curNew=curNew+1;
    if(curNew>=news.length)curNew=0;
    for(var i=0;i<news.length;i++)
    {
        if(i==curNew)
        {
            news[i].Element.style.display="block";
            news[i].Element.style.visibility="visible";
            news[i].LinkElement.className="Cur";
            text.innerHTML="<a href=\""+news[i].Url+"\" title=\""+news[i].Text+"\" target=\"_blank\">"+news[i].Text+"</a>";
        }
        else
        {
            news[i].Element.style.visibility="hidden";
            news[i].Element.style.display="none";
            news[i].LinkElement.className="Normal";
        }
    }
    if(timer)window.clearTimeout(timer);
    timer=window.setTimeout("change()",4000);
    
}

