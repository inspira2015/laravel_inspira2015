<div class="modal-wrapper">
	<div class="text-center" id="text">
		{{ Lang::get('vacationfund.affmessage') }}
	</div>
</div>
<hr>
<div class="row">
	<div class="col-xs-6 ">
		<a href="{{ url('affiliation/update/'.$affiliation_id) }}" class="btn-light-blue btn-small">
			{{ Lang::get('vacationfund.change-affiliation') }}
		</a>
	</div>
	<div class="col-xs-6 ">
		{!! Form::open(array('url' => 'vacationfund/modify')) !!}

		<div class="btn-blue-clear btn-small underline" data-route="{{ url('vacationfund/modify') }}" data-role="submit">
			{{ Lang::get('vacationfund.continue-without-fund') }}
		</div>
		{!! Form::hidden('currency', Session::get('users.currency') ) !!}
		{!! Form::hidden('fondo', '0') !!}
		{!! Form::close() !!}
	</div>
</div>
