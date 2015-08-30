<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing institutes</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/home.css"))}}
    {{HTML::style(asset("/public/css/site/institutes.css"))}}
    {{HTML::style(asset("/public/css/site/grid-list.css"))}}
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"/>

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>
        @include('includes.search')

        <div class="container institutes-list">

            @if(isset($institutes))

            <div class="grid-info row">
                <div class="col-md-12">
                    {{--<div class="top-menu">--}}
                        {{--<ul>--}}
                            {{--<li id="grid">{{ HTML::image('public/images/grid.png', 'grid-icon') }}</li>--}}
                            {{--<li id="list">{{ HTML::image('public/images/list.png', 'list-icon') }}</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    <div style="clear:both"></div>
                    <ul id="content">

                        @foreach($institutes as $institute)

                        <li class="data">
                            <div class="name-date">
                                <span class="name">{{$institute->name}}</span><span class="date">{{date('d-M-Y', strtotime($institute->establish_date))}}</span>
                            </div>
                            <div class="add-map">
                                <span class="add">{{$institute->address}}, {{$institute->location->city}}, {{$institute->location->state}}<br/>	<a target="_blank" href="{{$root}}/courses/{{$institute->id}}">View Courses</a> </span>
                                <span class="map">{{ HTML::image('public/images/map.jpg', 'map-icon') }}</span>
                            </div>
                        </li>

                        @endforeach

                    </ul>

                    {{--<div id="popup_div">--}}
                        {{--Test the dialog--}}
                        {{--<br/>--}}
                        {{--<button id="btnClose">Close</button>--}}
                    {{--</div>--}}

                    <div id='page_navigation'></div>
                    <input type='hidden' id='current_page'/>
                    <input type='hidden' id='show_per_page'/>
                </div>
            </div>

            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/institutes.js"))}}
{{HTML::script(asset("/public/js/site/search.js"))}}

</body>
</html>
