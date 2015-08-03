@extends('layouts.basic')

@section('content')

<div class="row bg-gray-transparent">
	<div class="codigo"></div>
	{!! Form::open(array('url' => 'codes/check', 'id' => 'profile', 'name'=>'formulario')) !!}
	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
	
	<h2>
		{{ Lang::get('code.promo') }}
	</h2>
	<div class="col-sm-10 col-sm-push-1 col-md-8 col-md-push-2 nopadding">				
		<div class="inputs">
			<?php echo Form::text('code', Input::get('code') ? Input::get('code') : @$code, array( 'required' => 'required'));?>
		</div>
	</div>
	{!! Form::close() !!}
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
<style>
	h2 {
		text-transform:none; 
		font-size:24px; 
		color:#465664; 
		text-align:justify;
		margin-top:20px;
		margin-bottom: 20px;
	}
</style>
@endsection
