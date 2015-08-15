@extends('layouts.basic', array('title' => Lang::get('auth.login') ) )

@section('content')   

<div class="row" data-role="response">    
    <div class="col-md-8 col-md-offset-2 bg-gray">
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
					<label class="col-md-4 control-label">E-mail</label>
					<div class="col-md-6">
						<input type="email" class="form-control" name="email" value="{{ old('email') }}">
					</div>
				</div>
	
				<div class="form-group">
					<label class="col-md-4 control-label">{{ Lang::get('auth.password') }}</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="password">
					</div>
				</div>
	
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4 nopadding">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remember">{{ Lang::get('auth.remember-me') }}
							</label>
						</div>
					</div>
				</div>
				<div class="divider"></div>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="row">
							<button type="submit" class="btn-blue btn-medium">
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