@extends('layouts.master') @section('content')


<!-- Modal Note -->
<style>
.modal {
  text-align: center;
  padding: 0!important;
}
.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<style>

</style>
<div class="modal" id="myModal" style="padding-right: 12px !important;">
    <div class="modal-dialog" style="max-width: 526px;">
        <a class="close" data-dismiss="modal" style="    position: absolute; right: 10px; opacity: 1; font-size: 30px; color: #fff;">×</a>
        <img src="{{url()}}/images/note1.jpg" class="img-responsive">
    </div>
</div>

<script type="text/javascript">
  $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>
<!-- End of Modal Note -->

<div class="toparea container">
    
    <div class="row">

        <div class="categories col-xs-12 col-sm-3 col-md-2">
            @include('includes.sidebar')
        </div>
     

        <div class="col-xs-12 col-sm-7 col-md-8">
            <div id="home_gallery" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#home_gallery" data-slide-to="0" class="active"></li>
                    <li data-target="#home_gallery" data-slide-to="1"></li>
                    <li data-target="#home_gallery" data-slide-to="2"></li>
                    <li data-target="#home_gallery" data-slide-to="3"></li>
                    <li data-target="#home_gallery" data-slide-to="4"></li>
                    <li data-target="#home_gallery" data-slide-to="5"></li>
<!--                    <li data-target="#home_gallery" data-slide-to="6"></li>-->
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
<!--
                    <div class="item active">
                        <a href="{{url()}}/page/store/fish-n-chips"><img src="{{url()}}/images/slides/slide-base-london.jpg" alt="Click to go to gallery"></a>
                    </div>
-->
                    
                    <div class="item active">
                        <a href="{{ url('authCustomer/register') }}"><img src="{{url()}}/images/slides/slide2.jpg" alt="Click to go to gallery"></a>

                    </div>
                    <div class="item">
                        <a href="{{url()}}/page/store/easy-soft"><img src="{{url()}}/images/slides/slide3.jpg" alt="Click to go to gallery"></a>
                        <div class="carousel-caption">
                            <!--                        Caption Goes here.-->
                        </div>
                    </div>
                    <div class="item">
                        <a href="{{url()}}/search/items?q=ginebra&sort=created_at"><img src="{{url()}}/images/slides/slide4.jpg" alt="Click to go to gallery"></a>
                     </div>
                    
                    <div class="item">
                        <a href="{{url()}}/page/store/7-soles"><img src="{{url()}}/images/slides/slide5.jpg" alt="Click to go to gallery"></a>
                        

                    </div> 
                    <div class="item">
                        <a href="{{url()}}/page/store/world-balance"><img src="{{url()}}/images/slides/slide6.jpg" alt="Click to go to gallery"></a> 
                    </div>     
                    <div class="item">
                        <a href="{{url()}}/search/items?q=freedom%20spark&sort=created_at"><img src="{{url()}}/images/slides/slide7.jpg" alt="Click to go to gallery"></a> 
                    </div>     
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#home_gallery" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#home_gallery" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!--/Carousel-->
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2">
            <div class="ads-right">
                <div class="col-md-12 col-sm-12 col-xs-4 no-padding">
                    <a href="{{url()}}/page/store/base-london"><img class="img-responsive" src="{{url()}}/images/ad-right1.jpg" alt=""></a>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-4 no-padding">
                    <a href="{{url()}}/page/store/7-soles"><img class="img-responsive" src="{{url()}}/images/ad-right4.jpg" alt=""></a>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-4 no-padding">
                    <a href="{{url()}}/page/store/east-rock"><img class="img-responsive" src="{{url()}}/images/ad-right3.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    
   
    

    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="promo" style="margin-bottom:20px;">
                    <a href="{{ url('page/events') }}"><img class="img-responsive" src="{{url()}}/images/promo2.jpg" alt=""></a>
                </div>
            </div>           
            <div class="col-md-12">
                <div class="promo">
                    <a href="{{ url('authCustomer/register') }}"><img class="img-responsive" src="{{url()}}/images/promo1.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </section>

<!--
    <section>
        <span class="_hot"></span>
        <div class="row hot">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <img src="{{url()}}/images/featuredimg1.jpg" alt="" class="img-responsive">
                <span><a href="#">Shop Now</a></span>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <img src="{{url()}}/images/featuredimg2.jpg" alt="" class="img-responsive">
                <span><a href="#">Shop Now</a></span>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <img src="{{url()}}/images/featuredimg3.jpg" alt="" class="img-responsive">
                <span><a href="#">Shop Now</a></span>
            </div>
        </div>
    </section>
-->

    <section>
        <h2><span class="highlight">Featured Brands</span></h2>
        <div class="row featured">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <ul class="bxslider">
                    @foreach($stores as $s)

                        @foreach($s->storeLogo as $image)
                            @if($image->is_primary)
                                <li>
                                    <a href="{{route('store_page', $s->slug)}}">
                                        <img class="img-responsive" src="{{url($image->path . $image->file_name)}}" alt="">
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endforeach

                </ul>
            </div>
        </div>
    </section>
<!--
    <section>
        <div class="row">
            <h2><span class="highlight">Today's Deal</span></h2>
            <div class="col push-it">
                <div class="shoes-back"></div>
                <div class="shoes-front"></div>
                <div class="caption">
                    <h2>Push it to the limit.<span>Endure</span></h2>
                    <p>Our toughest running shoe to date. Equipped with reinforced microfiber upper, as well our TERRA-SOFT insole technology. GET INTO WORLD BALANCE</p>
                                            <a class="shopnow" href="#">Shop Now</a>
                </div>
            </div>
        </div>
    </section>
-->
    <section>
       <h2><span class="highlight">Featured Products</span></h2>
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="row">

                    @foreach($items as $i)
                    <div class="col-xs-6 col-sm-6 col-md-4">
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
                                    <span class="product_price" style="color:red; text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>
                                    <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat($i->discounted_price)}}</span>
                                @else
                                    <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>
                                @endif
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="newlooks">
                    <a href="{{url()}}/page/store/7-soles" target="_blank"><img class="img-responsive" src="{{url()}}/images/newestimg1.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </section>
    </div>

    @endsection