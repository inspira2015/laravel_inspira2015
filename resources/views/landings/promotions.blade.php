@extends('layouts.landings.promotions.basic')

@section('content')
<div class="col-xs-12">
	<div class="row">
		<div class="swiper-container swiper-container-h slider">
			<div class="swiper-wrapper">
				<div class="swiper-slide" id="slide-1">
					<h1><a href="{{ url('/') }}"><img src="images/logo_inspira.png"></a></h1><br>

					<h2>Viaja a los mejores lugares con uber e inspira</h2>
					Los resorts m&aacute;s lujosos alrededor del mundo, al precio m&aacute;s bajo<br>
					<br>
					<div class="row text-center">
						<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
					</div>
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="slide-4">
					<h1><a href="{{ url('/') }}"><img src="images/logo_inspira.png"></a></h1><br>

					<h2>VIAJAR ES FÁCIL Y SEGURO CON UBER E INSPIRA</h2>
					RESERVA F&Aacute;CILMENTE TODO LO NECESARIO PARA TU VIAJE DESDE NUESTRO SITIO<br>
					<br>
					<div class="row text-center">
						<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
					</div>
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="slide-5">
					<h1><a href="{{ url('/') }}"><img src="images/logo_inspira.png"></a></h1><br>

					<h2>VIAJA CON TODOS TUS AMIGOS CON UBER E INSPIRA</h2>
					HOSPEDAJE DE HASTA 8 PERSONAS CON UN SOLO CERTIFICADO<br>
					<br>
					<div class="row text-center">
						<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
					</div>
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="slide-2">
					<h1><a href="{{ url('/') }}"><img src="images/logo_inspira.png"></a></h1><br>

					<h2>VIAJA POR TODO EL MUNDO CON UBER E INSPIRA</h2>
					LOS RESORTS M&Aacute;S LUJOSOS DE 86 PA&Iacute;SES ALREDEDOR DEL MUNDO<br>
					<br>
					<div class="row text-center">
						<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
					</div>
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="slide-3">
					<h1><a href="{{ url('/') }}"><img src="images/logo_inspira.png"></a></h1><br>
					
					<h2>UBER E INSPIRA; UNA EXPERIENCIA INOLVIDABLE</h2>
					EXPERIMENTA UN NUEVO NIVEL COMFORT Y LUJO QUE ENUNCA OLVIDAR&Aacute;S<br>
					<br>
					<div class="row text-center">
						<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
					</div>
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
			</div>
			<!-- Add Pagination -->
			<div class="swiper-pagination swiper-pagination-h"></div>
		</div>
    
	</div>
	<div class="row" id="map" data-id="more-info">
		<div class="container">
			<div class="row">
				<p>Creemos que viajar es esencial para el bienestar, desarrollo, salud mental, f&iacute;sica y emocional de todo ser <br>
					humano, por esta raz&oacute;n queremos que todas las personas, sin importar estado socioecon&oacute;mico, edad y<br>
					limitaciones de tiempo ¡ VIAJEN !
				</p>
			</div>
			<div class="row">
				<h2>C&Oacute;MO FUNCIONA</h2>
				<p>Reg&iacute;strate, compra tu certificado y reserva.</p><br>
				<p>Conoce todos los resorts disponibles, dando clic en alguno de los destinos que se presentan abajo.
				</p>
		</div>
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
					<a href="{{ url('destino/mazatlan') }}" target="_blank">
						{!! HTML::image('images/destinations/mazatlan.jpg', 'Mazatl&aacute;n, Mex.') !!}
						<span>Mazatl&aacute;n, Mex.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/puerto-vallarta') }}" target="_blank">
						{!! HTML::image('images/destinations/puertovallarta.jpg', 'Puerto Vallarta, Mex.') !!}
						<span>Puerto Vallarta, Mex.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/las-vegas') }}" target="_blank">
						{!! HTML::image('images/destinations/orlando.jpg', 'Orlando') !!}
						<span>Las Vegas, E.U.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/malaga') }}" target="_blank">
						{!! HTML::image('images/destinations/malaga.jpg', 'M&aacute;laga, Esp.') !!}
						<span>M&aacute;laga, Esp.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino') }}" target="_blank">
						{!! HTML::image('images/destinations/donde-quieres-ir.jpg', '&iquest; A d&oacute;nde quieres ir ?') !!}
						<span>&iquest; A d&oacute;nde quieres ir ?</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

@endsection