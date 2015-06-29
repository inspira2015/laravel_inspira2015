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
    <script type="text/javascript" src="<?php echo url();?>/css/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo url();?>/js/estados.js"></script>
    <link rel="icon" href="<?php echo url();?>/images/inspira.ico" type="image/ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/slide.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo url();?>/css/bootstrap/css/slidestyle.css" />
    <link rel="stylesheet" href="<?php echo url();?>/css/jquery.h5-lightbox.css">
  </head>
  <body id="page" style="background-image:url('<?php echo url();?>/images/2.jpg'); background-repeat:no-repeat; background-position: center center fixed; 
                        -webkit-background-size: cover;
                        -moz-background-size: cover;
                        -o-background-size: cover;
                        background-size: cover; height:100%;">
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

<footer style="margin-top:100px;">
  <div class="container" style="color:#fff; font-size:11px; padding:0 !important;">
    <div class="section-1">
      <img src="<?php echo url();?>/images/copyright.png"/>
        &nbsp; Inspira México derechos reservados @ 2015
    </div>
    <div class="section-2">
      <a href="http://inspiramexico.mx/terminos-y-condiciones/"  onclick="window.open(this.href, 'mywin',
        'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" style="color:#fff;">
        Politicas de privacidad y terminos de servicio
      </a>
    </div>
    <div class="section-3">México : 55.8526.1061
      <br>US Toll Free: 1.855.INSPIRA
    </div>
    <div class="section-4" style="display:inline-block;">
      <p style="display:inline-block; width:65%; padding-right:10px; vertical-align:middle;">
        Siguenos en:
      </p>
      <p style="display:inline-block; width:30%; vertical-align:top;">
        <img style="display:inline-block; width:100%; height:auto; vertical-align:top;"src="<?php echo url();?>/images/logofacebook.png"/>
      </p>
    </div>
  </div>
</footer>

  <!--Start of Tawk.to Script-->
<script type="text/javascript">
    var $_Tawk_API={},$_Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/551aea4d4365744943a76741/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();

  </script>
  <!--End of Tawk.to Script-->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-61781914-3', 'auto');
    ga('send', 'pageview');
</script>

  <script type="text/javascript" src="<?php echo url();?>/js/validations_profile.js"></script>
</body>
</html>