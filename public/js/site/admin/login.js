$(function(){
    $("input[name='btn-login']").click(doLogin);
});

function doLogin(){

    if(isLoginFormValid()){

        var data = $("#form-admin-login").serialize();

        $.ajax({
            url: root + '/is-valid-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('wrong')>-1)
                    $('.message').html('Invalid username or password');
                else if(result.message.indexOf('correct')>-1)
                    window.location.replace(root + '/admin-section');
                else
                    $('.message').html('Server returned error : ' + result.message);
            }
        });
    }
}
function isLoginFormValid(){
    return true;
}