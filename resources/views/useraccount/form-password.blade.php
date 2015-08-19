{!! Form::open(array('url' => 'useraccount/update-password' , 'class' => 'form-data' )) !!}
	{!! Form::hidden('current_password',  Crypt::encrypt($user->details->password) ) !!}
	<div class="form-group">
		<label for="password">{{ Lang::get('userdata.password') }}: </label>
		<div class="input-group">
			<input type="password" name="password" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label for="confirm">{{ Lang::get('userdata.confirm-password') }}: </label>
		<div class="input-group">
			<input type="password" name="password_confirmation"  class="form-control">
		</div>
	</div>
	<div class="form-group">
	@include('errors.messages')
	</div>
	<div class="form-group">
		<div class="col-xs-4 col-xs-push-8 text-center nopadding">
			<div data-role="submit" data-route="useraccount/update-password" class="btn-blue btn-small">{{ Lang::get('userdata.save') }}</div>
		</div>
	</div>
{!! Form::close() !!}
