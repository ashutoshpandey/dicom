var patientId;

$(function(){

    patientId = $(".span-patient").attr('rel');

    $("input[name='btn-update-patient']").click(updatePatient);

    $("input[name='btn-forward']").click(forwardRequest);

    history(1);
});

function history(page){

    $.getJSON(
        root + '/patient-request-history/' + patientId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showHistory(result);
            }
        }
    );
}
function showHistory(result){

    if(result!=undefined && result.categories!=undefined && result.categories.length>0){

        var str = '';

        str = str + '<table id="grid-category" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">Category Id</th> \
                    <th data-column-id="name">Category Name</th> \
                    <th data-column-id="subid">SubCategory Id</th> \
                    <th data-column-id="subname">SubCategory Name</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<result.categories.length;i++){

            var data = result.categories[i];

            str = str + '<tr> \
                    <td>' + data.category.id + '</td> \
                    <td>' + data.category.name + '</td> \
                    <td>' + data.subcategory.id + '</td> \
                    <td>' + data.subcategory.name + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#history-list').html(str);

        $("#grid-category").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = "&nbsp;&nbsp; <span style='cursor:pointer;color:blue' class='remove' rel='" + row.id + "'>Remove</a>";

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $('#category-list').find(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove expert from this category?"))
                        return;

                    $.getJSON(root + '/remove-expert-category/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listCategories(1);
                            else if(result.message.indexOf('not logged')>-1)
                                window.location.replace(root);
                            else
                                alert("Server returned error : " + result);
                        }
                    );
                });
            });
    }
    else
        $('#history-list').html('No categories assigned');

}

function updatePatient(){

    if(isUpdatePatientFormValid()){

        var data = $("#form-update-patient").serialize();

        $.ajax({
            url: root + '/update-institute-patient',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-service").find('.message').html('Duplicate patient email');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Patient updated successfully');
                }
            }
        });
    }
}
function isUpdatePatientFormValid(){
    return true;
}

function forwardRequest(){

    if(isForwardRequestFormValid()){

        var data = $("#form-forward-request").serialize();

        $.ajax({
            url: root + '/forward-patient-request',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Request forwarded successfully');
                }
            }
        });
    }
}
function isForwardRequestFormValid(){
    return true;
}
