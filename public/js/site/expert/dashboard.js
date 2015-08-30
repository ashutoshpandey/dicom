$(document).ready(function(){

    startClock();

    setInterval(startClock, 1000);
    /* table sorter plugin */
    $("#myTable").tablesorter();

    /* plugin for calendar */
    $('#calendar').fullCalendar({
        // http://fullcalendar.io/docs/event_data/events_json_feed/
    });

    /* **************JS FOR DASHBOARD******************* */

    $(".toggle_calendar").click(function(){
        $(".calendar_container").addClass("active");
    });
    $(".close_calendar").click(function(){
        $(".calendar_container").removeClass("active");
    });
    $("body").click(function(e){
        $(".appointment_modes .modes").hide();
    });
    $("caption .appointment_modes .selected_mode p").click(function(e){
        e.stopPropagation();
        $(this).closest(".appointment_modes").find(".modes").toggle();
    });
    $("caption .appointment_modes .modes p").click(function(e){
        e.stopPropagation();
       var text = $(this).html();
        $("caption .appointment_modes .selected_mode p").html(text);
        $("caption .appointment_modes .modes").hide();
    });

    /* **************JS FOR PROFILE PAGE******************* */

    $(".edit_detail input[type='text']#tags").keyup(function(e){
        if(e.keyCode == 13) {
            var value = $(this).val();
            if (value != "") {
                var tag = "<span onclick='$(this).remove();'>"+ value +"</span>";
                var current_html = $(this).next().html();
                $(this).next().html(current_html + tag);
                $(this).val("");
            }
        }
    });




});

function startClock(){
    var date = new Date();
    var meridian = "AM";
    var date_string = date.toDateString();
    var time_minutes = date.getMinutes();
    var time_seconds = date.getSeconds();
    var time_hours = date.getHours();

    if(time_hours>12){
        time_hours = time_hours -12;
        meridian = "PM";
    }

    if(time_minutes<10){
        time_minutes = "0"+time_minutes;
    }

    if(time_hours<10){
        time_hours = "0"+time_hours;
    }

    if(time_seconds<10){
        time_seconds = "0" + time_seconds;
    }

    var time_string = time_hours+":"+time_minutes+":"+time_seconds+" "+meridian;

    $(".column.date").html(date_string);
    $(".digital_clock").html(time_string);
}


