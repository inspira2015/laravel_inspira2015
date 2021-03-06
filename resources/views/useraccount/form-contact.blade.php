<h3>{{ Lang::get('userdata.information') }}
	@if(Session::has('complete-profile'))
	<br>
	<span style="color:#CC4B9B;font-size:12px;">
		{{ Lang::get('userdata.complete-profile') }}
	</span>
	@endif
</h3>

{!! Form::open(array('url' => 'useraccount/update-contact', 'class' => 'form-data' )) !!}
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.cell') }}:</label>
		<div class="input-group">
			{!! Form::text( 'cellphone',  $user->phones->cell , array('class' => 'form-control') ) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.phone') }}:</label>
		<div class="input-group">
			{!! Form::text( 'phone',  $user->phones->phone, array('class' => 'form-control')) !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.office') }}:</label>
		<div class="input-group">
			{!! Form::text( 'office',  $user->phones->office, array('class' => 'form-control')) !!}
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
		<div class="row">
		<div class="col-xs-4"><label for="country">{{ Lang::get('userdata.country') }}:</label></div>
		<div class="col-xs-8 nopadding">&nbsp;&nbsp;&nbsp;{{ $user->details->country }}</div>
		</div>
	</div>
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.state') }}:</label>
		<div class="input-group select-state">
			@if( in_array($user->details->country_code, Config::get('extra.countries') ))
			{!! Form::select('state', $states, $user->details->state->code , array('class' => 'form-control') ) !!}
			@else
			{!! Form::text( 'state',  $user->details->state->name, array('class' => 'form-control') ) !!}
			@endif
		</div>
	</div>
	<div class="form-group">
	@include('errors.messages')
	</div>
	<div class="form-group">
		<div class="col-xs-5 col-xs-push-7 col-sm-4 col-sm-push-8 text-center nopadding">
			<div data-role="submit" data-route="useraccount/update-contact" class="btn-blue btn-small">{{ Lang::get('userdata.save') }}</a>
		</div>
	</div>
{!! Form::close() !!}


