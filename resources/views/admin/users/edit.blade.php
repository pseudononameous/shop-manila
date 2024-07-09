@extends('layouts.admin') 
@section('content')
<div class="container">
    <div ng-controller="{{$ctrl}}">

        <div class="page-header">
            <h2>{{$title}} User</h2>
        </div>

        <form class="form-horizontal" name="userForm" role="form" ng-submit="userForm.$valid && save()">

            <div ng-if="data.errors" class="alert alert-danger" role="alert" ng-cloak>
                <div ng-repeat="error in data.errors" ng-cloak>
                    @{{error[0]}}
                </div>
            </div>

            <div class="col-md-6">

                <my-horizontal-form label-size="2" label="Name" value-size="8" required>
                    <input type="text" class="form-control" ng-model="data.name">
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Email" value-size="8" required>
                    <input type="email" class="form-control" ng-model="data.email">
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Store" value-size="8">
                    <select class="form-control" ng-model="data.store" ng-options="store.name for store in options.stores" required></select>
                </my-horizontal-form>
            </div>

            <my-form-buttons is-invalid="userForm.$invalid" return-to="{{route('admin_user')}}"></my-form-buttons>


        </form>
    </div>
</div>
@endsection