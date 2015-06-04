<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Olvido contraseña</title>
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
			  <form method="post" action="?route=users/olvidepwd" id="profile" name="formulario">
				  <?php if(isset($attempts)){
echo '<input type="hidden" name="attempts" value='.((int)$attempts+1).'/>';
} 
else{
echo '<input type="hidden" name="attempts" value=0 />';
} 
?>
		     <div class="content" style="background-color:transparent; ">
          <h2 style="text-transform:none; font-size:24px; color:#465664; text-align:justify;">Si ha olvidado su contraseña, favor de ingresar el correo electronico que tiene registrado con nosotros y le enviaremos la contraseña a ese correo electronico.</h2>
				 <br><br>
          <div class="inputs" style="margin:0 auto; width:70%;">
         <input type="text" name="email" style="width:100%; border:12px solid #465664; background-color:#bec4c9; color:#465664;" />
</div>
         </form>
          
      </div>
        
       <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:30px; margin-top:30px;">   <a href="#" onClick="formulario.submit()"><img style="width:40%; height:auto;"src="images/enviarcontrasena.png"/></a></div>
			  	 <?PHP if(isset($message)){
	echo '<div style="width:50%; margin:0 auto;"><p style="color:#cc4b9b; font-weight:bold;">'.$message.'</p></div>'; }?></div>
          <div class="col-lg-12 col-md-12" style="padding:0 20px;">
			  
          <div class="divider"></div></div>
			  
        </div>
         
           
        
    </div>
    
      
	</div>
	<div class="row"  style="margin-bottom:350px; background-color:rgba(229,231,233,0.4); margin-top:10px; padding:0px;">
         
		<div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:0px;"> 
		
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