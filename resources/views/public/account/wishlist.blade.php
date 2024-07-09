@extends('layouts.master') @section('content')

    <div class="container" ng-controller="WishlistCtrl">
        <div class="row">
            <div class="order-heading">
                <div class="col-md-12">
                    <h2><span class="highlight">Wishlist</span></h2>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="product-form">


                <div class="data-heading">

                    <div class="row">
                        <div class="col-md-2">
                            <span>Item</span>
                        </div>
                        <div class="col-md-2">
                            <span>Description</span>
                        </div>
                        <div class="col-md-1">
                            <span>Actions</span>
                        </div>
                    </div>
                </div>


                <div class="data-content">

                    @foreach($wishlist as $w)
                        <div class="row order">

                            <div class="col-md-2">
                                <span><a href="{{route('item_page', $w->item->slug)}}">{{$w->item->name}}</a></span>
                            </div>
                            <div class="col-md-2">
                                <p>{{$w->item->short_description}}</p>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-default" ng-click="addToCart({{$w->item->id}})"> Add to Cart</button>
                                <button class="btn btn-default" ng-click="delete({{$w->id}})"> Remove Item</button>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>


@endsection