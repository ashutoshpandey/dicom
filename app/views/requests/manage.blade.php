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

    @include('includes.admin.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    @include('includes.admin.header')

    @include('includes.menu')

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Patient Requests
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{$root}}/admin-section"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Patient Requests</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <div id='request-list' class='list-container'></div>
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes.admin.assign-popup')
@include('includes.common_js_bottom')
@include('includes.expert.consultant-reply-popup')
@include('includes.expert.expert-reply-popup')
<span id="currentInstitute" rel="{{$currentInstitute}}">&nbsp;</span>
{{HTML::script(asset("/public/js/site/jquery.simplemodal.js"))}}
{{HTML::script(asset("/public/js/site/admin/patient-requests.js"))}}
<script type="text/javascript">
    $(function () {
        $(".requests").addClass('active');
    });
</script>
</body>
</html>
