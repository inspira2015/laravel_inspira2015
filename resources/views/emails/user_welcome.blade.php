<div style="display: table;height:100%;width:100%;background-color:#e5e7e9;font-size:20px;color:#465664;font-family: 'LondonBetween', Calibri;">
	<div style="background-color:#465664;display: table-row;text-align: center;">
		<img  src="https://inspiramexico.mx/mailcontent/email-confirm-header.png" style="width:100%; height:auto;" />
	</div>
	<div style="display: table-row;text-align: center;">
		<div style="padding: 40px 20px 0px 20px;text-transform: uppercase;font-size: 26px; vertical-align:top;"><img src="https://inspiramexico.mx/mailcontent/email-usericon.png" style="display:inline-block;margin-right: 15px;">
			{{ $user->name .' '. $user->last_name }}
		</div>
		<div style="padding: 10px 20px 20px 20px;">
			{{ Lang::get('emails.welcome') }}
		</div>
		<div style="padding: 20px 20px 30px 20px;">			
			<a href="{{ url('auth/login') }}" style="padding: 10px 35px 10px 40px; background-color: #4D9AD4; color:white; text-decoration: none;"> {{ Lang::get('emails.login') }}			 <img src="https://inspiramexico.mx/mailcontent/arrow.png" style="margin-left: 10px;width: 9px;height:13px;"></a>
			
		</div>
		<div style="padding: 0 10%;">
			<hr style="border: 0;height: 0;border-bottom: 1px solid #465664">
		</div>
		<div style="display: table;text-align:center;width:100%;"> 
			<div style="display: table-cell;text-align:center;padding-bottom: 40px;padding-left: 20px;padding-top:20px;">
				&nbsp;
			</div>
			<div style="display: table-cell;text-align:center; padding-bottom: 40px;">
				<a href="{{ url() }}/useraccount" style="color: #465664; text-decoration: none;">{{ Lang::get('emails.modify-data') }}</a>
			</div>
			<div style="display:table-cell;width:15px;padding-left:5px;padding-right:5px;">|</div>
			<div style="display: table-cell;text-align:center; padding-bottom: 40px;">
				<a href="#" style="color: #465664; text-decoration: none;">{{ Lang::get('emails.help') }}</a>
			</div>
			<div style="display:table-cell;width:15px;padding-left:5px;padding-right:5px;">|</div>
			<div style="display: table-cell;text-align:center; padding-bottom: 40px;">
				<a href="#" style="color: #465664; text-decoration: none;">{{ Lang::get('emails.cancel') }}</a>
			</div>
			<div style="display:table-cell;width:15px;padding-left:5px;padding-right:5px;">|</div>
			<div style="display: table-cell;text-align:center;padding-bottom: 40px;">
				<a href="#" style="color: #465664; text-decoration: none;">{{ Lang::get('emails.not-mine') }}</a>
			</div>
			<div style="display: table-cell;text-align:center;padding-bottom: 40px;padding-right: 20px;">
				&nbsp;
			</div>
		</div>
	</div>
	<div style="background-color:#465664;display: table-row;text-align: center;">
		<div style="display: table;text-align:center;width:100%;color:white;font-size:18px;"> 
			<div style="display: table-cell;padding-top:30px;padding-bottom:30px;">
				<a href="//inspiramexico.mx" style="color: white; text-decoration: none;padding-right: 10px;">InspiraMexico.mx</a>
			</div>
			<div style="display: table-cell;padding-top:30px;padding-bottom:30px;">
				<a href="mailto:Info@inspiramexico.mx?Subject=Info" target="_top" style="color: white; text-decoration: none;padding-right: 10px;">Info@inspiramexico.mx</a>
			</div>
			<div style="display: table-cell;padding-top:30px;padding-bottom:30px;">55.8526.1061 ext. 1007</div>
		</div>
	</div>
</div>