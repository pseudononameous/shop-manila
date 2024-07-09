@extends('layouts.admin')
@section('content')
    <div class="container" id="dashboard">
        <div class="row">
            @if(!Auth::user()->guest() && Auth::user()->get()->store_id==null)
            <div class="col-xs-2">
                <span class="article_header">Pending Order Item</span>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>Today</p>
                        <div class="right-box green">{{$orderState['orderPendingToday']}}</div>
                    </div>
                </div>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>Yesterday</p>
                        <div class="right-box orange">{{$orderState['orderPendingYesterday']}}</div>
                    </div>
                </div>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>Older</p>
                        <div class="right-box red">{{$orderState['orderPendingOlder']}}</div>
                    </div>
                </div>
                
                <br/>
                <span class="article_header">All Order Items</span>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>Today</p>
                        <div class="right-box gray">{{$orderState['allOrderToday']}}</div>
                    </div>
                </div>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>In the last 30 days</p>
                        <div class="right-box gray">{{$orderState['allOrderPastThirtyDays']}}</div>
                    </div>
                </div>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>Shipped</p>
                        <div class="right-box gray">{{$orderState['allOrderShipments']}}</div>
                    </div>
                </div>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>Returned</p>
                        <div class="right-box gray">{{$orderState['allOrderReturned']}}</div>
                    </div>
                </div>
                <div class="panel panel-default panel-cust">
                    <div class="panel-heading">
                        <p>Cancelled</p>
                        <div class="right-box gray">{{$orderState['allOrderCancelled']}}</div>
                    </div>
                </div>
                
                
                
            </div>
            @endif
            <div class="col-xs-10">


                <span class="article_header">News and Updates</span>

                @foreach($news as $n)
                    <article>
                        <span class="title">{{$n->title}}</span>
                        <span class="time"><i class="fa fa-clock-o"></i> {{date('M d, Y', strtotime( $n->created_at ))}} </span>

                        @foreach($n->newsImage as $image)
                            @if($image->is_primary)
                                <img class="center-block img-responsive" src="{{url($image->path . $image->file_name)}}" alt="">
                            @endif
                        @endforeach

                        <div>
                            {!! $n->content !!}
                        </div>

                    </article>
                @endforeach

                {!! $news->render() !!}

            </div>

        </div>
    </div>
@endsection