@extends('layouts.master')

@section('content')

    @include('includes.subNav')
    <div class="container">



<!--         <div class="brand categories col-md-12">
    <div class="filter" ng-controller="SearchCtrl">
        <div class="dropdown">
            <select class="form-control" ng-model="data.sort" ng-change="search(data.sort, 'search/items')">
                <option value="name">By Name</option>
                <option value="price">By Price</option>
                <option value="created_at">By Date</option>
            </select>
        </div>
    </div>
</div>
 -->
        <section>

            <div class="row">
                <div class="col-md-12">

                    @if($result == 0)
                        <br />
                        <span class="text-danger">Your search</span><b> "{{$query}}" </b> <span class="text-danger">did not match any items.</span>
                        <h4 class="text-success"><Strong>Why don't you check these other items?</Strong></h4>

                    @endif
                </div>

                <div class="col-md-12">
                    <div class="row">
                        @if($status)
                            @foreach($items as $i)
                                <div class="col-md-3">
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
                                                <span class="product_price" style="color:red; text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>
                                                <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat(Helper::getItemPrice($i))}}</span>
                                            @else
                                                <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat( Helper::getItemPrice($i) )}}</span>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>



                    <div class="col-md-12">
                        <div class="pull-right">
                            {!! $items->appends(['q' => $query, 'sort' => $sort])->render()!!}
                        </div>
                    </div>
                </div>

            </div>

        </section>



    </div>



@endsection
