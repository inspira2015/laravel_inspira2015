<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title><?php echo  Lang::get('registry.title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/font-awesome/css/font-awesome.min.css" />
    <script type="text/javascript" src="<?php echo url();?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo url();?>/js/jquery.validate.min.js"></script>

    <script type="text/javascript" src="<?php echo url();?>/css/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo url();?>/js/estados.js"></script>
    <link rel="icon" href="<?php echo url();?>/images/inspira.ico" type="image/ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/slide.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/slidestyle.css" />
    <link rel="stylesheet" href="<?php echo url();?>/css/jquery.h5-lightbox.css">
    
    <style>
      div.description{
          padding-top: 25px;
          padding-bottom: 25px;
          margin-top:100px;
          position:absolute; /* absolute position (so we can position it where we want)*/  
          bottombottom:0px; /* position will be on bottom */  
          left:0px;  
          width:50%;  
          /* styling bellow */  
          background-color:#F8F8F8;  
          font-family: 'tahoma';  
          font-size:15px;  
          color:#404040;  
          opacity:0.4; /* transparency */  
          filter:alpha(opacity=60); /* IE transparency */  
      }  

      .error{
        width:70% !important;
      }
      .account_conf{
        font-size: 32px;
      }

      div.continuar{
          padding-top: 25px;
          padding-bottom: 25px;
          margin-top:100px;
          position:absolute; /* absolute position (so we can position it where we want)*/  
          
          top:250px;
          left:0px;  
          width:50%;  
          /* styling bellow */  
          background-color:#F8F8F8;  
          font-family: 'tahoma';  
          font-size:15px;  
          color:#404040;  
          opacity:0.4; /* transparency */  
          filter:alpha(opacity=60); /* IE transparency */  
      }
    </style>

  </head>
  <body id="page" style="background-image:url('<?php echo url();?>/images/2.jpg'); background-repeat:no-repeat; background-position: center center fixed; 
                        -webkit-background-size: cover;
                        -moz-background-size: cover;
                        -o-background-size: cover;
                        background-size: cover; height:100%;position:relative;">
   <div class="header">
  <div class="container">
      <div class="logo">
        <a href="http://inspiramexico.mx">
          <img src="<?php echo url();?>/css/bootstrap/css/images/logo.png"/>
        </a>
      </div>
      <nav>
        <ul class="nav" style="margin-top:20px; font-size:11px;">
        </ul>
    </nav>
  </div>
</div>

<div class="container">
      @yield('content')
 
</div>

<footer style="position:absolute;margin-top:100px;">
  <div class="container" style="color:#fff; font-size:11px; padding:0 !important;">
    <div class="section-1">
      <img src="<?php echo url();?>/images/copyright.png"/>
        &nbsp;<?php echo  Lang::get('layoutmaster.copyright'); ?> 
    </div>
    <div class="section-2">
      <a href="http://inspiramexico.mx/terminos-y-condiciones/"  onclick="window.open(this.href, 'mywin',
        'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" style="color:#fff;">
        <?php echo  Lang::get('layoutmaster.privacypolicy'); ?> 
      </a>
    </div>
    <div class="section-3">México : 55.8526.1061
      <br>US Toll Free: 1.855.INSPIRA
    </div>
    <div class="section-4" style="display:inline-block;">
      <p style="display:inline-block; width:65%; padding-right:10px; vertical-align:middle;">
        <?php echo  Lang::get('layoutmaster.followus'); ?>:
      </p>
      <p style="display:inline-block; width:30%; vertical-align:top;">
        <img style="display:inline-block; width:100%; height:auto; vertical-align:top;"src="<?php echo url();?>/images/logofacebook.png"/>
      </p>
    </div>
  </div>
</footer>

	@include('layouts.__common.tawk')
	@include('layouts.__common.analytics')
  
</body>
</html>