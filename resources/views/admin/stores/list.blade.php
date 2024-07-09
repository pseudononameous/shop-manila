@extends('layouts.admin') @section('content')
<div class="container">
    <div class="main" ng-controller="StoreListCtrl">

        <div class="page-header">
            <h1>Stores</h1>
            <div class="list-add-btn pull-right">
                <a href="{{route('admin.stores.create')}}" class="btn btn-primary">Create Store</a>
            </div>
        </div>

        <div class="admin-content">
    
        <table class="table table-stripped">

            <thead>
                <th>Name</th>
                <th class="w85">Description</th>
                <th>Operations</th>
            </thead>

            <tbody>

                @foreach($data as $d)
                <tr>
                    <td>{{$d->name}}</td>
                    <td>{{$d->description}}</td>

                    <td data-title="'Operations'" class="table-ops">
                        <a href="{{route('admin.stores.edit', $d->id)}}">
                            Edit
                        </a> |
                        <a ng-click="delete({{$d->id}})" class="del">
                            Delete
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        
        </div>
        
    </div>
</div>
@endsection