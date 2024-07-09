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

            <h3>Paypal</h3>

            <p>Once you have made your payment, please scan the proof of payment and
            email it to <a href="mailto:payment@shopmanila.com">payment@shopmanila.com</a> so we can verify the payment and
            process your order for delivery.</p>

            <a href="{{url()}}" class="btn btn-primary" style="display:block; width:150px; font-size:12px; margin:50px auto;">Continue Shopping</a>
        </div>
    </div>
    
</div>

@endsection