@extends('layouts.master') @section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><span class="highlight">Change Password</span></h2>
            </div>
        </div>

        <!--<ul>
            <li>Passwords are case-sesitive and must be at least 6 characters</li>
            <li>A good password should contain a mix of capital and lower-case letters, numbers and symbols.</li>
        </ul>
        -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('message'))
            <div class="alert alert-success"> {!! session('message') !!}</div>
        @endif

        <form role="form" method="POST" action="{{ url('account/execute-change-password') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="profile password-change">
                <div class="profile-container">
                    <div class="row content">
                        <fieldset>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">Old Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input name="old_password" class="form-control" type="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">New Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input name="password" class="form-control" type="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">Confirm Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input name="password_confirmation" class="form-control" type="password">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="submit_block">
                            <button class="btn btn-primary" type="submit">Change Password</button>&nbsp;
                            <span>or <a href="{{url('account/profile')}}">Cancel</a></span>
                        </fieldset>
                    </div>
                </div>
            </div>



        </form>
    </div>

    @endsection