<?php
	$minifierCss = new MinifyCSS();
	$minifierCss->add('css/app/main.css');
	$minifierCss->minify('css/minify/main.css');
	
	$minifierJs = new MinifyJs();
	$minifierJs->add('js/jquery.creditCardValidator.min.js');
	$minifierJs->minify('js/minify/jquery.creditCardValidator.min.js');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content={!! csrf_token() !!}>
	<link rel="icon" href="<?php echo url();?>/images/inspira.ico" type="image/ico" />
	{!! HTML::style('css/bootstrap/css/style.css') !!}
	{!! HTML::style('css/bootstrap/css/menu.css') !!}
	{!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
	{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
	{!! HTML::style('css/bootstrap/css/slide.css') !!}
	{!! HTML::style('css/bootstrap/css/slidestyle.css') !!}
	{!! HTML::style('css/minify/main.css') !!}
</head>

<body id="page" style="background-image:url('<?php echo url();?>/images/<?php echo $background; ?>'); background-repeat:no-repeat; background-position: center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	">

	@include('layouts.__common.header')

	<div id="wrapper">
		<div class="container">
		    @yield('content')
		</div>
	</div>
	@include('layouts.__common.footer')

	@include('layouts.__common.privacy')
	@include('layouts.__common.terms')
	
	{!! HTML::script('js/jquery-1.10.2.min.js') !!}
	{!! HTML::script('js/minify/jquery.creditCardValidator.min.js') !!}
	{!! HTML::script('js/jquery.maskedinput.min.js') !!}
	
	{!! HTML::script('css/bootstrap/js/bootstrap.min.js') !!}
	{!! HTML::script('js/main.js') !!}
	
	@if(!$app->environment('local'))
		@include('layouts.__common.tawk')
		@include('layouts.__common.analytics')
	@endif
</body>
</html>