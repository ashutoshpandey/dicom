<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | View Patient</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.admin.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}

    @include('includes.admin.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px !important;">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <h1>
                Patient: {{$patient->name}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class='tab-container'>


                <div id='form-container'>
                        <form id='form-update-patient'>
                            <div class='form-row'>
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    {{$patient->name}}
                                </div>
                                <div class='form-label'>Gender</div>
                                <div class='form-data'>
                                    {{$patient->gender}}
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Email</div>
                                <div class='form-data'>
                                    {{$patient->email}}
                                </div>
                                <div class='form-label'>Contact Number</div>
                                <div class='form-data'>
                                    {{$patient->contact_number}}
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Country</div>
                                <div class='form-data'>
                                    {{$patient->country}}
                                </div>
                                <div class='form-label'>Referred by</div>
                                <div class='form-data'>
                                    {{$patient->institute->name}}
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>

            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
</body>
</html>