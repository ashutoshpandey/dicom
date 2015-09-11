<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Institutes</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.admin.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}
    {{HTML::style(asset("/public/css/quotation.css"))}}

    @include('includes.admin.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    @include('includes.admin.header')

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Quotation
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{$root}}/admin-section"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Institutes</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>

                    <div id='form-container'>
                        @include('includes.quotation', array('quoted' => $quoted))
                    </div>

            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/quotation.js"))}}
<script type="text/javascript">
    $(function () {
        $(".institutes").addClass('active');
    });
</script>
</body>
</html>
