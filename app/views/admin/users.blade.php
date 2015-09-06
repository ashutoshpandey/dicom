<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Couriers</title>
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
                Manage Software Users
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <ul class='tabs'>
                    <li><a href='#tab-list'>List</a></li>
                    <li><a href='#tab-create'>Create</a></li>
                </ul>
                <div id='tab-list'>
                    <div id='user-list' class='list-container'></div>
                </div>
                <div id='tab-create'>
                    <div id='form-container'>
                        <form id='form-create-user'>

                            <div class='form-row'>
                                <div class='form-label'>Institute</div>
                                <div class='form-data'>
                                    <select name="institute">

                                        @if($institutesFound)

                                            @foreach($institutes as $institute)

                                                <option value="{{$institute->id}}">{{$institute->name}}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>
                                <div class='clear'></div>
                            </div>

                            <div class='form-row'>
                                <div class='form-label'>Username</div>
                                <div class='form-data'>
                                    <input type='text' name='username'/>
                                </div>
                                <div class='form-label'>User type</div>
                                <div class='form-data'>
                                    <select name="user_type">
                                        <option>Administrator</option>
                                        <option>Inventory</option>
                                        <option>Reader</option>
                                    </select>
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
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    <input type='text' name='name'/>
                                </div>
                                <div class='form-label'>Gender</div>
                                <div class='form-data'>
                                    <label style="font-weight: normal"><input type='radio' name='gender' value='male' checked="checked"/>
                                        Male</label>
                                    <label style="font-weight: normal"><input type='radio' name='gender' value='female'/> Female</label>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Email</div>
                                <div class='form-data'>
                                    <input type='email' name='email'/>
                                </div>
                                <div class='form-label'>Contact number</div>
                                <div class='form-data'>
                                    <input type='text' name='contact_number'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data-full'>
                                    <input type='button' name='btn-create' value="Create User" class='half'/> <span
                                        class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/users.js"))}}
<script type="text/javascript">
    $(function () {
        $(".users").addClass('active');
    });
</script>
</body>
</html>
