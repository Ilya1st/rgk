/**
 * Created by lex on 08.08.2016.
 */
$(document).ready(function(){
    function getModelFields(eventId, callback){
        $.ajax('/basic/web/index.php/admin/notifications/fields', {
            success: callback,
            dataType:'json',
            data:{
                eventId:eventId
            }
        });
    }
    function fillFields(){
        var eventId=$('#notification-event_id').val(),
            tp = $('#notification-totype').val();
        var to = $('#notification-to');

        if(!eventId || tp!='field') {
            to.empty();
            return;
        }
        getModelFields(eventId,function(data){
            var options = $.map(data,function(item){
                return '<option value="' + item + '">'+item+"</option>";
            });
            to.empty();
            to.append(['<option value>--Выберите поле модели--</option>'].concat(options));
            to.attr('disabled',null);
        });
    }
    $('#notification-totype').change(function(e){
        var t = $(e.target).val();
        var to = $('#notification-to');
        switch(t){
            case 'all':
                to.attr('disabled','disabled');
                to.empty();
                break;
            case 'user':
                var options = $('#notification-from_user_id').children('option');
                var nOptions = $.map(options,function(item, i){
                    var cur = $(item);
                    return i ? '<option value="' + cur.val() + '">'+cur.text() + '</option>':'<option value>--Выберите получателя--</option>';
                });
                to.empty();
                to.append(nOptions);
                to.attr('disabled',null);
                break;
            case 'field':
                fillFields();
                break;
        }
    });

    function fillModelTemplates(target){
        var eventId = target.val(),
            cur = target.children('option:selected').text();
        if(eventId){
            getModelFields(eventId,function(data){
                $('#currentevent').text(cur);
                var str='';
                for(var i= 0,len=data.length;i<len;i++){
                    if(str) str+=', ';
                    str+='{model'+data[i]+"}";
                }
                $('#eventtemplates').text(str);
                $('#modeltemplates').removeClass('hidden');
            });
        }else{
            $('#modeltemplates').addClass('hidden');
        }
    }
    $('#notification-event_id').change(function(e){
        fillModelTemplates($(e.target));
        fillFields();
    });
    fillModelTemplates($('#notification-event_id'));
});