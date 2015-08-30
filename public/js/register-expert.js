$(function(){
    $("#btn").click(registerExpert);
});

function registerExpert(){

    var frm = $(".frm").serialize();

    $.ajax({
        url: 'saveexpert',
        type: 'GET',
        data: frm,
        success: function(r){

            if(r.indexOf("done")>-1)
                window.location.replace('expert-registered');
            else if(r.indexOf("duplicate")>-1)
                $(".msg").html("Email already taken...");
            else
                $(".msg").html("Please try after some time");
        }
    });
}