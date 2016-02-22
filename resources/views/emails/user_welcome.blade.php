<div style="display: table;height:100%;width:100%;background-color:#A4CE3A;font-size:20px;color:#465664;font-family: 'LondonBetween', Calibri;">
	<div style="display: table-row;text-align: center;">
		@if(Lang::locale() == 'es')
		<img  src="https://inspiramexico.mx/mailcontent/bg-welcome-inspira.png" style="width:100%; height:auto;" />
		@else
		<img  src="https://inspiramexico.mx/mailcontent/bg-welcome-inspira-eng.png" style="width:100%; height:auto;" />
		@endif
	</div>
	<div style="display: table-row;text-align: center;">
		<div style="padding: 40px 40px 40px 40px; color:white; font-size: 24px;">
			{{ Lang::get('emails.welcome.message') }}

			<div style="color:#465664; font-size: 26px;text-transform:uppercase; padding-top: 30px;line-height: 1.5;">
				{{ Lang::get('emails.welcome.you-worth') }}<br>
				<span style="color:white;font-size:22px;">{{ Lang::get('emails.welcome.we-are') }}</span></div>
		</div>
	</div>
	<div style="background-color:#465664;display: table-row;text-align: center;">
		<div style="display: table;text-align:center;width:100%;color:white;font-size:16px;"> 
			<div style="display: table-cell;width:30%;text-align:left;">
				<img src="https://inspiramexico.mx/mailcontent/bg-colorful-left.png" style="height:275px;width:100%;max-width:170px;float:left;" >
			</div>
			<div style="display: table-cell;width:40%;vertical-align:top;padding-top:40px;">
				<div style="padding-top: 20px; padding-bottom:20px; font-size:16px; line-height: 25px;padding-bottom:20px">
				<div style="font-size: 22px;">{{ Lang::get('emails.welcome.affiliation-info-is') }}</div>
					E-mail: {{ $user->email }}<br>
					{{ Lang::get('emails.password') }}: {{ $user->password }}<br><br>
					{{ Lang::get('emails.welcome.login') }}:<br>

					@if(Lang::getLocale() == 'es')
					<a href="http://InspiraMexico.mx" style="color:white;text-decoration:none;">http://InspiraMexico.mx</a>
					@else
					<a href="http://InspiraMexico.mx/en" style="color:white;text-decoration:none;">http://InspiraMexico.mx/en</a>
					@endif
				</div>
			</div>
			<div style="display: table-cell;width:30%;text-align:right;">
				<img src="https://inspiramexico.mx/mailcontent/bg-colorful-right.png" style="height:275px;width:100%;max-width:170px;float:right;" >
			</div>
		</div>
	</div>
</div>