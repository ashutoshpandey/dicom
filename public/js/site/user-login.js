$(function(){
    $("input[name='btn-user-login']").click(doUserLogin);
});

function doUserLogin(){

    if(isUserLoginFormValid()){

        var data = $("#form-expert-login").serialize();

        $.ajax({
            url: root + '/is-valid-user',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('wrong')>-1)
                    $("#form-expert-login").find('.message').html('Invalid username or password');
                else if(result.message.indexOf('correct')>-1)
                    window.location.replace(root + '/expert-section');
                else
                    $("#form-expert-login").find('.message').html('Server returned error : ' + result.message);
            }
        });
    }
}
function isUserLoginFormValid(){
    return true;
}