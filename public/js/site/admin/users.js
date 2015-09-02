$(function(){

    listUsers(1);
});

function createUser(){

    if(isUserFormValid()){

        var data = $("#form-create-user").serialize();

        $.ajax({
            url: root + '/save-user',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('User created successfully');

                    $('#form-container').find('input[type="text"],input[type="password"],input[type="email"], textarea').val('');

                    listUsers(1);
                }
            }
        });
    }
}
function isUserFormValid(){
    return true;
}

function listUsers(page){

    var status = 'active';

    $.getJSON(
        root + '/list-users/' + status + '/' + page,
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

    if(data!=undefined && data.users!=undefined && data.users.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="email">Email</th> \
                    <th data-column-id="contact">Contact</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.users.length;i++){

                var user = data.users[i];

                str = str + '<tr> \
                    <td>' + user.id + '</td> \
                    <td>' + user.first_name + ' ' + user.last_name + '</td> \
                    <td>' + user.email + '</td> \
                    <td>' + user.contact_number + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#user-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-user/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this user?"))
                    return;

                $.getJSON(root + '/remove-user/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listUsers(1);
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
        $('#user-list').html('No users found');
}