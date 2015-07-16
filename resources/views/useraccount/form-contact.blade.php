<div id = "campos">
{!! Form::open(array('url' => 'useraccount/update-contact' )) !!}
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.cell') }}:</label>
		<div class="input-group">
			{!! Form::text( 'phone[cellphone]',  $user->phones->cellphone['number'] ) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.phone') }}:</label>
		<div class="input-group">
			{!! Form::text( 'phone[phone]',  $user->phones->phone['number']) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.office') }}:</label>
		<div class="input-group">
			{!! Form::text( 'phone[office]',  $user->phones->office['number']) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.address') }}:</label>
		<div class="input-group">
			{!! Form::text( 'address',  $user->address['address'] ) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{  Lang::get('userdata.city') }}:</label>
		<div class="input-group">
			{!! Form::text( 'city',  $user->address['city'] ) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="country">{{ Lang::get('userdata.country') }}:</label>
		<div class="input-group">
			{!! Form::select('country', $countries, $user->details->country_code, array('class' => 'select-country', 'data-change' => 'select-state')) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.state') }}:</label>
		<div class="input-group select-state">
			@if( in_array($user->details->country_code, ['US', 'MX']))
			{!! Form::select('state', $states, $user->details->state ) !!}
			@else
			{!! Form::text( 'state',  $user->details->state ) !!}
			@endif
		</div>
	</div>
	<div data-role="submit" data-route="useraccount/update-contact"><img src="images/guardar.png"/></div>
{!! Form::close() !!}
</div>
