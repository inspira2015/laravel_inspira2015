@extends('layouts.basic', array( 'title' => Lang::get('code.title'), 'background' => 'codigo-background.jpg' ))

@section('content')

<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row bg-gray-transparent" style="border-top:150px;">
		<div class="col-sm-12 col-sm-pull-1 col-sm-offset-1 text-justify " style="font-size:24px;">
			<div class="row">
				<div class="col-xs-10 col-xs-push-2 col-sm-5 col-sm-push-7 col-md-4 col-md-push-8 nopadding">				
					<button type="submit" class="btn btn-blue-clear btn-medium">
						{{ Lang::get('auth.reset-password') }}
					</button>
				</div>	
				<div class="divider"></div>
				<div class="col-sm-10 col-sm-push-1 col-md-6 col-md-push-3">
					<div class="code"></div>
				</div>
			</div>
	
			<div class="row">
				<div class="col-sm-12 nopadding spacing">
				{{ Lang::get('auth.reset-password-message') }}
				</div>
			</div>
		</div>
		<div class="col-sm-10 col-sm-offset-1">
			<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
			<div class="inputs">
				{!! Form::text('email', old('email') , array( 'required' => 'required')) !!}
			</div>
		</div>
		<div class="col-sm-10 col-sm-offset-1">
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif
			@include('errors.messages')
		</div>
	</div>
	<div class="row bg-gray-transparent" style="margin-bottom: 450px;">
		<div class="col-xs-12 col-sm-10 col-sm-offset-1 nopadding">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<button type="submit" class="btn-blue btn-big">
						{{ Lang::get('auth.reset-password') }}
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection