<footer style="margin-top:100px;">
	<div class="container" style="color:#fff; font-size:11px; padding:0 !important;">
		<div class="section-1">
			{!! HTML::image('/images/copyright.png', 'Inspira Mexico - Copyright') !!}
			&nbsp; {{ Lang::get('layout.copyright') }}
		</div>
		<div class="section-2">
			<a href="http://inspiramexico.mx/terminos-y-condiciones/"  onclick="window.open(this.href, 'mywin',
			'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" style="color:#fff;">
			{{ Lang::get('layout.privacy-policy') }}
			</a>
		</div>
		<div class="section-3">
			M&eacute;xico : 55.8526.1061<br>
			US Toll Free: 1.855.INSPIRA
		</div>
		<div class="section-4" style="display:inline-block;">
			<p style="display:inline-block; width:65%; padding-right:10px; vertical-align:middle;">
			{{ Lang::get('layout.follow-us') }}
			</p>
			<p style="display:inline-block; width:30%; vertical-align:top;">			
			{!! HTML::image('/images/logofacebook.png', 'Inspira Mexico - Copyright', array('style'=> 'display:inline-block; width:100%; height:auto; vertical-align:top;')) !!}
			</p>
		</div>
	</div>
</footer>
