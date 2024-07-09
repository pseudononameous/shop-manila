@extends('layouts.admin') @section('content')
    <div class="container">
        <div class="main" ng-controller="OrderListCtrl">

            <div class="page-header">
                <h1>Orders</h1>
            </div>

            <div class="admin-content" ng-controller="OrderedItemsListCtrl">

                <div ng-controller="SearchCtrl">

                    <form name="searchForm" class="form-horizontal"
                          ng-submit="searchForm.$valid && search('created_at', 'admin/search/orders')">
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
                                        <option ng-repeat="op in options.paymentOptions" value="@{{ op.id }}">@{{ op.name }}</option>
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
                                        <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid">
                                            Search
                                        </button>
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
                    <th></th>
                    <th class="w10">Customer</th>
                    <th  class="w15">Order Number</th>
                    <th  class="w15">Payment Method</th>
                    <th  class="w20">Time Ordered</th>
                    <th colspan="2" class>Status</th>
                    </thead>

                    <tbody>

                    @foreach($data as $key => $d)
                        <tr data-toggle="collapse" data-target="#accordion{{$key}}"
                            class="clickable order-click" {{ ($d->is_modified) ? "style=color:#17A98C" : ''}}>
                            <td style="width: 3%;">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                                   href="#accordion{{$key}}">
                                </a>
                                <!--                                <i class="fa fa-angle-down" id="fa{{$key}}">-->
                            </td>
                            <td style="width: 15%;">{{$d->customer->name}}</td>
                            <td>{{$d->order_number}}</td>
                            <td>{{$d->optionPayment->name}}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at)->format('g:i A')}}</td>
                            <td>{{$d->optionOrderStatus->name}} </td>
                            <td><a href="#" ng-click="delete({{$d->id}})" class="del">Delete</a></td>
                            {{--<td data-title="'Operations'" class="table-ops">--}}

                            {{--@if($d->option_order_status_id == \Config::get('constants.orderVoidStatus'))--}}
                            {{--<a href="{{route('admin.orders.show', $d->id)}}">--}}
                            {{--View--}}
                            {{--</a>--}}
                            {{--@endif--}}

                            {{----}}
                            {{--@if($d->option_order_status_id != \Config::get('constants.orderVoidStatus'))--}}
                            {{--<a href="{{route('admin.orders.edit', $d->id)}}">--}}
                            {{--Edit--}}
                            {{--</a>--}}
                            {{--<span ng-click="cancel({{$d->id}})">--}}
                            {{--| Cancel |--}}
                            {{--</span>--}}

                            {{--<span ng-click="delete({{$d->id}})">--}}
                            {{--Delete--}}
                            {{--</span>--}}
                            {{--@endif--}}
                            {{--</td>--}}


                        </tr>



                        <!--
                        <tr class="order-click" >
                            <td style="width: 2%;"><i class="fa fa-angle-down" id="fa{{$key}}">
                                </td>
                            <td style="width: 15%;">{{$d->customer->name}}</td>
                            <td>{{$d->order_number}}</td>
                            <td>{{$d->optionPayment->name}}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at)->format('g:i A')}}</td>
                            <td>{{$d->optionOrderStatus->name}}</td>

                            {{--<td data-title="'Operations'" class="table-ops">--}}

                        {{--@if($d->option_order_status_id == \Config::get('constants.orderVoidStatus'))--}}
                        {{--<a href="{{route('admin.orders.show', $d->id)}}">--}}
                        {{--View--}}
                        {{--</a>--}}
                        {{--@endif--}}

                        {{----}}
                        {{--@if($d->option_order_status_id != \Config::get('constants.orderVoidStatus'))--}}
                        {{--<a href="{{route('admin.orders.edit', $d->id)}}">--}}
                        {{--Edit--}}
                        {{--</a>--}}
                        {{--<span ng-click="cancel({{$d->id}})">--}}
                        {{--| Cancel |--}}
                        {{--</span>--}}

                        {{--<span ng-click="delete({{$d->id}})">--}}
                        {{--Delete--}}
                        {{--</span>--}}
                        {{--@endif--}}
                        {{--</td>--}}

                                </tr>
        -->


                        <!--                        <tr style="color:#808080" style="padding: 0" class="order-toggle">-->

                        <tr style="padding: 0" id="accordion{{$key}}" class="collapse order-toggle">
                            <td style="width: 3%;"></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Item Name</strong></td>
                                    </tr>
                                    @foreach($d->orderDetail as $od)
                                        <tr>
                                            <td> {{$od->item->name.'-'.$od->item->short_description}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Size</strong></td>
                                    </tr>
                                    @foreach($d->orderDetail as $od)
                                        <tr>
                                            <td>
                                                @foreach($od->item->itemSize as $iz)
                                                    @if($od->option_size_id == $iz->optionSize->id)
                                                        {{$iz->optionSize->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>

                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Brand</strong></td>
                                    </tr>
                                    @foreach($d->orderDetail as $od)
                                        <tr>
                                            <td>
                                               {{$od->item->store->name}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>

                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <strong>Status</strong>
                                        </td>
                                    </tr>
                                    @foreach($d->orderDetail as $od)
                                        <tr>
                                            <td>

                                                @if($od->option_order_status_id==9)
                                                    {{isset($od->optionOrderStatus->name) ? $od->optionOrderStatus->name . ' - ' . date('M d, Y h:i A' , strtotime($od->updated_at) ) : ''}}
                                                    @foreach($od->orderDetailStatus as $re => $ro)
                                                        {{$re ==0 ? '-'.$ro->note  : ''}}
                                                        @endforeach
                                                @else
                                                    {{isset($od->optionOrderStatus->name) ? $od->optionOrderStatus->name . ' - ' . date('M d, Y h:i A' , strtotime($od->updated_at) ) : ''}}
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Operation</strong></td>
                                    </tr>
                                    @foreach($d->orderDetail as $od)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.order-details.edit', $od->id)}}"
                                                   target="_blank">Edit </a> |
                                                <a href="#" ng-click="cancel({{$od->id}})" class="del">Cancel </a>
                                                @if(!isset($od->option_order_status_id))
                                                    |
                                                <a ng-click="verify({{$od->id}})" class="success">Verify</a>
                                                    @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Merchant Operation</strong></td>
                                    </tr>
                                    @foreach($d->orderDetail as $od)
                                        <tr>
                                            @if(isset($od->option_order_status_id))
                                                <td>
                                                    {{--<a href="{{route('admin.ordered-items.edit', $od->order_header_id)}}" target="_blank">View</a>&emsp;--}}
                                                    @if($od->option_order_status_id == \Config::get('constants.orderVerifiedStatus') || $od->option_order_status_id == \Config::get('constants.orderPaidStatus'))

                                                        <a ng-click="accept({{$od->id}})">Accept  </a>|
                                                        <a ng-click="reject({{$od->id}})" class="del">Reject</a>



                                                    @elseif ($od->option_order_status_id == \Config::get('constants.orderPickupStatus'))


                                                        <a ng-click="ship({{$od->id}})">Ship</a>


                                                    @else

                                                        Status: {{$od->optionOrderStatus->name}}

                                                    @endif
                                                </td>
                                            @endif
                                            {{--<td>--}}
                                                {{--<a href="{{route('admin.order-details.edit', $od->id)}}"--}}
                                                   {{--target="_blank">Edit </a> |--}}
                                                {{--<a href="#" ng-click="cancel({{$od->id}})">Cancel </a>--}}
                                            {{--</td>--}}

                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>


                    @endforeach
                    </tbody>

                </table>


                {!! $data->appends(['orderNumber' => $orderNumber, 'customer' => $customer, 'paymentOption' => $paymentOption, 'status' => $status])->render() !!}

            </div>

        </div>
    </div>
@endsection
