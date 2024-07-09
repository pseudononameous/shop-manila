@extends('layouts.master') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <br>
                        <br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/authCustomer/register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Name</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="first and last name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">E-Mail Address</label>
                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Birthday</label>
                            <div class="col-md-7">
                                <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Password</label>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm Password</label>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Billing Address</label>
                            <div class="col-md-7">
                                <input id="registerBillingAddress" type="text" class="form-control" name="billing_address" value="{{ old('billing_address') }}">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                   <label class="col-md-3 control-label">Shipping Address</label>
                                    <div class="col-md-4">
                                        <input id="registerShippingAddress" placeholder="Address" type="text" name="shipping_address" value="{{old('shipping_address')}}" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="city_id" id="">
                                            <option selected disabled>City</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!--<div class="col-md-2">
                                        <input placeholder="Zipcode" type="text" class="form-control">
                                    </div>-->
                                </div>
                            </div>
                            <!--<div class="col-md-6">
                                <input type="text" class="form-control" name="shipping_address" value="{{ old('shipping_address') }}">
                            </div>-->
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <input id="sameAsBillingAddress" type="checkbox" name="billingaddress" /> <strong>Same as Billing Address</strong>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Telephone Number</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="telephone_number" value="{{ old('telephone_number') }}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile Number</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}">
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-9 col-md-offset-3">
                                <input type="checkbox" name="sign_up_newsletter" value="true" /> <strong>Receive updates on our latest products and deals</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection