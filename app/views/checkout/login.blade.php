<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Register</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/checkout-login.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container">

            <div class="col-md-9">

                <h3>Continue as a guest</h3>

                <form id="form-guest-login">
                <div class='form-row'>
                    <div class='form-label'>Email</div>
                    <div class='form-data'>
                        <input type='email' name='guest-email'/> &nbsp; &nbsp; <input type="button" name="btn-continue-guest" value="Continue"/>
                        &nbsp;&nbsp;
                        <span class="message message-guest"></span>

                    </div>
                    <div class='clear'></div>
                </div>
                </form>

                <hr/>

                <h3>Login here</h3>

                <form id="form-checkout-login">
                <div class='form-row'>
                    <div class='form-label'>Email</div>
                    <div class='form-data'>
                        <input type='email' name='login-email'/>
                    </div>
                    <div class='clear'></div>
                </div>
                <div class='form-row'>
                    <div class='form-label'>Password</div>
                    <div class='form-data'>
                        <input type='password' name='login-password'/>
                    </div>
                    <div class='clear'></div>
                </div>
                <div class='form-row'>
                    <div class='form-label'>&nbsp;</div>
                    <div class='form-data'>
                        <input type="button" name="btn-checkout-login" value="Continue"/>
                        &nbsp;&nbsp;
                        <span class="message message-login"></span>
                    </div>
                    <div class='clear'></div>
                </div>
                </form>
            </div>
            <div class="col-md-3">
                <h4>Order Amount</h4>
                &nbsp;Rs. {{$order->net_amount}}
            </div>
        </div>
    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/checkout-login.js"))}}
</body>
</html>
