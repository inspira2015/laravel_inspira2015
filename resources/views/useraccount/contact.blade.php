<div class="col-xs-12 form-data">
	<div class="row">
		<strong>{{ Lang::get('userdata.cell') }}</strong>: {{ $user->phones->cell['number'] }}
	</div>
	<div class="row">
		<strong>{{ Lang::get('userdata.phone') }}</strong>: {{ $user->phones->phone['number'] }}
	</div>
	<div class="row">
		<strong>{{ Lang::get('userdata.office') }}</strong>: {{ $user->phones->office['number'] }}
	</div>
	<div class="row">
		<strong>{{ Lang::get('userdata.address') }}</strong>: {{ $user->details->address }}
	</div>
	<div class="row">
		<strong>{{ Lang::get('userdata.city') }}</strong>: {{ $user->details->city }}
	</div>
	<div class="row">
		<strong>{{ Lang::get('userdata.country') }}</strong>: {{ $user->details->country }}
	</div>
	<div class="row">
		<strong>{{ Lang::get('userdata.state') }}</strong>: {{ $user->details->state }} </p>
	</div>
</div>

<div class="col-xs-4 col-xs-push-8 text-center">
	<a data-role="change" data-route="useraccount/edit-contact" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
</div>
