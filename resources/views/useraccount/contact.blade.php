<div class="col-xs-12 nopadding">
	<h3>{{ Lang::get('userdata.information') }}
		@if(Session::has('complete-profile'))
		<br>
		<span style="color:#CC4B9B;font-size:12px;">
			{{ Lang::get('userdata.complete-profile') }}
		</span>
		@endif
	</h3>
</div>
<div class="col-xs-12 form-data">
	<div class="row  form-data">
		<strong>{{ Lang::get('userdata.cell') }}</strong>: {{ $user->phones->cell }}
	</div>
	<div class="row form-data">
		<strong>{{ Lang::get('userdata.phone') }}</strong>: {{ $user->phones->phone }}
	</div>
	<div class="row form-data">
		<strong>{{ Lang::get('userdata.office') }}</strong>: {{ $user->phones->office }}
	</div>
	<div class="row form-data">
		<strong>{{ Lang::get('userdata.address') }}</strong>: {{ $user->details->address }}
	</div>
	<div class="row form-data">
		<strong>{{ Lang::get('userdata.city') }}</strong>: {{ $user->details->city }}
	</div>
	<div class="row form-data">
		<strong>{{ Lang::get('userdata.country') }}</strong>: {{ $user->details->country }}
	</div>
	<div class="row form-data">
		<strong>{{ Lang::get('userdata.state') }}</strong>: {{ $user->details->state->name }} </p>
	</div>
</div>

<div class="col-xs-6 col-xs-push-6 col-sm-5 col-sm-push-7 text-center">
	<a data-role="change" data-route="useraccount/edit-contact" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
</div>
