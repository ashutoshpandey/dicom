$(function () {

    $("#btn-search").click(function(){

        var location = $("input[name='location']").val();
        var search = $("input[name='search']").val();

        if(location.trim().length==0 && search.trim().length==0){
            var color = $(this).css('background-color');
            $(this).css('background-color', 'red');

            setTimeout(function(){
                $("#btn-search").css('background-color', color);
            },2000);

            return;
        }

        $("#form-search").attr('method', 'post');
        $("#form-search").attr('action', root + '/experts');
        $("#form-search").submit();
    });

    $("input[name='location']").autocomplete({
        source: function (request, response) {
            $.ajax({
                type: 'GET',
                url: root + '/search-cities/' + request.term,
                dataType: "json",
                success: function (data) {

                    if(data.message=="found") {

                        $(".locations").html('');

                        for (var i = 0; i < data.locations.length; i++) {

                            var location = data.locations[i];

                            var place = location.city + " - " + location.state;

                            $(".locations").append("<p rel='" + location.id + "' title='" + place + "'><span class='fa fa-map-marker'></span> " + place + "</p>")
                        }

                        $(".locations").find('p').unbind('click');
                        $(".locations").find('p').click(function(){
                            var location = $(this).attr('title');
                            var id = $(this).attr('rel');

                            $("input[name='location']").val(location);
                            $("input[name='search-city']").val(id);
                        });
                    }
                }
            })
        },
        minLength: 2,
        delay: 100
    });

    $("input[name='search']").autocomplete({
        source: function (request, response) {

            var url;
            var cityId = $("#search-city").val();

            if(cityId==undefined || cityId.length==0)
                url = root + '/search-keyword/' + request.term;
            else
                url = root + '/search-keyword/' + request.term + '/' + cityId;

            $.ajax({
                type: 'GET',
                url: url,
                dataType: "json",
                success: function (result) {

                    if(result.message=="found") {

                        $(".search_content").html('');

                        for (var i = 0; i < result.data.length; i++) {

                            var row = result.data[i];

                            $(".search_content").append("<p class='group_" + row.group + "' rel='" + row.id + "' title='" + row.name + "'><b>" + row.name + "</b> in " + row.group + "</p>")
                        }

                        $(".search_content").find('p').unbind('click');
                        $(".search_content").find('p').click(function(){
                            var location = $(this).attr('title');
                            var id = $(this).attr('rel');

                            $("input[name='search']").val(location);
                            $("input[name='search-keyword']").val(id);
                        });
                    }
                }
            })
        },
        minLength: 2,
        delay: 100,
        select: function(event, ui){
            alert(ui.item.id);
        }
    });
});