<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Update Location</title>
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
                Location: {{$location->city}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <div id='tab-create'>
                    <div id='form-container'>
                        <form id='form-update-location'>
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
                                    <script type="text/javascript">
                                        $("select[name='state']").val("{{$location->state}}");
                                    </script>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>City</div>
                                <div class='form-data'>
                                    <input type='text' name='city' value='{{$location->city}}'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Pin</div>
                                <div class='form-data'>
                                    <input type='text' name='pin' value='{{$location->pin}}'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data'>
                                    <input type='button' name='btn-update' value="Update Location" class='half'/> <span
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
{{HTML::script(asset("/public/js/site/admin/view-location.js"))}}
</body>
</html>
