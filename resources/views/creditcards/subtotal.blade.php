<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Subtotal</title>
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
?>
<div class="container">

<div class="container">
	
    <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:500px;">
        
	    <div class="col-lg-12 col-md-12">
            <div class="content" style="padding-bottom:20px;">
            <div class="informacion">
            <h2 style="padding-bottom:20px; text-align:center;">RESUMEN DE SU CUENTA</h2>
				<p style="text-align:center;">
					
				<span style="font-weight:bold;">PRIMER MES GRATUITO</span></p>
				<div style="width:40%; margin:0 auto; padding-top:20px;">
			
					<p>Pago mensual Afiliacion: $
						
						
<?PHP //if ($user_data['afiliacion']==1){
// if($user_codes["currency"]==$user_data["currency"]){
// echo $user_codes["discover"].' '.$user_data["currency"];
// }
// else{
// echo $user_codes["discover"].' '.$user_codes["currency"];
// echo ' ( ';
// if($user_data["currency"]=="USD"){
// echo (round($user_codes["discover"]/$currency["rate"], 2));
// }
// else{
// echo $user_codes["discover"]*$currency["rate"];
// }

// echo ' '.$user_data["currency"].' )';
// }

// }
// if ($user_data['afiliacion']==2){
// if($user_codes["currency"]==$user_data["currency"]){
// echo $user_codes["platinum"].' '.$user_data["currency"];
// }
// else{
// echo $user_codes["platinum"].' '.$user_codes["currency"];
// echo ' ( ';
// if($user_data["currency"]=="USD"){
// echo (round($user_codes["platinum"]/$currency["rate"], 2));
// }
// else{
// echo $user_codes["platinum"]*$currency["rate"];
// }

// echo ' '.$user_data["currency"].' )';
// }
// }
// if ($user_data['afiliacion']==3){
// if($user_codes["currency"]==$user_data["currency"]){
// echo $user_codes["diamond"].' '.$user_data["currency"];
// }
// else{
// echo $user_codes["diamond"].' '.$user_codes["currency"];
// echo ' ( ';
// if($user_data["currency"]=="USD"){
// echo (round($user_codes["diamond"]/$currency["rate"], 2));
// }
// else{
// echo $user_codes["diamond"]*$currency["rate"];
// }

// echo ' '.$user_data["currency"].' )';
// }
// }
// ?> </p>                      
 			<p>Pago Mensual Fondo vacacional: $ <?PHP
// if($user_data["currency"]=="USD"){
// echo $user_data['amount'].' USD';
// }else{
// echo $user_data['amount'].' MXN';
// }

?></p>
					<p>
						Proxima fecha de pago:
						 <?PHP

//echo date("Y-m-d", strtotime("+1 month"));

?>
					</p>
			
					
				</div>
            
				
				</div>
            
          </div>
          <div class="divider" style="margin-bottom:10px;"></div>
        </div>
         <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  <a href="?route=users/gotoFondo"><img style="width:50%; height:auto;"src="images/regresartransparente.png"/></a></div>
		
          <div class="col-lg-4 col-md-4 col-sm-4">
			<a href="#" id = "" > <img style="text-align: center; margin: 0 auto; width: 70%; height: auto;" src="images\visa_master_american.png"/> </a>
			</div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">
			  <form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
				  <input type="hidden" name="first_name" value="<?php// echo $user_data["first_name"]?>">
				  <input type="hidden" name="last_name" value="<?php //echo $user_data["last_name"]?>">
				  <input type="hidden" name="address1" value="<?php //echo $user_data["address"]?>">
				  <input type="hidden" name="state" value="<?php //echo $user_data["state"]?>">
				  <input type="hidden" name="address1" value="<?php //echo $user_data["address"]?>">
				  <input type="hidden" name="country" value="<?php //echo $user_data["country"]?>">
				  <input type="hidden" name="email" value="<?php //echo $user_data["email"]?>">
				  
<input type="hidden" name="cmd" value="_xclick-subscriptions">
<input type="hidden" name="business" value="nonamegalvezbusiness@test.com">
<input type="hidden" name="currency_code" value="<?php //echo $user_data["currency"]?>">
<input type="hidden" name="no_shipping" value="1">
				  
				  
<?PHP
// if($user_data['afiliacion']==1){
// if($user_codes['discover']==0){
// $afiliacion=0;
// }
// else{
// $afiliacion =$user_codes['discover'];
// }
// }
// if($user_data['afiliacion']==2){
// if($user_codes['platinum']==0){
// $afiliacion=0;
// }
// else{
// $afiliacion =$user_codes['platinum'];
// }
// }
// if($user_data['afiliacion']==3){
// if($user_codes['diamond']==0){
// $afiliacion=0;
// }
// else{
// $afiliacion =$user_codes['diamond'];
// }
// }

// if(($afiliacion+$user_data['amount'])>0){
// echo '<a href="?route=users/addcard"> <img src="images/continuar.png"/></a>';
// }else{
// echo '<a href="?route=users/felicidades"> <img src="images/continuar.png"/></a>';}

?>
<input type="hidden" name="a1" value="0">
<input type="hidden" name="p1" value="1">
<input type="hidden" name="t1" value="M">
// <input type="hidden" name="a3" value="<?PHP //if ($user_data['afiliacion']==1){
// if($user_codes["currency"]=="MXN"){

// if($user_data["currency"]=="USD"){
// echo round($user_codes["discover"]/$currency["rate"], 2)+$user_data['amount'];
// }else{
// echo $user_codes["discover"]+$user_data['amount'];

// }
// }
// else{
// if($user_data["currency"]=="USD"){
// echo round($user_codes["discover"], 2)+$user_data['amount'];
// }else{
// echo round($user_codes["discover"]/$currency["rate"], 2)+$user_data['amount'];

// }
// }

// }
// if ($user_data['afiliacion']==2){
// if($user_codes["currency"]=="MXN"){

// if($user_data["currency"]=="USD"){
// echo round($user_codes["platinum"]/$currency["rate"], 2)+$user_data['amount'];
// }else{
// echo $user_codes["platinum"]+$user_data['amount'];
// }
// }
// else{
// if($user_data["currency"]=="USD"){
// echo round($user_codes["platinum"], 2)+$user_data['amount'];
// }else{
// echo round($user_codes["platinum"]*$currency["rate"], 2)+$user_data['amount'];

// }
// }

// }
// if ($user_data['afiliacion']==3){
// if($user_codes["currency"]=="MXN"){

// if($user_data["currency"]=="USD"){
// echo round($user_codes["diamond"]/$currency["rate"], 2)+$user_data['amount'];
// }else{
// echo $user_codes["diamond"]+$user_data['amount'];

// }
// }
// else{

// if($user_data["currency"]=="USD"){
// echo round($user_codes["diamond"], 2)+$user_data['amount'];
// }else{
// echo round($user_codes["diamond"]*$currency["rate"], 2)+$user_data['amount'];
// }
// }

// }
?>">
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="D">
<input type="hidden" name="src" value="1">
<input type="hidden" name="sra" value="1">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="return" value="http://inspiramexico.mx/usuarios/index.php?route=users/afiliacionexitosa">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="cancel_return" value="http://inspiramexico.mx/usuarios/index.php?route=users/cancelado">
	<input type="hidden" name="description" value="Aceptar mensualidades">
	<input type="hidden" name="custom" value="<?php //echo $user_data['id']?>">
</form>
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