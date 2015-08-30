$(function(){
    $("input[name='btn-create']").click(createSoftwareUser);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listSoftwareUsers(1);
});

function createSoftwareUser(){

    if(isSoftwareUserFormValid()){

        var data = $("#form-create-software-user").serialize();

        $.ajax({
            url: root + '/save-software-user',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for softwareUser');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('SoftwareUser created successfully');

                    $('#form-container').find('input[type="text"],input[type="password"],input[type="email"], textarea').val('');

                    listSoftwareUsers(1);
                }
            }
        });
    }
}
function isSoftwareUserFormValid(){
    return true;
}

function listSoftwareUsers(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-list-software-users/' + status + '/' + page,
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

    if(data!=undefined && data.software_users!=undefined && data.software_users.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="username">Username</th> \
                    <th data-column-id="email">Email</th> \
                    <th data-column-id="contact">Contact</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.software_users.length;i++){

                var softwareUser = data.software_users[i];

                str = str + '<tr> \
                    <td>' + softwareUser.id + '</td> \
                    <td>' + softwareUser.name + '</td> \
                    <td>' + softwareUser.username + '</td> \
                    <td>' + softwareUser.email + '</td> \
                    <td>' + softwareUser.contact_number + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#software-user-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-software-user/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this software user?"))
                    return;

                $.getJSON(root + '/remove-software-user/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listSoftwareUsers(1);
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
        $('#software-user-list').html('No software users found');
}