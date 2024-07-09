<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Shop Manila - Admin</title>

	{!! HTML::style('css/app.css') !!}
	{!! HTML::style('css/admin.css') !!}
	{{--{!! HTML::style('bower_components/sweetalert/lib/sweet-alert.css') !!}--}}
	{!! HTML::style('bower_components/sweetalert2/dist/sweetalert2.min.css') !!}
	{!! HTML::style('bower_components/ng-tags-input/ng-tags-input.min.css') !!}
	{!! HTML::style('bower_components/ng-tags-input/ng-tags-input.bootstrap.min.css') !!}

	<script>
		var siteUrl = '{{url()}}/';
	</script>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Fonts -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body ng-app="app" ng-controller="AppCtrl">
        @if(Auth::user()->check())
        <header class="container">
            @include('includes.adminNav')	
        </header>
		@endif
		<main>
			@yield('content')
		</main>

		<footer>
			{{--@include('includes.footer-admin')	--}}
			@include('includes.footer')
		</footer>


	<!-- App dependencies -->
	{!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
	{!! HTML::script('bower_components/jquery/dist/jquery.elevateZoom-3.0.8.min.js') !!}
	{!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! HTML::script('bower_components/angular/angular.js') !!}
	{!! HTML::script('bower_components/angular-route/angular-route.min.js') !!}
	{!! HTML::script('bower_components/angular-resource/angular-resource.min.js') !!}
	{!! HTML::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js') !!}
	{!! HTML::script('bower_components/ng-file-upload/ng-file-upload.min.js') !!}
	{!! HTML::script('bower_components/es6-promise/es6-promise.min.js') !!}
	{!! HTML::script('bower_components/sweetalert2/dist/sweetalert2.min.js') !!}
	{{--{!! HTML::script('bower_components/sweetalert/lib/sweet-alert.min.js') !!}--}}
	{!! HTML::script('bower_components/ng-tags-input/ng-tags-input.min.js') !!}
	{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.js') !!}

	<script src="//cdn.ckeditor.com/4.5.6/basic/ckeditor.js"></script>

		{{--<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>--}}
	<!-- App scripts-->
	{!! HTML::script('js/app.js') !!}
	{!! HTML::script('js/directives.js') !!}
	{!! HTML::script('js/services.js') !!}
	{!! HTML::script('js/plugins.js') !!}

	{!! HTML::script('js/search/SearchCtrl.js') !!}
	{!! HTML::script('js/search/SearchSrvc.js') !!}


	{!! Assets::js() !!}

</body>
</html>
