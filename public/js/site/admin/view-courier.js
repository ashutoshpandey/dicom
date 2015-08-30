$(function(){
    $("input[name='btn-update']").click(updateCourier);
});

function updateCourier(){

    if(isCourierFormValid()){

        var data = $("#form-update-courier").serialize();

        $.ajax({
            url: root + '/update-courier',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for courier');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Courier updated successfully');
                }
            }
        });
    }
}
function isCourierFormValid(){
    return true;
}