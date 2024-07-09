@extends('layouts.admin') @section('content')
<div class="container">

    <div class="main" ng-controller="ItemListCtrl">
        <div class="page-header">
            <h1>Stock Management</h1>
            <div class="list-add-btn pull-right">

            </div>
        </div>

        <div class="admin-content">

            <div ng-controller="SearchCtrl">

                <form name="searchForm" class="form-horizontal" ng-submit="searchForm.$valid && search('created_at', 'admin/search/items/stock-management')">
                    <div class="form-group">

                        <div class="col-md-3">
                            <label for="item" class="control-label">Store</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['store']">
                            </div>
                        </div>

                        <div class="col-md-3">

                            <label for="item" class="control-label">Item</label>
                            <div>
                                <input type="text" class="form-control" ng-model="data.query['item']">
                            </div>
                        </div>

                        <div class="col-md-2">

                            <label for="item" class="control-label">Quantity</label>
                            <div>
                                <select ng-model="data.query['stock']" class="form-control">
                                    <option value=""></option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="search-btn">
                                    <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid">Search</button>
                                    <a class="btn btn-default" href="{{URL('admin/item/stock-management')}}">Clear</a>
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
                        <td>{{$d->item->store->name}}</td>
                        <td>{{$d->item->name}}</td>
                        <td>{{$d->item->short_description}}</td>
                        <td>{{$d->optionSize->name}}</td>
                        <td>{{$d->stock}}</td>
                        <td data-title="'Operations'" class="table-ops">

                            <a href="{{route('admin.items.edit', $d->item_id)}}">
                                Edit
                            </a> |
                            <a ng-click="delete({{$d->item_id}})" class="del">Delete</a>
                        </td>

                    </tr>

                    @endforeach
                </tbody>
            </table>

            {!! $data->appends(['item' => $item, 'store' => $store, 'stock' => $stock])->render() !!}

        </div>

    </div>

</div>
@endsection