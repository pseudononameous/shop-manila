@extends('layouts.master') 
@section('content') 
@include('includes.subNav') 
@include('includes.shippingInfo')

<div class="container">
    <h1><span class="highlight">Customer Care</span></h1>

    <div class="row">
        <div class="col-md-8">

            <div class="contact-details">
                <p>19 V. Mapa St. Caloocan City</p>
                <p>(02) 2777993</p>
                <p><strong>Monday - Friday</strong> 9AM-5PM </p>
                <p><strong>Saturday</strong> 9AM-11AM</p>
            </div>

        </div>
        <div class="col-md-4">
            <div class="contact-form" ng-controller="ContactUsCtrl">
                <h3>Contact Us</h3>
                <form role="form" name="contactForm"  ng-submit="contactForm.$valid && send()">
                    <div class="form-group">
                        <input type="name" ng-model="data.name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" ng-model="data.email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" ng-model="data.message" rows="3" id="Message" placeholder="Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" ng-disabled="contactForm.$invalid">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection