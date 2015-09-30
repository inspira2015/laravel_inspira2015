{!! Form::open(array('url' => 'useraccount/update-payment' , 'class' => 'form-data' )) !!}
<div class="row">
	<div class="col-xs-8">
		<div class="row text-center">
			<img src="images/markets.png">
		</div>
	</div>
	<div class="col-xs-4 text-center">
		<div class="row">
			<a data-role="change" data-route="useraccount/edit-payment" class="btn-blue btn-small">
				{{ Lang::get('userdata.pay') }}
			</a>
		</div>
	</div>
</div>
<div class="row margin-top">
	<div class="col-xs-8 text-center">

	</div>
	<div class="col-xs-4 text-center">
		<a class="btn-blue-clear btn-small underline">M&aacute;s Info</a>
	</div>
</div>
{!! Form::close() !!}


<div class="col-xs-12">
@include('errors.messages')
</div>
	
@if(@$receipt)
<div class="col-xs-10 col-xs-offset-1 text-center">
	<br>
	<a href="{{ $receipt }}" class="btn-light-blue btn-small" target="_blank">{{ Lang::get('userdata.view-receipt') }}</a>
</div>
@endif

<style>
	.underline {
		text-decoration: underline;
	}
	.less-margin {
		margin-top: -15px;
	}
	.margin-top {
		margin-top: 15px;
	}
</style>
