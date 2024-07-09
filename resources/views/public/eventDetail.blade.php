@extends('layouts.master')
@section('content')
    @include('includes.subNav')

    <div class="container">

        <div class="banner">
            <h2>

                @foreach($event->eventImage as $eImg)
                    @if(! $eImg->is_primary)
                        <img class="img-responsive" src="{{url($eImg->path . $eImg->file_name)}}" alt="">
                    @endif
                @endforeach
            </h2>
        </div>

        <section>
            <div class="row">
                <div class="brand categories col-md-3">

                    <div class="filter">
                        <div class="dropdown" ng-controller="SearchCtrl">

                            <select class="form-control" ng-model="data.sort" ng-change="sortItems()">
                                <option value="name">By Name</option>
                                <option value="event_price">By Price</option>
                                <option value="created_at">By Date</option>
                            </select>

                        </div>
                    </div>

                </div>


                <div class="col-md-9">
                    <div class="row">

                        @foreach($itemEvent as $i)
                            <div class="col-md-4">
                                <a href="{{route('item_page', [$i->item->slug, $i->event->slug])}}">
                                    <div class="product_block">
                                        <div class="product_image">
                                            @foreach($i->item->itemImage as $image)
                                                @if($image->is_primary)
                                                    <img class="center-block img-responsive" src="{{url($image->path . $image->file_name)}}" alt="">
                                                @endif
                                            @endforeach
                                        </div>
                                        <span class="product_name">{{$i->item->store->name}}</span>
                                        <span class="product_desc">{{$i->item->name}}</span>


                                        <span class="product_price" style="color:red; text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($i->item->price)}}</span>
                                        <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat($i->event_price)}}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach


                    </div>

                    <div class="col-md-12">
                        <div class="pull-right">

                            {!! $itemEvent->render() !!}

                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

@endsection