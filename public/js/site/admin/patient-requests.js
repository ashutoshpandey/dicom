$(function(){

    listPatientRequests(1);

    $("input[name='btn-forward']").click(forwardRequest);
});

function forwardRequest(){

    var frm = $("#form-forward-request").serialize();

    $(".forward-message").html("");

    $.ajax({
        url: root + '/forward-patient-request',
        type: 'post',
        success: function(result){

            if (result.message.indexOf('not logged') > -1)
                window.location.replace(root);
            else {
                $(".forward-message").html("Request forwarded successfully");
            }
        }
    });
}

function listPatientRequests(page){

    var status = 'active';

    $.getJSON(
        root + '/patient-requests',
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

    if(data!=undefined && data.patientRequests!=undefined && data.patientRequests.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Institute</th> \
                    <th data-column-id="email">Patient</th> \
                    <th data-column-id="contact">Date</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.patientRequests.length;i++){

                var request = data.patientRequests[i];

                str = str + '<tr> \
                    <td>' + request.id + '</td> \
                    <td>' + request.sender_institute.name + '</td> \
                    <td>' + request.patient.name + '</td> \
                    <td>' + request.created_at + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#request-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-institute-patient/' + row.patient_id + '">Patient</a>&nbsp;&nbsp; ';
                str += '<a target="_blank" href="' + root + '/admin-view-institute/' + row.institute_id + '">Institute</a>&nbsp;&nbsp; ';
                str += '<a class="assign" href="#" rel="' + row.id + '">Assign</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".assign").click(function(){
                var id = $(this).attr("rel");

                var data = $("#form-assign").serialize();

                data = data + '&id=' + id;

                $.ajax({
                    url: root + '/assign-request',
                    type: 'post',
                    data: data,
                    success: function(result){

                        if(result.message != undefined){

                            if(result.indexOf("not logged")>-1) {
                                alert("You are logged out");
                                window.location.replace = root;
                            }
                            else if(result.indexOf("done")>-1) {
                                $(".message-assign").html("Request assigned");
                                listPatientRequests(1);
                            }
                        }
                        else {
                            alert("Invalid result returned by server");
                        }
                    }
                });
            });
        });
    }
    else
        $('#request-list').html('No requests found');
}
