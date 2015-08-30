$(function(){
    $("#form-login").find("#btn-login").click(doLogin);
});

function doLogin(){
    var userType = $("#form-login").find("input[name='user_type']:checked").val();

    if(userType=='expert')
        doExpertLogin();
    else
        doUserLogin();
}

function doExpertLogin(){

    $("#form-expert-login").find('.message').html('');

    if(isExpertLoginFormValid()){

        var data = $("#form-login").serialize();

        $.ajax({
            url: root + '/is-valid-expert',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('invalid')>-1)
                    $("#form-login").find('.message').show().html('Invalid username or password');
                else if(result.message.indexOf('correct')>-1)
                    window.location.replace(root + '/expert-dashboard');
                else
                    $("#form-expert-login").find('.message').show().html('Server returned error : ' + result.message);
            }
        });
    }
}
function isExpertLoginFormValid(){
    return true;
}


function doUserLogin(){

    if(isUserLoginFormValid()){

        var data = $("#form-login").serialize();

        $.ajax({
            url: root + '/is-valid-user',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('wrong')>-1)
                    $("#form-login").find('.message').html('Invalid username or password');
                else if(result.message.indexOf('correct')>-1){
                    $("li#user-name").html(result.first_name + ' ' + result.last_name);
                }
                else
                    $("#form-login").find('.message').html('Server returned error : ' + result.message);
            }
        });
    }
}
function isUserLoginFormValid(){
    return true;
}