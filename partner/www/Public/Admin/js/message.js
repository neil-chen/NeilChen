/**
 * Created by Ccq on 2015/1/20.
 */
jQuery(document).ready(function() {
    /*
     阅读公告，公告弹窗
     */
    $('.readAdvice').click(function () {
        var sels = $(this);
        var id = Math.floor($(this).attr('data-id'));
        $('#advice_title').text($(this).attr('data-title'));
        $('#advice_content').html(JSON.parse($(this).attr('data-content')));
        $('#advice_name').text($(this).attr('data-name'));
        if ($(this).attr('data-food') == 0) {
            setRead(id);
            $('#advice_time').text($(this).attr('data-time'));
            sels.attr('data-food', 1);
        } else {
            $('#advice_time').text($(this).attr('data-food'));
        }
        $('#msg').modal('show');
    })

    /*
    弹框关闭后出发事件
     */
    $('#msg').on('hide.bs.modal', function () {
        window.location.reload();
    });

    /*
     阅读各种提醒
     */
    $('.setRead').click(function () {
        var sels = $(this);
        var id = Math.floor($(this).attr('data-id'));
        var rt = $(this).attr('data-food');
        if (rt == 0) {
            setRead(id);
            sels.attr('data-food', 1);
        }
    });

    /*
     阅读后的更新
     */
    function setRead(id) {
        $.post('/system/message/read', {
            'id': id
        }, function (data) {
            if (data.error == 0) {
                var num;
                var read_num;
                var unread;
                num = $('#unread_num').text();
                unread = $('#unread').text();
                read_num = $('#read_num').text();
                //未读消息的累减
                if (Number(num) > 0) {
                    num = num - 1;
                }
                if (Number(num) == 0) {
                    $('#unread_num').remove();
                } else {
                    $('#unread_num').text(num);
                }
                //标签内未读消息累减
                if (Number(unread) > 0) {
                    unread = unread - 1;
                }
                if (Number(unread) == 0) {
                    $('#unread').remove();
                } else {
                    $('#unread').text(unread);
                }
                //已读消息的累加
                if (Number(read_num) > 0) {
                    read_num = read_num * 1 + 1 * 1;
                }
                if (Number(read_num) == 0) {
                    $('#read_num').remove();
                } else {
                    $('#read_num').text(read_num);
                }
                $('#setRead' + id).removeClass('font-bold');
                $('#readAdvice' + id).removeClass('font-bold');
                $('#sender' + id).removeAttr('style');
                //$('#time' + id).text(data.msg);  //更新页面上的时间
                return data.msg;
            } else {
                alert(data.msg);
            }
        }, 'json');
    }
});