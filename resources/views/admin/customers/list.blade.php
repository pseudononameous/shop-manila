@extends('layouts.admin') @section('content')
    <div class="container">
        <div class="main" ng-controller="CustomerListCtrl">

            <div class="page-header">
                <h1>Customers Management</h1>
            </div>

            <div class="admin-content">

                <div ng-controller="SearchCtrl">

                    <form name="searchForm" class="form-horizontal"
                          ng-submit="searchForm.$valid && search('created_at', 'admin/search/customers')">
                        <div class="form-group">

                            <div class="col-md-2">
                                <label for="item" class="control-label">Name</label>
                                <div>
                                    <input type="text" class="form-control" ng-model="data.query['customerName']">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="item" class="control-label">Email</label>
                                <div>
                                    <input type="text" class="form-control" ng-model="data.query['customerEmail']">
                                </div>
                            </div>

                            <div class="col-md-2">

                                <label for="item" class="control-label">Birth Month</label>
                                <div>
                                    <select ng-model="data.query['birthMonth']" class="form-control">
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                            echo '<option value="' . $m . '">' . $month . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="search-btn">
                                        <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid">
                                            Search
                                        </button>
                                        <a class="btn btn-default" href="{{route('admin.customers.index')}}">Clear</a>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>

                <table class="table table-stripped">

                    <thead>

                    <th>Name</th>
                    <th>Email</th>
                    <th>Successful Order</th>
                    <th>Birthday</th>
                    <th>Operations</th>

                    </thead>

                    <tbody>

                    @foreach($data as $d)
                        {{-- */$complete_order = 0;/* --}}
                        @foreach($d->orderHeader as $r)
                            @if($r->optionOrderStatus->name=="Complete")
                                {{-- */$complete_order++;/* --}}
                            @endif
                        @endforeach
                        <tr>
                            <td>{{$d->name}}</td>
                            <td>{{$d->email}}</td>
                            <td>{{$complete_order}}</td>
                            <td>{{date('M d, Y', strtotime($d->birthday))}} </td>

                            <td data-title="'Operations'" class="table-ops">
                                <a href="{{route('admin.customers.show', $d->id)}}">
                                    View
                                </a>
                                <!--
                        <span ng-click="delete({{$d->id}})">
                            Delete
                        </span>
                        -->
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $data->appends(['birthMonth' => $birthMonth])->render() !!}
            </div>
        </div>
    </div>
@endsection
