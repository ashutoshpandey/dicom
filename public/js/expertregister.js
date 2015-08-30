var path,country,timezone;
$(function(){
    path = $(".path").attr('rel')+'/';
    country = $(".country").attr('rel');

    timezone = $(".timezone").attr('rel');

    $('.btnRegisterExpert').click(registerExpert);
});

function validate(){
    $('#registrationFormExpert').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        onSuccess: function(e) {
            registerExpert();
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
                    },
                    different: {
                        field: 'username',
                        message: 'Password cannot be the same as username'
                    },
                    stringLength: {
                        min: 8,
                        message: 'Password must have at least 8 characters'
                    }
                }
            },
            repeat_password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    },
                    identical: {
                        field: 'password',
                        message: 'Password mismatch'
                    }
                }
            },
            first_name: {
                message: 'First name is not valid',
                validators: {
                    notEmpty: {
                        message: 'First name is required'
                    }
                }
            },
            last_name: {
                message: 'Last name is not valid',
                validators: {
                    notEmpty: {
                        message: 'Last name is required'
                    }
                }
            },
            dob: {
                validators: {
                    notEmpty: {
                        message: 'Date of birth is required'
                    },
                    date: {
                        format: 'YYYY/MM/DD',
                        message: 'Date of birth is not valid'
                    }
                }
            },
            terms:{
                validators:{
                    choice:{
                        min: 1,
                        message: 'Please accept terms of use'
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

function registerExpert(){

    var frm = $("#registrationFormExpert").serialize();

    $.ajax({
        url: 'saveexpert',
        type: 'POST',
        data: frm,
        success: function(r){
            if(r.indexOf("done")>-1){
                $(".msg").html("Registration successfull");
                $.ajax({
                    url: 'sendexpertregisteremail',
                    type: 'GET',
                    success: function(r){
                    }
                });
                window.location.replace('expert-registered');
            }
            else if(r.indexOf("duplicate")>-1)
                $(".msg").html("Email already taken");
            else
                $(".msg").html("Please try after some time");
        }
    });
}