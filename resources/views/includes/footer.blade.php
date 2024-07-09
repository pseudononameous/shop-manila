@if ( (Request::segment(1) == 'admin') || (Request::segment(1) == 'auth')  )

   <div style="margin:30px 0">
       <p>Copyright 2016. ShopManila. All rights reserved.</p>
   </div>

@else

<!--
    <div class="row newsletter">
        <div class="col-xs-12 col-md-7">
            <span class="caption">
                    <a href="#">Sign up</a> for Exclusive Sales and Products.
                </span>
        </div>
        <div class="col-xs-12 col-md-5" ng-controller="NewsletterCtrl">
            <form class="form-horizontal" role="form" name="newsletterForm" ng-submit="newsletterForm.$valid && sign()">
                <input type="email" class="form-control" ng-model="data.email" ng-required="true" name="email" placeholder="Email Address">
                <button class="btn btn-default" type="submit" ng-disabled="newsletterForm.$invalid">Sign Up</button>
            </form>
        </div>
    </div>
-->
    
    <div class="container">
        <div class="row newsletter">
            <div class="col-xs-12 col-sm-12 col-md-7 caption">
                <span class="">
                    <a href="#">Sign up</a> for Exclusive Sales and Products.
                </span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5">
    <!--
                <form class="form-horizontal" action="http://my.sendinblue.com/users/subscribe/" method="post" onsubmit="return false">
                    <input type="hidden" name="js_id" id="js_id" value="2jwr6">  	
                    <input type="hidden" name="primary_type" id="primary_type" value="email">
                    <input type="hidden" name="req_hid" id="req_hid" value="">


                    <input type="email" class="form-control" name="email" value="" placeholder="Email Address" required="required">

                    <button class="btn btn-default" type="submit">Sign Up</button>
                </form>
    -->            
                <!-- SendinBlue Signup Form HTML Code -->
                <div id="sib_embed_signup" style="padding: 0;">
                    <div class="wrapper" style="position:relative;margin-left: auto; margin-right: auto;">
                        <input type="hidden" id="sib_embed_signup_lang" value="en">
                        <input type="hidden" id="sib_embed_invalid_email_message" value="That email address is not valid. Please try again">
                        <input type="hidden" name="primary_type" id="primary_type" value="email">
                        <div id="sib_loading_gif_area" style="position: absolute;z-index: 9999;display: none;">
                            <img src="http://img.mailinblue.com/new_images/loader_sblue.gif" style="display: block;margin-left: auto;margin-right: auto;position: relative;top: 40%;">
                        </div>
                        <form class="description" id="theform" name="theform" action="https://my.sendinblue.com/users/subscribeembed/js_id/2jwr6/id/1" onsubmit="return false;">
                            <input type="hidden" name="js_id" id="js_id" value="2jwr6"><input type="hidden" name="listid" id="listid" value="4"><input type="hidden" name="from_url" id="from_url" value="yes"><input type="hidden" name="hdn_email_txt" id="hdn_email_txt" value="">
                            <div class="container rounded">

                               <input type="hidden" name="req_hid" id="req_hid" value="">

                                <div class="view-messages" style=""> </div>                                   
                                <div class="primary-group email-group forms-builder-group ui-sortable" style="">
                                    <div class="row mandatory-email">

                                        <input  type="email" class="form-control" name="email" id="email" value="" placeholder="Email Address">

                                         <button class="btn btn-default" type="submit" data-editfield="subscribe">SUBMIT</button>

                                        <div style="clear:both;"></div>
                                        <div class="hidden-btns">
                                            <a class="btn move" href="#"><i class="icon-move"></i></a><br>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </form>
                    </div>
                </div>
                <script type='text/javascript' src='https://my.sendinblue.com/public/theme/version3/js/subscribe-validate.js?v=1465900172'></script>          
                <!-- End : SendinBlue Signup Form HTML Code -->          
            </div>
        </div>        
        <div class="row footer-links">
        <div class="col-md-6">
            <div class="row first">
                <div class="col">
                    <ul>
                        <li>
                            <a href="{{route('item_category_page', 'men')}}">
                                Shop Men's
                            </a>
                        </li>
                        @foreach($menCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col">
                    <ul>
                        <li>
                            <a href="{{route('item_category_page', 'women')}}">
                                Shop Women's
                            </a>
                        </li>
                        @foreach($womenCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col last">
                    <ul>
                        <li>
                            <a href="{{route('item_category_page', 'kids')}}">
                                Shop Kids'
                            </a>
                        </li>
                        @foreach($kidsCategory as $c)
                            <li><a href="{{route('item_category_page', $c->slug)}}">{{$c->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!--<div class="col">
                    <ul>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">iShopManila</a></li>
                    </ul>
                </div>-->
            </div>
        </div>
        <div class="col-md-6">
            <div class="row second">
                <div class="col">
                    <ul>
                        <li><a href="{{url('about')}}">About Shopmanila</a></li>
                        <li><a href="{{url('about')}}">Company Information</a></li>
                        <li><a href="{{url('sizechart')}}">Size Chart</a></li>
                        <li><a href="{{url('faq')}}">FAQs</a></li>
                    </ul>
                </div>
                <div class="col">
                    <ul>
                        <li><a href="{{url('contact')}}">Customer Service</a></li>
                        <li><a href="{{url('privacy')}}">Privacy Policy</a></li>
                        <li><a href="{{url('terms')}}">Terms and Conditions</a></li>
                        <li><a href="{{url('contact')}}">Contact Us</a></li>
                        <li><a href="{{url('contact')}}">For Merchants</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h4>Like and Follow us on:</h4>
                    <div class="social_footer">
                        <a target="_blank" class="fb" href="https://www.facebook.com/ShopManilaPH">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a target="_blank" class="ig" href="https://www.twitter.com/ShopManilaPH">
                            <i class="fa fa-instagram"></i>
                        </a>
                        <a target="_blank" class="twt" href="https://www.instagram.com/shopmaniladotcom">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <br><br><br>
                        <!-- Begin DigiCert site seal HTML and JavaScript -->
                        <div id="DigiCertClickID_L6U39KEv" data-language="en" class="col-md-8">
                            <a href="https://www.digicert.com/ssl-certificate.htm" target="_blank">
                                <img src="{{asset('images/ssl_certificate.png')}}" class="img-responsive"  style="margin: 0 auto;"/>
                            </a>
                        </div>
                        <!-- End DigiCert site seal HTML and JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p class="text-center">
                &copy; ShopManila Inc., All rights reserved. Made by 31 Digital Media.
            </p>
        </div>
    </div>
    </div>

   
@endif


<!-- Live GA -->

<script>

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-56469068-2', 'auto');

    ga('send', 'pageview');

    ga('require', 'ecommerce');

</script>

<script type="text/javascript">
    var dcid = dcid || [];__dcid.push(["DigiCertClickID_L6U39KEv", "13", "m", "black", "L6U39KEv"]);(function(){var cid=document.createElement("script");cid.async=true;cid.src="//seal.digicert.com/seals/cascade/seal.min.js";var s = document.getElementsByTagName("script");var ls = s[(s.length - 1)];ls.parentNode.insertBefore(cid, ls.nextSibling);}());
</script>