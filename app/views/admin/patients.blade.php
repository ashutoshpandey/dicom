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

    @include('includes.admin.super-menu')

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage [<span style="text-transform: uppercase">{{$institute->name}}</span>] Experts
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{$root}}/admin-section"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Institute Experts</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            @if($found)

            <div class='tab-container'>
                <ul class='tabs'>
                    <li><a href='#tab-list'>List</a></li>
                    <li><a href='#tab-create'>Create</a></li>
                </ul>
                <div id='tab-list'>
                    <div id='expert-list' class='list-container'></div>
                </div>
                <div id='tab-create'>
                    <div id='form-container'>
                        <form id='form-create-institute-expert'>
                            <div class='form-row'>
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    <input type='text' name='name'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Email</div>
                                <div class='form-data'>
                                    <input type='email' name='email'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Contact Number</div>
                                <div class='form-data'>
                                    <input type='text' name='contact_number'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Gender</div>
                                <div class='form-data'>
                                    <select name='gender'>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Highest Qualification</div>
                                <div class='form-data'>
                                    <input type='text' name='highest_qualification'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data-full'>
                                    <input type='button' name='btn-create' value="Create Expert" class='half'/> <span
                                            class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @else

                You have not added any categories

            @endif

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/patients.js"))}}
<script type="text/javascript">
    $(function () {
        $(".patients").addClass('active');
    });
</script>
</body>
</html>
