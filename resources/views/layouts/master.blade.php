<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title><?php echo  Lang::get('registry.title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/font-awesome/css/font-awesome.min.css" />
    <script type="text/javascript" src="<?php echo url();?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo url();?>/js/jquery.validate.min.js"></script>

    <script type="text/javascript" src="<?php echo url();?>/css/bootstrap/js/bootstrap.min.js"></script>
        {!!  HTML::script('js/main.js') !!}

    <script type="text/javascript" src="<?php echo url();?>/js/estados.js"></script>
    <link rel="icon" href="<?php echo url();?>/images/inspira.ico" type="image/ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/slide.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/slidestyle.css" />
    <link rel="stylesheet" href="<?php echo url();?>/css/jquery.h5-lightbox.css">
    
-->

	<meta name="csrf-token" content={!! csrf_token() !!}>

	{!! HTML::style('css/bootstrap/css/style.css') !!}
	{!! HTML::style('css/bootstrap/css/menu.css') !!}
	{!! HTML::style('css/bootstrap/css/bootstrap.min.css') !!}
	{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
	
	{!! HTML::style('css/app/main.css') !!}
	
	<link rel="icon" href="/images/inspira.ico" type="image/ico" />
	{!! HTML::script('js/jquery-1.10.2.min.js') !!}
	{!! HTML::script('js/jquery.validate.min.js') !!}

	{!! HTML::script('css/bootstrap/js/bootstrap.min.js') !!}
	{!!  HTML::script('js/main.js') !!}

	{!! HTML::style('css/bootstrap/css/slide.css') !!}
	{!! HTML::style('css/bootstrap/css/slidestyle.css') !!}

  </head>
  <body id="page">
   <div class="header">
  <div class="container">
      <div class="logo">
        <a href="{{ url() }}">
          <img src="<?php echo url();?>/css/bootstrap/css/images/logo.png"/>
        </a>
      </div>
      <nav>
        <ul class="nav" style="margin-top:20px; font-size:11px;">
        </ul>
    </nav>
  </div>
</div>

<div class="body-content">
	<div class="container">
	      @yield('content')
	 
	</div>
</div>


	@include('layouts._common.footer')

	@include('layouts.__common.tawk')
	@include('layouts.__common.analytics')
  
</body>
</html>