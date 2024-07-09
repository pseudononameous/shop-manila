@extends('layouts.master') @section('content')

<div class="container">
    <div class="row">
        <div class="order-heading">
            <div class="col-md-12">
                <h2><span class="highlight">Order Overview</span></h2>
            </div>

            <!--
            <div class="col-md-3">
                <div class="form-group">
                    <div class="right-inner-addon">
                        <i class="icon-search fa fa-search"></i>
                        <input type="search" class="form-control" placeholder="item no., search" />
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
    <div class="row">
        <div class="product-form">


            <div class="data-heading">

                <div class="row">
                    <div class="col-md-2">
                        <span>Order Number</span>
                    </div>
                    <div class="col-md-2">
                        <span>Grand Total</span>
                    </div>
                    <div class="col-md-3">
                        <span>Date Ordered</span>
                    </div>
                    <div class="col-md-3">
                        <span>Status</span>
                    </div>

                    <div class="col-md-2">
                        <span>Actions</span>
                    </div>
                </div>
            </div>


            <div class="data-content">

                @foreach($orders as $o)
                    <div class="row order">

                        <div class="col-md-2">
                            <span>{{$o->order_number}}</span>
                        </div>
                        <div class="col-md-2">
                            <p>{{Helper::getCurrency()}} {{Helper::numberFormat($o->grand_total)}}</p>
                        </div>
                        <div class="col-md-3">
                            <span>{{$o->created_at}}</span>
                        </div>
                        <div class="col-md-3">
                            <span>{{$o->optionOrderStatus->name}}</span>
                        </div>
                        <div class="col-md-2">
                            <span><a href="{{route('account_order_show', $o->id)}}">View Order</a></span>
                        </div>
                    </div>
                @endforeach

            </div>

            {!! $orders->render() !!}

        </div>
    </div>
</div>


@endsection