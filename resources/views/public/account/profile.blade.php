@extends('layouts.master') @section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><span class="highlight">Your Profile</span></h2>
            </div>
        </div>

        <div class="profile">
            <div class="profile-container">
                <div class="row heading">
                    <div class="col-md-10">
                        <span class="profile-header">Personal Information</span>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-default pull-right" href="{{route('edit_profile', $customer->id)}}">Edit</a>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-md-4">
                        <span class="profile-label">Name</span>
                    </div>
                    <div class="col-md-8">
                        <span class="profile-data">{{$customer->name}}</span>
                    </div>

                    <div class="col-md-4">
                        <span class="profile-label">Email Address</span>
                    </div>
                    <div class="col-md-8">
                        <span class="profile-data">{{$customer->email}}</span>
                    </div>

                    <div class="col-md-4">
                        <span class="profile-label">Birthday</span>
                    </div>
                    <div class="col-md-8">
                        <span class="profile-data">{{date('M d, Y', strtotime($customer->birthday))}}</span>
                    </div>

                    <div class="col-md-4">
                        <span class="profile-label">Password</span>
                    </div>
                    <div class="col-md-8">
                        <a class="btn btn-default" href="{{route('change_password')}}">Change Password</a>
                    </div>
                </div>

                <div class="row heading">
                    <div class="col-md-10">
                        <span class="profile-header">Contact Information</span>
                    </div>
                    <div class="col-md-2">
                    
                    </div>
                </div>

                <div class="row content">
                    <div class="col-md-6">
                        Billing Address
                    </div>

                    <div class="col-md-6">
                        <p>{{$customer->billing_address}}</p>
                    </div>

                </div>


                <div class="row content">
                    <div class="col-md-6">
                        Shipping Address
                    </div>

                    <div class="col-md-6">
                        <p>{{$customer->shipping_address}}</p>
                    </div>

                </div>

                <div class="row content">
                    <div class="col-md-6">
                        City
                    </div>

                    <div class="col-md-6">
                        <p>{{isset($customer->city->name) ? $customer->city->name : 'N/A'}}</p>
                    </div>

                </div>


                <div class="row content">
                    <div class="col-md-6">
                        Telephone Number
                    </div>

                    <div class="col-md-6">
                        <p>{{$customer->telephone_number}}</p>
                    </div>

                </div>


                <div class="row content">
                    <div class="col-md-6">
                        Mobile Number
                    </div>

                    <div class="col-md-6">
                        <p>{{$customer->mobile_number}}</p>
                    </div>

                </div>

                <div class="row profile-submit">
                </div>



            </div>
        </div>

    </div>


@endsection