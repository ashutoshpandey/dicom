$(function(){
    $("input[name='btn-create']").click(createInstitute);

    listInstitutes(1);
});

function createInstitute(){

    if(isInstituteFormValid()){

        var data = $("#form-create-institute").serialize();

        $.ajax({
            url: root + '/save-institute',
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
                    $('.message').html('Institute created successfully');

                    $('#form-container').find('input[type="text"],input[type="password"],input[type="email"], textarea').val('');

                    listInstitutes(1);
                }
            }
        });
    }
}
function isInstituteFormValid(){
    return true;
}

function listInstitutes(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-list-institutes/' + status + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showGrid(result);
            }
        }
    );
}
function showGrid(data){

    if(data!=undefined && data.institutes!=undefined && data.institutes.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="city">Location</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.institutes.length;i++){

                var institute = data.institutes[i];

                str = str + '<tr> \
                    <td>' + institute.id + '</td> \
                    <td>' + institute.name + '</td> \
                    <td>' + institute.city + ' / ' + institute.state + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#institute-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-institute/' + row.id + '">View</a>&nbsp;&nbsp; ';
                str += '<a target="_blank" href="' + root + '/admin-institute-experts/' + row.id + '">Experts</a>&nbsp;&nbsp; ';
                str += '<a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this institute?"))
                    return;

                $.getJSON(root + '/remove-institute/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listInstitutes(1);
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
        $('#institute-list').html('No institutes found');
}
