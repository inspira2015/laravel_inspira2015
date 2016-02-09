{!! Form::open(array('url' => 'useraccount/update-payment' , 'class' => 'form-data' )) !!}
	<div class="form-group" style="line-height: 2;">
		<label for="amount">{{ Lang::get('userdata.amount') }}:   $</label>
		<div class="input-group">
			<input type="text" name="amount" class="form-control">{{ $user->currency }}
		</div>
	</div>
	<div class="form-group">
	@include('errors.messages')
	</div>
	<div class="form-group">
		<div class="col-xs-4 col-xs-push-8 text-center nopadding">
			<div data-role="submit" data-route="useraccount/update-payment" class="btn-blue btn-small">{{ Lang::get('userdata.save') }}</div>
		</div>
	</div>
	<input type="hidden" name="currency" value="{{ $user->currency }}">
{!! Form::close() !!}
