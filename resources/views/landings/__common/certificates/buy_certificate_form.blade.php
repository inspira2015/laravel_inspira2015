{!! Form::open() !!}
<div class="row">
	<div class="col-xs-5 col-sm-2 col-md-2 nopadding">  
		<a href="{{ url('/') }}" class="btn-blue-clear btn-medium back">
			{{ Lang::get('layout.back') }}
		</a>
	</div>
	<div class="col-xs-5 col-xs-push-2 col-sm-2 col-sm-push-8 col-md-2 col-md-push-8 nopadding">   
		<div data-role="submit" data-route="{{ url('pagar-certificado') }}" class="btn-blue-clear btn-medium">
			{{ Lang::get('layout.continue') }}
		</div>
	</div>
	<div class="divider"></div>
</div>

<div class="row bg-light-gray text-left">
	<h2 style="font-size:20px;font-weight: 400;padding: 20px 10px;">CERTIFICADO INCLUYE</h2>
	<div id="product-offers">
		<div class="table-row">
			<div class="table-cell">Hospedaje de 7 noches en resort de lujo</div>
			<div class="table-cell"><span>{!! HTML::image('images/Paloma.png', 'Beneficios Inspira') !!}</span></div>
		</div>
		<div class="table-row">
			<div class="table-cell">Hospedaje de 2 hasta 8 adultos</div>
			<div class="table-cell"><span>{!! HTML::image('images/Paloma.png', 'Beneficios Inspira') !!}</span></div>
		</div>
		<div class="table-row">
			<div class="table-cell">Opciones de alojamiento en resorts de lujo alrededor del mundo<span class="small-super">1</span></div>
			<div class="table-cell"><span>{!! HTML::image('images/Paloma.png', 'Beneficios Inspira') !!}</span></div>
		</div>
		<div class="table-row">
			<div class="table-cell">Descuentos en renta de autom&oacute;vil</div>
			<div class="table-cell"><span>{!! HTML::image('images/Paloma.png', 'Beneficios Inspira') !!}</span></span></div>
		</div>
		<div class="table-row">
			<div class="table-cell">Compra de boletos de avi&oacute;n</div>
			<div class="table-cell"><span>{!! HTML::image('images/Paloma.png', 'Beneficios Inspira') !!}</span></div>
		</div>
		<div class="table-row">
			<div class="table-cell">Descuentos en actividades como tours y excursiones</div>
			<div class="table-cell"><span>{!! HTML::image('images/Paloma.png', 'Beneficios Inspira') !!}</span></div>
		</div>
		<div class="table-row">
			<div class="table-cell">Precio m&aacute;s bajo en el mercado, GARANTIZADO</div>
			<div class="table-cell"><span>{!! HTML::image('images/Paloma.png', 'Beneficios Inspira') !!}</span></div>
		</div>
	</div>
	
	<div class="col-xs-12 bg-blue text-right" id="price-offer">
		COSTO TOTAL: $ {{ $price }} MX
	</div>
	<div class="col-xs-12 text-right nopadding" style="margin-top:10px;margin-right: 10px;">
		<span class="small-super">1</span> Debido a disponibilidad o demanda, algunos cuartos pueden tener un costo adicional
	</div>
</div>
<div class="row bg-light-gray text-left">
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-6">
			<h2 style="font-size:20px;font-weight: 400;padding: 20px 10px;">DATOS DE COBRO POR TARJETA</h2>
		</div>
		<div class="hidden-xs col-sm-2 col-md-6 text-right">
			<img src="images/markets.png" style="margin-top:10px;margin-right: 20px;">
		</div>
	</div>
	
	@if(is_object(@$cc) || isset($name_on_card))
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<a data-role="change" data-route="{{ url('nueva-tarjeta') }}">
				{!! Form::radio('cc-option', '',!isset($name_on_card) ? 'true' : '', array('data-role' => 'change', 'data-route' => 'nueva-tarjeta') ) !!}  
				<span style="color:#465664;font-weight: 600;">NUEVA TARJETA</span>
			</a>
		</div>
		<div class="col-xs-12 col-sm-6">
			<a data-role="change" data-route="{{ url('tarjeta-registrada') }}"> 
				{!! Form::radio('cc-option', '',isset($name_on_card) ? 'true' : '', array('data-role' => 'change', 'data-route' => 'nueva-tarjeta') ) !!} 
				<span style="color:#465664;font-weight: 600;">USAR DATOS DEL ULTIMO REGISTRO</span>
			</a>
		</div>
	</div><br>
	@endif
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="name">* {{ Lang::get('creditcards.card-number') }}</label>
				<div class="input-group extra-width">
					{!! Form::text('cnumber', Input::get('cnumber') ? Input::get('cnumber') : @$cnumber, array('class' => 'form-control','id' => 'card_number')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="numero">* {{ Lang::get('creditcards.ccv') }} <a data-toggle="modal" class="small" data-target="#what-is-ccv" href="#">{{ Lang::get('creditcards.what-is') }}</a></label>
				<div class="input-group extra-width">
				  {!! Form::text('ccv', Input::get('ccv') ? Input::get('ccv') : @$ccv, array('class' => 'form-control','id' => 'codigo', 'size' => '4', 'maxlength' => '4' )) !!}                        
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="expiration">* {{ Lang::get('creditcards.expiration') }}</label>
				<div class="input-group extra-width">
					{!! Form::text('expiration_date', Input::get('expiration_date') ? Input::get('expiration_date') : @$cc->expiration_date, array('class' => 'form-control', 'size' => '7', 'maxlength' => '7', 'data-mask-type' => 'expiration', 'placeholder' => Lang::get('creditcards.expiry'))) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
                <label for="nombre">* {{ Lang::get('creditcards.birthdate') }}</label>
                <div class="input-group extra-width">
                  {!! Form::text('birthdate', Input::get('birthdate') ? Input::get('birthdate') : @$birthdate, array('class' => 'form-control', 'data-mask-type' => 'date', 'placeholder' => Lang::get('creditcards.birthdate-format') )) !!}                                                
                </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
	            <label for="nombre">* {{ Lang::get('creditcards.name-on-card') }}</label>
	            <div class="input-group extra-width">
	              {!! Form::text('name_on_card', Input::get('name_on_card') ? Input::get('name_on_card') : @$name_on_card, array('class' => 'form-control','id' => 'name_on_card')) !!}                                                
	            </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			    <label for="direccion">* {{ Lang::get('creditcards.address') }}</label>
			    <div class="input-group extra-width">
			      {!! Form::text('address', Input::get('address') ? Input::get('address') : @$address, array('class' => 'form-control','id' => 'address')) !!}                                                
			    </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="pais">* {{ Lang::get('creditcards.country') }}</label>
				<div class="input-group extra-width">
					{!! Form::select('country', [
					   'MX' => 'M&eacute;xico'],'MX', array('class' => 'form-control' )
					) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
                <label for="state">* {{ Lang::get('creditcards.state') }}</label>
                <div class="input-group select-state extra-width">
					{!! Form::select('state', $states, @$state, array('class' => 'form-control' ) ) !!}
                </div>
        	</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			    <label for="direccion">* {{ Lang::get('creditcards.city') }}</label>
			    <div class="input-group extra-width">
			      {!! Form::text('city', Input::get('city') ? Input::get('city') : @$city, array('class' => 'form-control','id' => 'city')) !!}                                                
			    </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			    <label for="direccion">* {{ Lang::get('creditcards.zip-code') }}</label>
			    <div class="input-group  extra-width">
			      {!! Form::text('zip_code', Input::get('zip_code') ? Input::get('zip_code') : @$zip_code, array('class' => 'form-control','id' => 'zip_code')) !!}                                                
			    </div>
			</div>
		</div>
	</div>
	<input type="hidden" name="terms" value="1">
	<input type="hidden" name="privacy" value="1">
</div>

<div class="row">
	<div class="col-md-10 col-md-push-1">
		@include('errors.messages')
	</div>
</div>

<div clas="row" style="margin-top: 30px;">
	<div class="col-xs-5 col-sm-3 col-md-2 nopadding">  
		<a href="{{ url('/') }}" class="btn-blue-clear btn-medium back">
			{{ Lang::get('layout.back') }}
		</a>
	</div>
	<div class="col-xs-6 col-xs-push-2 col-sm-3 col-sm-push-6 col-md-3 col-md-push-7 nopadding">   
		<div data-role="submit" data-route="{{ url('pagar-certificado') }}" class="btn-blue btn-medium">
			{{ Lang::get('layout.continue') }}
		</div>
		<div class="col-xs-12 text-right nopadding" id="mandatory">
		* {{ Lang::get('layout.required-fields') }}
		</div>
	</div>
</div>
{!! Form::close() !!}

<style>
	#product-offers span img{
		width: 20px;
	}
</style>