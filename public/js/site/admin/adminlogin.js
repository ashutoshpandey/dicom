var path;
$(function(){
    path = $(".path").attr('rel');
    validate();
    $('.btnlogin').click(checkLogin);
});

function validate(){
    $('#adminLoginForm').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        /*onSuccess: function(e) {
            checkLogin();
        },*/
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'Username is required'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    }
                }
            }
        }
    });
}

function checkLogin(){

    var frm = $("#adminLoginForm").serialize();

    $.ajax({
       url: 'isvalidadmin',
       type: 'GET',
       data: frm,
       success: function(r){

           if(r.indexOf("correct")>-1)
                window.location.replace(path+'/admin/admin-section');
           else if(r.indexOf("invalid")>-1)
               $(".msg").html("Invalid email or password");
           else
               $(".msg").html("Please try after some time");
       }
    });
}