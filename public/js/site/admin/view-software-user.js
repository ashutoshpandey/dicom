$(function(){
    $("input[name='btn-update']").click(updateSoftwareUser);
});

function updateSoftwareUser(){

    if(isSoftwareUserFormValid()){

        var data = $("#form-update-software-user").serialize();

        $.ajax({
            url: root + '/update-software-user',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for software user');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Software user updated successfully');
                }
            }
        });
    }
}
function isSoftwareUserFormValid(){
    return true;
}