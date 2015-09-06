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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Software User: {{$user->name}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <div id='tab-create'>
                    <div id='form-container'>
                        <form id='form-update-software-user'>

                            <div class='form-row'>
                                <div class='form-label'>Username</div>
                                <div class='form-data'>
                                    <input type='text' name='username' value='{{$user->username}}'/>
                                </div>
                                <div class='form-label'>User type</div>
                                <div class='form-data'>
                                    <select name="user_type">
                                        <option>Administrator</option>
                                        <option>Inventory</option>
                                        <option>Reader</option>
                                    </select>
                                    <script type="text/javascript">
                                        $("select[name='user_type']").val("{{$user->user_type}}");
                                    </script>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    <input type='text' name='name' value='{{$user->name}}'/>
                                </div>
                                <div class='form-label'>Gender</div>
                                <div class='form-data'>
                                    <label style="font-weight: normal !important;"><input type='radio' name='gender' value='male' {{$male_checked}}/> Male</label>
                                    <label style="font-weight: normal !important;"><input type='radio' name='gender' value='female' {{$female_checked}}/> Female</label>
                                </div>
                                <div class='clear'></div>
                            </div>

                            <div class='form-row'>
                                <div class='form-label'>Password</div>
                                <div class='form-data'>
                                    <input type='password' name='password'/>
                                </div>
                                <div class='form-label'>Confirm password</div>
                                <div class='form-data'>
                                    <input type='password' name='confirm_password'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Email</div>
                                <div class='form-data'>
                                    <input type='email' name='email' value='{{$user->email}}'/>
                                </div>
                                <div class='form-label'>Contact number</div>
                                <div class='form-data'>
                                    <input type='text' name='contact_number' value='{{$user->contact_number}}'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data'>
                                    <input type='button' name='btn-update' value="Update User" class='half'/> <span class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/view-user.js"))}}
<script type="text/javascript">
    $("select[name='user_type']").val("{{$user->user_type}}");
</script>

</body>
</html>
