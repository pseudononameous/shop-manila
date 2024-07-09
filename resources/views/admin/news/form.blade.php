@extends('layouts.admin') @section('content')

<div class="container">
    <div ng-controller="{{$ctrl}}">

        <div class="page-header">
            <h2>{{$title}} News</h2>
        </div>



        <form class="form-horizontal" name="newsForm" role="form" ng-submit="newsForm.$valid && save()">

            <div class="clearfix"></div>

            <div ng-if="config.errors" class="alert alert-danger" role="alert" ng-cloak>
                <div ng-repeat="error in config.errors">
                    @{{error[0]}}
                </div>
            </div>

            <fieldset class="col-md-12">

                <div class="upload-btn btn btn-primary" ngf-select ng-model="files" ngf-multiple="false" ng-disabled="config.inLimit">
                    <i class="glyphicon glyphicon-upload"></i>Featured Image
                </div>

                <div class="image-upload clearfix">
                    <div class="row">
                        <div class="col-md-3" ng-repeat="img in images">
                            <img class="img-responsive" ng-src="{{url()}}/@{{img.path}}/@{{img.fileName}}" alt="">

                            <button class="btn btn-danger" ng-click="deleteImage(img.fileName, $index)" my-prevent-default>
                                <i class="glyphicon glyphicon-remove"></i>Delete image
                            </button>
                        </div>
                    </div>
                </div>

                <my-horizontal-form label-size="2" label="Title" value-size="8">
                    <input type="text" class="form-control" ng-model="data.title">
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Content" value-size="8">
                    <textarea class="form-control" ng-model="data.content" my-ck-editor></textarea>
                </my-horizontal-form>

            </fieldset>

            <my-form-buttons is-invalid="newsForm.$invalid" return-to="{{route('admin.news.index')}}"></my-form-buttons>

        </form>
        
    </div>
    @endsection