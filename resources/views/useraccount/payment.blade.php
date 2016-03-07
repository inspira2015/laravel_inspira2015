{!! Form::open(array('url' => url('payment/bonus') , 'class' => 'form-data' )) !!}

<div class="row less-margin" id="bonus">
	<div class="col-xs-5 col-xs-push-1 col-sm-4 col-sm-push-2">
		{{ Lang::get('userdata.payment-type.store') }}<br>
		<input type="radio" name="type" value="1"/>
	</div>
	<div class="col-xs-5 col-xs-push-1 col-sm-4 col-sm-push-2">
		{{ Lang::get('userdata.payment-type.online') }}<br>
		<input type="radio" name="type" value="2"/>
	</div>
</div>
<div class="row margin-top">
	<div class="col-xs-6 col-sm-8 text-center">
		<img src="images/markets.png">
	</div>
	<div class="col-xs-6 col-sm-4 text-center">
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


@if(@$success)
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-success" role="alert">
			{{ $success }}
		</div>
	</div>
</div>	
@endif