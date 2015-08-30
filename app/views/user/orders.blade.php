<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage orders | Coboo</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.user.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}

    @include('includes.user.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    @include('includes.user.header')

    @include('includes.user.menu')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Orders
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div id='order-list' class='list-container'></div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/user/orders.js"))}}

<script type="text/javascript">
    $(function () {
        $(".orders").addClass('active');
    });
</script>
</body>
</html>
