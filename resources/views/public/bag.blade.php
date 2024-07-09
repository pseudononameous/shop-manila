@extends('layouts.master') 

@section('content') 

@include('includes.subNav') 

@include('includes.shippingInfo')

<div class="container">
    <h1><span class="highlight">Shopping Bag</span></h1>

    <section class="shopping">
        <div class="shopping_block">
           <div class="row">
               <div class="col-md-2">
                   <span class="textlabel">Item</span>
               </div>
                <div class="col-md-3">
                    <span class="textlabel">Description</span>
               </div>     
                <div class="col-md-5">
                    <span class="textlabel">Qty</span>
               </div>   
                <div class="col-md-2">
                    <span class="textlabel">Price</span>
               </div>                                     
           </div>
           
           <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>               
           </div>
           
            <div class="row">
                <div class="col-md-2">
                    <img src="{{url()}}/images/checkout-dummyimg1.png" />
                </div>
                <div class="col-md-3">
                    <span class="shopping_name">
                                       3.1 phillip lim
                                   </span>
                    <span class="shopping_desc">
                                      The pashli large shark-effect leather trapeze bag.
                                   </span>
                    <span class="shopping_color">
                                       Color: Black
                                   </span>
                    <span class="shopping_size">
                                       Size:
                                   </span>
                </div>
                <div class="col-md-5">
                    <div class="filter">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                1
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Other Amount</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="shopping_price">PHP 0.00</span>
                </div>
                <div class="col-md-3 col-md-offset-9">
                    <div class="shopping_edit">
                        <p><a href="#">Edit item</a></p>
                        <p><a href="#">Remove From Bag</a></p>
                    </div>
                </div>                     
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-2">
                    <img src="{{url()}}/images/checkout-dummyimg1.png" />
                </div>
                <div class="col-md-3">
                    <span class="shopping_name">
                                       3.1 phillip lim
                                   </span>
                    <span class="shopping_desc">
                                      The pashli large shark-effect leather trapeze bag.
                                   </span>
                    <span class="shopping_color">
                                       Color: Black
                                   </span>
                    <span class="shopping_size">
                                       Size:
                                   </span>
                </div>
                <div class="col-md-5">
                    <div class="filter">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                1
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Other Amount</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="shopping_price">PHP 0.00</span>
                </div>
                <div class="col-md-3 col-md-offset-9">
                    <div class="shopping_edit">
                        <p><a href="#">Edit item</a></p>
                        <p><a href="#">Remove From Bag</a></p>
                    </div>
                </div>                     
                <div class="col-md-12">
                    <hr>
                </div>
            </div>            
            
            <div class="row">
                <div class="col-md-5">
                    <div class="shopping_discount">
                        <span><strong>DISCOUNT CODES</strong></span>
                        <p>Enter your coupon code if you have one.</p>
                        <input class="form-control" type="text">
                        <button class="btn btn-primary">Enter Code</button>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="shopping_total">
                        <p class="text-right">
                            <strong>Grand Total</strong> <span>                                                         <strong>PHP 0.00</strong></span>
                        </p>
                        
                        <div class="actions">
                            <button class="btn btn-default">Update Cart</button>
                            <button class="btn btn-default">Continue Shopping</button>
                            <button class="btn btn-primary">Place Order</button>
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
    @stop