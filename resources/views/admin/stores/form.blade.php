@extends('layouts.admin') 
@section('content')

<div class="container">
    <div ng-controller="{{$ctrl}}">

        <div class="page-header">
            <h2>{{$title}} Store</h2>
        </div>

        <form class="form-horizontal" name="storeForm" role="form" ng-submit="storeForm.$valid && save()">

            <my-form-buttons is-invalid="storeForm.$invalid" return-to="{{route('admin.stores.index')}}"></my-form-buttons>

            <div class="clearfix"></div>

            <div ng-if="data.errors" class="alert alert-danger" role="alert" ng-cloak>
                <div ng-repeat="error in data.errors">
                    @{{error[0]}}
                </div>
            </div>

            <fieldset class="col-md-6">

                <div>

                    <div class="btn btn-primary" ngf-select ng-model="files" ngf-multiple="false"  ng-disabled="config.photoInLimit">
                        <i class="glyphicon glyphicon-upload"></i>Upload Banner
                    </div>

                    <div class="image-upload clearfix">

                        Banner:
                        <div ng-repeat="img in images">

                            <img class="img-responsive" ng-src="{{url()}}/@{{img.path}}/@{{img.fileName}}" alt="">

                            <button class="btn btn-danger" ng-click="deleteImage(img.fileName, $index)" my-prevent-default>
                                <i class="glyphicon glyphicon-remove"></i>Delete image
                            </button>

                        </div>

                    </div>

                </div>

                <br>
                <br>
                <br>

                <div>

                    <div class="btn btn-primary" ngf-select ng-model="logoFiles" ngf-multiple="false"  ng-disabled="config.logoInLimit">
                        <i class="glyphicon glyphicon-upload"></i>Upload Logo
                    </div>
                    
                    <span style="font-size:12px; margin-left:20px;">Please upload a square image, preferably <strong style="font-size:13px;">100x100</strong></span>

                    <div class="image-upload clearfix">

                        Logo:
                        <div ng-repeat="logo in logos">

                            <img class="img-responsive" ng-src="{{url()}}/@{{logo.path}}/@{{logo.fileName}}" alt="">

                            <button class="btn btn-danger" ng-click="deleteLogo(logo.fileName, $index)" my-prevent-default>
                                <i class="glyphicon glyphicon-remove"></i>Delete image
                            </button>

                        </div>

                    </div>

                </div>

                <my-horizontal-form label-size="2" label="Name" value-size="8">
                    <input type="text" class="form-control" ng-model="data.name" required>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Video link 1" value-size="8">
                    <input type="text" class="form-control" ng-model="videos.video_link[0]">
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Video link 2" value-size="8">
                    <input type="text" class="form-control" ng-model="videos.video_link[1]">
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Video link 3" value-size="8">
                    <input type="text" class="form-control" ng-model="videos.video_link[2]">
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Description" value-size="8">
                    <textarea class="form-control" ng-model="data.description" required></textarea>
                </my-horizontal-form>

                <my-horizontal-form label-size="2" label="Status" value-size="8">
                    <select class="form-control" ng-model="data.option_status_id">
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </my-horizontal-form>

            </fieldset>



        </form>
    </div>
</div>
@endsection