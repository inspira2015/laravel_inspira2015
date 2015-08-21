@extends('layouts.basic', array('title' => Lang::get('auth.login') ) )

@section('content')   

<div class="row" data-role="response">    
    <div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 bg-gray">
	    <div class="row">
		    <h2>{{ Lang::get('auth.login') }}</h2>
	    </div>
	    
	    <div class="row">
		    <div class="divider"></div>
	    </div>
	    
	    <div class="row">
	    	<div class="col-md-10 col-md-push-1">
				@include('errors.messages')
			</div>
		</div>
	    <div class="row">
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
				<div class="form-group">
					<label for="email">E-mail</label>
					<div class="input-group">
						<input type="email" class="form-control" name="email" value="{{ old('email') }}">
					</div>
				</div>
	
				<div class="form-group">
					<label for="password">{{ Lang::get('auth.password') }}</label>
					<div class="input-group">
						<input type="password" class="form-control" name="password">
					</div>
				</div>
	
				<div class="form-group">
					<div class="col-xs-8 col-xs-push-4 col-md-6 nopadding">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remember">{{ Lang::get('auth.remember-me') }}
							</label>
						</div>
					</div>
				</div>
				<div class="divider"></div>
				<div class="row">
					<div class="col-xs-4 col-xs-offset-4">
						<div class="row">
							<button type="submit" class="btn-light-blue btn-medium">
								{{ Lang::get('auth.login') }}
							</button>
						</div>
						<div class="row">
							<a class="btn btn-link" href="{{ url('/password/email') }}">
								{{ Lang::get('auth.forgot-password') }}
							</a>
						</div>
					</div>
					
				</div>
			</form>
	    </div>
    </div>
</div>
@endsection