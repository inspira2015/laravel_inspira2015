<!doctype html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <title>Activa tu cuenta</title>
	  <meta name="description" content="The HTML5 Herald">
	  <meta name="author" content="SitePoint">
	</head>
<body>
	<div style="width:600px; margin:0 auto;">
		<div style="@import url(http://inspiramexico.mx/resources/fonts/fonts.css?family=LondonBetween);">
			<div>
  				<div class="" style="width:100%; height:auto;"> 
	 				<img  src="http://inspiramexico.mx/usuarios/images/header2.png" style="width:100%; height:auto;" />
					<br>
				</div>
			</div>

			<div align = "center" style="width:100%;  weight:60px; font-weight: bold; background-color: #E5E7E9;">
				<font style="font-family:LondonBetween; font-size: 18px; color:#5a6b75;">
					¡ <?php echo $user->name .' '. $user->last_name; ?> gracias por afiliarte a Inspira México ! </font>
        		<br>
    			<hr width=80%;>
    			<font style="font-family:LondonBetween; font-size: 18px; color:#5a6b75;">
					Activa tu cuenta haciendo click en el link <a href="http://dev.inspira2015/user/activation/<?php echo $user->confirmation_code; ?>">Valida Email</a> 
				</font>
				<br>
				<div style="padding:10% 10% 10% 10%; margin:0 auto; width:60%; height:auto; border-style: solid; border-color:#d6dadd;  background-color: #ffffff; color:#616f7a; text-align:left; line-height: 19px;" align = "center">
					TUS DATOS DE CUENTA SON:<br>
					Nombre: <?php echo $user->name .' '. $user->last_name; ?><br>
					Correo: <?php echo $user->email; ?><br>
					Celular: <?php //echo $user->email; ?><br>
					Estado: <?php //echo $var_state; ?><br>
					Pais: <?php //echo $var_country; ?><br>
				</div>
			</div>	
    
			<div align = "center"> 
				<a href="http://inspiramexico.mx/#openModal2">
				<img  align = "center" src="http://inspiramexico.mx/usuarios/images/correo2_secc3.jpg" style="width:100%; heigth:auto"/>
				</a>
			</div>
		</div>
	</div>
</body>
</html>