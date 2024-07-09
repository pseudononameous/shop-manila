@extends('layouts.admin') 
@include('includes.adminSidebar') 
@section('content')

<div class="container">
    <div class="main" ng-controller="{{$ctrl}}">

        <div class="page-header">
            <h2>Order #@{{data.orderNumber}}</h2>
        </div>

        <div class="pull-left">
            <p>Date Ordered: @{{data.dateOrdered | myDateFormat}}</p>
            <p>Status: @{{data.status.name}}</p>
        </div>



        <form class="form-horizontal validate-form" name="orderForm" role="form" ng-submit="orderForm.$valid && save()" novalidate>

            <a href="{{url()}}/admin/orders" class="btn btn-default pull-right"><span class="icon-left"></span> Back</a>

            <div class="clearfix"></div>

            <fieldset>

                <legend>Customer</legend>

                <div class="col-md-6">
                    <my-static-display label="Customer" label-size="4" value-size="8">
                        @{{data.customer.name}}
                    </my-static-display>

                    <my-static-display label="Email" label-size="4" value-size="8">
                        @{{data.customer.email}}
                    </my-static-display>
                </div>

            </fieldset>



            <fieldset>

                <legend>Shipping details</legend>

                <div class="col-md-6">

                    <my-static-display label="Ship to" label-size="4" value-size="8">
                        @{{data.shippingDetail.shipTo}}
                    </my-static-display>

                    <my-static-display label="Email" label-size="4" value-size="8">
                        @{{data.shippingDetail.email}}
                    </my-static-display>

                    <my-static-display label="Billing address" label-size="4" value-size="8">
                        @{{data.shippingDetail.billingAddress}}
                    </my-static-display>

                </div>

                <div class="col-md-6">


                    <my-static-display label="Shipping address" label-size="4" value-size="8">
                        @{{data.shippingDetail.shippingAddress}}
                    </my-static-display>

                    <my-static-display label="Telephone number" label-size="4" value-size="8">
                        @{{data.shippingDetail.telephoneNumber}}
                    </my-static-display>

                    <my-static-display label="Mobile number" label-size="4" value-size="8">
                        @{{data.shippingDetail.mobileNumber}}
                    </my-static-display>

                </div>

            </fieldset>


            <fieldset class="col-md-6">

                <legend>Orders</legend>

                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th class="hidden">ID</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>QTY</th>
                            <th>Price</th>
                            <th>Rush QTY</th>
                            <th>RushPrice</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr ng-repeat="or in data.orderDetails">

                            <td>
                                @{{or.item.name}}
                            </td>
                            <td>@{{or.item.short_description}}</td>
                            <td>@{{or.qty}}</td>
                            <td>@{{or.price | currency : 'P '}}</td>
                            <td>@{{or.qty_rush}}</td>
                            <td>@{{or.rush_price | currency : 'P '}}</td>
                            <td>
                                @{{or.subtotal | currency : 'P '}}
                            </td>

                        </tr>
                    </tbody>

                </table>

                <div class="pull-right">
                    <p>Subtotal: @{{data.subtotal | currency : "P "}}</p>
                    <p>Shipping rate: @{{data.shippingRate | currency : "P "}}</p>
                    <p>Grand total: @{{data.grandTotal | currency : "P "}}</p>
                </div>

            </fieldset>


            <fieldset class="col-md-6">

                <legend>Notes</legend>

                <my-static-display label-size="2" label="" value-size="8">
                    @{{data.notes}}
                </my-static-display>

            </fieldset>

        </form>
    </div>
</div>
@stop