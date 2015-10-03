<div style="display: table;height:100%;width:100%;background-color:#A4CE3A;font-size:20px;color:#465664;font-family: 'LondonBetween', Calibri;">
	<div style="display: table-row;text-align: center;">
		@if( $user->language == 'es' )
		<img  src="https://inspiramexico.mx/mailcontent/bg-welcome-inspira.png" style="width:100%; height:auto;" />
		@else
		<img  src="https://inspiramexico.mx/mailcontent/bg-welcome-inspira-eng.png" style="width:100%; height:auto;" />
		@endif
	</div>
	<div style="background-color:#465664;display: table-row;text-align: center;">
		<div style="display: table;text-align:center;width:100%;color:white;font-size:16px;"> 
			<div style="display: table-cell;width:30%;text-align:left;">
				<img src="https://inspiramexico.mx/mailcontent/bg-colorful-left.png" style="height:275px;width:100%;max-width:170px;float:left;" >
			</div>
			<div style="display: table-cell;width:40%;vertical-align:top;padding-top:40px;">
				<div style="padding-top: 18px; padding-bottom:20px; font-size:16px; line-height: 25px;padding-bottom:20px">
					@if( $user->language == 'en' )
						Hi {{ $user->name }}!<br>
						Unfortunately, we are unable to process your order because the transaction on your credit card was declined.<br>
						We invite you to come over and change your credit card information, so we can process your order immediately.<br>
						
						Sincerely,<br>
						InspiraMexico Team.
					@else
						Hola {{ $user->name }}!<br>
						Desafortunadamente, no podemos procesar su orden porque la transacción de su tarjeta ha sido rechazada. <br>
						Te invitamos a que vengas y cambies tu información de pago, para que podamos procesar su pedido de inmediato.<br>
						
						Sinceramente,<br>
						El equipo de InspiraMexico.
					@endif
					<br><br>
					<a href="http://InspiraMexico.mx" style="color:white;text-decoration:none;">http://InspiraMexico.mx</a>
				</div>
			</div>
			<div style="display: table-cell;width:30%;text-align:right;">
				<img src="https://inspiramexico.mx/mailcontent/bg-colorful-right.png" style="height:275px;width:100%;max-width:170px;float:right;" >
			</div>
		</div>
	</div>
</div>