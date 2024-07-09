<!DOCTYPE html>
<html>
<head>
<style>
    
 @import url('https://fonts.googleapis.com/css?family=Lato:400,700');
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; }

      body {
        background-color: #f6f6f6;
        font-family: 'Lato', sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0; 
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; }	  
	  
      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        Margin: 0 auto !important;
        /* makes it centered */
        max-width: 1200px;
        padding: 10px;
        width: auto !important;
        /*width: 1200px;*/ 
		}

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        Margin: 0 auto;
        max-width: 1200px;
        padding: 10px; }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #fff;
        border-radius: 3px;
        width: 100%; }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; }

      .footer {
        clear: both;
        padding-top: 10px;
        text-align: center;
        width: 100%; }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #000000;
          font-size: 18px;
          text-align: center; 
		  text-decoration: none;
		  }
        
      h1,
      h2,
      h3,
      h4, h5,h6 {
        color: #000000;
        font-family: 'Lato', sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
		Margin-bottom: 30px; }
		
	  h6{
		font-size: 16px;
		font-weight: 700;
		text-transform: uppercase;
		Margin-bottom: 15px; 
		color: #252525;
	  }
		
      p,
      ul,
      ol {
        font-family: 'Lato', sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        Margin-bottom: 5px; 
		color: #555;
		}
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; }
	  p.first{
		font-size: 22px;
		font-weight: 700;
		Margin-bottom: 15px;
		color: #000;
	  }
	  p.rec{
	    font-size: 18px;
		font-weight: bold;
		color: #acacac;
		padding-bottom: 20px;
		border-bottom: 1px solid #acacac;
	  }
      p.jumbo{
        font-size: 32px;
        font-weight: 700;
        line-height: 1;
        color: #000;      
      }
      a {
        color: #3498db;
        text-decoration: none; }
        
      .align-center {
        text-align: center; }

      .align-right {
        text-align: right; }

      .align-left {
        text-align: left; }

      .clear {
        clear: both; }

      .mt0 {
        margin-top: 0; }

      .mb0 {
        margin-bottom: 0; }

	  .p0{
		padding: 0;
	  }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        Margin: 20px 0; }
		
	  .w20{
		width: 20%;
	  }
	  
	  .w2{
		width: 2%;
	  }  
    
      .w32{
        width: 32%;
      }
	 
      .w35{
        width: 35%;
       }
        
	  .w53{
		width: 53%;
	  }
	  
	  .w66{
		width: 66%;
	  }
    
      .w70{
		width: 70%;
	  }
	  
	  		
	  .social-icons img{
		margin: 15px 5px;
	  }
	  
	  .f555{
		color: #555;
	  }
        
      .thead td{
		background: #dfe0e2;
		text-align: left;
		padding: 10px;
		font-weight: 700;
		color: #252525;
	  }
	  
	  .thead td.no-bg{
		background: none;
	  }
	  
	  .tbody td{
	    padding: 10px 10px 0 10px;
	  }
	  
	  .black{
		background: #363636;
		padding: 20px 10px 0 20px !important;
		color: #fff;
	  }
	  
	  .black p{
		color: #fff;
	  }
	  
	  .black p.head{
		font-size: 16px;
	  }
	  
	  .black td{
		padding: 0;
	  }
</style>
</head>

<body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <!-- <td>&nbsp;</td> -->
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <!-- <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span> -->
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p class="first">Hello, {{$data->orderHeader->customer->name}}</p>
						
						<table class="f555">
							<tr>
								<td class="w20"><strong>Order placed on:</td>
								<td>{{ date('M d, Y', strtotime($data->orderHeader->created_at))}}</td>
							</tr>
							<tr>
								<td class="w20"><strong>Order number:</td>
								<td>{{$data->orderHeader->order_number}}</td>
							</tr>
							<tr>
								<td class="w20"><strong>Shipment number:</td>
								<td>{{$data->shipment_number}}</td>
							</tr>
						</table>
						<p>&nbsp;</p>
                      </td>
					  <td class="w20 align-right">
						<img src="{{url()}}/images/logo.png" alt="Shop Manila">
					  </td>
                    </tr>
					<tr>
						<td colspan="5">
						<p class="rec">Recipient Detail</p>
						</td>
					</tr>
				  </table>
				  
				  <table><tr><td colspan="5">&nbsp;</td></tr></table>
				  
				  <table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="w32">
							<h6>Ship To</h6>
							<p>{{$data->orderHeader->orderRecipient->name}}</p>
						</td>
						<td class="w2"></td>
						<td class="w32">
							<h6>Contact Details</h6>
							<p>E: <a href="mailto:{{$data->orderHeader->orderRecipient->email}}">{{$data->orderHeader->orderRecipient->email}}</a></p>
							<p>T: {{$data->orderHeader->orderRecipient->telephone_number}}</p>
							<p>M: {{$data->orderHeader->orderRecipient->mobile_number}}</p>
						</td>
						<td class="w2"></td>
						<td class="w32">
							<h6>Shipping Address</h6>
							<p>{{$data->orderHeader->orderRecipient->shipping_address}}</p>
						</td>
					</tr>
					
                  </table>
				  
				  <table><tr><td colspan="5">&nbsp;</td></tr></table>
				  
				  <table border="0" cellpadding="0" cellspacing="0">
					<tr class="thead">
						<td class="w32">Item</td>
						<td class="no-bg w2"></td>
						<td class="w32">Quantity Shipped</td>
						<td class="no-bg w2"></td>
						<td class="w32">Tracking Number</td>
					</tr>
					<tbody class="tbody">
					    @foreach ($data->shipmentDetail as $sd)
						<tr>
							<td><p><strong>{{$sd->orderDetail->item->name . ' ' . $sd->orderDetail->item->short_description}}</strong></p></td>
							<td></td>
							<td><p><strong>{{$sd->qty}}</strong></p></td>
							<td></td>
							<td><p><strong>{{$sd->tracking_number}}</strong></p></td>
						</tr>
						@endforeach
						
						<tr>
							<td> &nbsp;</td>
						</tr>
						
					</tbody>
				  </table>
				  
				  <table><tr><td colspan="5">&nbsp;</td></tr></table>
				  
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    
                    <a href="http://shopmanila.com">www.shopmanila.com</a>.
                  </td>
                </tr>
                <tr>
                  <td class="content-block social-icons">
					<a href="https://www.facebook.com/ShopManilaPH/" target="_blank"><img src="{{url('images/facebook-email.png')}}" /></a>
					<a href="https://twitter.com/ShopManilaPH" target="_blank"><img src="{{url('images/twitter-email.png')}}" /></a>
					<a href="https://www.instagram.com/shopmaniladotcom/" target="_blank"><img src="{{url('images/instagram-email.png')}}" /></a>
                  </td>
                </tr>
              </table>
            </div>

            <!-- END FOOTER -->
            
<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>

  
</html>