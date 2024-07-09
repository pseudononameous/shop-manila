@extends('layouts.master')

@section('content')

	<div ng-controller="ItemDetailCtrl">
		
		<h1>{{$item->name}}</h1>

		<div class="well">
			{{$item->short_description}}
		</div>

		<form name="itemForm" class="form-horizontal" ng-submit="itemForm.$valid && add()">
			
			<div>
				<label for="qty">Qty</label>
				<input type="number" ng-model="data.qty">
			</div>

			<div>
				<button class="btn btn-success" ng-disabled="itemForm.$invalid">Add to Cart</button>
			</div>

		</form>

	</div>

	
@endsection