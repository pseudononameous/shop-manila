@extends('layouts.master') @section('content') @include('includes.subNav') @include('includes.shippingInfo')

<div class="container">
    <h1><span class="highlight">Shopping Bag</span></h1>


    <div ng-controller="CartCtrl" ng-cloak>

        <table class="table">

            <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody ng-form="cartForm">

            <tr ng-repeat="ci in data.cart">
                <td>
                    <a href="{{url('page/item')}}/@{{ci.options.itemSlug}}">
                        <span> @{{ci.name}}</span>
                    </a>
                </td>
                <td>
                    <p>
                        @{{ci.options.shortDescription}}
                    </p>

                    <p ng-if="ci.options.size">
                        Size: @{{ ci.options.size }}
                    </p>
                </td>
                <td>
                    <input type="text" class="form-control" ng-model="ci.qty" required>
                </td>
                <td>@{{ci.price | currency : 'PHP '}}</td>

                <td>
                    @{{computeSubtotal(ci.price, ci.qty) | currency: 'PHP '}}
                </td>
                <td class="table-ops">
                    <span ng-click="remove(ci.rowid)">Remove</span>
                </td>
            </tr>

            </tbody>
        </table>


        <div class="clearfix"></div>


        <div class="coupon-code">

            <label for="coupon-code">Coupon: </label>
            <input type="text" ng-model="data.coupon">

            <button class="btn btn-primary" ng-click="applyCoupon()">Apply Coupon</button>

            <button class="btn btn-primary" ng-click="disableCoupon()">Remove Coupon</button>

        </div>


        <div class="row">
            <div class="col-md-12">
                <p>&nbsp;</p>
                <p>Applied Coupon: {{ $appliedCoupon }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grandtotalbox">
                    <div class="pull-right grandtotal">
                        <p>
                            <strong>Discount: </strong>
                            <span>{{ $discount }} </span>
                            @if($discountType != '')
                                <span> ({{ $discountType }}) / Discount applied to {{ isset($storeWithCoupon) ? $storeWithCoupon->name : ' all' }} items</span>
                            @endif
                        </p>

                        <p>
                            <strong>Subtotal: </strong>
                            <span>{{Helper::getCurrency()}} {{Helper::numberFormat($subtotal)}}</span>
                        </p>

                        <p>
                            <strong>Grand Total: </strong>
                        <h3>{{Helper::getCurrency()}} {{Helper::numberFormat($grandTotal)}}</h3>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="update">

            <button type="button" class="btn-theme btn btn-primary" ng-click="updateCart()">
                <span class="glyphicon glyphicon-refresh hideo"></span> Update cart
            </button>
            &nbsp;

            <button type="button" class="checkout-btn btn btn-primary" ng-disabled="cartForm.$invalid" ng-click="checkout()">
                <span class="icon-cart hideo"></span> Proceed to Checkout
            </button>
        </div>

    </div>

    <!--
    <section>
        <h2><span class="highlight">You May Also Like</span></h2>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     -->
</div>
@stop