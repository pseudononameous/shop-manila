@extends('layouts.admin') @section('content')
<div class="container">

    <div class="main" ng-controller="NewsListCtrl">
        <div class="page-header">
            <h1>News</h1>
            <div class="list-add-btn pull-right">
                <a href="{{route('admin.news.create')}}" class="btn btn-primary">Create News</a>
            </div>
        </div>

        <div class="admin-content">

            <table class="table table-stripped">
                <thead>
                    <th>Title</th>
                    <th>Date Created</th>
                    <th>Operations</th>
                </thead>
                <tbody>

                    @foreach($data as $d)
                    <tr>
                        <td>{{$d->title}}</td>
                        <td>{{ date('M d, Y', strtotime($d->created_at)) }}</td>


                        <td data-title="'Operations'" class="table-ops">
                            <a href="{{route('admin.news.edit', $d->id)}}">
                            Edit
                        </a> |
                            <a ng-click="delete({{$d->id}})" class="del">Delete</a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $data->render() !!}

        </div>

    </div>

</div>
@endsection