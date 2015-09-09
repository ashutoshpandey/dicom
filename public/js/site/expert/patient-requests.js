var requestId;
var currentExpertId;

$(function(){

    listPatientRequests(1);

    $("input[name='btn-reply-request']").click(replyRequest);

    currentExpertId = $(".current_expert_id").attr('rel');
});

function listPatientRequests(page){

    var status = 'active';

    $.getJSON(
        root + '/get-expert-requests',
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
                    <th data-column-id="institute">Sender Institute</th> \
                    <th data-column-id="patient">Patient</th> \
                    <th data-column-id="date">Date</th> \
                    <th data-column-id="status">Status</th> \
                    <th data-formatter="link">Action</th> \
                    <th data-formatter="extra"></th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.patientRequests.length;i++){

                var request = data.patientRequests[i];

                var status = request.status;

                if(status=="consultation")
                    status = "Not assigned";
                else if(status=="assigned")
                    status = "Please reply";
                else if(status=="consultant replied")
                    status = "Replied";
                else if(status=="expert replied")
                    status = "Complete";

                str = str + '<tr> \
                    <td>' + request.id + '</td> \
                    <td>' + request.sender_institute.name + '</td> \
                    <td>' + request.patient.name + '</td> \
                    <td>' + request.created_at + '</td> \
                    <td>' + status + '</td> \
                    <td></td> \
                    <td>' + request.patient_id + ':' + request.consultant_id + ':' + request.expert_id + '</td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#request-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/expert-view-patient/' + row.id + '">Patient</a>&nbsp;&nbsp; ';
                str += '<a target="_blank" href="' + root + '/expert-view-institute/' + row.id + '">Institute</a>&nbsp;&nbsp; ';

                if(row.status=="Please reply")
                    str += '<a class="reply" href="#" rel="' + row.id + '">Reply</a>';

                else if(row.status=="Replied" && row.consultant_id != currentExpertId) {
                    str += '<a class="view" href="#" rel="' + row.id + '">View</a>&nbsp;&nbsp; ';
                    str += '<a class="reply" href="#" rel="' + row.id + '">Reply</a>';
                }

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".view").click(function(){

                var id = $(this).attr('rel');

                $.ajax({
                    url: root + '/get-consultant-request-reply/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(result){
                        $(".consultant-reply").html(result.requestReply.comment);
                        $(".consultant-reply-date").html(result.requestReply.created_at);

                        $("#consultant-reply-popup").modal();
                    }
                });
            });

            $(".reply").click(function(){

                requestId = $(this).attr('rel');

                $('#reply-popup').modal();

            });
        });
    }
    else
        $('#request-list').html('No requests found');
}

function replyRequest(){

    var data = $("#form-reply-request").serialize();

    data = data + '&id=' + requestId;

    $.ajax({
        url: root + '/reply-request',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function(result){

            if(result.message != undefined){

                if(result.message.indexOf("not logged")>-1) {
                    alert("You are logged out");
                    window.location.replace = root;
                }
                else if(result.message.indexOf("done")>-1) {
                    $(".message-assign").html("Reply added successfully");
                    listPatientRequests(1);
                }
            }
            else {
                alert("Invalid result returned by server");
            }
        }
    });
}