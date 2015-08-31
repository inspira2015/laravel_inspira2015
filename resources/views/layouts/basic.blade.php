<?php
	$minifierCSS = new MinifyCSS();
	$minifierCSS->add('bootstrap/css/bootstrap.min.css');
	$minifierCSS->add('css/app/main.css');
	$minifierCSS->add('css/bootstrap/css/style.css');
	$minifierCSS->add('css/bootstrap/css/menu.css');
	
	$minifierCSS->add('css/font-awesome/css/font-awesome.min.css');
	$minifierCSS->add('css/bootstrap/css/slide.css');
	$minifierCSS->add('css/bootstrap/css/slidestyle.css');
	$minifierCSS->add('css/jquery.h5-lightbox.css');
	
	$minifierCSS->minify('css/minify/basic.css');
	
	$minifierJs = new MinifyJs();
	$minifierJs->add('js/jquery-1.10.2.min.js');
	$minifierJs->add('js/jquery.creditCardValidator.js');
	$minifierJs->add('js/jquery.maskedinput.js');
	$minifierJs->add('css/bootstrap/js/bootstrap.min.js');
	$minifierJs->add('js/main.js');
	
	$minifierJs->minify('js/minify/basic.js');
?>
	
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content={!! csrf_token() !!}>
	{!! HTML::style('css/minify/basic.css') !!}
	<link rel="icon" href="<?php echo url();?>/images/inspira.ico" type="image/ico" />
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
	
	{!! HTML::script('js/minify/basic.js') !!}
	
	@if(!$app->environment('local'))
		@include('layouts.__common.tawk')
		@include('layouts.__common.analytics')
	@endif
</body>
</html>