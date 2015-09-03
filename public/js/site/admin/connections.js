$(function(){
    $("input[name='btn-create']").click(createConnection);

    listConnections(1);
});

function createConnection(){

    if(isConnectionFormValid()){

        var data = $("#form-create-connection").serialize();

        $.ajax({
            url: root + '/save-connection',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate connection');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Connection created successfully');

                    listConnections(1);
                }
            }
        });
    }
}
function isConnectionFormValid(){

    var connection_id = $("select[name='connection_id']").val();
    var institute_id = $("select[name='institute_id']").val();

    $('.message').html('');

    if(connection_id==institute_id){
        $('.message').html('Choose different institutes');
        return false;
    }

    return true;
}

function listConnections(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-get-connections/' + status + '/' + page,
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

    if(data!=undefined && data.connections!=undefined && data.connections.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Institute</th> \
                    <th data-column-id="email">Connected To</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.connections.length;i++){

                var connection = data.connections[i];

                str = str + '<tr> \
                    <td>' + connection.id + '</td> \
                    <td>' + connection.connection_to + ' &mdash; ' + connection.connection_to_location + '</td> \
                    <td>' + connection.connection_from + ' &mdash; ' + connection.connection_from_location + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#connection-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this connection?"))
                    return;

                $.getJSON(root + '/remove-connection/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listConnections(1);
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
        $('#connection-list').html('No connections found');
}
