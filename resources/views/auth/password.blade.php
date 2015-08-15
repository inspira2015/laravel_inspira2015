@extends('layouts.basic', array('title' => Lang::get('auth.reset-password'), 'background' => '2.jpg' ) )

@section('content')   

<div class="row" data-role="response">    
    <div class="col-md-8 col-md-offset-2 bg-gray">	    
	    <div class="row">
	    	<div class="col-md-10 col-md-push-1">
		    	@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
				
				@include('errors.messages')
			</div>
		</div>
	    <div class="row">
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label for="email" >E-Mail</label>
					<div class="input-group">
						<input type="email"  class="form-control" name="email" value="{{ old('email') }}">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-5 col-md-offset-3 col-md-push-1">
						<div class="row">
							<br>
							<button type="submit" class="btn-light-blue btn-medium">
								{{ Lang::get('auth.reset-password') }}
							</button>
						</div>
					</div>
				</div>
			</form>
	    </div>
    </div>
</div>
@endsection