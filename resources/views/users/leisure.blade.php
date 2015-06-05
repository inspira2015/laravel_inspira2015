<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Felicidades</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/style.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
<link rel="icon" href="images/inspira.ico" type="image/ico" />
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slide.css" />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slidestyle.css" />
	<link rel="stylesheet" href="jquery.h5-lightbox.css">
</head>
<body id="page" style="background-image:url('images/3.jpg'); background-repeat:no-repeat; background-position: center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
 <?php 
  $path_header = base_path()."/resources/views/chunks/header.php";
    include_once $path_header;

// if(isset($user_data["language"])){
// if($user_data["language"]=="ES"){
// include "php/header.php";
// }else{
// include "php/headerENG.php";
// }
// }else{
// include "php/header.php";
// }
?>
<div class="container">

<div class="container">
	
    <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:500px;">
        
	
        
        
        <div class="col-lg-12 col-md-12">
            <div class="content">
            <div class="informacion">
            <h2 style="padding-bottom:20px; text-align:center;">¡FELICIDADES POR TU NUEVA AFILIACión y bienvenido a inspira méxico</h2>
            <p>En tu correo recibiras datos de acceso. Ahora puedes accesar a nuestro sistema de reservaciones, explorar tu mundo de posibilidades y planear tu proxima vacacion de ensueño</p>
            
          </div>
            
          </div>
          <div class="divider"></div>
        </div>
        <div class="col-lg-12 col-md-12" style="padding:20px;">
          <a href="?route=users/gotoDatos"><img style="width:50%; height:auto;"src="images/ingresarsistema.png"/></a>
        </div>
    </div>
    
      
	</div>

</div>
	<?php 
if(isset($user_data["language"])){
if($user_data["language"]=="ES"){
include "php/footer.php";
}else{
include "php/footerENG.php";
}
}else{
include "php/footer.php";
}
?>
</body>
</html>