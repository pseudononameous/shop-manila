@extends('layouts.admin')
@section('content')

    <div class="container">
        <div class="main" ng-controller="{{$ctrl}}">
            {{--<div class="pull-right">--}}
            {{--<button type="button" class="btn btn-default" ng-click="void({{$orderHeader->id}})"><span class="icon-list"></span> Cancel Order</button>--}}
            {{--</div>--}}

            <div class="page-header">
                <h2>Order # {{$orderHeader->order_number}}</h2>
                <h4>Status: {{isset($orderDetail->optionOrderStatus->name) ? $orderDetail->optionOrderStatus->name : ''}}</h4>
            </div>

            @if(! $isInvoiceComplete)
                <button type="button" class="btn btn-default" ng-click="invoice(data.id)">
                    <span class="icon-list"></span> Invoice
                </button>
            @endif


            @if( isset($orderDetail->optionOrderStatus->code_name))
                @if( $orderDetail->optionOrderStatus->code_name  ==  'invoiced' )

                    <button type="button" class="btn btn-default" ng-click="verify(data.id)">
                        <span class="icon-list"></span> Verify
                    </button>

                    <button type="button" class="btn btn-default" ng-click="paid(data.id)">
                        <span class="icon-list"></span> Mark as Paid
                    </button>

                @endif
            @endif


            @if( isset($orderDetail->optionOrderStatus->code_name))
                @if( $orderDetail->optionOrderStatus->code_name  ==  'accepted' )
                    <button type="button" class="btn btn-default" ng-click="forPickup(data.id)">
                        <span class="icon-list"></span> For Shipping
                    </button>
                @endif
            @endif


            @if( isset($orderDetail->optionOrderStatus->code_name))
                @if( $orderDetail->optionOrderStatus->code_name  ==  'shipped' )

                    <button type="button" class="btn btn-default" ng-click="refund(data.id)">
                        <span class="icon-list"></span> Refund
                    </button>

                    <button type="button" class="btn btn-default" ng-click="exchange(data.id)">
                        <span class="icon-list"></span> Exchange
                    </button>

                @endif
            @endif

            <form class="form-horizontal" name="orderForm" role="form" ng-submit="orderForm.$valid && save()">

                <my-form-buttons is-invalid="orderForm.$invalid"
                                 return-to="{{route('admin.orders.index')}}"></my-form-buttons>

                <div class="clearfix"></div>

                <div class="pull-left">
                    <p>
                        Time
                        Ordered {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $orderHeader->created_at)->format('g:i A')}}
                    </p>
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

                        <my-static-display label="Payment Method" label-size="4" value-size="8">
                            {{$orderHeader->optionPayment->name}}
                        </my-static-display>

                        <my-static-display label="Shipping Method" label-size="4" value-size="8">
                            {{$orderHeader->optionShipping->name}}
                        </my-static-display>

                    </div>

                </fieldset>

                <fieldset>
                    <legend>Order total</legend>

                    <div class="col-md-6">
                        <my-static-display label="Subtotal" label-size="4" value-size="8">
                            {{$orderHeader->subtotal}}
                        </my-static-display>

                        <my-static-display label="Shipping rate" label-size="4" value-size="8">
                            {{$orderHeader->shipping_rate}}
                        </my-static-display>

                        <my-static-display label="Discount" label-size="4" value-size="8">
                            {{isset($couponCode) ? $orderHeader->discount. ' - '.$couponCode : $orderHeader->discount }}
                        </my-static-display>
                    </div>

                    <div class="col-md-6">
                        <my-static-display label="Grand total" label-size="4" value-size="8">
                            {{$orderHeader->grand_total}}
                        </my-static-display>
                    </div>
                </fieldset>

                <fieldset class="col-md-12">

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

                            <tr>

                                <td>{{$orderDetail->item->name}} </td>
                                <td>
                                    <p> {{$orderDetail->item->short_description}}  </p>
                                    @if($orderDetail->option_size_id)
                                        <p> Size: {{$orderDetail->optionSize->name}}</p>
                                    @endif
                                </td>
                                <td>{{$orderDetail->qty}} </td>
                                <td>{{ Helper::numberFormat($orderDetail->price) }} </td>
                                <td>{{ Helper::numberFormat($orderDetail->subtotal)}} </td>

                            </tr>

                            </tbody>

                        </table>
                    {{--<div class="pull-right">--}}
                        {{--<p>Subtotal: {{$orderHeader->subtotal}}</p>--}}
                        {{--<p>Shipping rate: {{$orderHeader->shipping_rate}}</p>--}}
                        {{--<p>Discount: {{$orderHeader->discount}}</p>--}}
                        {{--<p>Grand total: {{$orderHeader->grand_total}}</p>--}}
                    {{--</div>--}}


                </fieldset>


                <!--
                <fieldset class="col-md-6">

                    <legend>Notes</legend>

                    <my-horizontal-form label-size="2" label="" value-size="8">
                        <textarea class="form-control" ng-model="data.notes" rows="10"></textarea>
                    </my-horizontal-form>

                </fieldset>
                -->

            </form>

            <div class="clearfix"></div>

            <hr>

            <div class="logs">
                <ul>
                    @foreach($logs as $log)

                        <li>
                            {{$log->optionOrderStatus->name}} at {{date('M d, Y h:i A', strtotime($log->created_at))}} {{$log->note}}
                        </li>

                    @endforeach
                </ul>

            </div>
        </div>
    </div>
@stop