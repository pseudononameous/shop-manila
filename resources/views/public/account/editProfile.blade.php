@extends('layouts.master') @section('content')

    <div class="container" ng-controller="EditProfileCtrl">
        <div class="row">
            <div class="col-md-12">
                <h2><span class="highlight">Edit Profile</span></h2>
            </div>
        </div>

        <form name="editProfileForm" ng-submit="editProfileForm.$valid && save()">

            <div class="profile">
                <div class="profile-container">
                    <div class="row heading">
                        <div class="col-md-10">
                            <span class="profile-header">Personal Information</span>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-default pull-right" type="submit" ng-disabled="editProfileForm.$invalid">Save</button>
                        </div>
                    </div>

                    <div class="row content">
                        <fieldset>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for=""><span class="required">*</span>Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" ng-model="data.name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for=""><span class="required">*</span> Email Address</label>
                                </div>
                                <div class="col-md-8">
                                    @{{data.email}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for=""></span> Birthday</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="date" ng-model="data.birthday">
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="row heading">
                        <div class="col-md-10">
                            <span class="profile-header">Contact Information</span>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>

                    <div class="row content">
                        <fieldset>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">Billing Address</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" ng-model="data.billing_address">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">Shipping Address</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" ng-model="data.shipping_address">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">City</label>
                                </div>

                                <div class="col-md-8">
                                    <select class="form-control" ng-options="c.name for c in options.cities" ng-model="data.city">
                                        <option value="">N/A</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">Telephone Number</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" ng-model="data.telephone_number">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">Mobile Number</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" ng-model="data.mobile_number">
                                </div>
                            </div>

                        </fieldset>
                    </div>

                    <div class="row profile-submit">
                        <div class="col-md-4 col-md-offset-8">
                             <button class="btn btn-default pull-right" type="submit" ng-disabled="editProfileForm.$invalid">Save</button>
                        </div>
                    </div>



                </div>
            </div>

        </form>

    </div>


@endsection