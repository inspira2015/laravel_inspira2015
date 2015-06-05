<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Tarjeta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/style.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/estados.js"></script>
	<link rel="icon" href="images/inspira.ico" type="image/ico" />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slide.css" />
        <link rel="stylesheet" type="text/css" href="bootstrap/css/slidestyle.css" />
	<link rel="stylesheet" href="jquery.h5-lightbox.css">
</head>
<body style="height:100%;background-image:url('images/2.jpg'); background-repeat:no-repeat; background-position: center center fixed; 
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
	
    <div class="row" id="arriba" style="margin-bottom:50px;">
        <div id="error" style="color:red; text-align:left; margin:0 auto; width:300px;"></div>
		<div class="col-lg-12 col-md-12 col-sm-12" >
			<h1 style="font-size:24px; font-weight:bold;">
				DATOS DE COBRO
			</h1>
        <form method="post" action="?route=users/addcreditcard"  onsubmit="return verificar()" id="profile" name="formulario" data-toggle="validator">
            <div class="col-lg-1col-md-push-2 col-sm-10-col-sm-push-2 " id="formularios">
                <div class="form-group" style="width:100%;">
					<label for="tipo" style="width:100% !important; ">* TIPO DE TARJETA </label>
                    <div class="input-group" style="margin:0 auto;">
						 <div class="inputs"  style="font-weight:bold;">
          VISA<input type="radio" name="tipo" value="visa" id="tipo" checked="checked"  />
			MASTERCARD<input type="radio" name="tipo" id="tipo" value="master" />
					AMEX<input type="radio" name="tipo" id="tipo" value="amex" />
</div>
                    </div>
                </div>
			<div class="form-group">
                    <label for="numero">* Numero de tarjeta</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="numero" id="numero" placeholder="XXXXXXXXXXXXXXXX"  required>
                        
                    </div>
                </div>
			<div class="form-group">
                    <label for="numero">* Codigo CVV <a style="color:#cc4b9b; font-size:10px;" href="http://inspiramexico.mx/cvv/spanish.html" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">¿que es?</a></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="3 o 4 dígitos"  required>
                        
                    </div>
                </div>
				   <div class="form-group"> 
					   <label for="numero">* EXPIRACION </label>
                    <div class="input-group">
                        <select  class="form-control" style="width:30%"  name="expiracion_mes" id="expiracion_mes" placeholder="3 o 4 dígitos"  required>
                        <option value="">---Mes---</option>
							<option value=1>01</option>
							<option value=2>02</option>
							<option value=3>03</option>
							<option value=4>04</option>
							<option value=5>05</option>
							<option value=6>06</option>
							<option value=7>07</option>
							<option value=8>08</option>
							<option value=9>09</option>
							<option value=10>10</option>
							<option value=11>11</option>
							<option value=12>12</option>
						</select>
						<div class="form-control" style="width:3%;   background-color: transparent !important;  border: none !important; border-color: transparent"><label>&nbsp;</label></div>
                        <select  class="form-control" style="width:30%"  name="expiracion_ano" id="expiracion_ano" placeholder="3 o 4 dígitos"  required>
                        <option value="">---Año---</option>
							<option value=15>2015</option>
							<option value=16>2016</option>
							<option value=17>2017</option>
							<option value=18>2018</option>
							<option value=19>2019</option>
							<option value=20>2020</option>
							<option value=21>2021</option>
							<option value=22>2022</option>
							<option value=23>2023</option>
							<option value=24>2024</option>
							<option value=25>2025</option>
						</select>
						
                    </div>
                </div>	
				<div class="form-group">
                    <label for="nombre">* Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa tu nombre" value="<?php //echo $user_data["first_name"]; ?>" required>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="apellido">* Apellido(s)</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="apellido" id="apellido"  value="<?php //echo $user_data["last_name"]; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="direccion">* Dirección</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="direccion" name="direccion"  placeholder="Calle y Numero" value="<?php //echo $user_data["address"]; ?>" required>
                    </div>
                </div>
				<div class="form-group">
                    <label for="direccion">* Ciudad</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="ciudad" name="ciudad"  placeholder="Ciudad" value="<?php //echo $user_data["address"]; ?>" required>
                    </div>
                </div>
				<div class="form-group">
                    <label for="direccion">* Codigo Postal</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="postal" name="postal"  placeholder="Codigo postal" required>
                    </div>
                </div>
                <div class="form-group col-lg-6 col-md-6">
                    <label for="pais">* Pais</label>
                    <div class="input-group">
                     <select name="pais" id="pais" required class="form-control">
						 <option value="" selected>--Seleccionar--</option>
                      <option value="MX">México</option>
					  <option value="US">Estados Unidos</option>
                       <option value="AF">Afganistán</option> 
                      <option value="AL">Albania</option> 
                      <option value="DE">Alemania</option> 
                      <option value="AD">Andorra</option> 
                      <option value="AO">Angola</option> 
                      <option value="AI">Anguilla</option> 
                      <option value="AQ">Antártida</option> 
                      <option value="AG">Antigua y Barbuda</option> 
                      <option value="AN">Antillas Holandesas</option> 
                      <option value="SA">Arabia Saudí</option> 
                      <option value="DZ">Argelia</option> 
                      <option value="AR">Argentina</option> 
                      <option value="AM">Armenia</option> 
                      <option value="AW">Aruba</option> 
                      <option value="AU">Australia</option> 
                      <option value="AT">Austria</option>  
                      <option value="AZ">Azerbaiyán</option>  
                      <option value="BS">Bahamas</option>  
                      <option value="BH">Bahrein</option>  
                      <option value="BD">Bangladesh</option>  
                      <option value="BB">Barbados</option>  
                      <option value="BE">Bélgica</option>  
                      <option value="BZ">Belice</option>  
                      <option value="BJ">Benin</option>  
                      <option value="BM">Bermudas</option>  
                      <option value="BY">Bielorrusia</option>  
                      <option value="MM">Birmania</option>  
                      <option value="BO">Bolivia</option>  
                      <option value="BA">Bosnia y Herzegovina</option>  
                      <option value="BW">Botswana</option>  
                      <option value="BR">Brasil</option>  
                      <option value="BN">Brunei</option>  
                      <option value="BG">Bulgaria</option>  
                      <option value="BF">Burkina Faso</option>  
                      <option value="BI">Burundi</option>  
                      <option value="BT">Bután</option>  
                      <option value="CV">Cabo Verde</option>  
                      <option value="KH">Camboya</option>  
                      <option value="CM">Camerún</option>  
                      <option value="CA">Canadá</option>  
                      <option value="TD">Chad</option>  
                      <option value="CL">Chile</option>  
                      <option value="CN">China</option>  
                      <option value="CY">Chipre</option>  
                      <option value="VA">Ciudad del Vaticano (Santa Sede)</option>  
                      <option value="CO">Colombia</option>  
                      <option value="KM">Comores</option>  
                      <option value="CG">Congo</option>  
                      <option value="CD">Congo, República Democrática del</option>  
                      <option value="KR">Corea</option>  
                      <option value="KP">Corea del Norte</option>  
                      <option value="CI">Costa de Marfíl</option>  
                      <option value="CR">Costa Rica</option>  
                      <option value="HR">Croacia (Hrvatska)</option>  
                      <option value="CU">Cuba</option>  
                      <option value="DK">Dinamarca</option>  
                      <option value="DJ">Djibouti</option>  
                      <option value="DM">Dominica</option>  
                      <option value="EC">Ecuador</option>  
                      <option value="EG">Egipto</option>  
                      <option value="SV">El Salvador</option>  
                      <option value="AE">Emiratos Árabes Unidos</option>  
                      <option value="ER">Eritrea</option>  
                      <option value="SI">Eslovenia</option>  
                      <option value="ES">España</option>  
                      <option value="US">Estados Unidos</option>  
                      <option value="EE">Estonia</option>  
                      <option value="ET">Etiopía</option>  
                      <option value="FJ">Fiji</option>  
                      <option value="PH">Filipinas</option>  
                      <option value="FI">Finlandia</option>  
                      <option value="FR">Francia</option>  
                      <option value="GA">Gabón</option>  
                      <option value="GM">Gambia</option>  
                      <option value="GE">Georgia</option>  
                      <option value="GH">Ghana</option>  
                      <option value="GI">Gibraltar</option>  
                      <option value="GD">Granada</option>  
                      <option value="GR">Grecia</option>  
                      <option value="GL">Groenlandia</option>  
                      <option value="GP">Guadalupe</option>  
                      <option value="GU">Guam</option>  
                      <option value="GT">Guatemala</option>  
                      <option value="GY">Guayana</option>  
                      <option value="GF">Guayana Francesa</option>  
                      <option value="GN">Guinea</option>  
                      <option value="GQ">Guinea Ecuatorial</option>  
                      <option value="GW">Guinea-Bissau</option>  
                      <option value="HT">Haití</option>  
                      <option value="HN">Honduras</option>  
                      <option value="HU">Hungría</option>  
                      <option value="IN">India</option>  
                      <option value="ID">Indonesia</option>  
                      <option value="IQ">Irak</option>  
                      <option value="IR">Irán</option>  
                      <option value="IE">Irlanda</option>  
                      <option value="BV">Isla Bouvet</option>  
                      <option value="CX">Isla de Christmas</option>  
                      <option value="IS">Islandia</option>  
                      <option value="KY">Islas Caimán</option>  
                      <option value="CK">Islas Cook</option>  
                      <option value="CC">Islas de Cocos o Keeling</option>  
                      <option value="FO">Islas Faroe</option>  
                      <option value="HM">Islas Heard y McDonald</option>  
                      <option value="FK">Islas Malvinas</option>  
                      <option value="MP">Islas Marianas del Norte</option>  
                      <option value="MH">Islas Marshall</option>  
                      <option value="UM">Islas menores de Estados Unidos</option>  
                      <option value="PW">Islas Palau</option>  
                      <option value="SB">Islas Salomón</option>  
                      <option value="SJ">Islas Svalbard y Jan Mayen</option>  
                      <option value="TK">Islas Tokelau</option>  
                      <option value="TC">Islas Turks y Caicos</option>  
                      <option value="VI">Islas Vírgenes (EE.UU.)</option>  
                      <option value="VG">Islas Vírgenes (Reino Unido)</option>  
                      <option value="WF">Islas Wallis y Futuna</option>  
                      <option value="IL">Israel</option>  
                      <option value="IT">Italia</option>  
                      <option value="JM">Jamaica</option>  
                      <option value="JP">Japón</option>  
                      <option value="JO">Jordania</option>  
                      <option value="KZ">Kazajistán</option>  
                      <option value="KE">Kenia</option>  
                      <option value="KG">Kirguizistán</option>  
                      <option value="KI">Kiribati</option>  
                      <option value="KW">Kuwait</option>  
                      <option value="LA">Laos</option>  
                      <option value="LS">Lesotho</option>  
                      <option value="LV">Letonia</option>  
                      <option value="LB">Líbano</option>  
                      <option value="LR">Liberia</option>  
                      <option value="LY">Libia</option>  
                      <option value="LI">Liechtenstein</option>  
                      <option value="LT">Lituania</option>  
                      <option value="LU">Luxemburgo</option>  
                      <option value="MK">Macedonia, Ex-República Yugoslava de</option>  
                      <option value="MG">Madagascar</option>  
                      <option value="MY">Malasia</option>  
                      <option value="MW">Malawi</option>  
                      <option value="MV">Maldivas</option>  
                      <option value="ML">Malí</option>  
                      <option value="MT">Malta</option>  
                      <option value="MA">Marruecos</option>  
                      <option value="MQ">Martinica</option>  
                      <option value="MU">Mauricio</option>  
                      <option value="MR">Mauritania</option>  
                      <option value="YT">Mayotte</option>  
                      <option value="FM">Micronesia</option>  
                      <option value="MD">Moldavia</option>  
                      <option value="MC">Mónaco</option>  
                      <option value="MN">Mongolia</option>  
                      <option value="MS">Montserrat</option>  
                      <option value="MZ">Mozambique</option>  
                      <option value="NA">Namibia</option>  
                      <option value="NR">Nauru</option>  
                      <option value="NP">Nepal</option>  
                      <option value="NI">Nicaragua</option>  
                      <option value="NE">Níger</option>  
                      <option value="NG">Nigeria</option>  
                      <option value="NU">Niue</option>  
                      <option value="NF">Norfolk</option>  
                      <option value="NO">Noruega</option>  
                      <option value="NC">Nueva Caledonia</option>  
                      <option value="NZ">Nueva Zelanda</option>  
                      <option value="OM">Omán</option>  
                      <option value="NL">Países Bajos</option>  
                      <option value="PA">Panamá</option>  
                      <option value="PG">Papúa Nueva Guinea</option>  
                      <option value="PK">Paquistán</option>  
                      <option value="PY">Paraguay</option>  
                      <option value="PE">Perú</option>  
                      <option value="PN">Pitcairn</option>  
                      <option value="PF">Polinesia Francesa</option>  
                      <option value="PL">Polonia</option>  
                      <option value="PT">Portugal</option>  
                      <option value="PR">Puerto Rico</option>  
                      <option value="QA">Qatar</option>  
                      <option value="UK">Reino Unido</option>  
                      <option value="CF">República Centroafricana</option>  
                      <option value="CZ">República Checa</option>  
                      <option value="ZA">República de Sudáfrica</option>  
                      <option value="DO">República Dominicana</option>  
                      <option value="SK">República Eslovaca</option>  
                      <option value="RE">Reunión</option>  
                      <option value="RW">Ruanda</option>  
                      <option value="RO">Rumania</option>  
                      <option value="RU">Rusia</option>  
                      <option value="EH">Sahara Occidental</option>  
                      <option value="KN">Saint Kitts y Nevis</option>  
                      <option value="WS">Samoa</option>  
                      <option value="AS">Samoa Americana</option>  
                      <option value="SM">San Marino</option>  
                      <option value="VC">San Vicente y Granadinas</option>  
                      <option value="SH">Santa Helena</option>  
                      <option value="LC">Santa Lucía</option>  
                      <option value="ST">Santo Tomé y Príncipe</option>  
                      <option value="SN">Senegal</option>  
                      <option value="SC">Seychelles</option>  
                      <option value="SL">Sierra Leona</option>  
                      <option value="SG">Singapur</option>  
                      <option value="SY">Siria</option>  
                      <option value="SO">Somalia</option>  
                      <option value="LK">Sri Lanka</option>  
                      <option value="PM">St. Pierre y Miquelon</option>  
                      <option value="SZ">Suazilandia</option>  
                      <option value="SD">Sudán</option>  
                      <option value="SE">Suecia</option>  
                      <option value="CH">Suiza</option>  
                      <option value="SR">Surinam</option>  
                      <option value="TH">Tailandia</option>  
                      <option value="TW">Taiwán</option>  
                      <option value="TZ">Tanzania</option>  
                      <option value="TJ">Tayikistán</option>  
                      <option value="TF">Territorios franceses del Sur</option>  
                      <option value="TP">Timor Oriental</option>  
                      <option value="TG">Togo</option>  
                      <option value="TO">Tonga</option>  
                      <option value="TT">Trinidad y Tobago</option>  
                      <option value="TN">Túnez</option>  
                      <option value="TM">Turkmenistán</option>  
                      <option value="TR">Turquía</option>  
                      <option value="TV">Tuvalu</option>  
                      <option value="UA">Ucrania</option>  
                      <option value="UG">Uganda</option>  
                      <option value="UY">Uruguay</option>  
                      <option value="UZ">Uzbekistán</option>  
                      <option value="VU">Vanuatu</option>  
                      <option value="VE">Venezuela</option>  
                      <option value="VN">Vietnam</option>  
                      <option value="YE">Yemen</option>  
                      <option value="YU">Yugoslavia</option>  
                      <option value="ZM">Zambia</option>  
                      <option value="ZW">Zimbabue</option> </select>
                    </div>
                </div>
               <div class="form-group col-lg-6 col-md-6">
                    <label for="state">* Estado</label>
                    <div id="contenedor-estados" class="input-group">
						<input type="text" name="state" id="state" required class="form-control"/>
                    </div>
                </div>
				<div class="input-group" style="margin:0 auto;">
						 <div class="inputs"  style="width: 50%; float:left; display: inline-block; ">
          Acepto <a style=" color:#cc4b9b;" href=" http://inspiramexico.mx/terminos-y-condiciones/" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">Terminos y condiciones</a><input type="radio" name="toc" value="1" id="toc" />
					</div><div class="inputs"  style="width: 50%; float:left; display: inline-block; ">
			Acepto <a style=" color:#cc4b9b;" href="http://inspiramexico.mx/aviso-de-privacidad/" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">Politicas de privacidad</a><input type="radio" name="politicas" id="1" value="master" />
				
</div>
                    </div>
            </div>
			</form>
            </div>
           <div class="col-lg-12 col-md-12" style="padding:20px;">
          <div class="divider"></div></div>
		<div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">&nbsp;</div>
          <div class="col-lg-4 col-md-4 col-sm-4">&nbsp;</div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">   <a href="#" onClick="verificar()"><img style="width:50%; height:auto;"src="images/continuar.png"/></a></div>
        </div>
	</div><!--arriba-->
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
	<script type="text/javascript" src="js/validations_cc.js"></script>
</body>
</html>