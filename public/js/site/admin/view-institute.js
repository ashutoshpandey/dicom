$(function(){
    $("input[name='btn-update']").click(updateInstitute);
});

function updateInstitute(){

    if(isInstituteFormValid()){

        var data = $("#form-update-institute").serialize();

        $.ajax({
            url: root + '/update-institute',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for institute');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Institute updated successfully');
                }
            }
        });
    }
}
function isInstituteFormValid(){
    return true;
}