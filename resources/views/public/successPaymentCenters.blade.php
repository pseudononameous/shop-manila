@extends('layouts.master')
@section('content')
    @include('includes.subNav')
    @include('includes.shippingInfo')

<div class="container">
    <div class="row">
        <div class="success_block">
            <span class="success_title text-center">
                <strong>Thank You</strong>
                 For your order!
            </span>

            <p class="text-center">Your order has been received.<br/>

             You will receive an order confirmation email with <br/>
             details of your order and a link to track its progress. <br/>
             You order will be processed as soon as payment <br/>
             has been received.
            </p>

            <br>

            <h3>Payment Centers</h3>

<!--            <p>Please email <a href="mailto:payment@shopmanila.com">payment@shopmanila.com</a> for account details.</p>-->
            <p> Payment Center(LBC / Palawan Express) - send payment to
                <br/>
                <br/><strong>KIMBERLY ROSE CHONG</strong>
                <br/>World Balance International, Inc.
                <br/>19 V. Mapa St., Caloocan City 1400
                <br/>0917 833 6542
            </p>

            <a href="{{url()}}" class="btn btn-primary" style="display:block; width:150px; font-size:12px; margin:50px auto;">Continue Shopping</a>
        </div>
    </div>

</div>

@endsection
