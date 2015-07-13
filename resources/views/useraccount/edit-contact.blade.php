<div id = "campos">
{!! Form::open(array('url' => 'useraccount/update-contact' )) !!}
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.cell') }}:</label>
		<div class="input-group">
			{!! Form::text('phone[cellphone]',  'cellphone') !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.phone') }}:</label>
		<div class="input-group">
			{!! Form::text('phone[phone]',  'phone') !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.office') }}:</label>
		<div class="input-group">
			{!! Form::text('phone[office]',  'office') !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.address') }}:</label>
		<div class="input-group">
			{!! Form::text('address',  'address') !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{  Lang::get('userdata.city') }}:</label>
		<div class="input-group">
			{!! Form::text('city',  'city') !!}
		</div>
	</div>
	
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.country') }}:</label>
		<div class="input-group">
			{!! Form::text('country',  'country') !!}
		</div>
	</div>
	<div class="form-group">
		<label for="cell">{{ Lang::get('userdata.state') }}:</label>
		<div class="input-group">
			{!! Form::text('state',  'state') !!}
		</div>
	</div>
	<div data-role="submit" data-route="useraccount/update-contact"><img src="images/guardar.png"/></div>
{!! Form::close() !!}
</div>
