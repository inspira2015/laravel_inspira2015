<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content={!! csrf_token() !!}>

	{!! HTML::style('css/bootstrap/css/style.css') !!}
	{!! HTML::style('css/bootstrap/css/menu.css') !!}
	{!! HTML::style('css/bootstrap/css/bootstrap.min.css') !!}
	{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
	<link rel="icon" href="/images/inspira.ico" type="image/ico" />
	{!! HTML::script('js/jquery-1.10.2.min.js') !!}
	{!! HTML::script('css/bootstrap/js/bootstrap.min.js') !!}
	
	{!!  HTML::script('js/main.js') !!}
<!--
	{!! HTML::script('js/datos.js') !!}
	{!! HTML::script('js/datos_cuenta.js') !!}
	{!! HTML::script('js/datos_fondo.js') !!}
-->
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

			<div class="col-lg-12 col-md-12 col-sm-12" style="background-color:#e5e7e9; z-index:1000; margin-bottom:70px; margin-top: 50px;">
				<div class="col-lg-6">
					<h1 style="font-size:32px;  color:#818c95; ">
						<i class="fa fa-user" style="border: 3px solid grey; border-radius:50%; width:35px; height:35px;"></i>&nbsp;
						{{ Str::upper($user->details->name) }} {{ Str::upper($user->details->last_name) }}
					</h1>
				</div>
				<div class="col-lg-3"> </div>

				<div class="col-lg-3"><a href="<?php echo url(); ?>/auth/logout">Logout</a> </div>

			</div>

			<div class="col-lg-6" style="margin-top:35px;">
				<div class="col-lg-12">
					<div class="content" style="padding-bottom:40px; padding-top:10px;">
						<div class="informacion">
							<h2>{{ Lang::get('userdata.information') }}</h2>
							<div data-role="response">
								@include('useraccount.contact')
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="content" style="padding-top:20px;">
						<div class="informacion">
							<h2>{{ Lang::get('userdata.account-details') }}</h2>
							<div data-role="response">
								@include('useraccount.password', array('action' => 'edit' ))
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="content">
						<div class="informacion-2" style="padding-top:10px; padding-bottom:10px;">
							<div data-role="response">
								@include('useraccount.choose-language', array( 'action' => 'edit' ))
							</div>
							
							@if( Auth::user()->getCurrency() == 'MXN' )
							<p style="display:inline-block; width:40%;">{{ Lang::get('userdata.currency') }}: {{ Auth::user()->getCurrency() }}</p>
							<a onclick="confirmeMXN()" style="color:#cc4b9b;">
								<img src="images/cambiar.png" style="vertical-align:text-top;"/>
							</a>
							@else
							<p style="display:inline-block; width:40%;">{{ Lang::get('userdata.currency') }}: {{ Auth::user()->getCurrency() }}</p>
							<a onclick="confirmeUSD()" style="color:#cc4b9b;">
								<img src="images/cambiarENG.png" style="vertical-align:text-top;"/>
							</a>          
							@endif
						</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="content">
						<div class="informacion-2" style="padding-top:30px; padding-bottom:30px;">
							<h1 style="text-align:center;">{{ Lang::get('userdata.inspira-points') }} {{ Auth::user()->getPoints() }} {{ Lang::get('userdata.points') }}</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6" style="margin-top:35px;">
				<div class="col-lg-12">
					<div class="content">
					@if( $accountSetup->checkValidAccount() !==FALSE )
						<div class="informacion">
							<h2>a {{ Lang::get('userdata.affiliation-type') }}<br/>
							@if( Auth::user()->getAffiliation() == 1 )
								{{ Lang::get('userdata.discover') }}
							@elseif (Auth::user()->getAffiliation() == 2 )
								{{ Lang::get('userdata.platinium') }}
							@elseif (Auth::user()->getAffiliation() == 3 )
								{{ Lang::get('userdata.diamond') }}
							@endif
							</h2>
						</div>
						@if( (Auth::user()->getCode() - Auth::user()->getAffiliation()) > 0 )
						<a style="text-align:center;" href="?route=users/gotoAfiliacion_single">
							@if( $user->details->language )
							<img src="images/categoria.png" style="width:80%;"/>
							@else
							<img src="images/categoriaENG.png" style="width:80%;"/>
							@endif
						</a>
						@endif
						<div class="informacion-2">
							<p>{{ Lang::get('userdata.expiration-date') }}:</p>
							<p>{{ Auth::user()->getDetails()->expires }}</p>
						</div>
					@else
						<div class="informacion">
							<h2>a {{ Lang::get('userdata.affiliation-type') }}<br/>
						</h2>
							<a href="/accountsetup">Continuar la configuracion de tu Cuenta</a>
						</div>
					@endif
					</div>
				
				</div>
				<div class="col-lg-12">
					<div class="content">
						@if( $accountSetup->checkValidAccount() !==FALSE )
						<div class="informacion-2" style="margin-bottom:20px;">
							<h2>{{ Lang::get('userdata.vacation-fund') }}</h2>
							<p> {{ Lang::get('userdata.monthly-fee') }}: 
								$ {{ Auth::user()->getDetails()->amount }} {{ Auth::user()->getDetails()->currency }}
							</p>
							<p>{{ Lang::get('userdata.total-saved') }}: 
								$ {{ Auth::user()->getDetails()->total_amount }} {{ Auth::user()->getDetails()->currency }}
								<?php //echo $user_data['total_saved'];?> <?php //echo $user_data['currency'];?>
							</p>
						</div>
						<div style="display:inline-block;">

							<form action="https://mexico.dineromail.com/Shop/Shop_Ingreso.asp" method="post"> 
								<input type="hidden" name="NombreItem" value="Agregar a fondo"> 
								<input type="hidden" name="TipoMoneda" value="{{ Auth::user()->getDetails()->currency  == 'MXN' ? 1: 2 }}">
								<input type="hidden" name="E_Comercio" value="1534470"> 
								<input type="hidden" name="NroItem" value="12"> 
								<input type="hidden" name="DireccionExito" value="http://inspiramexico.mx/payments/dineromail"> 
								<input type="hidden" name="DireccionFracaso" value="http://inspiramexico.mx/payments/dineromail/error"> 
								<input type="hidden" name="DireccionEnvio" value="0"> 
								<input type="hidden" name="Mensaje" value="1"> 
								<input type='hidden' name='MediosPago' value='4,5,6,17,19,20,21,22,13,14,7'>
								
								@if( Auth::user()->getDetails()->amount > 0 )
								<a style="text-align:center; display:inline-block; width:40%; vertical-align:top;" href="?route=users/gotoFondosingle">
									<img src="images/cambiar.png"/>
								</a>
									<div id="agregarfondo" style="display:inline-block;" width:100%;="" class="informacion-2;">
										<a id="cambiar3" style="display:inline-block; width:50%;">
											@if( $user->details->language == 'es' )
												<img src="images/abonoadicional.png" style="width:80%;">
											@else
												<img src="images/abonoadicionalENG.png" style="width:80%;">
											@endif
											<img src="images/visa_master_american_oxxo_7.png" style="margin-bottom:0px; display:inline-block;/">
										</a>
							  		</div>

								<div style="width:80%; margin:0 auto; padding-top:20px;">
									<div id="formularioabono">
																	
									</div>
									<p style="text-align:center;">Fecha de sig. abono: {{ date("d-m-Y", strtotime("+1 month")) }}</p>
								</div>
								@else
									<a style="text-align:center; display:inline-block; width:100%;" href="?route=users/gotoFondosingle">
										@if( $user->details->language == 'es' )
											<img src="images/fondo.png" style="width:80%; height:auto;">
										@else
											<img src="images/fondoENG.png" style="width:80%; height:auto;">
										@endif
									</a>
									<div id="agregarfondo" style="display:inline-block;" width:100%;="" class="informacion-2;">
										<a id="cambiar3" style="display:inline-block; width:50%;">
											@if( $user->details->language == 'es' )
												<img src="images/abonoadicional.png" style="width:80%;">
											@else
												<img src="images/abonoadicionalENG.png" style="width:80%;">
											@endif
											<img src="images/visa_master_american_oxxo_7.png" style="margin-bottom:0px; display:inline-block;/">
										</a>
							  		</div>
							  		<div style="width:80%; margin:0 auto; padding-top:20px;">
										<p style="color:#529ad3;">More information</p>
									</div>
								@endif
							</form>
						</div>
						@else
							<div class="informacion-2" style="margin-bottom:20px;">
								<h2>{{ Lang::get('userdata.vacation-fund') }}</h2>
							</div>
								<a href="/accountsetup">Continuar la configuracion de tu Cuenta</a>

						@endif
						<?PHP ?>
					</div>


					<div class="col-lg-12">
						<h2 class="content" style="background-color:transparent;">Promociones del mes</h2>
						<div class="col-lg-6 col-md-6 promo" style="padding:1px; margin:0 0;">
							<img src="images/manzanillo.png" style="width:100%;"/>
							<p>Manzanillo</p>
						</div>
						<div class="col-lg-6 col-md-6 promo"  style="padding:1px; margin:0 0;">
							<img src="images/mazatlan.png" style="width:100%;"/><p>Mazatlan</p>
						</div>
						<div class="col-lg-6 col-md-6 promo"  style="padding:1px; margin:0 0;">
							<img src="images/lasvegas.png" style="width:100%;"/><p>Las Vegas</p>
						</div>
						<div class="col-lg-6 col-md-6 promo"  style="padding:1px; margin:0 0;">
							<img src="images/malaga.png" style="width:100%;"/><p>Malaga</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12">
				<div class="divider"></div>
			</div>

			@if( $accountSetup->checkValidAccount() !==FALSE )
			<div class="col-lg-12 col-md-12" style="padding:20px;">
				<?php
				//echo '<a href="http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid='.$user_data["leisure_id"].'">';
				?>
				@if( $user->details->language == 'es' )
					<img style="width:50%; height:auto;"src="images/irareservacion.png"/></a>
				@else
					<img style="width:50%; height:auto;"src="images/irareservacionENG.png"/></a>
				@endif
			</div>
			@endif
		</div>
	</div>	
</div>
<style>
	div[data-role="response"] a[data-role="change"], 
	div[data-role="response"] div[data-role="submit"] {
		cursor: pointer;
		padding-left: 0px;
		display: inline-block;
		padding-right: 0px;
		padding-bottom: 0px;
	}
	div.informacion h2{
		padding-bottom: 20px;
	}
	
	div.informacion form label{
		text-transform: capitalize;
	}
	
	div.informacion form .form-group {
	  margin-bottom: 5px;
	}
	div.informacion .alert-danger{
		margin: 20px 0 0 0;
	}
	
	div.informacion div[data-role="submit"]{
		margin: 20px 0;
	}
</style>
@include('layouts.__common.footer')

@include('layouts.__common.tawk')
@include('layouts.__common.analytics')
</body>
</html>