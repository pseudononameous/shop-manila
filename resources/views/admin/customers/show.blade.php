@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="main">

        <div class="page-header">
            <h2>View Customer</h2>
        </div>

        <div class="row form-horizontal">

            <fieldset class="col-md-6">

                <my-static-display label-size="4" label="Name" value-size="8">
                    {{$customer->name}}
                </my-static-display>

                <my-static-display label-size="4" label="Email" value-size="8">
                    {{$customer->email}}
                </my-static-display>

                <my-static-display label-size="4" label="Birthday" value-size="8">
                    {{date('M d, Y', strtotime($customer->birthday))}}
                </my-static-display>

                <my-static-display label-size="4" label="Billing Address" value-size="8">
                    {{$customer->billing_address}}
                </my-static-display>

                <my-static-display label-size="4" label="Shipping Address" value-size="8">
                    {{$customer->shipping_address}}
                </my-static-display>

                <my-static-display label="City" label-size="4" value-size="8">
                    @if(count($customer->city))
                        {{$customer->city->name}}
                    @endif
                </my-static-display>

                <my-static-display label-size="4" label="Telephone Number" value-size="8">
                    {{$customer->telephone_number}}
                </my-static-display>

                <my-static-display label-size="4" label="Mobile Number" value-size="8">
                    {{$customer->mobile_number}}
                </my-static-display>


            </fieldset>
        </div>
        <hr />
        <div class="row form-horizontal">
            <fieldset class="col-md-10">
                <h3><span class="highlight">Customer's Wishlist</span></h3>
                <div class="clear-fix"></div>

                <div class="data-heading">
                    <div class="data-heading">

                        <div class="row">
                            <div class="col-md-4">
                                <span><strong>Item</strong></span>
                            </div>
                            <div class="col-md-4">
                                <span><strong>Description</strong></span>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="data-content">

                    @foreach($wishes as $w)
                        <div class="row order">

                            <div class="col-md-4">
                                <span>{{$w->item->name}}</span>
                            </div>
                            <div class="col-md-4">
                                <span>{{$w->item->short_description}}</span>
                            </div>
                        </div>
                    @endforeach

                </div>

            </fieldset>
        </div>
        <hr />

        <div class="row form-horizontal">
            <fieldset class="col-md-10">
                <h3><span class="highlight">Order History</span></h3>
                <div class="clear-fix"></div>
                <div class="data-heading">

                    <div class="row">
                        <div class="col-md-2">
                            <span><strong>Order Number</strong></span>
                        </div>
                        <div class="col-md-2">
                            <span><strong>Grand Total</strong></span>
                        </div>
                        <div class="col-md-2">
                            <span><strong>Date Ordered</strong></span>
                        </div>
                        <div class="col-md-2">
                            <span><strong>Status</strong></span>
                        </div>

                    </div>
                </div>

                <div class="data-content">

                    @foreach($orders as $o)
                        <div class="row order">

                            <div class="col-md-2">
                                <span>{{$o->order_number}}</span>
                            </div>
                            <div class="col-md-2">
                                <p>{{Helper::getCurrency()}} {{Helper::numberFormat($o->grand_total)}}</p>
                            </div>
                            <div class="col-md-3">
                                <span>{{$o->created_at}}</span>
                            </div>
                            <div class="col-md-3">
                                <span>{{$o->optionOrderStatus->name}}</span>
                            </div>

                        </div>
                    @endforeach

                </div>


            </fieldset>

        </div>

    </div>

</div>
@endsection
