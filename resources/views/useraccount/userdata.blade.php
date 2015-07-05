<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {!! HTML::style('css/bootstrap/css/style.css') !!}
    {!! HTML::style('css/bootstrap/css/menu.css') !!}
    {!! HTML::style('css/bootstrap/css/bootstrap.min.css') !!}
    {!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
    <link rel="icon" href="/images/inspira.ico" type="image/ico" />
    {!! HTML::script('js/jquery-1.10.2.min.js') !!}
    {!! HTML::script('css/bootstrap/js/bootstrap.min.js') !!}
    {!! HTML::script('js/datos.js') !!}
    {!! HTML::script('js/datos_cuenta.js') !!}
    {!! HTML::script('js/datos_fondo.js') !!}
    {!! HTML::style('css/bootstrap/css/slide.css') !!}
    {!! HTML::style('css/bootstrap/css/slidestyle.css') !!}
  </head>

  <body id="page" style="background-image:url('images/1.png'); background-repeat:no-repeat; background-position: center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">

    @include('layouts.__common.header')


  <div class="container">

  <div class="container">
  	
      <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9;">
          
  		<div class="col-lg-12 col-md-12 col-sm-12" style="background-color:#e5e7e9; z-index:1000; margin-bottom:70px;">
  			<div class="col-lg-4">
      <h1 style="font-size:32px;  color:#818c95; "><i class="fa fa-user" style="border: 3px solid grey; border-radius:50%; width:35px; height:35px;"></i>&nbsp;<?php //echo $user_data["first_name"]; ?> <?php //echo $user_data["last_name"]; ?></h1>
  			</div>
  					<div class="col-lg-4">
      		</div>
      
  					<div class="col-lg-4">
      		</div>
      
      
          </div>
  		
          <div class="col-lg-6" style="margin-top:35px;">
            <div class="col-lg-12">
            <div class="content" style="padding-bottom:40px; padding-top:10px;">
              <div class="informacion" style="padding-bottom:60px;">
              <h2 style="padding-bottom:20px;">Datos de contacto</h2>
              <div id = "campos">
  				<input type = "hidden" id = "leisure" value ="<?php //echo $user_data['leisure_id'] ?>">
  				<input type = "hidden" id = "afiliacion" name="afiliacion" value ="<?php //echo $afiliacion['tier_id'] ?>">
  			
  				<p id = "cel" class=""> </p>
  				
  				<p id = "hmt" class=""> </p>
  				
  				<p id = "wkt" class=""> </p>
  				
  				<p id = "address" class=""> </p>
  				
  				<p id = "city" class=""> </p>
  				
  				<p id = "country" class=""> </p>
  				
  				<p id = "state" class=""> </p>
  			</div>
            </div>
              <a id ="cambiar" class="linkcambiar"> <img src="images/cambiar.png"/></a>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="content" style="padding-bottom:40px; padding-top:20px;">
              <div class="informacion" style="padding-bottom:60px;">
              <h2 style="padding-bottom:20px;">Datos de cuenta</h2>
              			<div id = "campos2">
  				<p id = "correo" class=""> Email: director@inspira.mx</p>
  				<p id = "contrasena" class="">Contraseña: *********</p>
  				</div>
            </div>
              <a id= "cambiar2"><img src="images/cambiar.png"/></a>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="content">
              <div class="informacion-2" style="padding-top:10px; padding-bottom:10px;">
  				<?php 

  // if($user_data["language"]=="ES"){
  // echo ' <p > <p style="display:inline-block; width:40%;"> Idioma: &nbsp; '.$user_data["language"].' </p> <a onclick="changeEng()" style="color:#cc4b9b;"> <img src="images/cambiar.png" style="vertical-align:text-top;"/></a></p>';
  // }else{
  // echo ' <p > <p style="display:inline-block; width:40%;"> Language: '.$user_data["language"].' </p> <a onclick="changeEsp()" style="color:#cc4b9b;"><img src="images/cambiarENG.png" style="vertical-align:text-top;"/></a></p>';
  // }

  ?>
  				<?php 

  // if($user_data["currency"]=="MXN"){
  // echo ' <p > <p style="display:inline-block; width:40%;"> Moneda: '.$user_data["currency"].' </p> <a onclick="confirmeUSD()" style="color:#cc4b9b;"><img src="images/cambiar.png" style="vertical-align:text-top;"/></a></p>';
  // }else{
  // echo '<p > <p style="display:inline-block; width:40%;"> Moneda: '.$user_data["currency"].'</p> <a onclick="confirmeMXN()" style="color:#cc4b9b;"><img src="images/cambiar.png" style="vertical-align:text-top;"/></a></p>';
  // }

  ?>
  				
            </div>
            </div>
          </div>
  			<div class="col-lg-12">
            <div class="content">
              <div class="informacion-2" style="padding-top:30px; padding-bottom:30px;">
              <h1 style="text-align:center;">PUNTOS INSPIRA <?php //echo $user_data['inspira_points'];?> puntos</h1>
            </div>
            </div>
          </div>
          </div>
          <div class="col-lg-6" style="margin-top:35px;">
            <div class="col-lg-12">
            <div class="content">
              <div class="informacion">
              <h2>TIPO DE AFILIACIón</h2>
              <?php //if($user_data["afiliacion"]==1){ echo "<h2>Descubre</h2>";
  //}
  //if($user_data["afiliacion"]==2){ echo "<h2>Platino</h2>";
  // }
  // if($user_data["afiliacion"]==3){echo "<h2>Diamante</h2>";

  // }
   
  // if(($codes-$user_data["afiliacion"]) > 0){
  // echo '</div>    <a style="text-align:center;" href="?route=users/gotoAfiliacion_single"><img src="images/categoria.png" style="width:80%;"/></a>';
  // }else{
  // echo '</div>';
  // }
   ?>

  				<div class="informacion-2">
              <p>Fecha de vencimiento:</p>
              <p><?PHP //echo date('d-m-Y', strtotime($user_data['expirationDate']));?></p>
            </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="content">
              <div class="informacion-2" style="margin-bottom:20px;">
              <h2>FONDO vacacional</h2>
  				<p>
  					Abono mensual: $ <?php //if($user_data["amount"]){echo round($user_data['amount'], 2).' '.$user_data['currency'];}else{echo '0 '.$user_data['currency'];} ?>
  							</p>
  				<p>
  						Ahorros totales: $ <?php //echo $user_data['total_saved'];?> <?php //echo $user_data['currency'];?>
  				</p>
            </div>
  			  <div style="display:inline-block;">
  				  
  			  <form action="https://mexico.dineromail.com/Shop/Shop_Ingreso.asp" method="post"> 
  				  <input type="hidden" name="NombreItem" value="Agregar a fondo"> 
  				  <input type="hidden" name="TipoMoneda" value="<?php 
  //					if($user_data["currency"]=="MXN"){
  //						echo 1;										   
  //					 }else{
  //													echo 2;
  //													}?>"> 
  				 
  				  <input type="hidden" name="E_Comercio" value="1534470"> 
  				  <input type="hidden" name="NroItem" value="12"> 
  				  <input type="hidden" name="DireccionExito" value="http://inspiramexico.mx/payments/dineromail"> 
  				  <input type="hidden" name="DireccionFracaso" value="http://inspiramexico.mx/payments/dineromail/error"> 
  				  <input type="hidden" name="DireccionEnvio" value="0"> 
  				  <input type="hidden" name="Mensaje" value="1"> 
  				  <input type='hidden' name='MediosPago' value='4,5,6,17,19,20,21,22,13,14,7'>
  				  
              <?PHP 
  				// if($user_data["amount"]>0){
  				// 	echo '<a style="text-align:center; display:inline-block; width:40%; vertical-align:top;" href="?route=users/gotoFondosingle"><img src="images/cambiar.png"/></a><div id="agregarfondo" style="display:inline-block;" width:100%; class="informacion-2;"> <a id="cambiar3"   style="display:inline-block; width:40%;"><img src="images/abonoadicional.png" style="width:80%;"/><img src="images/visa_master_american_oxxo_7.png" style=""/></a>

  				//   </div>
  			 //  		<div style="width:80%; margin:0 auto; padding-top:20px;">
  				// 	<div id="formularioabono">

  				// 	</div>
  			 //  <p style="text-align:center;">Fecha de sig. abono: '.date("d-m-Y", strtotime("+1 month")).'</p></div></div>';
  			  
  				// }
  				// else{
  				// 	echo '
  				// 	<a style="text-align:center; display:inline-block; width:100%;" href="?route=users/gotoFondosingle" ><img src="images/fondo.png" style="width:80%; height:auto;"/></a> 

  				// 	<div id="agregarfondo" style="display:inline-block;" width:100%; class="informacion-2;">
  				// 		<a id="cambiar3" style="display:inline-block; width:50%;"><img src="images/abonoadicional.png" style="width:80%;"/>
  				// 		<img src="images/visa_master_american_oxxo_7.png" style="margin-bottom:0px; display:inline-block;/">
  				// 		</a>
  				//   		</div>
  				// 	</div>
  			 //  		<div style="width:80%; margin:0 auto; padding-top:20px;">
  				// 		<p style="color:#529ad3;">Mas información</p>
  				// 	</div>';

  				// }
  			?>	  
  				</form>
            </div>
          </div>
          <div class="col-lg-12">
            <h2 class="content" style="background-color:transparent;">Promociones del mes</h2>
            <div class="col-lg-6 col-md-6 promo" style="padding:1px; margin:0 0;"><img src="images/manzanillo.png" style="width:100%;"/>
              <p>Manzanillo</p>

            </div>
            <div class="col-lg-6 col-md-6 promo"  style="padding:1px; margin:0 0;"><img src="images/mazatlan.png" style="width:100%;"/><p>Mazatlan</p></div>
            <div class="col-lg-6 col-md-6 promo"  style="padding:1px; margin:0 0;"><img src="images/lasvegas.png" style="width:100%;"/><p>Las Vegas</p></div>
            <div class="col-lg-6 col-md-6 promo"  style="padding:1px; margin:0 0;"><img src="images/malaga.png" style="width:100%;"/><p>Malaga</p></div>
          </div>
          </div>
      <div class="col-lg-12 col-md-12">
            <div class="divider"></div>
          </div>
          <div class="col-lg-12 col-md-12" style="padding:20px;">
            <?php
  //echo '<a href="http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid='.$user_data["leisure_id"].'">';
  ?><img style="width:50%; height:auto;"src="images/irareservacion.png"/></a>
          </div>
          
      </div>
        
  	</div>

  </div>
  	 @include('layouts.__common.footer')

  @include('layouts.__common.tawk')
  @include('layouts.__common.analytics')


    
  // <?PHP	
  //echo '<script>
  // function confirmeUSD() {
  //     if (confirm("El cambio de moneda afectara las cantidades de su fondo vacacional,\nAHORRO MENSUAL:\n Ahora: $'.round($user_data['amount'],2).' '.$user_data['currency'].'\n Cambia a :  $'.round($user_data['amount']/$currency['rate'],2).' dlls mensuales \nAHORRO TOTAL:\n Ahora: '.$user_data['total_saved'].' '.$user_data['currency'].'\nCambia a: $'.round($user_data['total_saved']/$currency['rate'],2).' dlls") == true) {

  // 				$.ajax({
  // 		 type: "PUT",
  //  data: JSON.stringify({
  // "currencyCode": "USD",

  //  }),
  // url: "https://api.leisureloyalty.com/v3/members/'.$user_data["leisure_id"].'?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH",
  //    success: function() {
  //  window.location="?route=users/changetoUSD";
  //   }
  // });

         
  //     } 
  // }
  // 		function confirmeMXN() {
  //     if (confirm("El cambio de moneda afectara las cantidades de su fondo vacacional,\nAHORRO MENSUAL:\n Ahora: $'.round($user_data['amount'],2).' '.$user_data['currency'].'\n Cambia a :  $'.round($user_data['amount']*$currency['rate'],2).' MXN mensuales \nAHORRO TOTAL:\n Ahora: '.$user_data['total_saved'].' '.$user_data['currency'].'\nCambia a: $'.round($user_data['total_saved']*$currency['rate'],2).' MXN") == true) {
     


  // 				$.ajax({
  // 		 type: "PUT",
  //  data: JSON.stringify({
  // "currencyCode": "MXN",

  //  }),
  // url: "https://api.leisureloyalty.com/v3/members/'.$user_data["leisure_id"].'?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH",
  //    success: function() {
  //         window.location="?route=users/changetoMXN";
  //   }
  // });
  //     } 
  // }
  // 		function confirmUSD() {
  //     if (confirm("Dear affiliated Inspira notify you that making money exchange, according to the current bank exchange, your statement would be: Monthly Savings background holiday: Now: $'.round($user_data['amount'],2).' in '.$user_data['currency'].', MX monthly change to: $'.round($user_data['amount']/$currency['rate'],2).' dlls mensuales Ahorro total:") == true) {
  // 				$.ajax({
  // 		 type: "PUT",
  //  data: JSON.stringify({
  // "currencyCode": "USD",
  //  }),
  // url: "https://api.leisureloyalty.com/v3/members/'.$user_data["leisure_id"].'?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH",
  //    success: function() {
  //  window.location="?route=users/changetoUSD";
  //   }
  // });
  //     } 
  // }
  // 		function confirmMXN() {
  //     if (confirm("Dear affiliated Inspira notify you that making money exchange, according to the current bank exchange, your statement would be: Monthly Savings background holiday: Now: $'.round($user_data['amount'],2).' in '.$user_data['currency'].', dlls monthly change to: $'.round($user_data['amount']*$currency['rate'],2).' MXN mensuales Ahorro total:") == true) {


  // 				$.ajax({
  // 		 type: "PUT",
  //  data: JSON.stringify({
  // "currencyCode": "MXN",

  //  }),
  // url: "https://api.leisureloyalty.com/v3/members/'.$user_data["leisure_id"].'?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH",
  //    success: function() {
  //         window.location="?route=users/changetoMXN";
  //   }
  // });  } 
  // }
  // function changeEng(){
  // 				$.ajax({
  // 		 type: "PUT",
  //  data: JSON.stringify({
  // "languageCode": "EN",

  //  }),
  // url: "https://api.leisureloyalty.com/v3/members/'.$user_data["leisure_id"].'?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH",
  //    success: function() {
  // window.location="?route=users/changeENGLISH";
  //   }
  // });

  // }
  // </script>';
  ?>
  <?PHP 
  // echo '<script>
  // 	$(function() {
  // $.ajax({
  // 		 type: "PUT",
  //  data: JSON.stringify({
  // "mtierId": 111

  //  }),
  // url: "https://api.leisureloyalty.com/v3/members/changeTier/'.$user_data["leisure_id"].'?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH",
  //    success: function() {
  //     console.log("Tier Updated Successfully!");
  //   }
  // });
  // });
  // 	</script>';
  ?>
  </body>
  </html>