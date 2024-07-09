@extends('layouts.admin') @section('content')

    <div class="container">
        <div ng-controller="{{$ctrl}}">

            <div class="page-header">
                <h1>{{$title}} Item</h1>
            </div>

            <!-- Nav tabs -->
            <ul class="product_tabs nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Main</a></li>
                <li role="presentation"><a href="#categories" aria-controls="categories" role="tab" data-toggle="tab">Categories</a></li>
                <li role="presentation"><a href="#sizes" aria-controls="sizes" role="tab" data-toggle="tab">Sizes</a></li>
                <li role="presentation"><a href="#images" aria-controls="images" role="tab" data-toggle="tab">Images</a></li>
                <li role="presentation"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Event</a></li>
            </ul>

            <form class="form-horizontal" name="itemForm" role="form" ng-submit="itemForm.$valid && save()">

                <div class="tab-content clearfix">
                    <div role="tabpanel" class="tab-pane active" id="main">

                        <div class="clearfix"></div>

                        <div ng-if="config.errors" class="alert alert-danger" role="alert" ng-cloak>
                            <div ng-repeat="error in config.errors">
                                @{{error[0]}}
                            </div>
                        </div>

                        <fieldset class="col-md-12">

                            @if(is_null($userStoreId))
                                <my-horizontal-form label-size="2" label="Store" value-size="8">
                                    <select class="form-control" ng-options="s.name for s in options.stores" ng-model="data.store" required></select>
                                </my-horizontal-form>
                            @endif

                            <my-horizontal-form label-size="2" label="Name" value-size="8">
                                <input type="text" class="form-control" ng-model="data.name" required>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Sku" value-size="8">
                                <input type="text" class="form-control" ng-model="data.sku" required>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Color" value-size="8">
                                <input type="text" class="form-control" ng-model="data.short_description" required>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Tags" value-size="8">
                                <tags-input ng-model="tags"></tags-input>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Description" value-size="8">
                                <textarea class="form-control" ng-model="data.description" required my-ck-editor></textarea>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Price" value-size="8">
                                <input type="text" class="form-control" ng-model="data.price" required>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="On Sale?" value-size="8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" ng-model="data.on_sale" ng-checked="data.on_sale"> Yes
                                    </label>
                                </div>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Discounted Price" value-size="8">
                                <input type="text" class="form-control" ng-model="data.discounted_price">
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Discounted Price Start Date" value-size="8">
                                <input type="date" class="form-control" ng-model="data.discounted_price_start_date">
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Discounted Price End Date" value-size="8">
                                <input type="date" class="form-control" ng-model="data.discounted_price_end_date">
                            </my-horizontal-form>


                            <my-horizontal-form label-size="2" label="Quantity" value-size="8" class="hide">
                                <input type="text" class="form-control" ng-model="data.qty" value="0">
                            </my-horizontal-form>


                            @if(Auth::user()->get()->hasRole('admin'))
                                <my-horizontal-form label-size="2" label="Is Featured?" value-size="8">
                                    <input type="checkbox" ng-model="data.is_featured"> Yes
                                </my-horizontal-form>
                            @endif

                            <my-horizontal-form label-size="2" label="Status" value-size="8">
                                <select class="form-control" ng-model="data.option_status_id">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </my-horizontal-form>
                        </fieldset>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="categories">
                        <fieldset class="col-md-12">
                            <legend>Category</legend>

                            <div class="col-md-4">
                                <div ng-repeat="c in options.categories">
                                    <div class="checkbox" ng-if="$index > 3 && $index <= 7">
                                        <label>
                                            <input type="checkbox" ng-model="c.selected" ng-checked="c.selected"> @{{c.name}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div ng-repeat="c in options.categories">
                                    <div class="checkbox" ng-if="$index > 7 && $index <= 12">
                                        <label>
                                            <input type="checkbox" ng-model="c.selected" ng-checked="c.selected"> @{{c.name}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div ng-repeat="c in options.categories">
                                    <div class="checkbox" ng-if="$index <= 3">
                                        <label>
                                            <input type="checkbox" ng-model="c.selected" ng-checked="c.selected"> @{{c.name}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="sizes">
                        <fieldset class="col-md-12">
                            <legend>Size</legend>
                            <div ng-repeat="s in options.sizes">
                                <div class="checkbox col-md-6">
                                    <label>
                                        <input type="checkbox" ng-model="s.selected" ng-checked="s.selected"> @{{s.name}}
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Stock" ng-model="size.stock[$index]">
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="images">
                        <p class="bg-success">Please upload a square image, preferably <strong>2000x2000</strong></p>
                        <div class="upload-btn btn btn-primary" ngf-select ng-model="files" ngf-multiple="true" ng-disabled="config.inLimit">
                            <i class="glyphicon glyphicon-upload"></i>Upload Image/s
                        </div>

                        <div class="image-upload clearfix">
                            <div class="row">
                                <div class="col-md-4" ng-repeat="img in images">
                                    <div class="image-upload-block">
                                        <img class="img-responsive" ng-src="{{url()}}/@{{img.path}}/@{{img.fileName}}" alt="">
                                    </div>
                                    <p>
                                        <input type="radio" ng-model="imgData.primaryImage" ng-value="img.fileName"> &nbsp;Select as Primary Photo</p>
                                    <button class="btn btn-danger" ng-click="deleteImage(img.fileName, $index)" my-prevent-default>
                                        <i class="glyphicon glyphicon-remove"></i>Delete image
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="events">

                        <button class="btn btn-primary" ng-click="addEvent()" my-prevent-default><i class="fa fa-plus"></i></button>


                        <div ng-repeat="ev in config.events">


                            <my-horizontal-form label-size="2" label="Event" value-size="8">
                                @if($ctrl == 'EditItemCtrl')
                                    @{{ event.event[$index].name }}
                                @endif
                                <select class="form-control" ng-options="e.name for e in options.events" ng-model="event.event[$index]">
                                    @if($ctrl == 'AddItemCtrl')
                                        <option value="">N/A</option>
                                    @endif
                                </select>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Event Price" value-size="8">
                                <input type="text" class="form-control" ng-model="event.price[$index]">
                            </my-horizontal-form>

                        </div>

                        <div class="col-md-2" ng-if="! config.eventIsMinimum">
                            <button class="btn btn-primary" ng-click="removeEvent()" my-prevent-default><i class="fa fa-close"></i></button>
                        </div>

                        <!--
                        <div ng-repeat="e in options.events">

                            <my-horizontal-form label-size="2" label="Event" value-size="8">
                                <select class="form-control" ng-options="e.name for e in options.events" ng-model="data.event">
                                    <option value="">N/A</option>
                                </select>
                            </my-horizontal-form>

                            <my-horizontal-form label-size="2" label="Event Price" value-size="8">
                                <input type="text" class="form-control" ng-model="size.stock[$index]">
                            </my-horizontal-form>

                        </div>
                        -->

                        <my-form-buttons is-invalid="itemForm.$invalid" return-to="{{route('admin.items.index')}}"></my-form-buttons>
                    </div>

                </div>
                <!-- END: tab-content -->
            </form>

        </div>
@endsection