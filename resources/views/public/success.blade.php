@extends('layouts.master') @section('content') @include('includes.subNav') @include('includes.shippingInfo')

<div class="container">
    <div class="row">
        <div class="success_block">
            <span class="success_title text-center">
                <strong>Thank You</strong>
                 For your order!
            </span>

            <p class="text-center">Your order has been received.
                <br/> You will receive an order confirmation email with
                <br/> details of your order and a link to track its progress.
                <br/> You order will be processed as soon as payment
                <br/> has been received.
            </p>

            <br>

            <h3>Direct Bank Transfer</h3>

            <p>Please make your payment through our bank account:</p>

            <p>Bank: BDO</p>
            <p>Account Name: World Balance International Inc.</p>
            <p>Account Number: 001600143537</p>

            <p>Once you have made your deposit, please scan the deposit slip and email it to payment@shopmanila.com so we can verify the payment and process your order for delivery.</p>

            <a href="{{url()}}" class="btn btn-primary" style="display:block; width:150px; font-size:12px; margin:50px auto;">Continue Shopping</a>
        </div>
    </div>

</div>

@endsection

