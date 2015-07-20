{!! Form::open(array('url' => 'useraccount/update-password' )) !!}
	{!! Form::hidden('current_password',  Crypt::encrypt($user->details->password) ) !!}
	<div class="form-group">
		<label for="password">{{ Lang::get('userdata.password') }}: </label>
		<div class="input-group">
			<input type="password" name="password">
		</div>
	</div>
	<div class="form-group">
		<label for="confirm">{{ Lang::get('userdata.confirm-password') }}: </label>
		<div class="input-group">
			<input type="password" name="password_confirmation">
		</div>
	</div>
	@include('errors.messages')
	<div data-role="submit" data-route="useraccount/update-password"><img src="images/guardar.png"/></div>
{!! Form::close() !!}
