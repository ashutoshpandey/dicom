function isValidUser(){

    var data = $('.frmuserlogin').serialize();

    ajaxCall('authenticate/isvaliduser', 'post', data, userLoginResult);
}

function userLoginResult(result){

    if(result.indexOf('correct')>-1){
        ;
    }
    else{
        $('.frmuserlogin').find('.message').html('Invalid email or password');
    }
}

function isValidAdmin(){

    var data = $('.frmadminlogin').serialize();

    ajaxCall('authenticate/isvalidadmin', 'post', data, adminLoginResult);
}

function adminLoginResult(result){

    if(result.indexOf('correct')>-1){
        window.location.replace('adminsection');
    }
    else{
        $('.frmadminlogin').find('.message').html('Invalid username or password');
    }
}