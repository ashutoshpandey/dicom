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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px !important;">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <h1>
                Institute: {{$institute->name}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <div id='tab-create'>
                    <div id='form-container'>

                            <div class='form-row'>
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    {{$institute->name}}
                                </div>
                                <div class='form-label'>Establish Date</div>
                                <div class='form-data'>
                                    {{date('m/d/Y', strtotime($institute->establish_date))}}
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Address</div>
                                <div class='form-data'>
                                    {{$institute->address}}
                                </div>
                                <div class='form-label'>Landmark</div>
                                <div class='form-data'>
                                    {{$institute->land_mark}}
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>State</div>
                                <div class='form-data'>
                                    {{$institute->state}}
                                </div>
                                <div class='form-label'>City</div>
                                <div class='form-data'>
                                    {{$institute->city}}
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Zip</div>
                                <div class='form-data'>
                                    {{$institute->zip}}&nbsp;
                                </div>
                                <div class='form-label'>Country</div>
                                <div class='form-data'>
                                    {{$institute->country}}
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Contact number 1</div>
                                <div class='form-data'>
                                    {{$institute->contact_number_1}}
                                </div>
                                <div class='form-label'>Contact number 2</div>
                                <div class='form-data'>
                                    {{$institute->contact_number_2}}
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Latitude / Longitude</div>
                                <div class='form-data'>
                                    {{$institute->latitude}} / {{$institute->longitude}}
                                </div>
                                <div class='clear'></div>
                            </div>
                    </div>
                </div>
            </div>

        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->
@include('includes/common_js_bottom')
</body>
</html>
