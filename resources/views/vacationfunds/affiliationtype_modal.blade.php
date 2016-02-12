<div class="modal-wrapper">
	<div class="text-center" id="text">
		{{ Lang::get('vacationfund.affmessage') }}
	</div>
</div>
<hr>
<div class="row">
	<div class="col-xs-6 col-md-4">
		<a href="{{ url('affiliation') }}" class="btn-light-blue btn-small">
			{{ Lang::get('vacationfund.change-affiliation') }}
		</a>
	</div>
	<div class="col-xs-6 col-md-4 col-md-push-4">
		{!! Form::open(array('url' => 'vacationfund/add')) !!}

		<div class="btn-blue-clear btn-small underline" data-route="{{ url('vacationfund/add') }}" data-role="submit">
			{{ Lang::get('vacationfund.continue-without-fund') }}
		</div>
		{!! Form::hidden('currency', Session::get('users.currency') ) !!}
		{!! Form::hidden('fondo', '0') !!}
		{!! Form::close() !!}
	</div>
</div>
