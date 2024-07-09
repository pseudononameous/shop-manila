@extends('layouts.admin-home') @section('content')

    <div class="container" style="padding-top:10%; width:1150px;">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="intro_block pull-left">
                    <img class="img-responsive" src="{{url()}}/images/logo-home.png" alt="Shop Manila" />
                    
                    <h4>Contact Support</h4>
                    
                    <p>(02) 2777993<br />
                    care@shopmanila.com<br />
                    Mon-Fri 9AM-5PM<br />
                    Sat 9AM-11AM</p>
                    
                </div>
            </div>

            <div class="col-xs-12 col-md-6">
                <div class="login_block pull-right">
                    <p>Welcome to <span>Merchants Hub</span></p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> @if (count($errors) > 0)
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
                        <div class="field_group">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input class="form-control" name="email" id="email" type="text" value="{{ old('email') }}" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" name="password" id="password" type="password" value="" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="cf-submit" name="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <!--
        <div class="panel-body">


            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-md-4 control-label">E-Mail Address</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Login</button>

                        {{-- <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a> --}}
                    </div>
                </div>
            </form>
        </div>
-->

        </div>
    </div>

@endsection