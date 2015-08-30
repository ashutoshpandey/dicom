$(function(){
    listAppointments(1);
});

function listAppointments(page){

    var status = 'active';

    $.getJSON(
        root + '/expert-list-appointments/' + status + '/' + page,
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

    if(data!=undefined && data.appointments!=undefined && data.appointments.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="expert">Expert</th> \
                    <th data-column-id="customer">Customer</th> \
                    <th data-column-id="type">Type</th> \
                    <th data-column-id="date">Date</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.appointments.length;i++){

                var appointment = data.appointments[i];

                var customerName = appointment.user.first_name + ' ' + appointment.user.last_name;
                var expertName = appointment.expert.first_name + ' ' + appointment.expert.last_name;

                var varDate = appointment.appointment_date;
                var arDate = varDate.split(' ');

                var appointmentDate = arDate[0] + ' ' + arDate[1];

                str = str + '<tr> \
                    <td>' + appointment.id + '</td> \
                    <td>' + expertName + '</td> \
                    <td>' + customerName + '</td> \
                    <td>' + appointment.appointment_type + '</td> \
                    <td>' + appointmentDate + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#appointment-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-appointment/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Cancel</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to cancel this appointment?"))
                    return;

                $.getJSON(root + '/cancel-admin-appointment/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listAppointments(1);
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
        $('#appointment-list').html('No appointments found');
}