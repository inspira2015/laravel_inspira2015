<div class="header">
	<div class="col-md-10 col-md-offset-1 nopadding">
	    <div class="navbar-header text-center">
		    @if(Auth::check())
<!--
		        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span> 
			        <span class="icon-bar"></span> 
					{!! HTML::image('images/hamburguer.png', 'Navigation', array('style' => 'margin-top:-10px')) !!}
		        </button> 
-->
	        @endif
	        <div class="logo">
				<a href="http://{{ url(Config::get('domain.front')) }}">
					{!! HTML::image('css/bootstrap/css/images/logo.png', 'Inspira Mexico - Logo') !!}
				</a>
	        </div>
	    </div>
	    @if(Auth::check())
<!--
	    <nav id="bs-navbar" class="collapse navbar-collapse">
	        <ul class="nav navbar-nav navbar-right">
	            <li>
	            	<a href="{{ url('auth/logout') }} " style="color:white;display:block;vertical-align: middle;">Logout <i class="glyphicon glyphicon-log-out"></i></a>
	            </li>
	        </ul>
	    </nav>
-->
		@endif
	</div>
</div>