@extends('layouts.master') @section('content') @include('includes.subNav')

<div class="container" id="items" ng-controller="ItemDetailCtrl">

    <div class="row item-detail">
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-2">
                    <div id="gal1">
                        @foreach($item->itemImage as $i)
                        <a href="#" data-image="{{url()}}/{{$i->path}}/{{$i->file_name}}" data-zoom-image="{{url()}}/{{$i->path}}/{{$i->file_name}}">
                                <img class="thumbs" src="{{url()}}/{{$i->path}}/{{$i->file_name}}" />
                            </a> @endforeach

                    </div>
                </div>
                <div class="col-md-10">
                    <div class="gallery_zoom">
                        @foreach($item->itemImage as $image)
                            @if($image->is_primary)
                                <img src="{{url($image->path . $image->file_name)}}" alt="" id="img_01">
                            @endif
                        @endforeach
                    </div>


                    <div id="gal2">

                        @foreach($variation as $var) @if($var->related_item_code != $currentRelatedItemCode)
                            <a href="{{route('item_page', $var->slug)}}">
                                @foreach($var->itemImage as $image)
                                    @if($image->is_primary)
                                        <img class="thumbs" src="{{url($image->path . $image->file_name)}}" />
                                    @endif
                                @endforeach
                            </a> 
                            @endif 
                        @endforeach

                    </div>

                </div>

            </div>
        </div>
        <div class="col-md-5">
            <div class="item_desc">
                <span class="name">
                    <a href="{{route('store_page', $item->store->slug)}}">
                        {{$item->store->name}}
                    </a>
                </span>
                <p class="name">{{$item->name}}</p>



                <!-- Different prices display -->
                <div>

                    @if($itemEvent)
                        <span class="price" style="color:red; text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($item->price)}}</span>
                        <span class="price">{{Helper::getCurrency()}} {{Helper::numberFormat($itemEvent->event_price)}}</span>

                    @endif
                </div>

                <div>
                    @if($item->on_sale && ! $itemEvent)
                        <span class="price" style="color:red; text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($item->price)}}</span>
                        <span class="price">{{Helper::getCurrency()}} {{Helper::numberFormat(Helper::getItemPrice($item))}}</span>
                    @endif
                </div>


                <div>
                    @if(! $item->on_sale && ! $itemEvent)
                        <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat(Helper::getItemPrice($item))}}</span>
                    @endif
                </div>

                <p>
                    {{$item->short_description}}
                </p>

                <div ng-if="! config.hasSizes" ng-cloak>
                    Stock: @{{config.allowedQty}}
                </div>

                <div ng-if="config.hasSizes" ng-cloak>
                    Stock per size: @{{config.stockPerSize[data.sizeId]}}
                </div>

                <div class="row" ng-cloak>
                    <div class="col-md-7">
                        <div class="size_block">

                            <form name="itemForm" class="form-horizontal" ng-submit="itemForm.$valid && add({{$item->id}})">

                                <div>
                                    <label for="qty">Quantity</label>
                                    {{--<input type="number" class="form-control" ng-model="data.qty" required min="1" my-not-more-than-value="@{{config.stockPerSize[data.sizeId]}}">--}}
                                    <input type="number" class="form-control" ng-model="data.qty" required min="1" my-not-more-than-stock="@{{config.allowedQty}}">
                                </div>

                                <div ng-if="config.hasSizes" ng-cloak>
                                    <h5>Select Size</h5>
                                    <select ng-model="data.sizeId" class="form-control" ng-change="getAllowedQty()" required>
                                        <option value="@{{ size.option_size.id }}" ng-repeat="size in config.sizes">@{{ size.option_size.name }}</option>
                                    </select>
                                </div>

                                {{-- @if($item->qty) --}}
                                <button class="btn btn-primary" ng-disabled="itemForm.$invalid" ng-cloak>Add to Bag</button>
                                {{--@endif--}}

                            </form>

                            @if(Auth::customer()->check())
                            <div ng-controller="WishlistCtrl">
                                <button class="btn btn-default" ng-click="addToWishlist({{$item->id}})">Add to Wishlist</button>
                            </div>
                            @endif
                        </div>
                        <div class="promo_block">
                            <p>Delivery above 800 <span>Free</span></p>
                            <p>30 Days Return <span>Free</span></p>
                            <p>Cash on Delivery <span>Yes</span></p>
                        </div>

                    </div>
                    <div class="col-md-5">
                        <div class="details">
                            <h5>Share</h5>
                            <a target="_blank" href="javascript:window.open('https://www.facebook.com/sharer/sharer.php?sdk=joey&u={{route('item_page', $item->slug)}}&display=popup&ref=plugin&src=share_button','title','width=500,height=300')"
                               href="#">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="https://twitter.com/intent/tweet?url={{route('item_page', $item->slug)}}&text=ShopManila"><i class="fa fa-twitter"></i></a>
                            <!--<a href="#"><i class="fa fa-google-plus"></i></a>-->
                            <!--<a href="#"><i class="fa fa-envelope"></i></a>-->
                        </div>
                        <div class="details">
                            <p><strong>CUSTOMER CARE</strong>
                                <br/> CALL US (02) 2777993
                                <br/> Operation Hours:
                                <br/> Monday to Friday: 9am-5pm
                                <br/> Saturday: 9am-11am</p>
                        </div>

                        <div class="details">
                            <p><strong>DELIVERED IN</strong>
                                <br/> 2-3 days for NCR
                                <br/> 5-7 outside Metro Manila </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <section>
        <div class="item_info">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#details" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
                <li role="presentation"><a href="#sizecharts" aria-controls="profile" role="tab" data-toggle="tab">Size Chart</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="details">
                    <p>
                        {!! $item->description !!}
                    </p>
                </div>
                <div role="tabpanel" class="tab-pane clearfix" id="sizecharts">

                    <div class="row">
                        <div class="col-md-12">
                            <h1><span class="highlight">Size Chart</span></h1> @if($category == 'menShoes')
                            <h2><span class="highlight">Mens</span></h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Us</th>
                                        <th>Euro</th>
                                        <th>MM</th>
                                        <th>CM</th>
                                        <th>Inches</th>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>39</td>
                                        <td>246.70</td>
                                        <td>24.67</td>
                                        <td>9.71</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>40</td>
                                        <td>253.30</td>
                                        <td>25.33</td>
                                        <td>9.97</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>41</td>
                                        <td>260.00</td>
                                        <td>26.00</td>
                                        <td>10.23</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>42</td>
                                        <td>266.70</td>
                                        <td>26.66</td>
                                        <td>10.50</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>43</td>
                                        <td>273.30</td>
                                        <td>27.33</td>
                                        <td>10.76</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>44</td>
                                        <td>280.00</td>
                                        <td>28.00</td>
                                        <td>11.02</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>45</td>
                                        <td>286.65</td>
                                        <td>28.66</td>
                                        <td>11.29</td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>46</td>
                                        <td>293.32</td>
                                        <td>29.32</td>
                                        <td>11.55</td>
                                    </tr>
                                </table>
                            </div>
                            @endif @if($category == 'womenShoes')
                            <h2><span class="highlight">Ladies</span></h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Us</th>
                                        <th>Euro</th>
                                        <th>MM</th>
                                        <th>CM</th>
                                        <th>Inches</th>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>35</td>
                                        <td>220.66</td>
                                        <td>22.07</td>
                                        <td>8.69</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>36</td>
                                        <td>227.33</td>
                                        <td>22.73</td>
                                        <td>8.95</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>37</td>
                                        <td>234</td>
                                        <td>23.4</td>
                                        <td>9.21</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>38</td>
                                        <td>240.67</td>
                                        <td>24.07</td>
                                        <td>9.48</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>39</td>
                                        <td>247.34</td>
                                        <td>24.73</td>
                                        <td>9.74</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>40</td>
                                        <td>254</td>
                                        <td>25.40</td>
                                        <td>10.00</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>41</td>
                                        <td>260.68</td>
                                        <td>26.07</td>
                                        <td>10.26</td>
                                    </tr>
                                </table>
                            </div>

                            @endif @if($category == 'kidsShoes')

                            <h2><span class="highlight">Kids</span></h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Us</th>
                                        <th>Euro</th>
                                        <th>MM</th>
                                        <th>CM</th>
                                        <th>Inches</th>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>30</td>
                                        <td>187.33</td>
                                        <td>18.73</td>
                                        <td>7.37</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>31</td>
                                        <td>194</td>
                                        <td>19.4</td>
                                        <td>7.64</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>32</td>
                                        <td>200.67</td>
                                        <td>20.07</td>
                                        <td>7.9</td>
                                    </tr>git pull
                                    <tr>
                                        <td>13</td>
                                        <td>33</td>
                                        <td>207.34</td>
                                        <td>20.73</td>
                                        <td>8.16</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>34</td>
                                        <td>214</td>
                                        <td>21.4</td>
                                        <td>8.43</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>35</td>
                                        <td>220.66</td>
                                        <td>22.07</td>
                                        <td>8.69</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>36</td>
                                        <td>227.33</td>
                                        <td>22.73</td>
                                        <td>8.95</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>37</td>
                                        <td>234</td>
                                        <td>23.4</td>
                                        <td>9.21</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>38</td>
                                        <td>240.67</td>
                                        <td>24.07</td>
                                        <td>9.47</td>
                                    </tr>
                                </table>
                            </div>


                        </div>
                        @endif @if($category == 'menClothes')
                        <div class="col-md-12">
                            <h1><span class="highlight">Shirt Size Chart</span></h1>
                            <h2><span class="highlight">Mens</span></h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Men's SIZE TABLE (CM)</th>
                                        <th>S</th>
                                        <th>M</th>
                                        <th>L</th>
                                        <th>XL</th>
                                        <th>XXL</th>
                                    </tr>
                                    <tr>
                                        <td>front length</td>
                                        <td>68</td>
                                        <td>69.5</td>
                                        <td>71</td>
                                        <td>72.5</td>
                                        <td>74</td>
                                    </tr>
                                    <tr>
                                        <td>shoulder across</td>
                                        <td>41</td>
                                        <td>43</td>
                                        <td>45</td>
                                        <td>47</td>
                                        <td>49</td>
                                    </tr>
                                    <tr>
                                        <td>corrs width</td>
                                        <td>46</td>
                                        <td>48.5</td>
                                        <td>51</td>
                                        <td>53.5</td>
                                        <td>56</td>
                                    </tr>
                                    <tr>
                                        <td>waist width</td>
                                        <td>43</td>
                                        <td>45.5</td>
                                        <td>48</td>
                                        <td>50.5</td>
                                        <td>53</td>
                                    </tr>
                                    <tr>
                                        <td>hem sweep</td>
                                        <td>45</td>
                                        <td>47.5</td>
                                        <td>50</td>
                                        <td>52.5</td>
                                        <td>55</td>
                                    </tr>
                                    <tr>
                                        <td>neck width</td>
                                        <td>18</td>
                                        <td>18.5</td>
                                        <td>19</td>
                                        <td>19.5</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <td>front neck drop</td>
                                        <td>10.5</td>
                                        <td>11</td>
                                        <td>11.5</td>
                                        <td>12</td>
                                        <td>12.5</td>
                                    </tr>
                                    <tr>
                                        <td>sleeve length</td>
                                        <td>19</td>
                                        <td>19.5</td>
                                        <td>20</td>
                                        <td>20.5</td>
                                        <td>21</td>
                                    </tr>
                                    <tr>
                                        <td>camp straight</td>
                                        <td>20</td>
                                        <td>21</td>
                                        <td>22</td>
                                        <td>23</td>
                                        <td>24</td>
                                    </tr>
                                    <tr>
                                        <td>bicep</td>
                                        <td>17</td>
                                        <td>18.5</td>
                                        <td>19.5</td>
                                        <td>20.5</td>
                                        <td>21.5</td>
                                    </tr>
                                    <tr>
                                        <td>sleeve opening</td>
                                        <td>15.5</td>
                                        <td>16</td>
                                        <td>16.5</td>
                                        <td>17</td>
                                        <td>17.5</td>
                                    </tr>
                                </table>
                            </div>

                            @endif @if($category == 'womenClothes')
                            <h2><span class="highlight">Ladies</span></h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Ladie's SIZE TABLE (CM)</th>
                                        <th>S</th>
                                        <th>M</th>
                                        <th>L</th>
                                        <th>XL</th>
                                    </tr>
                                    <tr>
                                        <td>front length</td>
                                        <td>58.5</td>
                                        <td>60</td>
                                        <td>62</td>
                                        <td>64</td>
                                    </tr>
                                    <tr>
                                        <td>shoulder across</td>
                                        <td>35.5</td>
                                        <td>36.5</td>
                                        <td>37.5</td>
                                        <td>38.5</td>
                                    </tr>
                                    <tr>
                                        <td>corrs width</td>
                                        <td>38.5</td>
                                        <td>41</td>
                                        <td>43.5</td>
                                        <td>46</td>
                                    </tr>
                                    <tr>
                                        <td>waist width</td>
                                        <td>35.5</td>
                                        <td>38</td>
                                        <td>40.5</td>
                                        <td>43</td>
                                    </tr>
                                    <tr>
                                        <td>hem sweep</td>
                                        <td>40</td>
                                        <td>42.5</td>
                                        <td>45</td>
                                        <td>47.5</td>
                                    </tr>
                                    <tr>
                                        <td>neck width</td>
                                        <td>16.5</td>
                                        <td>17</td>
                                        <td>17.5</td>
                                        <td>18</td>
                                    </tr>
                                    <tr>
                                        <td>front neck drop</td>
                                        <td>9.5</td>
                                        <td>10</td>
                                        <td>10.5</td>
                                        <td>11</td>
                                    </tr>
                                    <tr>
                                        <td>sleeve length</td>
                                        <td>12.5</td>
                                        <td>13</td>
                                        <td>13.5</td>
                                        <td>14</td>
                                    </tr>
                                    <tr>
                                        <td>camp straight</td>
                                        <td>16.75</td>
                                        <td>17.5</td>
                                        <td>18.25</td>
                                        <td>19</td>
                                    </tr>
                                    <tr>
                                        <td>bicep</td>
                                        <td>16.5</td>
                                        <td>17.25</td>
                                        <td>17.5</td>
                                        <td>18.25</td>
                                    </tr>
                                    <tr>
                                        <td>sleeve opening</td>
                                        <td>14.5</td>
                                        <td>15</td>
                                        <td>15.5</td>
                                        <td>16</td>
                                    </tr>
                                </table>
                            </div>
                            @endif


                        </div>
                    </div>

                    <!-- <div class="table-block">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Us</th>
                                    <th>Euro</th>
                                    <th>MM</th>
                                    <th>CM</th>
                                    <th>Inches</th>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>39</td>
                                    <td>246.70</td>
                                    <td>24.67</td>
                                    <td>9.71</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>40</td>
                                    <td>253.30</td>
                                    <td>25.33</td>
                                    <td>9.97</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>41</td>
                                    <td>260.00</td>
                                    <td>26.00</td>
                                    <td>10.23</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>42</td>
                                    <td>266.70</td>
                                    <td>26.66</td>
                                    <td>10.50</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>43</td>
                                    <td>273.30</td>
                                    <td>27.33</td>
                                    <td>10.76</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>44</td>
                                    <td>280.00</td>
                                    <td>28.00</td>
                                    <td>11.02</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>45</td>
                                    <td>286.65</td>
                                    <td>28.66</td>
                                    <td>11.29</td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>46</td>
                                    <td>293.32</td>
                                    <td>29.32</td>
                                    <td>11.55</td>
                                </tr>
                            </table>
                        </div>
                    </div>-->

                    <!--<div class="table-block">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Us</th>
                                    <th>Euro</th>
                                    <th>MM</th>
                                    <th>CM</th>
                                    <th>Inches</th>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>39</td>
                                    <td>246.70</td>
                                    <td>24.67</td>
                                    <td>9.71</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>40</td>
                                    <td>253.30</td>
                                    <td>25.33</td>
                                    <td>9.97</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>41</td>
                                    <td>260.00</td>
                                    <td>26.00</td>
                                    <td>10.23</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>42</td>
                                    <td>266.70</td>
                                    <td>26.66</td>
                                    <td>10.50</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>43</td>
                                    <td>273.30</td>
                                    <td>27.33</td>
                                    <td>10.76</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>44</td>
                                    <td>280.00</td>
                                    <td>28.00</td>
                                    <td>11.02</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>45</td>
                                    <td>286.65</td>
                                    <td>28.66</td>
                                    <td>11.29</td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>46</td>
                                    <td>293.32</td>
                                    <td>29.32</td>
                                    <td>11.55</td>
                                </tr>
                            </table>
                        </div>
                    </div>-->

                    <!--<div class="table-block">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Us</th>
                                    <th>Euro</th>
                                    <th>MM</th>
                                    <th>CM</th>
                                    <th>Inches</th>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>39</td>
                                    <td>246.70</td>
                                    <td>24.67</td>
                                    <td>9.71</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>40</td>
                                    <td>253.30</td>
                                    <td>25.33</td>
                                    <td>9.97</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>41</td>
                                    <td>260.00</td>
                                    <td>26.00</td>
                                    <td>10.23</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>42</td>
                                    <td>266.70</td>
                                    <td>26.66</td>
                                    <td>10.50</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>43</td>
                                    <td>273.30</td>
                                    <td>27.33</td>
                                    <td>10.76</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>44</td>
                                    <td>280.00</td>
                                    <td>28.00</td>
                                    <td>11.02</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>45</td>
                                    <td>286.65</td>
                                    <td>28.66</td>
                                    <td>11.29</td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>46</td>
                                    <td>293.32</td>
                                    <td>29.32</td>
                                    <td>11.55</td>
                                </tr>
                            </table>
                        </div>
                    </div>-->

                </div>
            </div>

    </section>

    <section>
        <h2><span class="highlight">Related Items</span></h2>
        <div class="row">
            @foreach($relatedItems as $i) @if($var->related_item_code != $currentRelatedItemCode)
            <div class="col-xs-6 col-sm-6 col-md-3">

                <a href="{{route('item_page', $i->slug)}}">
                    <div class="product_block">
                        <div class="product_image">
                            @foreach($i->itemImage as $image) @if($image->is_primary)
                            <img class="img-responsive" src="{{url($image->path . $image->file_name)}}" /> @endif @endforeach
                        </div>
                        <span class="product_name">{{$i->store->name}}</span>
                        <span class="product_desc">{{$i->name}}</span> @if($i->on_sale)
                        <span class="price" style="color:red; text-decoration: line-through; ">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span>
                        <span class="price">{{Helper::getCurrency()}} {{Helper::numberFormat($i->discounted_price)}}</span> @else
                        <span class="product_price">{{Helper::getCurrency()}} {{Helper::numberFormat($i->price)}}</span> @endif
                    </div>
                </a>

            </div>
            @endif @endforeach
        </div>
    </section>

    </div>

    @endsection