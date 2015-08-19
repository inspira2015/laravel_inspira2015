<div class="col-xs-12 form-data">
	<div class="row">
		<strong>Email</strong>: {{ $user->details->email }}
	</div>
	<div class="row">
		<strong>{{ Lang::get('userdata.password') }}</strong>: *********
	</div>
</div>

<div class="col-xs-4 col-xs-push-8 text-center">
	<a data-role="change" data-route="useraccount/edit-password" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
</div>
