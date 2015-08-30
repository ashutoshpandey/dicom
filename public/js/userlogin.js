var path;

$(function(){

    path = $(".path").attr('rel') + "/";
    $('.btnLoginUser').click(checkLogin);
    //validate();
});

function validate(){
    $('#userLoginForm').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        onSuccess: function(e) {
            checkLogin();
        },
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email address is required'
                    },
                    emailAddress: {
                        message: 'Email address is not valid'
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
    })
    .on('error.field.bv', function(e, data) {
        // $(e.target)  --> The field element
        // data.bv      --> The BootstrapValidator instance
        // data.field   --> The field name
        // data.element --> The field element

        data.bv.disableSubmitButtons(false);
    });
}

function checkLogin(){

    var frm = $("#userLoginForm").serialize();
    $(".msg").html("");
    $.ajax({
        url: path + 'isvaliduser',
        type: 'POST',
        data: frm,
        dataType: 'json',
        success: function(r){

            if(r.message.indexOf("correct")>-1)
                window.location.replace(path + 'user/user-section');
            else if(r.message.indexOf("invalid")>-1)
                $(".msg").html("Invalid email or password");
            else
                $(".msg").html("Please try after some time");
        }
    });
}