@extends('layouts.landings.promotions.basic')

@section('content')
<div class="col-xs-12">
	<div class="row">    
	    <div id="jssor-slider">
	        <div data-u="loading">
	            <div data-u="filter"></div>
	            <div data-u="slide-loading"></div>
	        </div>
	        <div data-u="slides">
	            <div data-p="225.00">
		            <img data-u="image" src="images/slider/promotions/slider-1.jpg" />
		            <div class="row">
			            <div data-u="information">
							<h1 data-u="logo"><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
		
							<h2>Viaja a los mejores lugares con inspira</h2>
							Los resorts m&aacute;s lujosos alrededor del mundo, al precio m&aacute;s bajo<br>
							<br>
							
			            </div>
		            </div>
		            <div class="row">
						<a href="#" data-anchor="more-info" id="more-info">M&Aacute;S INFO<br>
		    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
	    				</a>
					</div>
	            </div>
	            <div data-p="225.00">
		            <img data-u="image" src="images/slider/promotions/slider-2.jpg" />
		            <div class="row">
			            <div data-u="information">
							<h1 data-u="logo"><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
							<h2>VIAJAR ES FÁCIL Y SEGURO CON INSPIRA</h2>
							RESERVA F&Aacute;CILMENTE TODO LO NECESARIO PARA TU VIAJE DESDE NUESTRO SITIO<br>
							<br>
			            </div>
		            </div>
		            <div class="row">
						<a href="#" data-anchor="more-info" id="more-info">M&Aacute;S INFO<br>
		    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
	    				</a>
					</div>
	            </div>
	            <div data-p="225.00">
		            <img data-u="image" src="images/slider/promotions/slider-3.jpg" />
		            <div class="row">
			            <div data-u="information">
							<h1 data-u="logo"><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
							<h2>VIAJA CON TODOS TUS AMIGOS CON INSPIRA</h2>
							HOSPEDAJE DE HASTA 8 PERSONAS CON UN SOLO CERTIFICADO<br>
							<br>					
			            </div>
		            </div>
		            <div class="row">
						<a href="#" data-anchor="more-info" id="more-info">M&Aacute;S INFO<br>
		    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
	    				</a>
					</div>
	            </div>
	            <div data-p="225.00">
		            <img data-u="image" src="images/slider/promotions/slider-4.jpg" />
		            <div class="row">
			            <div data-u="information">
							<h1 data-u="logo"><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
							<h2>VIAJA POR TODO EL MUNDO CON INSPIRA</h2>
							LOS RESORTS M&Aacute;S LUJOSOS DE 86 PA&Iacute;SES ALREDEDOR DEL MUNDO<br>
							<br>
			            </div>
		            </div>
		            <div class="row">
						<a href="#" data-anchor="more-info" id="more-info">M&Aacute;S INFO<br>
		    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
	    				</a>
					</div>
	            </div>
	            <div data-p="225.00">
		            <img data-u="image" src="images/slider/promotions/slider-5.jpg" />
		            <div class="row">
			            <div data-u="information">
							<h1 data-u="logo"><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
							<h2>INSPIRA; UNA EXPERIENCIA INOLVIDABLE</h2>
							EXPERIMENTA UN NUEVO NIVEL COMFORT Y LUJO QUE ENUNCA OLVIDAR&Aacute;S<br>
							<br>
			            </div>
		            </div>
		            <div class="row">
						<a href="#" data-anchor="more-info" id="more-info">M&Aacute;S INFO<br>
		    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
	    				</a>
					</div>
	            </div>
	            <div data-p="225.00">
		            <img data-u="image" src="images/slider/promotions/slider-6.jpg" />
		            <div class="row">
			            <div data-u="information">
							<h1 data-u="logo"><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
							<h2>TUS VACACIONES DE ENSUE&Ntilde;O EN SOLO 3 PASOS:</h2>
							<br>
							<div class="row" data-u="steps">
								<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
									<div class="row">
										<div class="col-xs-4">
											<div class="row">{!! HTML::image('images/register-check.png', 'Reg&iacute;strate') !!}</div>
											<div class="row">1. REG&Iacute;STRATE</div>
										</div>
										<div class="col-xs-4">
											<div class="row">{!! HTML::image('images/cert.png', 'Comprar certificado') !!}</div>
											<div class="row">2. COMPRA CERTIFICADO</div>
										</div>
										<div class="col-xs-4">
											<div class="row">{!! HTML::image('images/reserv.png', 'Reserva') !!}</div>
											<div class="row">3. RESERVA</div>
										</div>
									</div>
								</div>
							</div>	
			            </div>
		            </div>
		            <div class="row">
						<a href="#" data-anchor="more-info" id="more-info">M&Aacute;S INFO<br>
		    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
	    				</a>
					</div>
	            </div>
	        </div>
	        <div data-u="navigator" class="jssorb05" data-autocenter="1">
	            <div data-u="prototype"></div>
	        </div>
	        <span data-u="arrowleft" class="jssora22l" data-autocenter="2"></span>
	        <span data-u="arrowright" class="jssora22r" data-autocenter="2"></span>
	    </div>
	</div>
		<div class="row text-center" id="destinations">
		<div class="col-xs-12">
			<h2>ALGUNOS DE NUESTROS DESTINOS</h2>
			Da clic en la imagen para ver resorts disponibles de cada destino
		</div>
		<div class="col-xs-12 nopadding">
			<ul>
				<li>
					<a href="{{ url('destino/mazatlan?u=demo') }}" target="_blank">
						{!! HTML::image('images/destinations/mazatlan-2.jpg', 'Mazatl&aacute;n, Mex.') !!}
						<span>Mazatl&aacute;n, Mex.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/puerto-vallarta?u=demo') }}" target="_blank">
						{!! HTML::image('images/destinations/puertovallarta.jpg', 'Puerto Vallarta, Mex.') !!}
						<span>Puerto Vallarta, Mex.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/orlando?u=demo') }}" target="_blank">
						{!! HTML::image('images/destinations/orlando.jpg', 'Orlando') !!}
						<span>Orlando, E.U.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/malaga?u=demo') }}" target="_blank">
						{!! HTML::image('images/destinations/malaga.jpg', 'M&aacute;laga, Esp.') !!}
						<span>M&aacute;laga, Esp.</span>
					</a>
				</li>
				<li class="hidden-xs">
					<a href="{{ url('destino?u=demo') }}" target="_blank">
						{!! HTML::image('images/destinations/donde-quieres-ir.jpg', '&iquest; A d&oacute;nde quieres ir ?') !!}
						<span>&iquest; A d&oacute;nde quieres ir ?</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="row" id="map" data-id="more-info">
		<div class="container">
			<div class="row">
				<h2>¿ QU&Eacute; ES UN CERTIFICADO ?</h2>

				<p>Un certificado equivale a hospedaje por una semana, para hasta 8 personas, en el resort de lujo de tu <br>
				elección entre 86 países alrededor del mundo. Tú eliges la fecha de hospedaje, con un límite de tiempo de <br>
				1 año para hacer la reservación desde la compra de tu certificado *</p>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<h2>COMO FUNCIONA</h2>
				</div>
				<div class="col-xs-12 step">
					<div class="row">
						<div class="col-xs-12 col-sm-4">
							<div class="row">{!! HTML::image('images/register-checkcolor.png', 'Reg&iacute;strate') !!}</div>
							<div class="row">1. REG&Iacute;STRATE</div>
						</div>
						<div class="col-xs-12 col-sm-4">
							<div class="row">{!! HTML::image('images/certcolor.png', 'Comprar certificado') !!}</div>
							<div class="row">2. COMPRA CERTIFICADO</div>
						</div>
						<div class="col-xs-12 col-sm-4">
							<div class="row">{!! HTML::image('images/reservcolor.png', 'Reserva') !!}</div>
							<div class="row">3. RESERVA</div>
						</div>
					</div>
				</div>
<!--
				<div class="col-xs-12">
					Conoce todos los resorts disponibles, dando clic en alguno de los destinos que se presentan abajo.
				</div>
-->
			</div>
		</div>
	</div>
	<div class="row bg-light-blue">
		<div class="container">
			<div class="row">
				* Solo la reservaci&oacute;n deber ser durante el periodo de un a&ntilde;o a partir de la compra, la fecha de tu vacaci&oacute;n no tiene limite de tiempo. Ejemplo: tu servicio debe ser durante el periodo del 2016, pero puedes llevar a cabo tu vacación en el 2017. <a href="#modal-semanas" data-toggle="modal" data-target="#modal-semanas"><span class="underline">ALTA DEMANDA O SEMANAS AZULES</span>&nbsp;&rsaquo;</a>
			</div>
		</div>
	</div>
	<div class="row bg-medium-blue">
		<div class="container">
			<div class="row">
				<p>Creemos que viajar es esencial para el bienestar, desarrollo, salud mental, f&iacute;sica y emocional de todo ser <br>
					humano, por esta raz&oacute;n queremos que todas las personas, sin importar estado socioecon&oacute;mico, edad y<br>
					limitaciones de tiempo ¡ VIAJEN !
				</p>
			</div>
		</div>
	</div>
</div>
@include('landings.__common.modal_blue_weeks')
@endsection