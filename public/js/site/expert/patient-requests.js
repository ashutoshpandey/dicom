var requestId;
var currentExpertId;

var patientIds = Array();
var consultantIds = Array();

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
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.patientRequests.length;i++){

                var request = data.patientRequests[i];

                patientIds[request.id] = request.patient.id;
                consultantIds[request.id] = request.consultant_id;

                var status = request.status;

                if(consultantIds[request.id]==currentExpertId){     // consultant login
                    if (status == "assigned")
                        status = "Please reply";
                    else if (status == "consultant replied")
                        status = "Replied";
                    else if (status == "expert replied")
                        status = "Replied";
                }
                else {
                    if (status == "consultation")
                        status = "Not assigned";
                    else if (status == "assigned")
                        status = "Please reply";
                    else if (status == "consultant replied")
                        status = "Consultant Replied";
                    else if (status == "expert replied")
                        status = "Replied";
                }

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
                var str = "<a target='_blank' href='" + root + "/view-patient/" + patientIds[row.id] + "'><img src='" + root + "/public/images/patient.png' title='View Patient Information' class='table-icon'/></a>&nbsp;&nbsp; ";
//                str += "<a target='_blank' href='" + root + "/view-institute/" + row.id + "'><img src='" + root + "/public/images/institute.png' title='View Sender Institute Information' class='table-icon'/></a>&nbsp;&nbsp; ";

                if(row.status=="Please reply")
                    str += '<a class="reply" href="#" rel="' + row.id + '">Reply</a>';

                if(consultantIds[row.id] != currentExpertId) {                  // if expert logged in
                    if (row.status == "Consultant Replied") {
                        str += "<a class='view-consultant' href='#' rel='" + row.id + "'><img src='" + root + "/public/images/consultant.png' title='View Consultant Reply' class='table-icon'/></a>&nbsp;&nbsp; ";
                        str += '<a class="reply" href="#" rel="' + row.id + '">Reply</a>';
                    }
                    else if (row.status == "Replied") {
                        str += "<a class='view-consultant' href='#' rel='" + row.id + "'><img src='" + root + "/public/images/consultant.png' title='View Consultant Reply' class='table-icon'/></a>&nbsp;&nbsp; ";
                        str += "<a class='view-expert' href='#' rel='" + row.id + "'><img src='" + root + "/public/images/consultant.png' title='View Expert Reply' class='table-icon'/></a>&nbsp;&nbsp; ";
                    }
                }
                else{           // consultant logged in
                    if (row.status == "Replied") {
                        str += "<a class='view-consultant' href='#' rel='" + row.id + "'><img src='" + root + "/public/images/consultant.png' title='View Consultant Reply' class='table-icon'/></a>&nbsp;&nbsp; ";
                    }
                }

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".view-consultant").click(function(){

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

            $(".view-expert").click(function(){

                var id = $(this).attr('rel');

                $.ajax({
                    url: root + '/get-expert-request-reply/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(result){

                        var str = result.requestReply.comment;
                        str = str.replace(/(?:\r\n|\r|\n)/g, '<br />');

                        $(".expert-reply").html(str);
                        $(".expert-reply-date").html(result.requestReply.created_at);

                        $("#expert-reply-popup").modal();
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