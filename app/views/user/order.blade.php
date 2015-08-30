<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | View Order</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.user.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}

    @include('includes.user.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Order ID: #{{$order->id}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <ul class='tabs'>
                    <li><a href='#tab-address'>Address</a></li>
                    <li><a href='#tab-items'>Items</a></li>
                </ul>
                <div id='tab-address'>
                    <div id='form-container'>
                        <form id='form-order'>

                            <div class='col-2'>

                                <h3>Shipping information</h3>

                                <div class='form-row'>
                                    <div class='form-label'>Name</div>
                                    <div class='form-data'>{{$order->shipping_name}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-label'>Address</div>
                                    <div class='form-data'>{{$order->shipping_address}}, <b>Landmark : </b> {{$order->shipping_land_mark}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-label'>Location</div>
                                    <div class='form-data'>
                                        {{$order->shipping_city}}, {{$order->shipping_state}},
                                        {{$order->shipping_country}}, {{$order->shipping_zip}}
                                    </div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-label'>Contact number</div>
                                    <div class='form-data'>{{$order->shipping_contact_number_1}}, {{$order->shipping_contact_number_2}}</div>
                                    <div class='clear'></div>
                                </div>

                            </div>

                            <div class='col-2'>

                                <h3>Billing information</h3>

                                <div class='form-row'>
                                    <div class='form-label'>Name</div>
                                    <div class='form-data'>{{$order->billing_name}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-label'>Address</div>
                                    <div class='form-data'>{{$order->billing_address}}, <b>Landmark : </b> {{$order->billing_land_mark}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-label'>Location</div>
                                    <div class='form-data'>
                                        {{$order->billing_city}}, {{$order->billing_state}},
                                        {{$order->billing_country}}, {{$order->billing_zip}}
                                    </div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='form-label'>Contact number</div>
                                    <div class='form-data'>{{$order->billing_contact_number_1}}, {{$order->billing_contact_number_2}}</div>
                                    <div class='clear'></div>
                                </div>

                            </div>

                            <div class='clear'></div>
                        </form>
                    </div>
                </div>
                <div id="tab-items">
                    <div class="order-items">

                        @if(isset($orderItems))

                            <table id="grid-items" class="table table-condensed table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th data-column-id="id" data-type="numeric">ID</th>
                                        <th data-column-id="product">Product</th>
                                        <th data-column-id="quantity">Quantity</th>
                                        <th data-column-id="price">Price</th>
                                        <th data-column-id="status">Status</th>
                                        <th data-column-id="price" style="text-align:right">Net Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $total = 0; ?>
                                    @foreach($orderItems as $orderItem)

                                        <tr>
                                            <td>{{$orderItem->id}}</td>
                                            <td>{{$orderItem->product->name}}</td>
                                            <td>{{$orderItem->quantity}}</td>
                                            <td>{{$orderItem->discounted_price}}</td>
                                            <td>{{$orderItem->status}}</td>
                                            <td style="text-align:right">{{$orderItem->discounted_price * $orderItem->quantity}}</td>
                                        </tr>

                                        <?php $total = $total + $orderItem->discounted_price * $orderItem->quantity; ?>

                                    @endforeach

                                    <tr>
                                        <td colspan="6" style="text-align:right">Total = {{$total}}</td>
                                    </tr>

                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/user/common_js_bottom')
{{HTML::script(asset("/public/js/site/user/order.js"))}}
</body>
</html>
