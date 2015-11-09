@extends('layouts.uber.basic')

@section('content')
<div class="col-xs-12">
	<div class="row">
		<div class="swiper-container swiper-container-h slider">
			<div class="swiper-wrapper">
				<div class="swiper-slide" id="slide-1">
					<h1><a href="{{ url('/') }}"><img src="images/logo_inspira.png"></a></h1><br>

					<h2>Viaja a los mejores lugares con uber e inspira</h2>
					Los resorts mas lujosos rededor del mundo, al precio mas bajo<br>
					<br>
					<div class="row text-center">
						<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
					</div>
				</div>

<!--
				<div class="swiper-slide" id="slide-2">
					<h1><a href="{{ url('/') }}"><img src="images/logo_inspira.png"></a></h1><br>
					<h2>Viaja a los mejores lugares con uber e inspira</h2>
					Los resorts mas lujosos rededor del mundo, al precio mas bajo<br>
					<br>
					<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
				</div>
-->
<!--				<div class="swiper-slide" id="slide-3">
					<h1>
						<a href="//{{ Config::get('domain.front') }}">
							InspiraMexico.mx
						</a>
					</h1>
					<h2>Viaja a los mejores lugares con uber e inspira</h2>
					Los resorts mas lujosos rededor del mundo, al precio mas bajo<br>
					<br>
					<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
				</div>
				<div class="swiper-slide" id="slide-4">
					<h1>
						<a href="//{{ Config::get('domain.front') }}">
							InspiraMexico.mx
						</a>
					</h1>
					<h2>Viaja a los mejores lugares con uber e inspira</h2>
					Los resorts mas lujosos rededor del mundo, al precio mas bajo<br>
					<br>
					<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
				</div>
				<div class="swiper-slide" id="slide-5">
					<h1>
						<a href="//{{ Config::get('domain.front') }}">
							InspiraMexico.mx
						</a>
					</h1>
					<h2>Viaja a los mejores lugares con uber e inspira</h2>
					Los resorts mas lujosos rededor del mundo, al precio mas bajo<br>
					<br>
					<a href="{{ url('comprar-certificado') }}" class="btn-clear-white">COMPRAR CERTIFICADO</a>
				</div>
-->
			</div>
			<!-- Add Pagination -->
			<div class="swiper-pagination swiper-pagination-h"></div>
		</div>
    
	</div>
	<div class="row" id="map">
		<div class="container">
			<div class="row">
				<p>Creemos que viajar es esencial para el bienestar, desarrollo, salud mental y emocional de todo ser <br>
					humano, por esta raz&oacute;n queremos que todas las personas, sin importar estado socioecon&oacute;mico, edad y<br>
					limitaciones de tiempo &#33; VIAJEN !
				</p>
			</div>
			<div class="row">
				<h2>C&Oacute;MO FUNCIONA</h2>
				<p>Ingresa al sistema, escoge tu destino y fecha de vacaci&oacute;n, 
					compra tu certificado en l&iacute;nea y reserva.
				</p>
		</div>
		</div>
	</div>
	<div class="row text-center" id="destinations">
		<div class="col-xs-12">
			<h2>ALGUNOS DE NUESTROS DESTINOS.</h2>
			Da click en la imagen para ver resorts disponibles de cada destino.
		</div>
		<div class="col-xs-12 nopadding">
			<ul>
				<li>
					<a href="{{ url('destino/mazatlan') }}" target="_blank">
						{!! HTML::image('images/destinations/mazatlan.png', 'Mazatl&aacute;n, Mex.') !!}
						<span>Mazatl&aacute;n, Mex.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/puerto-vallarta') }}" target="_blank">
						{!! HTML::image('images/destinations/puertovallarta.png', 'Puerto Vallarta, Mex.') !!}
						<span>Puerto Vallarta, Mex.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/las-vegas') }}" target="_blank">
						{!! HTML::image('images/destinations/lasvegas.png', 'Las Vegas, E.U.') !!}
						<span>Las Vegas, E.U.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino/malaga') }}" target="_blank">
						{!! HTML::image('images/destinations/malaga.png', 'M&aacute;laga, Esp.') !!}
						<span>M&aacute;laga, Esp.</span>
					</a>
				</li>
				<li>
					<a href="{{ url('destino') }}" target="_blank">
						{!! HTML::image('images/destinations/donde-quieres-ir.png', '&iquest; A d&oacute;nde quieres ir ?') !!}
						<span>&iquest; A d&oacute;onde quieres ir ?</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

@endsection