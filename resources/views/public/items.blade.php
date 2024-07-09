@extends('layouts.master')
@section('content')
    @include('includes.subNav')

<div class="container">

    <div class="banner">
        <h2>
            <span class="highlight">{{$title}}</span>
        </h2>
    </div>

   <div class="category-filter" ng-controller="SearchCtrl">
        <p class="category-sort">SORT BY : </p>
        <span ng-click="sortItems('created_at')">New Arrivals</span> |
        <span ng-click="sortItems('price')">Price <span style="text-transform: lowercase !important;">(low to high)</span></span> |
        <span ng-click="sortItems('sale_only')">On Sale</span>
    </div>

    <section>
        <div class="row">
            <div class="brand categories col-md-3">

                <!--
                <div class="filter">
                    <div class="dropdown" ng-controller="SearchCtrl">

                        <select class="form-control" ng-model="data.sort" ng-change="sortItems()">
                            <option value="sale_only">What's on Sale</option>
                            <option value="name">By Name</option>
                            <option value="price">By Price</option>
                            <option value="created_at">By Date</option>
                        </select>
                    </div>
                </div>
                -->

                    @include('includes.sidebar')

            </div>


            <div class="col-md-12">


                <div class="row">

                    @foreach($items as $i)
                        <div class="col-md-3 col-sm-3 col-xs-12">
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

                                    @if($i->on_sale || ($i->event_id) )
                                            <span class="product_price prod_disc" style="text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>
                                            <span class="product_price prod_disc prod_disc_val"> {{Helper::getPercentDeducted($i->price, Helper::getItemPrice($i))}}</span>
                                            <span class="product_price" style="color:red; ">{{Helper::getCurrency()}} {{Helper::numberFormat(Helper::getItemPrice($i))}}</span>
                                    @else
                                            {{--<span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>--}}
                                            <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat( Helper::getItemPrice($i) )}}</span>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endforeach


                </div>

                <div class="col-md-12">
                    <div class="pull-right">

                        @if (count($sortRequest) > 0 && array_key_exists("sort", $sortRequest))
                        {!! $items->appends(['sort' => $sortRequest["sort"]])->render() !!}
                            @else
                            {!! $items->render() !!}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--
    <section>
        <h2><span class="highlight">Related Products</span></h2>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h2><span class="highlight">You May Also Like</span></h2>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="product_block">
                            <img src="{{url()}}/images/product_img1.jpg" alt="">
                            <span class="product_name">Product Name</span>
                            <span class="product_desc">Short Description</span>
                            <span class="product_price">PHP 0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    -->

</div>

@endsection
