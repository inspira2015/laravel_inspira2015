<div class="col-xs-8">
	<img src="images/bonus-logos.png">
</div>
<div class="col-xs-4 text-center">
	<a data-role="change" data-route="useraccount/edit-payment" class="btn-blue btn-small">{{ Lang::get('userdata.pay') }}</a>
</div>

<div class="col-xs-12">
@include('errors.messages')
</div>
	
@if(@$receipt)
<div class="col-xs-10 col-xs-offset-1 text-center">
	<br>
	<a href="{{ $receipt }}" class="btn-light-blue btn-small" target="_blank">{{ Lang::get('userdata.view-receipt') }}</a>
</div>
@endif