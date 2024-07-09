@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="main" ng-controller="{{$ctrl}}">

        <div class="page-header">
            <h2>{{$title}} Coupon </h2>
        </div>

        <form class="form-horizontal" name="couponForm" role="form" ng-submit="couponForm.$valid && save()">

            <my-form-buttons is-invalid="couponForm.$invalid" return-to="{{route('admin.coupons.index')}}"></my-form-buttons>

            <fieldset>


                <my-horizontal-form label-size="2" label="Name" value-size="8">
                    <input type="text" class="form-control" ng-model="data.name" required>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Code" value-size="8">
                    <input type="text" class="form-control" ng-model="data.code" required>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Store" value-size="8">
                    <select class="form-control" ng-options="s.name for s in options.stores" ng-model="data.store">
                        <option value="">All</option>
                    </select>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Discount" value-size="8">
                    <input type="text" class="form-control" ng-model="data.discount" required>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Coupon Type" value-size="8">
                    <select class="form-control" ng-options="c.name for c in options.couponTypes" ng-model="data.couponType" required></select>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Minimum Cart Amount" value-size="8">
                    <input type="text" class="form-control" ng-model="data.minimum_cart_amount" required>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Uses per Coupon" value-size="8">
                    <input type="text" class="form-control" ng-model="data.uses_per_coupon" required>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Uses per Customer" value-size="8">
                    <input type="text" class="form-control" ng-model="data.uses_per_customer" required>
                </my-horizontal-form>


            </fieldset>

        </form>
    </div>
</div>
@stop