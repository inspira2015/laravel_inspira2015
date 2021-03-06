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
  <div class="container">
    <div class="row" id="arriba" style="margin-bottom:50px;">
      <div id="error" style="color:red; text-align:left; margin:0 auto; width:300px;"></div>
      <div class="col-lg-12 col-md-12 col-sm-12" >
        
        <form method="post" action="?route=users/complete_registration"  onsubmit="return verificar()" id="profile" name="formulario" data-toggle="validator">
            <div class="col-lg-1col-md-push-2 col-sm-10-col-sm-push-2 " id="formularios">
                
                <div class="form-group">
                    <label for="nombre">* Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="first_name" id="nombre" placeholder="Ingresa tu nombre" value="" required>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="apellido">* Apellido</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="last_name" id="apellido"  value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputEmail">* E-mail</label>
                    <div class="input-group">
                        <input type="correo" class="form-control" id="correo" name="email" value=""required>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="contrasena">* Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password"  value="" required>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="contrasena2">* Confirmar Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password_check" id="password_check"  value=""required>
                    </div>
                </div>  

                <div class="form-group">
                    <label for="celular">* Celular</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="celular" name="cel_phn" value="" required>
                    </div>
                </div>

                <!--<div class="form-group medios" style="width:50%; display:inline;">-->
        <div class="form-group col-lg-6 col-md-6">
                    <label for="pais">* Pais</label>
                    <div class="input-group">
                     <select name="country" id="pais" required class="form-control">
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
                <!--<div class="form-group medios" style="width:50%; display:inline;">-->
        <div class="form-group col-lg-6 col-md-6">
                    <label for="state">* Estado</label>
                    <div id="contenedor-estados" class="input-group">
            <input type="text" name="state" id="state" required class="form-control"/>
                    </div>
                </div>
            </div>
        <!--<div class="form-group medios" style="width:50%; display:inline;">-->
      <div class="form-group col-lg-6 col-md-6">
                    <label for="estado">* lenguaje</label>
                    <div class="input-group">
               <select name="language" id="language" required class="form-control">
                      <option value="ES" selected>Español</option>
            <option value="EN">English</option>
            </select>
                    </div>
                </div>
        <!--<div class="form-group medios" style="width:50%; display:inline;">-->
      <div class="form-group col-lg-6 col-md-6">
                    <label for="estado">* moneda</label>
                    <div class="input-group">
                         <select name="currency" id="currency" required class="form-control">
               
                      <option value="MXN" selected>MXN PESO</option>
            <option value="USD">USD DOLLAR</option>
            </select>
                    </div>
                </div>
        </form>
            </div>
           <div class="col-lg-12 col-md-12" style="padding:20px;">
          <div class="divider"></div></div>
    <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  <a ><img style="width:50%; height:auto;"src="<?php echo url();?>/images/regresartransparente.png"/></a></div>
          <div class="col-lg-4 col-md-4 col-sm-4"></div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">   <a href="#" onClick="verificar()"><img style="width:50%; height:auto;"src="<?php echo url();?>/images/continuar.png"/></a></div>
        </div>
          
        
        
    </div><!--arriba-->
  
    
    
    
    
    
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