@extends('layouts.master')
@section('content')

	<h1>{{$store->name}}</h1>

	@foreach($items as $i)
		<div>
			<a href="{{route('store_item_page', [$store->slug, $i->slug ])}}">{{$i->name}}</a>

		</div>
	@endforeach

@endsection