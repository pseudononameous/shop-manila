@extends('layouts.admin') @section('content')
<div class="container">
    <div class="main" ng-controller="CouponListCtrl">



        <div class="page-header">
            <h1>Coupons</h1>
            <div class="list-add-btn pull-right">
                <a href="{{route('admin.coupons.create')}}" class="btn btn-primary">Create Coupon</a>
            </div>
        </div>


        <div class="admin-content">

            <table class="table table-stripped">

                <thead>

                    <th>Name</th>
                    <th>Code</th>
                    <th>For Store</th>
                    <th>Discount</th>
                    <th>Total Usage</th>
                    <th>Operations</th>

                </thead>

                <tbody>

                    @foreach($data as $d)
                    <tr>
                        <td>{{$d->name}}</td>
                        <td>{{$d->code}}</td>
                        <td>{{isset($d->store->name) ? $d->store->name : 'All'}}</td>
                        <td>{{$d->discount}} ({{$d->optionCouponType->name}}) </td>
                        <td>{{$d->total_usage}}</td>

                        <td>

                            <a href="{{route('admin.coupons.edit', $d->id)}}">
                                Edit
                            </a> |
                            <a ng-click="delete({{$d->id}})" class="del">
                                Delete
                            </a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>

            {!! $data->render() !!}

        </div>

    </div>
</div>
@endsection