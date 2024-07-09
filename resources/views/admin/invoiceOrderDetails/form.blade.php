@extends('layouts.admin')
@section('content')

    <div class="container">
        <div class="main" ng-controller="{{$ctrl}}">

            <div class="page-header">
                <h2>{{$title}} Invoice </h2>
                <h3>Order # {{$orderHeader->order_number}}</h3>
            </div>

            <form class="form-horizontal" name="invoiceForm" role="form" ng-submit="invoiceForm.$valid && save()">

                <my-form-buttons is-invalid="invoiceForm.$invalid"
                                 return-to="{{route('admin.invoices.index')}}"></my-form-buttons>
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
                    <legend>Order total</legend>

                    <div class="col-md-6">
                        <my-static-display label="Subtotal" label-size="4" value-size="8">
                            {{$orderHeader->subtotal}}
                        </my-static-display>

                        <my-static-display label="Shipping rate" label-size="4" value-size="8">
                            {{$orderHeader->shipping_rate}}
                        </my-static-display>

                        <my-static-display label="Discount" label-size="4" value-size="8">
                            {{isset($couponCode) ? $orderHeader->discount. ' - '.$couponCode : $orderHeader->discount}}
                        </my-static-display>
                    </div>

                    <div class="col-md-6">
                        <my-static-display label="Grand total" label-size="4" value-size="8">
                            {{$orderHeader->grand_total}}
                        </my-static-display>
                    </div>
                </fieldset>


                <fieldset>

                    <legend>Orders</legend>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>QTY to Invoice</th>
                                    <th>Amount to Invoice</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr ng-repeat="or in data.orderDetails">
                                    <td>
                                        @{{or.name}}
                                    </td>
                                    <td>@{{or.price | currency : 'P '}}</td>
                                    <td>@{{or.qty}}</td>
                                    <td>@{{or.subtotal | currency : 'P '}}</td>
                                    <td>
                                        <input type="text" class="form-control"
                                               ng-model="data.invoiceDetails.qtyToInvoice[or.id]"
                                               my-equal-value="@{{or.qty}}" required>
                                    </td>
                                    <td>
                                        @{{computeAmountToInvoice(data.invoiceDetails.qtyToInvoice[or.id], or.price) | currency : 'P '}}
                                    </td>

                                </tr>
                                </tbody>

                            </table>


                </fieldset>

            </form>
        </div>
    </div>
@stop