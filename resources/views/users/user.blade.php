@extends('layouts.master')

@section('content')
<div class="row" id="arriba">
	<div id="error">

	</div>
	<div class="col-md-10 col-md-push-1">
		@include('errors.messages')
	</div>

	{!! Form::open(array('url' => 'users/registration', 'id' => 'user_data','name' => 'formulario','data-toggle' => 'validator')) !!}

	<div class="col-sm-10-col-sm-push-2 " id="formularios">
		<div class="form-group">
			<label for="name">* {{ Lang::get('registry.name') }}</label>
			<div class="input-group">
				{!! Form::text('name',  Input::get('name') ? Input::get('name') : @$name, array('required','class' => 'form-control','id' => 'name', 'placeholder' => Lang::get('registry.name_place'))) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="last_name">* {{ Lang::get('registry.last_name') }}</label>
			<div class="input-group">
				{!! Form::text('last_name', Input::get('last_name') ? Input::get('last_name') : @$last_name, array('required','class' => 'form-control','id' => 'last_name')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="InputEmail">* E-mail</label>
			<div class="input-group">
				{!! Form::email('email', Input::get('email') ? Input::get('email') : @$email, array('required','class' => 'form-control','id' => 'email', 'autocomplete' => 'false')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="contrasena">* {{ Lang::get('registry.password') }}</label>
			<div class="input-group">
				{!! Form::password('password',  array('required','class' => 'form-control','id' => 'password')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="contrasena2">* {{ Lang::get('registry.retype_pwd') }}</label>
			<div class="input-group">
				<input type="password" class="form-control" name="password_check" id="password_check"  value=""required>
			</div>
		</div>  

		<div class="form-group">
			<label for="celular">* {{ Lang::get('registry.celphone') }}</label>
			<div class="input-group">
				{!! Form::text('cellphone_number', Input::get('cellphone_number') ? Input::get('cellphone_number') : @$cellphone_number, array('required','class' => 'form-control','id' => 'cellphone_number')) !!}
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group">
					<label for="pais">* {{ Lang::get('registry.country') }}</label>
					<div class="input-group">
					{!! Form::select('country', $country_list, Input::get('country') ? Input::get('country') : @$country, array('class' => 'select-country form-control', 'data-change' => 'select-state')) !!}
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-md-6">
				<div class="form-group">
					<label for="state">* {{ Lang::get('registry.state') }}</label>
					<div class="input-group select-state">
						@if( in_array( 'MX' , Config::get('extra.countries') ))
						{!! Form::select('state', $states, null, array('class' => 'form-control') ) !!}
						@else
						{!! Form::text( 'state',  '', array('class' => 'form-control')) !!}
						@endif
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
					{!! Form::select('language', $lan_list,Input::get('language')  ? Input::get('language') : @$language, array('class' => 'form-control','id' => 'language')) !!}
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-md-6">
			<div class="form-group">
				<label for="currency">* {{ Lang::get('registry.currency') }}</label>
				<div class="input-group">
					{!! Form::select('currency', $currency_list,Input::get('currency')   ? Input::get('currency') : @$currency, array('class' => 'form-control','id' => 'currency')) !!}
				</div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
	<div class="col-lg-12 col-md-12" style="padding:20px 20px 45px 20px;">
		<div class="divider"></div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  
		<a href="/codes/1">
			<img style="width:50%; height:auto;"src="<?php echo url();?>/images/regresartransparente.png"/>
		</a>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4"></div>
	<div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">   
		<a href="#" onClick="verificar()">
			<img style="width:50%; height:auto;"src="<?php echo url();?>/images/continuar.png"/>
		</a></div>
	</div>

{!! HTML::style('css/app/users.css') !!}
{!! HTML::script('js/users.js') !!}

@stop