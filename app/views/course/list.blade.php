<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing Courses</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/home.css"))}}
    {{HTML::style(asset("/public/css/site/institutes.css"))}}
    {{HTML::style(asset("/public/css/site/grid-list.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container course-list">

            <h3>Showing courses for: {{$institute->name}}</h3>

            @if(isset($courses))

            <div class="grid-info row">
                <div class="col-md-8">
                    <ul id="content">

                        @foreach($courses as $course)

                        <li class="data">
                            <div class="name-date">
                                <span class="name">{{$course->name}}</span></span>
                            </div>
                            <div class="add-map">
                                <span class="add">{{$course->description}}<br/>	<a target="_blank" href="{{$root}}/products/{{$course->id}}">View Books</a> </span>
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

            @else
                <h2>No courses found</h2>
            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/courses.js"))}}

</body>
</html>
