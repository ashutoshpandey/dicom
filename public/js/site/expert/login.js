$(function(){
    $("input[name='btn-login']").click(doLogin);
});

function doLogin(){

    $('.message').html('');
    $('.message').show();

    if(isExpertLoginFormValid()){

        var data = $("#form-login").serialize();

        $.ajax({
            url: root + '/is-valid-expert',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('invalid')>-1)
                    $('.message').html('Invalid username or password');
                else if(result.message.indexOf('correct')>-1)
                    window.location.replace(root + '/expert-section');
                else
                    $('.message').html('Server returned error : ' + result.message);
            }
        });
    }
}
function isExpertLoginFormValid(){
    return true;
}
