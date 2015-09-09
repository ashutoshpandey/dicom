var assignId;

$(function(){

    listPatientRequests(1);

    $("input[name='btn-forward']").click(forwardRequest);

    $("input[name='btn-assign-request']").click(assignRequest);

    $("select[name='category_consultant']").change(loadConsultants);
    $("select[name='category_expert']").change(loadExperts);

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

            for(var i =0;i<data.patientRequests.length;i++){

                var request = data.patientRequests[i];

                var status = request.status;

                if(status=="consultation")
                    status = "Not assigned";
                else if(status=="assigned")
                    status = "Assigned";
                else if(status=="consultant replied")
                    status = "Pending from expert";
                else if(status=="expert replied")
                    status = "Expert Replied";

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
                var str = '<a target="_blank" href="' + root + '/admin-view-institute-patient/' + row.patient_id + '">Patient</a>&nbsp;&nbsp; ';
                str += '<a target="_blank" href="' + root + '/admin-view-institute/' + row.institute_id + '">Institute</a>&nbsp;&nbsp; ';

                if(row.status=="Not assigned")
                    str += '<a class="assign" href="#" rel="' + row.id + '">Assign</a>';

                else if(row.status=="Expert Replied")
                    str += '<a class="quotation" href="#" rel="' + row.id + '">Quotation</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".assign").click(function(){

                assignId = $(this).attr('rel');

                $('#assign-popup').modal();

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