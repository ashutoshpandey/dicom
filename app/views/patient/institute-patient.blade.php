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

        @if($found)

        <section class="content-header">
            <h1>
                Patient: {{$patient->name}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class='tab-container'>
                <ul class='tabs'>
                    <li><a href='#tab-edit'>Edit</a></li>
                    <li><a href='#tab-form'>Form</a></li>
                    <li><a href='#tab-services'>History</a></li>
                </ul>

                <div id='tab-edit'>
                    <div id='form-container'>
                        <form id='form-create-book'>
                            <div class='form-row'>
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    <input type='text' name='first_name' value="{{$patient->name}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Email</div>
                                <div class='form-data'>
                                    <input type='text' name='email' value="{{$patient->email}}"/>
                                </div>
                                <div class='form-label'>Contact Number</div>
                                <div class='form-data'>
                                    <input type='text' name='contact_number' value="{{$patient->contact_number}}"/>
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
                                    <input type='text' name='highest_qualification' value="{{$patient->highest_qualification}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data-full'>
                                    <input type='submit' value="Update Expert" class='half'/> <span
                                            class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id='tab-form'>

                    <form id='form-create-category'>
                        <div class='form-row'>
                            <div class='form-label'>Category</div>
                            <div class='form-data'>
                                <select name="category"></select>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Sub Category</div>
                            <div class='form-data'>
                                <select name="subcategory"></select>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-category' value="Add To Category" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class="form-row">
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-forward' value="Forward to expert" class="half"/><span class='message forward-message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='forward-div' class='list-container'></div>

                </div>

                <div id='tab-history'>

                    <div id='history' class='list-container'></div>

                </div>
            </div>

        </section>
        <!-- /.content -->

        @else
            Invalid request
        @endif
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/view-institute-patient.js"))}}
<script>
    $("select[name='gender']").val("{{$patient->gender}}");
</script>
</body>
</html>