@extends('layouts.admin')
@section('content')
<div class="container">
    
    <div class="main" ng-controller="SalesReportCtrl">

        <div class="page-header">
            <h1>Sales Report</h1>
        </div>

        <div>
            <select ng-model="data.filter" ng-change="filter()">
                <option value="24hrs">Within 24hrs</option>
                <option value="thisWeek">This Week</option>
                <option value="thisMonth">This Month</option>
                {{--<option value="thisYear">This Year</option>--}}
                {{--<option value="lifetime">Lifetime</option>--}}
            </select>
        </div>


        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div id="chart_div"></div>

    </div>
    
</div>

@endsection