@extends('layouts.master')
@section('content')
    @include('includes.subNav')
    @include('includes.shippingInfo')
    <div class="container" ng-controller="CheckoutCtrl">
        <h1><span class="highlight">Checkout</span></h1>

        <div class="row">
            <div class="col-md-12">
                <div class="checkout">
                    <!--
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title active">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <i class="fa fa-sign-in"></i> Sign In
                                 <i class="fa fa-plus-circle"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                Sign In
                            </div>
                        </div>
                    </div>

                    -->
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-default_">
                                <div class="panel-heading_">
                                    <h4 class="panel-title_ active">
                                        <a>
                                            <i class="fa fa-map-marker"></i> Delivery Address
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div>
                                    <div class="panel-body_">
                                        <fieldset class="change-recipient">
                                            <form class="form-horizontal" name="addressForm" role="form">

                                                <my-horizontal-form label-size="3" label="Ship to" value-size="9">
                                                    <input type="text" class="form-control" ng-model="data.recipient.name" required>
                                                </my-horizontal-form>

                                                <my-horizontal-form label-size="3" label="Email" value-size="9">
                                                    <input type="email" class="form-control" ng-model="data.recipient.email" required>
                                                </my-horizontal-form>

                                                <my-horizontal-form label-size="3" label="Shipping address" value-size="9">
                                                    <textarea class="form-control" ng-model="data.recipient.shipping_address" required></textarea>
                                                </my-horizontal-form>

                                                <my-horizontal-form label-size="3" label="City" value-size="9">
                                                    <select class="form-control" ng-options="c.name for c in options.cities" ng-model="data.recipient.city" ng-change="changeSelectedCity()" id="selectedCity">
                                                        <option value="">N/A</option>
                                                    </select>
                                                </my-horizontal-form>

                                                <my-horizontal-form label-size="3" label="Telephone number" value-size="9">
                                                    <input type="text" class="form-control" ng-model="data.recipient.telephone_number">
                                                </my-horizontal-form>

                                                <my-horizontal-form label-size="3" label="Mobile number" value-size="9">
                                                    <input type="text" class="form-control" ng-model="data.recipient.mobile_number" required>
                                                </my-horizontal-form>

                                            </form>
                                        </fieldset>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-default_">
                                <div class="panel-heading_">
                                    <h4 class="panel-title_ active">
                                        <a>
                                            <i class="fa fa-calculator"></i> Payment Method
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div>
                                    <div class="panel-body_">

                                        @foreach($paymentOptions as $key => $po)


                                            <div class="radio">
                                                <!--$key == 1 means disabled for COD-->
                                                <!--
                                            <input type="radio" ng-model="data.option_payment_id" value="{{$po->id}}" ng-disabled="allowCod({{$key}})">
                                            <label for=" {{$po->name}}">{{$po->name}}</label>
-->

                                                <input id="rd{{$po->id}}" type="radio" ng-model="data.option_payment_id" value="{{$po->id}}" ng-disabled="allowCod({{$key}})">
                                                <label for="rd{{$po->id}}">{{$po->name}}</label>
                                            </div>


                                        @endforeach

                                        <a href="#" class="small pull-right" data-toggle="modal" data-target="#myModal">list of areas available for (COD)</a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">List of areas available for (COD)</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul>
                                                            <li><strong>Metro Manila</strong></li>
                                                            <li><strong>Bulacan</strong> – Balagtas, Bocaue, Guiguinto, Malolos, Marilao, Plaridel, Meycauayan, San Jose Del Monte, Sta. Maria</li>
                                                            <li><strong>Cavite</strong> – Amadeo, Bacoor, Carmona, Cavite City, Dasmariñas, GMA, Gen. Trias, Imus, Indang, Kawit, Mendez, Naic, Noveleta, Silang, Tanza, Trece Martirez</li>
                                                            <li><strong>Laguna</strong> – Biñan, Cabuyao, Calamba, San Pedro, Sta. Rosa</li>
                                                            <li><strong>Rizal</strong> – Angono, Antipolo, Cainta, Binangonan, Rodriguez, Taytay, San Mateo, Cardona, Jalajala, Teresa.</li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-default_">
                                <div class="panel-heading_">
                                    <h4 class="panel-title_ active">
                                        <a>
                                            <i class="fa fa-truck"></i> Shipping Method
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div>
                                    <div class="panel-body_">
                                        @foreach($shippingOptions as $key => $so)

                                                <!-- Hide lbc option -->
                                        {{--@if($key != 1)--}}
                                        <div class="radio">
                                            <input type="radio" ng-model="data.option_shipping_id" value="{{$so->id}}" ng-disabled="checkShippingState({{$key}})">
                                            <label for="{{$so->name}}">{{$so->name}}</label>

                                            {{--Show text for LBC option--}}
                                            {{--@if($key == 1)--}}
                                                    <!--                                                    <span>(1,000 and above only)</span>-->
                                            {{--@endif--}}
                                        </div>
                                        {{--@endif--}}
                                        @endforeach
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                    <!--/Row-->

                    <div class="panel panel-default_">
                        <div class="panel-heading_">
                            <h4 class="panel-title_ active">
                                <a>
                                    <i class="fa fa-reorder op-0"></i> Place Order
                                    <i class="fa fa-plus-circle"></i>
                                </a>
                            </h4>
                        </div>
                        <div>
                            <div class="panel-body_">
                                <div class="checkout_block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="headlabel">Item Summary</span>
                                        </div>

                                        {{-- */$price = 0;/* --}}
                                        @foreach($orderDetails as $od)
                                            <div class="col-md-2">
                                                <span class="textlabel">Item</span> @foreach($od->item->itemImage as $image) @if($image->is_primary)
                                                    <p>{{$od->item->name}}</p>
                                                    <img class="img-responsive" src="{{url($image->path . $image->file_name)}}" alt=""> @endif @endforeach
                                            </div>
                                            <div class="col-md-3">
                                                <span class="textlabel">Description</span>
                                        <span class="checkout_name">
                                            {{$od->item->short_description}}
                                        </span>
                                        <span class="checkout_desc">
                                            {!!  $od->item->description !!}
                                        </span>

                                                @if ($od->option_size_id)
                                                    <span class="checkout_size">
                                               Size: {{$od->optionSize->name}}
                                            </span>
                                                    @endif
                                                            <!--
                                                <span class="checkout_size">
                                               Size:
                                           </span>
                                           -->
                                            </div>
                                            <div class="col-md-5">
                                                <span class="textlabel">Qty</span>
                                        <span class="checkout_qty">
                                                {{$od->qty}}
                                            </span>
                                            </div>

                                            <div class="col-md-2">
                                                <span class="textlabel">Price</span>
                                                <span class="checkout_price">PHP {{$od->price}}</span>
                                            </div>
                                            {{-- */$price += $od->price;/* --}}
                                            <div class="col-md-12">
                                                <hr>
                                            </div>

                                        @endforeach

                                        <div class="col-md-3 col-md-offset-9">
                                            <div class="checkout_total">
                                                <p>Subtotal <span>{{Helper::getCurrency()}} {{Helper::numberFormat($orderHeader->subtotal)}} </span></p>
                                                <p>
                                                    Discount:
                                                    @if($coupon)
                                                        <span> ({{ $coupon['code'] }}) </span>
                                                    @endif
                                                    <span>{{ $discount }} </span>
                                                </p>

                                                @if ($shippingFee != 0)

                                                        <!--<p>Shipping fee<span>{{Helper::getCurrency()}} {{Helper::numberFormat($shippingFee)}}</span></p>-->
                                                <p ng-cloak>Shipping fee<span>@{{data.shippingFee | currency : 'PHP '}}</span></p>

                                                @endif

                                                @if ($shippingFee == 0)
                                                    <p style="color: red; text-decoration: line-through">Shipping fee
                                                        <span style="color: red; text-decoration: line-through">{{Helper::getCurrency()}} {{Helper::numberFormat($shippingFee)}}</span>
                                                    </p>
                                                @endif

                                                <p><strong>Grand Total</strong>
                                                    <span ng-cloak><strong>@{{data.grandTotal | currency : 'PHP '}}</strong></span>

                                                    <!--
                                                <span ng-if="grandTotal >= '800'" ng-cloak><strong>{{Helper::getCurrency()}} {{Helper::numberFormat($grandTotal)}}</strong></span>
                                                <span ng-if="grandTotal < '800'" ng-cloak><strong>{{Helper::getCurrency()}}
                                                    @if($price > 500)
                                                    {{Helper::numberFormat($price)}}
                                                    @else
                                                    {{Helper::numberFormat(500 - $price)}}
                                                    @endif
                                                            </strong></span>
                                                    -->
                                                </p>

                                                <button class="btn btn-primary" ng-click="placeOrder()" ng-disabled="addressForm.$invalid" onclick="this.disabled=true;">Place Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
