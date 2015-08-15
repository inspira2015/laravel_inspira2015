{!! Form::open(array('url' => 'users/registration', 'id' => 'user_data','name' => 'formulario','data-toggle' => 'validator')) !!}
<div class="row">
	<div class="col-xs-4 col-sm-3 col-sm-2">  
		<a href="/codes/1" class="btn-blue-clear btn-medium back">
			{{ Lang::get('layout.back') }}
		</a>
	</div>
	<div class="col-xs-4 col-xs-push-4 col-sm-3 col-sm-push-6 col-md-2 col-md-push-8">   
		<div data-role="submit" data-route="users/registration" class="btn-blue-clear btn-medium">
			{{ Lang::get('layout.continue') }}
		</div>
	</div>
	<div class="divider"></div>
</div>

<div class="row">
	<div class="col-md-10 col-md-push-1">
		@include('errors.messages')
	</div>
</div>

<div class="row">
	<div class="col-sm-10-col-sm-push-2">
		<div class="form-group">
			<label for="name">* {{ Lang::get('registry.name') }}</label>
			<div class="input-group">
				{!! Form::text('name',  Input::get('name') ? Input::get('name') : @$name, array('class' => 'form-control','id' => 'name', 'placeholder' => Lang::get('registry.name_place'))) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="last_name">* {{ Lang::get('registry.last_name') }}</label>
				<div class="input-group">
				{!! Form::text('last_name', Input::get('last_name') ? Input::get('last_name') : @$last_name, array('class' => 'form-control','id' => 'last_name')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="email">* E-mail</label>
			<div class="input-group">
				{!! Form::email('email', Input::get('email') ? Input::get('email') : @$email, array('class' => 'form-control validate-email','id' => 'email')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="password">* {{ Lang::get('registry.password') }}</label>
			<div class="input-group">
				{!! Form::password('password',  array('class' => 'form-control')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="password_confirmation">* {{ Lang::get('registry.retype_pwd') }}</label>
			<div class="input-group">
				{!! Form::password('password_confirmation',  array('class' => 'form-control')) !!}
			</div>
		</div>  
	
		<div class="form-group">
			<label for="cellphone_number">* {{ Lang::get('registry.celphone') }}</label>
			<div class="input-group">
				{!! Form::text('cellphone_number', Input::get('cellphone_number') ? Input::get('cellphone_number') : @$cellphone_number, array('class' => 'form-control','id' => 'cellphone_number', 'data-mask-type' => 'celular' )) !!}
			</div>
		</div>
	
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group">
					<label for="country">* {{ Lang::get('registry.country') }}</label>
					<div class="input-group">
					{!! Form::select('country', $country_list, Input::get('country') ? Input::get('country') : $location_info['country_code'], array('class' => 'select-country form-control inspira-select', 'data-change' => 'select-state')) !!}
					</div>
				</div>
			</div>
	
			<div class="col-lg-6 col-md-6">
				<div class="form-group">
					<label for="state">* {{ Lang::get('registry.state') }}</label>
					<div class="input-group select-state">
						@if( in_array( $location_info['country_code'] , Config::get('extra.countries') ))
						{!! Form::select('state', $location_info['states'], $location_info['state_code'], array('class' => 'form-control') ) !!}
						@else
						{!! Form::text( 'state',  '', array('class' => 'form-control')) !!}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="form-group">
			<label for="estado">* {{ Lang::get('registry.lang') }}</label>
			<div class="input-group">
				{!! Form::select('language', $lan_list,Input::get('language')  ? Input::get('language') : $location_info['language'], array('class' => 'form-control','id' => 'language')) !!}
			</div>
		</div>
	</div>

	<div class="col-lg-6 col-md-6">
		<div class="form-group">
			<label for="currency">* {{ Lang::get('registry.currency') }}</label>
			<div class="input-group">
				{!! Form::select('currency', $currency_list,Input::get('currency')   ? Input::get('currency') : $location_info['currency'], array('class' => 'form-control','id' => 'currency')) !!}
			</div>
		</div>
	</div>
</div>

<div class="col-sm-12">
	<div class="divider"></div>
</div>
<div class="col-xs-4 col-sm-2">  
	<a href="/codes/1" class="btn-blue-clear btn-medium back">
		{{ Lang::get('layout.back') }}
	</a>
</div>
<div class="col-xs-5 col-xs-push-3 col-sm-3 col-sm-push-7">   
	<div data-role="submit" data-route="users/registration" class="btn-blue btn-medium">
		{{ Lang::get('layout.continue') }}
	</div>
	<div class="col-xs-12 text-right nopadding" id="mandatory">
	* {{ Lang::get('layout.required-fields') }}
	</div>
</div>


{!! Form::close() !!}