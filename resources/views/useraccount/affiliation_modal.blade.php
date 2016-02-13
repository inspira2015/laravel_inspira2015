<div class="flat-windows">
	<div class="modal fade" id="change-affiliation" tabindex="-1" role="dialog" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					<div class="modal-wrapper">
						<div class="row text-center">
							<div class="col-xs-12">
								{{ Lang::get('userdata.change-affiliation') }}
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-6 col-md-4 text-left">
							<a href="#" class="btn btn-blue-clear btn-medium back" data-dismiss="modal">
								{{ Lang::get('userdata.cancel') }}
							</a>
						</div>
						<div class="col-xs-6 col-md-4 col-md-push-4">
							<a class="btn-light-blue btn-small" href="{{ url('affiliation/update', ['affiliation' => $userAffiliation->id]) }}">{{ Lang::get('userdata.change') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>