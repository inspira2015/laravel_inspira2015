{!! Form::open(array('url' => url('payment/bonus') , 'class' => 'form-data' )) !!}

<div class="row margin-top">	
	<div class="col-xs-12">
		<div class="form-group">
			<label for="name">{{ Lang::get('creditcards.card-number') }}</label>
			<div class="input-group">
				{!! Form::text('cnumber', Input::get('cnumber') ? Input::get('cnumber') : @$cnumber, array('class' => 'form-control','id' => 'card_number')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="numero">{{ Lang::get('creditcards.ccv') }} <a data-toggle="modal" class="small" data-target="#what-is-ccv" href="#">{{ Lang::get('creditcards.what-is') }}</a></label>
			<div class="input-group">
			  {!! Form::text('ccv', Input::get('ccv') ? Input::get('ccv') : @$ccv, array('class' => 'form-control','id' => 'codigo', 'size' => '4', 'maxlength' => '4' )) !!}                        
			</div>
		</div>
		<div class="form-group">
			<label for="expiration">{{ Lang::get('creditcards.expiration') }}</label>
			<div class="input-group">
				{!! Form::text('expiration_date', Input::get('expiration_date') ? Input::get('expiration_date') : @$expiration_date, array('class' => 'form-control', 'size' => '7', 'maxlength' => '7', 'data-mask-type' => 'expiration', 'placeholder' => Lang::get('creditcards.expiry'))) !!}
			</div>
		</div>
		<div class="form-group">
            <label for="nombre">{{ Lang::get('creditcards.birthdate') }}</label>
            <div class="input-group">
              {!! Form::text('birthdate', Input::get('birthdate') ? Input::get('birthdate') : @$birthdate, array('class' => 'form-control', 'data-mask-type' => 'date', 'placeholder' => Lang::get('creditcards.birthdate-format') )) !!}                                                
            </div>
		</div>
		<div class="form-group">
            <label for="nombre">{{ Lang::get('creditcards.name-on-card') }}</label>
            <div class="input-group">
              {!! Form::text('name_on_card', Input::get('name_on_card') ? Input::get('name_on_card') : @$name_on_card, array('class' => 'form-control','id' => 'name_on_card')) !!}                                                
            </div>
		</div>
		<div class="form-group">
		    <label for="direccion">{{ Lang::get('creditcards.phone') }}</label>
		    <div class="input-group">
		      {!! Form::text('phone', Input::get('phone') ? Input::get('phone') : @$phone, array('class' => 'form-control','id' => 'phone', 'data-mask-type' => 'celular' )) !!}                                                
		    </div>
		</div>
			
		<div class="form-group">
		    <label for="direccion">{{ Lang::get('creditcards.address') }}</label>
		    <div class="input-group">
		      {!! Form::text('address', Input::get('address') ? Input::get('address') : @$address, array('class' => 'form-control','id' => 'address')) !!}                                                
		    </div>
		</div>
		
		<div class="form-group">
			<label for="pais">{{ Lang::get('creditcards.country') }}</label>
			<div class="input-group">
				{!! Form::select('country', $country_list, Input::get('country') ? Input::get('country') : ( Lang::locale() == 'es' ? 'MX' : 'US' ) , array('class' => 'select-country form-control inspira-select', 'data-change' => 'select-state', 'data-route' => url('api/states'))) !!}
			</div>
		</div>
		
		<div class="form-group">
            <label for="state">{{ Lang::get('creditcards.state') }}</label>
            <div class="input-group select-state">
				@if( in_array( Input::get('country') ? Input::get('country') : 'MX' , Config::get('extra.countries') ))
				{!! Form::select('state', $states, Input::get('country') ? Input::get('country') : 'MX', array('class' => 'form-control' ) ) !!}
				@else
				{!! Form::text( 'state',  Input::get('country') ? Input::get('country') : 'MX' , array('class' => 'form-control')) !!}
				@endif
            </div>
    	</div>
			
		<div class="form-group">
		    <label for="direccion">{{ Lang::get('creditcards.city') }}</label>
		    <div class="input-group">
		      {!! Form::text('city', Input::get('city') ? Input::get('city') : @$city, array('class' => 'form-control','id' => 'city')) !!}                                                
		    </div>
		</div>
		<div class="form-group">
		    <label for="direccion">{{ Lang::get('creditcards.zip-code') }}</label>
		    <div class="input-group">
		      {!! Form::text('zip_code', Input::get('zip_code') ? Input::get('zip_code') : @$zip_code, array('class' => 'form-control','id' => 'zip_code')) !!}                                                
		    </div>
		</div>

		<div class="form-group" style="line-height: 2;">
			<label for="amount">{{ Lang::get('userdata.amount') }}:   $</label>
			<div class="input-group">
				<input type="text" name="amount" class="form-control">{{ $user->currency }}
			</div>
		</div>
		<input type="hidden" name="currency" value="{{ $user->currency }}">
		<input type="hidden" name="terms" value="1">
		<input type="hidden" name="privacy" value="1">
		<div class="form-group">
			<div class="col-sm-4 col-sm-push-8 text-center nopadding">
				<div data-role="submit" data-route="useraccount/credit-payment" class="btn-blue btn-small">{{ Lang::get('userdata.pay') }}</div>
			</div>
		</div>
	</div>
</div>

<div class="row margin-top">
	<div class="col-xs-4 col-sm-8 text-center ">
		<img src="images/markets.png">
	</div>
	<div class="col-xs-8 col-sm-4 text-center">
		<a class="btn-blue-clear btn-small underline">M&aacute;s Info</a>
	</div>
</div>
{!! Form::close() !!}


<div class="row">
	<div class="col-xs-12">
	@include('errors.messages')
	</div>
</div>
	
@if(@$receipt)
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 text-center">
			<a href="{{ $receipt }}" class="btn-light-blue btn-small" target="_blank">{{ Lang::get('userdata.view-receipt') }}</a>
		</div>
	</div>
@endif


@include('creditcards.modal_ccv')
