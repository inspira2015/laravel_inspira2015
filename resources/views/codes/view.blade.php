@extends('layouts.basic', array( 'title' => Lang::get('code.title') ))

@section('content')

<div class="row bg-gray-transparent">
{!! Form::open(array('url' => 'codes/check', 'id' => 'profile', 'name'=>'formulario')) !!}

	<div class="col-sm-12 col-sm-pull-1 col-sm-offset-1 text-justify" style="font-size:24px;">
		<div class="row">
			@if($errors->has())
			<div class="col-xs-6 col-xs-push-6 col-sm-4 col-sm-push-8 col-md-3 col-md-push-9 nopadding">
				<a href="{{ url('users') }}" class="btn-blue-clear btn-medium">
					{{ Lang::get('code.continue-without-code') }}
				</a>
			</div>			
			@else
			<div class="col-xs-6 col-xs-push-6 col-sm-4 col-sm-push-8 col-md-2 col-md-push-10 nopadding">
				<div class="btn-blue-clear btn-medium" data-role="submit">
					{{ Lang::get('layout.continue') }}
				</div>
			</div>
			@endif
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
		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
		<div class="inputs">
			{!! Form::text('code', Input::get('code') ? $code : '', array( 'required' => 'required')) !!}
		</div>
	</div>
{!! Form::close() !!}
</div>
<div class="row bg-gray-transparent">
	<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
		<div class="row">
			<a href="#" onClick="formulario.submit()" class="btn-blue">{{ Lang::get('layout.continue') }}</a>
		</div>
		@if($errors->has())
			<div class="row" id="code-error">
				<p>
					{{ Lang::get('code.promo-invalid') }}
				</p>
			</div>
			<div class="row">
				<a href="{{ url('users') }}" class="btn-light-blue btn-medium">
					{{ Lang::get('code.continue-without-code') }}
				</a>
			</div>
		@endif
	</div>
</div>
@endsection
