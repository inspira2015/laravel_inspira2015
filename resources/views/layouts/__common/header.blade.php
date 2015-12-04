<div class="header">
	<div class="container">
		<div class="col-xs-10">
	  		<div class="logo">
	  			<a href="{{ url('/') }}">
	  				{!! HTML::image('css/bootstrap/css/images/logo.png', 'Inspira Mexico - Logo') !!}
	  			</a>
	  		</div>
		</div>
		@if(Auth::check())
		<div class="col-xs-2">				
			<div class="row text-right">
				<a href="{{ url('auth/logout') }} " style="color:#818c95;display:block;line-height: 60px;vertical-align: middle;">Logout <i class="glyphicon glyphicon-log-out"></i></a>
			</div>			
		</div>
		@endif
	</div>
</div>