@extends('layouts.basic', array( 'title' => Lang::get('code.title') ))

@section('content')

{!! Form::open(array('url' => 'codes/check')) !!}
<div class="row bg-gray-transparent" style="border-top:150px;">
	<div class="col-sm-12 col-sm-pull-1 col-sm-offset-1 text-justify " style="font-size:24px;">
		<div class="row">
			<div class="col-xs-9 col-xs-push-3 col-sm-4 col-sm-push-8 col-md-3 col-md-push-9 nopadding">
				<a href="{{ url('users') }}" class="btn-blue-clear btn-medium">
					{{ Lang::get('code.continue-without-code') }}
				</a>
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
		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
		<div class="inputs">
			{!! Form::text('code', Input::get('code') ? $code : '', array( 'required' => 'required')) !!}
		</div>
	</div>
</div>
<div class="row bg-gray-transparent" style="margin-bottom: 450px;">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1">
		<div class="row">
			<div class="col-sm-5">
				<div data-role="submit" class="btn-blue btn-medium">{{ Lang::get('layout.with-code') }}</div>
			</div>
			<div class="col-sm-2 hidden-xs">
				<span style="border: 1px solid gray;"></span>
			</div>
			<div class="col-sm-5 nopadding">
				<a href="{{ url('users') }}" class="btn-blue-clear btn-medium">
					{{ Lang::get('code.continue-without-code') }}
				</a>
			</div>
		</div>
		@if($errors->has())
			<div class="row" id="code-error">
				<p>
					{{ Lang::get('code.promo-invalid') }}
				</p>
			</div>
		@endif
	</div>
</div>
{!! Form::close() !!}
@endsection
