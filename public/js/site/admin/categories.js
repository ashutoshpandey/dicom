$(function(){
    $("#form-create-category").find("input[name='btn-create']").click(createCategory);
    $("#form-create-subcategory").find("input[name='btn-create']").click(createSubCategory);

    listCategories(1);

    $("select[name='category']").change(function(){listSubCategories(1);});
});

function createCategory(){

    if(isCategoryFormValid()){

        var data = $("#form-create-category").serialize();

        $.ajax({
            url: root + '/save-category',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-category").find('.message').html('Duplicate name for category');
                }
                else if(result.message.indexOf('done')>-1){
                    $("#form-create-category").find('.message').html('Category created successfully');

                    $('#form-create-category').find('input[type="text"], textarea').val('');

                    listCategories();
                }
            }
        });
    }
}
function isCategoryFormValid(){
    return true;
}

function listCategories(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-list-categories/' + status,
        function(data){

            if(data.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showCategoryGrid(data);

                // for subcategory select
                if(data!=undefined && data.categories!=undefined && data.categories.length>0) {

                    $("select[name='category']").find('option').remove();

                    for (var i = 0; i < data.categories.length; i++) {

                        var category = data.categories[i];

                        $("select[name='category']").append("<option value='" + category.id + "'>" + category.name + "</option>");
                    }
                }

                listSubCategories(1);
            }
        }
    );
}
function showCategoryGrid(data){

    if(data!=undefined && data.categories!=undefined && data.categories.length>0){

        var str = '';

        str = str + '<table id="grid-category" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.categories.length;i++){

                var category = data.categories[i];

                str = str + '<tr> \
                    <td>' + category.id + '</td> \
                    <td>' + category.name + '</td> \
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
                var str= '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $('#category-list').find(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this category?"))
                    return;

                $.getJSON(root + '/remove-category/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1) {
                            listCategories(1);
                            listSubCategoryCategories(1);
                        }
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
        $('#category-list').html('No categories found');
}
function listSubCategories(page){

    var status = 'active';
    var categoryId = $("select[name='category']").val();

    $.getJSON(
        root + '/admin-list-subcategories/' + categoryId + '/' + status,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showSubCategoryGrid(result);
            }
        }
    );
}
function showSubCategoryGrid(data){

    if(data!=undefined && data.subcategories!=undefined && data.subcategories.length>0){

        var str = '';

        str = str + '<table id="grid-subcategory" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.subcategories.length;i++){

            var subcategory = data.subcategories[i];

            str = str + '<tr> \
                    <td>' + subcategory.id + '</td> \
                    <td>' + subcategory.name + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#subcategory-list').html(str);

        $("#grid-subcategory").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
        {
            $('#subcategory-list').find(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this sub-category?"))
                    return;

                $.getJSON(root + '/remove-subcategory/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listSubCategories();
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
        $('#subcategory-list').html('No subcategories found');
}

function createSubCategory(){

    if(isSubCategoryFormValid()){

        var data = $("#form-create-subcategory").serialize();

        $.ajax({
            url: root + '/save-subcategory',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $("#form-create-subcategory").find('.message').html('Duplicate name for sub-category');
                }
                else if(result.message.indexOf('done')>-1){
                    $("#form-create-subcategory").find('.message').html('Sub category created successfully');

                    $('#form-create-subcategory').find('input[type="text"], textarea').val('');

                    listSubCategories(1);
                }
            }
        });
    }
}
function isSubCategoryFormValid(){
    return true;
}
