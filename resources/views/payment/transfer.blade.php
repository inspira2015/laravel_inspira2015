{!! Form::open(array('url' => url('payment/bonus') , 'class' => 'form-data' )) !!}

<div class="row less-margin">	
	<div class="col-xs-12">
		<div class="form-group">
			
			<label for="cell">{{  Lang::get('userdata.payment-type.store') }}:</label>
			<div class="input-group">
				{!! Form::select('payment_on', Config::get('extra.stores'), null, array('class' => 'form-control') ) !!}
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group" style="line-height: 2;">
			<label for="amount">{{ Lang::get('userdata.amount') }}:   $</label>
			<div class="input-group">
				<input type="text" name="amount" class="form-control">{{ $user->currency }}
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-4 col-sm-push-8 text-center nopadding">
				<div data-role="submit" data-route="useraccount/update-payment" class="btn-blue btn-small">{{ Lang::get('userdata.pay') }}</div>
			</div>
		</div>
	
		<input type="hidden" name="currency" value="{{ $user->currency }}">

	</div>
</div>


<div class="row margin-top">
	<div class="col-xs-4 col-sm-8 text-center ">
		<img src="images/markets.png">
	</div>
	<div class="col-xs-8 col-sm-4 text-center">
		<a class="btn-blue-clear btn-small underline">{{ Lang::get('userdata.more-info') }}</a>
	</div>
</div>
{!! Form::close() !!}


<div class="row">
@include('errors.messages')
</div>
	
@if(@$receipt)
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 text-center">
			<a href="{{ $receipt }}" class="btn-light-blue btn-small" target="_blank">{{ Lang::get('userdata.view-receipt') }}</a>
		</div>
	</div>
@endif