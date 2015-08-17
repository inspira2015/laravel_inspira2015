@extends('layouts.basic')

@section('content')

<div class="row">
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 col-md-8 col-md-push-2 bg-gray">	
		<div class="row">
			<p class="account_conf">{{ Lang::get('activation.error.ready') }}</p>
		</div>	
		<div class="row">
			{{ Lang::get('activation.error.contact') }}
		</div>	
		<div class="row">
			<div class="divider"></div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<a href="mailto:{{ Config::get('extra.email.support') }}" class="btn-blue-clear btn-extrasmall">{{ Lang::get('activation.error.support') }}</a>
			</div>
			<div class="col-md-4 col-md-push-4">
				<a href="{{ url('password/email') }}" class="btn-blue btn-extrasmall">
					{{ Lang::get('activation.error.reset-password') }}
				</a>
			</div>
		</div>	
	</div>
</div>
@stop
  