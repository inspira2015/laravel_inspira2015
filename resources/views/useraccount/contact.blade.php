<div id = "campos">
	<input type = "hidden" id = "leisure" value ="<?php //echo $user_data['leisure_id'] ?>">
	<input type = "hidden" id = "afiliacion" name="afiliacion" value ="<?php //echo $afiliacion['tier_id'] ?>">
	<p id = "cel" class="">{{ Lang::get('userdata.cell') }}: {{ $user->phones->cellphone['number'] }}</p>
	<p id = "hmt" class="">{{ Lang::get('userdata.phone') }}: {{ $user->phones->phone['number'] }}</p>
	<p id = "wkt" class="">{{ Lang::get('userdata.office') }}: {{ $user->phones->office['number'] }}</p>
	<p id = "address" class="">{{ Lang::get('userdata.address') }}: {{ $user->address['address'] }}</p>

	<p id = "city" class="">{{ Lang::get('userdata.city') }}: {{ $user->address['city'] }}</p>

	<p id = "country" class="">{{ Lang::get('userdata.country') }}: {{ $user->details->country }}</p>

	<p id = "state" class="">{{ Lang::get('userdata.state') }}: {{ $user->details->state }} </p>
</div>
<a id ="cambiar" data-role="change" data-route="useraccount/edit-contact"> <img src="images/cambiar.png"/></a>
