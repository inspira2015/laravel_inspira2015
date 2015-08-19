<div class="col-xs-7">
	<strong>{{ Lang::get('userdata.language') }}</strong>: &nbsp; {{ Str::upper($user->details->language) }}
</div>
<div class="col-sm-4 col-sm-push-8 text-center">
	<a data-role="change" data-route="api/user/change-language" class="btn-blue btn-small">
		{{ Lang::get('userdata.change') }}
	</a>
</div>