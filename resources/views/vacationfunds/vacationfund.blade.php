<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title> <?php 
    //if($user_data["language"]=="ES"){
echo 'fondo vacacional';
//}else{
//echo 'vacation fund';
//}
?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/style.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
	<script type="text/javascript" src="js/fondo.js"></script>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<link rel="icon" href="images/inspira.ico" type="image/ico" />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slide.css" />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slidestyle.css" />
	<link rel="stylesheet" href="jquery.h5-lightbox.css">
</head>
<body id="page" style="background-image:url('images/4.jpg'); background-repeat:no-repeat; background-position: center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
 <?php 
$path_header = base_path()."/resources/views/chunks/header.php";
    include_once $path_header;
?>
<div class="container">

<div class="container">
	
    <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:100px;">
        
	
        
        
        <div class="col-lg-12 col-md-12">
            <div class="content">
            <div class="informacion">
            <h2 style="padding-bottom:20px;"><?php //echo $user_data["first_name"]; ?></h2> <?php //if($user_data["language"]=="ES"){
echo '<p>Viajar suele ser muy caro, especialmente cuando lo haces en familia. Nuestro programa  Fondo Vacacional te ayuda a planear y realizar tus vacaciones de ensueño sin importar tu presupuesto.</p>
            <p>Por medio de nuestro Fondo Vacacional podras abonar mes con mes una minima cantidad y asi ahorrar para tener todo cubierto para el dia de tu partida. Ademas de ayudar a administrarte, nuestro plan te brindara ahorros de hasta un 50% en tu proxima vacacion; el programa te brinda una gran cantidad de puntos Inspira que podran ser usado en tu siguiente reservación.</p>
            <p>¡Elige la cantidad que quieres ahorrar  mes con mes y preparate para esas vacaciones de ensueño !</p>';
//}else{
echo ' <p>Traveling is usually very expensive, especially when you do family. Our Holiday Fund program helps you to plan and carry out your dream vacation regardless of your budget.</p>
            <p>Through our Holiday Fund you can pay month by month a minimum amount and thus save to have everything covered for the day of your departure. In addition to helping you infuse our plan will offer you savings of up to 50% on your next holiday; The program gives you a lot of points that will be able Inspira be used on your next reservation.</p>
            <p>Choose the amount you want to save from month to month and prepare for that dream vacation !</p>';
//}
?>
            
            
          </div>
            
          </div>
          <div class="col-lg-12 col-md-12" style="padding:20px;">
<form method="post" action="?route=users/addfondo" id="profile" name="formulario">
				  <input type="hidden" name="email" value="<?php //echo $user_data['email']; ?>" />
            <div class="content" style="background-color:transparent; ">
          <h2>¿Le gustaria inscribirse a nuestro programa fondo vacacional?</h2>
          <div class="inputs" >
          Si<input type="radio" name="fondo" value=1 id="fondo2" checked="checked"  onclick="clicked(this)"/>
No en este momento<input type="radio" name="fondo" id="fondo1" value=0  onclick="clicked(this)"/>
</div>
<h2>Monto que le gustaria ahorrar cada mes</h2>
          <div class="col-lg-6 col-md-12 amounts" style="text-align:left; padding-top:12px;">
          $ &nbsp;<input type="text" class="form-control" name="amount" id="amount" style="width:70%; display:inline;"/>&nbsp;<?php //echo $user_data["currency"]; ?>&nbsp;</div></form>
			  
          


      </div>
        <div class="col-lg-12 col-md-12" style="padding:20px;">
          <div class="divider"></div></div>
<div class="col-lg-12 col-md-12" style="padding:20px;">
  <p style="text-align:left;">
	La cantidad que decida abonar sera cargada a su tarjeta al final de cada mes. El monto ahorrado podra utilizarse en cualquier momento que usted lo decida. Para cancelaciones favor de leer nuestros <a style="color:#818c95;">Terminos de cancelación</a>.
	  
	  
	 </p>

</div>

          <div class="col-lg-12 col-md-12" style="padding:20px;">
          <div class="divider"></div></div>
        </div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  <a href="?route=users/gotoAfiliacion" ><img style="width:50%; height:auto;"src="images/regresartransparente.png"/></a></div>
          <div class="col-lg-4 col-md-4 col-sm-4">&nbsp;</div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">   <a href="#" onClick="validateForm()"><img style="width:50%; height:auto;"src="images/continuar.png"/></a></div>
        
        
    </div>
    
      
	</div>

</div>
</div>
		 <script type="text/javascript">
    function validateForm()
    {
    var fondo = document.forms["formulario"]["fondo"].value;
	var a=document.forms["formulario"]["amount"].value;
		if(fondo==1){
    if (a==null || a=="" || a=="0")
      {
      alert("Favor de ingresar una cantidad");
      
      }else{
		  formulario.submit();
	  }
    }else{
		formulario.submit();
	}
	}
    </script>
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