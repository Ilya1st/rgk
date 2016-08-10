/**
 * Created by lex on 09.08.2016.
 */
'use strict';
$(document).ready(function(){
    $('.btn-readed').click(function(e){
        var target = $(e.target),
            id=target.parent().data('message-id');
        $.ajax('/basic/web/index.php/partner/default/readed', {
            success: function(){
                target.parent().removeClass('alert-warning').addClass('alert-success');
                target.remove();
            },
            data:{
                id:id
            }
        });
        e.preventDefault();
        return false;
    });
});