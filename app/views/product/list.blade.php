<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing Books</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/grid-list.css"))}}
    {{HTML::style(asset("/public/css/site/products.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container">

            <h3>Showing courses for: {{$course->institute->name}} -> {{$course->name}}</h3>
            <br/><br/>

            @if($found)

            <div class="grid-info row">
                <div class="col-md-2">
                    <div class="subject-list">
                        @if(isset($subjects))

                            @foreach($subjects as $subject)

                                <div><label><input type="checkbox" name="subject" value="{{$subject['subject']}}"/> {{$subject['subject']}}</label></div>

                            @endforeach

                        @endif
                    </div>
                </div>

                <div class="col-md-10 product-list" rel="{{$course->id}}">

                    <label><input type="checkbox" name="select-all"/> Select all products</label> <br/>

                    <ul id="content">

                        @foreach($products as $product)

                        <li class="data">
                            <div class="name-date">
                                <span class="name">{{$product->name}}</span>
                                <br/>
                                {{$currency}} {{$product->price}}
                                <br/>
                                By <b>{{$product->author}}</b> <br/><br/>
<!--                                <label><input type="checkbox" name="pick-product" value="{{$product->id}}"/> Pick this product </label>-->
                                @if($product->added=='y')
                                    <span class="added-to-bag" rel="{{$product->id}}">In bag</span>
                                @else
                                    <span class="add-to-bag" rel="{{$product->id}}">Add to bag</span>
                                @endif
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
                <h2>No products found</h2>
            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/products.js"))}}

</body>
</html>
