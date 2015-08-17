@extends('layouts.basic')

@section('content')
<div class="row">
	<div class="col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3 bg-gray">
		<i class="fa fa-user"></i>
		<p><?php echo $full_name; ?></p>
		<br/>
		<p class="account_conf">{{ Lang::get('emails.confirm-message') }}</p>
	</div>
</div>
@stop
  