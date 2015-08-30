<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | One stop destination for your course books</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/home.css"))}}
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
    </section>

</div>
<!-- ./wrapper -->

    @include('includes.footer')
    {{HTML::script(asset("/public/js/site/search.js"))}}

</body>
</html>
