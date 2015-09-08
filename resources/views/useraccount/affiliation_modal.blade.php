<div class="modal fade" id="change-affiliation" tabindex="-1" role="dialog" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body">
				<div class="row text-center">
					<div class="col-xs-12">
						{{ Lang::get('userdata.change-affiliation') }}
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-4 col-md-3 nopadding text-left">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('userdata.cancel') }}</button>
					</div>
					<div class="col-xs-4 col-xs-push-4 col-md-3 col-md-push-6 nopadding">
						<a class="btn btn-blue btn-small" href="{{ url('affiliation/update', ['affiliation' => $userAffiliation->id]) }}">{{ Lang::get('userdata.change') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>