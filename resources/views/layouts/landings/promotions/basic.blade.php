<?php
	$minifierCss = new MinifyCSS();
	$minifierCss->add('css/app/main.css');
	$minifierCss->minify('css/minify/main.css');
	$minifierCss->add('css/landings.css');
	$minifierCss->minify('css/minify/landings.css');
	$minifierCss->add('css/jssor-slider.css');
	$minifierCss->minify('css/minify/jssor-slider.css');
	
	$minifierJs = new MinifyJs();
	$minifierJs->add('js/jssor-slider.min.js');
	$minifierJs->minify('js/minify/jssor-slider.min.js');
	$minifierJs->add('js/jquery.creditCardValidator.js');
	$minifierJs->minify('js/minify/jquery.creditCardValidator.min.js');
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{{ $title }}</title>
<!-- 	<meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="csrf-token" content="{!! csrf_token() !!}">

	<link rel="icon" href="<?php echo url();?>/images/inspira.ico" type="image/ico" />
	{!! HTML::style('css/bootstrap/css/style.css') !!}
	{!! HTML::style('css/bootstrap/css/menu.css') !!}
	{!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
	{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
	{!! HTML::style('css/bootstrap/css/slide.css') !!}
	{!! HTML::style('css/bootstrap/css/slidestyle.css') !!}
	{!! HTML::style('css/minify/main.css') !!}
	{!! HTML::style('css/minify/landings.css') !!}
	{!! HTML::style('css/minify/jssor-slider.css') !!}
</head>

<body id="page uber"  style="background-image:url('<?php echo url();?>/images/<?php echo $background; ?>'); background-repeat:no-repeat; background-position: center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	">
	<div class="header">
		<div class="container">
			<div class="row text-center">
				<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-2 col-md-3 col-md-push-1 nopadding">
					@if(!Auth::check())
					<a href="#" class="btn-light-blue btn-xsmall" id="btn-login" data-toggle="modal" data-target="#modal-login" >
						INICIAR SESI&Oacute;N
					</a>
					@else
					<a href="#" class="btn-light-blue btn-xsmall" id="btn-login" data-toggle="modal" data-target="#modal-options" >
						{{ Auth::user()->name }} {{ substr(Auth::user()->last_name, 0,1) }}.
					</a>
					@endif
					</div>
				<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-0 col-md-3 col-md-offset-1 nopadding">
					<a href="{{ url('comprar-certificado') }}" class="btn-white-clear btn-xsmall">COMPRAR CERTIFICADO</a>
				</div>
			</div>
		</div>
	</div>

	<div id="wrapper">
		
		    @yield('content')
		
		<div id="bg-loading"></div>
		<div id="loading-inspira">
			<div class="brand-logo">
				<img src="http://images.leisureloyalty.com/viim/imlogo.png">
			</div>
			<div class="load">
				{{ Lang::get('layout.loading') }}
				<br>
				<img src="http://inspiramexico.leisureloyalty.com/images/loading.gif">
			</div>
		</div>
	
	
	</div>


	@include('layouts.__common.footer')

	@include('layouts.__common.privacy')
	@include('layouts.__common.terms')
	
	@include('layouts.landings.__common.message_modal')
	
	{!! HTML::script('js/jquery-1.10.2.min.js') !!}
	{!! HTML::script('js/minify/jquery.creditCardValidator.min.js') !!}
	{!! HTML::script('js/jquery.maskedinput.min.js') !!}
	{!! HTML::script('js/minify/jssor-slider.min.js') !!}

	{!! HTML::script('css/bootstrap/js/bootstrap.min.js') !!}

	{!! HTML::script('js/main.js') !!}
	
	@include('layouts.__common.facebook')
	
	@include('layouts.landings.__common.modal_login')
	
	@include('layouts.landings.promotions.analytics')
	
	@include('layouts.__common.tawk')
	
	@if($modal)
	<script>
	$(document).ready(function() { $('#modal-options').modal() });
	</script>
	@endif
</body>
</html>