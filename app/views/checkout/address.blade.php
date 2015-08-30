<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Register</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/checkout-address.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container">

        <h3>Shipping Address</h3>

        <form id="form-address" action="{{$root}}/checkout-payment" method="post">

            <div class='form-row'>
                <div class='form-label'>Name</div>
                <div class='form-data'>
                    <input type='email' name='shipping-name'/>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>Address</div>
                <div class='form-data'>
                    <textarea rows="5" name="shipping-address"></textarea>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>City</div>
                <div class='form-data'>
                    <input type='email' name='shipping-city'/>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>State</div>
                <div class='form-data'>
                    <input type='email' name='shipping-state'/>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>Pin code</div>
                <div class='form-data'>
                    <input type='email' name='shipping-zip'/>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>Land mark</div>
                <div class='form-data'>
                    <input type='email' name='shipping-land-mark'/>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>Contact number 1</div>
                <div class='form-data'>
                    <input type='email' name='shipping-contact-number-1'/>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>Contact number 2</div>
                <div class='form-data'>
                    <input type='email' name='shipping-contact-number-2'/>
                </div>
                <div class='clear'></div>
            </div>

            <div class='form-row'>
                <div class='form-label'>&nbsp;</div>
                <div class='form-data'>
                    <label><input type="checkbox" name="chk-billing-same" checked="checked" value="yes"/> Billing address is same as shipping address</label>
                </div>
                <div class='clear'></div>
            </div>

            <div id="billing-container">

                <div class='form-row'>
                    <div class='form-label'>Name</div>
                    <div class='form-data'>
                        <input type='email' name='billing-name'/>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class='form-row'>
                    <div class='form-label'>Address</div>
                    <div class='form-data'>
                        <textarea rows="5" name="billing-address"></textarea>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class='form-row'>
                    <div class='form-label'>City</div>
                    <div class='form-data'>
                        <input type='email' name='billing-city'/>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class='form-row'>
                    <div class='form-label'>State</div>
                    <div class='form-data'>
                        <input type='email' name='billing-state'/>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class='form-row'>
                    <div class='form-label'>Pin code</div>
                    <div class='form-data'>
                        <input type='email' name='billing-zip'/>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class='form-row'>
                    <div class='form-label'>Land mark</div>
                    <div class='form-data'>
                        <input type='email' name='billing-land-mark'/>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class='form-row'>
                    <div class='form-label'>Contact number 1</div>
                    <div class='form-data'>
                        <input type='email' name='billing-contact-number-1'/>
                    </div>
                    <div class='clear'></div>
                </div>

                <div class='form-row'>
                    <div class='form-label'>Contact number 2</div>
                    <div class='form-data'>
                        <input type='email' name='billing-contact-number-2'/>
                    </div>
                    <div class='clear'></div>
                </div>

            </div>

            <div class='form-row'>
                <div class='form-label'>&nbsp;</div>
                <div class='form-data'>
                    <input type='button' name='btn-address' value="Continue"/>
                </div>
                <div class='clear'></div>
            </div>
        </form>

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/checkout-address.js"))}}
</body>
</html>
