@extends('layouts.admin') @section('content')
    <div class="container">
        <div class="main" ng-controller="OrderListCtrl">

            <div class="page-header">
                <h1>Orders</h1>
            </div>

            <div class="admin-content">

                <div ng-controller="SearchCtrl">

                    <form name="searchForm" class="form-horizontal" ng-submit="searchForm.$valid && search('created_at', 'admin/search/orders')">
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


                            <div class="col-md-3">
                                <label for="item" class="control-label">Payment Method</label>
                                <div ng-cloak>
                                    <select class="form-control" ng-model="data.query['paymentOption']">
                                        <option value="">- Select -</option>
                                        <option value="@{{ op.id }}" ng-repeat="op in options.paymentOptions">@{{ op.name }}</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <label for="item" class="control-label">Status</label>
                                <div ng-cloak>
                                    <select class="form-control" ng-model="data.query['status']">
                                        <option value="">- Select -</option>
                                        <option value="1">Pending</option>
                                        <option value="3">Complete</option>
                                        <option value="4">Cancelled</option>

                                    </select>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="search-btn">
                                        <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid">Search</button>
                                        <a class="btn btn-default" href="{{route('admin.orders.index')}}">Clear</a>
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
                    <th>Time Ordered</th>
                    <th>Status</th>
                    <th>Operations</th>

                    </thead>

                    <tbody>

                    @foreach($data as $d)
                        <tr>
                            <td>{{$d->customer->name}}</td>
                            <td>{{$d->order_number}}</td>
                            <td>{{$d->optionPayment->name}}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at)->format('g:i A')}}</td>
                            <td>{{$d->optionOrderStatus->name}}</td>

                            <td data-title="'Operations'" class="table-ops">

                                @if($d->option_order_status_id == \Config::get('constants.orderVoidStatus'))
                                    <a href="{{route('admin.orders.show', $d->id)}}">
                                        View
                                    </a>
                                @endif

                                @if($d->option_order_status_id != \Config::get('constants.orderVoidStatus'))
                                    <a href="{{route('admin.orders.edit', $d->id)}}">
                                         Edit
                                    </a>
                                    <span ng-click="cancel({{$d->id}})">
                                       | Cancel |
                                    </span>

                                    <span ng-click="delete({{$d->id}})">
                                        Delete
                                    </span>
                                @endif
                            </td>

                        </tr>


                        <tr style="color:#808080">
                            @foreach($d->orderDetail as $od)
                                <td>
                                    {{$od->item->name}}
                                </td>

                                <a href="{{route('admin.admin-order-details.edit', $d->id)}}">
                                    Edit
                                </a>
                            @endforeach
                        </tr>
                    @endforeach

                    </tbody>

                </table>

                {!! $data->appends(['orderNumber' => $orderNumber, 'customer' => $customer, 'paymentOption' => $paymentOption, 'status' => $status])->render() !!}

            </div>

        </div>
    </div>
@endsection