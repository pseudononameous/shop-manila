@extends('layouts.admin')
@section('content')
    <div class="container" ng-controller="OrderedItemsListCtrl">
        <div class="main">

            <div class="page-header">
                <h1>Ordered Items</h1>
            </div>

            <table class="table table-stripped">

                <thead>
                <th>Item</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Date Ordered</th>
                <th>Operations</th>
                </thead>

                <tbody>

                @foreach($data as $d)
                    <tr>
                        <td>{{$d->item->name}}</td>
                        <td>{{isset($d->optionSize->name) ? $d->optionSize->name : 'N/A'}}</td>
                        <td>{{$d->qty}}</td>
                        <td>{{ Helper::getCurrency() . ' ' . $d->subtotal}}</td>
                        <td>{{date('M d, Y', strtotime($d->created_at))}}</td>
                        @if(isset($d->option_order_status_id))
                            <td>
                            <a href="{{route('admin.ordered-items.edit', $d->order_header_id)}}" target="_blank">View</a>&emsp;
                            @if($d->option_order_status_id == \Config::get('constants.orderVerifiedStatus') || $d->option_order_status_id == \Config::get('constants.orderPaidStatus'))

                                    <span ng-click="accept({{$d->id}})">Accept | </span>
                                    <span ng-click="reject({{$d->id}})">Reject</span>


                            @elseif ($d->option_order_status_id == \Config::get('constants.orderPickupStatus'))


                                    <span ng-click="ship({{$d->id}})">Ship</span>


                            @else

                                    Status: {{$d->optionOrderStatus->name}}

                            @endif
                            </td>
                        @endif

                    </tr>
                @endforeach
                </tbody>
            </table>

            {!! $data->render() !!}

        </div>
    </div>
@endsection