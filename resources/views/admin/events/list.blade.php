@extends('layouts.admin')
@section('content')
<div class="container" ng-controller="EventListCtrl">
    <div class="main" >

        <div class="page-header">
            <h1>Events</h1>
            <div class="list-add-btn pull-right">
                <a href="{{route('admin.events.create')}}" class="btn btn-primary">Create Event</a>
            </div>
        </div>



        <div class="admin-content">

            <table class="table table-stripped">

                <thead>

                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Operations</th>

                </thead>

                <tbody>

                    @foreach($data as $d)
                    <tr>
                        <td>{{$d->name}}</td>
                        <td>{{date('M d, Y', strtotime($d->start_date))}}</td>
                        <td>{{date('M d, Y', strtotime($d->end_date))}}</td>
                        <td>{{ (is_null($d->start_day_time)) ? 'N/A' :  date('g:i A', strtotime($d->start_day_time)) }}</td>
                        <td>{{(is_null($d->end_day_time)) ? 'N/A' :  date('g:i A', strtotime($d->end_day_time))}}</td>
                        <td>{{($d->status) ? 'Active' : 'Inactive'}}</td>

                        <td>
                            <a href="{{route('admin.events.edit', $d->id)}}">
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

            {!! $data->render() !!}

        </div>

    </div>
</div>
@endsection