<p style="display:inline-block; width:40%;">
	{{ Lang::get('userdata.language') }}: &nbsp; {{ Str::upper($user->details->language) }}
</p> 
<a style="color:#cc4b9b;" data-role="change" data-route="api/user/change-language"> 
	@if( $user->details->language == 'es' )
		<img src="images/cambiar.png" style="vertical-align:text-top;"/>
	@else
		<img src="images/cambiarENG.png" style="vertical-align:text-top;"/>
	@endif
</a>
