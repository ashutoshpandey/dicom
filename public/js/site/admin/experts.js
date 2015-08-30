$(function(){
    listExperts(1);
});

function startCreatingExpert(){

    $("#ifr").load(function(){
        expertCreated();
    });

    return true;
}

function expertCreated(){

    $(".message").html("Expert created successfully");

    $("input[type='text'], input[type='password'], input[type='email'], textarea").val('');

    listExperts(1);
}

function listExperts(page){

    var expertId = $('.expert-id').attr('rel');
    var status = 'active';

    $.getJSON(
        root + '/admin-list-experts/' + status + '/' + page,
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

    if(data!=undefined && data.experts!=undefined && data.experts.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="author">Email</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.experts.length;i++){

            var expert = data.experts[i];

            str = str + '<tr> \
                    <td>' + expert.id + '</td> \
                    <td>' + expert.first_name + ' ' + expert.last_name + '</td> \
                    <td>' + expert.email + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

    $('#expert-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-expert/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this expert?"))
                    return;

                $.getJSON(root + '/remove-expert/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listExperts(1);
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
        $('#expert-list').html('No experts found');

}