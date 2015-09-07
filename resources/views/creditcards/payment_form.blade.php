{!! Form::open(array('url' => 'users/registration')) !!}
<div class="row">
	<div class="col-xs-12">
		<h2>
			{{  Lang::get('creditcards.card-information') }}
		</h2>
	</div>
	<div class="col-xs-4 col-xs-push-8 col-sm-3 col-sm-push-9 col-md-2 col-md-push-10">   
		<div data-role="submit" data-route="addcreditcard" class="btn-blue-clear btn-medium">
			{{ Lang::get('layout.continue') }}
		</div>
	</div>
	<div class="divider"></div>
</div>

<div class="col-md-10 col-md-push-1">
	@include('errors.messages')
</div>

<div class="col-sm-10-col-sm-push-2">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="name">* {{ Lang::get('creditcards.card-number') }}</label>
				<div class="input-group">
					{!! Form::text('cnumber', Input::get('cnumber') ? Input::get('cnumber') : @$cnumber, array('class' => 'form-control','id' => 'card_number')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="numero">* {{ Lang::get('creditcards.ccv') }} <a data-toggle="modal" class="small" data-target="#what-is-ccv" href="#">{{ Lang::get('creditcards.what-is') }}</a></label>
				<div class="input-group">
				  {!! Form::text('ccv', Input::get('ccv') ? Input::get('ccv') : @$ccv, array('class' => 'form-control','id' => 'codigo', 'size' => '4', 'maxlength' => '4' )) !!}                        
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="expiration">* {{ Lang::get('creditcards.expiration') }}</label>
				<div class="input-group">
					{!! Form::text('expiration_date', Input::get('expiration_date') ? Input::get('expiration_date') : @$expiration_date, array('class' => 'form-control', 'size' => '7', 'maxlength' => '7', 'data-mask-type' => 'expiration', 'placeholder' => Lang::get('creditcards.expiry'))) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
                <label for="nombre">* {{ Lang::get('creditcards.birthdate') }}</label>
                <div class="input-group">
                  {!! Form::text('birthdate', Input::get('birthdate') ? Input::get('birthdate') : @$birthdate, array('class' => 'form-control', 'data-mask-type' => 'date', 'placeholder' => Lang::get('creditcards.birthdate-format') )) !!}                                                
                </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
	            <label for="nombre">* {{ Lang::get('creditcards.name-on-card') }}</label>
	            <div class="input-group">
	              {!! Form::text('name_on_card', Input::get('name_on_card') ? Input::get('name_on_card') : @$name_on_card, array('class' => 'form-control','id' => 'name_on_card')) !!}                                                
	            </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			    <label for="direccion">* {{ Lang::get('creditcards.address') }}</label>
			    <div class="input-group">
			      {!! Form::text('address', Input::get('address') ? Input::get('address') : @$address, array('class' => 'form-control','id' => 'address')) !!}                                                
			    </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="pais">* {{ Lang::get('creditcards.country') }}</label>
				<div class="input-group">
					{!! Form::select('country', $country_list, Input::get('country') ? Input::get('country') : ( Lang::locale() == 'es' ? 'MX' : 'US' ) , array('class' => 'select-country form-control inspira-select', 'data-change' => 'select-state', 'data-route' => url('api/states'))) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
                <label for="state">* {{ Lang::get('creditcards.state') }}</label>
                <div class="input-group select-state">
					@if( in_array( Input::get('country') ? Input::get('country') : 'MX' , Config::get('extra.countries') ))
					{!! Form::select('state', $states, Input::get('country') ? Input::get('country') : 'MX', array('class' => 'form-control' ) ) !!}
					@else
					{!! Form::text( 'state',  Input::get('country') ? Input::get('country') : 'MX' , array('class' => 'form-control')) !!}
					@endif
                </div>
        	</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			    <label for="direccion">* {{ Lang::get('creditcards.city') }}</label>
			    <div class="input-group">
			      {!! Form::text('city', Input::get('city') ? Input::get('city') : @$city, array('class' => 'form-control','id' => 'city')) !!}                                                
			    </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			    <label for="direccion">* {{ Lang::get('creditcards.zip-code') }}</label>
			    <div class="input-group">
			      {!! Form::text('zip_code', Input::get('zip_code') ? Input::get('zip_code') : @$zip_code, array('class' => 'form-control','id' => 'zip_code')) !!}                                                
			    </div>
			</div>
		</div>
	</div>
	
	
</div>
<div class="col-sm-12" style="padding:20px 10px 10px 10px;">
	<div class="divider"></div>
</div>
<div clas="row">
	<div class="col-xs-6 col-md-4 text-left">
		<div class="row">
			<input type="radio" name="terms">
			{{ Lang::get('creditcards.accept') }} 
			<a href="#" data-toggle="modal" data-target="#terms">
				{{ Lang::get('creditcards.terms') }}
			</a>
		</div>
		<div class="row">
			<input type="radio" name="privacy">
			{{ Lang::get('creditcards.accept') }} 
			<a href="#" data-toggle="modal" data-target="#privacy">
				{{ Lang::get('creditcards.privacy') }}
			</a>
		</div>
	</div>

	<div class="col-xs-6 col-xs-push-0 col-sm-3 col-sm-push-3 col-md-3 col-md-push-5">   
		<div data-role="submit" data-route="addcreditcard" class="btn-blue btn-medium">
			{{ Lang::get('layout.continue') }}
		</div>
		<div class="col-xs-12 text-right nopadding" id="mandatory">
		* {{ Lang::get('layout.required-fields') }}
		</div>
	</div>
</div>

{!! Form::close() !!}
