var assignId;

var patientIds = Array();
var instituteIds = Array();
var connectionIds = Array();

var currentInstitute;

$(function(){

    listPatientRequests(1);

    $("input[name='btn-forward']").click(forwardRequest);

    $("input[name='btn-assign-request']").click(assignRequest);

    $("select[name='category_consultant']").change(loadConsultants);
    $("select[name='category_expert']").change(loadExperts);

    currentInstitute = $("#currentInstitute").attr('rel');

    loadConsultants();
    loadExperts();
});

function loadConsultants(){

    var category_id = $("select[name='category_consultant']").val();

    $.ajax({
        url: root + '/get-category-consultants/' + category_id,
        type: 'get',
        dataType: 'json',
        success: function(result){

            if (result.message.indexOf('not logged') > -1)
                window.location.replace(root);
            else {
                if(result.message!=undefined && result.message=="found"){

                    $("select[name='consultant_id']").find('option').remove();

                    for(var i=0;i<result.experts.length;i++){

                        var expert = result.experts[i];

                        $("select[name='consultant_id']").append("<option value='" + expert.id + "'>" + expert.name + "</option>");
                    }
                }
            }
        }
    });
}
function loadExperts(){

    var category_id = $("select[name='category_expert']").val();

    $.ajax({
        url: root + '/get-category-experts/' + category_id,
        type: 'get',
        dataType: 'json',
        success: function(result){

            if (result.message.indexOf('not logged') > -1)
                window.location.replace(root);
            else {
                if(result.message!=undefined && result.message=="found"){

                    $("select[name='expert_id']").find('option').remove();

                    for(var i=0;i<result.experts.length;i++){

                        var expert = result.experts[i];

                        $("select[name='expert_id']").append("<option value='" + expert.id + "'>" + expert.name + "</option>");
                    }
                }
            }
        }
    });
}

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
                    <th data-column-id="institute">Institute</th> \
                    <th data-column-id="patient">Patient</th> \
                    <th data-column-id="date">Date</th> \
                    <th data-column-id="status">Status</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.patientRequests.length;i++) {

                var request = data.patientRequests[i];

                var status = request.status;

                patientIds[request.id] = request.patient.id;
                instituteIds[request.id] = request.institute_id;
                connectionIds[request.id] = request.connection_id;

                if (connectionIds[request.id] != currentInstitute){
                    if (status == "consultation")
                        status = "Not assigned";
                    else if (status == "assigned")
                        status = "Assigned";
                    else if (status == "consultant replied")
                        status = "Pending from expert";
                    else if (status == "expert replied")
                        status = "Expert Replied";
                }
                else{
                    if(status!="quotation")
                        status = "Pending";
                    else
                        status = "Complete";
                }

                str = str + '<tr> \
                    <td>' + request.id + '</td> \
                    <td>' + request.sender_institute.name + '</td> \
                    <td>' + request.patient.name + '</td> \
                    <td>' + request.created_at + '</td> \
                    <td>' + status + '</td> \
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
                var str = "<a target='_blank' href='" + root + "/view-patient/" + patientIds[request.id] + "'><img src='" + root + "/public/images/patient.png' title='View Patient Information' class='table-icon'/></a>&nbsp;&nbsp; ";

                if(connectionIds[row.id] != currentInstitute) {
                    str += "<a target='_blank' href='" + root + "/view-institute/" + connectionIds[request.id] + "'><img src='" + root + "/public/images/institute.png' title='View Sender Institute Information' class='table-icon'/></a>&nbsp;&nbsp; ";

                    if (row.status == "Not assigned")
                        str += '<a class="assign" href="#" rel="' + row.id + '">Assign</a>';

                    else if (row.status == "Expert Replied") {
                        str += "<a class='view-consultant' href='#' rel='" + row.id + "'><img src='" + root + "/public/images/consultant.png' title='View Consultant Reply' class='table-icon'/></a>&nbsp;&nbsp; ";
                        str += "<a class='view-expert' href='#' rel='" + row.id + "'><img src='" + root + "/public/images/consultant.png' title='View Expert Reply' class='table-icon'/></a>&nbsp;&nbsp; ";
                        str += "<a target='_blank' href='" + root + "/quotation/" + row.id + "'><img src='" + root + "/public/images/quotation.png' title='View Quotation' class='table-icon'/></a>&nbsp;&nbsp; ";
                    }
                }
                else{
                    if (row.status == "Complete")
                        str += "<a target='_blank' href='" + root + "/quotation/" + row.id + "'><img src='" + root + "/public/images/quotation.png' title='View Quotation' class='table-icon'/></a>&nbsp;&nbsp; ";
                }

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".assign").click(function(){

                assignId = $(this).attr('rel');

                $('#assign-popup').modal();

            });

            $(".view-consultant").click(function(){

                var id = $(this).attr('rel');

                $.ajax({
                    url: root + '/get-admin-consultant-request-reply/' + id,
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
                    url: root + '/get-admin-expert-request-reply/' + id,
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
        });
    }
    else
        $('#request-list').html('No requests found');
}

function assignRequest(){

    var data = $("#form-assign-request").serialize();

    data = data + '&id=' + assignId;

    $.ajax({
        url: root + '/assign-request',
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
                    $(".message-assign").html("Request assigned");
                    listPatientRequests(1);
                }
            }
            else {
                alert("Invalid result returned by server");
            }
        }
    });
}