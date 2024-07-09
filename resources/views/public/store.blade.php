@extends('layouts.master')
@section('content')
    @include('includes.subNav')

    <div class="container">

        <div class="banner">
            <h2>
                @if($banner)
                    <img class="img-responsive" src="{{url($banner->path . $banner->file_name)}}" alt="">
                @else
                    {{$title}}
                @endif
            </h2>
        </div>
        
        <div class="category-filter" ng-controller="SearchCtrl">
            <p class="category-sort">SORT BY: </p>
            <span ng-click="sortItems('created_at')">NEW ARRIVALS</span> |
            <span ng-click="sortItems('price')">PRICE<span style="text-transform: lowercase">(low to high)</span></span> |
            <span ng-click="sortItems('sale_only')">ON SALE</span> |
            <span ng-click="sortItems('men')">MEN</span> |
            <span ng-click="sortItems('women')">WOMEN</span> |
            <span ng-click="sortItems('kids')">KIDS</span>
        </div>
        
        <section>
            <div class="row">
                <div class="brand categories col-md-3">
                    <!--
                    <div class="filter" ng-controller="SearchCtrl">
                        <div class="dropdown">
                            <select class="form-control" ng-model="data.sort" ng-change="sortItems()">
                                <option value="sale_only">What's on Sale</option>
                                <option value="name">By Name</option>
                                <option value="price">By Price</option>
                                <option value="created_at">By Date</option>
                            </select>
                        </div>
                    </div>
                    -->
                    <div class="block">
                        <div class="store-description">{{$store->description}}</div>
                    </div>
                    <div class="store-videos">
                         <div class="row">                             
                            @foreach($store->storeVideo as $video)
                                <div class="col-md-12 col-sm-4 col-xs-6">
                                    <div class="embed-responsive embed-responsive-4by3">
                                    <iframe class="embed-responsive-item" src="{{$video->video_link}}" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        
                        @foreach($items as $i)
                            <div class="col-md-4">
                                <a href="{{route('item_page', $i->slug)}}">
                                    <div class="product_block">
                                        <div class="product_image">
                                            @foreach($i->itemImage as $image)
                                                @if($image->is_primary)
                                                    <img class="center-block img-responsive" src="{{url($image->path . $image->file_name)}}" alt="">
                                                @endif
                                            @endforeach
                                        </div>
                                        <span class="product_name">{{$i->store->name}}</span>
                                        <span class="product_desc">{{$i->name}}</span>
                                        @if($i->on_sale)
                                            <span class="product_price" style="text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>
                                            <span class="product_price"> {{Helper::getPercentDeducted($i->price, Helper::getItemPrice($i))}}</span>
                                            <span class="product_price" style="color:red; ">{{Helper::getCurrency()}} {{Helper::numberFormat($i->discounted_price)}}</span>
                                        @else
                                            <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            {!! $items->appends(['sort' => $sortRequest['sort']])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

@endsection