<?php
	$minifierCss = new MinifyCSS();
	$minifierCss->add('css/app/main.css');
	$minifierCss->minify('css/minify/main.css');
	$minifierCss->add('css/uber.css');
	$minifierCss->minify('css/minify/uber.css');
	
	$minifierJs = new MinifyJs();
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
	<meta name="csrf-token" content={!! csrf_token() !!}>
	<link rel="icon" href="<?php echo url();?>/images/inspira.ico" type="image/ico" />
	{!! HTML::style('css/bootstrap/css/style.css') !!}
	{!! HTML::style('css/bootstrap/css/menu.css') !!}
	{!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
	{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
	{!! HTML::style('css/bootstrap/css/slide.css') !!}
	{!! HTML::style('css/bootstrap/css/slidestyle.css') !!}
	{!! HTML::style('css/minify/main.css') !!}
	{!! HTML::style('css/minify/uber.css') !!}
	{!! HTML::style('css/swiper.css') !!}

</head>

<body id="page uber" onload="javascript: poponload()" style="background-image:url('<?php echo url();?>/images/<?php echo $background; ?>'); background-repeat:no-repeat; background-position: center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	">
	<div class="header">
		<div class="container">
<!--
	  		<div class="logo">
	  			<a href="{{ url('/') }}">
	  				{!! HTML::image('css/bootstrap/css/images/logo.png', 'Inspira Mexico - Logo') !!}
	  			</a>
	  		</div>
-->
			<div class="row text-center">
				<div class="col-xs-6 col-md-2 col-md-offset-4 nopadding">
					<a href="#" class="btn-light-blue btn-xsmall" id="btn-login" data-toggle="modal" data-target="#modal-login" >INICIAR SESI&Oacute;N</a>
					</div>
				<div class="col-xs-6 col-md-3 nopadding">
					<a href="{{ url('registro') }}" class="btn-white-clear btn-xsmall">COMPRAR CERTIFICADO</a>
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
	@include('layouts.__common.message_modal')
	
	{!! HTML::script('js/jquery-1.10.2.min.js') !!}
	{!! HTML::script('js/minify/jquery.creditCardValidator.min.js') !!}
	{!! HTML::script('js/jquery.maskedinput.min.js') !!}
	
	{!! HTML::script('css/bootstrap/js/bootstrap.min.js') !!}
	{!! HTML::script('js/jquery.cookie.js') !!}
	<script src="http://www.idangero.us/swiper/dist/js/swiper.min.js"></script>

	{!! HTML::script('js/main.js') !!}
	
	@if(!$app->environment('local'))
		@include('layouts.__common.tawk')
		@include('layouts.__common.analytics')
		
	@endif
	@include('layouts.__common.facebook')
	@include('layouts.uber.modal_login')
	<script type="text/javascript">
	function poponload()
	{
		var been_before = $.cookie("leisurelogin");
		
		if(!been_before){
			var date = new Date();
			date.setTime(date.getTime() + (60 * 30 * 1000));
			$.cookie("leisurelogin", "true", { path: '/', expires: date });
			
			var myPopup = window.open("http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid=VIIM1", "", "directories=no,height=150,width=150,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");
			if (!myPopup){
			    alert("Favor desactivar ventanas emergentes para mejor experiencia de usuario.");  
			}else {
			    myPopup.onload = function() {
			        setTimeout(function() {
			            if (myPopup.screenX === 0) {
			                alert("failed for chrome");
			            } else {
			                // close the test window if popups are allowed.
			                myPopup.close();  
			            }
			        }, 0);
			    };
			}
			
			 setTimeout(function() {
			      myPopup.close();
			    }, 5000);
			    return false;
			}

		}
	</script>
</body>
</html>