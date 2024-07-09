@extends('layouts.admin') @section('content')
<div class="container">
    <div class="main" ng-controller="ShipmentListCtrl">

        <div class="page-header">
            <h1>Shipments</h1>
        </div>

        <div class="admin-content">

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
                            </a>
                            <span ng-click="delete({{$d->id}})">
                                Delete
                            </span>
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