$(function(){

    $("#btn").click(sendPassword);
});

function checkLogin(){

    var frm = $(".frm").serialize();

    $.ajax({
        url: 'sendexpertpassword',
        type: 'GET',
        data: frm,
        success: function(r){

            if(r.indexOf("done")>-1)
                window.location.replace('expert-password-sent');
            else if(r.indexOf("notfound")>-1)
                $(".msg").html("Email not registered with us");
            else
                $(".msg").html("Please try after some time");
        }
    });
}