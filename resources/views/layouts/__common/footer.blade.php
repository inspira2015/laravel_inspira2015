<footer>
	<div class="container">
		<div class="col-md-5">
			{!! HTML::image('images/copyright.png', 'Mexico') !!}
			&nbsp; {{ Lang::get('layout.copyright') }}
		</div>
		<div class="hidden-xs hidden-sm col-md-2">
			<a href="#"  data-toggle="modal" data-target="#privacy" >
			{{ Lang::get('layout.privacy-policy') }} 
			</a>
		</div>
		<div class="hidden-xs hidden-sm col-md-3">
			M&eacute;xico : 55.8526.1061 <br/>
			US Toll Free: 1.855.INSPIRA
		</div>
		
		<div class="hidden-xs hidden-sm col-md-2" id="fb">
			<p> {{ Lang::get('layout.follow-us') }}:</p>
			<p>
				<a href="https://www.facebook.com/inspiramexico.mx" target="_blank">{!! HTML::image('images/logofacebook.png', 'facebook logo') !!}</a>
			</p>
		</div>
	</div>
</footer>