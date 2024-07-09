@extends('layouts.master') 
@section('content')

    <h1>{{$category->name}}</h1>


    @foreach($items as $item)

        <li>
        	<a href="/store/{{$storeSlug}}/item/{{$item->slug}}">{{$item->name}}</a>
        </li>

    @endforeach

@endsection