var expertId;

$(function(){

    expertId = $('#expert_id').attr('rel');

    $("input[name='btn-update-expert']").click(updateExpert);
    $("input[name='btn-create-service']").click(createService);
    $("input[name='btn-create-category']").click(createCategory);
    $("input[name='btn-create-qualification']").click(createQualification);

    getCategories();

    listServices(1);

    listCategories(1);

    listQualifications(1);
});


function getCategories(){

    $.getJSON(
        root + '/categories',
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                if(result.categories!=undefined && result.categories.length>0){

                    for(var i=0;i<result.categories.length;i++){

                        var category = result.categories[i];

                        $("select[name='category']").append("<option value='" + category.id + "'>" + category.name + "</option>");
                    }

                    getSubcategories();

                    $("select[name='category']").change(getSubcategories);
                }
            }
        }
    );
}

function getSubcategories(){

    var categoryId = $("select[name='category']").val();

    $.getJSON(
        root + '/subcategories/' + categoryId,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                if(result.subcategories!=undefined && result.subcategories.length>0){

                    for(var i=0;i<result.subcategories.length;i++){

                        var subcategory = result.subcategories[i];

                        $("select[name='subcategory']").append("<option value='" + subcategory.id + "'>" + subcategory.name + "</option>");
                    }
                }
            }
        }
    );
}

function listCategories(page){

    $("#form-create-category").find('.message').html('');

    $.getJSON(
        root + '/admin-data-expert-categories/' + expertId + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showCategories(result);
            }
        }
    );
}
function showCategories(result){

    if(result!=undefined && result.categories!=undefined && result.categories.length>0){

        var str = '';

        str = str + '<table id="grid-category" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">Id</th> \
                    <th data-column-id="category">Category</th> \
                    <th data-column-id="subcategory">SubCategory</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<result.categories.length;i++){

            var data = result.categories[i];

            str = str + '<tr> \
                    <td>' + data.id + '</td> \
                    <td>' + data.category.name + '</td> \
                    <td>' + data.subcategory.name + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#category-list').html(str);

        $("#grid-category").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = "&nbsp;&nbsp; <span style='cursor:pointer;color:blue' class='remove' rel='" + row.id + "'>Remove</a>";

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $('#category-list').find(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove expert from this category?"))
                        return;

                    $.getJSON(root + '/remove-expert-category/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listCategories(1);
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
        $('#category-list').html('No categories assigned');

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

function isExpertFormValid(){
    return true;
}

function createCategory(){

    if(isCategoryFormValid()){

        var data = $("#form-create-category").serialize();

        $.ajax({
            url: root + '/assign-expert-category',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-membership").find('.message').html('Duplicate category');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Category added successfully');

                    $("#form-create-category").find("input[type='text']").val('');
                    $("#form-create-category").find("textarea").val('');

                    listCategories(1);
                }
            }
        });
    }
}
function isCategoryFormValid(){
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

function updateExpert(){

    var data = $("#form-update-expert").serialize();

    $.ajax({
        url: root + '/update-institute-expert',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function(result) {

            if (result.message.indexOf('not logged') > -1)
                window.location.replace(root);
            else if (result.message.indexOf('done') > -1)
                $('.message-update').html("Expert updated successfully");
            else if (result.message.indexOf('duplicate') > -1)
                $('.message-update').html("Email is already used");
            else
                $('.message-update').html("Server returned error");
        }
    });
}
