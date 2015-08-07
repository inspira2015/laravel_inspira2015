<div style="display: table;height:100%;width:100%;background-color:#e5e7e9;font-size:20px;color:#465664;font-family: 'LondonBetween', Calibri;">
	<div style="background-color:#465664;display: table-row;text-align: center;">
    <a href="{{ url() }}">
		<img  src="https://inspiramexico.mx/mailcontent/email-confirm-header.png" style="width:100%; height:auto;" />
    </a>
	</div>
	<div style="display: table-row;text-align: center;">
		<div style="font-size: 26px; vertical-align:top;width:100%;text-align:center;padding-top:40px;">
			<div style="vertical-align:top;"><img src="http://www.bettercloud.com/wp-content/uploads/reset-passwords-grey1.png" style="width:50px;height:50px;">
				{{ Lang::get('emails.reset-password') }}
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
		<div style="display: table;text-align:center;width:100%;color:white;font-size:18px;"> 
			<div style="display: table-cell;padding-top:10px;padding-bottom:10px;"></div>
		</div>
	</div>
</div>