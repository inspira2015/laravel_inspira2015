<footer>
	<div class="container">
		<div class="col-md-5">
			{!! HTML::image('images/copyright.png', 'Mexico') !!}
			&nbsp; {{ Lang::get('layout.copyright') }}
		</div>
		<div class="hidden-xs hidden-sm col-md-2">
			<a href="/terms"  onclick="window.open(this.href, 'mywin',
			'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
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
				{!! HTML::image('images/logofacebook.png', 'facebook logo') !!}
			</p>
		</div>
	</div>
</footer>