var expertId;

$(function(){

    expertId = $('#expert_id').attr('rel');

    $("input[name='btn-create-membership']").click(createMembership);
    $("input[name='btn-create-service']").click(createService);
    $("input[name='btn-create-achievement']").click(createAchievement);
    $("input[name='btn-create-social']").click(createSocial);
    $("input[name='btn-create-specialty']").click(createSpecialty);
    $("input[name='btn-create-qualification']").click(createQualification);
    $("input[name='btn-create-location']").click(createLocation);

    listMemberships(1);

    listServices(1);

    listAchievements(1);

    listSpecialties(1);

    listSocialProfiles(1);

    listQualifications(1);

    listLocations(1);

    $("#form-create-location").find("select[name='state']").change(function(){
        var value = $(this).val();

        var cityObject = $("#form-create-location").find("select[name='city']");

        loadCities(value, cityObject);
    });
});

function listMemberships(page){

    $("#form-create-membership").find('.message').html('');

    $.getJSON(
        root + '/data-expert-list-memberships/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showMemberships(result);
            }
        }
    );
}
function showMemberships(data){

    if(data!=undefined && data.memberships!=undefined && data.memberships.length>0){

        var str = '';

        str = str + '<table id="grid-memberships" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="details">Details</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.memberships.length;i++){

            var membership = data.memberships[i];

            str = str + '<tr> \
                    <td>' + membership.id + '</td> \
                    <td>' + membership.name + '</td> \
                    <td>' + membership.details + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#membership-list').html(str);

        $("#grid-memberships").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = "&nbsp;&nbsp; <a class='remove' href='#' rel='" + row.id + "'>Remove</a>";

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $('#membership-list').find(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove this membership?"))
                        return;

                    $.getJSON(root + '/remove-expert-membership-admin/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listMemberships(1);
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
        $('#membership-list').html('No memberships found');

}


function listLocations(page){

    $("#form-create-location").find('.message').html('');

    $.getJSON(
        root + '/data-expert-list-location/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showLocations(result);
            }
        }
    );
}
function showLocations(data){

    if(data!=undefined && data.locations!=undefined && data.locations.length>0){

        var str = '';

        str = str + '<table id="grid-locations" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Location</th> \
                    <th data-column-id="location">Address</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.locations.length;i++){

            var locationObj = data.locations[i];

            str = str + '<tr> \
                    <td>' + locationObj.id + '</td> \
                    <td>' + locationObj.location.city + ' - ' + locationObj.location.state + '</td> \
                    <td>' + locationObj.address + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#location-list').html(str);

        $("#grid-locations").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = "&nbsp;&nbsp; <a class='remove' href='#' rel='" + row.id + "'>Remove</a>";

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
        {
            $('#location-list').find(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this location?"))
                    return;

                $.getJSON(root + '/remove-expert-location-admin/' + id,
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


function listSpecialties(page){

    $("#form-create-specialty").find('.message').html('');

    $.getJSON(
        root + '/data-expert-list-specialties/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showSpecialties(result);
            }
        }
    );
}
function showSpecialties(data){

    if(data!=undefined && data.specialties!=undefined && data.specialties.length>0){

        var str = '';

        str = str + '<table id="grid-specialties" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="details">Detail</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.specialties.length;i++){

            var specialty = data.specialties[i];

            str = str + '<tr> \
                    <td>' + specialty.id + '</td> \
                    <td>' + specialty.name + '</td> \
                    <td>' + specialty.details + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#specialty-list').html(str);

        $("#grid-specialties").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = "&nbsp;&nbsp; <a class='remove' href='#' rel='" + row.id + "'>Remove</a>";

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $('#specialty-list').find(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove this specialty?"))
                        return;

                    $.getJSON(root + '/remove-expert-specialty-admin/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listSpecialties(1);
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
        $('#specialty-list').html('No specialties found');

}

function listServices(page){

    $("#form-create-service").find('.message').html('');

    $.getJSON(
        root + '/data-expert-list-services/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showServices(result);
            }
        }
    );
}
function showServices(data){

    if(data!=undefined && data.services!=undefined && data.services.length>0){

        var str = '';

        str = str + '<table id="grid-services" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="details">Details</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.services.length;i++){

            var service = data.services[i];

            str = str + '<tr> \
                    <td>' + service.id + '</td> \
                    <td>' + service.name + '</td> \
                    <td>' + service.details + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#service-list').html(str);

        $("#grid-services").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $('#service-list').find(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove this service?"))
                        return;

                    $.getJSON(root + '/remove-expert-service-admin/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listServices(1);
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
        $('#service-list').html('No services found');

}

function listAchievements(page){

    $("#form-create-achievement").find('.message').html('');

    $.getJSON(
        root + '/data-expert-list-achievements/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showAchievements(result);
            }
        }
    );
}
function showAchievements(data){

    if(data!=undefined && data.achievements!=undefined && data.achievements.length>0){

        var str = '';

        str = str + '<table id="grid-achievements" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="details">Details</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.achievements.length;i++){

            var achievement = data.achievements[i];

            str = str + '<tr> \
                    <td>' + achievement.id + '</td> \
                    <td>' + achievement.name + '</td> \
                    <td>' + achievement.details + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#achievement-list').html(str);

        $("#grid-achievements").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str ='&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $('#achievement-list').find(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove this achievement?"))
                        return;

                    $.getJSON(root + '/remove-expert-achievement-admin/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listAchievements(1);
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
        $('#achievement-list').html('No achievements found');

}

function listSocialProfiles(page){

    $("#form-create-social").find('.message').html('');

    $.getJSON(
        root + '/data-expert-list-social/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showSocials(result);
            }
        }
    );
}
function showSocials(data){

    if(data!=undefined && data.socials!=undefined && data.socials.length>0){

        var str = '';

        str = str + '<table id="grid-socials" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="url">URL</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.socials.length;i++){

            var social = data.socials[i];

            str = str + '<tr> \
                    <td>' + social.id + '</td> \
                    <td>' + social.name + '</td> \
                    <td>' + social.url + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#social-list').html(str);

        $("#grid-socials").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $('#social-list').find(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove this social record?"))
                        return;

                    $.getJSON(root + '/remove-expert-social-admin/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listSocials(1);
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
        $('#social-list').html('No social records found');

}

function startUpdatingExpert(){

    $("#ifr").load(function(){
        expertUpdated();
    });

    return true;
}

function expertUpdated(){

    $(".message").html("Expert updated successfully");
}

function isExpertFormValid(){
    return true;
}

function createMembership(){

    if(isMembershipFormValid()){

        var data = $("#form-create-membership").serialize();

        $.ajax({
            url: root + '/create-expert-membership-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-membership").find('.message').html('Duplicate membership');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Membership added successfully');

                    $("#form-create-membership").find("input[type='text']").val('');
                    $("#form-create-membership").find("textarea").val('');

                    listMemberships(1);
                }
            }
        });
    }
}
function isMembershipFormValid(){
    return true;
}


function createLocation(){

    if(isLocationFormValid()){

        var data = $("#form-create-location").serialize();

        $.ajax({
            url: root + '/create-expert-location-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate location');
                }
                else if(result.message.indexOf('done')>-1){
                    $("#form-create-location").find('.message').html('Location added successfully');

                    $("#form-create-location").find("input[type='text']").val('');
                    $("#form-create-location").find("textarea").val('');

                    listLocations(1);
                }
            }
        });
    }
}
function isLocationFormValid(){
    return true;
}

function createAchievement(){

    if(isAchievementFormValid()){

        var data = $("#form-create-achievement").serialize();

        $.ajax({
            url: root + '/create-expert-achievement-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-achievement").find('.message').html('Duplicate achievement');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Achievement added successfully');

                    $("#form-create-achievement").find("input[type='text']").val('');
                    $("#form-create-achievement").find("textarea").val('');

                    listAchievements(1);
                }
            }
        });
    }
}
function isAchievementFormValid(){
    return true;
}


function createSpecialty(){

    if(isSpecialtyFormValid()){

        var data = $("#form-create-specialty").serialize();

        $.ajax({
            url: root + '/create-expert-specialty-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-speciality").find('.message').html('Duplicate specialty');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Specialty added successfully');

                    $("#form-create-specialty").find("input[type='text']").val('');
                    $("#form-create-specialty").find("textarea").val('');

                    listSpecialties(1);
                }
            }
        });
    }
}
function isSpecialtyFormValid(){
    return true;
}


function createService(){

    if(isServiceFormValid()){

        var data = $("#form-create-service").serialize();

        $.ajax({
            url: root + '/create-expert-service-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-service").find('.message').html('Duplicate service');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Service added successfully');

                    $("#form-create-service").find("input[type='text']").val('');
                    $("#form-create-service").find("textarea").val('');

                    listServices(1);
                }
            }
        });
    }
}
function isServiceFormValid(){
    return true;
}


function createSocial(){

    if(isSocialFormValid()){

        var data = $("#form-create-social").serialize();

        $.ajax({
            url: root + '/create-expert-social-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-achievement").find('.message').html('Duplicate social entry');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Social information added successfully');

                    $("#form-create-social").find("input[type='text']").val('');
                    $("#form-create-social").find("textarea").val('');

                    listSocialProfiles(1);
                }
            }
        });
    }
}
function isQualificationFormValid(){
    return true;
}


function createQualification(){

    if(isQualificationFormValid()){

        var data = $("#form-create-qualification").serialize();

        $.ajax({
            url: root + '/create-expert-qualification-admin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-qualification").find('.message').html('Duplicate qualification');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Qualification added successfully');

                    $("#form-create-qualification").find("input[type='text']").val('');
                    $("#form-create-qualification").find("textarea").val('');

                    listQualifications(1);
                }
            }
        });
    }
}
function isQualificationFormValid(){
    return true;
}

function listQualifications(page){

    $("#form-create-qualification").find('.message').html('');

    $.getJSON(
        root + '/data-expert-list-qualification/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showQualifications(result);
            }
        }
    );
}
function showQualifications(data){

    if(data!=undefined && data.qualifications!=undefined && data.qualifications.length>0){

        var str = '';

        str = str + '<table id="grid-qualifications" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="detail">Description</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.qualifications.length;i++){

            var qualification = data.qualifications[i];

            str = str + '<tr> \
                    <td>' + qualification.id + '</td> \
                    <td>' + qualification.name + '</td> \
                    <td>' + qualification.description + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#qualification-list').html(str);

        $("#grid-qualifications").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
        {
            $('#qualification-list').find(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this social record?"))
                    return;

                $.getJSON(root + '/remove-expert-qualification-admin/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listQualifications(1);
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
        $('#qualification-list').html('No qualification found');

}

function loadCities(state,destination){

    $.ajax({
        url: root + '/admin-get-cities/' + state,
        type: 'get',
        dataType: 'json',
        success: function(result){

            $("select[name='city']").find('option').remove();

            if(result.message=="found"){

                for(var i=0; i<result.locations.length; i++){

                    var location = result.locations[i];

                    destination.append('<option value="' + location.id + '">' + location.city + '</option>');
                }
            }
        }
    });
}