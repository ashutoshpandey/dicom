$(function(){
    $("input[name='btn-update']").click(updateLocation);
});

function updateLocation(){

    if(isLocationFormValid()){

        var data = $("#form-update-location").serialize();

        $.ajax({
            url: root + '/update-location',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for location');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Location updated successfully');
                }
            }
        });
    }
}
function isLocationFormValid(){
    return true;
}