@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="main" ng-controller="{{$ctrl}}">

        <div class="page-header">
            <h2>{{$title}} Event </h2>
        </div>

        <form class="form-horizontal" name="eventForm" role="form" ng-submit="eventForm.$valid && save()">


            <div ng-if="config.errors" class="alert alert-danger" role="alert" ng-cloak>
                <div ng-repeat="error in config.errors">
                    @{{error[0]}}
                </div>
            </div>

            <my-form-buttons is-invalid="eventForm.$invalid" return-to="{{route('admin.events.index')}}"></my-form-buttons>

            <div class="upload-btn btn btn-primary" ngf-select ng-model="files" ngf-multiple="true" ng-disabled="config.inLimit">
                <i class="glyphicon glyphicon-upload"></i>Upload Banner
            </div>

            <div class="image-upload clearfix">
                <div class="row">
                    <div class="col-md-4" ng-repeat="img in images">
                        <div class="image-upload-block">
                            <img class="img-responsive" ng-src="{{url()}}/@{{img.path}}/@{{img.fileName}}" alt="">
                        </div>
                        <div>
                            <input class="radio" type="radio" ng-model="imgData.primaryImage" ng-value="img.fileName"> &nbsp;Select as Primary Photo
                        </div>
                        <button class="btn btn-danger" ng-click="deleteImage(img.fileName, $index)" my-prevent-default>
                            <i class="glyphicon glyphicon-remove"></i>Delete image
                        </button>
                    </div>
                </div>
            </div>

            <my-horizontal-form label-size="2" label="Name" value-size="8">
                <input type="text" class="form-control" ng-model="data.name" required>
            </my-horizontal-form>

            <my-horizontal-form label-size="2" label="Start Date" value-size="8">
                <input type="date" class="form-control" ng-model="data.start_date" required>
            </my-horizontal-form>

            <my-horizontal-form label-size="2" label="End Date" value-size="8">
                <input type="date" class="form-control" ng-model="data.end_date" required>
            </my-horizontal-form>


            <my-horizontal-form label-size="2" label="Start time in a day" value-size="8">
                <input type="time" class="form-control" ng-model="data.start_day_time">
            </my-horizontal-form>

            <my-horizontal-form label-size="2" label="End time in a day" value-size="8">
                <input type="time" class="form-control" ng-model="data.end_day_time">
            </my-horizontal-form>

            <my-static-display label-size="2" label="Status" value-size="8">
                @{{ data.status == 1 ? 'Active' : 'Inactive' }}
            </my-static-display>

        </form>
    </div>
</div>
@stop