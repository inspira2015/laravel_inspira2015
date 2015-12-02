@extends('layouts.landings.promotions.basic')

@section('content')
<div class="col-xs-12">
	<div class="row">


    <style>
        
        /* jssor slider bullet navigator skin 05 css */
        /*
        .jssorb05 div           (normal)
        .jssorb05 div:hover     (normal mouseover)
        .jssorb05 .av           (active)
        .jssorb05 .av:hover     (active mouseover)
        .jssorb05 .dn           (mousedown)
        */
        .jssorb05 {
            position: absolute;
        }
        .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
            position: absolute;
            /* size of bullet elment */
            width: 16px;
            height: 16px;
            background: url('images/slider/icons/b05.png') no-repeat;
            overflow: hidden;
            cursor: pointer;
        }
        .jssorb05 div { background-position: -7px -7px; }
        .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
        .jssorb05 .av { background-position: -67px -7px; }
        .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }

        /* jssor slider arrow navigator skin 22 css */
        /*
        .jssora22l                  (normal)
        .jssora22r                  (normal)
        .jssora22l:hover            (normal mouseover)
        .jssora22r:hover            (normal mouseover)
        .jssora22l.jssora22ldn      (mousedown)
        .jssora22r.jssora22rdn      (mousedown)
        */
        .jssora22l, .jssora22r {
            display: block;
            position: absolute;
            /* size of arrow element */
            width: 40px;
            height: 58px;
            cursor: pointer;
            background: url('images/slider/icons/a22.png') center center no-repeat;
            overflow: hidden;
        }
        .jssora22l { background-position: -10px -31px; }
        .jssora22r { background-position: -70px -31px; }
        .jssora22l:hover { background-position: -130px -31px; }
        .jssora22r:hover { background-position: -190px -31px; }
        .jssora22l.jssora22ldn { background-position: -250px -31px; }
        .jssora22r.jssora22rdn { background-position: -310px -31px; }
    </style>
    
    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden; visibility: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('images/slider/icons/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
            <div data-p="225.00" style="display: none;">
                <img data-u="image" src="images/slider/icons/red.jpg" />xxx
               <!--  <img data-u="image" src="img/red.jpg" />
                <div style="position: absolute; top: 30px; left: 30px; width: 480px; height: 120px; font-size: 50px; color: #ffffff; line-height: 60px;">TOUCH SWIPE SLIDER</div>
                <div style="position: absolute; top: 300px; left: 30px; width: 480px; height: 120px; font-size: 30px; color: #ffffff; line-height: 38px;">Build your slider with anything, includes image, content, text, html, photo, picture</div>
                <div data-u="caption" data-t="0" style="position: absolute; top: 100px; left: 600px; width: 445px; height: 300px;">
                    <img src="img/c-phone.png" style="position: absolute; top: 0px; left: 0px; width: 445px; height: 300px;" />
                    <img src="img/c-jssor-slider.png" data-u="caption" data-t="1" style="position: absolute; top: 70px; left: 130px; width: 102px; height: 78px;" />
                    <img src="img/c-text.png" data-u="caption" data-t="2" style="position: absolute; top: 153px; left: 163px; width: 80px; height: 53px;" />
                    <img src="img/c-fruit.png" data-u="caption" data-t="3" style="position: absolute; top: 60px; left: 220px; width: 140px; height: 90px;" />
                    <img src="img/c-navigator.png" data-u="caption" data-t="4" style="position: absolute; top: -123px; left: 121px; width: 200px; height: 155px;" />
                </div>
                <div data-u="caption" data-t="5" style="position: absolute; top: 120px; left: 650px; width: 470px; height: 220px;">
                    <img src="img/c-phone-horizontal.png" style="position: absolute; top: 0px; left: 0px; width: 470px; height: 220px;" />
                    <div style="position: absolute; top: 4px; left: 45px; width: 379px; height: 213px; overflow: hidden;">
                        <img src="img/c-slide-1.jpg" data-u="caption" data-t="6" style="position: absolute; top: 0px; left: 0px; width: 379px; height: 213px;" />
                        <img src="img/c-slide-3.jpg" data-u="caption" data-t="7" style="position: absolute; top: 0px; left: 379px; width: 379px; height: 213px;" />
                    </div>
                    <img src="img/c-navigator-horizontal.png" style="position: absolute; top: 4px; left: 45px; width: 379px; height: 213px;" />
                    <img src="img/c-finger-pointing.png" data-u="caption" data-t="8" style="position: absolute; top: 740px; left: 1600px; width: 257px; height: 300px;" />
                </div> -->
            </div>
            <div data-p="225.00" style="display: none;">
                <img data-u="image" src="images/slider/icons/purple.jpg" />xxxxxx
            </div>
            <div data-p="225.00" style="display: none;">
                <img data-u="image" src="images/slider/icons/blue.jpg" />xdfd
            </div>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>
        <a href="http://www.jssor.com" style="display:none">Bootstrap Carousel</a>
    </div>
    
		<div class="swiper-container swiper-container-h slider">
			<div class="swiper-wrapper">
				<div class="swiper-slide" id="promotions-slide-1">
					<h1><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>

					<h2>Viaja a los mejores lugares con inspira</h2>
					Los resorts m&aacute;s lujosos alrededor del mundo, al precio m&aacute;s bajo<br>
					<br>
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="promotions-slide-2">
					<h1><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>

					<h2>VIAJAR ES FÁCIL Y SEGURO CON INSPIRA</h2>
					RESERVA F&Aacute;CILMENTE TODO LO NECESARIO PARA TU VIAJE DESDE NUESTRO SITIO<br>
					<br>
					
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="promotions-slide-3">
					<h1><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>

					<h2>VIAJA CON TODOS TUS AMIGOS CON INSPIRA</h2>
					HOSPEDAJE DE HASTA 8 PERSONAS CON UN SOLO CERTIFICADO<br>
					<br>
					
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="promotions-slide-4">
					<h1><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>

					<h2>VIAJA POR TODO EL MUNDO CON INSPIRA</h2>
					LOS RESORTS M&Aacute;S LUJOSOS DE 86 PA&Iacute;SES ALREDEDOR DEL MUNDO<br>
					<br>
					
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="promotions-slide-5">
					<h1><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
					
					<h2>INSPIRA; UNA EXPERIENCIA INOLVIDABLE</h2>
					EXPERIMENTA UN NUEVO NIVEL COMFORT Y LUJO QUE ENUNCA OLVIDAR&Aacute;S<br>
					<br>
					
					<div class="row">
					<a href="#" data-anchor="more-info" id="more-info">M&aacute;s info<br>
	    				{!! HTML::image('images/more-info.png', 'M&aacute;s informaci&oacute;n') !!}
    				</a>
					</div>
				</div>
				<div class="swiper-slide" id="promotions-slide-6">
					<h1><a href="{{ url('/') }}"><img src="images/LogoInspira.png"></a></h1><br>
					
					<h2>TUS VACACIONES DE ENSUE&Ntilde;O EN SOLO 3 PASOS:</h2>
					<br>
					<div class="row" id="steps">
						<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-xs-12 col-sm-4">
									<div class="row">{!! HTML::image('images/register-check.png', 'Reg&iacute;strate') !!}</div>
									<div class="row">1. REG&Iacute;STRATE</div>
								</div>
								<div class="col-xs-12 col-sm-4">
									<div class="row">{!! HTML::image('images/cert.png', 'Comprar certificado') !!}</div>
									<div class="row">2. COMPRA CERTIFICADO</div>
								</div>
								<div class="col-xs-12 col-sm-4">
									<div class="row">{!! HTML::image('images/reserv.png', 'Reserva') !!}</div>
									<div class="row">3. RESERVA</div>
								</div>
							</div>
						</div>
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
				<div class="col-xs-12">
					Conoce todos los resorts disponibles, dando clic en alguno de los destinos que se presentan abajo.
				</div>
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
	<div class="row text-center" id="destinations">
		<div class="col-xs-12">
			<h2>ALGUNOS DE NUESTROS DESTINOS</h2>
			Da clic en la imagen para ver resorts disponibles de cada destino
		</div>
		<div class="col-xs-12 nopadding">
			<ul>
				<li>
					<a href="{{ url('destino/mazatlan') }}" target="_blank">
						{!! HTML::image('images/destinations/mazatlan-2.jpg', 'Mazatl&aacute;n, Mex.') !!}
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
					<a href="{{ url('destino/orlando') }}" target="_blank">
						{!! HTML::image('images/destinations/orlando.jpg', 'Orlando') !!}
						<span>Orlando, E.U.</span>
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