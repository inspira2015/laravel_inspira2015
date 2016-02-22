<div style="display: table;height:100%;width:100%;background-color:#e5e7e9;font-size:20px;color:#465664;font-family: 'LondonBetween', Calibri;">
	<div style="display: table-row;text-align: center;">
	@if(Lang::getLocale() == 'es')
    <a href="{{ url() }}">
		<img  src="https://inspiramexico.mx/mailcontent/RecoverPass_Espanol.jpg" style="width:100%; height:auto;" />
    </a>
    @else
    <a href="{{ url() }}/en">
		<img  src="https://inspiramexico.mx/mailcontent/RecoverPass_English.jpg" style="width:100%; height:auto;" />
    </a>    @endif
	</div>
	<div style="display: table-row;text-align: center;">
		<div style="font-size: 26px; vertical-align:top;width:100%;text-align:center;padding-top:20px;">
			<div style="vertical-align:top;"><img src="https://inspiramexico.mx/mailcontent/secure-lock.png" style="width:50px;height:50px;">
			</div>
		</div>	
		<div style="font-size: 20px; padding-right:20px; padding-left:20px;">
			{{ Lang::get('emails.password-message') }}			
		</div>
		<div style="margin-top:20px;margin-bottom:20px;padding-bottom:40px;padding-top:20px;">
			<a href="{{ url('password/reset/'.$token) }}" style="padding: 10px 35px 10px 40px; background-color: #4D9AD4; color:white; text-decoration: none;font-size:22px;">
				{{ Lang::get('emails.reset-password') }}			 
				<img src="https://inspiramexico.mx/mailcontent/arrow.png" style="margin-left: 10px;width: 9px;height:13px;">
			</a>
		</div>	
	</div>
	<div style="background-color:#465664;display: table-row;text-align: center;">
        <div style="display: table;text-align:center;width:100%;color:white;font-size:16px;"> 
            <div style="display: table-cell;width:10%;text-align:left;">
                <img src="https://inspiramexico.mx/mailcontent/bg-colorful-left.png" style="height:auto;width:100%;max-width:65px;float:left;" >
            </div>
            <div style="display: table-cell;width:70%;vertical-align:top;">
                <div style="font-size:12px; line-height: 25px;padding:30px 0;">
                    <div style="display:table;width:100%;">
                        <div style="display:table-row">
                            <div style="display:table-cell;width:50%;text-align: left;">
                            {{ Lang::get('layout.copyright') }}
                            </div>
                            <div style="display:table-cell;width:30%;text-align: left;padding-left:10px;">
	                        @if(Lang::getLocale() == 'es')
                            &middot; (55) 8526-1061 ext 1007<br>
                            &middot; <a href="http://InspiraMexico.mx" style="color:white!important;text-decoration:none!important;">InspiraMexico.mx</a>
                            @else
                            &middot; (55) 1.855.INSPIRA<br>
							&middot; <a href="http://InspiraMexico.mx/en" style="color:white!important;text-decoration:none!important;">InspiraMexico.mx/en</a>

                            @endif
                            </div>
                            <div style="display:table-cell;width:20%;text-align: right;border-left:1px solid white;">
                               {{ Lang::get('layout.follow-us') }}: <a href="https://www.facebook.com/inspiramexico.mx" target="_blank"><img src="http://inspiramexico.mx/mailcontent/booking/facebook-icon.png" style="vertical-align: middle;margin-left: 10px;width: 30px;"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: table-cell;width:10%;text-align:right;">
                <img src="https://inspiramexico.mx/mailcontent/bg-colorful-right.png" style="height:auto;width:100%;max-width:60px;float:right;" >
            </div>
        </div>
    </div>
</div>