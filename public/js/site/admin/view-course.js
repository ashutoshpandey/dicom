$(function(){
    $("input[name='btn-update']").click(updateCourse);
});

function updateCourse(){

    if(isCourseFormValid()){

        var data = $("#form-update-course").serialize();

        $.ajax({
            url: root + '/update-course',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for course');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Course updated successfully');
                }
            }
        });
    }
}
function isCourseFormValid(){
    return true;
}