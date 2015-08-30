<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | View Complaint</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.admin.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}
    {{HTML::style(asset("/public/css/site/admin/view-complaint.css"))}}

    @include('includes.admin.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div>

    <!-- Content Wrapper. Contains page content -->
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Complaint Number # {{$complaint->id}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div id='form-container'>
                <form id='form-update-personal'>
                    <div class='form-row'>
                        <div class='form-label'>Name</div>
                        <div class='form-data'>
                            <input type='text' name='name' value='{{$complaint->name}}'/>
                        </div>
                        <div class='form-label'>Email</div>
                        <div class='form-data'>
                            <input type='email' name='email' value='{{$complaint->email}}'/>
                        </div>
                        <div class='clear'></div>
                    </div>
                    <div class='form-row'>
                        <div class='form-label'>Contact Number</div>
                        <div class='form-data'>
                            <input type="text" name="contact_number_1" value='{{$complaint->contact_number_1}}'/>
                        </div>
                        <div class='form-label'>Alternate Number</div>
                        <div class='form-data'>
                            <input type="text" name="contact_number_2" value='{{$complaint->contact_number_2}}'/>
                        </div>
                        <div class='clear'></div>
                    </div>
                    <div class='form-row'>
                        <div class='form-label'>Address</div>
                        <div class='form-data'>
                            <textarea name='address'>{{$complaint->address}}</textarea>
                        </div>
                        <div class='clear'></div>
                    </div>
                    <div class='form-row'>
                        <div class='form-label'>&nbsp;</div>
                        <div class='form-data'>
                            <input type='button' name='btn-update-personal' value="Update Personal Information" class='half'/>
                            <br/><br/>
                            <span class='message message-personal'></span>
                        </div>
                        <div class='clear'></div>
                    </div>
                </form>

                <form id='form-update-complaint'>
                    <div class='form-row'>
                        <div class='form-label'>Description</div>
                        <div class='form-data'>
                            <textarea name='description'></textarea>
                        </div>
                        <div class='form-label'>Status</div>
                        <div class='form-data'>
                            <select name="status">
                                <option>Complaint</option>
                                <option>Problem</option>
                            </select>
                        </div>
                        <div class='clear'></div>
                    </div>
                    <div class='form-row'>
                        <div class='form-label'>&nbsp;</div>
                        <div class='form-data'>
                            <input type='button' name='btn-update-complaint' value="Update Complaint" class='half'/>
                            <br/><br/>
                            <span class='message'></span>
                        </div>
                        <div class='clear'></div>
                    </div>
                </form>

                <hr/>

                    <div id="complaint-update-list"></div>
                </form>
            </div>

        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/view-complaint.js"))}}
</body>
</html>
