@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="main" ng-controller="{{$ctrl}}">

        <div class="page-header">
            <h2>{{$title}} Shipment </h2>
            <h3>Order # {{$orderHeader->order_number}}</h3>
            <p>Payment Method: {{$orderHeader->optionPayment->name}}</p>
        </div>

        <form class="form-horizontal" name="shipmentForm" role="form" ng-submit="shipmentForm.$valid && save()">

            <my-form-buttons is-invalid="shipmentForm.$invalid" return-to="{{route('admin.shipments.index')}}"></my-form-buttons>

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

                </div>

            </fieldset>

            <fieldset>

                <legend>Orders</legend>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Quantity to Ship</th>
                            <th>Tracking Number</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr ng-repeat="or in data.orderDetails">
                            <td>
                                @{{or.name}}
                            </td>
                            <td>@{{or.qty}}</td>
                            <td>
                                <input type="text" class="form-control" ng-model="data.shipmentDetails.qtyToShip[or.id]" my-equal-value="@{{or.qty}}" required>
                            </td>

                            <td>
                                <input type="text" class="form-control" ng-model="data.shipmentDetails.trackingNumber[or.id]">
                            </td>

                        </tr>
                    </tbody>

                </table>

            </fieldset>

        </form>
    </div>
</div>
@stop