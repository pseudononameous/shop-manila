@extends('layouts.admin') @section('content')
<div class="container">
    <div class="main" ng-controller="ShipmentListCtrl">

        <div class="page-header">
            <h1>Shipments</h1>
        </div>

        <div class="admin-content">

            <div ng-controller="SearchCtrl">

                <form name="searchForm" class="form-horizontal" ng-submit="searchForm.$valid && search('created_at', 'admin/search/shipments')">
                    <div class="form-group">

                        <div class="col-md-3">

                            <label for="item" class="control-label">Customer</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['customer']">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="item" class="control-label">Order Number</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['orderNumber']">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="search-btn">
                                    <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid">Search</button>
                                    <a class="btn btn-default" href="{{route('admin.shipments.index')}}">Clear</a>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </div>

                </form>
            </div>

            <table class="table table-stripped">

                <thead>

                    <th>Customer</th>
                    <th>Order Number</th>
                    <th>Payment Method</th>
                    <th>Shipment Number</th>
                    <th>Date Shipped</th>
                    <th>Operations</th>

                </thead>

                <tbody>

                    @foreach($data as $d)
                    <tr>
                        <td>{{$d->orderHeader->customer->name}}</td>
                        <td>{{$d->orderHeader->order_number}}</td>
                        <td>{{$d->orderHeader->optionPayment->name}}</td>
                        <td>{{$d->shipment_number}}</td>
                        <td>{{ date('M d, Y', strtotime($d->created_at))}}</td>

                        <td>
                            <a href="{{route('admin.shipments.show', $d->id)}}">
                                View
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