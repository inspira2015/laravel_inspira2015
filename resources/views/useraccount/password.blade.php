<div class="col-xs-12 form-data">
	<div class="row">
		<div class="col-xs-12 form-data nopadding">
			<strong>Email</strong>: {{ $user->details->email }}
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8 form-data nopadding">
			<strong>{{ Lang::get('userdata.password') }}</strong>: *********
		</div>
		<div class="col-xs-4 text-center nopadding">
			<a data-role="change" data-route="useraccount/edit-password" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
		</div>
	</div>
	@if(!$user->details->facebook_id)
	<div class="divider"></div>
	<div class="row">
		<div class="col-xs-8 form-data nopadding">
			<a data-role="change" data-route="useraccount/fbLink" class="fb-linkto">{{ Lang::get('userdata.fb-link') }}</a>
		</div>
		<div class="col-xs-3  col-xs-push-1 form-data nopadding">
			<a data-toggle="modal" data-target="#linktofb" href="#" class="btn-blue-clear btn-small underline">{{ Lang::get('userdata.more-info') }}</a>
		</div>
	</div>
	@endif
	<div class="row">
		<div class="form-group">
		@include('errors.messages')
		</div>
	</div>
</div>

@include('useraccount.linktofb_modal')
