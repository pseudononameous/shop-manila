@extends('layouts.master') @section('content')

@include('includes.subNav')

@include('includes.shippingInfo')

<div class="container">
    <h1><span class="highlight">About us</span></h1>

    <div class="row">
        <div class="col-md-6">
            <h3>ABOUT SHOP MANILA</h3>
            <p>Say goodbye to traffic jams, long crowds and long queues! Say hello to the newest online shopping destination, Shop Manila.</p>
            
<p>Shop Manila is the one stop shop for all your lifestyle needs. With just a click, Shop Manila is making a conscious effort to bring the power of convenience at your fingertips. It offers a variety of footwear, apparel and accessories for the hip and trendy and each store carries a different range of well known and exciting brands, waiting to be discovered by you.</p>
<p>So what are you waiting for? Get your fingers ready to shop and get clicking!</p>

<p>Shop Manila is powered and owned by World Balance International Inc., a trusted and highly recognized company in the Philippines, Shop Manila sells only quality, authentic merchandise on its portal. Value Proposition: Shop Manila's business philosophy calls for the empowerment of individuals through convenient shopping through e-commerce.</p> 
       
       <p>Shop Manila's value proposition revolves on giving consumers the power and ease of purchasing products online. Shop Manila offers innovation through services that ensure a high standard of satisfaction for both users and enterprise and aims to maximize their corporate value to become a truly global online shopping site with uncompromising customer service.</p>
        </div>

        <div class="col-md-6">
            <img style="margin-top:50px;" class="img-responsive" src="{{url()}}/images/about-img1.jpg">
        </div>

    </div>
    
</div>

@endsection