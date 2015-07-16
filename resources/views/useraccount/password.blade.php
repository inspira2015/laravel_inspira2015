<div id = "campos2">
	<p id = "correo" class=""> Email: {{ $user->details->email }}</p>
	<p id = "contrasena" class="">{{ Lang::get('userdata.password') }}: *********</p>
</div>
<a id= "cambiar2" data-role="change" data-route="useraccount/edit-password"><img src="images/cambiar.png"/></a>