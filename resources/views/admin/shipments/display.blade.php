@extends('layouts.admin')
@section('content')


    <div class="container"  ng-controller="ViewShipmentCtrl">

        <div class="main">

            <div class="page-header">
                <h2>View Shipment #{{$shipment->shipment_number}}</h2>
            </div>

            <div class="clearfix"></div>

            <button ng-click="sendEmail()" class="btn btn-default">Email to Customer</button>

            @if($shipment->is_email_sent)
                <span>
                    An email has been sent to the customer
                </span>
            @endif
            
            <form class="form-horizontal" name="invoiceForm" role="form" ng-submit="invoiceForm.$valid && submit()" novalidate>

                <a href="{{route('admin.shipments.index')}}" class="btn btn-default pull-right"><span class="icon-left"></span> Back</a>

                <div class="pull-left">
                    <p>Date Ordered:  {{date('M d, Y', strtotime($shipment->orderHeader->created_at)) }}</p>
                    <p>Date Shipped:  {{date('M d, Y', strtotime($shipment->created_at)) }}</p>
                    <p>Payment Method:  {{$shipment->orderHeader->optionPayment->name }}</p>
                </div>

                <div class="clearfix"></div>

                <fieldset>

                    <legend>Customer</legend>

                    <div class="col-md-6">
                        <my-static-display label="Customer" label-size="4" value-size="8">
                            {{$shipment->orderHeader->customer->name}}
                        </my-static-display>

                        <my-static-display label="Email" label-size="4" value-size="8">
                            {{$shipment->orderHeader->customer->email}}
                        </my-static-display>
                    </div>


                </fieldset>

                <fieldset>

                    <legend>Recipient details</legend>

                    <div class="col-md-6">

                        <my-static-display label="Ship to" label-size="4" value-size="8">
                            {{$shipment->orderHeader->orderRecipient->name}}
                        </my-static-display>

                        <my-static-display label="Email" label-size="4" value-size="8">
                            {{$shipment->orderHeader->orderRecipient->email}}
                        </my-static-display>

                        <my-static-display label="Shipping address" label-size="4" value-size="8">
                            {{$shipment->orderHeader->orderRecipient->shipping_address}}
                        </my-static-display>

                    </div>


                    <div class="col-md-6">


                        <my-static-display label="Telephone number" label-size="4" value-size="8">
                            {{$shipment->orderHeader->orderRecipient->telephone_number}}
                        </my-static-display>

                        <my-static-display label="Mobile number" label-size="4" value-size="8">
                            {{$shipment->orderHeader->orderRecipient->mobile_number}}
                        </my-static-display>

                    </div>

                </fieldset>

                <fieldset>

                    <legend>Orders</legend>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>QTY Shipped</th>
                            <th>Tracking Number</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($shipment->shipmentDetail as $sd)
                            <tr>

                                <td>
                                {{$sd->orderDetail->item->name . ' ' . $sd->orderDetail->item->short_description  }} 
                                </td>
                                <td>{{$sd->qty}}</td>
                                <td>{{$sd->tracking_number}}</td>

                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </fieldset>


            </form>
        </div>
    </div>

@stop