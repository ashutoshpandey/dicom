$(function(){
    $("input[name='btn-update']").click(updateUser);
});

function updateUser(){

    if(isUserFormValid()){

        var data = $("#form-update-user").serialize();

        $.ajax({
            url: root + '/update-user',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('User updated successfully');
                }
            }
        });
    }
}
function isUserFormValid(){
    return true;
}