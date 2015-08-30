$(function(){
    $("input[name='btn-create']").click(createLocation);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listLocations(1);
});

function createLocation(){

    if(isLocationFormValid()){

        var data = $("#form-create-location").serialize();

        $.ajax({
            url: root + '/save-location',
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
                    $('.message').html('Location created successfully');

                    $('#form-container').find('input[type="text"],input[type="password"],input[type="email"], textarea').val('');

                    listLocations(1);
                }
            }
        });
    }
}
function isLocationFormValid(){
    return true;
}

function listLocations(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-list-locations/' + status + '/' + page,
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

    if(data!=undefined && data.locations!=undefined && data.locations.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="city">City</th> \
                    <th data-column-id="state">State</th> \
                    <th data-column-id="pin">Pin</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.locations.length;i++){

                var location = data.locations[i];

                str = str + '<tr> \
                    <td>' + location.id + '</td> \
                    <td>' + location.city + '</td> \
                    <td>' + location.state + '</td> \
                    <td>' + location.pin + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#location-list').html(str);

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

                if(!confirm("Are you sure to remove this location?"))
                    return;

                $.getJSON(root + '/remove-location/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listLocations(1);
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
        $('#location-list').html('No locations found');
}