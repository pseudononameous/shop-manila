@extends('layouts.admin')
@section('content')

    <div class="container">
        <div class="main">

            <div class="page-header">
                <h2>Order # {{$orderHeader->order_number}}</h2>

                <p>
                    @if($orderHeader->option_order_status_id == \Config::get('constants.orderVoidStatus'))
                        Order has been cancelled
                    @endif
                </p>
            </div>


            <form class="form-horizontal" name="orderForm" role="form">



                <div class="pull-left">
                    <p>
                        Time Ordered {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $orderHeader->created_at)->format('g:i A')}}
                    </p>
                </div>

                <div class="pull-right">
                    <a href="{{route('admin.orders.index')}}" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                </div>

                <div class="clearfix"></div>

                <fieldset>

                    <legend>Customer</legend>

                    <div class="col-md-6">
                        <my-static-display label="Customer" label-size="4" value-size="8">
                            {{$orderHeader->customer->name}}
                        </my-static-display>

                        <my-static-display label="Email" label-size="4" value-size="8">
                            {{$orderHeader->customer->email}}
                        </my-static-display>
                    </div>

                </fieldset>

                <fieldset>

                    <legend>Recipient details</legend>

                    <div class="col-md-6">

                        <my-static-display label="Ship to" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->name}}
                        </my-static-display>

                        <my-static-display label="Email" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->email}}
                        </my-static-display>

                        <my-static-display label="Shipping address" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->shipping_address}}
                        </my-static-display>

                    </div>

                    <div class="col-md-6">

                        <my-static-display label="Telephone number" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->telephone_number}}
                        </my-static-display>

                        <my-static-display label="Mobile number" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->mobile_number}}
                        </my-static-display>
                        <my-static-display label="City" label-size="4" value-size="8">
                            @if(count($orderHeader->orderRecipient->city))
                            {{$orderHeader->orderRecipient->city->name}}
                            @endif
                        </my-static-display>

                    </div>

                </fieldset>


                <fieldset>

                    <legend>Shipping details</legend>

                    <div class="col-md-6">

                        <my-static-display label="Shipping Method" label-size="4" value-size="8">
                            {{$orderHeader->optionShipping->name}}
                        </my-static-display>

                    </div>

                </fieldset>

                <fieldset class="col-md-6">

                    <legend>Orders</legend>

                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($orderDetails as $od)
                            <tr>

                                <td>{{$od->item->name}} </td>
                                <td>
                                    <p> {{$od->item->short_description}}  </p>
                                    @if($od->option_size_id)
                                        <p> Size: {{$od->optionSize->name}}</p>
                                    @endif
                                </td>
                                <td>{{$od->qty}} </td>
                                <td>{{$od->price}} </td>
                                <td>{{$od->subtotal}} </td>

                            </tr>
                        @endforeach
                        </tbody>

                    </table>


                    <div class="pull-right">
                        <p>Subtotal: {{$orderHeader->subtotal}}</p>
                        <p>Shipping rate: {{$orderHeader->shipping_rate}}</p>
                        <p>Discount: {{$orderHeader->discount}}</p>
                        <p>Grand total: {{$orderHeader->grand_total}}</p>
                    </div>

                </fieldset>


                <fieldset class="col-md-6">

                    <legend>Notes</legend>

                    {{$orderHeader->notes}}

                </fieldset>


            </form>


        </div>
    </div>
@stop