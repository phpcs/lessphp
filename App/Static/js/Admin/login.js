/**
 * Created by mac on 16/5/17.
 */


$(function(){

    $('form').submit(function(){
        var obj = $('form input')
        var data = {}

        obj.each(function(i){
            var key = $(this).attr('id')
            data[key] = $(this).val()
        })


        $.post('/Admin/index', data, function(res){
            var res = JSON.parse(res)
            if (res.code!=1) {
                alert(res.mes)
            } else {
                window.location.href='/Admin/father/panel'
            }
        })


    })

})