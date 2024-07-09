@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="main">

            <div class="page-header">
                <h1>Orders Report</h1>
            </div>


            <div ng-controller="SearchCtrl" ng-cloak>

                <div ng-if="config.errors" class="alert alert-danger" role="alert" ng-cloak>
                    <div ng-repeat="error in config.errors">
                        @{{error[0]}}
                    </div>
                </div>


                <form name="searchForm" class="form-horizontal" ng-submit="searchForm.$valid && search('created_at', 'admin/search/orders-report')">
                    <a class="btn btn-default" href="{{url('admin/export/orders-report')}}?store=@{{data.query['store']}}&dateFrom=@{{ data.query['dateFrom'] }}&dateTo=@{{ data.query['dateTo'] }}">Export</a>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="item" class="control-label">Store</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['store']" ng-required="!data.query['dateFrom']">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="item" class="control-label">Date From</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['dateFrom']" ng-required="data.query['dateTo']">
                                <small>Ex: 1/1/16</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                              <label for="item" class="control-label">Date To</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['dateTo']" ng-required="data.query['dateFrom']">
                                <small>Ex: 1/2/16</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">&nbsp;</label>
                               <div>
                                <button class="btn btn-success" type="submit" ng-disabled="searchForm.$invalid">Search</button>
                                <a class="btn btn-default" href="{{url('admin/reports/orders')}}">Clear</a>
                              </div>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table table-stripped">
                <thead>
                <th>Store</th>
                <th>Customer</th>
                <th>Order Number</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Date Ordered</th>
                </thead>

                <tbody>

                @foreach($data as $d)
                    <tr>
                        <td>{{$d->item->store->name}}</td>
                        <td>{{$d->orderHeader->customer->name}}</td>
                        <td>{{$d->orderHeader->order_number}}</td>
                        <td>
                            <p>
                                {{$d->item->name}}
                            </p>

                            <p>
                                {{$d->item->short_description}}
                            </p>

                            <p>
                                {{isset($d->optionSize->name) ? 'Size: ' . $d->optionSize->name : ''}}
                            </p>
                        </td>
                        <td>{{ Helper::getCurrency() . ' ' . Helper::numberFormat($d->price)}}</td>
                        <td>{{ $d->qty}}</td>
                        <td>{{ Helper::getCurrency() . ' ' . Helper::numberFormat($d->subtotal)}}</td>
                        <td>{{ date('M d, Y', strtotime($d->created_at))}}</td>

                    </tr>
                @endforeach

                </tbody>

            </table>

            {!! $data->appends(['store' => $store, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo])->render() !!}

        </div>
    </div>
@endsection