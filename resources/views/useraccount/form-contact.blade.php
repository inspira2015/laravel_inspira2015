
{!! Form::open(array('url' => 'useraccount/update-contact', 'class' => 'form-data' )) !!}
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.cell') }}:</label>
		<div class="input-group">
			{!! Form::text( 'cellphone',  $user->phones->cell['number'] , array('class' => 'form-control') ) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.phone') }}:</label>
		<div class="input-group">
			{!! Form::text( 'phone',  $user->phones->phone['number'], array('class' => 'form-control')) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.office') }}:</label>
		<div class="input-group">
			{!! Form::text( 'office',  $user->phones->office['number'], array('class' => 'form-control')) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.address') }}:</label>
		<div class="input-group">
			{!! Form::text( 'address',  $user->details->address, array('class' => 'form-control', 'data-mask-input' => 'phone')) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{  Lang::get('userdata.city') }}:</label>
		<div class="input-group">
			{!! Form::text( 'city',  $user->details->city, array('class' => 'form-control') ) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="country">{{ Lang::get('userdata.country') }}:</label>
		<div class="input-group">
			{!! Form::select('country', $countries, $user->details->country_code, array('class' => 'select-country form-control', 'data-change' => 'select-state', 'data-route' => url('api/states'))) !!}
		</div>
	</div>
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.state') }}:</label>
		<div class="input-group select-state">
			@if( in_array($user->details->country_code, Config::get('extra.countries') ))
			{!! Form::select('state', $states, $user->details->state , array('class' => 'form-control') ) !!}
			@else
			{!! Form::text( 'state',  $user->details->state, array('class' => 'form-control') ) !!}
			@endif
		</div>
	</div>
	<div class="form-group">
	@include('errors.messages')
	</div>
	<div class="form-group">
		<div class="col-xs-4 col-xs-push-8 text-center nopadding">
			<div data-role="submit" data-route="useraccount/update-contact" class="btn-blue btn-small">{{ Lang::get('userdata.save') }}</a>
		</div>
	</div>
{!! Form::close() !!}


