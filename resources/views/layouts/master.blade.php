<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Shop Manila</title>

	<meta property="og:url"           content="{{Request::url()}}" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="ShopManila" />
	<meta property="og:description"   content="Sign up for exclusive sales and products" />

	{!! HTML::style('css/app.css') !!}
	{!! HTML::style('bower_components/ng-table/dist/ng-table.min.css') !!}
	{{--{!! HTML::style('bower_components/sweetalert/lib/sweet-alert.css') !!}--}}
	{!! HTML::style('bower_components/sweetalert2/dist/sweetalert2.min.css') !!}
	{!! HTML::style('bower_components/ng-tags-input/ng-tags-input.min.css') !!}
	{!! HTML::style('bower_components/ng-tags-input/ng-tags-input.bootstrap.min.css') !!}
	{!! HTML::style('css/style.css') !!}

	<script>
		var siteUrl = '{{url()}}/';
	</script>

	<!-- Fonts -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    {{--<link href='https://fonts.googleapis.com/css?family=Raleway:500,700,600,400,800' rel='stylesheet' type='text/css'>--}}

    
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body ng-app="app" ng-controller="AppCtrl" style="overflow-x: hidden;">
	
	<header>
		@include('includes.nav')
	</header>
        
		@yield('content')

    <footer>
        @include('includes.footer')
    </footer>

	</div>
	

	<!-- App dependencies -->
	{!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
	{!! HTML::script('bower_components/jquery/dist/jquery.elevateZoom-3.0.8.min.js') !!}
	{!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! HTML::script('bower_components/angular/angular.js') !!}
	{!! HTML::script('bower_components/angular-route/angular-route.min.js') !!}
	{!! HTML::script('bower_components/angular-resource/angular-resource.min.js') !!}
	{!! HTML::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js') !!}
	{!! HTML::script('bower_components/ng-file-upload/ng-file-upload.min.js') !!}
	{!! HTML::script('bower_components/ng-table/dist/ng-table.min.js') !!}
	{!! HTML::script('bower_components/sweetalert2/dist/sweetalert2.min.js') !!}
	{!! HTML::script('bower_components/ng-tags-input/ng-tags-input.min.js') !!}
	{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.js') !!}

	<!-- App scripts-->
	{!! HTML::script('js/app.js') !!}

	{!! HTML::script('js/directives.js') !!}
	{!! HTML::script('js/services.js') !!}
	{!! HTML::script('js/plugins.js') !!}
	{!! HTML::script('js/search/SearchCtrl.js') !!}
	{!! HTML::script('js/search/SearchSrvc.js') !!}
	{!! HTML::script('js/newsletter/NewsletterCtrl.js') !!}
	{!! HTML::script('js/newsletter/SignUpCtrl.js') !!}
	{!! HTML::script('js/newsletter/NewsletterSrvc.js') !!}

	{!! Assets::js() !!}

	<!-- Load Facebook SDK for JavaScript -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

	<!-- TWITTER API -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
	</script>
</body>
</html>
