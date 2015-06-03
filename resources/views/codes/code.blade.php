<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ingresa tu codigo</title>
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
</head>
<body id="page" style="background-image:url('images/codigo-background.jpg'); background-repeat:no-repeat; background-position: center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
<?php 
if(isset($user_data["language"])){
if($user_data["language"]=="ES"){
include "php/header.php";
}else{
include "php/headerENG.php";
}
}else{
include "php/header.php";
}
?>
<div class="container">

<div class="container">
  
    <div class="row"  style="background-color:rgba(229,231,233,0.4); margin-bottom:10px;">
        
  
        
        
        <div class="col-lg-12 col-md-12">
            <div class="codigo"></div>
          <div class="col-lg-12 col-md-12" style="padding:20px;">
        <form method="post" action="?route=users/profileexternalmain" id="profile" name="formulario">
         <div class="content" style="background-color:transparent; ">
          <h2 style="text-transform:none; font-size:24px; color:#465664; text-align:justify;">Gracias por su preferencia. Si usted cuenta con uncódigo promocional favor de ingresarlo en la parte inferior y así hacer válido sus tarifas preferenciales.</h2>
         <br><br>
          <div class="inputs" style="margin:0 auto; width:70%;">
         <input type="text" name="code" style="width:100%; border:12px solid #465664; background-color:#bec4c9; color:#465664;" />
</div>
         </form>
          
      </div>
        

          <div class="col-lg-12 col-md-12" style="padding:20px;">
          <div class="divider"></div></div>
        </div>
         
           
        
    </div>
    
      
  </div>
  <div class="row"  style="margin-bottom:350px; background-color:rgba(229,231,233,0.4); margin-top:10px; padding:0px;">
  <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:30px; margin-top:70px;"></div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:30px; margin-top:70px;">   <a href="#" onClick="formulario.submit()"><img style="width:100%; height:auto;"src="images/continuargrande.png"/></a></div>
    <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:30px; margin-top:70px;"></div>
    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:0px;"> 
       <?PHP if(isset($error)){
echo '<div class="col-lg-3"></div>';
  echo '<div class="col-lg-6 col-sm-12" style="margin:0 auto;"><p style="color:#cc4b9b">El código que ha ingresado no es válido, favor de tratar nuevamente o de click a la liga de abajo si no cuenta con código promocional:</p> <a href="?route=users/profileexternal2"><img style="margin-top:30px;width:50%; height:auto;"src="images/sincodigo.png"/></a></div>';
echo '<div class="col-lg-3"></div>';
}?></div>
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