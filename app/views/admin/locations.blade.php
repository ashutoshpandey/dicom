<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Courses</title>
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
            <h1 style="text-transform: capitalize">
                Manage Locations
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
                    <div id='location-list' class='list-container'></div>
                </div>
                <div id='tab-create'>
                    <div id='form-container'>
                        <form id='form-create-location'>
                            <div class='form-row'>
                                <div class='form-label'>State</div>
                                <div class='form-data'>
                                    <select name="state">
                                          <option>Andaman and Nicobar Islands</option>
                                          <option>Andhra Pradesh</option>
                                          <option>Arunachal Pradesh</option>
                                          <option>Assam</option>
                                          <option>Bihar</option>
                                          <option>Chandigarh</option>
                                          <option>Chhattisgarh</option>
                                          <option>Dadar and Nagar Haveli</option>
                                          <option>Daman and Diu</option>
                                          <option>Delhi</option>
                                          <option>Goa</option>
                                          <option>Gujarat</option>
                                          <option>Haryana</option>
                                          <option>Himachal Pradesh</option>
                                          <option>Jammu and Kashmir</option>
                                          <option>Jharkhand</option>
                                          <option>Karnataka</option>
                                          <option>Kerala</option>
                                          <option>Lakshadeep</option>
                                          <option>Madya Pradesh</option>
                                          <option>Maharashtra</option>
                                          <option>Manipur</option>
                                          <option>Meghalaya</option>
                                          <option>Mizoram</option>
                                          <option>Nagaland</option>
                                          <option>Orissa</option>
                                          <option>Pondicherry</option>
                                          <option>Punjab</option>
                                          <option>Rajasthan</option>
                                          <option>Sikkim</option>
                                          <option>Tamil Nadu</option>
                                          <option>Tripura</option>
                                          <option>Uttaranchal</option>
                                          <option>Uttar Pradesh</option>
                                          <option>West Bengal</option>
                                    </select>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>City</div>
                                <div class='form-data'>
                                    <input type="text" name="city" class="half"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Pin</div>
                                <div class='form-data'>
                                    <input type="text" name="pin" class="half"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data-full'>
                                    <input type='button' name='btn-create' value="Create Location" class='half'/> <span
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

    @include('includes/common_js_bottom')

    {{HTML::script(asset("/public/js/site/admin/locations.js"))}}

    <script type="text/javascript">
        $(function(){
            $(".orders").addClass('active');
        });
    </script>
</body>
</html>
