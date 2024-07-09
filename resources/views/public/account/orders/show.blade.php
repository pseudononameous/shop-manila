@extends('layouts.master') @section('content')

<div class="container">
    <div class="row">
        <div class="order-heading">
            <div class="col-md-12">
                <h2><span class="highlight">Order Details for Order No. {{$orderHeader->order_number}}</span></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="order-block">
                <span class="order-title">Shipping Address</span>
                <p>{{$recipient->name}}, {{$recipient->telephone_number}} / {{$recipient->mobile_number}} {{$recipient->shipping_address}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="order-block">
                <span class="order-title">Billing Address</span>
                <p>{{$customer->name}}, {{$customer->telephone_number}} / {{$customer->mobile_number}} {{$customer->billing_address}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="order-block">
                <span class="order-title">Payment Method</span>
                <p>{{$orderHeader->optionPayment->name}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <h2><span class="highlight">Items</span></h2>
        <div class="data-heading">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-1">
                    <span>Item</span>
                </div>
                <div class="col-md-4">
                    <span>Product Description</span>
                </div>
                <div class="col-md-2">
                    <span>Price</span>
                </div>
                <div class="col-md-2">
                    <span>Status</span>
                </div>
            </div>
        </div>

        <div class="data-content">

            @foreach($orderHeader->orderDetail as $od)
                <div class="row order">

                    <div class="col-md-2">
                        @foreach($od->item->itemImage as $image)
                            @if($image->is_primary)
                                <img class="img-responsive" src="{{url($image->path . $image->file_name)}}" alt="" >
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-1">
                        <span><a href="{{route('item_page', $od->item->slug)}}">{{$od->item->name}}</a></span>
                    </div>
                    <div class="col-md-4">
                        <p>{!! $od->item->description !!} </p>
                    </div>
                    <div class="col-md-2">
                        <span>{{Helper::getCurrency()}} {{ Helper::numberFormat($od->item->price)}}</span>
                    </div>
                    <div class="col-md-2">
                        <span style="float:left">{{isset($od->optionOrderStatus->name) ? $od->optionOrderStatus->name : 'N/A'}}</span>
                    </div>
                </div>
            @endforeach

            <div class="row order">
                <div class="col-md-3 col-md-offset-7">
                    <span>Subtotal</span>
                </div>
                <div class="col-md-2">
                    <span>{{Helper::getCurrency()}} {{Helper::numberFormat($orderHeader->subtotal)}}</span>
                </div>
            </div>

            <div class="row order">
                <div class="col-md-3 col-md-offset-7">
                    <span>Discount</span>
                </div>
                <div class="col-md-2">
                    <span>{{Helper::getCurrency()}} {{Helper::numberFormat($orderHeader->discount)}}</span>
                </div>
            </div>

            <div class="row order">
                <div class="col-md-3 col-md-offset-7">
                    <span>Shipping</span>
                </div>
                <div class="col-md-2">
                    <span>{{Helper::getCurrency()}} {{ Helper::numberFormat($orderHeader->shipping_rate) }}</span>
                </div>
            </div>

            <div class="row order">
                <div class="col-md-3 col-md-offset-7">
                    <span><strong>Grand Total</strong></span>
                </div>
                <div class="col-md-2">
                    <span><strong>{{Helper::getCurrency()}} {{ Helper::numberFormat($orderHeader->grand_total) }}</strong></span>
                </div>
            </div>

        </div>

    </div>
</div>


@endsection