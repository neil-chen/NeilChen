/**
 * Created by ccq on 2015/1/20.
 */
$.fn.marquee = function(options){
    var obj = $(this), ul = obj.find('ul'), i = 0,timer;
    if(ul.find('li').length>=4){
        obj.append(ul.clone());
    }
    function s(){
        if(i>=ul.width()){
            obj.scrollLeft(0);
            i=0;
        }else{
            obj.scrollLeft(i++);
        }
        timer = setTimeout(s,20);
    }
    s();
    obj.hover(function(){
        clearTimeout(timer)
    },function(){
        s();
    })
}

$('#marquee').marquee();