<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content={!! csrf_token() !!}>

	{!! HTML::style('css/bootstrap/css/style.css') !!}
	{!! HTML::style('css/bootstrap/css/menu.css') !!}
	{!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
	{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
	{!! HTML::style('css/bootstrap/css/slide.css') !!}
	{!! HTML::style('css/bootstrap/css/slidestyle.css') !!}
	
	{!! HTML::script('js/jquery-1.10.2.min.js') !!}

	{!! HTML::script('css/bootstrap/js/bootstrap.min.js') !!}
	{!! HTML::script('js/main.js') !!}

	<link rel="icon" href="/images/inspira.ico" type="image/ico" />
	{!! HTML::style('css/jquery.h5-lightbox.css') !!}
	
	{!! HTML::style('css/app/main.css') !!}
</head>

<body id="page" style="background-image:url('<?php echo url();?>/images/<?php echo $background; ?>'); background-repeat:no-repeat; background-position: center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;">

	@include('layouts.__common.header')

	<div class="container">
	    @yield('content')
	</div>

	@include('layouts.__common.footer')

	@if(!$app->environment('local'))
		@include('layouts.__common.tawk')
		@include('layouts.__common.analytics')
	@endif
</body>
</html>