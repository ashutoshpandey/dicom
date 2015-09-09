<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | View Expert</title>
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
                Expert: {{$expert->first_name}} {{$expert->last_name}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class='tab-container'>
                <ul class='tabs'>
                    <li><a href='#tab-edit'>Edit</a></li>
                    <li><a href='#tab-categories'>Categories</a></li>
                    <li><a href='#tab-services'>Services</a></li>
                    <li><a href='#tab-qualification'>Qualification</a></li>
                </ul>

                <div id='tab-edit'>
                    <div id='form-container'>
                        <form id='form-update-expert'>
                            <div class='form-row'>
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    <input type='text' name='name' value="{{$expert->name}}"/>
                                </div>
                                <div class='form-label'>Email</div>
                                <div class='form-data'>
                                    <input type='text' name='email' value="{{$expert->email}}"/>
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
                                <div class='form-label'>Contact Number</div>
                                <div class='form-data'>
                                    <input type='text' name='contact_number' value="{{$expert->contact_number}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Highest Qualification</div>
                                <div class='form-data'>
                                    <input type='text' name='highest_qualification' value="{{$expert->highest_qualification}}"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Password</div>
                                <div class='form-data'>
                                    <input type='password' name='password'/>
                                </div>
                                <div class='form-label'>Confirm Password</div>
                                <div class='form-data'>
                                    <input type='password' name='confirm_password'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data-full'>
                                    <input type="button" name="btn-update-expert" value="Update Expert" class='half'/> <span
                                            class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id='tab-categories'>

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
                    </form>

                    <div id='category-list' class='list-container'></div>

                </div>

                <div id='tab-services'>

                    <form id='form-create-service'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Details</div>
                            <div class='form-data'>
                                <textarea name='details' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-service' value="Create Service" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='service-list' class='list-container'></div>
                </div>

                <div id='tab-qualification'>

                    <form id='form-create-qualification'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Description</div>
                            <div class='form-data'>
                                <textarea name='description' rows="4"></textarea>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create-qualification' value="Create Qualification" class="half"/><span
                                        class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>

                    <div id='qualification-list' class='list-container'></div>

                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/view-expert.js"))}}
<script>
    $("select[name='gender']").val("{{$expert->gender}}");
</script>
<span style="display: none" rel='{{$expert->id}}' id='expert_id'>&nbsp;</span>
</body>
</html>