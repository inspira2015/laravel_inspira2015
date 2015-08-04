@extends('layouts.basic')

@section('content')

<div class="row bg-gray-transparent">
	
	
	<div class="col-sm-12 col-sm-pull-1 col-sm-offset-1 text-justify" style="font-size:24px;">
		<div class="row">
			<div class="col-xs-4 col-xs-push-8 col-sm-3 col-sm-push-9 col-md-2 col-md-push-10">
				<a href="#" onClick="formulario.submit()" class="btn-blue-clear">{{ Lang::get('layout.continue') }}</a>
			</div>
			<div class="divider"></div>
			<div class="col-sm-10 col-sm-push-1 col-md-6 col-md-push-3">
				<div class="code"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 nopadding spacing">
			{{ Lang::get('code.promo') }}
			</div>
		</div>
	</div>
	<div class="col-sm-10 col-sm-push-1">
		{!! Form::open(array('url' => 'codes/check', 'id' => 'profile', 'name'=>'formulario')) !!}

		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
		<div class="inputs">
			{!! Form::text('code', Input::get('code') ? Input::get('code') : @$code, array( 'required' => 'required')) !!}
		</div>
				
		{!! Form::close() !!}
	</div>
</div>
<div class="row bg-gray-transparent">
	<div class="col-xs-8 col-xs-push-2 col-sm-4 col-sm-push-4">
		<div class="row">
			<a href="#" onClick="formulario.submit()" class="btn-blue">{{ Lang::get('layout.continue') }}</a>
		</div>
		@if($errors->has())
			<div class="row" id="code-error">
				<p>
					{{ Lang::get('code.promo-invalid') }}
				</p> 
				<a href="{{ url('/users') }}" class="btn-pink-clear">
					{{ Lang::get('code.continue-without-code') }}
				</a>
			</div>
		@endif
	</div>
</div>
@endsection
