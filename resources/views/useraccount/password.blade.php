@if( isset($action) )
	@if( $action == "edit" )
	<div id = "campos2">
		<p id = "correo" class=""> Email: {{ $user->details->email }}</p>
		<p id = "contrasena" class="">{{ Lang::get('userdata.password') }}: *********</p>
	</div>
	<a id= "cambiar2" data-role="change" data-route="useraccount/edit-details"><img src="images/cambiar.png"/></a>
	@else
		{!! Form::open(array('url' => 'useraccount/update-details' )) !!}
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
			<div data-role="submit" data-route="useraccount/update-details"><img src="images/guardar.png"/></div>
		{!! Form::close() !!}
	@endif
@endif