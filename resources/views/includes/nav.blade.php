<nav class="main-menu navbar navbar-default">
    <div class="container remove-padd">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="{{ url('/') }}">
                <img src="{{url()}}/images/logo.png" alt="Shop Manila" />
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav main-nav">

                <li class="dropdown">
                    <a href="{{route('item_category_page', 'women')}}" class="dropdown-toggle" data-toggle="dropdown">Women<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'women')}}">All Women</a></li>
                        @foreach($womenCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="{{route('item_category_page', 'men')}}" class="dropdown-toggle" data-toggle="dropdown">Men <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'men')}}">All Men</a></li>
                        @foreach($menCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="{{route('item_category_page', 'kids')}}" class="dropdown-toggle" data-toggle="dropdown">Kids <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'kids')}}">All Kids</a></li>
                        @foreach($kidsCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fashion <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'fashion')}}">All Fashion</a></li>
                        @foreach($fashionCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Health &amp; Beauty <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'health-and-beauty')}}">All Health</a></li>
                        @foreach($healthCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Electronics &amp; Gadgets <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'electronics-and-gadgets')}}">All Electronics &amp; Gadgets</a></li>
                        @foreach($electronicsCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Travel <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'travel')}}">All Travel</a></li>
                        @foreach($travelCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Home &amp; Living <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'home-and-living')}}">All Home &amp; Living</a></li>
                        @foreach($homeCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gifts <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('item_category_page', 'gifts')}}">All Gifts</a></li>
                        @foreach($giftsCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </li>

            </ul>

            <ul class="list-inline top-nav">
                <li><a href="{{route('events_list_page')}}">Today's Deals</a></li>
                <li><a href="{{url('contact')}}">Customer Care</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">


                @if (Auth::customer()->guest())
                    <li><a href="{{ url('authCustomer/login') }}">Sign In </a></li>
                    <li><a href="{{ url('authCustomer/register') }}">Sign Up</a></li>
                @else
                    <li><a href="{{ url('account/profile') }}">Account</a></li>
                    <li><a href="{{ url('account/orders') }}">Orders</a></li>
                    <li class="dropdown">
                        <a style="margin-left: 1px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="caret"></span> {{Auth::customer()->get()->name}}</a>
                        <ul style="top: -29px;" class="dropdown-menu" role="menu">
                            <li><a href="{{ url('authCustomer/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
             @if (Auth::customer()->guest())
                <ul class="nav navbar-nav wishlist">
                    <li><a href="{{route('account.wishlist.index')}}">Wishlist</a></li>
                    <li><a class="bag" href="{{ url('cart') }}">My Bag <span class="text-danger">({{$numITEMS}})</span>



                    </a></li>
                </ul>
            @else
                <ul class="nav navbar-nav wishlist login-wishlist">
                    <li><a href="{{route('account.wishlist.index')}}">Wishlist</a></li>
                    <li><a class="bag" href="{{ url('cart') }}">My Bag <span class="text-danger">({{$numITEMS}})</span></a></li>
                </ul>
            @endif

        </div>

        <div class="search" ng-controller="SearchCtrl">

            <div class="input-group">
                <form name="searchForm" class="form-horizontal" ng-submit="searchForm.$valid && search('created_at', 'search/items')">
                    <input type="text" class="form-control" placeholder="Shoes, Clothing, Bags, etc." aria-describedby="basic-addon2" ng-model="data.query['q']" required>
                    <span class="input-group-btn" id="basic-addon2">
                        <button class="btn btn-default" type="submit" ng-disabled="searchForm.$invalid"><i class="fa fa-search"></i></button>
                    </span>
                </form>
            </div>
        </div>

    </div>
</nav>
