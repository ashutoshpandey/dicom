var path;
$(function(){
    path = $(".path").attr('rel')+"/";
//    validate();
    $('.btnLoginExpert').click(checkExpertLogin);
});

function validate(){
    $('#expertLoginForm').bootstrapValidator({
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

function checkExpertLogin(){

    var frm = $("#expertLoginForm").serialize();
    $(".msg").html("");
    
    $.ajax({
        url: 'isvalidexpert',
        type: 'GET',
        data: frm,
        success: function(r){

            if(r.indexOf("correct")>-1)
                window.location.replace(path+'expert/expert-section');
            else if(r.indexOf("invalid")>-1)
                $(".msg").html("Invalid username or password");
            else
                $(".msg").html("Please try after some time");
        }
    });
}