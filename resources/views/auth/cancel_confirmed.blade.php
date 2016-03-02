@extends('layouts.basic', array('title' => Lang::get('auth.cancel-account-title'), 'background' => '2.jpg' ))

@section('content')

<div class="row">
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 col-md-8 col-md-push-2 bg-gray">	
		<div class="row">
			<i class="fa fa-user"></i>
		</div>
		<div class="row">
			<p class="account_conf">
				{{ Lang::get('auth.cancel-confirmed') }}
			</p>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<a href="{{ url('useraccount') }}" class="btn-light-blue btn-medium">
					{{ Lang::get('layout.continue') }}
				</a>
			</div>
		</div>
	</div>
</div>
@stop
  