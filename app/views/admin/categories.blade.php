<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Categories</title>
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
            <h1 style="text-transform: capitalize">
                Manage Categories
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <!--<ul class='tabs'>
                        <li><a href='#tab-category'>Categories</a></li>
                        <li><a href='#tab-subcategory'>Sub-Categories</a></li> -->
                </ul>
                <div id='tab-category'>
                    <div id='form-container'>
                        <form id='form-create-category'>
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
                                    <textarea name="description" rows="4"></textarea>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data'>
                                    <input type='button' name='btn-create' value="Create Category"/> <span
                                            class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                    <div id='category-list' class='list-container'></div>
                </div>
<!--
                <div id='tab-subcategory'>
                    <div id='form-container'>
                        <form id='form-create-subcategory'>
                            <div class='form-row'>
                                <div class='form-label'>Category</div>
                                <div class='form-data'>
                                    <select name="category"></select>
                                </div>
                                <div class='clear'></div>
                            </div>
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
                                    <textarea name="description" rows="4"></textarea>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data'>
                                    <input type='button' name='btn-create' value="Create Sub Category"/> <span
                                            class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                    <div id='subcategory-list' class='list-container'></div>
                </div>
-->
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    @include('includes/common_js_bottom')
    {{HTML::script(asset("/public/js/site/admin/categories.js"))}}
    <script type="text/javascript">
        $(function () {
            $(".categories").addClass('active');
        });
    </script>
</body>
</html>
