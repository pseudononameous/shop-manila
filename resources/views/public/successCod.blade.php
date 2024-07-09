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
<!--
                <br/> You order will be processed as soon as payment
                <br/> has been received.
-->
                <br/>Your order will now be processed and payment
                <br/>will be Cash on Delivery.
            </p>

            <br>

            <h3>Cash on Delivery</h3>

            <p>This is only available through XEND.

                <p>Here are our selected areas wherein our Cash On Delivery (COD) payment method is accepted: </p>
                <ul>
                    <li><p>Metro Manila</p></li>
                    <li><p>Bulacan – Balagtas, Bocaue, Guiguinto, Malolos, Marilao, Plaridel, Meycauayan, San Jose Del Monte, Sta. Maria</p></li>
                    <li><p>Cavite – Amadeo, Bacoor, Carmona, Cavite City, Dasmariñas, GMA, Gen. Trias, Imus, Indang, Kawit, Mendez, Naic, Noveleta, Silang, Tanza, Trece Martirez</p></li>
                    <li><p>Laguna – Biñan, Cabuyao, Calamba, San Pedro, Sta. Rosa</p></li>
                    <li><p>Rizal – Angono, Antipolo, Cainta, Binangonan, Rodriguez, Taytay, San Mateo, Cardona, Jalajala, Tanay, Teresa.</p></li>
                </ul>


                <p>You will receive an email confirmation for this payment method.</p>

                <a href="{{url()}}" class="btn btn-primary" style="display:block; width:150px; font-size:12px; margin:50px auto;">Continue Shopping</a>
        </div>
    </div>

</div>

@endsection