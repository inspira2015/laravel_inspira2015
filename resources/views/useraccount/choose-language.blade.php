@if( isset( $action ) )
	@if( $action == 'edit' )
		<p style="display:inline-block; width:40%;">{{ Lang::get('userdata.language') }}: &nbsp; {{ Str::upper($user->details->language) }}</p> 
		<a style="color:#cc4b9b;" data-role="change" data-route="useraccount/edit-language"> 
			@if( $user->details->language == 'es' )
				<img src="images/cambiar.png" style="vertical-align:text-top;"/>
			@else
				<img src="images/cambiarENG.png" style="vertical-align:text-top;"/>
			@endif
		</a>
	@else
		{!! Form::open() !!}
		<div class="form-group">
			<label for="language">{{ Lang::get('userdata.language') }}</label>
			<div class="input-group">
				{!! Form::text('language',  'language') !!}
			
				<a style="color:#cc4b9b;display: inline-block;" data-role="submit" data-route="useraccount/update-language"> 
				@if( $user->details->language == 'es' )
					<img src="images/guardar.png" style="vertical-align:text-top;"/>
				@else
					<img src="images/guardarENG.png" style="vertical-align:text-top;"/>
				@endif
			</div>
		</a>
		</div>

		{!! Form::close() !!}
	@endif
@endif