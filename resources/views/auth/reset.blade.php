@extends('layouts.basic', array('title'=> Lang::get('auth.reset-password'), 'background' => 'codigo-background.jpg'))

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="row bg-gray" data-role="response">
			<div class="col-md-10 col-md-push-1">
				@include('errors.messages')
			</div>
			{!! Form::open(array('url' => 'password/reset', 'method' => 'post', 'role' => 'form', 'class' => 'col-md-10 col-md-push-1')) !!}
				<input type="hidden" name="token" value="{{ $token }}">
				<div class="form-group row">
					<label for="email">E-mail</label>
					<div class="input-group">
						{!! Form::email('email', Input::get('email') ? Input::get('email') : @$email, array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					<label for="password">{{ Lang::get('registry.password') }}</label>
					<div class="input-group">
						{!! Form::password('password',  array('class' => 'form-control')) !!}
					</div>
				</div>
				<div class="form-group row">
					<label for="password_confirmation"> {{ Lang::get('registry.retype_pwd') }}</label>
					<div class="input-group" >
						{!! Form::password('password_confirmation',  array('class' => 'form-control')) !!}
					</div>
				</div>  
				<div class="form-group text-center row">
				<div class="col-sm-8 col-sm-offset-2">
						<input type="submit" class="btn-light-blue btn-small" value="{{ Lang::get('auth.reset-password') }}">

					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
