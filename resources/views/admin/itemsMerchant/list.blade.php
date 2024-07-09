@extends('layouts.admin') @section('content')
    <div class="container">

        <div class="main" ng-controller="ItemListCtrl">
            <div class="page-header">
                <h1>Items Management</h1>
                <div class="list-add-btn pull-right">
                    <a href="{{route('admin.merchant-items.create')}}" class="btn btn-primary">Create Item</a>
                </div>
            </div>

            <div class="admin-content">

                <div ng-controller="SearchCtrl">

                    <form name="searchForm" class="form-horizontal" ng-submit="searchForm.$valid && search('created_at', 'admin/search/merchant-items')">
                        <div class="form-group">

                            <div class="col-md-3">

                                <label for="item" class="control-label">Item</label>
                                <div>
                                    <input type="text" class="form-control" ng-model="data.query['item']">
                                </div>
                            </div>

                            <div class="col-md-2">

                                <label for="item" class="control-label">Has Image?</label>
                                <div>
                                    {{--<input type="text" class="form-control" ng-model="data.query['image']">--}}
                                    <select ng-model="data.query['hasImage']" class="form-control">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">

                                <label for="item" class="control-label">Status</label>
                                <div>
                                    <select ng-model="data.query['status']" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="search-btn">
                                        <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid">Search</button>
                                        <a class="btn btn-default" href="{{route('admin.merchant-items.index')}}">Clear</a>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>



                <table class="table table-stripped">
                    <thead>
                    <th></th>
                    {{--<th>Store</th>--}}
                    <th>Name</th>
                    <th>Has Image?</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Operations</th>
                    </thead>
                    <tbody>

                    @foreach($data as $key=> $d)
                        <tr data-toggle="collapse" data-target="#accordion{{$key}}" class="clickable order-click" {{ ($d->is_modified) ? "style=color:#17A98C" : ''}}>
                            <td style="width: 3%;">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#accordion{{$key}}">
                                </a>
                                <!--                                <i class="fa fa-angle-down" id="fa{{$key}}">-->
                            </td>
                            {{--<td>{{$d->store->name}}</td>--}}
                            <td>{{$d->name}}</td>
                            <td>

                                @if(count($d->itemImage) > 0)
                                    Yes

                                @else
                                    No
                                @endif

                            </td>

                            <td>{{$d->short_description}}</td>
                            <td>{{Helper::numberFormat($d->price)}}</td>
                            <td>{{($d->option_status_id == 1) ? 'Active' : 'Inactive'}}</td>


                            <td data-title="'Operations'" class="table-ops">

                                <a href="{{route('admin.merchant-items.edit', $d->id)}}">
                                    Edit
                                </a>
                                <span ng-click="delete({{$d->id}})">Delete</span>
                            </td>

                        </tr>

                        <tr style="padding: 0" id="accordion{{$key}}" class="collapse order-toggle">
                            <td style="width: 3%;"></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Color</strong></td>
                                    </tr>
                                    <tr>
                                        <td> {{$d->short_description}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <strong>Size</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @foreach($d->itemSize as $k =>$iz)
                                                {{$k + 1 == count($d->itemSize) ?  $iz->optionSize->name : $iz->optionSize->name. ','}}
                                            @endforeach
                                        </td>
                                    </tr>

                                </table>
                            </td>

                        </tr>



                    @endforeach
                    </tbody>
                </table>

                {!! $data->appends(['item' => $item, 'hasImage' => $hasImage, 'status' => $status])->render() !!}

            </div>

        </div>

    </div>
@endsection