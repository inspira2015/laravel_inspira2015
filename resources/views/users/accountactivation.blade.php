@extends('layouts.basic')

@section('content')

<div class="row">
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 col-md-8 col-md-push-2 bg-gray">	
		<div class="row">
			<i class="fa fa-user"></i>
			<p><?php echo $full_name; ?></p>
		</div>
		<div class="row">
			<p>{{ Lang::get('activation.welcome.email-confirmed') }}</p>
		</div>
		
		<div class="row">
			<p class="account_conf">
				{{ Lang::get('activation.welcome.message') }}
			</p>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<a href="{{ url('useraccount') }}" class="btn-light-blue btn-medium">
					{{ Lang::get('auth.sign-in') }}
				</a>
			</div>
		</div>
	</div>
</div>
@stop
  