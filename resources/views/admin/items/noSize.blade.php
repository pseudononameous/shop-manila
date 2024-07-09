@extends('layouts.admin') @section('content')
<div class="container">

    <div class="main" ng-controller="ItemListCtrl">
        <div class="page-header">
            <h1>No Size Item</h1>
            <div class="list-add-btn pull-right">

            </div>
        </div>

        <div class="admin-content">

            <div ng-controller="SearchCtrl">

                <form name="searchForm" class="form-horizontal" ng-submit="searchForm.$valid && search('created_at', 'admin/search/items/no-size')">
                    <div class="form-group">

                        <div class="col-md-4">
                            <label for="item" class="control-label">Store</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['store']">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="search-btn">
                                    <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid">Search</button>
                                    <a class="btn btn-default" href="{{URL('admin/item/no-size')}}">Clear</a>
                                </div>
                            </div>
                        </div>


                    </div>

                </form>
            </div>


            <table class="table table-stripped">
                <thead>
                    <th>Store</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Operations</th>
                </thead>
                <tbody>

                    @foreach($data as $d)
                    <tr>
                        <td>{{$d->store->name}}</td>
                        <td>{{$d->name}}</td>
                        <td>{{$d->short_description}}</td>
                        <td>{{""}}</td>
                        <td>{{""}}</td>
                        <td data-title="'Operations'" class="table-ops">

                            <a href="{{route('admin.items.edit', $d->id)}}">
                                Edit
                            </a>
                            <span ng-click="delete({{$d->id}})">Delete</span>
                        </td>

                    </tr>

                    @endforeach
                </tbody>
            </table>

            {!! $data->appends(['item' => $item, 'store' => $store, 'hasImage' => $hasImage, 'status' => $status])->render() !!}

        </div>

    </div>

</div>
@endsection